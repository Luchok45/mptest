<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function __invoke()
    {
        return redirect()
            ->route('announcements.index');
    }
}
