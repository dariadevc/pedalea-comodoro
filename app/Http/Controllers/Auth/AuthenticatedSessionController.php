<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
    
        $request->session()->regenerate();
    
        $authenticatedUser = Auth::user();
    
        // Redirigir según el rol
        if ($authenticatedUser->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($authenticatedUser->hasRole('cliente')) {
            return redirect()->route('cliente.dashboard');
        }
    
        // Redirigir a una ruta por defecto si no hay coincidencia de rol
        return redirect()->route('home'); // Cambia 'home' por tu ruta por defecto
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
