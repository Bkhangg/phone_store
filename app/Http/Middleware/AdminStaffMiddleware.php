<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class AdminStaffMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            auth()->logout();
            return redirect('/')->with('error', 'Bạn không có quyền truy cập');
        }

        if (auth()->user()->status == 0) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Tài khoản đã bị khóa']);
        }

        return $next($request);
    }
}

