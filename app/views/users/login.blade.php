@extends('layouts.travel')

@section('title')
Login | Visits
@stop

@section('content')

<div class="main-body login-page">

    <div class="container about-page">
        <h1>Login</h1>

        <div class="row">
            <div class="col-md-push-3 col-md-6">
                {{ Form::open(array('url' => '/user/login-process', 'role' => 'form', 'method' => 'POST', 'class' => 'formplate aside-filter', 'id' => 'login-form')) }}
                    @if (Session::has('error'))
                    <div>
                        <strong>Error!</strong> {{Session::get('error')}}
                    </div>
                    @endif

                    @if (Session::has('message'))
                    <div>
                        <strong>Information</strong> {{Session::get('message')}}
                    </div>
                    @endif
                    <input value="{{{Input::old('email')}}}" name="email" required="true" type="email" id="inputEmail1" placeholder="Email Address">
                    <input required="true" name="password" type="password" id="inputPassword1" name="password" placeholder="Password">

                    <div>
                        <input type="checkbox" class="white" id="remember-me"><label for="remember-me">Remember Me</label>
                    </div>

                    <a href="{{ action('UserController@reset') }}">Forgot your password?</a>
                    <input type="submit" value="Sign In" class="yellow">
                {{ Form::close() }}

            </div>
        </div>
    </div>

</div>



@stop

@section('scripts')
<script>
    $("#login-form").validate();
</script>
@stop