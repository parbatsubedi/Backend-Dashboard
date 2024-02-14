{{--<div class="row">--}}
{{--    <div class="col-lg-12">--}}
{{--        <div class="ibox ">--}}
{{--            <div class="ibox-title">--}}
{{--                <h5 id="graphTitleNpay">Npay Monthly Transaction / Users Involved Graph</h5>--}}
{{--                <div class="float-right">--}}
{{--                    <div class="btn-group">--}}
{{--                        <button type="button" class="btn btn-xs btn-white active" id="monthlyButton2">Monthly</button>--}}
{{--                        <button type="button" class="btn btn-xs btn-white" id="yearlyButton2" rel="{{ route('admin.dashboard.npay.yearly') }}">Yearly</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="ibox-content" style="height: 400px;">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-lg-9">--}}
{{--                        <div class="flot-chart" id="monthly2">--}}
{{--                            <div class="flot-chart-content" id="flot-dashboard-chart-npay"></div>--}}
{{--                        </div>--}}

{{--                        <div class="flot-chart" id="yearly2" style="display:none;">--}}
{{--                            <div class="flot-chart-content" id="flot-dashboard-chart-yearly-npay"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-lg-3">--}}
{{--                        <ul class="stat-list">--}}
{{--                            <li>--}}
{{--                                <h2 class="no-margins">{{ $monthTransactionCount['npay'] }} Transactions</h2>--}}
{{--                                <small>Total npay transactions count this month</small>--}}
{{--                                @if($yearTransactionCount['npay'] != 0)--}}
{{--                                    <div class="stat-percent">{{ round(($monthTransactionCount['npay']/$yearTransactionCount['npay']) * 100, 2) }}% <i class="fa fa-bolt text-navy"></i></div>--}}
{{--                                    <div class="progress progress-mini">--}}
{{--                                        <div style="width: {{ ($monthTransactionCount['npay']/$yearTransactionCount['npay']) * 100 }}%;" class="progress-bar"></div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <h2 class="no-margins ">Rs. {{ $monthTransactionAmount['npay'] }}</h2>--}}
{{--                                <small>Total npay transaction amount this month</small>--}}
{{--                                @if($yearTransactionAmount['npay'] != 0)--}}
{{--                                    <div class="stat-percent">{{ round(($monthTransactionAmount['npay']/$yearTransactionAmount['npay']) * 100, 2) }}% <i class="fa fa-bolt text-navy"></i></div>--}}
{{--                                    <div class="progress progress-mini">--}}
{{--                                        <div style="width: {{($monthTransactionAmount['npay']/$yearTransactionAmount['npay']) * 100}}%;" class="progress-bar"></div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <h2 class="no-margins ">{{ $yearTransactionCount['npay'] }} Transactions</h2>--}}
{{--                                <small>Total npay transactions count this year</small>--}}
{{--                                @if($successfulTransactionCount != 0)--}}
{{--                                    <div class="stat-percent">{{ round(($yearTransactionCount['npay']/$successfulTransactionCount) * 100, 2) }}% <i class="fa fa-bolt text-navy"></i></div>--}}
{{--                                    <div class="progress progress-mini">--}}
{{--                                        <div style="width: {{ ($yearTransactionCount['npay']/$successfulTransactionCount) * 100 }}%;" class="progress-bar"></div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <h2 class="no-margins ">Rs. {{ $yearTransactionAmount['npay'] }}</h2>--}}
{{--                                <small>Total npay transactions amount this year</small>--}}
{{--                                @if($successfulTransactionSum != 0)--}}
{{--                                    <div class="stat-percent">{{ round(($yearTransactionAmount['npay']/$successfulTransactionSum) * 100, 2) }}% <i class="fa fa-bolt text-navy"></i></div>--}}
{{--                                    <div class="progress progress-mini">--}}
{{--                                        <div style="width: {{ ($yearTransactionAmount['npay']/$successfulTransactionSum) * 100 }}%;" class="progress-bar"></div>--}}
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
