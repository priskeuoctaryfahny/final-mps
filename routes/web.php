<?php

use App\Models\Dashboard\Gas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WebSettingController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Backend\StSpController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\IncidentController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Dashboard\Management\RoleController;
use App\Http\Controllers\Dashboard\Management\UserController;
use App\Http\Controllers\Dashboard\Management\ActivityController;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/tes', function () {
    return view('tes');
});


Route::get('lang', [LanguageController::class, 'change'])->name("change.lang");

Route::get('/email/verify', [VerificationController::class, 'show'])
    ->middleware(['auth'])
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [VerificationController::class, 'send'])
    ->middleware(['auth'])
    ->name('verification.send');

Auth::routes();

Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('profiles', ProfileController::class);
    Route::resource('settings', WebSettingController::class);

    // Users
    Route::get('users/export/{format}', [UserController::class, 'export'])->name('users.export');
    Route::get('users/serverside', [UserController::class, 'serverside'])->name('users.serverside');
    Route::resource('users', UserController::class);

    // Users
    Route::get('activities/export/{format}', [ActivityController::class, 'export'])->name('activities.export');
    Route::get('activities/serverside', [ActivityController::class, 'serverside'])->name('activities.serverside');
    Route::get('activities', [ActivityController::class, 'index'])->name('activities.index');

    // Users
    Route::post('users/import', [UserController::class, 'import'])->name('users.import');
    Route::get('users/export/{format}', [UserController::class, 'export'])->name('users.export');
    Route::get('users/serverside', [UserController::class, 'serverside'])->name('users.serverside');
    Route::resource('users', UserController::class);


    Route::get('roles/serverside', [RoleController::class, 'serverside'])->name('roles.serverside');
    Route::resource('roles', RoleController::class);


    Route::resource('units', UnitController::class);
    Route::resource('incidents', IncidentController::class);
    Route::resource('reports', ReportController::class);
    Route::resource('stsps', StSpController::class);
    Route::resource('employees', EmployeeController::class);

    Route::get('testing/{tes}', function ($tes) {
        return $tes;
    })->name('users.testing');
});
