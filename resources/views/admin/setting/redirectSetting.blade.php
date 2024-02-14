@extends('admin.layouts.admin_design')
@section('content')


    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Redirect Settings</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>

                <li class="breadcrumb-item">
                    <a >Settings</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>Redirect Settings</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <form method="post" enctype="multipart/form-data" id="notificationForm">
            @csrf
            <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Settings</h5>
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

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Redirect Title</label>
                            <div class="col-sm-10">
                                <input value="{{ $settings['redirect_title'] ?? ''}}" name="redirect_title" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Redirect Logo Url</label>
                            <div class="col-sm-10">
                                <input value="{{ $settings['redirect_logo_url'] ?? ''}}" name="redirect_logo_url" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Return After Redirect Url</label>
                            <div class="col-sm-10">
                                <input value="{{ $settings['return_after_redirect_url'] ?? ''}}" name="return_after_redirect_url" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Return After Redirect App</label>
                            <div class="col-sm-10">
                                <input value="{{ $settings['return_after_redirect_app'] ?? ''}}" name="return_after_redirect_app" type="text" class="form-control">
                            </div>
                        </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
