<?php

    namespace App\Http\Controllers;

    use App\Models\alternatif;
    use App\Models\kriteria;
    use App\Models\Product;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;

    class alternatifController extends Controller
    {
        public function index() : View
        {
            $alternatifs = alternatif::with('product')->get();
            return view('User.Alternatif.view', compact('alternatifs'));
        }

        public function create() : View
        {
            $products = Product::all();
            $last = alternatif::orderBy('id', 'desc')->first();
            $newNumber = $last ? (int) substr($last->kode_alternatif, 1) + 1 : 1;
            $kode_alternatif = 'A' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
            return view('User.Alternatif.create', compact('kode_alternatif', 'products'));
        }

        public function store(Request $request) : RedirectResponse
        {
            $request->validate([
                'kode_alternatif' => 'required|unique:alternatifs,kode_alternatif',
                'product_id' => 'required|exists:products,id',
                'performance' => 'required|integer|min:1|max:100',
                'camera' => 'required|integer|min:1|max:100',
                'battery' => 'required|integer|min:1',
                'aftersales' => 'required|integer|min:1|max:10',
            ]);
            alternatif::create($request->all());
            return redirect()->route('Alternatif.index')->with('success', 'Data Berhasil Disimpan!');
        }

        public function edit($id) : View
        {
            $alt = alternatif::findOrFail($id);
            $products = Product::all();
            return view('User.Alternatif.edit', compact('alt', 'products'));
        }

        public function update(Request $request, $id) : RedirectResponse
        {
            $alt = alternatif::findOrFail($id);
            $request->validate([
                'kode_alternatif' => 'required|unique:alternatifs,kode_alternatif,' . $alt->id,
                'product_id' => 'required|exists:products,id',
                'performance' => 'required|integer|min:1|max:100',
                'camera' => 'required|integer|min:1|max:100',
                'battery' => 'required|integer|min:1',
                'aftersales' => 'required|integer|min:1|max:10',
            ]);
            $alt->update($request->all());
            return redirect()->route('Alternatif.index')->with('success', 'Data Berhasil Diupdate!');
        }

        public function view(): View
        {
            $alternatifs = alternatif::with('product')->get();
            return view('User.Alternatif.alt_view', compact('alternatifs'));
        }

        public function destroy($id) : RedirectResponse
        {
            $alt = alternatif::findOrFail($id);
            $alt->delete();
            return redirect()->route('Alternatif.index')->with('success', 'Data Berhasil Dihapus!');
        }

        // ---------------- MOORA ----------------
        public function moora(Request $request): View
        {
            $ids = $request->input('select_alternatif', []);
            $alternatifs = !empty($ids)
                ? Alternatif::with('product')->whereIn('id', $ids)->get()
                : Alternatif::with('product')->get();

            $kriterias = Kriteria::all();

            $mapping = [
                'C01' => 'product.price',
                'C02' => 'performance',
                'C03' => 'camera',
                'C04' => 'battery',
                'C05' => 'product.storage',
                'C06' => 'aftersales',
            ];

            // Matriks keputusan
            $matrix = [];
            foreach ($alternatifs as $alt) {
                foreach ($kriterias as $k) {
                    $field = $mapping[$k->kode_kriteria] ?? null;
                    if ($field) {
                        if (str_starts_with($field, 'product.')) {
                            $col = str_replace('product.', '', $field);
                            $matrix[$alt->id][$k->kode_kriteria] = $alt->product->$col;
                        } else {
                            $matrix[$alt->id][$k->kode_kriteria] = $alt->$field;
                        }
                    }
                }
            }

            // Hitung penyebut normalisasi
            $denominator = [];
            foreach ($kriterias as $k) {
                $sumSquares = 0;
                foreach ($alternatifs as $alt) {
                    $sumSquares += pow($matrix[$alt->id][$k->kode_kriteria], 2);
                }
                $denominator[$k->kode_kriteria] = $sumSquares > 0 ? sqrt($sumSquares) : 0;
            }

            // Normalisasi & Optimasi
            $normalisasi = [];
            $optimasi = [];
            foreach ($alternatifs as $alt) {
                $nilai = 0;
                foreach ($kriterias as $k) {
                    $den = $denominator[$k->kode_kriteria];
                    $r = $den > 0 ? $matrix[$alt->id][$k->kode_kriteria] / $den : 0;
                    $normalisasi[$alt->id][$k->kode_kriteria] = $r;

                    $bobot = (float) $k->bobot;
                    $nilai += strtolower($k->type) === 'benefit' ? $r * $bobot : -($r * $bobot);
                }
                $optimasi[$alt->id] = $nilai;
            }

            arsort($optimasi); // ranking

            // Simpan hasil MOORA di session
            session([
                'moora_matrix' => $matrix,
                'moora_normalisasi' => $normalisasi,
                'moora_optimasi' => $optimasi,
                'moora_alternatifs' => $alternatifs->pluck('id')->toArray(),
            ]);

            return view('User.Alternatif.moora', compact(
                'alternatifs',
                'kriterias',
                'matrix',
                'normalisasi',
                'optimasi'
            ));
        }

        // ---------------- REKOMENDASI ----------------
        public function rekomendasi(Request $request): View|RedirectResponse
    {
        // Ambil hasil MOORA dari session
        $matrix = session('moora_matrix', []);
        $normalisasi = session('moora_normalisasi', []);
        $optimasi = session('moora_optimasi', []);
        $altIds = session('moora_alternatifs', []);

        if (empty($altIds)) {
            // Kalau session kosong, redirect ke MOORA supaya dihitung dulu
            return redirect()->route('alternatif.moora')
                ->with('error', 'Silakan lakukan perhitungan MOORA terlebih dahulu.');
        }

        $alternatifs = Alternatif::with('product')->whereIn('id', $altIds)->get();

        // --- Opsional: hitung ulang MOORA berdasarkan kriteria yang dipilih ---
        $selectedCodes = (array) $request->input('kriteria', []);
        $weightsSelected = [];
        if (!empty($selectedCodes)) {
            $selectedKriterias = Kriteria::whereIn('kode_kriteria', $selectedCodes)->get();

            // Hitung penyebut normalisasi hanya untuk kriteria terpilih
            $denominator = [];
            foreach ($selectedKriterias as $k) {
                $sumSquares = 0;
                foreach ($alternatifs as $alt) {
                    $sumSquares += pow($matrix[$alt->id][$k->kode_kriteria] ?? 0, 2);
                }
                $denominator[$k->kode_kriteria] = $sumSquares > 0 ? sqrt($sumSquares) : 0;
            }

            // Normalisasi & Optimasi untuk kriteria terpilih (gunakan bobot asli TANPA penormalan agar seragam dengan Excel)
            foreach ($selectedKriterias as $k) {
                $weightsSelected[$k->kode_kriteria] = (float) $k->bobot;
            }
            $optimasiRecalc = [];
            $normalisasiSelected = [];

            foreach ($alternatifs as $alt) {
                $nilai = 0;
                foreach ($selectedKriterias as $k) {
                    $kode = $k->kode_kriteria;
                    $den = $denominator[$kode] ?? 0;
                    $r = $den > 0 ? (($matrix[$alt->id][$kode] ?? 0) / $den) : 0;
                    $normalisasiSelected[$alt->id][$kode] = $r;

                    $bobot = (float) $k->bobot;
                    $nilai += strtolower($k->type) === 'benefit' ? $r * $bobot : -($r * $bobot);
                }
                $optimasiRecalc[$alt->id] = $nilai;
            }

            arsort($optimasiRecalc);
            $optimasi = $optimasiRecalc;
            $normalisasi = $normalisasiSelected;
        }

        // Simpan optimasi penuh (sebelum filter) untuk opsi ranking
        $allOptimasi = $optimasi;

        $kriterias = Kriteria::all(); // tetap dibutuhkan untuk looping di view

        // --- Filter berdasarkan ranking ---
        if ($request->filled('rank')) {
            $rank = (int) $request->rank;
            $sortedIds = array_keys($optimasi);
            $idFilter = $sortedIds[$rank - 1] ?? null;

            if ($idFilter) {
                $optimasi = [$idFilter => $optimasi[$idFilter]];
                $alternatifs = $alternatifs->where('id', $idFilter);
            }
        }

        // --- Filter berdasarkan nilai kriteria ---
        if ($request->filled('filter')) {
            foreach ($request->filter as $kode => $min) {
                if ($min !== null && $min !== '') {
                    $alternatifs = $alternatifs->filter(function ($alt) use ($matrix, $kode, $min) {
                        return ($matrix[$alt->id][$kode] ?? 0) >= $min;
                    });

                    // pastikan optimasi hanya untuk alternatif yang lolos filter
                    $optimasi = array_intersect_key($optimasi, $alternatifs->keyBy('id')->toArray());
                }
            }
        }

        return view('User.Alternatif.rekomendasi', compact(
            'alternatifs',
            'matrix',
            'normalisasi',
            'optimasi',
            'kriterias',
            'allOptimasi',
            'selectedCodes',
            'weightsSelected'
        ));
    }


    }