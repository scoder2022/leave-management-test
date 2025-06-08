<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRoleValidationMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check()) {
            $user = Auth::user();
           if (!$user->status) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account is inactive.');
            }

            // If role does not match, abort
            if ($user->role !== $role) {
                abort(403, 'Unauthorized access.');
            }

            return $next($request);
        }

        return redirect()->route('login');
    }
}
