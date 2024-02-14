<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ (\DB::table('rebranding_setting')->value('site_title') ? ucfirst(\DB::table('rebranding_setting')->value('site_title')) : 'ERP') . ' ERP' }}</title>

    <link rel="icon" href="{{ asset('storage/uploads/settings/favicon/' . \DB::table('rebranding_setting')->value('favicon')) ?? '' }}" type="image/x-icon">

    <link href="{{ asset('admin/css/bootstrap.min.css', Config::get('app.IS_SSL')) }}" rel="stylesheet">
    <link href="{{ asset('admin/font-awesome/css/font-awesome.css', Config::get('app.IS_SSL')) }}" rel="stylesheet">

    <link href="{{ asset('admin/css/plugins/iCheck/custom.css', Config::get('app.IS_SSL'))}}" rel="stylesheet">
    <link href="{{ asset('admin/css/plugins/steps/jquery.steps.css', Config::get('app.IS_SSL'))}}" rel="stylesheet">

    <link href="{{ asset('admin/css/animate.css', Config::get('app.IS_SSL')) }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css', Config::get('app.IS_SSL')) }}" rel="stylesheet">


    <!-- Random Password Generation StyleSheet Link -->
    <link href="{{ asset('admin/css/randomPassword.css', Config::get('app.IS_SSL')) }}" rel="stylesheet">


    <!-- Icon link for Genrate and Copy Password -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
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

        .btn-success {
            background-color: #1ab394;
            border-color: #1ab394
        }

        .btn-success:hover, .btn-success:focus, .btn-success:active {
            background-color: #18a689 !important;
            border-color: #18a689 !important;
        }

        .ibox-content {
            padding-bottom: 15px;
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

    @include('admin.layouts.admin_sidebar')

    <div id="page-wrapper" class="gray-bg">

        @include('admin.layouts.admin_header')

        @yield('content')

        @include('admin.layouts.admin_footer')

    </div>

</div>

<!-- Mainly scripts -->
<script src="{{ asset('admin/js/jquery-3.1.1.min.js', Config::get('app.IS_SSL')) }} " ></script>
<script src="{{ asset('admin/js/popper.min.js', Config::get('app.IS_SSL')) }} " ></script>
<script src="{{ asset('admin/js/bootstrap.js', Config::get('app.IS_SSL')) }} " ></script>
<script src="{{ asset('admin/js/plugins/metisMenu/jquery.metisMenu.js', Config::get('app.IS_SSL')) }} " ></script>
<script src="{{ asset('admin/js/plugins/slimscroll/jquery.slimscroll.min.js', Config::get('app.IS_SSL')) }} " ></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('admin/js/inspinia.js', Config::get('app.IS_SSL')) }} " ></script>
<script src="{{ asset('admin/js/plugins/pace/pace.min.js', Config::get('app.IS_SSL')) }} " ></script>

 <!-- Steps -->
 <script src="{{ asset('admin/js/plugins/steps/jquery.steps.min.js', Config::get('app.IS_SSL'))}}"></script>

 <!-- Jquery Validate -->
 <script src="{{ asset('admin/js/plugins/validate/jquery.validate.min.js', Config::get('app.IS_SSL'))}}"></script>

<script>
    $('form').attr('autocomplete','off');
    $('.filter-clear-btn').on('click', function(e){
        e.preventDefault();
        let form = (this).closest('form');

        let inputFields = $("input", form);
        inputFields.each(function (index, inputField) {
           inputField.value = "";
        })

        let selectFields = $("select", form);
        selectFields.each(function (index, selectField) {
            selectField.selectedIndex = 0;
            let select2Data = $(selectField).siblings().children().children();
            select2Data[0].innerHTML = selectField.options[0].text;

        })

        let amountSliders = ['wallet_amount', 'payment_amount', 'loaded_amount', 'amount',
            'fund', 'balance', 'debit', 'total_transaction_amount',
            'total_transaction_commission', 'balance_transaction_statement',
            'amount_transaction', 'load_fund_amount']

        $.each(amountSliders, function (index, value) {
            try {
                let amountSliderData = $('.ionrange_' + value).data("ionRangeSlider")
                amountSliderData.update({
                    from: 0,
                    to: 100000
                })
            } catch (e) {

            }

        })

        let countSliders = ['transaction_count']
        $.each(countSliders, function (index, value) {
            try {
                let countSlidersData = $('.ionrange_' + value).data("ionRangeSlider")
                countSlidersData.update({
                    from: 0,
                    to: 10000
                })
            }catch (e) {

            }
        })

        try {
            let numberSliderData = $('.ionrange_number').data("ionRangeSlider");
            numberSliderData.update({
                from: 0,
                to: 1000
            })
        }catch (e) {

        }

    })
</script>

@yield('scripts')




</body>
</html>
