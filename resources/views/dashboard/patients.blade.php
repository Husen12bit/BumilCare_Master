@extends('layouts.app')

@section('title', 'Daftar Pasien')
@section('content')

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Pasien (Prioritas Risiko)</h2>
        <span class="text-xs text-gray-500">
            Total: {{ $patients->count() }} pasien
        </span>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Lahir</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">HPL</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skrining Terakhir</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($patients as $i => $patient)
                    @php
                        $status = $patient->latestScreening?->risk_status?->value ?? 'hijau';
                        $rowClass = match ($status) {
                            'merah' => 'bg-red-50',
                            'kuning' => 'bg-yellow-50',
                            default => 'bg-white',
                        };
                        $badgeClass = match ($status) {
                            'merah' => 'bg-red-100 text-red-800',
                            'kuning' => 'bg-yellow-100 text-yellow-800',
                            default => 'bg-green-100 text-green-800',
                        };
                        $badgeLabel = match ($status) {
                            'merah' => 'MERAH',
                            'kuning' => 'KUNING',
                            default => 'HIJAU',
                        };
                    @endphp
                    <tr class="{{ $rowClass }} hover:bg-opacity-75 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $i + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $patient->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $patient->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $patient->tanggal_lahir->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $patient->hpl?->format('d M Y') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $patient->latestScreening?->created_at?->format('d M Y H:i') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                {{ $badgeLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <a href="{{ route('patients.show', $patient) }}"
                               class="text-sm text-blue-600 hover:underline font-medium">
                                Detail →
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                            Belum ada data pasien.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
