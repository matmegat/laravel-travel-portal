@extends('layouts.travel')

@section('content')



<div class="auth_pages">

    @if (Session::has('error'))
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Error!</strong> {{Session::get('error')}}
    </div>
    @endif

    {{ Form::open(array('url' => action('UserController@resetContinue', array('id' => $user_id, 'code' => $code)), 'role' => 'form', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'reset-continue-form')) }}
        <div class="container">
            <div class="auth_box">  
                <header>
                    <h3>Update your password</h3>
                </header>
                <article>
                    <div class="password">
                        <input maxlength="50" required="true" minlength="5" type="password" name="password" class="form-control" id="inputPassword1" placeholder="Password">
                    </div>
                    <div class="password">
                        <input equalTo="#inputPassword1" maxlength="50" required="true" minlength="5" type="password" class="form-control" id="inputPassword2" placeholder="Repeat Password">
                    </div>
                </article>
                <footer>
                    <button type="submit" class="big_button">Reset</button>
                </footer>
            </div>
        </div>
    {{ Form::close() }}
<script>
    $("#reset-continue-form").validate();
</script>
</div>







<div class="row col-md-6 col-md-offset-3">

@if (Session::has('error'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Error!</strong> {{Session::get('error')}}
</div>
@endif




</div>

@stop