

@can('Dashboard accepted KYC table')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>List of accepted user KYCs</h5>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" title="Accepted KYC List - {{ auth()->user()->email }}">
                            <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>User</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>KYC status</th>
                                <th>status changed on</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($acceptedKycs as $kyc)
                                @if($loop->index == 6)
                                    @break
                                @endif
                                <tr class="gradeX">
                                    <td>{{ $loop->index +  1 }}</td>
                                    <td>
                                        {{ $kyc->first_name . ' '. $kyc->last_name }}
                                    </td>
                                    <td>
                                       {{ optional($kyc->user)->mobile_no }}
                                    </td>
                                    <td>
                                        {{ optional($kyc->user)->email }}
                                    </td>
                                    <td>
                                       @if($kyc->accept == 1)
                                           <span class="badge badge-primary">
                                               ACCEPTED
                                           </span>
                                       @else
                                            <span class="badge badge-danger">
                                               REJECTED
                                           </span>
                                       @endif
                                    </td>
                                    <td>
                                        Rs. {{ $kyc->created_at}}
                                    </td>

                                    <td class="center">
                                        @can('User KYC view')
                                            <a href="{{route('user.kyc', $kyc->user_id)}}" class="btn btn-sm btn-primary m-t-n-xs"><strong>KYC</strong></a>
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

@can('Dashboard rejected KYC table')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>List of rejected user KYCs</h5>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" title="Rejected KYC list - {{ auth()->user()->email }}">
                            <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>User</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>KYC status</th>
                                <th>status changed on</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rejectedKycs as $kyc)
                                @if($loop->index == 6)
                                    @break
                                @endif
                                <tr class="gradeX">
                                    <td>{{ $loop->index +  1 }}</td>
                                    <td>
                                        {{ $kyc->first_name . ' '. $kyc->last_name }}
                                    </td>
                                    <td>
                                        {{ optional($kyc->user)->mobile_no }}
                                    </td>
                                    <td>
                                        {{ optional($kyc->user)->email }}
                                    </td>
                                    <td>
                                        @if($kyc->accept == 1)
                                            <span class="badge badge-primary">
                                               ACCEPTED
                                           </span>
                                        @else
                                            <span class="badge badge-danger">
                                               REJECTED
                                           </span>
                                        @endif
                                    </td>
                                    <td>
                                        Rs. {{ $kyc->created_at}}
                                    </td>

                                    <td class="center">
                                        @can('User KYC view')
                                            <a href="{{route('user.kyc', $kyc->user_id)}}" class="btn btn-sm btn-primary m-t-n-xs"><strong>KYC</strong></a>
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

