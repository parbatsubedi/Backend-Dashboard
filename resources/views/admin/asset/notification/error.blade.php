@if(session('error'))
    <div class="col-md-12">
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{ session('error') }}
        </div>
    </div>
@endif
