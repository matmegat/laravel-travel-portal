@extends('layouts.travel')

@section('title')
Register | Visits
@stop

@section('content')

<div class="auth_pages">

    @if (Session::has('error'))
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Error!</strong> {{Session::get('error')}}
    </div>
    @endif
    {{ Form::open(array('url' => '/user/register-process', 'role' => 'form', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'signup-form')) }}
        <div class="container">
            <div class="auth_box">
                 <header>
                    <h3>Sign in</h3>
                </header>
                <article>
                    <div class="name">
                        <!--<label for="firstname" class="col-lg-4 control-label">First name</label>-->
                            <input value="{{{Input::old('firstname')}}}" required="true" type="text" name="first_name" id="firstname" placeholder="First Name">
                    </div>
                    <div class="name">
                        <!--<label for="lastname" class="col-lg-4 control-label">Last name</label>-->
                            <input value="{{{Input::old('lastname')}}}" required="true" type="text" name="last_name" id="lastname" placeholder="Last Name">
                    </div>
                    <div class="email">
                        <!--<label for="inputEmail1" class="col-lg-4 control-label">Email</label>-->
                            <input value="{{{Input::old('email')}}}" required="true" type="email" name="email" id="inputEmail1" placeholder="Email">
                    </div>
                    <div class="password">
                        <!--<label for="inputPassword1" class="col-lg-4 control-label">Password</label>-->
                            <input maxlength="50" required="true" minlength="5" type="password" name="password" id="inputPassword1" placeholder="Password">
                    </div>
                    <div class="password">
                        <!--<label for="inputPassword2" class="col-lg-4 control-label">Repeat password</label>-->
                            <input maxlength="50" required="true" minlength="5" type="password" id="inputPassword2" placeholder="Repeat Password">
                    </div>
                </article>
                <footer>
                    <button type="submit" class="big_button">Sign up</button>
                </footer>

            </div>
        </div>
    {{ Form::close() }}
    <script>
        $("#signup-form").validate({
            rules: {
                inputPassword1: "required",
                inputPassword2: {
                    equalTo: "#inputPassword1"
                }
            }
        });
    </script>
</div>

@stop