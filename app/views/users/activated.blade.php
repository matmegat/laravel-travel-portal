@extends('layouts.master')

@section('content')

<div class="container">
    <div class="auth_box">
        <header>
            <h3>Success</h3>
            <p>User is successfully activated.
    You can {{link_to('user/login', 'login')}} now.</p>
        </header>
    </div>
</div>

@stop