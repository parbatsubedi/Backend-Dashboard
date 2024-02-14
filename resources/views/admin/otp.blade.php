
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin | OTP </title>

    <link href="{{ secure_asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('admin/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ secure_asset('admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('admin/css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="loginColumns animated fadeInDown">
    <div class="row">

        <div class="col-md-12">
            @include('admin.asset.notification.notify')
        </div>

        <div class="col-md-6">
            <h2 class="font-bold">Welcome to Dpaisa</h2>

            <p>Admin panel of Dpaisa </p>

        </div>
        <div class="col-md-6">

            <div class="ibox-content">
                <form class="m-t" role="form" action="{{ route('admin.login.otp') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="otp" class="form-control" placeholder="OTP Code" required="">
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">Enter OTP</button>


                </form>
                <p class="m-t">
                    <small>Dpaisa admin panel all rights reserved &copy; {{ Date('Y') }}</small>
                </p>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6">
            Copyright Pvt. Ltd.
        </div>
        <div class="col-md-6 text-right">
            <small>© {{ Date('Y') }}</small>
        </div>
    </div>
</div>


</body>
<script src="{{ secure_asset('admin/js/jquery-3.1.1.min.js') }} " ></script>
<script>
    $('.close').on('click', function (e) {
        $('.alert-danger').hide();
    });
</script>
</html>
