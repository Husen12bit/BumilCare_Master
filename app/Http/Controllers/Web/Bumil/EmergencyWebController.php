<?php

namespace App\Http\Controllers\Web\Bumil;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class EmergencyWebController extends Controller
{
    public function index(): View
    {
        return view('web.emergency.index');
    }
}
