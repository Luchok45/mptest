<?php

namespace App\Http\Controllers;

use App\Http\Resources\MyRatingCollection;
use App\Models\Rating;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        return inertia('activity/Index')
            ->with(
                'activity',
                MyRatingCollection::make(
                    Rating::query()
                        ->with('event')
                        ->my()
                        ->orderByDesc('created_at')
                        ->paginate($request->input('per_page', 25))
                )
            );
    }
}
