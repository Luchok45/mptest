<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\IndexRequest;
use App\Http\Resources\Privileges\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Spatie\Permission\Models\Role;

#[Middleware('auth')]
#[Middleware('permission:users.view')]
class UsersController extends Controller
{
    public function index(IndexRequest $request)
    {
        return inertia('users/Index', [
            'users' => UserResource::collection(
                User::with('roles')
                    ->orderBy('id')
                    ->when(! empty($request->safe()->input('search')), fn ($query) => $query
                        ->where('last_name', 'like', '%'.$request->safe()->input('search').'%')
                        ->orWhere('first_name', 'like', '%'.$request->safe()->input('search').'%')
                        ->orWhere('patronymic', 'like', '%'.$request->safe()->input('search').'%')
                    )
                    ->when(! empty($request->safe()->input('filters.role')), fn ($query) => $query->whereHas(
                        'roles',
                        fn ($q) => $q->whereName($request->safe()->input('filters.role'))->whereGuardName('web')
                    ))
                    ->paginate($request->safe()->input('per_page', 15))
                    ->withQueryString(),
            ),
            'roles' => RoleResource::collection(
                Role::where('guard_name', 'web')
                    ->orderBy('name')
                    ->get()
            )->resolve(),
        ]);
    }

    #[Middleware('permission:users.assign-role')]
    public function toggleRole(User $user, Role $role)
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);
        } else {
            $user->assignRole($role);
        }
    }
}
