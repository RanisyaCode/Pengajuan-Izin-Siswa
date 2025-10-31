<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // =========================
    // LOGIN & LOGOUT
    // =========================
    public function login() { 
        return view('auth.login');
    }

    public function loginProses(Request $request) {
        $request->validate([
            'email'    => 'required',
            'password' => 'required|min:8',
        ],[
            'email.required'    => 'Email Tidak Boleh Kosong',
            'password.required' => 'Password Tidak Boleh Kosong',
            'password.min'      => 'Password Minimal 8 Karakter',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard')->with('success', 'Anda Berhasil Login');
        }

        return redirect()->back()->with('error', 'Email atau Password Salah');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda Berhasil Logout');
    }

   // =========================
    // REGISTER
    // =========================
    public function register()
    {
        return view('auth.register');
    }

    public function registerProses(Request $request)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'min:3',
                'max:50',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'kelas' => [
                'required',
                'string',
                'max:20',
            ],
        ], [
            'nama.required'      => 'Nama tidak boleh kosong',
            'nama.min'           => 'Nama minimal 3 karakter',
            'nama.max'           => 'Nama maksimal 50 karakter',

            'email.required'     => 'Email tidak boleh kosong',
            'email.email'        => 'Format email tidak valid',
            'email.unique'       => 'Email sudah terdaftar di sistem',

            'password.required'  => 'Password tidak boleh kosong',
            'password.min'       => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',

            'kelas.required'     => 'Kelas harus dipilih atau diisi',
        ]);

        // Simpan data user baru
        $user = \App\Models\User::create([
            'nama'     => trim($request->nama),
            'email'    => strtolower($request->email),
            'password' => bcrypt($request->password),
            'role'     => 'Siswa',
            'kelas'    => $request->kelas,
            'aksi'     => true,
        ]);

        // Login otomatis setelah register
        Auth::login($user);

        // Arahkan ke dashboard
        return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat dan Anda telah masuk ke sistem.');
    }

    // =========================
    // FORGOT PASSWORD
    // =========================
    public function forgot() {
        return view('auth.forgot-password');
    }

    public function forgotProses(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak terdaftar dalam sistem.',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // =========================
    // RESET PASSWORD
    // =========================
    public function resetPasswordForm($token, Request $request) {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email ?? '',
        ]);
    }

    public function resetPasswordProses(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password berhasil direset, silakan login.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}