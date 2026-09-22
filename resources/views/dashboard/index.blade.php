@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')

    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Statistik Pasien berdasarkan Risiko</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- MERAH --}}
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-red-500">
            <p class="text-sm font-medium text-gray-500 uppercase">Risiko Tinggi (Merah)</p>
            <p class="text-4xl font-bold text-red-600 mt-2">{{ $data['merah'] }}</p>
            <p class="text-sm text-gray-400 mt-1">Pasien perlu perhatian segera</p>
        </div>

        {{-- KUNING --}}
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
            <p class="text-sm font-medium text-gray-500 uppercase">Risiko Sedang (Kuning)</p>
            <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $data['kuning'] }}</p>
            <p class="text-sm text-gray-400 mt-1">Pasien perlu pemantauan</p>
        </div>

        {{-- HIJAU --}}
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
            <p class="text-sm font-medium text-gray-500 uppercase">Risiko Rendah (Hijau)</p>
            <p class="text-4xl font-bold text-green-600 mt-2">{{ $data['hijau'] }}</p>
            <p class="text-sm text-gray-400 mt-1">Pasien dalam kondisi normal</p>
        </div>
    </div>

    {{-- Alert Pasien Merah --}}
    <div class="mt-10">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">
                ⚠️ Perhatian Segera — Pasien Risiko Tinggi
            </h3>
            <a href="{{ route('patients.index') }}" class="text-sm text-blue-600 hover:underline">
                Lihat semua pasien →
            </a>
        </div>

        @if ($alerts->isEmpty())
            <div class="bg-white rounded-xl shadow p-6 text-center text-gray-400 text-sm">
                Tidak ada pasien berisiko tinggi saat ini. 👍
            </div>
        @else
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-red-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase">Pasien</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase">Tensi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase">Hb</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase">Keluhan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase">Waktu</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-red-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($alerts as $patient)
                            @php $s = $patient->latestScreening; @endphp
                            <tr class="hover:bg-red-50/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $patient->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $patient->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $s->tensi_sistol }}/{{ $s->tensi_diastol }} <span class="text-xs text-gray-400">mmHg</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $s->hb_level }} <span class="text-xs text-gray-400">g/dL</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ implode(', ', $s->keluhan ?? []) ?: '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $s->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('patients.show', $patient) }}"
                                       class="text-sm text-blue-600 hover:underline font-medium">
                                        Detail →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection
