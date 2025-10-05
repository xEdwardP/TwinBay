<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\ParkingSpace;
use App\Models\Rate;
use App\Models\Ticket;
use App\Models\Vehicle;
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
                return redirect()->route('tickets.index')->with('error', 'El vehículo ya tiene un ticket activo.');
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
            echo $dateTime = Carbon::now();
            $ticket->in_date = $dateTime->toDateString();
            $ticket->in_time = $dateTime->toTimeString();

            $ticket->ticket_status = 'activo';
            $ticket->observations = $validated['observations'];
            $ticket->save();

            // Update Parking Space Status
            $parkingSpace = ParkingSpace::findOrFail($validated['parking_space_id']);
            $parkingSpace->parking_status = 'ocupado';
            $parkingSpace->save();

            return redirect()->route('tickets.index')->with('success', 'Ticket creado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->route('tickets.index')->with('error', 'No se pudo generar el ticket: ' . $e->getMessage());
        }
    }

    public function show(Ticket $ticket)
    {
        //
    }

    public function edit(Ticket $ticket)
    {
        //
    }

    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    public function destroy(Ticket $ticket)
    {
        //
    }

    public function searchVehicle($id)
    {
        $vehicle = Vehicle::with('customer')->findOrFail($id);
        return view('admin.tickets.search_vehicle', [
            'title' => 'Buscar vehículo',
            'vehicle' => $vehicle,
        ]);
    }
}
