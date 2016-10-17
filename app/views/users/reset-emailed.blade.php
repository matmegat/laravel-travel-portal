@extends('layouts.travel')



@section('content')

<div class="main-body login-page">

    <div class="container about-page">

        <div class="row">
            <div class="col-md-push-3 col-md-6">

            @if (Session::has('error'))
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> {{Session::get('error')}}
            </div>
            @endif

            <h3 style="color:#fff;">Please check your inbox for email with further instructions.</h3>



            </div>
        </div>
    </div>
                
@stop




@section('content')

<div class="container">
    <div class="auth_box">
        <header>
            <h3>Please check your inbox for email with further instructions.</h3>
        </header>
    </div>
</div>

@stop