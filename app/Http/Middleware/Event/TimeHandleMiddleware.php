<?php

namespace App\Http\Middleware\Event;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeHandleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        [$timeStart, $timeEnd] = explode(' - ', $request->time);

        $startsAt = Carbon::parse("{$request->date} $timeStart");
        $endsAt = Carbon::parse("{$request->date} $timeEnd");

        if ($timeStart > $timeEnd) {
            $endsAt->addDay();
        }

        $request->merge([
            'starts_at' => $startsAt->format('Y-m-d H:i:s'),
            'ends_at' => $endsAt->format('Y-m-d H:i:s'),
        ]);

        return $next($request);
    }
}
