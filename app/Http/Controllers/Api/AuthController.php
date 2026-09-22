<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            // 1. Buat User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => UserRole::BUMIL,
            ]);

            // 2. Hitung HPL otomatis dari HPHT (rumus Naegele: +280 hari)
            $hpl = null;
            if ($request->filled('hpht')) {
                $hpl = \Carbon\Carbon::parse($request->hpht)->addDays(280)->format('Y-m-d');
            }

            // 3. Buat Patient
            Patient::create([
                'user_id' => $user->id,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'jumlah_anak' => $request->jumlah_anak ?? 0,
                'hpht' => $request->hpht,
                'hpl' => $hpl,
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
                'lila' => $request->lila,
            ]);

            // 4. Buat token
            $token = $user->createToken('bumil-app')->plainTextToken;

            return response()->json([
                'message' => 'Registrasi berhasil. Selamat datang di BumilCare!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role->value,
                ],
                'token' => $token,
            ], 201);
        });
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial tidak valid.'],
            ]);
        }

        if ($user->role !== UserRole::BUMIL) {
            return response()->json([
                'message' => 'Hanya akun bumil yang dapat mengakses API ini.',
            ], 403);
        }

        $token = $user->createToken('bumil-app')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->value,
            ],
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil.']);
    }
}
