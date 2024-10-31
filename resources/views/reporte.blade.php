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
$rangoNombres = [
    1 => 'Directo',
    2 => 'Superior',
    3 => 'Ejecutivo',
    4 => 'Plata',
    5 => 'Oro',
    6 => 'Platino',
    7 => 'Diamante',
    8 => 'Diamante Real'
];
$nombreRango = $rangoNombres[$resultados[0]->Ranking] ?? 'Rango desconocido';
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Volumen 24 meses    </title>
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 1200px;
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
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        text-align: center;
    }

    .header h1 {
        font-size: 1.5em;
        margin: 0;
        flex: 1 100%;
    }

    .profile {
        text-align: center;
        background: linear-gradient(to top right, #e0f7fa, #ffffff);
        padding: 20px;
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
    }

    .flag-img {
        display: inline-block;
        width: 40px;
        height: auto;
    }

    .data-section {
        padding: 20px;
    }

    .table-container {
        padding: 20px;
        overflow-x: auto; /* Para permitir desplazamiento horizontal en pantallas pequeñas */
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

    /* Media Queries para Responsividad */
    @media (max-width: 768px) {
        .container {
            padding: 10px;
            border-radius: 8px;
        }

        .header {
            flex-direction: column;
            padding: 10px;
        }

        .header h1 {
            font-size: 1.2em;
        }

        .perfil-img {
            width: 80px;
            height: 80px;
        }

        .data-section,
        .chart-container {
            padding: 15px;
        }

        .table-container {
            padding: 10px;
        }

        th, td {
            padding: 6px;
        }
    }

    @media (max-width: 480px) {
        .perfil-img {
            width: 60px;
            height: 60px;
        }

        .header h1 {
            font-size: 1em;
        }

        th, td {
            font-size: 0.8em;
            padding: 4px;
        }

        .flag-container {
            padding: 8px;
        }

        .chart-container {
            padding: 10px;
        }
    }
</style>

</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reporte de Volumen 24 meses
            </h1>
        </div>


        <!-- Perfil del Socio -->
        <div class="profile">
            @if($resultados[0]->associateId)
                <img class="perfil-img" src="https://varaiblescom.nikkenlatam.com/custom_lat/img/codes/{{ $resultados[0]->associateId }}-min.jpg" alt="Perfil">
            @else
            <img class="perfil-img" src="https://varaiblescom.nikkenlatam.com/custom_lat/img/codes/{{ $resultados[0]->associateId }}-min.jpg" alt="Perfil">

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
                            <th>VO Total</th>
                            <th>VO Comisionable</th>
                            <th>% Comisionable</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resultados as $dato)
                            <tr>
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

        <!-- Gráfico de VO Total -->
        <div class="chart-container">
        <!--    <h3 class="text-center">Gráfico de VO Total</h3>-->
            <canvas id="voTotalChart"></canvas>
        </div>
    </div>

    <!-- Cargar Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script para Renderizar el Gráfico de VO Total -->
    <script>
        const periodos = @json(array_column($resultados, 'periodo')).map(periodo => {
            const anio = periodo.slice(0, 4); // Obtiene el año
            const mes = periodo.slice(4, 6);  // Obtiene el mes en formato MM
            const meses = {
                '01': 'enero', '02': 'febrero', '03': 'marzo', '04': 'abril', '05': 'mayo', '06': 'junio',
                '07': 'julio', '08': 'agosto', '09': 'septiembre', '10': 'octubre', '11': 'noviembre', '12': 'diciembre'
            };
            return `${anio} ${meses[mes] || 'Mes desconocido'}`; // Usa el nombre del mes o 'Mes desconocido' si no coincide
        });

        const voTotales = @json(array_column($resultados, 'VOtotal'));

        new Chart(document.getElementById('voTotalChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: periodos,
                datasets: [{
                    label: 'VO Total',
                    data: voTotales,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Evolución de VO Total' }
                },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</body>
</html>
