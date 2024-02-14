{{--monthly npay graph--}}
<!--
<script>
    data = <?php echo $nPayGraph ?>;
    year = <?php echo $year  ?>;
    month = <?php echo $month ?>;

    monthDates = new Date(parseInt(year), parseInt(month), 0).getDate();
    countObj = {};
    amountObj = {};
    userObj = {};

    for( let i = 1; i <= monthDates; i++){
        const date = `${year}-${month < 10 ? '0' + month : month}-${i < 10 ? '0' + i : i}`;

        data[date] !== undefined
            ? countObj[date] = data[date].count
            : countObj[date] = 0;

        data[date] !== undefined
            ? amountObj[date] = data[date].amount
            : amountObj[date]=0;

        data[date] !== undefined
            ? userObj[date] = data[date].userCount
            : userObj[date]=0;
    }

    keys = Object.keys(countObj);
    monthCountData = Object.values(countObj);
    monthAmountData = Object.values(amountObj);
    monthUserData = Object.values(userObj);

    options = {
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false,
            }
        },
        series: [
            {
                name: 'Number of Users',
                type: 'column',
                data: monthUserData
            },
            {
                name: 'Transaction Amount',
                type: 'line',
                data: monthAmountData
            }
        ],
        stroke: {
            width: [0, 4]
        },
        title: {
            //text: 'Transaction / Users Involved Graph'
        },

        labels: keys,
        xaxis: {
            //type: 'month'
        },
        yaxis: [
            {
                title: {
                    text: 'Number of Users',
                },
            },
            {
                opposite: true,
                title: {
                    text: 'Transaction Amount'
                },
                labels: {
                    formatter: function (value) {
                        return 'Rs. ' + value;
                    }
                }
            }]

    };

    let chart3 = new ApexCharts(
        document.querySelector("#flot-dashboard-chart-npay"),
        options
    );

    chart3.render();
</script>
-->
