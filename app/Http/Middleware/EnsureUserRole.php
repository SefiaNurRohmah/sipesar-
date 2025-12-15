<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth; // ← WAJIB ini!

class EnsureUserRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();  // sekarang valid

        if (!$user) {
            return redirect()->route('login');
        }

        if (!in_array($user->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki akses untuk halaman ini.');
        }

        return $next($request);
    }
}
