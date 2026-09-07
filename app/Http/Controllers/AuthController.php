<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectToDashboard();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:admin,siswa,bendahara,guru',
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'kelas_id' => $validated['kelas_id'] ?? null,
        ]);

        Auth::login($user);

        return $this->redirectToDashboard();
    }

    private function redirectToDashboard()
    {
        return match (Auth::user()->role) {
            'siswa' => redirect()->intended(route('siswa.dashboard')),
            'bendahara' => redirect()->intended(route('bendahara.dashboard')),
            'guru' => redirect()->intended(route('guru.dashboard')),
            'admin' => redirect()->intended(route('admin.dashboard')),
            default => abort(403, 'Role tidak memiliki dashboard.'),
        };
    }
}
