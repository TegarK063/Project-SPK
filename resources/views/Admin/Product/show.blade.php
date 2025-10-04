<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2" defer></script>
</head>

<!-- component -->

<body class="font-mono bg-zinc-600 shadow-md">
    <!-- component -->
    <div class="max-w-4xl mx-auto my-40">
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Produk</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Gambar Produk -->
                <div class="flex justify-center">
                    <img src="{{ asset('/storage/products/' . $product->image) }}" alt="{{ $product->series }}"
                        class="rounded-lg shadow w-64 h-64 object-cover">
                </div>

                <!-- Informasi Produk -->
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Series</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $product->series }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Storage</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $product->storage }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Deskripsi</p>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Harga</p>
                        <p class="text-xl font-bold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tombol Navigasi Admin -->
            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('Products.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>

</body>

</html>
