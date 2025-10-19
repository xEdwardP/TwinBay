<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
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
            margin-bottom: 30px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #212529;
        }

        .header p {
            font-size: 11px;
            color: #6c757d;
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

        .summary-cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            gap: 15px;
        }

        .summary-card {
            flex: 1;
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #dee2e6;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .summary-card h3 {
            margin: 0 0 8px 0;
            color: #495057;
            font-size: 14px;
            font-weight: normal;
        }

        .summary-card .amount {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .summary-card.total {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .summary-card.total .amount {
            color: #28a745;
        }

        .summary-card.average {
            background-color: #d1ecf1;
            border-color: #bee5eb;
        }

        .summary-card.average .amount {
            color: #17a2b8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 8px 10px;
            font-size: 11px;
        }

        th {
            background-color: #f1f3f5;
            color: #495057;
            text-align: center;
        }

        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        @page {
            margin: 50px 30px 70px 30px;
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
            <h1>Reporte de Ingresos Diarios — {{ $month }} {{ $year }}</h1>
            <p>Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('h:i:s A') }}</p>
        </div>

        <div class="report-info">
            <p><strong>Periodo del reporte:</strong> {{ $month }} - {{ $year }}</p>
        </div>

        <div class="summary-cards">
            <div class="summary-card">
                <h3>Ingreso total del mes</h3>
                <p class="amount">{{ $setting->currency }} {{ number_format($totalMonthly, 2) }}</p>
            </div>

            <div class="summary-card total">
                <h3>Promedio diario</h3>
                <p class="amount">{{ $setting->currency }} {{ number_format($avgDaily, 2) }}</p>
            </div>

            <div class="summary-card average">
                <h3>Mejor día</h3>
                <p class="amount">{{ $setting->currency }} {{ number_format($bestDay->totalDaily, 2) }}</p>
            </div>
        </div>

        @if ($dailyIncome->isEmpty())
            <p style="text-align: center; font-style: italic;">No se encontraron facturas en el rango de fechas
                seleccionado.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Día</th>
                        <th>Fecha</th>
                        <th>Servicios</th>
                        <th>Ingresos</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dailyIncome as $income)
                        @php
                            $date = \Carbon\Carbon::parse($income->date);
                        @endphp
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td style="text-align: center;">{{ ucfirst($date->locale('es')->translatedFormat('l')) }}
                            </td>
                            <td style="text-align: center;">{{ $date->format('d/m/Y') }}</td>
                            <td style="text-align: center;">{{ $income->quantityServices }}</td>
                            <td style="text-align: center;">{{ $setting->currency }}
                                {{ number_format($income->totalDaily, 2) }}</td>
                            <td style="text-align: center;">
                                @if ($income->totalDaily == $maxIncome)
                                    <span style="color: #28a745; font-weight: bold">Mejor ingreso</span>
                                @elseif ($income->totalDaily == $minIncome)
                                    <span style="color: #dc3545; font-weight: bold">Peor ingreso</span>
                                @else
                                    <span>Normal</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4" style="text-align: right;">Monto total ingresado:</td>
                        <td colspan="2" style="text-align: right;">{{ $setting->currency }}
                            {{ number_format($totalMonthly, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        @endif

        <div id="footer">
            <p>Reporte generado por: {{ $setting->name }}<br>
                &copy; {{ now()->format('Y') }} Todos los derechos reservados<br>
                Impreso por: {{ $user->name }}</p>
        </div>
    </div>
</body>

</html>
