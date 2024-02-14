
{{--Yearly and monthly button click--}}
<!--
<script>

    $('#yearlyButton').one('click', function (e) {
        let url = $(this).attr('rel');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            method:"POST",
            data: {data:'data'},
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            beforeSend: function () {
                $("#overlay").fadeIn(300);
            },
            success: function (resp) {

                loadYearGraph(resp.graph, 'flot-dashboard-chart-yearly');

                $("#overlay").fadeOut(300);

            },
            error: function (resp) {
                console.log(resp);
                alert('error');
            }
        });
    });

    $('#yearlyButton').on('click', function (e) {

        $('#monthlyButton').removeClass('active');
        $(this).addClass('active');

        $('#graphTitlePaypoint').text('PayPoint Yearly Transaction / Users Involved Graph');
        $('#monthly').css('display', 'none');
        $('#yearly').css('display', 'block');

    });

    $('#monthlyButton').on('click', function (e) {
        $('#yearlyButton').removeClass('active');
        $(this).addClass('active');

        $('#graphTitlePaypoint').text('PayPoint Monthly Transaction / Users Involved Graph');
        $('#yearly').css('display', 'none');
        $('#monthly').css('display', 'block');
    });
</script>
Yearly and monthly button click paypoint
<script>

    $('#yearlyButton2').one('click', function (e) {
        let url = $(this).attr('rel');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            method:"POST",
            data: {data:'data'},
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            beforeSend: function () {
                $("#overlay").fadeIn(300);
            },
            success: function (resp) {

                loadYearGraph(resp.graph, 'flot-dashboard-chart-yearly-npay');

                $("#overlay").fadeOut(300);

            },
            error: function (resp) {
                console.log(resp);
                alert('error');
            }
        });
    });

    $('#yearlyButton2').on('click', function (e) {

        $('#monthlyButton2').removeClass('active');
        $(this).addClass('active');

        $('#graphTitleNpay').text('Npay Yearly Transaction / Users Involved Graph');
        $('#monthly2').css('display', 'none');
        $('#yearly2').css('display', 'block');

    });

    $('#monthlyButton2').on('click', function (e) {
        $('#yearlyButton2').removeClass('active');
        $(this).addClass('active');

        $('#graphTitle').text('Npay Monthly Transaction / Users Involved Graph');
        $('#yearly2').css('display', 'none');
        $('#monthly2').css('display', 'block');
    });
</script>
-->
