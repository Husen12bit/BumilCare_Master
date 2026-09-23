@extends('web.layouts.app')

@section('title', 'Kontak Darurat')
@section('header-title', 'Kontak & Rujukan Darurat')
@section('header-subtitle', 'Simpan kontak penting ini')

@section('content')

<div class="space-y-4">

    {{-- Panic Button --}}
    <div class="bg-red-50 border-2 border-red-400 rounded-2xl p-5 text-center">
        <div class="w-16 h-16 mx-auto bg-red-500 rounded-full flex items-center justify-center mb-3 animate-pulse">
            <span class="text-3xl">🚨</span>
        </div>
        <h2 class="text-lg font-bold text-red-700">PANIC BUTTON</h2>
        <p class="text-xs text-gray-600 mt-1 mb-4">
            Tekan jika Anda mengalami tanda bahaya kehamilan (perdarahan, kejang, sesak napas, dll)
        </p>

        <button onclick="kirimPanic()"
                class="w-full py-3 bg-red-600 text-white rounded-xl font-bold text-sm active:scale-[0.98] transition shadow-md">
            KIRIM TANDA BAHAYA
        </button>
    </div>

    {{-- Kontak Faskes --}}
    <div>
        <h2 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
            <span>📞</span> Kontak Faskes & Rujukan
        </h2>

        @php
            $kontak = [
                [
                    'nama' => 'Bidan Desa',
                    'ket' => 'Konsultasi & laporan skrining',
                    'telp' => '6285100697036',
                    'wa' => true,
                    'icon' => '👩‍⚕️',
                ],
                [
                    'nama' => 'RSUD Madiun',
                    'ket' => 'Rumah Sakit Rujukan',
                    'telp' => '0351464325',
                    'wa' => false,
                    'icon' => '🏥',
                ],
                [
                    'nama' => 'RSUD Magetan',
                    'ket' => 'Rumah Sakit Rujukan',
                    'telp' => '0351895023',
                    'wa' => false,
                    'icon' => '🏥',
                ],
            ];
        @endphp

        <div class="space-y-2">
            @foreach ($kontak as $k)
                <a href="{{ $k['wa'] ? 'https://wa.me/' . $k['telp'] : 'tel:' . $k['telp'] }}"
                   class="flex items-center gap-3 bg-white rounded-2xl p-4 shadow-sm active:bg-gray-50 transition">
                    <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center text-2xl">
                        {{ $k['icon'] }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 text-sm">{{ $k['nama'] }}</p>
                        <p class="text-xs text-gray-500">{{ $k['ket'] }}</p>
                        <p class="text-xs text-teal-600 mt-0.5 font-medium">{{ $k['telp'] }}</p>
                    </div>
                    <span class="text-teal-500 text-xl">→</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Info Tanda Bahaya --}}
    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4">
        <h3 class="text-sm font-bold text-yellow-800 mb-2">⚠️ Tanda Bahaya Kehamilan</h3>
        <ul class="text-xs text-yellow-800 space-y-1 list-disc list-inside">
            <li>Perdarahan dari jalan lahir</li>
            <li>Nyeri kepala hebat & pandangan kabur</li>
            <li>Bengkak kaki, tangan, atau wajah</li>
            <li>Kejang</li>
            <li>Gerakan bayi berkurang/hilang</li>
            <li>Ketuban pecah dini</li>
        </ul>
    </div>

</div>

@push('scripts')
<script>
function kirimPanic() {
    if (!confirm('Anda yakin ingin mengirim sinyal DARURAT ke Bidan?')) return;

    const text = encodeURIComponent(
        '🚨 *DARURAT KEHAMILAN* 🚨\n\n' +
        'Saya mengalami tanda bahaya kehamilan.\n' +
        'Mohon bantuan segera.\n\n' +
        'Waktu: ' + new Date().toLocaleString('id-ID') + '\n' +
        'Mohon balas secepatnya.'
    );

    window.open('https://wa.me/6285100697036?text=' + text, '_blank');
}
</script>
@endpush

@endsection
