<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Patient;
use App\Models\Screening;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Nakes
        User::create([
            'name' => 'Bidan Yeny',
            'email' => 'nakes@bumilcare.test',
            'password' => Hash::make('password'),
            'role' => UserRole::NAKES,
        ]);

        // Bumil 1: Risiko MERAH
        $bumil1 = User::create([
            'name' => 'Ibu Ani',
            'email' => 'ani@bumilcare.test',
            'password' => Hash::make('password'),
            'role' => UserRole::BUMIL,
        ]);
        $p1 = Patient::create([
            'user_id' => $bumil1->id,
            'tanggal_lahir' => '1998-05-15',
            'hpl' => '2026-01-20',
            'tinggi_badan' => 158.5,
        ]);
        Screening::create([
            'patient_id' => $p1->id,
            'tensi_sistol' => 165,
            'tensi_diastol' => 110,
            'hb_level' => 6.5,
            'keluhan' => ['perdarahan', 'pusing'],
            'risk_status' => 'merah',
        ]);

        // Bumil 2: Risiko KUNING
        $bumil2 = User::create([
            'name' => 'Ibu Budi',
            'email' => 'budi@bumilcare.test',
            'password' => Hash::make('password'),
            'role' => UserRole::BUMIL,
        ]);
        $p2 = Patient::create([
            'user_id' => $bumil2->id,
            'tanggal_lahir' => '2000-08-10',
            'hpl' => '2026-02-15',
            'tinggi_badan' => 160.0,
        ]);
        Screening::create([
            'patient_id' => $p2->id,
            'tensi_sistol' => 145,
            'tensi_diastol' => 95,
            'hb_level' => 10.5,
            'keluhan' => ['pusing'],
            'risk_status' => 'kuning',
        ]);

        // Bumil 3: Risiko HIJAU
        $bumil3 = User::create([
            'name' => 'Ibu Citra',
            'email' => 'citra@bumilcare.test',
            'password' => Hash::make('password'),
            'role' => UserRole::BUMIL,
        ]);
        $p3 = Patient::create([
            'user_id' => $bumil3->id,
            'tanggal_lahir' => '1999-03-22',
            'hpl' => '2026-03-10',
            'tinggi_badan' => 155.0,
        ]);
        Screening::create([
            'patient_id' => $p3->id,
            'tensi_sistol' => 115,
            'tensi_diastol' => 75,
            'hb_level' => 12.5,
            'keluhan' => [],
            'risk_status' => 'hijau',
        ]);
    }
}
