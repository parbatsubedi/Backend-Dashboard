@extends('admin.layouts.admin_design')
@section('content')
    <div class="wrapper wrapper-content">
        {{--Admin Dashboard--}}
        @include('admin.dashboard.adminDashboard')
        <hr>
    </div>
@endsection

@section('styles')
    <!-- FooTable -->
    <link href="{{ secure_asset('admin/css/plugins/footable/footable.core.css') }}" rel="stylesheet">
    <style>
        .apexcharts-menu-icon {
            display: none;
        }
    </style>

    @include('admin.asset.css.datatable')
@endsection


@section('scripts')

    <!-- Custom and plugin javascript -->
    <script src="{{ secure_asset('admin/js/inspinia.js') }} " ></script>
    <script src="{{ secure_asset('admin/js/plugins/pace/pace.min.js') }} " ></script>

    <!-- jQuery UI -->
    <script src="{{ secure_asset('admin/js/plugins/jquery-ui/jquery-ui.min.js') }} " ></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @include('admin.asset.js.datatable')

{{--    @include('admin.dashboard.js.graph.graphButtons')--}}

{{--    @include('admin.dashboard.js.graph.monthlyPayPoint')--}}
{{--    @include('admin.dashboard.js.graph.monthlyNPay')--}}
{{--    @include('admin.dashboard.js.graph.yearly')--}}
{{--    @include('admin.dashboard.js.graph.executePaymentTimeElapsed')--}}

    <!-- FooTable -->
    <script src="{{ secure_asset('admin/js/plugins/footable/footable.all.min.js') }}"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {

            $('.footable').footable();
            $('.footable2').footable();

        });
    </script>
@endsection



