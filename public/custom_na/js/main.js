//Mostrar información general
    function chart0(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-0");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na/pages/charts/chart-0.php?v=' + Math.random() * 100;
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

window.miTimeout = setTimeout(function() {
    var alto_imagen = $("#abi_pwp_link").height();
    $("#abiinfo_div").css('min-height', alto_imagen);
}, 1000);

// mostrar/ocultar div loader
    let requestCount = 0;
    $(".loader_div_na").hide();
    function showLoader(){
        $(".loader_div_na").show();
    }
    function hideLoader(){
        $(".loader_div_na").hide();
    }
// mostrar/ocultar div loader

//Mostrar información compras
    function ventas(codeUser, nameUser, countrieUser, rankUser, lang){
        var divMensaje = $("#chart-1");
        requestCount++;
        if (requestCount >= 1) {
            showLoader();
        }

        var dataUrl = 'custom_na/pages/charts/chart-1.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'GET',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val(), lang: lang },
            url: dataUrl,
            success: function(html){ 
                divMensaje.html(html);

                requestCount--;
                if (requestCount === 0) {
                    hideLoader();
                }
            },
            error: function(){
                hideLoader();
            }
        });
    }
//Mostrar información compras

//Mostrar información inscripciones
    function chart2(codeUser, nameUser, countrieUser, rankUser, lang){
        var divMensaje = $("#chart-2");
        requestCount++;
        if (requestCount >= 1) {
            showLoader();
        }

        var dataUrl = 'custom_na/pages/charts/chart-2.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val(), lang: lang },
            url: dataUrl,
            beforeSend: function(){
                showLoader();
            },
            success: function(html){
                divMensaje.html(html);

                requestCount--;
                if (requestCount === 0) {
                    hideLoader();
                }
            },
            error: function(){
                hideLoader();
            }
        });
    }
//Mostrar información inscripciones

//Mostrar información bonificaciones
    function chart3(codeUser, nameUser, countrieUser, rankUser, lang){
        var divMensaje = $("#chart-3");
        requestCount++;
        if (requestCount >= 1) {
            showLoader();
        }

        var dataUrl = 'custom_na/pages/charts/chart-3.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val(), lang: lang },
            url: dataUrl,
            beforeSend: function(){
                showLoader();
            },
            success: function(html){ 
                divMensaje.html(html);
                
                requestCount--;
                if (requestCount === 0) {
                    hideLoader();
                }
            },
            error: function(){
                hideLoader();
            }
        });
    }
//Mostrar información bonificaciones

//Mostrar información volúmenes
    function volumen(codeUser, nameUser, countrieUser, rankUser, lang){
        var divMensaje = $("#chart-4");
        requestCount++;
        if (requestCount >= 1) {
            showLoader();
        }

        var dataUrl = 'custom_na/pages/charts/chart-4.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val(), lang: lang },
            url: dataUrl,
            beforeSend: function(){
                showLoader();
            },
            success: function(html){ 
                divMensaje.html(html);
                
                requestCount--;
                if (requestCount === 0) {
                    hideLoader();
                }
            },
            error: function(){
                hideLoader();
            }
        });
    }
//Mostrar información volúmenes

//Mostrar información ingresos
    function chart5(codeUser, nameUser, countrieUser, rankUser, lang){
        var divMensaje = $("#chart-5");
        requestCount++;
        if (requestCount >= 1) {
            showLoader();
        }

        var dataUrl = 'custom_na/pages/charts/chart-5.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val(), lang: lang },
            url: dataUrl,
            beforeSend: function(){
                showLoader();
            },
            success: function(html){ 
                divMensaje.html(html);
                
                requestCount--;
                if (requestCount === 0) {
                    hideLoader();
                }
            },
            error: function(){
                hideLoader();
            }
        });
    }
//Mostrar información ingresos

//Mostrar información comparativo
    function chart6(codeUser, nameUser, countrieUser, rankUser, lang){
        var divMensaje = $("#chart-6");
        requestCount++;
        if (requestCount >= 1) {
            showLoader();
        }

        var dataUrl = 'custom_na/pages/charts/chart-6.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val(), lang: lang },
            url: dataUrl,
            beforeSend: function(){
                showLoader();
            },
            success: function(html){ 
                divMensaje.html(html);
                
                requestCount--;
                if (requestCount === 0) {
                    hideLoader();
                }
            },
            error: function(){
                hideLoader();
            }
        });
    }
//Mostrar información comparativo

//Mostrar información composión compra por línea de producto
    function comprasprod1(codeUser, nameUser, countrieUser, rankUser){
        var divMensaje = $("#chart-7");
        divMensaje.html('<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        var dataUrl = 'custom_na/pages/charts/chart-7.php?v=' + Math.random() * 100;
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

        var dataUrl = 'custom_na/pages/charts/chart-8.php?v=' + Math.random() * 100;
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

        var dataUrl = 'custom_na/pages/charts/chart-9.php?v=' + Math.random() * 100;
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

        var dataUrl = 'custom_na/pages/charts/chart-10.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val() },
            url: dataUrl,
            success: function(html){ divMensaje.html(html); }, error: function(){}
        });
    }
//Mostrar información genealogía

//Mostrar información incorporaciones totales
    function chart11(codeUser, nameUser, countrieUser, rankUser, lang){
        var divMensaje = $("#chart-11");
        requestCount++;
        if (requestCount >= 1) {
            showLoader();
        }

        var dataUrl = 'custom_na/pages/charts/chart-11.php?v=' + Math.random() * 100;
        $.ajax({
            type: 'POST',
            data: { codeUser:codeUser, nameUser:nameUser, countrieUser:countrieUser, rankUser:rankUser, periodo: $("#periodoQuery").val(), lang: lang },
            url: dataUrl,
            beforeSend: function(){
                showLoader();
            },
            success: function(html){ 
                divMensaje.html(html);
                
                requestCount--;
                if (requestCount === 0) {
                    hideLoader();
                }
            },
            error: function(){
                hideLoader();
            }
        });
    }
//Mostrar información incorporaciones totales