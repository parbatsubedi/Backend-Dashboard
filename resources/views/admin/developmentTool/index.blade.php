@extends('admin.layouts.admin_design')
@section('content')
    <div class="wrapper wrapper-content">
        {{--Admin Dashboard--}}
        <h2 style="margin-top: -5px; margin-left: 5px;">Development Tool</h2>

        @can('Development tool backup database')
        <div class="row">
                <div class="col-lg-3">
                    <a href="{{ route('developmentTool.backup') }}"> <div class="ibox ">
                        <div class="ibox-title" style="padding-right: 15px;">
                            <span class="label label-success float-right">Backup</span>
                            <h5>Backup Database</h5>
                        </div>
                    </div></a>
                </div>
        </div>
        @endcan




    </div>
@endsection

@section('styles')

@endsection


@section('scripts')



@endsection



