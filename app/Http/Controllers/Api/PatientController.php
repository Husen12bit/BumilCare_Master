<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $patient = $request->user()->patient?->load('user');

        if (! $patient) {
            return response()->json(['data' => null]);
        }

        return response()->json([
            'data' => [
                'id' => $patient->id,
                'nama' => $patient->user->name,
                'umur' => $patient->tanggal_lahir->age,
                'alamat' => $patient->alamat,
                'jumlah_anak' => $patient->jumlah_anak,
                'hpht' => $patient->hpht?->format('Y-m-d'),
                'hpl' => $patient->hpl?->format('Y-m-d'),
                'tinggi_badan' => $patient->tinggi_badan,
                'berat_badan' => $patient->berat_badan,
                'lila' => $patient->lila,
                'usia_kehamilan_minggu' => $patient->usiaKehamilanMinggu(),
            ],
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'alamat' => ['nullable', 'string', 'max:255'],
            'jumlah_anak' => ['nullable', 'integer', 'min:0', 'max:20'],
            'hpht' => ['nullable', 'date', 'before:today'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:100', 'max:220'],
            'berat_badan' => ['nullable', 'numeric', 'min:20', 'max:200'],
            'lila' => ['nullable', 'numeric', 'min:10', 'max:50'],
        ]);

        $patient = $request->user()->patient;

        if (! $patient) {
            return response()->json(['message' => 'Profil tidak ditemukan.'], 404);
        }

        // Hitung HPL otomatis jika HPHT diisi
        if (!empty($validated['hpht'])) {
            $validated['hpl'] = \Carbon\Carbon::parse($validated['hpht'])->addDays(280)->format('Y-m-d');
        }

        $patient->update($validated);

        return response()->json(['message' => 'Profil diperbarui.', 'data' => $patient->fresh()]);
    }
}
