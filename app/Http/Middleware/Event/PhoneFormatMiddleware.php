<?php

namespace App\Http\Middleware\Event;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PhoneFormatMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $phone = Str::swap([
            '+' => '',
            ' ' => '',
            '(' => '',
            ')' => '',
            '-' => '',
        ], $request->user_phone);

        $request->merge(['phone' => $phone]);
        return $next($request);
    }
}
