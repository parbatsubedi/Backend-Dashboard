{{--monthly graph--}}
<!--
<script>

{{--    let data = <?php echo $graph ?>;--}}
{{--    let year = <?php echo $year  ?>;--}}
{{--    let month = <?php echo $month ?>;--}}

    let monthDates = new Date(parseInt(year), parseInt(month), 0).getDate();
    let countObj = {};
    let amountObj = {};
    let userObj = {};


    for( let i = 1; i <= monthDates; i++){
        const date = `${year}-${month < 10 ? '0' + month : month}-${i < 10 ? '0' + i : i}`;
        console.log(date);
        console.log(data['2020-01-02']);

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

    let keys = Object.keys(countObj);
    let monthCountData = Object.values(countObj);
    let monthAmountData = Object.values(amountObj);
    let monthUserData = Object.values(userObj);


    let options = {
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

    let chart = new ApexCharts(
        document.querySelector("#flot-dashboard-chart"),
        options
    );

    chart.render();
</script>
-->

