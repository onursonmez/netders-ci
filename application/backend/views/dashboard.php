<script src="https://code.highcharts.com/highcharts.src.js"></script>

<div id="container"></div>

<script>

Highcharts.chart('container', {

    title: {
        text: 'Günlük Telefon Numarası Görüntülemeleri'
    },

    subtitle: {
        text: 'Eğitmenlerin günlük telefon numaralarına tıklama sayıları'
    },

    xAxis: {
        categories: ["<?=$grafik1['categories']?>"],
        crosshair: true
    },
    
    yAxis: {
        title: {
            text: 'Tıklama Sayısı'
        },
    },
    legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
    },

   
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [
    {
        name: 'Tıklama Sayıları',
        data: [<?=$grafik1['values']?>]
    }
    ],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});	
</script>

<div id="container2"></div>

<script>

Highcharts.chart('container2', {

    title: {
        text: 'Günlük Üyelik Sayıları'
    },

    subtitle: {
        text: 'Netders portalına günlük üyelik sayıları'
    },

    xAxis: {
        categories: ["<?=$grafik2['categories']?>"],
        crosshair: true
    },
    
    yAxis: {
        title: {
            text: 'Üyelik Sayısı'
        },
    },
    legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
    },

   
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [
    {
        name: 'Üyelik Sayıları',
        data: [<?=$grafik2['values']?>]
    }
    ],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});	
</script>