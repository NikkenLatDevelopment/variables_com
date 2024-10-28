<!DOCTYPE html>
<html lang="es">
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

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .flag-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .flag-container img {
            width: 40px;
            border-radius: 50%;
        }

        .profile {
            text-align: center;
            background: linear-gradient(to top right, #e0f7fa, #ffffff);
            padding: 20px;
            position: relative;
        }

        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #6A1B9A;
            margin-bottom: 10px;
        }

        .profile h2 {
            margin: 0;
            font-size: 20px;
            color: #6A1B9A;
        }

        .profile p {
            color: #666;
            margin: 5px 0;
        }

        .data-section {
            padding: 20px;
        }

        .data-section h3 {
            background-color: #9c27b0;
            color: white;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin: 0 0 10px 0;
        }

        .data-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .data-list li {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            font-size: 16px;
        }

        .footer {
            background-color: #f8f8f8;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
        }
    </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reporte Comercial</h1>
            <div class="flag-container">
                <img src="https://flagcdn.com/w40/mx.png" alt="Bandera de México">
            </div>
        </div>

        <div class="profile">
        @if($datos->associateId)
        <img src="https://varaiblescom.nikkenlatam.com/custom_lat/img/codes/{{ $datos->associateId }}-min.jpg" alt="Perfil">
        @else
            <img src="https://via.placeholder.com/100" alt="Perfil">
        @endif
            <h2>{{ $datos->nombre }}</h2>
            <p>¡Muchas felicidades!</p>
        </div>

        <div class="data-section">
        <h3>Datos del Socio</h3>
        <ul class="data-list">
            <li><span>Id AssociateID:</span><span>{{ $datos->associateId }}</span></li>
            <li><span>Periodo:</span><span>{{ $datos->periodo }}</span></li>
            <li><span>VO total:</span><span>{{ $datos->VOtotal }}</span></li>
            <li><span>VO comisionable:</span><span>{{ $datos->VOcomisionable }}</span></li>
            <li><span>% Comisionable:</span><span>{{ $datos->Comisionable }}%</span></li>

        </ul>
        </div>

      
       

        

        <div class="data-section">
            <h3>Reporte de Compras - 2024</h3>
            <div class="table-container">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Meses</th>
                            <th>Ene24</th><th>Feb24</th><th>Mar24</th><th>Abr24</th>
                            <th>May24</th><th>Jun24</th><th>Jul24</th><th>Ago24</th>
                            <th>Total 2024</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Compras Personales (Dólares)</th>
                            <td>120</td><td>150</td><td>180</td><td>210</td>
                            <td>250</td><td>300</td><td>350</td><td>400</td>
                            <td>1960</td>
                        </tr>
                        <tr>
                            <th>Compras de Clientes Preferentes (Dólares)</th>
                            <td>80</td><td>100</td><td>120</td><td>140</td>
                            <td>160</td><td>180</td><td>200</td><td>220</td>
                            <td>1200</td>
                        </tr>
                        <tr>
                            <th>Compras Organizacional (Dólares)</th>
                            <td>500</td><td>550</td><td>600</td><td>650</td>
                            <td>700</td><td>750</td><td>800</td><td>850</td>
                            <td>5400</td>
                        </tr>
                        <tr>
                            <th>Compra Total (Dólares)</th>
                            <td>700</td><td>800</td><td>900</td><td>1000</td>
                            <td>1110</td><td>1230</td><td>1350</td><td>1470</td>
                            <td>8560</td>
                        </tr>
                        <tr>
                            <th>Compra Promedio por Activo (Dólares)</th>
                            <td>70</td><td>80</td><td>90</td><td>100</td>
                            <td>110</td><td>120</td><td>130</td><td>140</td>
                            <td>960</td>
                        </tr>
                        <tr>
                            <th>Crecimiento de la Compra Personal (%)</th>
                            <td>2%</td><td>3%</td><td>5%</td><td>4%</td>
                            <td>6%</td><td>7%</td><td>8%</td><td>9%</td>
                            <td>44%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="chart-container">
            <h3 class="text-center">Gráfico de Compras - 2024</h3>
            <canvas id="comprasChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('comprasChart').getContext('2d');
        const comprasChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ene24', 'Feb24', 'Mar24', 'Abr24', 'May24', 'Jun24', 'Jul24', 'Ago24'],
                datasets: [
                    {
                        label: 'Compras Personales (Dólares)',
                        data: [120, 150, 180, 210, 250, 300, 350, 400],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Compras de Clientes Preferentes (Dólares)',
                        data: [80, 100, 120, 140, 160, 180, 200, 220],
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Compras Organizacional (Dólares)',
                        data: [500, 550, 600, 650, 700, 750, 800, 850],
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Evolución de Compras Mensuales en 2024'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>



    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
