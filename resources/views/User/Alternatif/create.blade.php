<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Alternatif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2" defer></script>
    <style>
        body {
            background: #f3f4f6;
        }
    </style>
</head>

<body>
    <section class="min-h-screen p-6 bg-zinc-600 shadow-md">
        <h1 class="text-xl font-bold text-white capitalize">Add Alternatif</h1>
        <form action="{{ route('Alternatif.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-6 mt-4">
                <div>
                    <label class="text-white" for="kode_alternatif">Kode Alternatif</label>
                    <input id="kode_alternatif" type="text" name="kode_alternatif" value="{{ $kode_alternatif }}"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-pink-500 focus:outline-none focus:ring"
                        readonly>
                </div>

                <div>
                    <label class="text-white" for="product_id">Pilih Series</label>
                    <select id="product_id" name="product_id"
                        class="@error('product_id') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-pink-500 focus:outline-none focus:ring">

                        <option value="">-- Pilih Series --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                data-storage="{{ $product->storage }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->series }}
                            </option>
                        @endforeach
                    </select>

                    @error('product_id')
                        <div class="text-red-500 mt-1 ">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-3">
                    <label class="text-white" for="price">Harga</label>
                    <input id="price" type="text"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-md"
                        readonly>
                </div>

                <div class="mt-3">
                    <label class="text-white" for="storage">Storage</label>
                    <input id="storage" type="text"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-md"
                        readonly>
                </div>

                <div>
                    <label class="text-white" for="performance">Performance</label>
                    <input id="performance" type="number" name="performance" value="{{ old('performance') }}"
                        class="@error('performance') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-pink-500 focus:outline-none focus:ring"
                        placeholder="Masukkan Performance 1-100" min="1" max="100" required>
                    @error('performance')
                        <div class="text-red-500 mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="text-white" for="camera">Camera</label>
                    <input id="camera" type="number" name="camera" value="{{ old('camera') }}"
                        class="@error('camera') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-pink-500 focus:outline-none focus:ring"
                        placeholder="Masukkan Camera 1-100" min="1" max="100" required>
                    @error('camera')
                        <div class="text-red-500 mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="text-white" for="battery">Battery</label>
                    <input id="battery" type="number" name="battery" value="{{ old('battery') }}"
                        class="@error('battery') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-pink-500 focus:outline-none focus:ring"
                        placeholder="Masukkan Ketahanan Battery" min="1" max="100" required>
                    @error('battery')
                        <div class="text-red-500 mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="text-white" for="aftersales">Aftersales</label>
                    <input id="aftersales" type="number" name="aftersales" value="{{ old('aftersales') }}"
                        class="@error('aftersales') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-pink-500 focus:outline-none focus:ring"
                        placeholder="Masukkan Aftersales 1-10" min="1" max="10" required>
                    @error('aftersales')
                        <div class="text-red-500 mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="mr-2 px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-700 rounded-md hover:bg-pink-600 focus:outline-none focus:bg-pink-600">Save</button>
                <a href="{{ route('Alternatif.index') }}"
                    class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">Cancel</a>
            </div>
        </form>
    </section>
    <script>
        document.getElementById('product_id').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            document.getElementById('price').value = selected.getAttribute('data-price') || '';
            document.getElementById('storage').value = selected.getAttribute('data-storage') || '';
        });
    </script>
</body>

</html>
