<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PrivilegesSeeder extends Seeder
{
    public function run(): void
    {
        $administrator = Role::updateOrCreate(['name' => 'administrator', 'guard_name' => 'web']);
        $moderator = Role::updateOrCreate(['name' => 'moderator', 'guard_name' => 'web']);
        $creator = Role::updateOrCreate(['name' => 'creator', 'guard_name' => 'web']);

        $eventsViewAll = Permission::updateOrCreate(['name' => 'events.view.all', 'guard_name' => 'web']);
        $eventsViewMy = Permission::updateOrCreate(['name' => 'events.view.my', 'guard_name' => 'web']);
        $eventsCreate = Permission::updateOrCreate(['name' => 'events.create', 'guard_name' => 'web']);
        $eventsModerate = Permission::updateOrCreate(['name' => 'events.moderate', 'guard_name' => 'web']);

        $ratingView = Permission::updateOrCreate(['name' => 'rating.view', 'guard_name' => 'web']);

        $usersView = Permission::updateOrCreate(['name' => 'users.view', 'guard_name' => 'web']);
        $usersAssignRole = Permission::updateOrCreate(['name' => 'users.assign-role', 'guard_name' => 'web']);

        $administrator->syncPermissions(
            $eventsViewAll,
            $eventsViewMy,
            $eventsCreate,
            $eventsModerate,
            $ratingView,
            $usersView,
            $usersAssignRole,
        );
        $moderator->syncPermissions($eventsViewAll, $eventsModerate);
        $creator->syncPermissions($eventsViewMy, $eventsCreate, $ratingView);
    }
}
