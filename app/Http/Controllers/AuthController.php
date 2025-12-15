<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Announcement;
use App\Models\Registration;

class AuthController extends Controller
{
    // Halaman utama
    public function welcome()
    {
        // Some dynamic data for the landing page
        $announcements = Announcement::active()->orderBy('created_at', 'desc')->limit(3)->get();
        $totalRegistrations = Registration::count();
        $accepted = Registration::where('status', 'diterima')->count();
        $pending = Registration::where('status', 'menunggu keputusan')->count();

        return view('welcome', compact('announcements', 'totalRegistrations', 'accepted', 'pending'));
    }

    // Tampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'hp' => 'required|string|max:20|unique:users,hp',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'hp' => $data['hp'],
            'password' => Hash::make($data['password']),
            'role' => 'siswa', // default role
        ]);

        // Dispatch event UserRegistered
        UserRegistered::dispatch($user);

        // Jangan auto-login — arahkan ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('status', 'Akun berhasil dibuat. Silakan login.');
    }

    // Tampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Proses login - BISA MENGGUNAKAN EMAIL ATAU HP
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string', // Ganti dari 'email' menjadi 'login'
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        // Tentukan apakah input adalah email atau nomor HP
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'hp';

        // Coba login dengan kredensial yang sesuai
        $attemptCredentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($attemptCredentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user) {
                if ($user->role === 'admin') {
                    return redirect()->intended(route('admin.dashboard'));
                } elseif ($user->role === 'kepala_sekolah') {
                    return redirect()->intended(route('kepala-sekolah.dashboard'));
                }
            }

            return redirect()->intended(route('siswa.dashboard'));
        }

        return back()->withErrors([
            'login' => 'Email/Nomor HP atau password salah'
        ])->onlyInput('login');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}
