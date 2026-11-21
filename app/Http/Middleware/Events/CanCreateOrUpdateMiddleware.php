<?php

namespace App\Http\Middleware\Events;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;

class CanCreateOrUpdateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /** @var ?Event $event */
        $event = $request->route()->parameter('event');

        abort_unless(
            $request->user()->can('events.create')
            && (empty($event) || $event->isCreatorOrCoauthor($request->user())),
            403
        );

        return $next($request);
    }
}
