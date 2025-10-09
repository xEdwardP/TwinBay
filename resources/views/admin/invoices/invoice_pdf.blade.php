<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=300, initial-scale=1.0">
    <title>FACTURA #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Arial Narrow', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            max-width: 300px;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .container {
            padding: 8px;
        }

        .text-center {
            text-align: center;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
            margin: 6px 0;
            text-align: center;
        }

        .section-title {
            font-weight: bold;
            margin-top: 6px;
            margin-bottom: 2px;
        }

        .info {
            margin-bottom: 4px;
        }

        .footer {
            font-size: 11px;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px;
            font-size: 10px;
            text-align: center
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center">
            <strong>{{ $setting->name }}</strong><br>
            {{ $setting->description }}<br>
            {{ $setting->address }}<br>
            Sucursal: {{ $setting->branch }}<br>
            Tel: {{ $setting->phone1 }} / {{ $setting->phone2 }}
        </div>

        <div class="line"></div>

        <div class="title">FACTURA #{{ $invoice->invoice_number }}</div>

        <div class="line"></div>

        <div class="section-title">DATOS DEL CLIENTE</div>
        <div class="info"><strong>Nombre:</strong> {{ $invoice->customer->name }}</div>
        <div class="info"><strong>Documento:</strong> {{ $invoice->customer->document_type }} -
            {{ $invoice->customer->document_number }}</div>
        <div class="info"><strong>Placa:</strong> {{ $invoice->vehicle->license_plate }}</div>

        <div class="line"></div>

        <div class="section-title">DATOS DEL SERVICIO</div>
        <div class="info"><strong>Espacio Nº:</strong> {{ $invoice->ticket->parking_space_id }}</div>
        <div class="info"><strong>Fecha de ingreso:</strong> {{ $invoice->ticket->in_date }}</div>
        <div class="info"><strong>Hora de ingreso:</strong> {{ $invoice->ticket->in_time }}</div>
        <div class="info"><strong>Fecha de salida:</strong> {{ $invoice->ticket->out_date }}</div>
        <div class="info"><strong>Hora de salida:</strong> {{ $invoice->ticket->out_time }}</div>

        <div class="line"></div>

        <div>
            <table>
                <thead>
                    <th style="width: 120px">Detalle</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </thead>

                <tbody>
                    <tr>
                        <td>{{ $invoice->detail }}</td>
                        <td>1</td>
                        <td>{{ $setting->currency . ' ' . $invoice->total }}</td>
                    </tr>
                </tbody>
            </table>

            <p style="text-align: right">Monto Total: {{ $setting->currency . ' ' . $invoice->total }}</p>
        </div>

        <div class="line"></div>

        <div style="text-align: center;">
            <img src="{{ $qrCodePNG }}" alt="Código QR"
                style="width: 100px; height: 100px; display: block; margin: 0 auto;">
        </div>

        <div class="line"></div>

        <div class="footer text-center">
            <strong>¡Gracias por su preferencia!</strong><br>
            <strong>Usuario:</strong> {{ $invoice->user->name }}<br>
            <strong>Impreso:</strong> {{ $date }}
        </div>
    </div>
</body>

</html>
