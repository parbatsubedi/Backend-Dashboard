@if(session('success'))
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{ session('success') }}
        </div>
    </div>
@endif
