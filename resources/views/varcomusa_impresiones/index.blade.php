
<!doctype html>
<html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Informe Variables Comerciales NA</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('custom_usa/img/favicon/favicon.ico') }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('custom_usa/img/favicon/favicon.ico') }}" type="image/x-icon">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('custom_usa/img/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('custom_usa/img/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('custom_usa/img/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('custom_usa/img/favicon/site.webmanifest') }}">
        <link rel="mask-icon" href="{{ asset('custom_usa/img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#00aba9">
        <meta name="theme-color" content="#ffffff">
        <!-- Favicon -->

        <!-- Librerías nativas -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!-- Librerías nativas -->

        <!-- Librerías adicionales -->
        <link rel="stylesheet" media="screen" href="{{ asset('custom/css/main.css?4.0.0') }}"/>
        <link rel="stylesheet" media="print" href="{{ asset('custom/css/main-print.css?2.0.0') }}"/>
        <!-- Librerías adicionales -->
        <style>
            .loader_div {
                position: fixed;
                top: 0;
                bottom: 0%;
                left: 0;
                right: 0%;
                z-index: 12000;
                opacity: 1;
                display: none;
                background: #fff;
            }

            .messageText {
                padding: 35px;
                border-radius: 10px;
                width: 100%;
                margin: auto;
                    margin-top: auto;
                text-align: center;
                margin-top: 150px;
                position: initial;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            {{-- <input type="hidden" id="env" value="{{ env('ENTORNO') }}"> --}}
            <input type="hidden" id="env" value="test">
            <div id="loader_div_ajax" class="loader_div">
                <div class="messageText">
                    <div class="text-center">
                        <div class="spinner-border spinner-border-sm" role="status" style="width: 2rem;height: 2rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <br>
                    <h2>{{ $nameUser }}</h2>
                    <h4>Estamos actualizando tus datos, al finalizar podrás ver tu información.</h4>
                    <h6>Tiempo de espera estimado 2 minutos.</h6>
                </div>
            </div>
            <!-- Información general -->
            <div class="row gx-0"><div class="col"><div id="chart-0"></div></div></div>
            <!-- Información general -->

            <!-- Información genealogía -->
            {{-- <hr>
            <h2>genealogía Radial</h2>
            <br> --}}
            <div class="row gx-0"><div class="col"><div id="chart-10"></div></div></div>
            <!-- Información genealogía -->

            <!-- Información compras -->
            {{-- <hr>
            <h2>compras</h2>
            <br> --}}
            <div class="row gx-0"><div class="col"><div id="chart-1"></div></div></div>
            <!-- Información compras -->

            <!-- Información inscripciones -->
            {{-- <hr>
            <h2>inscripciones</h2>
            <br> --}}
            <div class="row gx-0"><div class="col"><div id="chart-2"></div></div></div>
            <!-- Información inscripciones -->

            <!-- Información inscripciones totales -->
            {{-- <hr>
            <h2>inscripciones totales</h2>
            <br> --}}
            <div class="row gx-0"><div class="col"><div id="chart-11"></div></div></div>
            <!-- Información inscripciones totales -->

            <!-- Información bonificaciones -->
            {{-- <hr>
            <h2>bonificaciones</h2>
            <br> --}}
            <div class="row gx-0"><div class="col"><div id="chart-3"></div></div></div>
            <!-- Información bonificaciones -->

            <!-- Información volumenes -->
            {{-- <hr>
            <h2>volumenes</h2>
            <br> --}}
            <div class="row gx-0"><div class="col"><div id="chart-4"></div></div></div>
            <!-- Información volumenes -->

            <!-- Información ingresos -->
            {{-- <hr>
            <h2>ingresos</h2>
            <br> --}}
            <div class="row gx-0"><div class="col"><div id="chart-5"></div></div></div>
            <!-- Información ingresos -->

            <!-- Información comparativo -->
            {{-- <hr>
            <h2>comparativo</h2>
            <br> --}}
            <div class="row gx-0"><div class="col"><div id="chart-6"></div></div></div>
            <!-- Información comparativo -->

            <!-- Información composión compra por línea de producto -->
            <div class="row gx-0"><div class="col"><div id="chart-7"></div></div></div>
            <!-- Información composión compra por línea de producto -->

            <!-- Información comparativo venta pimag vs accesorios -->
            <div class="row gx-0"><div class="col"><div id="chart-8"></div></div></div>
            <!-- Información comparativo venta pimag vs accesorios -->

            <!-- Información comportamiento de compra de producto vs compra de repuestos -->
            <div class="row gx-0"><div class="col"><div id="chart-9"></div></div></div>
            <!-- Información comportamiento de compra de producto vs compra de repuestos -->
        </div>
    </body>
    <!-- Librerías nativas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Librerías nativas -->

    <!-- Librerías adicionales -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <script src="{{ asset('custom_na_impresiones/js/main.js?v=' . Date('YmdHis')) }}"></script>
    <!-- Librerías adicionales -->
    <input type="text" id="codeUser" value="{{ $codeUser }}" readonly hidden>
    <input type="text" id="nameUser" value="{{ $nameUser }}" readonly hidden>
    <input type="text" id="countrieUser" value="{{ $countrieUser }}" readonly hidden>
    <input type="text" id="rankUser" value="{{ $rankUser }}" readonly hidden>
    <input type="text" id="periodoQuery" value="{{ $period }}" readonly hidden>
    <input type="text" id="prod" value="{{ config('app.PROD') }}" readonly hidden>
    
    <script>chart0($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#prod").val());</script>
    <script>ventas($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#prod").val());</script>
    <script>chart2($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#prod").val());</script>
    <script>chart11($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#prod").val());</script>
    <script>chart3($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#prod").val());</script>
    <script>volumen($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#prod").val());</script>
    {{-- <script>chart5($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#prod").val());</script> --}}
    {{-- <script>chart6($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#prod").val());</script> --}}
</html>