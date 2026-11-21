<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\EditRequest;
use App\Http\Resources\UserResource;
use Illuminate\Routing\Attributes\Controllers\Middleware;

#[Middleware('auth')]
class MyProfileController extends Controller
{
    public function edit()
    {
        return inertia('profile/Edit', [
            'user' => UserResource::make(auth()->user())->resolve(),
        ]);
    }

    public function update(EditRequest $request)
    {
        auth()->user()->update($request->validated());
        //        auth()->user()->update([
        //            ...$request->safe()->only(['phone', 'email']),
        //            'birthdate' => $request->input('birthdate'),
        //        ]);
    }
}
