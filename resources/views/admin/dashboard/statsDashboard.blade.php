<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel</title>

    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">

    <style>

        .btn-icon {
            width: 25px;
            height: 25px;
            padding: 2px 0;
        }

        #button{
            display:block;
            margin:20px auto;
            padding:10px 30px;
            background-color:#eee;
            border:solid #ccc 1px;
            cursor: pointer;
        }
        #overlay{
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height:100%;
            display: none;
            background: rgba(0,0,0,0.6);
        }
        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px #ddd solid;
            border-top: 4px #2e93e6 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }
        @keyframes sp-anime {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(359deg);
            }
        }
        .is-hide{
            display:none;
        }

        .navbar-minimalize {
            display: none;
        }
    </style>

    @yield('styles')

</head>

<body>
<div id="wrapper">
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    <div id="page-wrapper" class="gray-bg" style="width: 100%">

        @include('admin.layouts.admin_header')

        <div class="wrapper wrapper-content">
            <h2 style="margin-top: -5px; margin-left: 5px;">Dashboard</h2>
            <div class="row">
                @can('Dashboard all transactions sum')
                    @include('admin.dashboard.widgets.allTransactionSum')
                @endcan

                @can('Dashboard successful transactions count')
                    @include('admin.dashboard.widgets.successfulTransactionCount')
                @endcan

                @can('Dashboard total KYC not filled users')
                    @include('admin.dashboard.widgets.totalKYCNotFilledUsers')
                @endcan

                @can('Dashboard total KYC filled users')
                    @include('admin.dashboard.widgets.totalKYCFilledUsers')
                @endcan

                @include('admin.dashboard.widgets.totalAcceptedKYCCount')
                @include('admin.dashboard.widgets.totalRejectedKYCCount')

                @include('admin.dashboard.widgets.totalNpayClearanceClearedCount')
                @include('admin.dashboard.widgets.totalPaypointClearanceClearedCount')
            </div>

            @can('Dashboard users transactions graph')
                @include('admin.dashboard.widgets.graph.paypoint')
                @include('admin.dashboard.widgets.graph.npay')
            @endcan
            <hr>

        </div>

        @include('admin.layouts.admin_footer')

    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ asset('admin/js/jquery-3.1.1.min.js') }} " ></script>
<script src="{{ asset('admin/js/popper.min.js') }} " ></script>
<script src="{{ asset('admin/js/bootstrap.js') }} " ></script>
<script src="{{ asset('admin/js/plugins/metisMenu/jquery.metisMenu.js') }} " ></script>
<script src="{{ asset('admin/js/plugins/slimscroll/jquery.slimscroll.min.js') }} " ></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('admin/js/inspinia.js') }} " ></script>
<script src="{{ asset('admin/js/plugins/pace/pace.min.js') }} " ></script>

<script>
    $('form').attr('autocomplete','off');
</script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('admin/js/inspinia.js') }} " ></script>
<script src="{{ asset('admin/js/plugins/pace/pace.min.js') }} " ></script>

<!-- jQuery UI -->
<script src="{{ asset('admin/js/plugins/jquery-ui/jquery-ui.min.js') }} " ></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

@include('admin.asset.js.datatable')

{{--Yearly and monthly button click--}}
<script>

    $('#yearlyButton').one('click', function (e) {
        let url = $(this).attr('rel');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            method:"POST",
            data: {data:'data'},
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            beforeSend: function () {
                $("#overlay").fadeIn(300);
            },
            success: function (resp) {

                loadYearGraph(resp.graph, 'flot-dashboard-chart-yearly');

                $("#overlay").fadeOut(300);

            },
            error: function (resp) {
                console.log(resp);
                alert('error');
            }
        });
    });

    $('#yearlyButton').on('click', function (e) {

        $('#monthlyButton').removeClass('active');
        $(this).addClass('active');

        $('#graphTitlePaypoint').text('PayPoint Yearly Transaction / Users Involved Graph');
        $('#monthly').css('display', 'none');
        $('#yearly').css('display', 'block');

    });

    $('#monthlyButton').on('click', function (e) {
        $('#yearlyButton').removeClass('active');
        $(this).addClass('active');

        $('#graphTitlePaypoint').text('PayPoint Monthly Transaction / Users Involved Graph');
        $('#yearly').css('display', 'none');
        $('#monthly').css('display', 'block');
    });
</script>

{{--Yearly and monthly button click paypoint--}}
<script>

    $('#yearlyButton2').one('click', function (e) {
        let url = $(this).attr('rel');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            method:"POST",
            data: {data:'data'},
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            beforeSend: function () {
                $("#overlay").fadeIn(300);
            },
            success: function (resp) {

                loadYearGraph(resp.graph, 'flot-dashboard-chart-yearly-npay');

                $("#overlay").fadeOut(300);

            },
            error: function (resp) {
                console.log(resp);
                alert('error');
            }
        });
    });

    $('#yearlyButton2').on('click', function (e) {

        $('#monthlyButton2').removeClass('active');
        $(this).addClass('active');

        $('#graphTitleNpay').text('Npay Yearly Transaction / Users Involved Graph');
        $('#monthly2').css('display', 'none');
        $('#yearly2').css('display', 'block');

    });

    $('#monthlyButton2').on('click', function (e) {
        $('#yearlyButton2').removeClass('active');
        $(this).addClass('active');

        $('#graphTitle').text('Npay Monthly Transaction / Users Involved Graph');
        $('#yearly2').css('display', 'none');
        $('#monthly2').css('display', 'block');
    });
</script>

{{--monthly graph--}}
<script>

    let data = <?php echo $graph ?>;
    let year = <?php echo $year  ?>;
    let month = <?php echo $month ?>;

    console.log(data);

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

{{--yearly graph--}}
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


{{--monthly npay graph--}}
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

</body>
</html>
