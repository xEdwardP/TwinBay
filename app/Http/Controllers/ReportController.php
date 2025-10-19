<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrintReportFilterRequest;
use App\Models\Invoice;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index', [
            'title' => 'Centro de reportes del sistema',
            'startWeek' => Carbon::now()->startOfWeek()->format('Y-m-d'),
            'endWeek' => Carbon::now()->endOfWeek()->format('Y-m-d'),
        ]);
    }

    public function printWeeklyReport(PrintReportFilterRequest $request)
    {
        try {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();

            $invoices = Invoice::whereBetween('created_at', [$startDate, $endDate])->get();

            $totalAmount = $invoices->sum('total');

            $pdf = Pdf::loadView('admin.reports.weekly_report', [
                'title' => 'Reporte Semanal',
                'setting' => Setting::first(),
                'invoices' => $invoices,
                'startDate' => $startDate->format('d/m/Y'),
                'endDate' => $endDate->format('d/m/Y'),
                'totalAmount' => $totalAmount,
                'user' => Auth::user(),
            ]);

            return $pdf->stream('Reporte_Semanal.pdf');
        } catch (\Exception $e) {
            return redirect()->route('reports.index')->with('error', 'No se pudo generar el reporte semanal debido a un error: ' . $e->getMessage());
        }
    }

    public function printMonthlyReport(Request $request)
    {
        try {
            $request->validate([
                'year_filter' => 'required',
                'month_filter' => 'required',
            ]);

            $year = $request->year_filter;
            $monthId = $request->month_filter;
            $invoices = Invoice::whereYear('created_at', $year)->whereMonth('created_at', $monthId)->get();

            $totalAmount = $invoices->sum('total');

            $months = [
                1 => 'Enero',
                2 => 'Febrero',
                3 => 'Marzo',
                4 => 'Abril',
                5 => 'Mayo',
                6 => 'Junio',
                7 => 'Julio',
                8 => 'Agosto',
                9 => 'Septiembre',
                10 => 'Octubre',
                11 => 'Noviembre',
                12 => 'Diciembre',
            ];

            $pdf = Pdf::loadView('admin.reports.monthly_report', [
                'title' => 'Reporte Mensual',
                'setting' => Setting::first(),
                'invoices' => $invoices,
                'year' => $year,
                'month' => $months[$monthId],
                'totalAmount' => $totalAmount,
                'user' => Auth::user(),
            ]);

            return $pdf->stream('Reporte_Mensual.pdf');
        } catch (\Exception $e) {
            return redirect()->route('reports.index')->with('error', 'No se pudo generar el reporte mensual debido a un error: ' . $e->getMessage());
        }
    }

    public function printDailyReport(Request $request)
    {
        try {
            $request->validate([
                'year_filter' => 'required',
                'month_filter' => 'required',
            ]);

            $year = $request->year_filter;
            $month = $request->month_filter;
            $dailyIncome = Invoice::selectRaw('DATE(created_at) as date, SUM(total) as totalDaily, COUNT(*) as quantityServices')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();

            $totalMonthly = $dailyIncome->sum('totalDaily');
            $avgDaily = $dailyIncome->avg('totalDaily');

            if ($dailyIncome->isEmpty()) {
                return redirect()->route('reports.index')->with('error', 'No se encontraron facturas en el rango de fechas seleccionado.');
            }

            $months = [
                1 => 'Enero',
                2 => 'Febrero',
                3 => 'Marzo',
                4 => 'Abril',
                5 => 'Mayo',
                6 => 'Junio',
                7 => 'Julio',
                8 => 'Agosto',
                9 => 'Septiembre',
                10 => 'Octubre',
                11 => 'Noviembre',
                12 => 'Diciembre',
            ];

            $pdf = Pdf::loadView('admin.reports.daily_report', [
                'title' => 'Reporte de Ingresos Diarios',
                'setting' => Setting::first(),
                'year' => $year,
                'month' => $months[$month],
                'user' => Auth::user(),
                'dailyIncome' => $dailyIncome,
                'totalMonthly' => $totalMonthly,
                'avgDaily' => $avgDaily,
                'maxIncome' => $dailyIncome->max('totalDaily'),
                'minIncome' => $dailyIncome->min('totalDaily'),
                'bestDay' => $dailyIncome->sortByDesc('totalDaily')->first(),
            ]);

            return $pdf->stream('Reporte_Ingresos_Diario.pdf');
        } catch (\Exception $e) {
            return redirect()->route('reports.index')->with('error', 'No se pudo generar el reporte de ingresos debido a un error: ' . $e->getMessage());
        }
    }
}
