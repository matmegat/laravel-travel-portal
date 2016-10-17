@extends('layouts.travel')

@section('content')

<div class="container">
    <div class="auth_box">
        <header>
            <h3>Thank You for registering on {{Config::get('site.domain')}}!
We sent you a mail to validate your email address.
Please check your inbox and click on activation link there.</h3>
        </header>
    </div>
</div>



@stop