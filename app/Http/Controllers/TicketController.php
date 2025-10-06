<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\ParkingSpace;
use App\Models\Rate;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        return view('admin.tickets.index', [
            'title' => 'Tickets',
            'spaces' => ParkingSpace::all(),
            'items' => Ticket::latest()->get(),
            'vehicles' => Vehicle::with('customer')->get(),
            'rates' => Rate::all(),
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
}
