<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\View\View;

class PatientListController extends Controller
{
    public function index(): View
    {
        // Ambil semua pasien dengan screening terbaru, urutkan:
        // MERAH (0) → KUNING (1) → HIJAU (2)
        $patients = Patient::with(['user', 'latestScreening'])
            ->get()
            ->sortBy(function ($patient) {
                $priority = match ($patient->latestScreening?->risk_status?->value) {
                    'merah' => 0,
                    'kuning' => 1,
                    default => 2,
                };
                return $priority;
            })
            ->values();

        return view('dashboard.patients', compact('patients'));
    }
}
