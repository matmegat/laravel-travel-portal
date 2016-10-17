@extends('layouts.travel')

@section('title')
Reset Password | Visits
@stop


@section('content')

<div class="main-body login-page">

    <div class="container about-page">
        <h1>Reset Password</h1>

        <div class="row">
            <div class="col-md-push-3 col-md-6">

            @if (Session::has('error'))
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> {{Session::get('error')}}
            </div>
            @endif

            {{ Form::open(array('url' => '/user/reset-process', 'role' => 'form', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'reset-form')) }}

            <h3 style="color:#fff;">Please enter here your email address which you used for registration</h3>

            <article>
                <div class="email">
                    <input value="{{{Input::old('email')}}}" required="true" type="email" name="email" id="inputEmail1" placeholder="Email">
                </div>
            </article>
            <footer>
                <input type="submit" value="Reset" class="yellow">
            </footer>


            {{ Form::close() }}


            </div>
        </div>
    </div>
                
@stop


@section('scripts')
    <script>
        $("#reset-form").validate();
    </script>
@stop