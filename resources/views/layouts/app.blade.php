<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — BumilCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="text-lg font-bold text-gray-800">
                    BumilCare
                    <span class="text-xs font-normal text-gray-400 ml-1">Nakes</span>
                </a>
                <div class="flex gap-6 text-sm">
                    <a href="{{ route('dashboard') }}"
                       class="{{ request()->routeIs('dashboard') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-blue-600' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('patients.index') }}"
                       class="{{ request()->routeIs('patients.*') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-blue-600' }}">
                        Daftar Pasien
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-medium text-gray-800">{{ auth()->user()->name ?? 'Nakes' }}</div>
                    <div class="text-xs text-gray-500">Tenaga Kesehatan</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-sm px-3 py-1.5 rounded-md bg-red-50 text-red-600 hover:bg-red-100 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="text-center text-xs text-gray-400 py-6">
        &copy; {{ date('Y') }} BumilCare &mdash; Sistem Monitoring Kesehatan Ibu Hamil
    </footer>

</body>
</html>
