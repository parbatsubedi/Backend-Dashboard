<script type="text/javascript" src="{{asset('admin/js/plugins/jsoneditor/jquery.json-editor.min.js', Config::get('app.IS_SSL'))}}"></script>

{{--<script src="{{ asset('admin/js/plugins/jsoneditor/jquery.json-editor.js') }}"></script>--}}
<script>
    function getJson() {
        try {
            return JSON.parse($('#json-input').val());
        } catch (ex) {
            alert('Wrong JSON Format: ' + ex);
        }
    }

    var editor = new JsonEditor('#json-display', getJson());
    $('#translate').on('click', function () {
        editor.load(getJson());
    });
</script>
