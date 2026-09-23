@extends('web.layouts.app')

@section('title', 'Profil Saya')
@section('header-title', 'Profil Saya')
@section('header-subtitle', 'Kelola data kehamilan Anda')

@section('content')

<div class="space-y-4">

    <div class="bg-gradient-to-br from-teal-500 to-teal-600 text-white rounded-2xl p-5 shadow-md">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-3xl">
                👩
            </div>
            <div>
                <p class="font-bold text-lg">{{ auth()->user()->name }}</p>
                <p class="text-xs opacity-90">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-4">
        <h2 class="text-sm font-bold text-teal-600 mb-3">Data Pribadi</h2>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between py-1.5 border-b border-gray-100">
                <span class="text-gray-500">Umur</span>
                <span class="font-medium">{{ $patient?->tanggal_lahir?->age ?? '-' }} tahun</span>
            </div>
            <div class="flex justify-between py-1.5 border-b border-gray-100">
                <span class="text-gray-500">Alamat</span>
                <span class="font-medium text-right max-w-[60%]">{{ $patient?->alamat ?? '-' }}</span>
            </div>
            <div class="flex justify-between py-1.5">
                <span class="text-gray-500">Jumlah Anak</span>
                <span class="font-medium">{{ $patient?->jumlah_anak ?? 0 }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-4">
        <h2 class="text-sm font-bold text-teal-600 mb-3">Data Kehamilan</h2>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between py-1.5 border-b border-gray-100">
                <span class="text-gray-500">HPHT</span>
                <span class="font-medium">{{ $patient?->hpht?->format('d M Y') ?? '-' }}</span>
            </div>
            <div class="flex justify-between py-1.5 border-b border-gray-100">
                <span class="text-gray-500">HPL</span>
                <span class="font-medium">{{ $patient?->hpl?->format('d M Y') ?? '-' }}</span>
            </div>
            <div class="flex justify-between py-1.5 border-b border-gray-100">
                <span class="text-gray-500">Usia Kehamilan</span>
                <span class="font-medium">{{ $patient?->usiaKehamilanMinggu() ?? '-' }} minggu</span>
            </div>
            <div class="flex justify-between py-1.5 border-b border-gray-100">
                <span class="text-gray-500">Tinggi Badan</span>
                <span class="font-medium">{{ $patient?->tinggi_badan ?? '-' }} cm</span>
            </div>
            <div class="flex justify-between py-1.5 border-b border-gray-100">
                <span class="text-gray-500">Berat Badan</span>
                <span class="font-medium">{{ $patient?->berat_badan ?? '-' }} kg</span>
            </div>
            <div class="flex justify-between py-1.5">
                <span class="text-gray-500">LILA</span>
                <span class="font-medium">{{ $patient?->lila ?? '-' }} cm</span>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('bumil.logout') }}">
        @csrf
        <button type="submit"
                class="w-full py-3 bg-red-50 text-red-600 rounded-xl font-semibold text-sm active:scale-[0.98] transition">
            Keluar dari Akun
        </button>
    </form>

</div>

@endsection
