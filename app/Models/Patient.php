<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patient extends Model
{
    protected $fillable = [
        'user_id', 'nik', 'tanggal_lahir', 'alamat', 'jumlah_anak',
        'hpht', 'hpl', 'tinggi_badan', 'berat_badan', 'lila', 'golongan_darah',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'hpht' => 'date',
            'hpl' => 'date',
            'tinggi_badan' => 'decimal:2',
            'berat_badan' => 'decimal:2',
            'lila' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

    public function latestScreening(): HasOne
    {
        return $this->hasOne(Screening::class)->latestOfMany();
    }

    /** Hitung usia kehamilan dalam minggu dari HPHT */
    public function usiaKehamilanMinggu(): ?int
    {
        if (! $this->hpht) return null;
        return (int) floor($this->hpht->diffInWeeks(now()));
    }

    /** Hitung HPL otomatis jika belum ada (rumus Naegele) */
    public function hitungHplOtomatis(): ?string
    {
        if (! $this->hpht) return null;
        return $this->hpht->copy()->addDays(280)->format('Y-m-d');
    }
}
