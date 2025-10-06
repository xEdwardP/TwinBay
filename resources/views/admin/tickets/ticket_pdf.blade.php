<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=300, initial-scale=1.0">
    <title>Ticket #{{ $ticket->ticket_number }}</title>
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

        <div class="title">TICKET #{{ $ticket->ticket_number }}</div>

        <div class="line"></div>

        <div class="section-title">Datos del Cliente</div>
        <div class="info"><strong>Nombre:</strong> {{ $ticket->customer->name }}</div>
        <div class="info"><strong>Documento:</strong> {{ $ticket->customer->document_type }} - {{ $ticket->customer->document_number }}</div>
        <div class="info"><strong>Placa:</strong> {{ $ticket->vehicle->license_plate }}</div>

        <div class="line"></div>

        <div class="section-title">Datos del Ingreso</div>
        <div class="info"><strong>Espacio Nº:</strong> {{ $ticket->parking_space_id }}</div>
        <div class="info"><strong>Fecha:</strong> {{ $ticket->in_date }}</div>
        <div class="info"><strong>Hora:</strong> {{ $ticket->in_time }}</div>

        <div class="line"></div>

        <div class="footer text-center">
            <strong>¡Gracias por su preferencia!</strong><br>
            <strong>Usuario:</strong> {{ $ticket->user->name }}<br>
            <strong>Impreso:</strong> {{ $date }}
        </div>
    </div>
</body>
</html>
