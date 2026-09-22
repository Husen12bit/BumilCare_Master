<?php

namespace App\Services;

use App\Enums\RiskStatus;

class RiskAssessmentService
{
    /**
     * Daftar keluhan tanda bahaya sesuai pedoman Kemenkes & input Nakes.
     */
    public const KELUHAN_MERAH = [
        'perdarahan',
        'nyeri_perut_hebat',
        'nyeri_kepala_hebat',
        'pandangan_kabur',
        'gerakan_bayi_kurang',
        'demam_tinggi',
        'mual_muntah_hebat',
    ];

    public const KELUHAN_KUNING = [
        'bengkak_kaki_muka',
        'batuk_lama',
        'diare_berulang',
        'pusing',
        'mual',
        'demam',
    ];

    public function assess(
        int $sistol,
        int $diastol,
        float $hbLevel,
        array $keluhan = [],
        ?float $lila = null,
        ?int $usiaKehamilan = null,
    ): RiskStatus {
        // ============ FAKTOR RISIKO MERAH ============
        if ($sistol >= 160 || $diastol >= 110) return RiskStatus::MERAH; // Hipertensi berat
        if ($sistol <= 90 || $diastol <= 60) return RiskStatus::MERAH;   // Hipotensi
        if ($hbLevel < 7.0) return RiskStatus::MERAH;                    // Anemia berat

        if (!empty(array_intersect($keluhan, self::KELUHAN_MERAH))) {
            return RiskStatus::MERAH;
        }

        // Preeklamsia: hipertensi + keluhan neurologis
        $gejalaPreeklamsia = ['nyeri_kepala_hebat', 'pandangan_kabur'];
        if (($sistol >= 140 || $diastol >= 90) && !empty(array_intersect($keluhan, $gejalaPreeklamsia))) {
            return RiskStatus::MERAH;
        }

        // ============ FAKTOR RISIKO KUNING ============
        if ($sistol >= 140 || $diastol >= 90) return RiskStatus::KUNING; // Hipertensi
        if ($hbLevel < 11.0) return RiskStatus::KUNING;                  // Anemia
        if ($lila !== null && $lila < 23.5) return RiskStatus::KUNING;   // KEK (Kurang Energi Kronis)

        if (!empty(array_intersect($keluhan, self::KELUHAN_KUNING))) {
            return RiskStatus::KUNING;
        }

        // ============ HIJAU ============
        return RiskStatus::HIJAU;
    }

    /** Label keluhan untuk UI */
    public static function daftarKeluhan(): array
    {
        return [
            'demam_tinggi' => 'Demam tinggi',
            'nyeri_perut_hebat' => 'Nyeri perut hebat',
            'mual_muntah_hebat' => 'Mual dan muntah hebat',
            'nyeri_kepala_hebat' => 'Nyeri kepala hebat',
            'pandangan_kabur' => 'Pandangan kabur',
            'bengkak_kaki_muka' => 'Bengkak kaki/muka',
            'perdarahan' => 'Perdarahan',
            'gerakan_bayi_kurang' => 'Gerakan bayi tidak ada/kurang',
            'batuk_lama' => 'Batuk lama > 2 minggu',
            'diare_berulang' => 'Diare berulang',
        ];
    }
}
