<?php

namespace App\Http\Controllers\Web\Bumil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KiaWebController extends Controller
{
    public function index(): View
    {
        $patient = Auth::user()->patient;
        return view('web.kia.index', compact('patient'));
    }

    public function updateTtd(Request $request)
    {
        // Untuk fitur ceklis TTD 7 hari terakhir
        // Simpan di session atau kolom baru (sesuai kebutuhan)
        $request->validate(['ttd_hari' => ['required', 'array', 'size:7']]);
        session(['ttd_hari' => $request->ttd_hari]);

        return response()->json(['success' => true, 'message' => 'Catatan TTD tersimpan.']);
    }
}
