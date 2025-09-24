<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::redirect('/', 'login');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');

// Setting routes
Route::prefix('admin/settings')->controller(SettingController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('settings.index');
    Route::post('/store', 'store')->name('settings.store');
});

// Users routes
Route::prefix('admin/users')->controller(UserController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('users.index');
    Route::post('/store', 'store')->name('users.store');
    Route::get('/create', 'create')->name('users.create');
    Route::get('/edit/{user}', 'edit')->name('users.edit');
    Route::put('/update/{user}', 'update')->name('users.update');
    Route::get('/show/{user}', 'show')->name('users.show');
    Route::delete('/destroy/{user}', 'destroy')->name('users.destroy');
    Route::post('/restore/{id}', 'restore')->name('users.restore');
});

// Roles routes
Route::prefix('admin/roles')->controller(RoleController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('roles.index');
    Route::post('/store', 'store')->name('roles.store');
    Route::get('/edit/{role}', 'edit')->name('roles.edit');
    Route::put('/update/{role}', 'update')->name('roles.update');
    Route::delete('/destroy/{role}', 'destroy')->name('roles.destroy');
});
