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
            max-width: 800px;
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
            <img src="https://varaiblescom.nikkenlatam.com/custom_lat/img/codes/470803-min.jpg" alt="Perfil">
            <h2>SOLTERO CURIEL, JOSE ARTURO</h2>
            <p>¡Muchas felicidades!</p>
        </div>

        <div class="data-section">
            <h3>Avances</h3>
            <ul class="data-list">
                <li><span>Directo:</span><span>1999-01-01</span></li>
                <li><span>Superior:</span><span>1998-01-31</span></li>
                <li><span>Ejecutivo:</span><span>1998-01-31</span></li>
                <li><span>Plata:</span><span>1998-01-31</span></li>
                <li><span>Oro:</span><span>1998-01-31</span></li>
                <li><span>Platino:</span><span>1998-01-31</span></li>
                <li><span>Diamante:</span><span>2011-11-30</span></li>
                <li><span>Diamante Real:</span><span>2017-11-30</span></li>
            </ul>
        </div>

        <div class="data-section">
            <h3>Líderes en su Organización</h3>
            <ul class="data-list">
                <li><span>Plata:</span><span>575</span></li>
                <li><span>Oro:</span><span>63</span></li>
                <li><span>Platino:</span><span>47</span></li>
                <li><span>Diamante:</span><span>8</span></li>
                <li><span>Diamante Real:</span><span>4</span></li>
            </ul>
        </div>

        <div class="data-section">
            <h3>Número de Influencers en su Organización</h3>
            <ul class="data-list">
                <li><span>No. de Socios Independientes:</span><span>7,059</span></li>
                <li><span>No. de Clientes Preferentes:</span><span>4,003</span></li>
                <li><span>Activos Mensuales (Promedio):</span><span>1,357</span></li>
                <li><span>Incorporados Mes (Promedio):</span><span>191</span></li>
                <li><span>Socios Independientes Frontales:</span><span>39</span></li>
                <li><span>Niveles de Profundidad:</span><span>18</span></li>
                <li><span>Compras del Último Año (USD):</span><span>$4,548,424</span></li>
            </ul>
        </div>

        <div class="footer">
            <p>Informe Variables Comerciales por Socio Independiente</p>
            <p>Periodo de Medición: Septiembre 2023 a Agosto 2024</p>
        </div>
    </div>
</body>
</html>
