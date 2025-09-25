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
                                    Product</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-items-center table-flush">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th scope="col">Series</th>
                                            <th scope="col">Storage</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @forelse ($products as $product)
                                            <tr>
                                                <th scope="row" class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <a href="#" class="avatar me-2">
                                                            <img alt="Image placeholder"
                                                                src="{{ asset('/storage/products/' . $product->image) }}"
                                                                class=" style="width:50px; height:50px;">
                                                        </a>
                                                        <span class="mb-0 text-sm">{{ $product->series }}
                                                            ({{ $product->storage }})
                                                        </span>
                                                    </div>
                                                </th>
                                                <td>
                                                    <span class=" text-black">
                                                        {{ $product->storage }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class=" text-black">
                                                        {{ 'Rp ' . number_format($product->price, 2, ',', '.') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="actions">
                                                        <a href="{{ route('Products.show', $product->id) }}"
                                                            class="btn btn-sm btn-info">View</a>
                                                        <a href="{{ route('Products.edit', $product->id) }}"
                                                            class="btn btn-sm btn-warning">Edit</a>
                                                        <form id="delete-form-{{ $product->id }}"
                                                            action="{{ route('Products.destroy', $product->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="confirmDelete({{ $product->id }}, '{{ $product->series }}')">
                                                                Delete
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <div class=" alert alert-danger rounded-0 text-center">
                                                Data Products belum ada.
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
