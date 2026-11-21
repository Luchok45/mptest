<?php

namespace App\Console\Commands\Privileges;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

#[Signature('privileges:give-role {user} {role}')]
#[Description('Give a role for a user')]
class GiveRoleCommand extends Command
{
    public function handle(): void
    {
        $user = User::whereEmail($this->argument('user'))
            ->first();
        if (! $user) {
            $this->error('User not found');

            return;
        }

        $role = Role::where('guard_name', 'web')
            ->whereName($this->argument('role'))
            ->first();

        if (! $role) {
            $this->error('Role not found');

            return;
        }

        $user->assignRole($role);

        $this->info('Giving role '.$role->name.' to user "'.$user->email.'"');
    }
}
