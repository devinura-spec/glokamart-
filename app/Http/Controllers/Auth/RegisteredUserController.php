<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan form register
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Simpan data register
     */
   public function store(Request $request)
{
    // 1. Validasi input user
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Password::defaults()],
    ]);

    // 2. Simpan user baru
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // 3. Buat detail user otomatis
    $user->detail()->create([
        'address' => null,
        'city' => null,
        'postal_code' => null,
        'phone' => null,
        'photo' => null,
    ]);

    // 4. Redirect ke halaman login dengan pesan sukses
    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
}

}
