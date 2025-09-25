<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product</title>
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
        <h1 class="text-xl font-bold text-white capitalize dark:text-white">Edit Product</h1>
        <form action="{{ route('Products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6 mt-4">
                <div>
                    <label class="text-white dark:text-gray-200" for="series">Series</label>
                    <input id="series" type="text" name="series" value="{{ old('series', $product->series) }}"
                        class="@error('series') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-pink-500 dark:focus:border-pink-500 focus:outline-none focus:ring"
                        placeholder="Masukkan Series Product">
                    @error('series')
                        <div class="text-red-500 mt-1 ">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="text-white dark:text-gray-200" for="storage">Storage</label>
                    <input id="storage" type="number" name="storage" value="{{ old('storage', $product->storage) }}"
                        class="@error('storage') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-pink-500 dark:focus:border-pink-500 focus:outline-none focus:ring"
                        placeholder="Masukkan Storage Product">
                    @error('storage')
                        <div class="text-red-500 mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="text-white dark:text-gray-200" for="price">Price</label>
                    <input id="price" type="text" name="price" value="{{ old('price', $product->price) }}"
                        class="@error('price') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-pink-500 dark:focus:border-pink-500 focus:outline-none focus:ring"
                        placeholder="Masukkan Price Product">
                    @error('price')
                        <div class="text-red-500 mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="text-white dark:text-gray-200" for="description">Description</label>
                    <textarea id="description" name="description"
                        class="@error('description') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-pink-500 dark:focus:border-pink-500 focus:outline-none focus:ring">{{ old('description', $product->description) }}</textarea>
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
                    <div class="mt-2">
                        @if ($product->image)
                            <div class="mb-4">
                                <p class="text-white mb-2">Current Image:</p>
                                <img id="preview-image" src="{{ asset('storage/products/' . $product->image) }}"
                                    alt="Product Image"
                                    class="h-32 w-32 object-cover rounded-md border border-gray-300">
                            </div>
                        @else
                            <img id="preview-image"
                                class="h-32 w-32 object-cover rounded-md border border-gray-300 hidden">
                        @endif

                        <div
                            class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
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
                                        <span>Upload a file</span>
                                        <input id="image" name="image" type="file"
                                            class="sr-only @error('image') is-invalid @enderror" accept="image/*">
                                    </label>
                                    <p class="pl-1 text-white">or drag and drop</p>
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

        priceInput.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            if (value) {
                this.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                this.value = '';
            }
        });

        document.querySelector('form').addEventListener('submit', function() {
            priceInput.value = priceInput.value.replace(/\./g, '');
        });
    </script>
    <script>
        const inputImage = document.getElementById('image');
        const previewImage = document.getElementById('preview-image');

        inputImage.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden'); // kalau tadinya gak ada gambar
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>

</html>
