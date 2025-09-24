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
                                <a class="btn btn-primary text-white" href="">Tambah Product</a>
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
                                        <tr>
                                            <th scope="row" class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <a href="#" class="avatar me-2">
                                                        <img alt="Image placeholder"
                                                            src="{{ asset('assets/img/iphone-8-space-gray.jpg') }}"
                                                            class=" style="width:50px; height:50px;">
                                                    </a>
                                                    <span class="mb-0 text-sm">Iphone 8 (64GB)</span>
                                                </div>
                                            </th>
                                            <td>
                                                <span class=" text-black">
                                                    64 GB
                                                </span>
                                            </td>
                                            <td>
                                                <span class=" text-black">
                                                    Rp. 8.000.000
                                                </span>
                                            </td>
                                            <td>
                                                <div class="actions">
                                                    <a href="#" class="btn btn-sm btn-info">View</a>
                                                    <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
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
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
