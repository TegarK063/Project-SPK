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
        transition: transform 200ms ease, box-shadow 200ms ease;
        border: none;
        border-radius: 14px;
        overflow: hidden;
    }
    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 30px rgba(0,0,0,0.12);
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
        background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.65) 50%, rgba(255,255,255,0) 100%);
        transform: translateX(-100%);
        animation: shimmer 1.4s infinite;
    }
    @keyframes shimmer {
        100% { transform: translateX(100%); }
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
        color: #fff;
        background: linear-gradient(135deg, #4CAF50, #2E7D32);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
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
    .price-tag {
        font-weight: 700;
        color: #2e7d32;
    }
    .small-meta {
        color: #6c757d;
        font-size: 0.9rem;
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
                                    <input class="form-check-input" type="checkbox" name="kriteria[]" id="ck_{{ $k->kode_kriteria }}" value="{{ $k->kode_kriteria }}" {{ in_array($k->kode_kriteria, (array) request('kriteria', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ck_{{ $k->kode_kriteria }}">{{ $k->nama_kriteria }} ({{ strtoupper($k->kode_kriteria) }})</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="rank" class="form-label">Pilih Ranking</label>
                        <select class="form-control" name="rank" id="rank">
                            <option value="">-- Semua --</option>
                            @php $i=1; @endphp
                            @foreach (($allOptimasi ?? $optimasi) as $id => $nilai)
                                <option value="{{ $i }}" {{ request('rank') == $i ? 'selected' : '' }}>Ranking {{ $i++ }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Terapkan</button>
                <a href="{{ route('alternatif.rekomendasi') }}" class="btn btn-light border ml-2">Reset</a>
            </form>
        </div>
    </div>
    <script>
        (function(){
            var btn = document.getElementById('btnFilterToggle');
            var panel = document.getElementById('filterPanel');
            if(btn && panel){
                btn.addEventListener('click', function(){
                    if(panel.classList.contains('d-none')){
                        panel.classList.remove('d-none');
                    } else {
                        panel.classList.add('d-none');
                    }
                });
            }
        })();
    </script>

    {{-- 📊 Hasil Rekomendasi --}}
    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                @php $rank = 1; @endphp
                @forelse ($optimasi as $id => $nilai)
                    @php $alt = $alternatifs->firstWhere('id', $id); @endphp
                    @if ($alt)
                    @php $delay = ($rank - 1) * 0.06 . 's'; @endphp
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4 fade-in" style="animation-delay: {{ $delay }};">
                        <div class="card h-100 product-card">
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
                                <img src="{{ $src }}" class="card-img-top skeleton" alt="{{ $alt->product->series }}" style="height: 180px; object-fit: cover;" onload="this.classList.remove('skeleton')" />
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title mb-1">{{ $alt->product->series }}</h6>
                                <div class="mb-2 small-meta">
                                    <div class="price-tag">Rp {{ number_format($alt->product->price, 0, ',', '.') }}</div>
                                    <div>Storage: {{ $alt->product->storage }} GB</div>
                                </div>
                                {{-- MOORA score and contributions (if filtered by criteria) --}}
                                @if(!empty($selectedCodes ?? []))
                                <div class="mb-2 small-meta">
                                    <div><strong>Skor MOORA:</strong> {{ number_format($nilai, 4) }}</div>
                                    <div class="mt-1">
                                        @foreach ($selectedCodes as $code)
                                            @php
                                                $r = $normalisasi[$alt->id][$code] ?? null;
                                                $w = $weightsSelected[$code] ?? null;
                                                $k = $kriterias->firstWhere('kode_kriteria', $code);
                                                $isBenefit = $k && strtolower($k->type) === 'benefit';
                                                $contrib = ($r !== null && $w !== null) ? ($isBenefit ? $r * $w : -($r * $w)) : null;
                                            @endphp
                                            @if($contrib !== null)
                                                <div>
                                                    {{ $k->nama_kriteria ?? $code }}: {{ number_format($contrib, 4) }}
                                                    <span class="text-muted">(r={{ $r !== null ? number_format($r,4) : '-' }}, w={{ $w !== null ? number_format($w,4) : '-' }})</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                <p class="card-text mb-0 small-meta">
                                    {{ \Illuminate\Support\Str::limit($alt->product->description, 100) }}
                                </p>
                                @endif
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
@endsection
