<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; // Tambahkan ini
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role = 'master_admin'): Response
    {
        if (!Auth::check() || !User::checkRole($role)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}