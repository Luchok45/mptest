<?php

namespace App\Http\Controllers;

use App\Services\RatingService;
use Illuminate\Routing\Attributes\Controllers\Middleware;

#[Middleware('auth')]
class RatingController extends Controller
{
    public function __construct(private RatingService $ratingService) {}

    #[Middleware('permission:rating.view')]
    public function index()
    {
        return inertia('rating/Index')
            ->with('rating', $this->ratingService->getRatingResponse());
    }
}
