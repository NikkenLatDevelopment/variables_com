<!DOCTYPE html>
<html lang="es">
@php
function formatoPeriodo($periodo) {
    $anio = substr($periodo, 0, 4);
    $mes = substr($periodo, 4, 2);

    $meses = [
        '01' => 'enero', '02' => 'febrero', '03' => 'marzo',
        '04' => 'abril', '05' => 'mayo', '06' => 'junio',
        '07' => 'julio', '08' => 'agosto', '09' => 'septiembre',
        '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre'
    ];

    return "$anio " . ($meses[$mes] ?? 'Mes desconocido');
}
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Comercial</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #662D91;
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .profile {
            text-align: center;
            padding: 20px;
            background: linear-gradient(to top right, #e0f7fa, #ffffff);
        }

        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #6A1B9A;
            margin-bottom: 10px;
        }

        .data-section {
            padding: 20px;
        }

        .table-container {
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .chart-container {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reporte Comercial</h1>
        </div>

        <!-- Perfil del Socio -->
        <div class="profile">
            @if($resultados[0]->associateId)
                <img src="https://varaiblescom.nikkenlatam.com/custom_lat/img/codes/{{ $resultados[0]->associateId }}-min.jpg" alt="Perfil">
            @else
                <img src="https://via.placeholder.com/100" alt="Perfil">
            @endif
            <h2>ID AssociateID: {{ $resultados[0]->associateId }}</h2>
        </div>

        <div class="data-section">
            <h3>Reporte de Compras - 2024</h3>
            <div class="table-container">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Associate ID</th>
                            <th>Nombre</th>
                            <th>Periodo</th>
                            <th>VO Total</th>
                            <th>VO Comisionable</th>
                            <th>% Comisionable</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resultados as $dato)
                            <tr>
                                <td>{{ $dato->associateId }}</td>
                                <td>{{ $dato->nombre }}</td>
                                <td>{{ formatoPeriodo($dato->periodo) }}</td>
                                <td>{{ number_format($dato->VOtotal, 2) }}</td>
                                <td>{{ number_format($dato->VOcomisionable, 2) }}</td>
                                <td>{{ number_format($dato->Comisionable, 2) }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="chart-container">
            <h3 class="text-center">Gráfico de VO Total</h3>
            <canvas id="voTotalChart"></canvas>
        </div>

        <div class="chart-container">
            <h3 class="text-center">Gráfico de VO Comisionable</h3>
            <canvas id="voComisionableChart"></canvas>
        </div>

        <div class="chart-container">
            <h3 class="text-center">Gráfico de % Comisionable</h3>
            <canvas id="comisionableChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const periodos = @json(array_column($resultados, 'periodo')).map(p => formatoPeriodo(p));
        const voTotales = @json(array_column($resultados, 'VOtotal'));
        const voComisionables = @json(array_column($resultados, 'VOcomisionable'));
        const porcentajesComisionables = @json(array_column($resultados, 'Comisionable'));

        function renderChart(id, label, data) {
            new Chart(document.getElementById(id).getContext('2d'), {
                type: 'line',
                data: {
                    labels: periodos,
                    datasets: [{
                        label: label,
                        data: data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: { display: true, text: label }
                    },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        renderChart('voTotalChart', 'VO Total', voTotales);
        renderChart('voComisionableChart', 'VO Comisionable', voComisionables);
        renderChart('comisionableChart', '% Comisionable', porcentajesComisionables);
    </script>
</body>
</html>
