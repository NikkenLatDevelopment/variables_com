
<!doctype html>
<html lang="es">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Informe Variables Comerciales NA</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('custom_na/img/favicon/favicon.ico') }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('custom_na/img/favicon/favicon.ico') }}" type="image/x-icon">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('custom_na/img/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('custom_na/img/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('custom_na/img/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('custom_na/img/favicon/site.webmanifest') }}">
        <link rel="mask-icon" href="{{ asset('custom_na/img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#00aba9">
        <meta name="theme-color" content="#ffffff">
        <!-- Favicon -->

        <!-- Librerías nativas -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!-- Librerías nativas -->

        <!-- Librerías adicionales -->
        <link rel="stylesheet" media="screen" href="{{ asset('custom_na/css/main.css?4.0.0') }}"/>
        <link rel="stylesheet" media="print" href="{{ asset('custom_na/css/main-print.css?2.0.0') }}"/>
        <link rel="stylesheet" href="{{ asset('main/css/var_com_usa/custom.css') }}">
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
                    {{-- <h2>{{ $nameUser }}</h2> --}}
                    <h4>Estamos actualizando tus datos, al finalizar podrás ver tu información.</h4>
                    <h6>Tiempo de espera estimado 2 minutos.</h6>
                </div>
            </div>

            <div class="loader_div_na">
                <div class="contenedor-div-y-titulo">
                    <center>
                        <div class="spinner"></div>
                    </center>
                    <h2 class="titulo">{{__('loading_msg')}}</h2>
                </div>
            </div>

            <div class="row layout-top-spacing w-100 mt-3 portada">
                <div class="col-12 col-lg-10 col-md-12">
                    <blockquote class="blockquote rounded">
                        <h1 class="d-inline">{{ucwords(__('Business_Variables_Report_By_Consultant'))}}</h1>
                        <h3 class="text-end"><b>{{ucwords($data_gral['name_user'])}}</b></h3>
                        <h4 class="">{{ucwords(__('period'))}}: {{ $data_gral['period_i'] }} {{ucwords(__('to'))}} {{$data_gral['period_f']}}</h4>
                    </blockquote>
                </div>
                <div class="col-6 col-lg-2 col-md-4 m-auto">
                    <a class="card style-7" href="javascript:void(0)" target="_blank">
                        <img src="https://media.istockphoto.com/id/612520134/es/vector/icono-de-la-ni%C3%B1a-de-dibujos-animados-avatar-%C3%BAnico-icono-de-personas.jpg?s=612x612&amp;w=0&amp;k=20&amp;c=Qr7Jijd2sk8keBFjgfoTXNHn_teVInKjHe4g8-1MdyA=" class="card-img-top" alt="...">
                    </a>
                </div>
                <div class="col-12 col-lg-4 col-md-6 mt-2">
                    <div class="card mb-3">
                        <div class="card-content">
                            <h4 class="card-title text-center bg-mnk pb-2 pt-2">{{ucwords(__('rank_advancement'))}}</h4>
                            <div class="table-responsive p-2">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('Direct'))}}</td>
                                            <td>{{ $portada[0]->Avances_DIR == 0 ? '' : $portada[0]->Avances_DIR }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('Senior'))}}</td>
                                            <td>{{ $portada[0]->Avances_SUP == 0 ? '' : $portada[0]->Avances_SUP }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('Executive'))}}</td>
                                            <td>{{ $portada[0]->Avances_EXE == 0 ? '' : $portada[0]->Avances_EXE }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('Silver'))}}</td>
                                            <td>{{ $portada[0]->Avances_Plata == 0 ? '' : $portada[0]->Avances_Plata }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('Gold'))}}</td>
                                            <td>{{ $portada[0]->Avances_ORO == 0 ? '' : $portada[0]->Avances_ORO }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('Platinum'))}}</td>
                                            <td>{{ $portada[0]->Avances_PLO == 0 ? '' : $portada[0]->Avances_PLO }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('Diamond'))}}</td>
                                            <td>{{ $portada[0]->Avances_DIA == 0 ? '' : $portada[0]->Avances_DIA }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('Royal_Diamond'))}}</td>
                                            <td>{{ $portada[0]->Avances_DRL == 0 ? '' : $portada[0]->Avances_DRL }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-md-6 mt-2">
                    <div class="card mb-3">
                        <div class="card-content">
                            <h4 class="card-title text-center bg-mnk pb-2 pt-2">{{ucwords(__('leaders_in_your_organization'))}}</h4>
                            <div class="table-responsive p-2">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('Silver'))}}</td>
                                            <td>{{$portada[0]->Lideres_Plata}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('Gold'))}}</td>
                                            <td>{{$portada[0]->Lideres_ORO}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('Platinum'))}}</td>
                                            <td>{{$portada[0]->Lideres_PLO}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('Diamond'))}}</td>
                                            <td>{{$portada[0]->Lideres_DIA}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('Royal_Diamond'))}}</td>
                                            <td>{{$portada[0]->Lideres_DRL}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-md-6 mt-2 mb-5">
                    <div class="card">
                        <div class="card-content">
                            <h4 class="card-title text-center bg-mnk pb-2 pt-2">{{ucwords(__('members_in_your_organization'))}}</h4>
                            <div class="table-responsive p-2">
                                <table class="table table-hover table-sm">
                                    <tbody>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('no_of_consultants'))}}</td>
                                            <td>{{number_format($portada[0]->NAsesores, 0)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('no_of_customers'))}}</td>
                                            <td>{{number_format($portada[0]->NAsesoresPref, 0)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('monthly_active_consultants_(Avg)'))}}</td>
                                            <td>{{number_format($portada[0]->ActivosMensuales_consultants, 0)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('monthly_active_customers_(Avg)'))}}</td>
                                            <td>{{number_format($portada[0]->ActivosMensuales_customer, 0)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('monthly_consultants_sign_ups_(Avg)'))}}</td>
                                            <td>{{number_format($portada[0]->prom_consultans, 0)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('monthly_customers_sign_ups_(Avg)'))}}</td>
                                            <td>{{number_format($portada[0]->prom_costumers, 0)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('frontline_consultants'))}}</td>
                                            <td>{{number_format($portada[0]->Frontalidad_consultants, 0)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('frontline_customers'))}}</td>
                                            <td>{{number_format($portada[0]->Frontalidad_customer, 0)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('depth'))}}</td>
                                            <td>{{number_format($portada[0]->Profundidad, 0)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-end">{{ucwords(__('rolling_year_purchases_(usd)'))}}</td>
                                            <td>{{number_format($portada[0]->ComprasUltimoAño, 0)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    {{-- <img src="http://127.0.0.1:8002/src/img/logo-black.png" class="w-15 mt-2 logo-ft-nk"> --}}
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
            <div class="row gx-0 mt-5"><div class="col"><div id="chart-1"></div></div></div>
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
    <script src="{{ asset('custom_na/js/main.js?' . Date("YmdHis")) }}"></script>
    <!-- Librerías adicionales -->
    <input type="text" id="codeUser" value="{{ $data_gral['code'] }}" readonly hidden>
    <input type="text" id="nameUser" value="{{ $data_gral['name_user'] }}" readonly hidden>
    <input type="text" id="countrieUser" value="{{ $data_gral['countrie_user'] }}" readonly hidden>
    <input type="text" id="rankUser" value="{{ $data_gral['rank_user'] }}" readonly hidden>
    <input type="text" id="periodoQuery" value="{{ $period }}" readonly hidden>
    <input type="text" id="lang" value="{{ $lang }}" readonly hidden>
     
    {{-- <script>chart0($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#lang").val());</script> --}}
    <script>ventas($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#lang").val());</script>
    <script>chart2($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#lang").val());</script>
    <script>chart11($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#lang").val());</script>
    <script>chart3($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#lang").val());</script>
    <script>volumen($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#lang").val());</script>
    <script>chart5($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#lang").val());</script>
    <script>chart6($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val(), $("#lang").val());</script>
</html>