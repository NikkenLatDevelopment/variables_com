function eliminarComas(texto) {
  return texto.replace(/,/g, "");
}

txtMont0 = $("#txtMont0").text();
txtMont1 = $("#txtMont1").text();
txtMont2 = $("#txtMont2").text();
txtMont3 = $("#txtMont3").text();
txtMont4 = $("#txtMont4").text();
txtMont5 = $("#txtMont5").text();
txtMont6 = $("#txtMont6").text();
txtMont7 = $("#txtMont7").text();
txtMont8 = $("#txtMont8").text();
txtMont9 = $("#txtMont9").text();
txtMont10 = $("#txtMont10").text();
txtMont11 = $("#txtMont11").text();
var labels = [txtMont11, txtMont10, txtMont9, txtMont8, txtMont7, txtMont6, txtMont5, txtMont4, txtMont3, txtMont2, txtMont1, txtMont0];

function h1_graph_1(){
    montActive0 = parseInt(eliminarComas($("#montActive0").text()));
    montActive1 = parseInt(eliminarComas($("#montActive1").text()));
    montActive2 = parseInt(eliminarComas($("#montActive2").text()));
    montActive3 = parseInt(eliminarComas($("#montActive3").text()));
    montActive4 = parseInt(eliminarComas($("#montActive4").text()));
    montActive5 = parseInt(eliminarComas($("#montActive5").text()));
    montActive6 = parseInt(eliminarComas($("#montActive6").text()));
    montActive7 = parseInt(eliminarComas($("#montActive7").text()));
    montActive8 = parseInt(eliminarComas($("#montActive8").text()));
    montActive9 = parseInt(eliminarComas($("#montActive9").text()));
    montActive10 = parseInt(eliminarComas($("#montActive10").text()));
    montActive11 = parseInt(eliminarComas($("#montActive11").text()));
    var montActive_values = [montActive11, montActive10, montActive9, montActive8, montActive7, montActive6, montActive5, montActive4, montActive3, montActive2, montActive1, montActive0];

    CompraTotal0 = parseInt(eliminarComas($("#CompraTotal0").text()));
    CompraTotal1 = parseInt(eliminarComas($("#CompraTotal1").text()));
    CompraTotal2 = parseInt(eliminarComas($("#CompraTotal2").text()));
    CompraTotal3 = parseInt(eliminarComas($("#CompraTotal3").text()));
    CompraTotal4 = parseInt(eliminarComas($("#CompraTotal4").text()));
    CompraTotal5 = parseInt(eliminarComas($("#CompraTotal5").text()));
    CompraTotal6 = parseInt(eliminarComas($("#CompraTotal6").text()));
    CompraTotal7 = parseInt(eliminarComas($("#CompraTotal7").text()));
    CompraTotal8 = parseInt(eliminarComas($("#CompraTotal8").text()));
    CompraTotal9 = parseInt(eliminarComas($("#CompraTotal9").text()));
    CompraTotal10 = parseInt(eliminarComas($("#CompraTotal10").text()));
    CompraTotal11 = parseInt(eliminarComas($("#CompraTotal11").text()));
    var CompraTotal_values = [CompraTotal11, CompraTotal10, CompraTotal9, CompraTotal8, CompraTotal7, CompraTotal6, CompraTotal5, CompraTotal4, CompraTotal3, CompraTotal2, CompraTotal1, CompraTotal0];

    var data_h1_graph_1 = {
        chart: {
            height: 550,
            type: 'line',
            toolbar: {
                show: false,
            },
            zoom: {
                enabled: false
            }
        },
        series: [{
            name: 'Purchases (USD)',
            type: 'column',
            data: CompraTotal_values
        }, 
        {
            name: 'Monthly Actives',
            type: 'line',
            data: montActive_values
        }],
        colors:['rgba(241, 185, 42, 1)', 'rgba(220, 123, 79, 1)'],
        stroke: {
            width: [0, 4]
        },
        title: {
            text: 'Purchasing behaviour vs Monthly Actives',
            align: 'center'
        },
        labels: labels,
        xaxis: {
            type: 'text'
        },
        yaxis: [{
            title: {
                text: 'USD',
            },
        }, 
        {
            opposite: true,
            title: {
                text: 'Monthly Actives'
            }
        }],
        legend: {
            position: 'top',
            horizontalAlign: 'center',
            offsetY: 10,
            markers: {
                shape: 'square',
                width: 20,
                height: 12,
                radius: 0,
                strokeWidth: 0
            }
        },
        markers: {
            size: 5,
        }
    }

    var div_h1_graph_1 = new ApexCharts(
        document.querySelector("#h1-graph-1"),
        data_h1_graph_1
    );
    div_h1_graph_1.render();
}
h1_graph_1();

function h1_graph_2(){
    CompraPromedioXActivoUSD11 = parseInt(eliminarComas($("#CompraPromedioXActivoUSD11").text()));
    CompraPromedioXActivoUSD10 = parseInt(eliminarComas($("#CompraPromedioXActivoUSD10").text()));
    CompraPromedioXActivoUSD9 = parseInt(eliminarComas($("#CompraPromedioXActivoUSD9").text()));
    CompraPromedioXActivoUSD8 = parseInt(eliminarComas($("#CompraPromedioXActivoUSD8").text()));
    CompraPromedioXActivoUSD7 = parseInt(eliminarComas($("#CompraPromedioXActivoUSD7").text()));
    CompraPromedioXActivoUSD6 = parseInt(eliminarComas($("#CompraPromedioXActivoUSD6").text()));
    CompraPromedioXActivoUSD5 = parseInt(eliminarComas($("#CompraPromedioXActivoUSD5").text()));
    CompraPromedioXActivoUSD4 = parseInt(eliminarComas($("#CompraPromedioXActivoUSD4").text()));
    CompraPromedioXActivoUSD3 = parseInt(eliminarComas($("#CompraPromedioXActivoUSD3").text()));
    CompraPromedioXActivoUSD2 = parseInt(eliminarComas($("#CompraPromedioXActivoUSD2").text()));
    CompraPromedioXActivoUSD1 = parseInt(eliminarComas($("#CompraPromedioXActivoUSD1").text()));
    CompraPromedioXActivoUSD0 = parseInt(eliminarComas($("#CompraPromedioXActivoUSD0").text()));
    var CompraPromedioXActivoUSD = [CompraPromedioXActivoUSD11, CompraPromedioXActivoUSD10, CompraPromedioXActivoUSD9, CompraPromedioXActivoUSD8, CompraPromedioXActivoUSD7, CompraPromedioXActivoUSD6, CompraPromedioXActivoUSD5, CompraPromedioXActivoUSD4, CompraPromedioXActivoUSD3, CompraPromedioXActivoUSD2, CompraPromedioXActivoUSD1, CompraPromedioXActivoUSD0];

    var data_h1_graph_2 = {
        chart: {
            height: 550,
            type: 'line',
            toolbar: {
                show: false,
            },
            zoom: {
                enabled: false
            }
        },
        series: [{
            name: "Average Purchases by Active (USD)",
            data: CompraPromedioXActivoUSD
        }],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        title: {
            text: 'Average Purchases by Active (USD)',
            align: 'center'
        },
        grid: {
            row: {
                colors: ['#fff', 'transparent'],
                opacity: 0.5
            },
        },
        yaxis: {
            title: {
                text: 'USD'
            }
        },
        xaxis: {
            categories: labels
        },
        colors:['rgba(220, 123, 79, 1)'],
        legend: {
            position: 'top',
            horizontalAlign: 'center',
            offsetY: 10,
            markers: {
                shape: 'square',
                width: 20,
                height: 12,
                radius: 0,
                strokeWidth: 0
            }
        },
        markers: {
            size: 5,
        }
    }

    var div_h1_graph_2 = new ApexCharts(
        document.querySelector("#h1-graph-2"),
        data_h1_graph_2
    );
    div_h1_graph_2.render();
}
h1_graph_2();

function h2_graph_1(){
    Activos_mensualesAbi0 = parseInt(eliminarComas($("#Activos_mensualesAbi0").text()));
    Activos_mensualesAbi2 = parseInt(eliminarComas($("#Activos_mensualesAbi2").text()));
    Activos_mensualesAbi3 = parseInt(eliminarComas($("#Activos_mensualesAbi3").text()));
    Activos_mensualesAbi4 = parseInt(eliminarComas($("#Activos_mensualesAbi4").text()));
    Activos_mensualesAbi5 = parseInt(eliminarComas($("#Activos_mensualesAbi5").text()));
    Activos_mensualesAbi6 = parseInt(eliminarComas($("#Activos_mensualesAbi6").text()));
    Activos_mensualesAbi7 = parseInt(eliminarComas($("#Activos_mensualesAbi7").text()));
    Activos_mensualesAbi8 = parseInt(eliminarComas($("#Activos_mensualesAbi8").text()));
    Activos_mensualesAbi9 = parseInt(eliminarComas($("#Activos_mensualesAbi9").text()));
    Activos_mensualesAbi10 = parseInt(eliminarComas($("#Activos_mensualesAbi10").text()));
    Activos_mensualesAbi11 = parseInt(eliminarComas($("#Activos_mensualesAbi11").text()));
    var values_Activos_mensualesAbi = [Activos_mensualesAbi11, Activos_mensualesAbi10, Activos_mensualesAbi9, Activos_mensualesAbi8, Activos_mensualesAbi7, Activos_mensualesAbi6, Activos_mensualesAbi5, Activos_mensualesAbi4, Activos_mensualesAbi3, Activos_mensualesAbi2, Activos_mensualesAbi1, Activos_mensualesAbi0];

    var data_h1_graph_2 = {
        series: [
            {
                name: "Monthly Active",
                data: values_Activos_mensualesAbi
            },
            {
                name: "Reactivations",
                data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
            },
            {
                name: 'Quartly Active',
                data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
            },
            {
                name: 'Sign Ups',
                data: [34, 2, 74, 1, 66, 34, 56, 23, 82, 56, 7, 34]
            }
        ],
        chart: {
            height: 450,
            type: 'line',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false,
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: [5, 5, 5, 5],
            curve: 'straight',
            dashArray: [0, 0, 0, 0]
        },
        title: {
            text: 'Purchasing behaviour and Sign Ups',
            align: 'center'
        },
        legend: {
            tooltipHoverFormatter: function(val, opts) {
                return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + '</strong>'
            }
        },
        colors:['rgb(220, 123, 79)', 'rgb(49, 27, 245)', 'rgb(1, 114, 39)', 'rgb(247, 194, 49)'],
        xaxis: {
            categories: labels,
        },
        
        grid: {
            borderColor: '#f1f1f1',
        },
        markers: {
            size: 5,
            hover: {
                size: 6,
            }
        }
    };

    var div_h2_graph_1 = new ApexCharts(
        document.querySelector("#h2-graph-1"), 
        data_h1_graph_2
    );
    div_h2_graph_1.render();
}
h2_graph_1();

var sline3 = {
    chart: {
        height: 350,
        type: 'line',
        zoom: {
            enabled: false
        },
        toolbar: {
            show: false,
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'straight'
    },
    series: [{
        name: "Desktops",
        data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
    }],
    title: {
        text: 'Product Trends by Month',
        align: 'left'
    },
    grid: {
        row: {
            colors: ['#f1f2f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
        },
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
    }
}

var chart3 = new ApexCharts(
    document.querySelector("#mixed-chart-3"),
    sline3
);
chart3.render();

var sLineArea2 = {
    chart: {
        height: 350,
        type: 'area',
        toolbar: {
            show: false,
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    series: [{
        name: 'series1',
        data: [31, 40, 28, 51, 42, 109, 100]
    }, {
        name: 'series2',
        data: [11, 32, 45, 32, 34, 52, 41]
    }],

    xaxis: {
        type: 'datetime',
        categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00", "2018-09-19T06:30:00"],
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}

var chart4 = new ApexCharts(
    document.querySelector("#s-line-area2"),
    sLineArea2
);

chart4.render();

var sLineArea3 = {
    chart: {
        height: 350,
        type: 'area',
        toolbar: {
            show: false,
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    series: [{
        name: 'series1',
        data: [31, 40, 28, 51, 42, 109, 100]
    }, 
    {
        name: 'series2',
        data: [11, 32, 45, 32, 34, 52, 41]
    },
    {
        name: 'series2',
        data: [23, 22, 57, 23, 46, 95, 34]
    }],

    xaxis: {
        type: 'datetime',
        categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00", "2018-09-19T06:30:00"],
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}

var chart5 = new ApexCharts(
    document.querySelector("#s-line-area2"),
    sLineArea3
);

chart5.render();

var sColStacked2 = {
    chart: {
        height: 350,
        type: 'bar',
        stacked: true,
        toolbar: {
          show: false,
        }
    },
    responsive: [{
        breakpoint: 480,
        options: {
            legend: {
                position: 'bottom',
                offsetX: -10,
                offsetY: 0
            }
        }
    }],
    plotOptions: {
        bar: {
            horizontal: false,
        },
    },
    series: [{
        name: 'PRODUCT A',
        data: [44, 55, 41, 67, 22, 43]
    },{
        name: 'PRODUCT B',
        data: [13, 23, 20, 8, 13, 27]
    },{
        name: 'PRODUCT C',
        data: [11, 17, 15, 15, 21, 14]
    },{
        name: 'PRODUCT D',
        data: [21, 7, 25, 13, 22, 8]
    }],
    xaxis: {
        type: 'datetime',
        categories: ['01/01/2011 GMT', '01/02/2011 GMT', '01/03/2011 GMT', '01/04/2011 GMT', '01/05/2011 GMT', '01/06/2011 GMT'],
    },
    legend: {
        position: 'right',
        offsetY: 40
    },
    fill: {
        opacity: 1
    },
}

var chart6 = new ApexCharts(
    document.querySelector("#s-col-stacked4"),
    sColStacked2
);

chart6.render();


function h7_graph_1(){
    var data_h7_graph_1 = {
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false,
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        series: [{
            name: "Desktops",
            data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
        }],
        title: {
            text: 'Product Trends by Month',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['#f1f2f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        }
    }

    var div_h7_graph_1  = new ApexCharts(
        document.querySelector("#h7-graph-1"),
        data_h7_graph_1
    );
    div_h7_graph_1.render();
}
h7_graph_1();

function h7_graph_2(){
    var data_h7_graph_2 = {
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false,
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        series: [{
            name: "Desktops",
            data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
        }],
        title: {
            text: 'Product Trends by Month',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['#f1f2f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        }
    }

    var div_h7_graph_2  = new ApexCharts(
        document.querySelector("#h7-graph-2"),
        data_h7_graph_2
    );
    div_h7_graph_2.render();
}
h7_graph_2();

function h8_graph_1(){
    var data_h8_graph_1 = {
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false,
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        series: [{
            name: "Desktops",
            data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
        }],
        title: {
            text: 'Product Trends by Month',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['#f1f2f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        }
    }

    var div_h8_graph_1  = new ApexCharts(
        document.querySelector("#h8-graph-1"),
        data_h8_graph_1
    );
    div_h8_graph_1.render();
}
h8_graph_1();