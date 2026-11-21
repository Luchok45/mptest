<?php

namespace App\Http\Resources;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see Rating */
class MyRatingCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => RatingResource::collection($this->collection)->resolve(),
            'total_points' => Rating::query()->my()->sum('modification'),
        ];
    }
}
