<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="theme-color" content="#00897B">
    <title>Daftar — BumilCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <header class="bg-teal-600 text-white px-4 py-4 shadow-md sticky top-0">
        <div class="flex items-center gap-3">
            <a href="{{ route('bumil.login') }}" class="text-2xl">←</a>
            <h1 class="text-base font-bold">Daftar Akun Bumil</h1>
        </div>
    </header>

    <main class="p-4 max-w-md mx-auto">

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('bumil.register') }}" class="space-y-4">
            @csrf

            {{-- Data Akun --}}
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <h2 class="text-sm font-bold text-teal-600 mb-3">📝 Data Akun</h2>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none text-base">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none text-base">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Password (min 8 karakter)</label>
                        <input type="password" name="password" required minlength="8"
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none text-base">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none text-base">
                    </div>
                </div>
            </div>

            {{-- Data Ibu Hamil --}}
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <h2 class="text-sm font-bold text-teal-600 mb-3">👩 Data Ibu Hamil</h2>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 outline-none text-base">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}"
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 outline-none text-base">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Jumlah Anak</label>
                        <input type="number" name="jumlah_anak" value="{{ old('jumlah_anak', 0) }}" min="0" max="20"
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 outline-none text-base">
                    </div>
                </div>
            </div>

            {{-- Data Kehamilan --}}
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <h2 class="text-sm font-bold text-teal-600 mb-3">🤰 Data Kehamilan</h2>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">HPHT (Hari Pertama Haid Terakhir)</label>
                        <input type="date" name="hpht" value="{{ old('hpht') }}"
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 outline-none text-base">
                        <p class="text-[11px] text-gray-400 mt-1">Kosongkan jika tidak ingat</p>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">TB (cm)</label>
                            <input type="number" name="tinggi_badan" value="{{ old('tinggi_badan') }}" step="0.1"
                                   class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 outline-none text-base">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">BB (kg)</label>
                            <input type="number" name="berat_badan" value="{{ old('berat_badan') }}" step="0.1"
                                   class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 outline-none text-base">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">LILA (cm)</label>
                            <input type="number" name="lila" value="{{ old('lila') }}" step="0.1"
                                   class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 outline-none text-base">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit"
                    class="w-full py-3.5 bg-teal-600 text-white rounded-xl font-semibold text-base active:scale-[0.98] transition shadow-md">
                Daftar Sekarang
            </button>

            <p class="text-center text-xs text-gray-400 pb-4">
                Dengan mendaftar, Anda menyetujui penggunaan data untuk keperluan kesehatan ibu hamil.
            </p>
        </form>
    </main>

</body>
</html>
