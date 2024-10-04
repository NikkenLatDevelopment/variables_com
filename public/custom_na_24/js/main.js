//Mostrar información general
    function chart0(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-0");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na_24/pages/charts/chart-0.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val() },
            url: dataUrl,
            success: function(html){ 
                divMensaje.html(html); 

                //Mostrar información genealogía
                setTimeout(function(){ chart10(codeUser, nameUser, countrieUser, rankUser); });
                //Mostrar información genealogía
            }, error: function(){}
        });
    }
//Mostrar información general

//Mostrar información compras
    function ventas(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-1");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na_24/pages/charts/chart-1.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'GET',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val() },
            url: dataUrl,
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información compras

//Mostrar información inscripciones
    function chart2(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-2");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na_24/pages/charts/chart-2.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val() },
            url: dataUrl,
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información inscripciones

//Mostrar información bonificaciones
    function chart3(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-3");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na_24/pages/charts/chart-3.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val() },
            url: dataUrl,
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información bonificaciones

//Mostrar información volúmenes
    function volumen(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-4");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na_24/pages/charts/chart-4.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val() },
            url: dataUrl,
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información volúmenes

//Mostrar información ingresos
    function chart5(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-5");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na_24/pages/charts/chart-5.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val() },
            url: dataUrl,
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información ingresos

//Mostrar información comparativo
    function chart6(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-6");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na_24/pages/charts/chart-6.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val() },
            url: dataUrl,
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información comparativo

//Mostrar información composión compra por línea de producto
    function comprasprod1(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-7");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na_24/pages/charts/chart-7.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val() },
            url: dataUrl,
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información composión compra por línea de producto

//Mostrar información comparativo venta pimag vs accesorios
    function comprasprod2(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-8");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na_24/pages/charts/chart-8.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val() },
            url: dataUrl,
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información comparativo venta pimag vs accesorios

//Mostrar información comportamiento de compra de producto vs compra de repuestos
    function comprasprod3(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-9");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na_24/pages/charts/chart-9.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val() },
            url: dataUrl,
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información comportamiento de compra de producto vs compra de repuestos

//Mostrar información genealogía
    function chart10(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-10");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na_24/pages/charts/chart-10.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val() },
            url: dataUrl,
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información genealogía

//Mostrar información incorporaciones totales
    function chart11(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-11");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na_24/pages/charts/chart-11.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val() },
            url: dataUrl,
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información incorporaciones totales