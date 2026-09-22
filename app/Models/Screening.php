<?php

namespace App\Models;

use App\Enums\RiskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Screening extends Model
{
    protected $fillable = [
        'patient_id', 'usia_kehamilan_minggu', 'berat_badan', 'lila',
        'tensi_sistol', 'tensi_diastol', 'hb_level',
        'keluhan', 'ttd_7_hari_terakhir', 'risk_status',
    ];

    protected function casts(): array
    {
        return [
            'keluhan' => 'array',
            'risk_status' => RiskStatus::class,
            'hb_level' => 'decimal:1',
            'berat_badan' => 'decimal:2',
            'lila' => 'decimal:2',
            'ttd_7_hari_terakhir' => 'boolean',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
