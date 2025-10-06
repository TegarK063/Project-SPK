@extends('Layout.app')

@section('title', 'Rekomendasi Produk')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">

    <div class="container-fluid mt-7">
        <div class="rounded-lg p-4 mb-4" style="background: linear-gradient(135deg,#2e7d32,#43a047); color:#fff;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Rekomendasi</h4>
                <span class="badge badge-light" style="font-size:0.9rem;">{{ count($optimasi) }} produk</span>
            </div>
        </div>

        <style>
            /* Card animation & hover effects */
            .product-card {
                position: relative;
                transition: transform 220ms ease, box-shadow 220ms ease;
                border: none;
                border-radius: 16px;
                overflow: hidden;
                background: #fff;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
                min-height: 460px;
            }

            .product-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 16px 36px rgba(0, 0, 0, 0.14);
            }

            .product-img-wrapper {
                position: relative;
                overflow: hidden;
                background: #f7f7f9;
            }

            /* Skeleton shimmer */
            .skeleton {
                position: relative;
                background: #eee;
            }

            .skeleton::after {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.65) 50%, rgba(255, 255, 255, 0) 100%);
                transform: translateX(-100%);
                animation: shimmer 1.4s infinite;
            }

            @keyframes shimmer {
                100% {
                    transform: translateX(100%);
                }
            }

            .product-img-wrapper img {
                transition: transform 300ms ease;
            }

            .product-card:hover .product-img-wrapper img {
                transform: scale(1.04);
            }

            .rank-badge {
                position: absolute;
                top: 10px;
                left: 10px;
                z-index: 2;
                padding: 6px 10px;
                border-radius: 999px;
                font-size: 0.8rem;
                font-weight: 600;
                color: #111827;
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid rgba(0, 0, 0, 0.06);
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            }

            .fade-in {
                opacity: 0;
                transform: translateY(8px);
                animation: card-fade 480ms ease forwards;
            }

            @keyframes card-fade {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .moora-badge {
                position: absolute;
                top: 10px;
                right: 10px;
                z-index: 2;
                padding: 6px 12px;
                border-radius: 999px;
                font-size: 0.85rem;
                font-weight: 700;
                color: #fff;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                box-shadow: 0 8px 18px rgba(0, 0, 0, 0.18);
            }

            .glow-ring::before {
                content: '';
                position: absolute;
                inset: 0;
                padding: 1px;
                border-radius: 18px;
                background: linear-gradient(135deg, rgba(102, 126, 234, 0.45), rgba(118, 75, 162, 0.45));
                -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
                -webkit-mask-composite: xor;
                mask-composite: exclude;
                pointer-events: none;
            }

            .clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .meta-row {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .chip {
                display: inline-block;
                padding: 4px 10px;
                border-radius: 999px;
                background: #f3f4f6;
                color: #111827;
                font-size: 0.85rem;
                font-weight: 600;
            }

            .price-chip {
                display: inline-block;
                padding: 6px 12px;
                border-radius: 10px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: #fff;
                font-weight: 700;
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            }

            .desc-text {
                color: #6b7280;
                font-size: 0.92rem;
            }

            /* Special styling for #1 ranked product card */
            .rank-badge-special {
                animation: pulse-glow 2s infinite;
                box-shadow: 0 0 20px rgba(40, 167, 69, 0.5);
            }

            @keyframes pulse-glow {
                0%, 100% {
                    box-shadow: 0 0 20px rgba(40, 167, 69, 0.5);
                    transform: scale(1);
                }
                50% {
                    box-shadow: 0 0 30px rgba(40, 167, 69, 0.8);
                    transform: scale(1.05);
                }
            }

            .analysis-section {
                background: rgba(255, 255, 255, 0.7);
                border-radius: 12px;
                padding: 15px;
                border: 1px solid rgba(40, 167, 69, 0.2);
            }

            .criteria-item {
                transition: all 0.3s ease;
                border-left: 4px solid transparent;
            }

            .criteria-item:hover {
                transform: translateX(5px);
                border-left-color: #28a745;
            }

            .champion-card {
                position: relative;
                overflow: hidden;
            }

            .champion-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
                animation: shimmer-champion 3s infinite;
            }

            @keyframes shimmer-champion {
                0% { left: -100%; }
                100% { left: 100%; }
            }
        </style>

        {{-- 🔍 Minimal Filter Toggle --}}
        <div class="d-flex justify-content-end mb-3">
            <button type="button" id="btnFilterToggle" class="btn btn-success">Filter</button>
        </div>
        <div class="mb-4 d-none" id="filterPanel">
            <div class="card card-body">
                <form method="GET" action="{{ route('alternatif.rekomendasi') }}">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label d-block">Pilih Kriteria</label>
                            <div class="d-flex flex-wrap">
                                @foreach ($kriterias as $k)
                                    <div class="form-check mr-4 mb-2">
                                        <input class="form-check-input" type="checkbox" name="kriteria[]"
                                            id="ck_{{ $k->kode_kriteria }}" value="{{ $k->kode_kriteria }}"
                                            {{ in_array($k->kode_kriteria, (array) request('kriteria', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="ck_{{ $k->kode_kriteria }}">{{ $k->nama_kriteria }}
                                            ({{ strtoupper($k->kode_kriteria) }})
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Terapkan</button>
                    <a href="{{ route('alternatif.rekomendasi') }}" class="btn btn-light border ml-2">Reset</a>
                </form>
            </div>
        </div>
        <script>
            (function() {
                var btn = document.getElementById('btnFilterToggle');
                var panel = document.getElementById('filterPanel');
                if (btn && panel) {
                    btn.addEventListener('click', function() {
                        if (panel.classList.contains('d-none')) {
                            panel.classList.remove('d-none');
                        } else {
                            panel.classList.add('d-none');
                        }
                    });
                }
            })();
        </script>

        {{-- 🏆 Special Card for #1 Ranked Product --}}
        @if (!empty($optimasi))
            @php
                $firstId = array_key_first($optimasi);
                $firstAlt = $alternatifs->firstWhere('id', $firstId);
                $firstNilai = $optimasi[$firstId];
            @endphp
            @if ($firstAlt)
                <div class="card shadow-lg mb-4 champion-card" style="border: 2px solid #28a745; background: linear-gradient(135deg, #f8fff9 0%, #e8f5e8 100%);">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <div class="rank-badge-special" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px; border-radius: 50%; font-size: 1.2rem; font-weight: bold; display: inline-block; width: 80px; height: 80px; line-height: 50px;">
                                    #1
                                </div>
                            </div>
                            <div class="col-md-4">
                                @php
                                    $img = $firstAlt->product->image ?? null;
                                    if ($img) {
                                        if (str_starts_with($img, 'http')) {
                                            $src = $img;
                                        } else {
                                            $src = asset('storage/products/' . ltrim($img, '/'));
                                        }
                                    } else {
                                        $src = asset('assets/img/default.png');
                                    }
                                @endphp
                                <img src="{{ $src }}" alt="{{ $firstAlt->product->series }}"
                                     style="width: 100%; height: 200px; object-fit: contain; border-radius: 12px; background: #f8f9fa;" />
                            </div>
                            <div class="col-md-6">
                                <h4 class="text-success mb-2">{{ $firstAlt->product->series }}</h4>
                                <div class="mb-3">
                                    <span class="badge bg-primary me-2">{{ $firstAlt->product->storage }} GB</span>
                                    <span class="badge bg-warning text-dark">Rp {{ number_format($firstAlt->product->price, 0, ',', '.') }}</span>
                                </div>

                                {{-- Analysis of why it's #1 --}}
                                <div class="analysis-section">
                                    <h6 class="text-dark mb-3">
                                        <i class="bi bi-trophy-fill text-warning me-2"></i>
                                        Mengapa Produk Ini Ranking #1?
                                    </h6>
                                    <div class="criteria-analysis">
                                        @php
                                            $topCriteria = [];
                                            $criteriaNames = [
                                                'C01' => 'Harga',
                                                'C02' => 'Performance',
                                                'C03' => 'Kamera',
                                                'C04' => 'Baterai',
                                                'C05' => 'Storage',
                                                'C06' => 'After Sales'
                                            ];

                                            // Calculate contribution of each criteria to the final score
                                            foreach ($kriterias as $k) {
                                                if (isset($normalisasi[$firstId][$k->kode_kriteria])) {
                                                    $normalizedValue = $normalisasi[$firstId][$k->kode_kriteria];
                                                    $weight = (float) $k->bobot;
                                                    $contribution = strtolower($k->type) === 'benefit'
                                                        ? $normalizedValue * $weight
                                                        : -($normalizedValue * $weight);
                                                    $topCriteria[] = [
                                                        'name' => $criteriaNames[$k->kode_kriteria] ?? $k->nama_kriteria,
                                                        'contribution' => $contribution,
                                                        'type' => $k->type,
                                                        'weight' => $weight,
                                                        'raw_value' => $matrix[$firstId][$k->kode_kriteria] ?? 0
                                                    ];
                                                }
                                            }

                                            // Sort by contribution (highest positive impact first)
                                            usort($topCriteria, function($a, $b) {
                                                return $b['contribution'] <=> $a['contribution'];
                                            });
                                        @endphp

                                        @foreach (array_slice($topCriteria, 0, 3) as $criteria)
                                            @php
                                                $name = $criteria['name'];
                                                $value = $criteria['raw_value'];
                                                $type = $criteria['type'];
                                                $isPositive = $criteria['contribution'] > 0;

                                                // Create user-friendly descriptions
                                                $description = '';
                                                $icon = '';

                                                if ($name === 'Harga') {
                                                    $icon = '💰';
                                                    // For price (Cost criteria), negative contribution means lower price = better
                                                    if ($type === 'Cost') {
                                                        $description = $isPositive ? 'Harga lebih mahal' : 'Harga terjangkau';
                                                    } else {
                                                        $description = $isPositive ? 'Harga terjangkau' : 'Harga lebih mahal';
                                                    }
                                                } elseif ($name === 'Performance') {
                                                    $icon = '⚡';
                                                    if ($isPositive) {
                                                        $description = 'Performance lebih baik';
                                                    } else {
                                                        $description = 'Performance kurang optimal';
                                                    }
                                                } elseif ($name === 'Kamera') {
                                                    $icon = '📷';
                                                    if ($isPositive) {
                                                        $description = 'Kualitas kamera lebih bagus';
                                                    } else {
                                                        $description = 'Kualitas kamera kurang bagus';
                                                    }
                                                } elseif ($name === 'Baterai') {
                                                    $icon = '🔋';
                                                    if ($isPositive) {
                                                        $description = 'Daya tahan baterai lebih kuat';
                                                    } else {
                                                        $description = 'Daya tahan baterai kurang kuat';
                                                    }
                                                } elseif ($name === 'Storage') {
                                                    $icon = '💾';
                                                    if ($isPositive) {
                                                        $description = 'Kapasitas storage lebih besar';
                                                    } else {
                                                        $description = 'Kapasitas storage lebih kecil';
                                                    }
                                                } elseif ($name === 'After Sales') {
                                                    $icon = '🎧';
                                                    if ($isPositive) {
                                                        $description = 'Layanan after sales lebih baik';
                                                    } else {
                                                        $description = 'Layanan after sales kurang baik';
                                                    }
                                                }
                                            @endphp
                                            <div class="criteria-item mb-2 p-2 rounded"
                                                 style="background: #d4edda;">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold">
                                                        {{ $icon }} {{ $description }}
                                                    </span>
                                                    <span class="badge bg-success">
                                                        ✓
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-3 p-3 rounded" style="background: #e3f2fd;">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle me-1"></i>
                                            @php
                                                $strengths = [];
                                                $criteriaNames = [
                                                    'C01' => 'Harga',
                                                    'C02' => 'Performance',
                                                    'C03' => 'Kamera',
                                                    'C04' => 'Baterai',
                                                    'C05' => 'Storage',
                                                    'C06' => 'After Sales'
                                                ];

                                                // Get the top criteria that contributed most positively
                                                $positiveCriteria = array_filter($topCriteria, function($c) {
                                                    return $c['contribution'] > 0;
                                                });

                                                // Always show at least 2-3 criteria, or all if less than 3
                                                $topStrengths = array_slice($positiveCriteria, 0, max(2, min(3, count($positiveCriteria))));

                                                // If we have less than 2 positive criteria, include some from the top criteria regardless of contribution
                                                if (count($topStrengths) < 2) {
                                                    $topStrengths = array_slice($topCriteria, 0, 3);
                                                }

                                                foreach ($topStrengths as $criteria) {
                                                    $name = $criteria['name'];
                                                    $value = $criteria['raw_value'];
                                                    $type = $criteria['type'];

                                                    if ($name === 'Harga') {
                                                        $strengths[] = "Harga terjangkau (Rp " . number_format($value, 0, ',', '.') . ")";
                                                    } elseif ($name === 'Performance') {
                                                        $strengths[] = "Performance tinggi (" . number_format($value, 1) . "/10)";
                                                    } elseif ($name === 'Kamera') {
                                                        $strengths[] = "Kualitas kamera bagus (" . number_format($value, 1) . "/10)";
                                                    } elseif ($name === 'Baterai') {
                                                        $strengths[] = "Daya tahan baterai kuat (" . number_format($value, 0) . " Jam)";
                                                    } elseif ($name === 'Storage') {
                                                        $strengths[] = "Kapasitas storage besar (" . number_format($value, 0) . " GB)";
                                                    } elseif ($name === 'After Sales') {
                                                        $strengths[] = "Layanan after sales baik (" . number_format($value, 1) . "/10)";
                                                    }
                                                }

                                                $explanation = "Produk ini mendapat ranking #1 karena ";
                                                if (!empty($strengths)) {
                                                    if (count($strengths) == 1) {
                                                        $explanation .= $strengths[0] . ".";
                                                    } elseif (count($strengths) == 2) {
                                                        $explanation .= $strengths[0] . " dan " . $strengths[1] . ".";
                                                    } elseif (count($strengths) == 3) {
                                                        $explanation .= $strengths[0] . ", " . $strengths[1] . ", dan " . $strengths[2] . ".";
                                                    } else {
                                                        // For more than 3, show first 3
                                                        $explanation .= $strengths[0] . ", " . $strengths[1] . ", dan " . $strengths[2] . ".";
                                                    }
                                                } else {
                                                    $explanation .= "memiliki kombinasi terbaik dari semua kriteria yang dinilai.";
                                                }
                                            @endphp
                                            {{ $explanation }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        {{-- 📊 Hasil Rekomendasi --}}
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    @php $rank = 1; @endphp
                    @forelse ($optimasi as $id => $nilai)
                        @php $alt = $alternatifs->firstWhere('id', $id); @endphp
                        @if ($alt)
                            @php $delay = ($rank - 1) * 0.06 . 's'; @endphp
                            <div class="col-sm-6 col-md-4 col-lg-3 mb-4 fade-in"
                                style="animation-delay: {{ $delay }};">
                                <div class="card h-100 product-card glow-ring">
                                    @php
                                        $img = $alt->product->image ?? null;
                                        if ($img) {
                                            if (str_starts_with($img, 'http')) {
                                                $src = $img;
                                            } else {
                                                $src = asset('storage/products/' . ltrim($img, '/'));
                                            }
                                        } else {
                                            $src = asset('assets/img/default.png');
                                        }
                                    @endphp
                                    <div class="product-img-wrapper">
                                        <span class="rank-badge" title="Peringkat">Rank #{{ $rank }}</span>
                                        @if (!empty($selectedCodes ?? []) || request()->filled('rank'))
                                            {{-- <span class="moora-badge">MOORA: {{ number_format($nilai, 4) }}</span> --}}
                                        @endif
                                        <img src="{{ $src }}" class="card-img-top skeleton"
                                            alt="{{ $alt->product->series }}" style="height: 260px; object-fit: cover;"
                                            onload="this.classList.remove('skeleton')" />
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title mb-1">{{ $alt->product->series }}</h6>
                                        <div class="meta-row mb-2">
                                            <span class="chip">{{ $alt->product->storage }} GB</span>
                                            <span class="price-chip">Rp
                                                {{ number_format($alt->product->price, 0, ',', '.') }}</span>
                                        </div>
                                        <p class="desc-text mb-0 clamp-2">
                                            {{ \Illuminate\Support\Str::limit($alt->product->description, 140) }}</p>
                                        <div class="mt-auto">
                                            <button type="button" class="btn btn-success mt-3"
                                                data-bs-toggle="modal" data-bs-target="#modalProduct-{{ $id }}">
                                                Lihat Detail
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal Detail Produk --}}
                            <div class="modal fade" id="modalProduct-{{ $id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content rounded-3">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title mb-0">{{ $alt->product->series }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-5 mb-3 mb-md-0">
                                                    <div class="border rounded-lg overflow-hidden shadow-sm">
                                                        <img src="{{ $src }}" alt="{{ $alt->product->series }}"
                                                            style="width: 100%; height: 280px; object-fit: cover;" />
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="d-flex align-items-center flex-wrap mb-3">
                                                        <span class="price-chip me-2 mb-2">Rp {{ number_format($alt->product->price, 0, ',', '.') }}</span>
                                                        <span class="chip mb-2">{{ $alt->product->storage }} GB</span>
                                                        @if (!empty($selectedCodes ?? []) || request()->filled('rank'))
                                                            <span class="badge bg-primary ms-2 mb-2">MOORA: {{ number_format($nilai, 4) }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 p-3 rounded" style="background:#f9fafb;">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="bi bi-tag me-2 text-secondary"></i>
                                                            <span class="fw-bold">Series</span>
                                                        </div>
                                                        <div class="text-dark">{{ $alt->product->series }}</div>
                                                    </div>
                                                    <div class="mb-1 p-3 rounded" style="background:#f9fafb;">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="bi bi-info-circle me-2 text-secondary"></i>
                                                            <span class="fw-bold">Deskripsi</span>
                                                        </div>
                                                        <p class="mb-0" style="color:#4b5563; line-height:1.7;">
                                                            {{ $alt->product->description }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $rank++; @endphp
                        @endif
                    @empty
                        <div class="col-12 text-center text-muted py-4">Tidak ada data yang cocok dengan filter.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Section --}}
    <footer class="mt-5 py-4" style="background: linear-gradient(135deg, #2e7d32, #43a047); color: white;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">
                        <i class="bi bi-trophy-fill me-2"></i>
                        Sistem Rekomendasi Produk
                    </h5>
                    <p class="mb-0 text-light">
                        Menggunakan metode MOORA (Multi-Objective Optimization on the basis of Ratio Analysis)
                        untuk memberikan rekomendasi produk terbaik berdasarkan kriteria yang telah ditentukan.
                    </p>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-3">Kriteria Penilaian</h6>
                    <ul class="list-unstyled text-light">
                        <li><i class="bi bi-currency-dollar me-2"></i>Harga</li>
                        <li><i class="bi bi-speedometer2 me-2"></i>Performance</li>
                        <li><i class="bi bi-camera me-2"></i>Kamera</li>
                        <li><i class="bi bi-battery-full me-2"></i>Baterai</li>
                        <li><i class="bi bi-hdd me-2"></i>Storage</li>
                        <li><i class="bi bi-headset me-2"></i>After Sales</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-3">Informasi</h6>
                    <div class="text-light">
                        <p class="mb-2">
                            <i class="bi bi-calendar-check me-2"></i>
                            Total Produk: <strong>{{ count($optimasi) }}</strong>
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-graph-up me-2"></i>
                            Metode: <strong>MOORA</strong>
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-shield-check me-2"></i>
                            Status: <span class="badge bg-success">Aktif</span>
                        </p>
                    </div>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-light">
                        <i class="bi bi-c-circle me-1"></i>
                        {{ date('Y') }} Sistem Rekomendasi Produk. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex justify-content-md-end gap-3">
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-check-circle me-1"></i>
                            Terverifikasi
                        </span>
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-star-fill me-1"></i>
                            Rekomendasi Terbaik
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endsection
