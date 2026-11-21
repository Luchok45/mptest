<?php

namespace App\Http\Controllers;

use App\Enums\ActivityDirection;
use App\Enums\EventLevel;
use App\Enums\EventStatus;
use App\Enums\RewardType;
use App\Enums\YouthPolicyDirection;
use App\Http\Middleware\Events\CanCreateOrUpdateMiddleware;
use App\Http\Middleware\Events\CanViewMiddleware;
use App\Http\Middleware\Events\CheckStatusMiddleware;
use App\Http\Requests\Events\AddCoauthorRequest;
use App\Http\Requests\Events\AddMemberRequest;
use App\Http\Requests\Events\AddReportLinkRequest;
use App\Http\Requests\Events\AddWinnerRequest;
use App\Http\Requests\Events\CreateRequest;
use App\Http\Requests\Events\RejectRequest;
use App\Http\Requests\PreloadImageRequest;
use App\Http\Resources\Events\FullResource;
use App\Http\Resources\UserResource;
use App\Models\Event;
use App\Models\EventMember;
use App\Models\EventReportLink;
use App\Models\User;
use Illuminate\Routing\Attributes\Controllers\Middleware;

#[Middleware('auth')]
#[Middleware('permission:events.view.all', only: ['index'])]
#[Middleware(CanViewMiddleware::class, only: ['myEvents', 'show'])]
#[Middleware(CanCreateOrUpdateMiddleware::class, only: ['create', 'store', 'edit', 'update', 'destroy'])]
#[Middleware(CheckStatusMiddleware::class.':published', only: ['addMember', 'destroyMember', 'addWinner', 'destroyWinner'])]
class EventsController extends Controller
{
    public function index()
    {
        return inertia('events/Index', [
            'events' => FullResource::collection(
                Event::query()
                    ->with('creator')
                    ->when(! empty(request()->input('search')), function ($query) {
                        return $query->where('main_name', 'like', '%'.request()->input('search').'%');
                    })
                    ->when(! empty(request()->input('filters.status')), function ($query) {
                        return $query->whereIn('status', EventStatus::fromFilter(request()->input('filters.status')));
                    })
                    ->whereNot('status', EventStatus::DRAFT)
                    ->orderBy('dates_start_date')
                    ->paginate()
            ),
        ]);
    }

    public function myEvents()
    {
        return inertia('events/MyEvents', [
            'events' => FullResource::collection(
                Event::query()
                    ->with('creator')
                    ->when(! empty(request()->input('search')), function ($query) {
                        return $query->where('main_name', 'like', '%'.request()->input('search').'%');
                    })
                    ->when(! empty(request()->input('filters.status')), function ($query) {
                        return $query->whereIn('status', EventStatus::fromFilter(request()->input('filters.status')));
                    })
                    ->when(! empty(request()->input('filters.role')), function ($query) {
                        return match (request()->input('filters.role')) {
                            'creator' => $query->whereCreatorId(auth()->id()),
                            'coauthor' => $query->whereRelation('coauthors', 'user_id', auth()->id()),
                            default => $query->whereCreatorId(auth()->id())
                                ->orWhereRelation('coauthors', 'user_id', auth()->id())
                        };
                    })
                    ->when(empty(request()->input('filters.role')), function ($query) {
                        return $query->whereCreatorId(auth()->id())
                            ->orWhereRelation('coauthors', 'user_id', auth()->id());
                    })
//                    ->when(! empty(request()->input('filters.period')), function ($query) {
// //                        dd(request()->input('filters.period'));
//                        return match (request()->input('filters.period')) {
//                            'current-weak' => $query->where('dates_start_date', '<=', now()->startOfWeek()->startOfDay())
//                                ->where('dates_start_date', '>=', now()->endOfWeek()->endOfDay()),
//                            'current-month' => $query->where('dates_start_date', '<=', now()->startOfMonth()->startOfDay())
//                                ->where('dates_start_date', '>=', now()->endOfMonth()->endOfDay()),
//                            'next-month' => $query->where('dates_start_date', '<=', now()->addMonth()->startOfMonth()->startOfDay())
//                                ->where('dates_start_date', '>=', now()->addMonth()->endOfMonth()->endOfDay())
//                        };
//                    })

                    ->orderBy('dates_start_date')
                    ->paginate()
            ),
            'search' => request()->input('search'),
        ]);
    }

    public function show(Event $event)
    {
        return inertia('events/Show', [
            'event' => (new FullResource($event->load([
                'creator',
                'coauthors',
                'members',
                'winners.eventMember.user',
                'reportLinks',
            ])))->resolve(),
            'reward_types' => RewardType::toArray(),
            'canModerate' => true,
        ]);
    }

    public function create()
    {
        return inertia('events/Create', [
            'creator' => (new UserResource(auth()->user()))->resolve(),
            'event_levels' => EventLevel::toArray(),
            'activity_directions' => ActivityDirection::toArray(),
            'youth_policy_directions' => YouthPolicyDirection::toArray(),
        ]);
    }

    public function store(CreateRequest $request)
    {
        $event = Event::create(array_merge(
            $request->getValidatedData(),
            ['creator_id' => auth()->id()],
        ));

        return redirect()->route('events.show', $event->id);
    }

    public function edit(Event $event)
    {
        return inertia('events/Create', [
            'event' => (new FullResource($event))->resolve(),
            'event_levels' => EventLevel::toArray(),
            'activity_directions' => ActivityDirection::toArray(),
            'youth_policy_directions' => YouthPolicyDirection::toArray(),
        ]);
    }

    public function update(Event $event, CreateRequest $request)
    {
        $event->update($request->getValidatedData());

        return redirect()->route('events.show', $event->id);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index');
    }

    public function uploadCover(PreloadImageRequest $request)
    {
        $request->validated();

        return response()->json(
            $request->saveFile('events'),
        );
    }

    public function addCoauthor(Event $event, AddCoauthorRequest $request)
    {
        $event->coauthors()->updateOrCreate(
            ['user_id' => $request->validated('user_id')],
            $request->validated()
        );
    }

    public function destroyCoauthor(Event $event, User $user)
    {
        $event->coauthors()
            ->where('user_id', $user->id)
            ->delete();
    }

    public function addMember(Event $event, AddMemberRequest $request)
    {
        $event->members()
            ->updateOrCreate(['user_id' => $request->validated('user_id')]);
    }

    public function destroyMember(Event $event, User $user)
    {
        $event->members()
            ->where('user_id', $user->id)
            ->delete();
    }

    public function addWinner(Event $event, AddWinnerRequest $request)
    {
        if ($event->members()->whereId($request->validated('member_id'))->exists()) {
            $event->winners()
                ->updateOrCreate(
                    ['event_member_id' => $request->validated('member_id')],
                    ['reward_type' => $request->validated('reward_type')]
                );
        }

    }

    public function destroyWinner(Event $event, EventMember $member)
    {
        $event->winners()
            ->where('event_member_id', $member->id)
            ->delete();
    }

    public function addReportLink(Event $event, AddReportLinkRequest $request)
    {
        $event->reportLinks()
            ->create($request->validated());
    }

    public function destroyReportLink(Event $event, EventReportLink $reportLink)
    {
        $event->reportLinks()
            ->whereId($reportLink->id)
            ->delete();
    }

    public function sendToAgreement(Event $event)
    {
        $event->update([
            'status' => EventStatus::AGREEMENT,
            'reject_comment' => null,
        ]);
    }

    public function rejectAgreement(Event $event, RejectRequest $request)
    {
        $event->update([
            'status' => EventStatus::REVISION,
            'reject_comment' => $request->validated('reject_comment'),
        ]);
    }

    public function sendToPublished(Event $event)
    {
        $event->update([
            'status' => EventStatus::PUBLISHED,
            'reject_comment' => null,
        ]);
    }

    public function sendToInReporting(Event $event)
    {
        $event->update([
            'status' => EventStatus::IN_REPORTING,
            'reject_comment' => null,
        ]);
    }

    public function sendToInReportAgreement(Event $event)
    {
        $event->update([
            'status' => EventStatus::IN_REPORT_AGREEMENT,
            'reject_comment' => null,
        ]);
    }

    public function rejectReportAgreement(Event $event, RejectRequest $request)
    {
        $event->update([
            'status' => EventStatus::IN_REPORT_REVISION,
            'reject_comment' => $request->validated('reject_comment'),
        ]);
    }

    public function sendToInReportPublished(Event $event)
    {
        $event->update([
            'status' => EventStatus::IN_REPORT_PUBLISHED,
            'reject_comment' => null,
        ]);
    }

    public function sendToArchive(Event $event)
    {
        $event->update([
            'status' => EventStatus::ARCHIVED,
            'reject_comment' => null,
        ]);
    }
}
