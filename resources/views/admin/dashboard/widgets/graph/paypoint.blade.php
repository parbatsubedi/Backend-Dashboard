{{--<div class="row">--}}
{{--    <div class="col-lg-12">--}}
{{--        <div class="ibox ">--}}
{{--            <div class="ibox-title">--}}
{{--                <h5 id="graphTitlePaypoint">PayPoint Monthly Transaction / Users Involved Graph</h5>--}}
{{--                <div class="float-right">--}}
{{--                    <div class="btn-group">--}}
{{--                        <button type="button" class="btn btn-xs btn-white active" id="monthlyButton">Monthly</button>--}}
{{--                        <button type="button" class="btn btn-xs btn-white" id="yearlyButton" rel="{{ route('admin.dashboard.paypoint.yearly') }}">Yearly</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="ibox-content" style="height: 400px;">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-lg-9">--}}
{{--                        <div class="flot-chart" id="monthly">--}}
{{--                            <div class="flot-chart-content" id="flot-dashboard-chart"></div>--}}
{{--                        </div>--}}

{{--                        <div class="flot-chart" id="yearly" style="display:none;">--}}
{{--                            <div class="flot-chart-content" id="flot-dashboard-chart-yearly"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-lg-3">--}}
{{--                        <ul class="stat-list">--}}
{{--                            <li>--}}
{{--                                <h2 class="no-margins">{{ $monthTransactionCount['paypoint'] }} Transactions</h2>--}}
{{--                                <small>Total paypoint transactions count this month</small>--}}
{{--                                @if($yearTransactionCount['paypoint'] != 0)--}}
{{--                                    <div class="stat-percent">{{ round(($monthTransactionCount['paypoint']/$yearTransactionCount['paypoint']) * 100, 2) }}% <i class="fa fa-bolt text-navy"></i></div>--}}
{{--                                    <div class="progress progress-mini">--}}
{{--                                        <div style="width: {{ ($monthTransactionCount['paypoint']/$yearTransactionCount['paypoint']) * 100 }}%;" class="progress-bar"></div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <h2 class="no-margins ">Rs. {{ $monthTransactionAmount['paypoint'] }}</h2>--}}
{{--                                <small>Total paypoint transaction amount this month</small>--}}
{{--                                @if($yearTransactionAmount['paypoint'] != 0)--}}
{{--                                    <div class="stat-percent">{{ round(($monthTransactionAmount['paypoint']/$yearTransactionAmount['paypoint']) * 100, 2) }}% <i class="fa fa-bolt text-navy"></i></div>--}}
{{--                                    <div class="progress progress-mini">--}}
{{--                                        <div style="width: {{($monthTransactionAmount['paypoint']/$yearTransactionAmount['paypoint']) * 100}}%;" class="progress-bar"></div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <h2 class="no-margins ">{{ $yearTransactionCount['paypoint'] }} Transactions</h2>--}}
{{--                                <small>Total paypoint transactions count this year</small>--}}
{{--                                @if($successfulTransactionCount != 0)--}}
{{--                                    <div class="stat-percent">{{ round(($yearTransactionCount['paypoint']/$successfulTransactionCount) * 100, 2) }}% <i class="fa fa-bolt text-navy"></i></div>--}}
{{--                                    <div class="progress progress-mini">--}}
{{--                                        <div style="width: {{ ($yearTransactionCount['paypoint']/$successfulTransactionCount) * 100 }}%;" class="progress-bar"></div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <h2 class="no-margins ">Rs. {{ $yearTransactionAmount['paypoint'] }}</h2>--}}
{{--                                <small>Total paypoint transactions amount this year</small>--}}
{{--                                @if($successfulTransactionSum)--}}
{{--                                    <div class="stat-percent">{{ round(($yearTransactionAmount['paypoint']/$successfulTransactionSum) * 100, 2) }}% <i class="fa fa-bolt text-navy"></i></div>--}}
{{--                                    <div class="progress progress-mini">--}}
{{--                                        <div style="width: {{ ($yearTransactionAmount['paypoint']/$successfulTransactionSum) * 100 }}%;" class="progress-bar"></div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
