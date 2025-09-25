@extends('Layout.app')

@section('title', 'Product User')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-hover: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
        }

        body,
        .card {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f4f7fa;
            padding: 6.5em 0;
        }

        .card {
            background: #fff;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 300px;
            /* semua gambar tingginya sama */
            object-fit: cover;
        }


        .card-body {
            text-align: center;
        }

        .card-title {
            font-weight: bold;
            font-size: 1.2rem;
            color: #333;
        }

        .card-subtitle {
            font-size: 0.9rem;
            color: #777;
        }

        .card-text {
            font-size: 0.95rem;
            color: #555;
        }

        .btn {
            border: none;
            border-radius: 30px;
            padding: 8px 18px;
            font-weight: 600;
            color: #fff !important;
            background: var(--gradient);
            transition: all 0.4s ease;
        }

        .btn:hover {
            background: var(--gradient-hover);
            color: #fff !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        .btn i {
            margin-right: 5px;
        }
    </style>


    <body>
        <div class="container main mx-auto">
            <div class="row g-4">
                @forelse ($productsuser as $product)
                    <div class="col-md-4">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset('/storage/products/' . $product->image) }}" class="card-img-top"
                                alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->series }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $product->storage }} GB</h6>
                                <p class="card-text">{{ $product->description }}</p>
                                <a href="#" class="btn mr-2"><i class="fas fa-link"></i>
                                    {{ 'Rp ' . number_format($product->price, 2, ',', '.') }}</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center fs-4">No Products Found</p>
                @endforelse
            </div>
        </div>
    </body>
@endsection
