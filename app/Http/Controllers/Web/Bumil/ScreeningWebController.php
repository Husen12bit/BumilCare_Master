<?php

namespace App\Http\Controllers\Web\Bumil;

use App\Http\Controllers\Controller;
use App\Services\RiskAssessmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ScreeningWebController extends Controller
{
    public function __construct(private RiskAssessmentService $riskService) {}

    public function index(): View
    {
        $patient = Auth::user()->patient;
        $screenings = $patient?->screenings()->orderByDesc('created_at')->take(10)->get() ?? collect();

        return view('web.screening.index', compact('patient', 'screenings'));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tensi_sistol' => ['required', 'integer', 'min:50', 'max:300'],
            'tensi_diastol' => ['required', 'integer', 'min:30', 'max:200'],
            'hb_level' => ['required', 'numeric', 'min:2', 'max:20'],
            'berat_badan' => ['nullable', 'numeric', 'min:20', 'max:200'],
            'lila' => ['nullable', 'numeric', 'min:10', 'max:50'],
            'keluhan' => ['nullable', 'array'],
            'keluhan.*' => ['string'],
        ]);

        $patient = Auth::user()->patient;
        if (! $patient) {
            return response()->json(['message' => 'Profil belum lengkap.'], 404);
        }

        $riskStatus = $this->riskService->assess(
            sistol: $validated['tensi_sistol'],
            diastol: $validated['tensi_diastol'],
            hbLevel: (float) $validated['hb_level'],
            keluhan: $validated['keluhan'] ?? [],
            lila: isset($validated['lila']) ? (float) $validated['lila'] : null,
        );

        $screening = $patient->screenings()->create([
            'tensi_sistol' => $validated['tensi_sistol'],
            'tensi_diastol' => $validated['tensi_diastol'],
            'hb_level' => $validated['hb_level'],
            'berat_badan' => $validated['berat_badan'] ?? null,
            'lila' => $validated['lila'] ?? null,
            'keluhan' => $validated['keluhan'] ?? [],
            'risk_status' => $riskStatus,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Skrining berhasil disimpan.',
            'data' => [
                'id' => $screening->id,
                'risk_status' => $riskStatus->value,
                'risk_label' => $riskStatus->label(),
                'tensi_sistol' => $screening->tensi_sistol,
                'tensi_diastol' => $screening->tensi_diastol,
                'hb_level' => $screening->hb_level,
                'keluhan' => $screening->keluhan,
                'rekomendasi' => $this->getRekomendasi($riskStatus->value),
            ],
        ]);
    }

    private function getRekomendasi(string $status): string
    {
        return match ($status) {
            'merah' => 'SEGERA ke faskes/RS terdekat. Anda berisiko tinggi (preeklamsia/anemia berat). Hubungi bidan sekarang.',
            'kuning' => 'Periksa ke bidan/puskesmas dalam 1-2 hari. Perhatikan asupan gizi dan istirahat cukup.',
            default => 'Kondisi Anda baik. Lanjutkan kunjungan ANC rutin dan konsumsi Tablet Tambah Darah.',
        };
    }
}
