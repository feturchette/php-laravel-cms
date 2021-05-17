<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\UserPermission;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $userRole = auth()->user()->role;
            $currentRouteName = Route::currentRouteName();

            if (
                UserPermission::isRoleHasRightToAccess($userRole, $currentRouteName) || 
                in_array($currentRouteName, $this->getUserAccess($userRole))
            ) {
                return $next($request);
            } else {
                abort(403, 'Unauthorized action');
            }
        } catch (\Throwable $th) {
            if ($userRole === 'admin') {
                return redirect('dashboard');
            } else {
                return redirect('/');
            }
        }
    }

    private function getUserAccess($userRole) {
        $access = [
            'admin' => [
                'dashboard',
                'users',
                'user-permissions',
                'dashboard',
                'pages',
                'navigation-menus'
            ],
        ];

        return $access[$userRole];
    }
}
