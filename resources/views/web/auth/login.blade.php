<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="theme-color" content="#00897B">
    <title>Masuk — BumilCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-teal-50 to-blue-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm bg-white rounded-2xl shadow-xl p-6">
        <div class="text-center mb-6">
            <div class="w-16 h-16 mx-auto bg-teal-100 rounded-full flex items-center justify-center mb-3">
                <span class="text-3xl">💚</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">BumilCare</h1>
            <p class="text-sm text-gray-500 mt-1">Skrining Cepat & KIA Digital</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('bumil.login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none text-base"
                       placeholder="nama@email.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none text-base"
                       placeholder="••••••••">
            </div>

            <button type="submit"
                    class="w-full py-3 bg-teal-600 text-white rounded-xl font-semibold text-base active:scale-[0.98] transition">
                Masuk
            </button>
        </form>

        <div class="text-center mt-6 pt-6 border-t border-gray-100">
            <p class="text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('bumil.register') }}" class="text-teal-600 font-semibold">Daftar Sekarang</a>
            </p>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-xs text-gray-400">Login sebagai Nakes →</a>
        </div>
    </div>

</body>
</html>
