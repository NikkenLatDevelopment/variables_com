//Mostrar información general
    function chart0(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-0");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser },
            url: 'custom/pages/charts/chart-0.php',
            success: function(html){ 
                divMensaje.html(html); 

                //Mostrar información genealogía
                setTimeout(function(){ chart10(codeUser, nameUser, countrieUser, rankUser); });
                //Mostrar información genealogía
            }, error: function(){}
        });
    }
//Mostrar información general

function LLenadoIncorp(codeUser){
    $.ajax({
        type: "get",
        url: "LLenadoIncorp",
        data: {
            codeUser: codeUser,
        },
        beforeSend: function() {
            $(".loader_div").show();
        },
        success: function (response) {
           Incorp_C(codeUser);
        },
        error: function () {
            $(".loader_div").hide();
            alert("Ocurrio un error al extraer la información, reintente nuevamente o pongase en contacto con Servicio al Cliente de su país");
        }
    });
}

function Incorp_C(codeUser){
    $.ajax({
        type: "get",
        url: "Incorp_C",
        data: {
            codeUser: codeUser,
        },
        beforeSend: function() {
            $(".loader_div").show();
        },
        success: function (response) {
            compras_llenado(codeUser);
        },
        error: function () {
            $(".loader_div").hide();
            alert("Ocurrio un error al extraer la información, reintente nuevamente o pongase en contacto con Servicio al Cliente de su país");
        }
    });
}

// function Incorp_CTrimestrales(codeUser){
//     $.ajax({
//         type: "get",
//         url: "Incorp_CTrimestrales",
//         data: {
//             codeUser: codeUser,
//         },
//         beforeSend: function() {
//             $(".loader_div").show();
//         },
//         success: function (response) {
//             IncorpConAactividad_Trimestral(codeUser);
//         },
//         error: function () {
//             $(".loader_div").hide();
//             alert("Ocurrio un error al extraer la información, reintente nuevamente o pongase en contacto con Servicio al Cliente de su país");
//         }
//     });
// }

// function IncorpConAactividad_Trimestral(codeUser){
//     $.ajax({
//         type: "get",
//         url: "IncorpConAactividad_Trimestral",
//         data: {
//             codeUser: codeUser,
//         },
//         beforeSend: function() {
//             $(".loader_div").show();
//         },
//         success: function (response) {
//             compras_llenado(codeUser);
//         },
//         error: function () {
//             $(".loader_div").hide();
//             alert("Ocurrio un error al extraer la información, reintente nuevamente o pongase en contacto con Servicio al Cliente de su país");
//         }
//     });
// }

function compras_llenado(codeUser){
    $.ajax({
        type: "get",
        url: "compras_llenado",
        data: {
            codeUser: codeUser,
        },
        beforeSend: function() {
            $(".loader_div").show();
        },
        success: function (response) {
            ConteoComercialD1(codeUser);
        },
        error: function () {
            $(".loader_div").hide();
            alert("Ocurrio un error al extraer la información, reintente nuevamente o pongase en contacto con Servicio al Cliente de su país");
        }
    });
}

function ConteoComercialD1(codeUser){
    $.ajax({
        type: "get",
        url: "ConteoComercialD1",
        data: {
            codeUser: codeUser,
        },
        beforeSend: function() {
            $(".loader_div").show();
        },
        success: function (response) {
            Total_ORG(codeUser);
        },
        error: function () {
            $(".loader_div").hide();
            alert("Ocurrio un error al extraer la información, reintente nuevamente o pongase en contacto con Servicio al Cliente de su país");
        }
    });
}

function Total_ORG(codeUser){
    $.ajax({
        type: "get",
        url: "Total_ORG",
        data: {
            codeUser: codeUser,
        },
        beforeSend: function() {
            $(".loader_div").show();
        },
        success: function (response) {
            Bonificaciones_SD_ORG_LLenado(codeUser);
        },
        error: function () {
            $(".loader_div").hide();
            alert("Ocurrio un error al extraer la información, reintente nuevamente o pongase en contacto con Servicio al Cliente de su país");
        }
    });
}

function Bonificaciones_SD_ORG_LLenado(codeUser){
    $.ajax({
        type: "get",
        url: "Bonificaciones_SD_ORG_LLenado",
        data: {
            codeUser: codeUser,
        },
        beforeSend: function() {
            $(".loader_div").show();
        },
        success: function (response) {
            $(".loader_div").hide();
            chart0($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val());
            ventas($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val());
            chart2($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val());
            chart11($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val());
            chart3($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val());
            volumen($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val());
            chart5($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val());
            chart6($("#codeUser").val(), $("#nameUser").val(), $("#countrieUser").val(), $("#rankUser").val());
        },
        error: function () {
            $(".loader_div").hide();
            alert("Ocurrio un error al extraer la información, reintente nuevamente o pongase en contacto con Servicio al Cliente de su país");
        }
    });
}

//Mostrar información compras
    function ventas(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-1");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            type: 'GET',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser },
            url: 'custom/pages/charts/chart-1.php',
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información compras

//Mostrar información inscripciones
    function chart2(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-2");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser },
            url: 'custom/pages/charts/chart-2.php',
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información inscripciones

//Mostrar información bonificaciones
    function chart3(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-3");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser },
            url: 'custom/pages/charts/chart-3.php',
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información bonificaciones

//Mostrar información volúmenes
    function volumen(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-4");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser },
            url: 'custom/pages/charts/chart-4.php',
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información volúmenes

//Mostrar información ingresos
    function chart5(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-5");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser },
            url: 'custom/pages/charts/chart-5.php',
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información ingresos

//Mostrar información comparativo
    function chart6(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-6");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser },
            url: 'custom/pages/charts/chart-6.php',
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información comparativo

//Mostrar información composión compra por línea de producto
    function comprasprod1(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-7");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser },
            url: 'custom/pages/charts/chart-7.php',
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información composión compra por línea de producto

//Mostrar información comparativo venta pimag vs accesorios
    function comprasprod2(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-8");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser },
            url: 'custom/pages/charts/chart-8.php',
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información comparativo venta pimag vs accesorios

//Mostrar información comportamiento de compra de producto vs compra de repuestos
    function comprasprod3(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-9");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser },
            url: 'custom/pages/charts/chart-9.php',
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información comportamiento de compra de producto vs compra de repuestos

//Mostrar información genealogía
    function chart10(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-10");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser },
            url: 'custom/pages/charts/chart-10.php',
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información genealogía

//Mostrar información incorporaciones totales
    function chart11(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-11");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser },
            url: 'custom/pages/charts/chart-11.php',
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información incorporaciones totales