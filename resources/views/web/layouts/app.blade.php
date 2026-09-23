<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#00897B">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <title>@yield('title', 'BumilCare') — BumilCare</title>

    {{-- PWA Manifest --}}
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" href="/icons/icon-192.png">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">

    {{-- Tailwind + Alpine --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --color-teal: #00897B;
            --color-teal-light: #4DB6AC;
            --color-blue-soft: #4FC3F7;
        }
        body { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; -webkit-tap-highlight-color: transparent; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen pb-20">

    {{-- Header --}}
    <header class="bg-teal-600 text-white px-4 pt-4 pb-3 shadow-md sticky top-0 z-30">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-base font-bold">@yield('header-title', 'BumilCare')</h1>
                <p class="text-xs text-teal-100 mt-0.5">@yield('header-subtitle', 'Skrining Cepat & KIA Digital')</p>
            </div>
            <a href="{{ route('bumil.profile') }}" class="w-9 h-9 rounded-full bg-teal-700 flex items-center justify-center">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                </svg>
            </a>
        </div>

        {{-- Badge versi --}}
        <div class="mt-2 inline-flex items-center px-2 py-0.5 rounded-full bg-teal-700 text-[10px] text-teal-100">
            <span class="w-1.5 h-1.5 bg-green-300 rounded-full mr-1 animate-pulse"></span>
            Versi Percontohan Faskes/Kader
        </div>
    </header>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="mx-4 mt-3 p-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Content --}}
    <main class="px-4 py-4">
        @yield('content')
    </main>

    {{-- Bottom Navigation --}}
    <nav class="fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 z-30 safe-area-bottom">
        <div class="grid grid-cols-3">
            @php
                $tabs = [
                    ['route' => 'bumil.screening', 'icon' => 'monitor_heart', 'label' => 'Skrining'],
                    ['route' => 'bumil.kia', 'icon' => 'book', 'label' => 'Kartu KIA'],
                    ['route' => 'bumil.emergency', 'icon' => 'emergency', 'label' => 'Darurat'],
                ];
            @endphp

            @foreach ($tabs as $tab)
                @php $active = request()->routeIs($tab['route']); @endphp
                <a href="{{ route($tab['route']) }}"
                   class="flex flex-col items-center justify-center py-2.5 {{ $active ? 'text-teal-600' : 'text-gray-400' }}">
                    <span class="text-xl">
                        @if($tab['icon'] === 'monitor_heart') ❤️
                        @elseif($tab['icon'] === 'book') 📖
                        @else 🚨
                        @endif
                    </span>
                    <span class="text-[11px] mt-0.5 font-medium">{{ $tab['label'] }}</span>
                    @if($active)
                        <span class="absolute bottom-0 w-12 h-0.5 bg-teal-600 rounded-t-full"></span>
                    @endif
                </a>
            @endforeach
        </div>
    </nav>

    {{-- Register Service Worker --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(console.error);
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
