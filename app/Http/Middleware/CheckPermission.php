<?php

namespace App\Http\Middleware;

use App\Helpers\PermissionHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        // Not logged in — let the auth middleware handle it
        if (! $user) {
            return $next($request);
        }

        if (! PermissionHelper::can($permission)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You do not have permission to perform this action.',
                ], 403);
            }

            return response()->view('errors.permission-denied', [
                'role'       => $user->role ?? 'Unknown',
                'permission' => $permission,
            ], 403);
        }

        return $next($request);
    }
}
