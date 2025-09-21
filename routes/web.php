<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
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

// Roles routes
Route::prefix('admin/roles')->controller(RoleController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('roles.index');
    Route::post('/store', 'store')->name('roles.store');
    // Route::get('/create', 'create')->name('roles.create');
    Route::get('/edit/{role}', 'edit')->name('roles.edit');
    Route::put('/update/{role}', 'update')->name('roles.update');
    Route::delete('/destroy/{role}', 'destroy')->name('roles.destroy');
});
