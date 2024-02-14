@extends('admin.layouts.admin_design')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Update admin profile</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a >Backend Users</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Update Profile</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>update {{ auth()->user()->name }}'s profile</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" action="{{ route('backendUser.profile') }}" enctype="multipart/form-data" >
                            @csrf
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input name="name" type="text" class="form-control" value="{{ $admin->name }}" required>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input name="email" type="email" class="form-control" value="{{ $admin->email }}" required>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Mobile No.</label>
                                <div class="col-sm-10">
                                    <input name="mobile_no" type="text" class="form-control" value="{{ $admin->mobile_no }}" required>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary btn-sm" type="submit">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
