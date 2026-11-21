<?php

namespace App\Http\Middleware\Events;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;

class CanViewMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /** @var ?Event $event */
        $event = $request->route()->parameter('event');
        abort_if(empty($event) && ! $request->routeIs('events.my'), 404);

        abort_unless(
            $request->user()->can('events.view.all')
                || ($request->user()->can('events.view.my') && $request->routeIs('events.my'))
                || ($request->user()->can('events.view.my') && $event?->isCreatorOrCoauthor($request->user())),
            403
        );

        return $next($request);
    }
}
