
<script src="{{ asset('admin/js/datepicker.js', Config::get('app.IS_SSL')) }}"></script>
<script src="{{ asset('admin/js/plugins/clockpicker/clockpicker.js', Config::get('app.IS_SSL')) }}"></script>

<script>
    $(".date_from").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        keyboardNavigation: false,
    });

    $(".date_till").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        keyboardNavigation: false,
    });
</script>

<script>
    $(".date_from").change(function () {
        var start_date = $(this).val();

        $(".date_to").val('');
        $(".date_to").removeAttr('readonly');
        $(".date_to").datepicker('destroy');
        $(".date_to").datepicker({
            autoclose: true,
            todayHighlight: true,
            startDate:new Date(start_date),
            format: 'yyyy-mm-dd'
        });
    });

    $(".date_to").keyup(function () {
        $(this).val('');
    });
</script>

{{--    //For Second Date --}}
<script>
    $(".date_from_load").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        keyboardNavigation: false,
    });

</script>

<script>
    $(".date_from_load").change(function () {
        var start_date = $(this).val();

        $(".date_to_load").val('');
        $(".date_to_load").removeAttr('readonly');
        $(".date_to_load").datepicker('destroy');
        $(".date_to_load").datepicker({
            autoclose: true,
            todayHighlight: true,
            startDate:new Date(start_date),
            format: 'yyyy-mm-dd'
        });
    });

    $(".date_to_load").keyup(function () {
        $(this).val('');
    });
</script>

<script>
    $(".select-date").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        keyboardNavigation: false,
    });
</script>
<script>
    $(".select_date").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        keyboardNavigation: false,
    });
</script>

<script>
    /*$(".date_with_time").datepicker({
         autoclose: true,
         todayHighlight: true,
         format: 'dd M yyyy HH:mm',
         keyboardNavigation: false,
    });*/

    $(".date_with_time").clockpicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd M yyyy HH:mm',
        keyboardNavigation: false,
    });

</script>


