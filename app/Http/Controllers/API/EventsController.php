<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Events\FullResource;
use App\Http\Resources\Events\MemberResource;
use App\Http\Resources\Events\ShortResource;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function all(Request $request)
    {
        return ShortResource::collection(
            Event::query()
                ->statusFilter($request->input('statuses', []))
                ->cursorPaginate()
        );
    }

    public function my()
    {
        return ShortResource::collection(
            Event::query()
                ->my()
                ->cursorPaginate(15)
        );
    }

    public function show(Event $event)
    {
        return FullResource::make($event)->resolve();
    }

    public function members(Event $event)
    {
        return MemberResource::collection(
            $event->members()
                ->with(['user'])
                ->paginate(15)
        );
    }

    public function addMemberFromQR(Event $event, Request $request)
    {
        try {
            $payload = $request->input('payload')
                |> base64_decode(...)
                |> function (string $str): array { return explode(';', $str); }
                |> function (array $elements): array {
                    $result = [];
                    foreach ($elements as $element) {
                        $parts = explode(':::', $element);
                        $result[$parts[0]] = $parts[1];
                    }
                    return $result;
                };

            if(Carbon::parse($payload['created_at']) <= now() && Carbon::parse($payload['expired_at']) >= now()) {
                $user = User::findOrFail($payload['user_id']);
                $member = $event->members()->updateOrCreate(['user_id' => $user->id]);

                return MemberResource::make($member->load(['user']))->resolve();
            } else { return response()->json(['error' => 'invalid payload'], 500); }
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        return response()->json(
            ShortResource::collection(
                Event::when(empty($request->selected), fn ($query) => $query->where('name', 'LIKE', '%'.$request->search.'%'))
                    ->when(! empty($request->selected), fn ($query) => $query->whereId($request->selected))
                    ->limit(5)
                    ->get()
            )->resolve(),
        );
    }

    public function searchMembers(Event $event, Request $request)
    {
        return response()->json(
            MemberResource::collection(
                $event->members()
                    ->with(['user'])
                    ->when(empty($request->selected), function ($query) use ($request) {
                        return $query->whereRelation('user', 'id', 'like', '%'.$request->search.'%')
                            ->orWhereRelation('user', 'email', 'like', '%'.$request->search.'%')
                            ->orWhereRelation('user', 'last_name', 'like', '%'.$request->search.'%')
                            ->orWhereRelation('user', 'first_name', 'like', '%'.$request->search.'%')
                            ->orWhereRelation('user', 'patronymic', 'like', '%'.$request->search.'%');
                    })
                    ->when(! empty($request->selected), fn ($query) => $query->whereId($request->selected))
                    ->limit(5)
                    ->get()
            )->resolve()
        );
    }
}
