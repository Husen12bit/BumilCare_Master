@extends('web.layouts.app')

@section('title', 'Skrining Risiko')
@section('header-title', 'Skrining Risiko Tinggi')
@section('header-subtitle', 'Isi data sesuai kondisi Anda saat ini')

@section('content')

<div x-data="screeningApp()" x-cloak>

    <form @submit.prevent="submit" class="space-y-4">

        {{-- Data Skrining --}}
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <h2 class="text-sm font-bold text-teal-600 mb-3 flex items-center gap-2">
                <span>🩺</span> Data Skrining
            </h2>

            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Tekanan Darah Sistol (mmHg)</label>
                    <input type="number" x-model.number="form.tensi_sistol" min="50" max="300" required
                           class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 outline-none text-base"
                           placeholder="Contoh: 120">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Tekanan Darah Diastol (mmHg)</label>
                    <input type="number" x-model.number="form.tensi_diastol" min="30" max="200" required
                           class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 outline-none text-base"
                           placeholder="Contoh: 80">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Kadar Hb (g/dL)</label>
                    <input type="number" x-model.number="form.hb_level" step="0.1" min="2" max="20" required
                           class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 outline-none text-base"
                           placeholder="Contoh: 11.5">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">BB (kg)</label>
                        <input type="number" x-model.number="form.berat_badan" step="0.1"
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 outline-none text-base">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">LILA (cm)</label>
                        <input type="number" x-model.number="form.lila" step="0.1"
                               class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 outline-none text-base">
                    </div>
                </div>
            </div>
        </div>

        {{-- Keluhan --}}
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <h2 class="text-sm font-bold text-teal-600 mb-3 flex items-center gap-2">
                <span>⚠️</span> Keluhan / Tanda Bahaya
            </h2>

            <div class="space-y-1">
                <template x-for="k in daftarKeluhan" :key="k.value">
                    <label class="flex items-center gap-3 p-2.5 rounded-lg active:bg-gray-50 cursor-pointer">
                        <input type="checkbox" :value="k.value" x-model="form.keluhan"
                               class="w-5 h-5 text-teal-600 rounded focus:ring-teal-500">
                        <span class="text-sm text-gray-700" x-text="k.label"></span>
                    </label>
                </template>
            </div>
        </div>

        {{-- Tombol Submit --}}
        <button type="submit" :disabled="loading"
                class="w-full py-3.5 bg-teal-600 text-white rounded-xl font-semibold text-base active:scale-[0.98] transition shadow-md disabled:opacity-60 flex items-center justify-center gap-2">
            <svg x-show="loading" class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span x-text="loading ? 'Memproses...' : 'Cek Status Risiko'"></span>
        </button>
    </form>

    {{-- Hasil --}}
    <div x-show="result" x-transition class="mt-4">
        <div class="rounded-2xl p-5 border-2"
             :class="{
                'bg-red-50 border-red-500': result?.risk_status === 'merah',
                'bg-yellow-50 border-yellow-500': result?.risk_status === 'kuning',
                'bg-green-50 border-green-500': result?.risk_status === 'hijau'
             }">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-4 h-4 rounded-full"
                      :class="{
                        'bg-red-500': result?.risk_status === 'merah',
                        'bg-yellow-500': result?.risk_status === 'kuning',
                        'bg-green-500': result?.risk_status === 'hijau'
                      }"></span>
                <span class="font-bold text-sm uppercase"
                      :class="{
                        'text-red-700': result?.risk_status === 'merah',
                        'text-yellow-700': result?.risk_status === 'kuning',
                        'text-green-700': result?.risk_status === 'hijau'
                      }"
                      x-text="'STATUS: ' + (result?.risk_label || '')"></span>
            </div>

            <p class="text-sm text-gray-700 leading-relaxed" x-text="result?.rekomendasi"></p>

            <div class="mt-4 grid grid-cols-3 gap-2 text-xs">
                <div class="bg-white/60 rounded-lg p-2">
                    <p class="text-gray-500">TD</p>
                    <p class="font-bold text-gray-800" x-text="result?.tensi_sistol + '/' + result?.tensi_diastol"></p>
                </div>
                <div class="bg-white/60 rounded-lg p-2">
                    <p class="text-gray-500">Hb</p>
                    <p class="font-bold text-gray-800" x-text="result?.hb_level + ' g/dL'"></p>
                </div>
                <div class="bg-white/60 rounded-lg p-2">
                    <p class="text-gray-500">Keluhan</p>
                    <p class="font-bold text-gray-800" x-text="(result?.keluhan || []).length + ' item'"></p>
                </div>
            </div>

            <button @click="shareWA"
                    class="mt-4 w-full py-2.5 bg-green-500 text-white rounded-xl font-semibold text-sm active:scale-[0.98] transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.71.306 1.263.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.29.173-1.414-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Kirim Hasil ke Bidan via WhatsApp
            </button>
        </div>
    </div>

    {{-- Riwayat --}}
    @if ($screenings->isNotEmpty())
    <div class="mt-6">
        <h3 class="text-sm font-bold text-gray-700 mb-3">Riwayat Skrining Terakhir</h3>
        <div class="space-y-2">
            @foreach ($screenings as $s)
                @php
                    $badgeClass = match ($s->risk_status->value) {
                        'merah' => 'bg-red-100 text-red-800',
                        'kuning' => 'bg-yellow-100 text-yellow-800',
                        default => 'bg-green-100 text-green-800',
                    };
                @endphp
                <div class="bg-white rounded-xl p-3 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">{{ $s->created_at->format('d M Y, H:i') }}</p>
                        <p class="text-sm font-medium text-gray-800 mt-0.5">
                            {{ $s->tensi_sistol }}/{{ $s->tensi_diastol }} mmHg · Hb {{ $s->hb_level }}
                        </p>
                    </div>
                    <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $badgeClass }}">
                        {{ strtoupper($s->risk_status->value) }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script>
function screeningApp() {
    return {
        loading: false,
        result: null,
        form: {
            tensi_sistol: '',
            tensi_diastol: '',
            hb_level: '',
            berat_badan: '',
            lila: '',
            keluhan: [],
        },
        daftarKeluhan: [
            { value: 'demam_tinggi', label: 'Demam tinggi' },
            { value: 'nyeri_perut_hebat', label: 'Nyeri perut hebat' },
            { value: 'mual_muntah_hebat', label: 'Mual dan muntah hebat' },
            { value: 'nyeri_kepala_hebat', label: 'Nyeri kepala hebat' },
            { value: 'pandangan_kabur', label: 'Pandangan kabur' },
            { value: 'bengkak_kaki_muka', label: 'Bengkak kaki/muka' },
            { value: 'perdarahan', label: 'Perdarahan' },
            { value: 'gerakan_bayi_kurang', label: 'Gerakan bayi tidak ada/kurang' },
            { value: 'batuk_lama', label: 'Batuk lama > 2 minggu' },
            { value: 'diare_berulang', label: 'Diare berulang' },
        ],

        async submit() {
            this.loading = true;
            this.result = null;

            try {
                const res = await fetch('{{ route('bumil.screening.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.form),
                });

                const data = await res.json();

                if (!res.ok) throw new Error(data.message || 'Gagal menyimpan data');

                this.result = data.data;

                // Scroll ke hasil
                setTimeout(() => {
                    this.$el.querySelector('[x-show="result"]')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 100);

            } catch (err) {
                alert('Error: ' + err.message);
            } finally {
                this.loading = false;
            }
        },

        shareWA() {
            if (!this.result) return;

            const keluhanText = (this.result.keluhan || []).length > 0
                ? this.result.keluhan.join(', ')
                : 'Tidak ada';

            const text = `Assalamualaikum Bidan, saya mau laporan hasil skrining BumilCare:%0A%0A` +
                `Status: ${this.result.risk_label.toUpperCase()}%0A` +
                `TD: ${this.result.tensi_sistol}/${this.result.tensi_diastol} mmHg%0A` +
                `Hb: ${this.result.hb_level} g/dL%0A` +
                `Keluhan: ${keluhanText}%0A%0A` +
                `Mohon arahan. Terima kasih.`;

            window.open(`https://wa.me/6285100697036?text=${text}`, '_blank');
        }
    }
}
</script>
@endpush

@endsection
