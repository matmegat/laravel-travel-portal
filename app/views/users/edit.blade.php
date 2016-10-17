@extends('layouts.master')

@section('content')

@if (Session::has('error'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Error!</strong> {{Session::get('error')}}
</div>
@endif

@if (Session::has('message'))
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Information</strong> {{Session::get('message')}}
</div>
@endif

<ul class="nav nav-tabs">
    <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
    <li><a href="#password-tab" data-toggle="tab">Update Password</a></li>
</ul>

<div class="tab-content">

    <div class="tab-pane active" id="profile">

        <div class="row">

            <div class="col-md-6">

                {{ Form::open(array('url' => action('UserController@saveProfile', array('id' => $user->id)), 'role' => 'form', 'method' => 'POST', 'class'
                => 'form-horizontal', 'id' => 'profile-form')) }}

                <div class="form-group">
                    <label for="group" class="col-lg-4 control-label">Groups</label>

                    <div class="col-lg-8">
                        {{ Form::select('group', $groups, $userGroup, array(
                            'required' => true,
                            'class' => 'form-control'
                        )) }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="firstname" class="col-lg-4 control-label">First name</label>

                    <div class="col-lg-8">
                        <input value="{{{$user->first_name}}}" required="true" type="text" name="first_name"
                               class="form-control" id="firstname" placeholder="First Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-lg-4 control-label">Last name</label>

                    <div class="col-lg-8">
                        <input value="{{{$user->last_name}}}" required="true" type="text" name="last_name"
                               class="form-control" id="lastname" placeholder="Last Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-4 control-label">Email</label>

                    <div class="col-lg-8">
                        <input value="{{{$user->email}}}" required="true" type="email" name="email" class="form-control"
                               id="inputEmail1" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-8">
                        <button type="submit" class="btn btn-default">Update</button>
                    </div>
                </div>

                {{ Form::close() }}

                <script>
                    $("#profile-form").validate();
                </script>

            </div>

        </div>

    </div>

    <div class="tab-pane" id="password-tab">

        <div class="row">

            <div class="col-md-6">

                {{ Form::open(array('url' => action('UserController@updatePassword', array('id' => $user->id)), 'role' => 'form', 'method' => 'POST',
                'class' => 'form-horizontal', 'id' => 'password-form')) }}

                <div class="form-group">
                    <label for="inputPassword1" class="col-lg-4 control-label">New Password</label>

                    <div class="col-lg-8">
                        <input maxlength="50" required="true" minlength="5" type="password" name="password"
                               class="form-control" id="inputPassword1" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword1" class="col-lg-4 control-label">Repeat new password</label>

                    <div class="col-lg-8">
                        <input equalTo="#inputPassword1" maxlength="50" required="true" minlength="5" type="password"
                               class="form-control" id="inputPassword2" placeholder="Password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-8">
                        <button type="submit" class="btn btn-default">Update</button>
                    </div>
                </div>

                {{ Form::close() }}

                <script>
                    $("#password-form").validate();
                </script>

            </div>

        </div>

    </div>

    <div class="tab-pane" id="settings">
        <p>
            No settings here yet
        </p>
    </div>

</div>

@stop