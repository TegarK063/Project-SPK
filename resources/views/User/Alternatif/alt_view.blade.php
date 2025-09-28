@extends('Layout.app')

@section('title', 'Kelola Alternatif')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <body>
        <div class="main-content mb-5">
            <div class="container-fluid mt-7">
                <div class="row">

                    <div class="col">
                        <div class="card shadow">
                            <form action="{{ route('alternatif.moora') }}" method="POST">
                                @csrf
                                <div class="card-header border-0">
                                    <button type="submit" class="btn btn-success mt-3">Hitung MOORA</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover align-items-center table-flush">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                {{-- <th scope="col">Pilih</th> --}}
                                                <th scope="col">Kode</th>
                                                <th scope="col">Nama Alternatif</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Performance</th>
                                                <th scope="col">Camera</th>
                                                <th scope="col">Battery</th>
                                                <th scope="col">Storage</th>
                                                <th scope="col">Aftersales</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @forelse ($alternatifs as $alternatif)
                                                <tr>
                                                    {{-- <td>
                                                        <input type="checkbox" name="select_alternatif[]"
                                                            value="{{ $alternatif->id }}">
                                                    </td> --}}
                                                    <td>
                                                        <span class=" text-black">
                                                            {{ $alternatif->kode_alternatif }}
                                                        </span>
                                                    </td>
                                                    <th scope="row" class="text-center">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <span class="mb-0 text-sm">
                                                                {{ $alternatif->product->series }}
                                                            </span>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <span class=" text-black">
                                                            {{ $alternatif->product->price }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class=" text-black">
                                                            {{ $alternatif->performance }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class=" text-black">
                                                            {{ $alternatif->camera }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class=" text-black">
                                                            {{ $alternatif->battery }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class=" text-black">
                                                            {{ $alternatif->product->storage }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class=" text-black">
                                                            {{ $alternatif->aftersales }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <div class=" alert alert-danger rounded-0 text-center">
                                                    Data Alternatif belum ada.
                                                </div>
                                            @endforelse
                                        </tbody>
                                    </table>
                            </form>
                        </div>
                        <div class="card-footer py-4">
                        </div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                        //message with sweetalert
                        @if (session('success'))
                            Swal.fire({
                                icon: "success",
                                title: "BERHASIL",
                                text: "{{ session('success') }}",
                                showConfirmButton: false,
                                timer: 2000
                            });
                        @elseif (session('error'))
                            Swal.fire({
                                icon: "error",
                                title: "GAGAL!",
                                text: "{{ session('error') }}",
                                showConfirmButton: false,
                                timer: 2000
                            });
                        @endif
                    </script>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                </div>
            </div>
        </div>
        </div>
    </body>
@endsection
