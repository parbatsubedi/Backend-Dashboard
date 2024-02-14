{{--yearly graph--}}
<!--
<script>
    function loadYearGraph(respData , containerId) {

        let monthLabels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        let data = respData;
        let countObj = {};
        let amountObj = {};
        let userObj = {};


        $.each(monthLabels, function( index, value ) {
            data[value] !== undefined
                ? countObj[value] = data[value].count
                : countObj[value] = 0;

            data[value] !== undefined
                ? amountObj[value] = data[value].amount
                : amountObj[value] = 0;

            data[value] !== undefined
                ? userObj[value] = data[value].userCount
                : userObj[value]=0;
        });

        let monthCountData = Object.values(countObj);
        let monthAmountData = Object.values(amountObj);
        let monthUserData = Object.values(userObj);

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

            labels: monthLabels,
            xaxis: {
                //type: 'month'
            },
            yaxis: [{
                title: {
                    text: 'Number of Users',
                },

            }, {
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

        let chart2 = new ApexCharts(
            document.querySelector(`#${containerId}`),
            options
        );

        chart2.render();
    }
</script>
-->
