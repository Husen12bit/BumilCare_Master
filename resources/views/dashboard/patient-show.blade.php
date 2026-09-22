@extends('layouts.app')

@section('title', $patient->user->name)
@section('content')

    <div class="mb-4">
        <a href="{{ route('patients.index') }}" class="text-sm text-gray-500 hover:text-blue-600">
            ← Kembali ke Daftar Pasien
        </a>
    </div>

    {{-- Card Info Pasien --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">{{ $patient->user->name }}</h2>
                <p class="text-sm text-gray-500">{{ $patient->user->email }}</p>
            </div>

            @php
                $status = $patient->screenings->first()?->risk_status;
                $badgeClass = match ($status?->value) {
                    'merah' => 'bg-red-100 text-red-800',
                    'kuning' => 'bg-yellow-100 text-yellow-800',
                    'hijau' => 'bg-green-100 text-green-800',
                    default => 'bg-gray-100 text-gray-800',
                };
            @endphp
            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $badgeClass }}">
                {{ $status?->label() ?? 'Belum ada skrining' }}
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-100">
            <div>
                <p class="text-xs text-gray-400 uppercase">Tanggal Lahir</p>
                <p class="text-sm font-medium text-gray-800 mt-1">
                    {{ $patient->tanggal_lahir->format('d F Y') }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase">HPL</p>
                <p class="text-sm font-medium text-gray-800 mt-1">
                    {{ $patient->hpl?->format('d F Y') ?? '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase">Tinggi Badan</p>
                <p class="text-sm font-medium text-gray-800 mt-1">
                    {{ $patient->tinggi_badan ? $patient->tinggi_badan . ' cm' : '-' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Riwayat Skrining --}}
    <h3 class="text-lg font-semibold text-gray-700 mb-4">
        Riwayat Skrining ({{ $patient->screenings->count() }})
    </h3>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tensi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hb</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keluhan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($patient->screenings as $screening)
                    @php
                        $st = $screening->risk_status->value;
                        $badgeClass = match ($st) {
                            'merah' => 'bg-red-100 text-red-800',
                            'kuning' => 'bg-yellow-100 text-yellow-800',
                            default => 'bg-green-100 text-green-800',
                        };
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $screening->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $screening->tensi_sistol }}/{{ $screening->tensi_diastol }} mmHg
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $screening->hb_level }} g/dL
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ implode(', ', $screening->keluhan ?? []) ?: '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                {{ strtoupper($st) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                            Pasien ini belum memiliki data skrining.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
