<script src="{{ asset('admin/js/plugins/dataTables/datatables.min.js', Config::get('app.IS_SSL')) }}"></script>
<script src="{{ asset('admin/js/plugins/dataTables/dataTables.bootstrap4.min.js', Config::get('app.IS_SSL')) }}"></script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){

        $('.dataTables-example').each(function () {

            let table = this;

            console.log(table.title);

            $(table).DataTable({
                "order": [],
                "pageLength": 25,
                paging: true,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy', title: table.title},
                    {extend: 'csv', title: table.title},
                    {extend: 'excel', title: table.title},
                    {extend: 'pdf', title: table.title},
                    {extend: 'print',
                        customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '12px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit')
                                .css('color', 'black');

                            $(win.document.body).find('h1').css('font-size', 'bold').css('color', 'black');
                            $(win.document.body).find('td:last-child').css('display', 'none');
                            $(win.document.body).find('th:last-child').css('display', 'none');
                        },
                        title: table.title
                    }
                ]
            });
        });
    });
</script>
