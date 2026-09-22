<?php

namespace App\Enums;

enum RiskStatus: string
{
    case HIJAU = 'hijau';
    case KUNING = 'kuning';
    case MERAH = 'merah';

    public function label(): string
    {
        return match ($this) {
            self::HIJAU => 'Risiko Rendah',
            self::KUNING => 'Risiko Sedang',
            self::MERAH => 'Risiko Tinggi',
        };
    }
}
