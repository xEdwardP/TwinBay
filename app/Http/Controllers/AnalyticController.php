<?php

namespace App\Http\Controllers;

use App\Models\ParkingSpace;
use App\Models\Setting;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticController extends Controller
{
    public function index()
    {
        $monthlyIncome = Ticket::select(
            DB::raw('MONTH(out_date) as month'),
            DB::raw('SUM(total_amount) as total'),
        )->where('ticket_status', 'completado')
            ->groupBy('month')->orderBy('month')->get()->keyBy('month')->toArray();

        $incomesData = array_fill(1, 12, 0);

        foreach ($monthlyIncome as $month => $income) {
            $incomesData[$month] = $income['total'];
        }

        $spaces = ParkingSpace::all();
        $tickets_actives = Ticket::where('ticket_status', 'activo')->get();

        $occupiedSpaces = $spaces->filter(fn($space) => $tickets_actives->firstWhere('parking_space_id', $space->id))->count();
        $availableSpaces = $spaces->where('parking_status', 'disponible')->count();
        $maintenanceSpaces = $spaces->where('parking_status', 'en mantenimiento')->count();


        return view('admin.analytics.index', [
            'title' => 'Análisis y Gráficos',
            'setting' => Setting::first(),
            'totalTodayIncomes' => Ticket::where('ticket_status', 'completado')->where('out_date', Carbon::today())->sum('total_amount'),
            'totalYesterdayIncomes' => Ticket::where('ticket_status', 'completado')->where('out_date', Carbon::yesterday())->sum('total_amount'),
            'totalWeekIncomes' => Ticket::where('ticket_status', 'completado')->whereBetween('out_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_amount'),
            'totalLastWeekIncomes' => Ticket::where('ticket_status', 'completado')->whereBetween('out_date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->sum('total_amount'),
            'totalMonthIncomes' => Ticket::where('ticket_status', 'completado')->whereMonth('out_date', Carbon::now()->month)->whereYear('out_date', Carbon::now()->year)->sum('total_amount'),
            'totalLastMonthIncomes' => Ticket::where('ticket_status', 'completado')->whereMonth('out_date', Carbon::now()->subMonth()->month)->whereYear('out_date', Carbon::now()->subMonth()->year)->sum('total_amount'),
            'totalIncomes' => Ticket::where('ticket_status', 'completado')->sum('total_amount'),
            'incomesData' => $incomesData,
            'occupiedSpaces' => $occupiedSpaces,
            'availableSpaces' => $availableSpaces,
            'maintenanceSpaces' => $maintenanceSpaces,
        ]);
    }
}
