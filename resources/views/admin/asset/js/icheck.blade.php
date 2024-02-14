<script src="{{ asset('admin/js/plugins/iCheck/icheck.min.js', Config::get('app.IS_SSL')) }}"></script>
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>
