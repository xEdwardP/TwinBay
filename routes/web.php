<?php

use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::redirect('/', 'login');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');

// Settings
Route::prefix('admin/settings')->controller(SettingController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('settings.index');
    Route::post('/store', 'store')->name('settings.store');
});

// Route::resource('admin/settings', SettingController::class)->middleware('auth');
