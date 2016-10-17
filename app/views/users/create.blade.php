@extends('layouts.master')

@section('content')

<div class="col-md-6 col-md-offset-2">

    @if (Session::has('error'))
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Error!</strong> {{Session::get('error')}}
    </div>
    @endif

    {{ Form::open(array('url' => '/admin/user/create-process', 'role' => 'form', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'signup-form')) }}
        <div class="form-group">
            <label for="group" class="col-lg-5 control-label">Groups</label>

            <div class="col-lg-7">
                {{ Form::select('group', $groups, null, array(
                'required' => true,
                'class' => 'form-control'
                )) }}
            </div>
        </div>

        <div class="form-group">
            <label for="firstname" class="col-lg-5 control-label">First name</label>
            <div class="col-lg-7">
                <input value="{{{Input::old('firstname')}}}" required="true" type="text" name="first_name" class="form-control" id="firstname" placeholder="First Name">
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-lg-5 control-label">Last name</label>
            <div class="col-lg-7">
                <input value="{{{Input::old('lastname')}}}" required="true" type="text" name="last_name" class="form-control" id="lastname" placeholder="Last Name">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail1" class="col-lg-5 control-label">Email</label>
            <div class="col-lg-7">
                <input value="{{{Input::old('email')}}}" required="true" type="email" name="email" class="form-control" id="inputEmail1" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword1" class="col-lg-5 control-label">Password</label>
            <div class="col-lg-7">
                <input maxlength="50" required="true" minlength="5" type="password" name="password" class="form-control" id="inputPassword1" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword1" class="col-lg-5 control-label">Repeat password</label>
            <div class="col-lg-7">
                <input equalTo="#inputPassword1" maxlength="50" required="true" minlength="5" type="password" class="form-control" id="inputPassword2" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-5 col-lg-7">
                <button type="submit" class="btn btn-default">Create</button>
            </div>
        </div>
    {{ Form::close() }}
    <script>
        $("#signup-form").validate();
    </script>
</div>

@stop