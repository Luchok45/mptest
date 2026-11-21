<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function search(Request $request)
    {
        return response()->json(
            UserResource::collection(
                User::when(empty($request->selected), function ($query) use ($request) {
                    return $query->where('id', 'like', '%'.$request->search.'%')
                        ->orWhere('email', 'like', '%'.$request->search.'%')
                        ->orWhere('last_name', 'like', '%'.$request->search.'%')
                        ->orWhere('first_name', 'like', '%'.$request->search.'%')
                        ->orWhere('patronymic', 'like', '%'.$request->search.'%');
                })
                    ->when(! empty($request->selected), function ($query) use ($request) {
                        return $query->where('id', $request->selected);
                    })
                    ->limit(5)
                    ->get()
            )->resolve()
        );
    }
}
