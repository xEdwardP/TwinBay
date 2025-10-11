<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
            'totalTodayIncomes' => Ticket::where('ticket_status', 'completado')->where('out_date', Carbon::today())->sum('total_amount'),
            'totalYesterdayIncomes' => Ticket::where('ticket_status', 'completado')->where('out_date', Carbon::yesterday())->sum('total_amount'),
            'totalWeekIncomes' => Ticket::where('ticket_status', 'completado')->whereBetween('out_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_amount'),
            'totalLastWeekIncomes' => Ticket::where('ticket_status', 'completado')->whereBetween('out_date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->sum('total_amount'),
            'totalMonthIncomes' => Ticket::where('ticket_status', 'completado')->whereMonth('out_date', Carbon::now()->month)->whereYear('out_date', Carbon::now()->year)->sum('total_amount'),
            'totalLastMonthIncomes' => Ticket::where('ticket_status', 'completado')->whereMonth('out_date', Carbon::now()->subMonth()->month)->whereYear('out_date', Carbon::now()->subMonth()->year)->sum('total_amount'),
            'totalIncomes' => Ticket::where('ticket_status', 'completado')->sum('total_amount'),
        ]);
    }
}
