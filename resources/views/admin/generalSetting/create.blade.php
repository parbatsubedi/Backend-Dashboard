@extends('admin.layouts.admin_design')
@section('content')


    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Create General Page Settings</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Settings</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Create General Page Settings</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
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
                        <form method="post" action="{{ route('general.setting.create') }}" enctype="multipart/form-data"
                              id="notificationForm">
                            @csrf

                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input name="title" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <div class="custom-file">
                                        <input name="image" id="logo1" type="file" class="custom-file-input">
                                        <label for="logo1" class="custom-file-label">Choose file...</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Description</label>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="ibox ">
                                        <div class="ibox-content no-padding">
                                            <textarea name="description" class="summernote" style="display: none; height: 100px;">
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
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
    @include('admin.asset.css.summernote')
@endsection

@section('scripts')
    @include('admin.asset.js.summernote')
    <script>
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
@endsection

