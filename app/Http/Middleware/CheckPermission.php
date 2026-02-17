<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permiso)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->can($permiso)) {
            return response()->view('errors.no_permission', [], 403);
        }


        return $next($request);
    }
}
