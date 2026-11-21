<?php

namespace App\Http\Resources;

use App\Http\Resources\Privileges\RoleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'prometheus_id' => $this->oauth_prometheus_id,
            'avatar' => $this->avatar,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'patronymic' => $this->patronymic,
            'name' => $this->name,
            'full_name' => $this->full_name,
            'birthdate' => $this->birthdate?->toIso8601String(),
            'phone' => $this->phone,
            'email' => $this->email,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),

            $this->mergeWhen($this->relationLoaded('roles'), [
                'roles' => RoleResource::collection($this->roles),
            ]),
        ];
    }
}
