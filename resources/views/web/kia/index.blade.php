@extends('web.layouts.app')

@section('title', 'Kartu KIA')
@section('header-title', 'Kartu KIA Mini')
@section('header-subtitle', 'Kepatuhan & Jadwal Kehamilan')

@section('content')

<div x-data="{ ttd: [false, false, false, false, false, false, false] }" x-cloak class="space-y-4">

    {{-- Info Kehamilan --}}
    <div class="bg-gradient-to-br from-teal-500 to-teal-600 text-white rounded-2xl p-5 shadow-md">
        <p class="text-xs opacity-80">Usia Kehamilan Saat Ini</p>
        <p class="text-3xl font-bold mt-1">
            {{ $patient?->usiaKehamilanMinggu() ?? '-' }}
            <span class="text-base font-normal">minggu</span>
        </p>
        <div class="grid grid-cols-2 gap-3 mt-4 pt-4 border-t border-white/20">
            <div>
                <p class="text-xs opacity-80">HPL</p>
                <p class="text-sm font-semibold mt-0.5">
                    {{ $patient?->hpl?->format('d M Y') ?? '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs opacity-80">HPHT</p>
                <p class="text-sm font-semibold mt-0.5">
                    {{ $patient?->hpht?->format('d M Y') ?? '-' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Kepatuhan TTD --}}
    <div class="bg-white rounded-2xl shadow-sm p-4">
        <h2 class="text-sm font-bold text-teal-600 mb-3 flex items-center gap-2">
            <span>💊</span> Kepatuhan Tablet Tambah Darah (TTD)
        </h2>
        <p class="text-xs text-gray-500 mb-3">Centang hari di mana Anda minum TTD dalam 7 hari terakhir:</p>

        <div class="grid grid-cols-7 gap-1.5">
            <template x-for="(v, i) in ttd" :key="i">
                <button type="button" @click="ttd[i] = !ttd[i]"
                        class="aspect-square rounded-xl flex flex-col items-center justify-center text-xs font-bold transition"
                        :class="ttd[i] ? 'bg-teal-500 text-white shadow-md' : 'bg-gray-100 text-gray-400'">
                    <span x-text="'H-' + (7 - i)"></span>
                    <span x-show="ttd[i]" class="text-[10px] mt-0.5">✓</span>
                </button>
            </template>
        </div>

        <p class="text-xs text-gray-500 mt-3">
            Total minggu ini: <span class="font-bold text-teal-600" x-text="ttd.filter(Boolean).length + '/7'"></span>
        </p>
    </div>

    {{-- Jadwal ANC --}}
    <div class="bg-white rounded-2xl shadow-sm p-4">
        <h2 class="text-sm font-bold text-teal-600 mb-3 flex items-center gap-2">
            <span>📅</span> Jadwal Kunjungan ANC
        </h2>

        <div class="space-y-2">
            @php
                $jadwal = [
                    ['tm' => 'Trimester 1', 'ket' => '1x kunjungan (K1)', 'done' => true],
                    ['tm' => 'Trimester 2', 'ket' => '2x kunjungan', 'done' => false],
                    ['tm' => 'Trimester 3', 'ket' => '3x kunjungan', 'done' => false],
                ];
            @endphp

            @foreach ($jadwal as $j)
                <div class="flex items-center gap-3 p-3 rounded-xl {{ $j['done'] ? 'bg-teal-50' : 'bg-gray-50' }}">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm
                                {{ $j['done'] ? 'bg-teal-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                        {{ $j['done'] ? '✓' : '○' }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">{{ $j['tm'] }}</p>
                        <p class="text-xs text-gray-500">{{ $j['ket'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 p-3 rounded-xl bg-blue-50 border border-blue-200">
            <p class="text-xs text-blue-700">
                <strong>Jadwal ANC berikutnya:</strong> Segera hubungi bidan untuk pemeriksaan rutin.
            </p>
        </div>
    </div>

</div>

@endsection
