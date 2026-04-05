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
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    // 1️⃣ Autentikasi user
    $request->authenticate();

    // 2️⃣ Regenerasi session
    $request->session()->regenerate();

    // 3️⃣ Ambil user yang login
    $user = Auth::user();

    // 4️⃣ Cek role_id (default ke 2 kalau null)
    $roleId = $user->role_id ?? 2;

    // 5️⃣ Redirect admin kalau role_id = 1
    if ($roleId == 1) {
        return redirect()->route('admin.dashboard');
    }

    // 6️⃣ Redirect petugas
    if ($roleId == 3) {
        return redirect()->route('petugas.dashboard');
    }

    // 6️⃣ Redirect user biasa
    return redirect()->route('home');
}


    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda telah logout.');
    }
}
