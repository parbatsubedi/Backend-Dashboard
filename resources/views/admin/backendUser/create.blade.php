@extends('admin.layouts.admin_design')
@section('content')


    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Create admin user</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>

                <li class="breadcrumb-item">
                    <a >Backend Users</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>Create</strong>
                </li>

            </ol>
        </div>

    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Create backend user</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" enctype="multipart/form-data" id="notificationForm">
                            @csrf
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input name="name" type="text" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input name="email" type="email" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Mobile No.</label>
                                <div class="col-sm-10">
                                    <input name="mobile_no" type="text" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input name="password" type="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Assign Role</label>
                                <div class="col-sm-10">
                                    <select class="select2_demo_2 form-control" multiple="multiple" name="roles[]">
                                        @foreach($allRoles as $allRole)
                                            <option value="{{ $allRole->name }}"

                                            >{{ $allRole->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>


                            <div class="hr-line-dashed"></div>



                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary btn-sm" type="submit">Create backend user</button>
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

