<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdminType
{
    /**
     * Handle an incoming request.
     * Expect a role parameter like 'Admin' or 'SuperAdmin'.
     */
    public function handle(Request $request, Closure $next, $requiredType)
    {
        $user = auth('admin')->user();
        if (!$user) {
            return redirect()->route('admin.login');
        }

        $type = strtolower($user->admin_type ?? '');
        if (strtolower($requiredType) !== $type) {
            // If user is superadmin but required Admin, redirect to their dashboard
            if ($type === 'superadmin') {
                return redirect()->route('super-admin.dashboard');
            }
            // Otherwise, send to admin dashboard
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
