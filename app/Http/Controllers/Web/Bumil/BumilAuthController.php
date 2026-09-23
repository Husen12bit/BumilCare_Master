<?php

namespace App\Http\Controllers\Web\Bumil;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class BumilAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('web.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        $request->session()->regenerate();

        if (Auth::user()->role !== UserRole::BUMIL) {
            Auth::logout();
            return back()->withErrors(['email' => 'Akun ini bukan akun bumil.']);
        }

        return redirect()->intended(route('bumil.screening'));
    }

    public function showRegister(): View
    {
        return view('web.auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'jumlah_anak' => ['nullable', 'integer', 'min:0', 'max:20'],
            'hpht' => ['nullable', 'date', 'before:today'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:100', 'max:220'],
            'berat_badan' => ['nullable', 'numeric', 'min:20', 'max:200'],
            'lila' => ['nullable', 'numeric', 'min:10', 'max:50'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => UserRole::BUMIL,
            ]);

            $hpl = ! empty($validated['hpht'])
                ? \Carbon\Carbon::parse($validated['hpht'])->addDays(280)->format('Y-m-d')
                : null;

            Patient::create([
                'user_id' => $user->id,
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'alamat' => $validated['alamat'] ?? null,
                'jumlah_anak' => $validated['jumlah_anak'] ?? 0,
                'hpht' => $validated['hpht'] ?? null,
                'hpl' => $hpl,
                'tinggi_badan' => $validated['tinggi_badan'] ?? null,
                'berat_badan' => $validated['berat_badan'] ?? null,
                'lila' => $validated['lila'] ?? null,
            ]);

            Auth::login($user);
        });

        return redirect()->route('bumil.screening')
            ->with('success', 'Registrasi berhasil. Selamat datang di BumilCare!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('bumil.login');
    }

    public function showProfile(): View
    {
        $patient = Auth::user()->patient;
        return view('web.profile.index', compact('patient'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'alamat' => ['nullable', 'string', 'max:255'],
            'jumlah_anak' => ['nullable', 'integer', 'min:0', 'max:20'],
            'hpht' => ['nullable', 'date', 'before:today'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:100', 'max:220'],
            'berat_badan' => ['nullable', 'numeric', 'min:20', 'max:200'],
            'lila' => ['nullable', 'numeric', 'min:10', 'max:50'],
        ]);

        if (! empty($validated['hpht'])) {
            $validated['hpl'] = \Carbon\Carbon::parse($validated['hpht'])->addDays(280)->format('Y-m-d');
        }

        Auth::user()->patient?->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
