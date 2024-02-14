

@can('Dashboard npay clearance table')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>List of latest npay clearances</h5>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" title="NPay Clearances by {{ auth()->user()->email }}">
                        <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Clearance Date</th>
                            <th>Transaction Date</th>
                            <th>Total transaction count</th>
                            <th>Total transaction amount</th>
                            <th>Total transaction commission</th>
                            <th>Transaction Type</th>
                            <th>Cleared By</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($npayClearedTransactions as $clearance)
                            @if($loop->index == 6)
                                @break
                            @endif
                            <tr class="gradeX">
                                <td>{{ $loop->index +  1 }}</td>
                                <td>
                                    {{ date('d M, Y', strtotime($clearance->created_at)) }}
                                </td>
                                <td>
                                    {{ date('d M, Y', strtotime($clearance->transaction_date)) }}
                                </td>
                                <td>
                                    {{ $clearance->total_transaction_count }}
                                </td>
                                <td>
                                    Rs. {{ $clearance->total_transaction_amount }}
                                </td>
                                <td>
                                    Rs. {{ $clearance->total_transaction_commission }}
                                </td>
                                <td>
                                    @if(!empty($clearance->transactions[0]))
                                        {{ $clearance->transactions[0]->service_type }}
                                    @endif
                                </td>
                                <td>
                                    {{ $clearance->admin->name }}
                                </td>
                                <td>
                                    @if(!empty($clearance->image))
                                        <img src="{{ asset('storage/uploads/clearance/'. $clearance->image) }}" alt="" style="height: 120px;">
                                    @endif
                                </td>
                                <td>
                                    @if($clearance->clearance_status === "0")
                                        <span  style="color: green">cleared</span>
                                    @elseif ($clearance->clearance_status === "1")
                                        <span style="color: green">signed</span>
                                    @else
                                        <span style="color: red">Dispute</span>
                                    @endif
                                </td>
                                <td class="center">
                                    @can('Clearance npay change status')
                                        <a style="margin-top: 5px;" class="btn btn-sm btn-primary m-t-n-xs" href="{{ route('clearance.changeStatus', $clearance->id) }}"><strong>Change Status</strong></a>
                                    @endcan
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
@endcan

@can('Dashboard paypoint clearance table')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>List of latest paypoint clearances</h5>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" title="PayPoint clearances by {{ auth()->user()->email }}">
                        <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Clearance Date</th>
                            <th>Transaction Date</th>
                            <th>Total transaction count</th>
                            <th>Total transaction amount</th>
                            <th>Total transaction commission</th>
                            <th>Transaction Type</th>
                            <th>Cleared By</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paypointClearedTransactions as $clearance)
                            @if($loop->index == 6)
                                @break
                            @endif
                            <tr class="gradeX">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>
                                    {{ date('d M, Y', strtotime($clearance->created_at)) }}
                                </td>
                                <td>
                                    {{ date('d M, Y', strtotime($clearance->transaction_date)) }}
                                </td>
                                <td>
                                    {{ $clearance->total_transaction_count }}
                                </td>
                                <td>
                                    Rs. {{ $clearance->total_transaction_amount }}
                                </td>
                                <td>
                                    Rs. {{ $clearance->total_transaction_commission }}
                                </td>
                                <td>
                                    @if(!empty($clearance->transactions[0]))
                                        {{ $clearance->transactions[0]->service_type }}
                                    @endif
                                </td>
                                <td>
                                    {{ $clearance->admin->name }}
                                </td>
                                <td>
                                    @if(!empty($clearance->image))
                                        <img src="{{ asset('storage/uploads/clearance/'. $clearance->image) }}" alt="" style="height: 120px;">
                                    @endif
                                </td>
                                <td>
                                    @if($clearance->clearance_status === "0")
                                        <span  style="color: green">cleared</span>
                                    @elseif ($clearance->clearance_status === "1")
                                        <span style="color: green">signed</span>
                                    @else
                                        <span style="color: red">Dispute</span>
                                    @endif
                                </td>
                                <td class="center">
                                    @can('Clearance npay change status')
                                        <a style="margin-top: 5px;" class="btn btn-sm btn-primary m-t-n-xs" href="{{ route('clearance.changeStatus', $clearance->id) }}"><strong>Change Status</strong></a>
                                    @endcan
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
@endcan

