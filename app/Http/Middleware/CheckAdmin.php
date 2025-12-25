<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * Kiểm tra đăng nhập
         */

        if (!Auth::check()) {
            return response()->json([
                'message' => 'Bạn chưa đăng nhập',
            ], 401);
        }

        $user = Auth::user();

        /**
         * Kiểm tra xem có phải tài khoản Admin không
         */

        if (!($user instanceof Admin)) {
            return response()->json([
                'message' => 'Bạn không có quyền quản trị (Admin access only)',
            ], 403);
        }

        return $next($request);
    }
}
