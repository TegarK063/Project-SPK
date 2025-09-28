@extends('Layout.app')

@section('title', 'Hasil Perhitungan MOORA')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

<div class="container-fluid mt-7">
    <div class="text-center mb-4">
        <h2 class="font-weight-bold">Hasil Perhitungan MOORA</h2>
        <p class="text-muted">Metode Multi-Objective Optimization on the basis of Ratio Analysis</p>
    </div>

    {{-- 1. Bobot Kriteria --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">1. Bobot Kriteria</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Kriteria</th>
                        <th>Tipe</th>
                        <th>Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kriterias as $k)
                        <tr>
                            <td>{{ $k->kode_kriteria }}</td>
                            <td>{{ $k->nama_kriteria }}</td>
                            <td>{{ ucfirst($k->type) }}</td>
                            <td>{{ $k->bobot }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- 2. Matriks Keputusan --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">2. Matriks Keputusan</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Alternatif</th>
                        @foreach ($kriterias as $k)
                            <th>{{ $k->nama_kriteria }} ({{ $k->type }})</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alternatifs as $alt)
                        <tr>
                            <td>{{ $alt->kode_alternatif }} - {{ $alt->product->series }}</td>
                            @foreach ($kriterias as $k)
                                <td>{{ $matrix[$alt->id][$k->kode_kriteria] }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- 3. Normalisasi Matriks --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">3. Normalisasi Matriks</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Alternatif</th>
                        @foreach ($kriterias as $k)
                            <th>{{ $k->nama_kriteria }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alternatifs as $alt)
                        <tr>
                            <td>{{ $alt->kode_alternatif }}</td>
                            @foreach ($kriterias as $k)
                                <td>{{ number_format($normalisasi[$alt->id][$k->kode_kriteria], 4) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- 4. Optimasi (Yi) --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">4. Nilai Optimasi (Yi)</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Alternatif</th>
                        <th>Nilai Yi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($optimasi as $id => $nilai)
                        @php $alt = $alternatifs->firstWhere('id', $id); @endphp
                        <tr>
                            <td>{{ $alt->kode_alternatif }} - {{ $alt->product->series }}</td>
                            <td>{{ number_format($nilai, 4) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- 5. Hasil Ranking --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">5. Hasil Ranking</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Ranking</th>
                        <th>Alternatif</th>
                        <th>Nilai Yi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $rank = 1;
                        $sortedOptimasi = collect($optimasi)->sortDesc();
                    @endphp
                    @foreach ($sortedOptimasi as $id => $nilai)
                        @php $alt = $alternatifs->firstWhere('id', $id); @endphp
                        <tr>
                            <td><span class="badge badge-primary text-black">{{ $rank++ }}</span></td>
                            <td>{{ $alt->kode_alternatif }} - {{ $alt->product->series }}</td>
                            <td>{{ number_format($nilai, 4) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="back-bnt mb-4">
        <a href="{{ route('Alternatif.view') }}" class="btn btn-danger">Kembali</a>
    </div>
</div>
@endsection
