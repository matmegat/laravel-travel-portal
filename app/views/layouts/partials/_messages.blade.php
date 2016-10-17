@if(\Session::has('error'))
    <div class="alert alert-danger">
        <strong>Error!</strong> {{ \Session::get('error') }}
    </div>
@endif