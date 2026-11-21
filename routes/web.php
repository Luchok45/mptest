<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\PrometheusOAuthController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexController::class);

Route::prefix('auth/lk')->name('oauth.prometheus.')->controller(PrometheusOAuthController::class)->group(function () {
    Route::get('/redirect', 'redirect')->name('redirect');
    Route::get('/callback', 'callback')->name('callback');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('/profile')->name('profile.')->controller(MyProfileController::class)->group(function () {
        Route::get('/edit', 'edit')->name('edit');
        Route::patch('/edit', 'update')->name('update');
    });

    Route::prefix('announcements')->name('announcements.')->controller(AnnouncementsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{event}', 'show')->name('show');
        Route::patch('/{event}/register', 'register')->name('register');
    });

    Route::prefix('/activity')->name('activity.')->controller(ActivityController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::prefix('/rating')->name('rating.')->controller(RatingController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::prefix('events')->name('events.')->controller(EventsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/my', 'myEvents')->name('my');
        Route::get('/create', 'create')->name('create');
        Route::get('/{event}', 'show')->name('show');
        Route::get('/{event}/edit', 'edit')->name('edit');
        Route::post('/', 'store')->name('store');
        Route::patch('/{event}', 'update')->name('update');
        Route::delete('/{event}', 'destroy')->name('destroy');

        Route::post('/upload-cover', 'uploadCover')->name('upload-cover');

        Route::patch('/{event}/coauthors', 'addCoauthor')->name('add-coauthor');
        Route::delete('/{event}/coauthors/{user}', 'destroyCoauthor')->name('destroy-coauthor');

        Route::patch('/{event}/members', 'addMember')->name('add-member');
        Route::delete('/{event}/members/{user}', 'destroyMember')->name('destroy-member');

        Route::patch('/{event}/winners', 'addWinner')->name('add-winner');
        Route::delete('/{event}/winners/{member}', 'destroyWinner')->name('destroy-winner');

        Route::patch('/{event}/report-links', 'addReportLink')->name('add-report-link');
        Route::delete('/{event}/report-links/{reportLink}', 'destroyReportLink')->name('destroy-report-link');

        Route::patch('/{event}/to-agreement', 'sendToAgreement')->name('to-agreement');
        Route::patch('/{event}/reject-agreement', 'rejectAgreement')->name('reject-agreement');
        Route::patch('/{event}/to-published', 'sendToPublished')->name('to-published');
        Route::patch('/{event}/to-reporting', 'sendToInReporting')->name('to-reporting');
        Route::patch('/{event}/to-report-agreement', 'sendToInReportAgreement')->name('to-report-agreement');
        Route::patch('/{event}/reject-report-agreement', 'rejectReportAgreement')->name('reject-report-agreement');
        Route::patch('/{event}/to-report-published', 'sendToInReportPublished')->name('to-report-published');
        Route::patch('/{event}/to-archive', 'sendToArchive')->name('to-archive');
    });

    Route::prefix('/users')->name('users.')->controller(UsersController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::patch('/{user}/toggle-role/{role}', 'toggleRole')->name('toggle-role');
    });

    Route::get('/logout', function () {
        Auth::logout();

        return redirect()->route('login');
    })->name('mplogout');
});
