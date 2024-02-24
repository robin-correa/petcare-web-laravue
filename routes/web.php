<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SpecieTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VeterinarianController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Landing');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
});


Route::get('/login', function () {
    return Inertia::render('Login');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    });

    Route::resource('services', ServiceController::class);
    Route::resource('specieTypes', SpecieTypeController::class);
    Route::resource('veterinarians', VeterinarianController::class);
    Route::resource('users', UserController::class);
    Route::put('users/{user}/updatePermissions', [UserController::class, 'updatePermissions']);
    Route::resource('roles', RoleController::class);
});
