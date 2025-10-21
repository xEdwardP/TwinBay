<?php

use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ParkingSpaceController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/register', function(){
    abort(403, 'Registro no permitido!');
})->name('register');

Route::redirect('/', 'login');
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

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
    Route::get('/profile', 'showProfile')->name('users.profile');
    Route::put('/profile/update/{user}', 'updateProfile')->name('users.update_profile');
    Route::put('/profile/change_password/{user}', 'changePassword')->name('users.change_password');
});

// Roles routes
Route::prefix('admin/roles')->controller(RoleController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('roles.index');
    Route::post('/store', 'store')->name('roles.store');
    Route::get('/edit/{role}', 'edit')->name('roles.edit');
    Route::put('/update/{role}', 'update')->name('roles.update');
    Route::delete('/destroy/{role}', 'destroy')->name('roles.destroy');
});

// ParkingSpaces routes
Route::prefix('admin/spaces')->controller(ParkingSpaceController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('spaces.index');
    Route::get('/create', 'create')->name('spaces.create');
    Route::post('/store', 'store')->name('spaces.store');
    Route::put('/update/{id}', 'update')->name('spaces.update');
    Route::delete('/destroy/{space}', 'destroy')->name('spaces.destroy');
});

// Rates routes
Route::prefix('admin/rates')->controller(RateController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('rates.index');
    Route::get('/create', 'create')->name('rates.create');
    Route::post('/store', 'store')->name('rates.store');
    Route::get('/edit/{rate}', 'edit')->name('rates.edit');
    Route::put('/update/{rate}', 'update')->name('rates.update');
    Route::delete('/destroy/{rate}', 'destroy')->name('rates.destroy');
});

// Customers routes
Route::prefix('admin/customers')->controller(CustomerController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('customers.index');
    Route::get('/create', 'create')->name('customers.create');
    Route::post('/store', 'store')->name('customers.store');
    Route::get('/edit/{customer}', 'edit')->name('customers.edit');
    Route::put('/update/{customer}', 'update')->name('customers.update');
    Route::get('/show/{customer}', 'show')->name('customers.show');
    Route::delete('/destroy/{customer}', 'destroy')->name('customers.destroy');
    Route::post('/restore/{customer}', 'restore')->name('customers.restore');
});

// Vehicles Routes
Route::prefix('admin/customers/vehicles')->controller(VehicleController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('vehicles.index');
    Route::post('/store', 'store')->name('vehicles.store');
    Route::put('/update/{vehicle}', 'update')->name('vehicles.update');
    Route::delete('/destroy/{vehicle}', 'destroy')->name('vehicles.destroy');
});

// Tickets Routes
Route::prefix('admin/tickets')->controller(TicketController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('tickets.index');
    Route::get('/vehicle/{id}', 'searchVehicle')->name('tickets.search_vehicle');
    Route::post('/store', 'store')->name('tickets.store');
    Route::post('/update/ticket_rate/', 'update')->name('tickets.update');
    Route::get('/complete_invoice/{ticket}', 'completeInvoice')->name('tickets.complete_invoice');
    Route::delete('/destroy/{ticket}', 'destroy')->name('tickets.destroy');
    Route::get('/{ticket}/print', 'printTicket')->name('tickets.print_ticket');
    Route::get('/{ticket}/calcAmount', 'calcAmount')->name('tickets.calcAmount');
});

// Invoices Routes
Route::prefix('admin/invoices')->controller(InvoiceController::class)->middleware('auth')->group(function () {
    Route::get('/print/{invoice}', 'printInvoice')->name('invoices.print');
});

// Analytics routes
Route::prefix('admin/analytics')->controller(AnalyticController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('analytics.index');
});

// Reports routes
Route::prefix('admin/reports')->controller(ReportController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('reports.index');
    Route::get('/print/weekly_report', 'printWeeklyReport')->name('reports.weekly_report');
    Route::get('/print/monthly_report', 'printMonthlyReport')->name('reports.monthly_report');
    Route::get('/print/daily_report', 'printDailyReport')->name('reports.daily_report');
});
