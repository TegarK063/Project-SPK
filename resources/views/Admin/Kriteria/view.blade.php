@extends('Layout.app')

@section('title', 'Product Admin')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <body>
        <div class="main-content mb-5">
            <div class="container mt-7">
                <div class="row">

                    <div class="col">
                        <div class="card shadow">
                            <div class="card-header border-0">
                                <a class="btn btn-primary text-white" href="{{ Route('Products.create') }}">Tambah
                                    Kriteria</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-items-center table-flush">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th scope="col">Kode</th>
                                            <th scope="col">Kriteria</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Bobot</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @forelse ($kriterias as $kriteria)
                                        <tr>
                                            <td>
                                                <span class=" text-black">
                                                    {{ $kriteria->kode_kriteria }}
                                                </span>
                                            </td>
                                            <th scope="row" class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <span class="mb-0 text-sm">
                                                        {{ $kriteria->nama_kriteria }}
                                                    </span>
                                                </div>
                                            </th>
                                            <td>
                                                <span class=" text-black">
                                                    {{ $kriteria->type }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class=" text-black">
                                                    {{ $kriteria->bobot }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="actions">
                                                    <a href="#" class="btn btn-sm btn-info">View</a>
                                                    <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                                    <form id="#" action="#" method="POST" class="d-inline">
                                                        {{-- @csrf
                                                            @method('DELETE') --}}
                                                        <button type="button" class="btn btn-sm btn-danger">
                                                            Delete
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <div class=" alert alert-danger rounded-0 text-center">
                                            Data Kriteria belum ada.
                                        </div>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer py-4">
                                <nav aria-label="...">
                                    <ul class="pagination justify-content-end mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1">
                                                <i class="fas fa-angle-left"></i>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">
                                                <i class="fas fa-angle-right"></i>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
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
                        <script>
                            function confirmDelete(id, series) {
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: "btn btn-success",
                                        cancelButton: "btn btn-danger"
                                    },
                                    buttonsStyling: false
                                });

                                swalWithBootstrapButtons.fire({
                                    title: "Apakah Anda Yakin?",
                                    text: "Menghapus data " + series,
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonText: "Yes, delete it!",
                                    cancelButtonText: "No, cancel!",
                                    reverseButtons: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // submit form delete
                                        document.getElementById('delete-form-' + id).submit();
                                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                                        swalWithBootstrapButtons.fire({
                                            title: "Cancelled",
                                            text: "Your data is safe :)",
                                            icon: "error"
                                        });
                                    }
                                });
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
