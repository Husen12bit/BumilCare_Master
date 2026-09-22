<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\RiskStatus;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Screening;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Ambil ID screening terbaru per pasien
        $latestIds = Screening::selectRaw('MAX(id)')
            ->groupBy('patient_id');

        $stats = Screening::whereIn('id', $latestIds)
            ->selectRaw('risk_status, COUNT(*) as total')
            ->groupBy('risk_status')
            ->pluck('total', 'risk_status');

        $data = [
            'merah' => $stats[RiskStatus::MERAH->value] ?? 0,
            'kuning' => $stats[RiskStatus::KUNING->value] ?? 0,
            'hijau' => $stats[RiskStatus::HIJAU->value] ?? 0,
        ];

        // Daftar pasien dengan screening terbaru berstatus MERAH
        $alerts = Patient::with(['user', 'latestScreening'])
            ->whereHas('latestScreening', fn ($q) => $q->where('risk_status', RiskStatus::MERAH->value))
            ->take(5)
            ->get();

        return view('dashboard.index', compact('data', 'alerts'));
    }
}
