<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Invoice;
use App\Models\ParkingSpace;
use App\Models\Rate;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        $ratesId = DB::table('rates')->select(DB::raw('MIN(id) as id'))->groupBy('name', 'type')->pluck('id');

        return view('admin.tickets.index', [
            'title' => 'Tickets',
            'setting' => Setting::first(),
            'spaces' => ParkingSpace::all(),
            'items' => Ticket::latest()->get(),
            'vehicles' => Vehicle::with('customer')->get(),
            'rates' => Rate::whereIn('id', $ratesId)->get(),
            'tickets_actives' => Ticket::where('ticket_status', 'activo')->get(),
        ]);
    }

    public function store(TicketRequest $request)
    {
        try {
            $validated = $request->validated();
            $ticket_active = Ticket::where('vehicle_id', $validated['vehicle_id'])->where('ticket_status', 'activo')->first();

            if ($ticket_active) {
                return redirect()->route('tickets.index')->with('error', '¡El vehículo ya tiene un ticket activo!');
            }

            $vehicle = Vehicle::findOrFail($validated['vehicle_id']);

            $ticket = new Ticket();
            $ticket->parking_space_id = $validated['parking_space_id'];
            $ticket->customer_id = $vehicle->customer_id;
            $ticket->vehicle_id = $validated['vehicle_id'];
            $ticket->rate_id = $validated['rate_id'];
            $ticket->user_id = Auth::user()->id;

            // Generate Ticket Number
            $lastTicket = DB::table('tickets')->max('id');
            $nextTicket = $lastTicket ? $lastTicket + 1 : 1;
            $ticket->ticket_number = 'TK-' . $nextTicket;

            // Ticket Date and Time
            $dateTime = Carbon::now();
            $ticket->in_date = $dateTime->toDateString();
            $ticket->in_time = $dateTime->toTimeString();

            $ticket->ticket_status = 'activo';
            $ticket->observations = $validated['observations'];
            $ticket->save();

            // Update Parking Space Status
            $parkingSpace = ParkingSpace::findOrFail($validated['parking_space_id']);
            $parkingSpace->parking_status = 'ocupado';
            $parkingSpace->save();

            return redirect()->route('tickets.index')->with('success', '¡Ticket creado exitosamente!')->with('ticket_id', $ticket->id);
        } catch (\Exception $e) {
            return redirect()->route('tickets.index')->with('error', 'No se pudo generar el ticket debido a un error: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'ticket_id_edit_rate' => 'required|exists:Tickets,id',
                'rate_id' => 'required|exists:Rates,id',
            ]);

            $ticket = Ticket::findOrFail($request->ticket_id_edit_rate);
            $rate = Rate::findOrFail($request->rate_id);

            $ticket->rate_id = $rate->id;
            $ticket->save();

            return redirect()->route('tickets.index')->with('success', '¡La tarifa del ticket fue actualizada exitosamente!');
        } catch (\Exception $e) {
            return redirect()->route('tickets.index')->with('error', 'No se pudo actualizar la tarifa del ticket debido a un error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->ticket_status = 'cancelado';
            $ticket->save();
            $ticket->delete();

            // Update Parking Space Status
            $parkingSpace = ParkingSpace::findOrFail($ticket->parking_space_id);
            $parkingSpace->parking_status = 'disponible';
            $parkingSpace->save();

            return redirect()->route('tickets.index')->with('success', '¡El ticket fue cancelado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->route('tickets.index')->with('error', 'No se pudo cancelar el ticket debido a un error: ' . $e->getMessage());
        }
    }

    public function searchVehicle($id)
    {
        $vehicle = Vehicle::with('customer')->findOrFail($id);
        return view('admin.tickets.search_vehicle', [
            'title' => 'Buscar vehículo',
            'vehicle' => $vehicle,
        ]);
    }

    public function printTicket($id)
    {
        try {
            $ticket = Ticket::with('customer')->findOrFail($id);
            $parkingSpace = ParkingSpace::findOrFail($ticket->parking_space_id);

            $pdf = Pdf::loadView('admin.tickets.ticket_pdf', [
                'ticket' => $ticket,
                'setting' => Setting::first(),
                'date' => Carbon::now(),
            ]);

            // Configuración para impresora térmica: 80mm de ancho, alto automático
            $pdf->setOptions([
                'dpi' => '120',
                'defaultPaperSize' => [0, 0, 226.77, 0], // 80mm = 226.77 points
                'isHtml5ParserEnabled' => 'true',
                'isRemoteEnabled' => 'true',
                'defaultFont' => 'Arial Narrow'
            ]);

            $pdf->setPaper([0, 0, 226.77, 999999]); // 80mm de ancho, alto automático
            return $pdf->stream('Ticket.pdf');
        } catch (\Exception $e) {
            return redirect()->route('tickets.index')->with('error', 'No se pudo imprimir el ticket debido a un error: ' . $e->getMessage());
        }
    }

    public function completeInvoice($id)
    {
        try {
            $ticket = Ticket::with('rate')->findOrFail($id);

            $in_datetime = new DateTime($ticket->in_date . ' ' . $ticket->in_time);
            $out_datetime = new DateTime(Carbon::now());
            $diff = $in_datetime->diff($out_datetime);

            $calcDays = $diff->days;
            $calcHours = $diff->h;
            $calcMinutes = $diff->i;
            $diffMinutes = ($calcDays * 1440) + ($calcHours * 60) + $calcMinutes;

            $totalTime = "{$calcDays} dias con {$calcHours} horas con {$calcMinutes} minutos";
            $totalAmount = 0;
            $rate = null;

            if ($calcDays > 0) {
                $rateDay = DB::table('rates')->where('name', 'regular')->where('type', 'por dia')->min('id');
                $ticket->rate_id = $rateDay;
                $ticket->save();

                $ticket->load('rate');
            }

            $type = $ticket->rate->type;
            $name = $ticket->rate->name;

            if ($type === 'por hora') {
                $grace = match (true) {
                    $calcHours >= 1 && $calcHours <= 8 => 10,
                    $calcHours >= 9 && $calcHours <= 18 => 15,
                    $calcHours >= 19 && $calcHours <= 23 => 20,
                    default => 15,
                };

                if ($calcMinutes > $grace) {
                    $calcHours += 1;
                } else {
                    $calcHours = $calcHours == 0 ? 1 : $calcHours;
                }

                $rate = Rate::where('type', 'por hora')
                    ->where('name', $name)
                    ->where('quantity', $calcHours)
                    ->first();
            } elseif ($type === 'por dia') {
                if ($diffMinutes > $ticket->rate->grace_period_minutes) {
                    $calcDays += 1;
                } else {
                    $calcDays = $calcDays == 0 ? 1 : $calcDays;
                }

                $rate = Rate::where('type', 'por dia')
                    ->where('name', $name)
                    ->where('quantity', $calcDays)
                    ->first();
            }

            if (!$rate) {
                return redirect()->route('tickets.index')
                    ->with('error', "No se encontró una tarifa: Tipo: {$type} - {$name} con cantidad: " . ($type === 'por hora' ? $calcHours : $calcDays));
            }

            $totalAmount = $rate->cost;

            $dateTime = Carbon::now();
            $ticket->rate_id = $rate->id;
            $ticket->out_date = $dateTime->toDateString();
            $ticket->out_time = $dateTime->toTimeString();
            $ticket->total_time = $totalTime;
            $ticket->total_amount = $totalAmount;
            $ticket->ticket_status = 'completado';
            $ticket->save();

            ParkingSpace::where('id', $ticket->parking_space_id)->update(['parking_status' => 'disponible']);

            // Create Invoice
            $invoice = new Invoice();
            $invoice->ticket_id = $ticket->id;
            $invoice->user_id = Auth::user()->id;
            $invoice->customer_id = $ticket->customer_id;
            $invoice->vehicle_id = $ticket->vehicle_id;

            // Generate Invoice Number
            $lastInvoice = DB::table('invoices')->max('id');
            $nextInvoice = $lastInvoice ? $lastInvoice + 1 : 1;
            $invoice->invoice_number = $nextInvoice;

            $invoice->detail = "Servicio de parqueo de " . $totalTime;
            $invoice->total = $totalAmount;
            $invoice->save();

            return redirect()->route('tickets.index')->with('success', 'Ticket facturado correctamente.')->with('invoice_id', $invoice->id);;
        } catch (\Exception $e) {
            return redirect()->route('tickets.index')->with('error', 'No se pudo facturar el ticket: ' . $e->getMessage());
        }
    }

    public function calcAmount($id)
    {
        try {
            $ticket = Ticket::with('rate')->findOrFail($id);
            $setting = Setting::first();

            $in_datetime = new DateTime($ticket->in_date . ' ' . $ticket->in_time);
            $out_datetime = new DateTime(Carbon::now());
            $diff = $in_datetime->diff($out_datetime);

            $calcDays = $diff->days;
            $calcHours = $diff->h;
            $calcMinutes = $diff->i;
            $diffMinutes = ($calcDays * 1440) + ($calcHours * 60) + $calcMinutes;

            $rate = null;

            if ($calcDays > 0) {
                $rateDay = DB::table('rates')->where('name', 'regular')->where('type', 'por dia')->min('id');
                $ticket->rate_id = $rateDay;
                $ticket->save();

                $ticket->load('rate');
            }

            $type = $ticket->rate->type;
            $name = $ticket->rate->name;

            if ($type === 'por hora') {
                $grace = match (true) {
                    $calcHours >= 1 && $calcHours <= 8 => 10,
                    $calcHours >= 9 && $calcHours <= 18 => 15,
                    $calcHours >= 19 && $calcHours <= 23 => 20,
                    default => 15,
                };

                if ($calcMinutes > $grace) {
                    $calcHours += 1;
                } else {
                    $calcHours = $calcHours == 0 ? 1 : $calcHours;
                }

                $rate = Rate::where('type', 'por hora')
                    ->where('name', $name)
                    ->where('quantity', $calcHours)
                    ->first();
            } elseif ($type === 'por dia') {
                if ($diffMinutes > $ticket->rate->grace_period_minutes) {
                    $calcDays += 1;
                } else {
                    $calcDays = $calcDays == 0 ? 1 : $calcDays;
                }

                $rate = Rate::where('type', 'por dia')
                    ->where('name', $name)
                    ->where('quantity', $calcDays)
                    ->first();
            }

            if ($rate) {
                echo $totalAmount = "{$setting->currency} {$rate->cost}";
            } else {
                echo $totalAmount = "{$setting->currency} 0.00";
            }
        } catch (\Exception $e) {
            return redirect()->route('tickets.index')->with('error', 'No se pudo calcular el monto del ticket debido a un error: ' . $e->getMessage());
        }
    }
}
