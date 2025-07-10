<?php
// app/Http/Middleware/RoleAdminMiddleware.php
namespace App\Http\Middleware;

use Closure;

class RoleAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->hasRole('admin')) {
            return $next($request);
        }
        abort(403);
    }
}

