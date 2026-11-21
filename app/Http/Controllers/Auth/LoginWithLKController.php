<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class LoginWithLKController extends Controller
{
    public function login()
    {
        $user = User::updateOrCreate(['email' => 'naggadim@dev'], [
            'last_name' => 'Смертин',
            'first_name' => 'Дмитрий',
            'patronymic' => 'Анатольевич',
            'password' => 'password',
        ]);

        auth()->login($user, remember: true);

        return redirect('/dashboard');
    }
}
