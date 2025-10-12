<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\ParkingSpace;
use App\Models\Rate;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'setting' => Setting::first(),
            'totalRoles' => Role::count(),
            'totalUsers' => User::where('name', '!=', 'SUPER ADMIN')->count(),
            'totalParkingSpaces' => ParkingSpace::count(),
            'totalAvailableParkingSpaces' => ParkingSpace::where('parking_status', 'disponible')->count(),
            'totalOccupiedParkingSpaces' => ParkingSpace::where('parking_status', 'ocupado')->count(),
            'totalMaintenanceParkingSpaces' => ParkingSpace::where('parking_status', 'en mantenimiento')->count(),
            'totalRates' => Rate::count(),
            'totalCustomers' => Customer::count(),
            'totalVehicles' => Vehicle::count(),
            'totalActiveTickets' => Ticket::where('ticket_status', 'activo')->count(),
            'invoices' => Invoice::with('customer', 'vehicle')->latest('id')->limit(5)->get(),
        ]);
    }
}
