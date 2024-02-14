@extends('admin.dashboard.stats.dashboardDesign')
@section('content')
    <div class="wrapper wrapper-content">
        {{--Yesterday--}}
        <h2 style="margin-top: -15px; margin-left: 5px;">Yesterday (Date: {{ \Carbon\Carbon::yesterday()->format('Y-m-d') }})</h2>
        <div class="row">
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px;">
                        <span class="label label-success float-right">Total</span>
                        <h5>NPay Transaction Count</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $stats['yesterday']['transaction']['count'] }} </h1>
                        <small>Sum of NPay dispute transactions</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px;">
                        <span class="label label-success float-right">Total</span>
                        <h5>NPay Transaction Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">Rs. {{ $stats['yesterday']['transaction']['amount'] }} </h1>
                        <small>Sum of NPay Transactions </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px">
                        <span class="label label-danger float-right">Total</span>
                        <h5>Pending Dispute Count</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">Rs. {{ $stats['yesterday']['pendingDispute']['count'] }}</h1>
                        <small>Number of NPay dispute transactions</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px">
                        <span class="label label-danger float-right">Total</span>
                        <h5>Pending Dispute Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">Rs. {{ $stats['yesterday']['pendingDispute']['amount'] }}</h1>
                        <small>Sum of NPay dispute transactions </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px">
                        <span class="label label-primary float-right">Total</span>
                        <h5>Resolved Dispute Count</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">Rs. {{ $stats['yesterday']['resolvedDispute']['count'] }}</h1>
                        <small>Number of NPay resolved transactions</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px">
                        <span class="label label-primary float-right">Total</span>
                        <h5>Resolved Dispute Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">Rs. {{ $stats['yesterday']['resolvedDispute']['amount'] }}</h1>
                        <small>Sum of NPay resolved transactions </small>
                    </div>
                </div>
            </div>
        </div>

        {{--Today--}}
        <h2 style="margin-top: -20px; margin-left: 5px;">Today (Date: {{ \Carbon\Carbon::today()->format('Y-m-d') }})</h2>
        <div class="row">
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px;">
                        <span class="label label-success float-right">Total</span>
                        <h5>NPay Transaction Count</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $stats['today']['transaction']['count'] }} </h1>
                        <small>Sum of NPay dispute transactions</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px;">
                        <span class="label label-success float-right">Total</span>
                        <h5>NPay Transaction Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">Rs. {{ $stats['today']['transaction']['amount'] }} </h1>
                        <small>Sum of NPay Transactions </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px">
                        <span class="label label-danger float-right">Total</span>
                        <h5>Pending Dispute Count</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">Rs. {{ $stats['today']['pendingDispute']['count'] }}</h1>
                        <small>Number of NPay dispute transactions</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px">
                        <span class="label label-danger float-right">Total</span>
                        <h5>Pending Dispute Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">Rs. {{ $stats['today']['pendingDispute']['amount'] }}</h1>
                        <small>Sum of NPay dispute transactions </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px">
                        <span class="label label-primary float-right">Total</span>
                        <h5>Resolved Dispute Count</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">Rs. {{ $stats['today']['resolvedDispute']['count'] }}</h1>
                        <small>Number of NPay resolved transactions</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px">
                        <span class="label label-primary float-right">Total</span>
                        <h5>Resolved Dispute Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">Rs. {{ $stats['today']['resolvedDispute']['amount'] }}</h1>
                        <small>Sum of NPay resolved transactions </small>
                    </div>
                </div>
            </div>
        </div>

        {{--NPay--}}
        <div class="row">
            {{--Tables--}}
            <div class="col-lg-8">

                <div class="ibox" style="margin-bottom: 10px;">
                    <div class="ibox-title" style="padding-right: 15px">
                        <h5>Pending Disputes</h5>
                        <div class="ibox-content" style="height: 20vh">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" title="NPay transactions list">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Transaction Date</th>
                                        <th>Dispute Date</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($disputes as $dispute)
                                        <tr class="gradeC">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $dispute->disputeable->created_at }}</td>
                                            <td>
                                                {{ $dispute->created_at }}
                                            </td>
                                            <td>
                                                <span class="badge badge-warning">PENDING</span>
                                            </td>
                                            <td>
                                                Rs. {{ $dispute->disputeable->amount }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title" style="padding-right: 15px;">
                        <h5>Clearance</h5>
                        <div class="ibox-content" style="height: 20vh">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" title="NPay transactions list">
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Clearance Date</th>
                                        <th>Transaction Count</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($clearances as $clearance)
                                        <tr class="gradeC">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $clearance->created_at }}</td>
                                            <td>
                                                {{ count($clearance->clearanceTransactions) }}
                                            </td>
                                            <td>
                                                @include('admin.clearance.status', ['clearanceTransactions' => $clearance->clearanceTransactions])
                                            </td>
                                            <td>
                                                Rs. {{ $clearance->total_transaction_amount }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{--Vendor Graph--}}
            <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 id="graphTitleNPay">NPay Vendors Graph</h5>
                    </div>
                    <div class="ibox-content" id="graph-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="flot-chart" id="vendors" style="height: 45vh; margin-left: 35px;">
                                    <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>



    </div>
@endsection

@section('styles')
    <style>
        #graph-content {
            padding: 0px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        let vendorData = {!!$graph !!};
        let keys = Object.keys(vendorData);
        let values = Object.values(vendorData);

        let options = {
            series: values,
            chart: {
                width: 500,
                type: 'pie',
            },
            labels: keys,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 500
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#flot-dashboard-chart"), options);
        chart.render();
    </script>
@endsection
