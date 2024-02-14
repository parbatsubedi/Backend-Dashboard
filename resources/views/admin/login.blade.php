
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ (\DB::table('rebranding_setting')->value('site_title') ? ucfirst(\DB::table('rebranding_setting')->value('site_title')) : 'ERP') . ' | Login' }}</title>

    <link rel="icon" href="{{ asset('storage/uploads/settings/favicon/' . \DB::table('rebranding_setting')->value('favicon')) ?? '' }}" type="image/x-icon">
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">

<section class="h-100 form-login" style="background-color: #f3f3f4;">
    <div class="container py-5 h-100" style="margin-top: -40px;">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-4">
                <div class="rounded-3 text-black" style="background-color: #f3f3f4 !important;">
                    <div class="loginColumns animated fadeInDown">
                        <div class="row">
                            <div class="card-body p-md-3 mx-md-1">
                                <div class="text-center">
                                    <img src="{{ asset('storage/uploads/settings/' . \DB::table('rebranding_setting')->value('logo')) }}" alt="Site Logo" class="responsive-site-logo">
                                    <h3 class="font-bold">Welcome to {{ (\DB::table('rebranding_setting')->value('site_title') ? ucfirst(\DB::table('rebranding_setting')->value('site_title')) : 'ERP') }}</h3>
                                    <p>Admin panel of Business- {{ (\DB::table('rebranding_setting')->value('site_title') ? ucfirst(\DB::table('rebranding_setting')->value('site_title')) : 'ERP') }}</p>
                                </div>

                                <div class="text-center">
                                    @include('admin.asset.notification.notify')
                                </div>

                                <form class="m-t" role="form" action="{{ route('admin.login') }}" method="post" autocomplete="off">
                                @csrf
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Email" required="" value="{{old('email')}}">
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required="">
                                    </div>

                                    <div class="text-group">
                                        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                                    </div>
                                </form>

                                <div class="text-center">
                                <small>{{ (\DB::table('rebranding_setting')->value('site_title') ? ucfirst(\DB::table('rebranding_setting')->value('site_title')) : 'ERP') }} admin panel all rights reserved &copy; {{ Date('Y') }}</small>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


</body>
<style>
    .responsive-site-logo {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
    }
    @media (min-width: 768px) {
        .form-login {
            height: 100vh !important;
        }
    }
</style>
<script src="{{ asset('admin/js/jquery-3.1.1.min.js') }} " ></script>
<script>
    $('.close').on('click', function (e) {
        $('.alert-danger').hide();
    });
</script>

<?php
    $secondaryColor = \DB::table('rebranding_setting')->value('secondary_color');
    $btnTextColor = \DB::table('rebranding_setting')->value('button_text_color');

    if($secondaryColor != "#18a689"){
?>
    <script>
        var secondaryColor = "<?php echo $secondaryColor; ?>";

        var styleLiTag = document.createElement('style');
                styleLiTag.innerHTML = `
                    .navbar-default .nav > li.active {
                        border-left: 4px solid ${secondaryColor} !important;
                    }
                `;
                document.head.appendChild(styleLiTag);


                var styleBtnTag = document.createElement('style');
                styleBtnTag.innerHTML = `
                    .btn-primary, .page-item.active .page-link {
                        background-color: ${secondaryColor} !important;
                        border-color: ${secondaryColor} !important; 
                    }
                `;
                document.head.appendChild(styleBtnTag);
    </script>
    <?php } ?>
    <?php if($btnTextColor != "#a7b1c2"){ ?>
    <script>
        var btnTextColor = "<?php echo $btnTextColor; ?>";

        var styleTag = document.createElement('style');
                styleTag.innerHTML = `
                    .btn-primary{
                        color: ${btnTextColor} !important;
                    }
                `;
                document.head.appendChild(styleTag);
    </script>

    <?php } ?>
</html>
