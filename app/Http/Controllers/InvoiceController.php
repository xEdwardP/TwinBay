<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;
use Milon\Barcode\Facades\DNS2DFacade as DNS2D;

class InvoiceController extends Controller
{
    public function index() {}

    public function create() {}

    public function store(Request $request) {}

    public function show(Invoice $invoice) {}

    public function edit(Invoice $invoice) {}

    public function update(Request $request, Invoice $invoice) {}

    public function destroy(Invoice $invoice) {}

    public function printInvoice($id)
    {
        try {
            $invoice = Invoice::with('customer', 'vehicle')->findOrFail($id);
            
            $codeQR = "Esta factura # {$invoice->invoice_number} corresponde al cliente: {$invoice->customer->name} "
                . "con numero de documento: {$invoice->customer->document_number}, "
                . "con la placa del vehiculo: {$invoice->vehicle->license_plate}, "
                . "por el concepto de: {$invoice->detail}, con un costo total de: L.{$invoice->total}";

            $qrCodePNG = 'data:image/png;base64,' . DNS2D::getBarcodePNG($codeQR, 'QRCODE', 4, 4);

            $pdf = Pdf::loadView('admin.invoices.invoice_pdf', [
                'invoice' => $invoice,
                'setting' => Setting::first(),
                'date' => Carbon::now(),
                'qrCodePNG' => $qrCodePNG,
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
            return $pdf->stream('Factura_' . $invoice->invoice_number . '.pdf');
        } catch (\Exception $e) {
            return redirect()->route('tickets.index')->with('error', 'No se pudo imprimir la factura debido a un error: ' . $e->getMessage());
        }
    }
}
