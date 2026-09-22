<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScreeningRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'usia_kehamilan_minggu' => ['nullable', 'integer', 'min:1', 'max:42'],
            'berat_badan' => ['nullable', 'numeric', 'min:20', 'max:200'],
            'lila' => ['nullable', 'numeric', 'min:10', 'max:50'],
            'tensi_sistol' => ['required', 'integer', 'min:50', 'max:300'],
            'tensi_diastol' => ['required', 'integer', 'min:30', 'max:200'],
            'hb_level' => ['required', 'numeric', 'min:2', 'max:20'],
            'keluhan' => ['nullable', 'array'],
            'keluhan.*' => ['string', 'in:demam_tinggi,nyeri_perut_hebat,mual_muntah_hebat,nyeri_kepala_hebat,pandangan_kabur,bengkak_kaki_muka,perdarahan,gerakan_bayi_kurang,batuk_lama,diare_berulang'],
            'ttd_7_hari_terakhir' => ['boolean'],
        ];
    }
}
