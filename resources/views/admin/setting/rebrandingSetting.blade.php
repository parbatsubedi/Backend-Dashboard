@extends('admin.layouts.admin_design')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Rebranding Settings</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Settings</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Rebranding Settings</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                @include('admin.asset.notification.notify')
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
                        <form method="post" action="{{ route('settings.rebrandingUpdate') }}" enctype="multipart/form-data"
                              id="notificationForm">
                            @csrf

                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Site Title</label>
                                <div class="col-sm-10">
                                    <input value="{{  $dbData->site_title ?? ''}}" name="site_title" type="text"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Site Logo</label>
                                <div class="col-sm-10">
                                    <div class="custom-file">
                                        <input name="site_logo" id="logo1" type="file" class="custom-file-input">
                                        <label for="logo1" class="custom-file-label">Choose file...</label>
                                    </div>

                                    <div class="row" style="margin-top: 20px;">
                                        <div class="col-md-4">
                                        @if (!empty($dbData->logo))
                                            <img class="d-block w-100"
                                                src="{{ asset('storage/uploads/settings/' . $dbData->logo) }}"
                                                alt="logo">
                                        @else
                                           <img src="" alt="logo">
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Favicon</label>
                                <div class="col-sm-10">
                                    <div class="custom-file">
                                        <input name="favicon" id="favicon" type="file" class="custom-file-input">
                                        <label for="favicon" class="custom-file-label">Choose file...</label>
                                    </div>

                                    <div class="row" style="margin-top: 20px;">
                                        <div class="col-md-4">
                                        @if (!empty($dbData->favicon))
                                            <img class="d-block w-100"
                                                src="{{ asset('storage/uploads/settings/favicon/' . $dbData->favicon) }}"
                                                alt="logo">
                                        @else
                                           <img src="" alt="logo">
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Sender SMTP Email</label>
                                <div class="col-sm-10">
                                    <input value="{{  $email ?? ''}}" name="smtp_email" type="email"
                                           class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Sender SMTP Password</label>
                                <div class="col-sm-10">
                                    <input value="{{ $smtp_password ?? '' }}" name="smtp_password" type="text"
                                           class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Site Color</label>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Primary Color</label>
                                <div class="col-sm-5">
                                    <input type="text" id="primary-color-picker" name="primary_color" value="{{ $dbData->primary_color ?? '#2f4050' }}" class="form-control">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Secondary Color</label>
                                <div class="col-sm-5">
                                    <input type="text" id="secondary-color-picker" name="secondary_color" value="{{ $dbData->secondary_color ?? '#18a689' }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Global Text Color</label>
                                <div class="col-sm-5">
                                    <input type="text" id="global-text-color-picker" name="global_text_color" value="{{ $dbData->global_text_color ?? '#212529' }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Sidebar Text Color</label>
                                <div class="col-sm-5">
                                    <input type="text" id="text-color-picker" name="text_color" value="{{ $dbData->text_color ?? '#a7b1c2' }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Button Text Color</label>
                                <div class="col-sm-5">
                                    <input type="text" id="btn-text-color-picker" name="button_text_color" value="{{ $dbData->button_text_color ?? '#a7b1c2' }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Hover Color</label>
                                <div class="col-sm-5">
                                    <input type="text" id="hover-color-picker" name="hover_color" value="{{ $dbData->hover_color ?? '#a7b1c2' }}" class="form-control">
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>

                            @can('Rebranding setting update')
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                    </div>
                                </div>
                            @endcan
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

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>

    <!--Color Picker -->
    <script>
        $("#primary-color-picker").spectrum({
            showInput: true,
            showAlpha: true,
            preferredFormat: "hex",
            move: function(color) {
                var selectedColor = color.toHexString();
                document.body.style.backgroundColor = selectedColor;
                var metisMenuElements = document.querySelectorAll(".sidebar-collapse ul");
                for (var i = 0; i < metisMenuElements.length; i++) {
                    metisMenuElements[i].style.setProperty("background-color", color, "important");
                }
                applyColorToNavLi(selectedColor);
            },
        });

        function applyColorToNavLi(selectedColor) {
            var styleTag = document.createElement('style');
            styleTag.innerHTML = `
                .navbar-default .nav > li > a:hover,
                .navbar-default .nav > li > a:focus {
                    background-color: ${selectedColor} !important;
                }
            `;
            document.head.appendChild(styleTag);
        }
    </script>
    <script>
        $("#secondary-color-picker").spectrum({
            showInput: true,
            showAlpha: true,
            preferredFormat: "hex",
            move: function(color){
                var selectedColor = color.toHexString();
                var styleLiTag = document.createElement('style');
                styleLiTag.innerHTML = `
                    .navbar-default .nav > li.active {
                        border-left: 4px solid ${selectedColor} !important;
                    }
                `;
                document.head.appendChild(styleLiTag);


                var styleBtnTag = document.createElement('style');
                styleBtnTag.innerHTML = `
                    .btn-primary {
                        background-color: ${selectedColor} !important;
                        border-color: ${selectedColor} !important; 
                    }
                `;
                document.head.appendChild(styleBtnTag);

            }
        });
    </script>

    <script>
        $("#global-text-color-picker").spectrum({
            showInput: true,
            showAlpha: true,
            preferredFormat: "hex",

            move: function(color){
                var selectedColor = color.toHexString();
                var styleTag = document.createElement('style');
                styleTag.innerHTML = `
                    body, .welcome-message {
                        color: ${selectedColor} !important;
                    }
                `;
                document.head.appendChild(styleTag);
            }
        });
    </script>
    <script>
        $("#text-color-picker").spectrum({
            showInput: true,
            showAlpha: true,
            preferredFormat: "hex",

            move: function(color) {
                var selectedColor = color.toHexString();
                var styleTag = document.createElement('style');
                styleTag.innerHTML = `
                    .nav-header a, .nav-header .text-muted, .nav > li > a{
                        color: ${selectedColor} !important;
                    }
                `;
                document.head.appendChild(styleTag);
            }
        });
    </script>
    <script>
        $("#btn-text-color-picker").spectrum({
            showInput: true,
            showAlpha: true,
            preferredFormat: "hex",

            move: function(color) {
                var selectedColor = color.toHexString();
                var styleTag = document.createElement('style');
                styleTag.innerHTML = `
                    .btn-primary{
                        color: ${selectedColor} !important;
                    }
                `;
                document.head.appendChild(styleTag);
            }
        });
    </script>

    <script>
        $("#hover-color-picker").spectrum({
            showInput: true,
            showAlpha: true,
            preferredFormat: "hex",

            move: function(color) {
                var selectedColor = color.toHexString();
                var styleTag = document.createElement('style');
                styleTag.innerHTML = `
                    .nav > li > a:hover,
                    .logo-element:hover,
                    .nav > li > a:focus,
                    .logo-element:focus {
                        color: ${selectedColor} !important;
                        font-size: 1.1em;
                    }
                `;
                document.head.appendChild(styleTag);
            }
        });
    </script>


    <script>
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
@endsection

