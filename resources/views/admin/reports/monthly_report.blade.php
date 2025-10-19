<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            padding: 30px 50px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 22px;
            margin: 0;
        }

        .header p {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        .report-info {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-left: 4px solid #17a2b8;
            margin-bottom: 20px;
        }

        .report-info p {
            margin: 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            font-size: 11px;
        }

        th {
            background-color: #e9ecef;
            text-align: center;
        }

        .total-row {
            background-color: #f1f3f5;
            font-weight: bold;
        }

        @page {
            margin-bottom: 70px;
        }

        #footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Reporte de Facturaciones Mensuales</h1>
            <p>Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('h:i:s A') }}</p>
        </div>

        <div class="report-info">
            <p><strong>Periodo del reporte:</strong> {{ $month }} / {{ $year }}</p>
        </div>

        @if ($invoices->isEmpty())
            <p style="text-align: center; font-style: italic;">No se encontraron facturas en el rango de fechas
                seleccionado.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Placa</th>
                        <th style="width: 200px;">Detalle</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td>{{ $invoice->customer->name }}</td>
                            <td>{{ $invoice->vehicle->license_plate }}</td>
                            <td>{{ $invoice->detail }}</td>
                            <td style="text-align: right;">{{ $setting->currency }}
                                {{ number_format($invoice->total, 2) }}</td>
                            <td style="text-align: center;">
                                {{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4" style="text-align: right;">Monto Total:</td>
                        <td colspan="2" style="text-align: right;">{{ $setting->currency }}
                            {{ number_format($totalAmount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        @endif

        <div id="footer">
            <p style="text-align: center;">Reporte generado por: {{ $setting->name }}<br>
                &copy; {{ now()->format('Y') }} Todos los derechos reservados<br>
                Impreso por: {{ $user->name }}
            </p>
        </div>
    </div>
</body>

</html>
