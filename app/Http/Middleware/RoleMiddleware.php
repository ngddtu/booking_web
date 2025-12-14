<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();

        // Convert role names to integers if passed as strings (optional, tailored to current User model constants)
        $roleIds = [];
        foreach ($roles as $role) {
            if ($role === 'manager') $roleIds[] = \App\Models\User::ROLE_MANAGER;
            if ($role === 'saler') $roleIds[] = \App\Models\User::ROLE_SALER;
            if (is_numeric($role)) $roleIds[] = (int)$role;
        }

        if (in_array($user->role, $roleIds)) {
            return $next($request);
        }

        // If manager, allow access to everything (as per requirement "admin thì tất cả")
        // NOTE: The user said "admin thì tất cả" (admin accesses everything). 
        // If the current user is a manager, they should bypass the check for saler routes?
        // Or we just ensures manager is included in the allowed roles for those routes?
        // Let's explicitly handle the "admin accesses everything" requirement here.
        if ($user->role === \App\Models\User::ROLE_MANAGER) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
