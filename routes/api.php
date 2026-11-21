<?php

use App\Http\Controllers\API\AnnouncementsController;
use App\Http\Controllers\API\EventsController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->name('api.')->group(function () {
    Route::get('/user', UserController::class)->name('user');

    Route::prefix('/announcements')->name('announcements.')->controller(AnnouncementsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{event}', 'show')->name('show');
        Route::patch('/{event}/register', 'register')->name('register');
    });

    Route::prefix('/users')->name('users.')->controller(UsersController::class)->group(function () {
        Route::get('/search', 'search')->name('search');
    });

    Route::prefix('/events')->name('events.')->controller(EventsController::class)->group(function () {
        Route::get('/all', 'all')->name('all');
        Route::get('/my', 'my')->name('my');
        Route::get('/{event}', 'show')->whereNumber('event')->name('show');
        Route::get('/{event}/members', 'members')->whereNumber('event')->name('members');
        Route::patch('/{event}/members/qr', 'addMemberFromQR')->whereNumber('event')->name('members.qr');

        Route::get('/search', 'search')->name('search');
        Route::get('/{event}/members/search', 'searchMembers')->name('members.search');
    });
});
