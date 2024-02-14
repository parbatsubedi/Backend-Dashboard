@extends('admin.layouts.admin_design')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Assign role to {{ $user->name }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a >Backend Users</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Assign role</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title collapse-link">
                        <h5>Assign role to {{ $user->name }}</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="post" enctype="multipart/form-data" id="notificationForm">
                            @csrf
                            <div class="form-group">
                                <label class="font-normal">Select Roles</label>
                                <select class="select2_demo_2 form-control" multiple="multiple" name="roles[]">
                                    @foreach($allRoles as $allRole)
                                        <option value="{{ $allRole->name }}"

                                        @foreach($user->roles as $role)
                                            @if($role->id == $allRole->id)
                                                selected
                                            @endif
                                        @endforeach

                                        >{{ $allRole->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary btn-sm" type="submit">Update Roles</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    @include('admin.asset.css.select2')
@endsection

@section('scripts')
    @include('admin.asset.js.select2')
@endsection

