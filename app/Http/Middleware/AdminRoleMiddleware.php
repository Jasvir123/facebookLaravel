<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

use App\Models\Role;

class AdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        $roles = Role::get();

        // dd($user->hasAnyRole($roles));
        if ($user && $user->hasAnyRole(['admin'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
