<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministrativoController extends Controller
{
    public function dashboard()
    {
        return view('administrativo.dashboard');
    }
}
