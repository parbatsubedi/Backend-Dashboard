@extends('admin.layouts.admin_design')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>All Seeders</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>Seeders</strong>
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
                        <h5>List of all Seeders</h5>

                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example"
                                   title="Seeder List">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Seeder Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($seederFileName as $key=>$seederFileName)
                                    @if($seederFileName != "." && $seederFileName != "..")
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $seederFileName }} </td>
                                            <td>
                                                @can('Run seeder')
                                                    <form
                                                        action="{{ route('seeder.run',substr($seederFileName,0,-4)) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                                class="reset btn btn-sm btn-primary m-t-n-xs"
                                                                rel="{{ substr($seederFileName,0,-4) }}">Run
                                                        </button>
                                                        <button id="resetBtn-{{ substr($seederFileName,0,-4) }}"
                                                                style="display: none" type="submit"
                                                                href="{{ route('seeder.run',substr($seederFileName,0,-4)) }}"
                                                                class="resetBtn btn btn-sm btn-danger m-t-n-xs"><strong>Run</strong>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            {{--                                {{ $transactions->appends(request()->query())->links() }}--}}
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

    <link href="{{ asset('admin/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">


    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css"/>
@endsection

@section('scripts')

    @include('admin.asset.js.chosen')
    @include('admin.asset.js.datepicker')
    @include('admin.asset.js.datatable')
    <script>
        @if(!empty($_GET))
        $(document).ready(function (e) {
            let a = "Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} entries";
            $('.dataTables_info').text(a);
        });
        @endif
    </script>

    <!-- IonRangeSlider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js"></script>
    <script>
        let amount = @if(!empty($_GET['amount'])) `{{ $_GET['amount'] }}`;
        @else '0;100000'; @endif
        let split = amount.split(';');
        $(".ionrange_amount").ionRangeSlider({
            type: "double",
            grid: true,
            min: 0,
            max: 100000,
            from: split[0],
            to: split[1],
            prefix: "Rs."
        });
    </script>

    <script>
        $('#excel').submit(function (e) {
            e.preventDefault();
            let url = $(this).attr('action').val();
        });
    </script>

    <script src="{{ asset('admin/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $('.reset').on('click', function (e) {
            e.preventDefault();
            let seederClassName = $(this).attr('rel');
            console.log(seederClassName);
            swal({
                title: "Are you sure?",
                text: "Do you want to run this seeder file",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            }, function () {
                console.log('#resetBtn-' + seederClassName);
                $('#resetBtn-' + seederClassName).trigger('click');
                swal.close();

            })
        });
    </script>

@endsection


