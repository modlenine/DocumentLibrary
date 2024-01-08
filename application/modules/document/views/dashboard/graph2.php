
<div id="graph1" style="height: 400px"></div>

<script type="text/javascript">
Highcharts.chart('graph1', {
    chart: {
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 10,
            beta: 25,
            depth: 70
        }
    },
    title: {
        text: '3D chart with null values'
    },
    subtitle: {
        text: 'Notice the difference between a 0 value and a null point'
    },
    plotOptions: {
        column: {
            depth: 25
        }
    },
    xAxis: {
        categories: Highcharts.getOptions().lang.shortMonths,
        labels: {
            skew3d: true,
            style: {
                fontSize: '16px'
            }
        }
    },
    yAxis: {
        title: {
            text: null
        }
    },
    plotOptions: {
    series: {
        borderWidth: 0,
        dataLabels: {
                enabled: true,
                format: '{point.y:.1f}%'
            },
    cursor: 'pointer',
    point: {
        events: {
            click: function () {
                location.href = 'http://192.190.10.27/dc2/' +
                    this.name;
            }
        }
    }
    }
    },
    series: [{
        name: 'Sales',
        colorByPoint: true,
        data: [
            {
            name:"สอง",y:2},
            {name:"สาม",y:3},
            {name:"ว่าง",y:0},
            {name:"สี่",y:4},
            {name:"สี่",y:0},
            {name:"ห้า",y:5},
            {name:"หนึ่ง",y:1},
            {name:"สี่",y:4},
            {name:"หก",y:6},
            {name:"สาม",y:3}]
    }]
});
</script>