<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel</title>

    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">

    <style>
        .btn-icon {
            width: 25px;
            height: 25px;
            padding: 2px 0;
        }

        #button{
            display:block;
            margin:20px auto;
            padding:10px 30px;
            background-color:#eee;
            border:solid #ccc 1px;
            cursor: pointer;
        }
        #overlay{
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height:100%;
            display: none;
            background: rgba(0,0,0,0.6);
        }
        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px #ddd solid;
            border-top: 4px #2e93e6 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }
        @keyframes sp-anime {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(359deg);
            }
        }
        .is-hide{
            display:none;
        }

        .navbar-minimalize {
            display: none;
        }

        .table-bordered {
            border: 1px solid #EBEBEB !important;
        }

        .ibox-content {
            padding-bottom: 5px !important;
        }

         .apexcharts-menu-icon {
             display: none;
         }
    </style>
    @yield('styles')
</head>

<body>
<div id="wrapper">
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
    <div id="page-wrapper" class="gray-bg" style="width: 100%">

        @include('admin.layouts.admin_header')

        @yield('content')

        @include('admin.layouts.admin_footer')
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ asset('admin/js/jquery-3.1.1.min.js') }} " ></script>
<script src="{{ asset('admin/js/popper.min.js') }} " ></script>
<script src="{{ asset('admin/js/bootstrap.js') }} " ></script>
<script src="{{ asset('admin/js/plugins/metisMenu/jquery.metisMenu.js') }} " ></script>
<script src="{{ asset('admin/js/plugins/slimscroll/jquery.slimscroll.min.js') }} " ></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('admin/js/inspinia.js') }} " ></script>
<script src="{{ asset('admin/js/plugins/pace/pace.min.js') }} " ></script>

<script>
    $('form').attr('autocomplete','off');
</script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('admin/js/inspinia.js') }} " ></script>
<script src="{{ asset('admin/js/plugins/pace/pace.min.js') }} " ></script>

<!-- jQuery UI -->
<script src="{{ asset('admin/js/plugins/jquery-ui/jquery-ui.min.js') }} " ></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

@yield('scripts')

</body>
</html>
