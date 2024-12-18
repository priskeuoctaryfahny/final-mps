<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RendisController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WebSettingController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Dashboard\Management\RoleController;
use App\Http\Controllers\Dashboard\Management\UserController;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/tes', function () {
    return view('tes');
});


Route::get('lang', [LanguageController::class, 'change'])->name("change.lang");



Auth::routes(['verify' => true]);

Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::get('/dashboard', function () {
    return view('dashboard.index')->with('title', __('text-ui.breadcrumb.dashboard'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard2', function () {
    return view('dashboard.index')->with('title', 'Dashboard 2');
})->middleware(['auth', 'verified'])->name('dashboard2');

Route::middleware('auth')->group(function () {
    Route::resource('profiles', ProfileController::class);
    Route::resource('settings', WebSettingController::class);
});

Route::middleware('auth')->group(function () {

    // Users
    Route::get('users/export/{format}', [UserController::class, 'export'])->name('users.export');
    Route::get('users/serverside', [UserController::class, 'serverside'])->name('users.serverside');
    Route::resource('users', UserController::class);

    // Rendis
    Route::get('rendis/export/{format}', [RenDisController::class, 'export'])->name('rendis.export');
    Route::get('rendis/serverside', [RenDisController::class, 'serverside'])->name('rendis.serverside');
    Route::resource('rendis', RenDisController::class);

    Route::get('roles/serverside', [RoleController::class, 'serverside'])->name('roles.serverside');
    Route::resource('roles', RoleController::class);

    Route::get('testing', [UserController::class, 'testing'])->name('users.testing');
});
