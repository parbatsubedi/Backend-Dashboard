@extends('admin.layouts.admin_design')
@section('content')


    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>All Notifications</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>Notifications</strong>
                </li>

                <li class="breadcrumb-item active">
                    <strong>All</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title collapse-link">
                        <h5>Filter Notification</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content" @if( empty($_GET) || (!empty($_GET['page']) && count($_GET) === 1)  ) style="display: none"  @endif>
                        <div class="row">
                            <div class="col-sm-12">
                                <form role="form" method="get" action="{{ route('transaction.complete') }}" id="filter">
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="send_to" placeholder="Send To User" class="form-control" value="{{ !empty($_GET['send_to']) ? $_GET['send_to'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="send_from" placeholder="Send From User" class="form-control" value="{{ !empty($_GET['send_from']) ? $_GET['send_from'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="title" placeholder="Notification Title" class="form-control" value="{{ !empty($_GET['title']) ? $_GET['title'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="type" placeholder="Notification Type" class="form-control" value="{{ !empty($_GET['type']) ? $_GET['type'] : '' }}">
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input id="date_load_from" type="text" class="form-control date_from" placeholder="From" name="from" autocomplete="off" value="{{ !empty($_GET['from']) ? $_GET['from'] : '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input id="date_load_to" type="text" class="form-control date_to" placeholder="To" name="to" autocomplete="off" value="{{ !empty($_GET['to']) ? $_GET['to'] : '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div>
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit" formaction="{{ route('notification.view') }}"><strong>Filter</strong></button>
                                    </div>
                                    @include('admin.asset.components.clearFilterButton')
                                    {{--<div>
                                        <button id="excelBtn" class="btn btn-sm btn-warning float-right m-t-n-xs" type="submit" style="margin-right: 10px;" formaction="{{ route('transaction.complete.excel') }}"><strong>Excel</strong></button>
                                    </div>--}}
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
                        <h5>List of all transactions</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" title="Complete transactions list">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Type</th>
                                    <th>Send To</th>
                                    <th>Send By</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($notifications as $notification)
                                    <tr class="gradeC">
                                        <td>{{ $loop->index + ($notifications->perPage() * ($notifications->currentPage() - 1)) + 1 }}</td>
                                        <td>{{ $notification->created_at }}</td>
                                        <td>
                                            {{ $notification->title }}
                                        </td>
                                        <td>
                                            {{ strip_tags($notification->message) }}
                                        </td>
                                        <td>
                                            {{ $notification->notification_type }}
                                        </td>
                                        <td>
                                            {{ $notification->user->mobile_no ?? 'Group Message' }}
                                        </td>
                                        <td>
                                            {{ $notification->admin->email }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $notifications->appends(request()->query())->links() }}
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
    <script>
        $(document).ready(function (e) {
            let a = "Showing {{ $notifications->firstItem() }} to {{ $notifications->lastItem() }} of {{ $notifications->total() }} entries";
            $('.dataTables_info').text(a);
        });
    </script>
@endsection


