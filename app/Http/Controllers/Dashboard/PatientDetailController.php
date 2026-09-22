<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\View\View;

class PatientDetailController extends Controller
{
    /**
     * Tampilkan detail pasien + riwayat skrining lengkap.
     */
    public function show(Patient $patient): View
    {
        $patient->load([
            'user',
            'screenings' => fn ($q) => $q->orderByDesc('created_at'),
        ]);

        return view('dashboard.patient-show', compact('patient'));
    }
}
