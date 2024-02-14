@extends('admin.layouts.admin_design')
@section('content')


    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>All General Pages</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>General Pages</strong>
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

        @include('admin.asset.notification.notify')
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>List of all general pages</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" title="General settings list">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($settings as $setting)
                                    <tr class="gradeC">
                                        <td>{{ $loop->index + 1}}</td>
                                        <td>{{ $setting->title}}</td>
                                        <td>
                                            @if(!empty($setting->image))
                                                <img src="{{ secure_asset('storage/uploads/settings/'. $setting->image) }}" alt="" style="height: 120px;">
                                            @endif
                                        </td>
                                        <td>
                                           {!! $setting->description !!}
                                        </td>

                                        <td>
                                            {{--<a href="{{ route('general.setting.detail', $setting->id) }}"><button class="btn btn-warning btn-icon" type="button"><i class="fa fa-info"></i></button></a>--}}
                                            <a href="{{ route('general.setting.update', $setting->id) }}"><button class="btn btn-info btn-icon" type="button"><i class="fa fa-edit"></i></button></a>
                                            <form action="{{ route('general.setting.delete') }}" method="post" id="deactivateForm" style="display: inline">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $setting->id }}">
                                                <button class="btn btn-danger btn-icon deactivate" rel="{{ $setting->id }}"><i class="fa fa-trash"></i></button>
                                                <button id="deactivateBtn-{{ $setting->id }}" type="submit" style=" display:none;"  rel="{{ route('general.setting.delete') }}"></button>
                                            </form>

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
    </div>
@endsection


@section('styles')
    @include('admin.asset.css.chosen')
    @include('admin.asset.css.datepicker')
    @include('admin.asset.css.datatable')
    <!-- Sweet Alert -->
    <link href="{{ secure_asset('admin/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('scripts')

    @include('admin.asset.js.chosen')
    @include('admin.asset.js.datepicker')
    @include('admin.asset.js.datatable')

    <!-- Sweet alert -->
    <script src="{{ secure_asset('admin/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        $('.deactivate').on('click', function (e) {

            e.preventDefault();
            let id = $(this).attr('rel');

            swal({
                title: "Are you sure?",
                text: "This data will be deleted",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Yes, delete!",
                closeOnConfirm: true,
                closeOnClickOutside: true
            }, function () {
                let deactivateButton = '#deactivateBtn-' + id;
                $(deactivateButton).trigger('click');
                swal.close();
            })
        });
    </script>


@endsection


