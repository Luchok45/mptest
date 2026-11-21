<?php

namespace App\Http\Middleware\Events;

use App\Enums\EventStatus;
use App\Models\Event;
use Closure;
use Illuminate\Http\Request;

class CheckStatusMiddleware
{
    public function handle(Request $request, Closure $next, ...$statuses)
    {
        /** @var ?Event $event */
        $event = $request->route()->parameter('event');

        foreach ($statuses as $status) {
            if (EventStatus::tryFrom($status) === $event->status) {
                return $next($request);
            }
        }

        abort(418);
    }
}
