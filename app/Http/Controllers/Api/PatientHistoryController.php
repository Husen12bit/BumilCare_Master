<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScreeningResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientHistoryController extends Controller
{
    /**
     * GET /api/patient/history
     */
    public function index(Request $request): JsonResponse
    {
        $patient = $request->user()->patient;

        if (! $patient) {
            return response()->json(['data' => []]);
        }

        $screenings = $patient->screenings()
            ->orderByDesc('created_at')
            ->paginate(15);

        return response()->json([
            'data' => ScreeningResource::collection($screenings),
            'meta' => [
                'current_page' => $screenings->currentPage(),
                'last_page' => $screenings->lastPage(),
                'total' => $screenings->total(),
            ],
        ]);
    }
}
