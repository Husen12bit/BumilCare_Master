<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScreeningRequest;
use App\Http\Resources\ScreeningResource;
use App\Services\RiskAssessmentService;
use Illuminate\Http\JsonResponse;

class ScreeningController extends Controller
{
    public function __construct(
        private RiskAssessmentService $riskService
    ) {}

    /**
     * POST /api/screening
     * Alur: validasi → hitung risk_status → simpan → return resource
     */
    public function store(StoreScreeningRequest $request): JsonResponse
    {
        $patient = $request->user()->patient;

        if (! $patient) {
            return response()->json([
                'message' => 'Profil pasien belum lengkap. Silakan isi data terlebih dahulu.',
            ], 404);
        }

        $riskStatus = $this->riskService->assess(
            sistol: $request->integer('tensi_sistol'),
            diastol: $request->integer('tensi_diastol'),
            hbLevel: $request->float('hb_level'),
            keluhan: $request->input('keluhan', []),
            lila: $request->float('lila'),
            usiaKehamilan: $request->integer('usia_kehamilan_minggu'),
        );

        $screening = $patient->screenings()->create([
            'usia_kehamilan_minggu' => $request->usia_kehamilan_minggu,
            'berat_badan' => $request->berat_badan,
            'lila' => $request->lila,
            'tensi_sistol' => $request->tensi_sistol,
            'tensi_diastol' => $request->tensi_diastol,
            'hb_level' => $request->hb_level,
            'keluhan' => $request->keluhan ?? [],
            'ttd_7_hari_terakhir' => $request->boolean('ttd_7_hari_terakhir'),
            'risk_status' => $riskStatus,
        ]);

        return response()->json([
            'message' => 'Skrining berhasil disimpan.',
            'data' => new ScreeningResource($screening),
        ], 201);
    }
}
