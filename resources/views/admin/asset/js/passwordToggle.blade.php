<script>
    $('.toggle-password').on('click', function (e) {
        $(this).find('.passwordIcon').toggleClass('fa-eye-slash');
        let inputId = '#' + $(this).attr('rel');

        if ($(inputId).attr('type') === 'password') {
            $(inputId).attr('type', 'text')
        } else {
            $(inputId).attr('type', 'password')
        }
    });
</script>
