@extends('admin.dashboard.stats.dashboardDesign')
@section('content')
    <div class="wrapper wrapper-content">
        {{--Yesterday--}}
        <h2 style="margin-top: -15px; margin-left: 5px;"><b>NCHL Bank Transfer</b> Yesterday (Date: {{ \Carbon\Carbon::yesterday()->format('Y-m-d') }})</h2>
        <div class="row">
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px;">
                        <span class="label label-success float-right">Total</span>
                        <h5> Transaction Count</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $stats['yesterday']['transaction']['count'] }} </h1>
                        <small>Sum of  dispute transactions</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px;">
                        <span class="label label-success float-right">Total</span>
                        <h5> Transaction Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">Rs. {{ $stats['yesterday']['transaction']['amount'] }} </h1>
                        <small>Sum of  Transactions </small>
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
                        <small>Number of  dispute transactions</small>
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
                        <small>Sum of  dispute transactions </small>
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
                        <small>Number of  resolved transactions</small>
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
                        <small>Sum of  resolved transactions </small>
                    </div>
                </div>
            </div>
        </div>

        {{--Today--}}
        <h2 style="margin-top: -20px; margin-left: 5px;"><b>NCHL Bank Transfer</b> Today (Date: {{ \Carbon\Carbon::today()->format('Y-m-d') }})</h2>
        <div class="row">
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px;">
                        <span class="label label-success float-right">Total</span>
                        <h5> Transaction Count</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $stats['today']['transaction']['count'] }} </h1>
                        <small>Sum of  dispute transactions</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox ">
                    <div class="ibox-title" style="padding-right: 15px;">
                        <span class="label label-success float-right">Total</span>
                        <h5> Transaction Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">Rs. {{ $stats['today']['transaction']['amount'] }} </h1>
                        <small>Sum of  Transactions </small>
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
                        <small>Number of  dispute transactions</small>
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
                        <small>Sum of  dispute transactions </small>
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
                        <small>Number of  resolved transactions</small>
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
                        <small>Sum of  resolved transactions </small>
                    </div>
                </div>
            </div>
        </div>

        {{----}}
        <div class="row">
            {{--Tables--}}
            <div class="col-lg-12">

                <div class="ibox" style="margin-bottom: 10px;">
                    <div class="ibox-title" style="padding-right: 15px">
                        <h5>Pending Disputes</h5>
                        <div class="ibox-content" style="height: 20vh">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" title=" transactions list">
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
            </div>

            {{--Vendor Graph--}}
            {{--<div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 id="graphTitle"> Vendors Graph</h5>
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
            </div>--}}
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

@endsection
