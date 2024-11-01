<!DOCTYPE html>
<html lang="es">
@php
$isPdf = request()->route() && request()->route()->named('reporte.pdf');
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

$rangoNombres = [
    1 => 'Directo',
    2 => 'Superior',
    3 => 'Ejecutivo',
    4 => 'Bronce',
    5 => 'Plata',
    6 => 'Oro',
    7 => 'Platino',
    8 => 'Diamante',
    9 => 'Diamante Real'
];
$nombreRango = $rangoNombres[$resultados[0]->Ranking] ?? 'Rango desconocido';

$rangohistorico = [
    1 => 'Directo',
    2 => 'Superior',
    3 => 'Ejecutivo',
    4 => 'Bronce',
    5 => 'Plata',
    6 => 'Oro',
    7 => 'Platino',
    8 => 'Diamante',
    9 => 'Diamante Real'
];


// Configurar datos del gráfico para QuickChart.io
$periodos = array_map(fn($dato) => formatoPeriodo($dato->periodo), $resultados);
$voComisionables = array_map(fn($dato) => $dato->VOcomisionable, $resultados);

$chartConfig = [
    'type' => 'line',
    'data' => [
        'labels' => $periodos,
        'datasets' => [[
            'label' => 'VO Comisionable',
            'data' => $voComisionables,
            'borderColor' => 'rgba(153, 102, 255, 1)',
            'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
            'fill' => true,
        ]]
    ],
    'options' => [
        'plugins' => [
            'legend' => ['display' => false],
            'title' => ['display' => true, 'text' => 'Evolución de VO Comisionable']
        ],
        'scales' => [
            'y' => ['beginAtZero' => true]
        ]
    ]
];

// Codificar en JSON y pasar a la URL de QuickChart.io
$chartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig));
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Volumen 24 meses</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            font-size: 12px;
        }

        .container {
            max-width: 100%;
            margin: 20px auto;
            padding: 15px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #662D91;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .header h1 {
            font-size: 1.5em;
            margin: 0;
        }

        .profile {
            text-align: center;
            background: linear-gradient(to top right, #e0f7fa, #ffffff);
            padding: 10px;
        }

        .perfil-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #6A1B9A;
            margin-bottom: 10px;
        }

        .flag-container {
            text-align: center;
            margin-top: 10px;
            padding: 10px;
            background: linear-gradient(to top right, #e0f7fa, #ffffff);
            border-radius: 15px;
            padding: 10px;
        }

        .flag-img {
            display: inline-block;
            width: 40px;
            height: auto;
        }

        .data-section {
            padding: 10px;
        }

        .table-container {
            padding: 5px;
            overflow-x: auto;
            padding: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        th, td {
            padding: 2px;
            font-size: 10px;
            border: 1px solid #ddd;
            padding: 3px;
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
            padding: 10px;
            text-align: center;
            
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reporte de Volumen 24 meses</h1>
        </div>

        <!-- Perfil del Socio -->
        <div class="profile">
            @if($resultados[0]->associateId)
                <img class="perfil-img" src="https://storage.googleapis.com/vivenikken/sites/regional/commercial-variables/codes/{{ $resultados[0]->associateId }}.jpg" alt="Perfil">
            @else
                <img class="perfil-img" src="{{ asset('images/default-profile.png') }}" alt="Perfil">
            @endif

            <h2>Código de Asesor de Bienestar: {{ $resultados[0]->associateId }}</h2>
            <h2>Nombre: {{ $resultados[0]->nombre }}</h2>
            <h2>Rango: {{ $nombreRango }}</h2>
        </div>

        <!-- Contenedor independiente para la bandera --> 
        <div class="flag-container">
            @php
                $paisesISO = [
                    'MEX' => 'mx', 'CHL' => 'cl', 'PER' => 'pe', 'COL' => 'co',
                    'ECU' => 'ec', 'GTM' => 'gt', 'SLV' => 'sv', 'PAN' => 'pa',
                    'CRI' => 'cr', 'CAN' => 'ca', 'USA' => 'us'
                ];
                $codigoISO = $paisesISO[$resultados[0]->pais] ?? 'unknown';
            @endphp

            @if($codigoISO !== 'unknown')
                <img class="flag-img" src="https://flagcdn.com/w40/{{ $codigoISO }}.png" alt="Bandera de {{ $resultados[0]->pais }}">
            @else
                <p>Bandera no disponible</p>
            @endif
        </div>

        <!-- Tabla de Datos -->
        <div class="data-section">
            <h3>Reporte de Compras - 2024</h3>
            <div class="table-container">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Periodo</th>
                            <th>Rango de Pago</th>
                            <th>VO Total</th>
                            <th>VO Comisionable</th>
                            <th>% Comisionable</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resultados as $dato)
                            <tr>
                                <td>{{ formatoPeriodo($dato->periodo) }}</td>
                                <td>{{ $rangohistorico[$dato->rango] }}</td>
                                <td>{{ number_format($dato->VOtotal, 2) }}</td>
                                <td>{{ number_format($dato->VOcomisionable, 2) }}</td>
                                <td>{{ number_format($dato->Comisionable, 2) }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Gráfico de VO Comisionable -->
        <div class="chart-container">
            <h3 class="text-center">Gráfico de VO Comisionable</h3>
            @if($isPdf)
                <!-- Mostrar la imagen generada de QuickChart.io para el PDF -->
                <img src="{{ $chartUrl }}" alt="Gráfico de VO Comisionable" style="width: 100%; max-width: 1000px; height: auto; max-height: 550px; margin: 0 auto; display: block;">
            @else
                <!-- Mostrar el gráfico interactivo en la versión web -->
                <canvas id="voComisionableChart"></canvas>
                <img src="{{ $chartUrl }}" alt="Gráfico de VO Comisionable" style="width: 100%; max-width: 1000px; height: auto; max-height: 550px; margin: 0 auto; display: block;">

            @endif
        </div>
    </div>

  
</body>
</html>
