<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Jika sudah login dan mencoba ke halaman login/register,
     * arahkan ke dashboard sesuai role.
     */
    public function handle(Request $request, Closure $next, string|null ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // Arahkan berdasarkan role user
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->role === 'kepala_sekolah') {
                    return redirect()->route('kepala-sekolah.dashboard');
                } else {
                    return redirect()->route('siswa.dashboard');
                }
            }
        }

        return $next($request);
    }
}
