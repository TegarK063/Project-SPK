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
        // get data from model
        $alternatifs = alternatif::with('product')->get();
        // render view
        return view('User.Alternatif.view', compact('alternatifs'));
    }

    public function create() : View
    {
        // get data from model product
        $products = Product::all();
        // Generate kode_alternatif otomatis
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
        // simpan data
        alternatif::create($request->all());
        // redirect to index
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

    public function moora(Request $request): View
    {
        // Ambil alternatif yang dipilih (kalau ada)
        $ids = $request->input('select_alternatif', []);

        if (!empty($ids)) {
            $alternatifs = Alternatif::with('product')->whereIn('id', $ids)->get();
        } else {
            $alternatifs = Alternatif::with('product')->get();
        }

        $kriterias = Kriteria::all();

        // --- Mapping kode_kriteria ke field di tabel
        $mapping = [
            'C01' => 'product.price',
            'C02' => 'performance',
            'C03' => 'camera',
            'C04' => 'battery',
            'C05' => 'product.storage',
            'C06' => 'aftersales',
        ];

        // --- Matriks keputusan
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

        // --- Hitung penyebut normalisasi
        $denominator = [];
        foreach ($kriterias as $k) {
            $sumSquares = 0;
            foreach ($alternatifs as $alt) {
                $sumSquares += pow($matrix[$alt->id][$k->kode_kriteria], 2);
            }
            $denominator[$k->kode_kriteria] = sqrt($sumSquares);
        }

        // --- Normalisasi & Optimasi
        $normalisasi = [];
        $optimasi = [];
        foreach ($alternatifs as $alt) {
            $nilai = 0;
            foreach ($kriterias as $k) {
                $r = $matrix[$alt->id][$k->kode_kriteria] / $denominator[$k->kode_kriteria];
                $normalisasi[$alt->id][$k->kode_kriteria] = $r;

                $bobot = (float) $k->bobot;
                if (strtolower($k->type) === 'benefit') {
                    $nilai += $r * $bobot;
                } else {
                    $nilai -= $r * $bobot;
                }
            }
            $optimasi[$alt->id] = $nilai;
        }

        // --- Ranking
        arsort($optimasi);

        return view('User.Alternatif.moora', compact(
            'alternatifs',
            'kriterias',
            'matrix',
            'normalisasi',
            'optimasi'
        ));
    }

}