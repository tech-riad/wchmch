<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WhmcsAdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login.form')
                ->with('error', 'Please login first');
        }

        if (!auth()->user()->is_admin) {
            abort(403, 'Access denied');
        }

        return $next($request);
    }
}
