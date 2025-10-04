<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Kriteria</title>
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
        <h1 class="text-xl font-bold text-white capitalize">Add Kriteria</h1>
        <form action="{{ route('Kriteria.update', $kriteria->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6 mt-4">
                <div>
                    <label class="text-white" for="kode_kriteria">Kode Kriteria</label>
                    <input id="kode_kriteria" type="text" name="kode_kriteria" value="{{ $kriteria->kode_kriteria }}"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-pink-500 focus:outline-none focus:ring"
                        readonly>
                </div>

                <div>
                    <label class="text-white" for="nama_kriteria">Nama Kriteria</label>
                    <input id="nama_kriteria" type="text" name="nama_kriteria"
                        value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}"
                        class="@error('nama_kriteria') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-pink-500 focus:outline-none focus:ring"
                        placeholder="Masukkan Nama Kriteria">
                    @error('nama_kriteria')
                        <div class="text-red-500 mt-1 ">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="text-white" for="type">Type</label>
                    <select id="type" name="type"
                        class="@error('type') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-pink-500 focus:outline-none focus:ring">
                        <option value="">-- Pilih Type --</option>
                        <option value="Cost" {{ old('type', $kriteria->type) == 'Cost' ? 'selected' : '' }}>Cost
                        </option>
                        <option value="Benefit" {{ old('type', $kriteria->type) == 'Benefit' ? 'selected' : '' }}>
                            Benefit</option>
                    </select>
                    @error('type')
                        <div class="text-red-500 mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="text-white" for="bobot">Bobot</label>
                    <input id="bobot" type="number" name="bobot" value="{{ old('bobot', $kriteria->bobot) }}"
                        class="@error('bobot') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-pink-500 focus:outline-none focus:ring"
                        placeholder="Masukkan Bobot (contoh: 0,20)" step="0.01" min="0">
                    @error('bobot')
                        <div class="text-red-500 mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="mr-2 px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-700 rounded-md hover:bg-pink-600 focus:outline-none focus:bg-pink-600">Save</button>
                <a href="{{ route('Kriteria.index') }}"
                    class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-600">Cancel</a>
            </div>
        </form>
    </section>
    <script>
        const bobotInput = document.getElementById('bobot');

        document.querySelector('form').addEventListener('submit', function() {
            // ganti koma menjadi titik agar bisa disimpan di database
            bobotInput.value = bobotInput.value.replace(',', '.');
        });
    </script>
</body>

</html>
