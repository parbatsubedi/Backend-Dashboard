<script src="{{ secure_asset('admin/js/plugins/summernote/summernote-bs4.js',Config::get('app.IS_SSL') ) }}"></script>

<script>
    $(document).ready(function(){

        $('.summernote').summernote();

    });
</script>
