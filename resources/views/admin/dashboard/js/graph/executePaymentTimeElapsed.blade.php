<!--
<script>
    let userExecutePayments = {!! $executePayments !!};

    keys = Object.keys(userExecutePayments);
    data = Object.values(userExecutePayments);

    //keys = keys.map((value) => { return ''});

    let optionsTimeElapsed = {
        series: [
            {
                name: "Time Elapsed",
                data: data
            }
        ],
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            },
        },
        dataLabels: {
            enabled: true
        },
        stroke: {
            width: [5, 7, 5],
        },
        markers: {
            size: 0,
            hover: {
                sizeOffset: 6
            }
        },
        xaxis: {
            categories: keys,
            title: {
                text: 'Latest Transactions'
            }
        },
        yaxis: [
            {
                title: {
                    text: 'Time Elapsed in seconds',
                },
            },
        ],
        tooltip: {
            y: [
                {
                    title: {
                        formatter: function (val) {
                            return val + " (mins)"
                        }
                    }
                }
            ]
        },
        grid: {
            borderColor: '#f1f1f1',
        }
    };

    let chartTimeElapsed = new ApexCharts(document.querySelector("#chart-time-elapsed"), optionsTimeElapsed);
    chartTimeElapsed.render();
</script>
-->
