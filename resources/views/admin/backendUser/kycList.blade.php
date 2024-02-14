@extends('admin.layouts.admin_design')
@section('content')



    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Users</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>KYC List</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title collapse-link">
                        <h5>Filter Users</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content"
                         @if( empty($_GET) || (!empty($_GET['page']) && count($_GET) === 1)  ) style="display: none" @endif>
                        <div class="row">
                            <div class="col-sm-12">
                                <form role="form" method="get" action="{{ route('backendUser.kycList') }}">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="name" placeholder="Enter User Name"
                                                       class="form-control"
                                                       value="{{ !empty($_GET['name']) ? $_GET['name'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <input type="text" name="number" placeholder="Enter Contact Number"
                                                       class="form-control"
                                                       value="{{ !empty($_GET['number']) ? $_GET['number'] : '' }}">
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <input type="email" name="email" placeholder="Enter Email"
                                                   class="form-control"
                                                   value="{{ !empty($_GET['email']) ? $_GET['email'] : '' }}">
                                        </div>

                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <select data-placeholder="Choose transaction status..."
                                                        class="chosen-select" tabindex="2" name="change_status">
                                                    <option value="" selected disabled>Select Status...</option>

                                                    @if(!empty($_GET['change_status']))
                                                        <option value="all"
                                                                @if($_GET['change_status'] == 'all') selected @endif>
                                                            All
                                                        </option>
                                                        <option value="accepted"
                                                                @if($_GET['change_status']  == 'accepted') selected @endif >
                                                            Accepted
                                                        </option>
                                                        <option value="rejected"
                                                                @if($_GET['change_status'] == 'rejected') selected @endif>
                                                            Rejected
                                                        </option>
                                                        <option value="notverified"
                                                                @if($_GET['change_status'] == 'notverified') selected @endif>
                                                            Not verified
                                                        </option>
                                                    @else
                                                        <option value="all">All</option>
                                                        <option value="accepted">Accepted</option>
                                                        <option value="rejected">Rejected</option>
                                                        <option value="notverified">Not verified</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6" style="padding-bottom: 15px;">
                                            <div class="input-group date">

                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                <input id="date_load_from" type="text" class="form-control date_from"
                                                       placeholder="From" name="from" autocomplete="off"
                                                       value="{{ !empty($_GET['from']) ? $_GET['from'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6" style="padding-bottom: 15px;">
                                            <div class="input-group date">
                                                                    <span class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </span>
                                                <input id="date_load_to" type="text" class="form-control date_to"
                                                       placeholder="To" name="to" autocomplete="off"
                                                       value="{{ !empty($_GET['to']) ? $_GET['to'] : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select data-placeholder="Choose User Type..." class="chosen-select"  tabindex="2" name="user_type">
                                                    <option value="" selected disabled>Sort By User Type</option>
                                                    <option value="" selected>All</option>
                                                    @if(!empty($_GET['user_type']))
                                                        @if($_GET['user_type'] == "normal_user")
                                                            <option value="normal_user" selected>Normal user</option>
                                                            <option value="agent">Agent</option>
                                                            <option value="merchant">Merchant</option>
                                                        @elseif($_GET['user_type'] == "agent")
                                                            <option value="normal_user">Normal user</option>
                                                            <option value="agent" selected>Agent</option>
                                                            <option value="merchant">Merchant</option>
                                                        @elseif($_GET['user_type'] == 'merchant')
                                                            <option value="normal_user">Normal user</option>
                                                            <option value="agent">Agent</option>
                                                            <option value="merchant" selected>Merchant</option>
                                                        @endif
                                                    @else
                                                        <option value="normal_user">Normal user</option>
                                                        <option value="agent">Agent</option>
                                                        <option value="merchant">Merchant</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div>
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit">
                                            <strong>Filter</strong></button>
                                    </div>
                                    @include('admin.asset.components.clearFilterButton')
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>List of users kyc</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example"
                                   title="Backend user changed KYC list - {{ auth()->user()->email }}">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>User</th>
                                    <th>Contact Number</th>
                                    <th>Email</th>
                                    <th>KYC status</th>
                                    <th>User type</th>
                                    <th>Status changed on</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($lists as $kyc)

                                    <tr class="gradeX">
                                        <td>{{ $loop->index +  1 }}</td>
                                        <td>
                                            {{ $kyc->first_name . ' '. $kyc->last_name }}
                                        </td>
                                        <td>
                                            {{ $kyc->user->mobile_no }}
                                        </td>
                                        <td>
                                            {{ $kyc->user->email }}
                                        </td>
                                        <td>
                                            {{--@if($kyc->pivot->status == 'ACCEPTED')
                                                <span class="badge badge-primary">
                                               ACCEPTED
                                           </span>
                                            @else
                                                <span class="badge badge-danger">
                                               REJECTED
                                           </span>
                                            @endif--}}
                                            @include('admin.user.kyc.status', ['kyc' => $kyc])
                                        </td>
                                        <td>
                                           @include('admin.user.userType.displayUserTypes',['user' => $kyc->user])
                                        </td>

                                        <td>
                                            {{--{{ $kyc->admin[0]->pivot->updated_at}}--}}
                                            {{ $kyc->updated_at }}
                                        </td>

                                        <td class="center">
                                            @can('User KYC view')
                                                <a href="{{route('user.kyc', $kyc->user_id)}}"
                                                   class="btn btn-sm btn-primary m-t-n-xs"><strong>KYC</strong></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $lists->appends(request()->query())->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('styles')
    @include('admin.asset.css.chosen')
    @include('admin.asset.css.datepicker')
    @include('admin.asset.css.datatable')
@endsection

@section('scripts')
    @include('admin.asset.js.chosen')
    @include('admin.asset.js.datepicker')
    @include('admin.asset.js.datatable')
@endsection



