<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Restrict a route (or route group) to the given staff roles.
     * Usage: ->middleware('role:owner,manager')
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Owners always have full access to their own restaurant's back office.
        if ($user->role === 'owner' || in_array($user->role, $roles, true)) {
            return $next($request);
        }

        abort(403, 'You do not have permission to access this section.');
    }
}
