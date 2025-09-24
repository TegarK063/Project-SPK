<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2" defer></script>
    <style>
        body {
            background: #f3f4f6;
        }
    </style>
</head>

<body>
    <section class="min-h-screen p-6 bg-zinc-600 shadow-md dark:bg-gray-800">
        <h1 class="text-xl font-bold text-white capitalize dark:text-white">Add Product</h1>
        <form action="{{ route('Products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-6 mt-4">
                <div>
                    <label class="text-white dark:text-gray-200" for="series">Series</label>
                    <input id="series" type="text" name="series"
                        class="value {{ old('series') }} @error('series') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-pink-500 dark:focus:border-pink-500 focus:outline-none focus:ring"
                        placeholder="Masukkan Series Product">
                    <!-- error message untuk series -->
                    @error('series')
                        <div class="text-red-500 mt-1 ">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="text-white dark:text-gray-200" for="storage">Storage</label>
                    <input id="storage" type="number" name="storage"
                        class="value {{ old('storage') }} @error('storage') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-pink-500 dark:focus:border-pink-500 focus:outline-none focus:ring"
                        placeholder="Masukkan Storage Product">
                    <!-- error message untuk storage -->
                    @error('storage')
                        <div class="text-red-500 mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="text-white dark:text-gray-200" for="price">Price</label>
                    <input id="price" type="text" name="price"
                        class="value {{ old('price') }} @error('price') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-pink-500 dark:focus:border-pink-500 focus:outline-none focus:ring"
                        placeholder="Masukkan Price Product">
                    <!-- error message untuk price -->
                    @error('price')
                        <div class="text-red-500 mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="text-white dark:text-gray-200" for="description">Description</label>
                    <textarea id="description" type="textarea" name="description"
                        class="value {{ old('description') }} @error('description') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-pink-500 dark:focus:border-pink-500 focus:outline-none focus:ring"></textarea>
                    <!-- error message untuk description -->
                    @error('description')
                        <div class="text-red-500 mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-white">
                        Image
                    </label>
                    <div
                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-white" stroke="currentColor" fill="none"
                                viewBox="0 0 48 48" aria-hidden="true">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="image"
                                    class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span class="">Upload a file</span>
                                    <input id="image" name="image" type="file"
                                        class="sr-only @error('image') is-invalid @enderror">
                                </label>
                                <p class="pl-1 text-white">or drag and drop</p>
                                <!-- error message untuk image -->
                            </div>
                            @error('image')
                                <div class="text-red-500 mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                            <p class="text-xs text-white">
                                PNG, JPG, GIF up to 10MB
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="mr-2 px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-700 rounded-md hover:bg-pink-600 focus:outline-none focus:bg-pink-600">Save</button>
                <a href="{{ route('Products.index') }}"
                    class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">Cencel</a>
            </div>
        </form>
    </section>
    <script>
        const priceInput = document.getElementById('price');

        // Format angka ribuan saat mengetik
        priceInput.addEventListener('input', function(e) {
            // Ambil hanya digit angka
            let value = this.value.replace(/\D/g, '');
            if (value) {
                this.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                this.value = '';
            }
        });

        // Bersihkan jadi angka mentah sebelum submit
        document.querySelector('form').addEventListener('submit', function() {
            priceInput.value = priceInput.value.replace(/\./g, '');
        });
    </script>
</body>

</html>
