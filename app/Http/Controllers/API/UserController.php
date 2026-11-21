<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function __invoke()
    {
        return UserResource::make(auth()->user()->load('roles'))->resolve();
    }
}
