@extends('layouts.master')

@section('title')

Manage pages

@stop

@section('content')


<ul class="nav nav-tabs">
    <li class="active"><a href="#home" data-toggle="tab">Pages</a></li>
    <li><a href="#social" data-toggle="tab">Social Icon Urls</a></li>
    <li><a href="#bookingInfo" data-toggle="tab">Footer Booking Info</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="home">
        <table class="table table-striped">
            <tr>
                <th>id</th>
                <th>Page Name</th>
                <th>Action</th>
            </tr>

            @foreach($list as $item)

            <tr>
                <td>{{$item->id}}</td>
                <td>
                    <a title="Edit" href="{{ action('PageAdminController@edit', array('id' => $item->id)) }}">
                        {{$item->name}}
                    </a>
                </td>
                <td>
                    <a title="Edit" href="{{ action('PageAdminController@edit', array('id' => $item->id)) }}">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a onclick="return confirm('Are you sure want to delete information about this?')" title="Delete" href="{{ action('PageAdminController@delete', array('id' => $item->id)) }}">
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>
                </td>
            </tr>

            @endforeach

        </table>
    </div>
    <div class="tab-pane" id="social">
        {{ Form::open(array('action' => array('PageAdminController@saveSocial'), 'role' => 'form', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'edit-form')) }}

        <div class="form-group">
            <label for="title" class="col-lg-2 control-label">Facebook</label>
            <div class="col-lg-10">
                <input value="{{$social->facebook}}"  type="text" name="soc[facebook]" class="form-control" id="title" placeholder="http://facebook.com/me">
            </div>
        </div>
        <div class="form-group">
            <label for="title" class="col-lg-2 control-label">Twitter</label>
            <div class="col-lg-10">
                <input value="{{$social->twitter}}"  type="text" name="soc[twitter]" class="form-control" id="title" placeholder="http://twitter.com/me">
            </div>
        </div>
        <div class="form-group">
            <label for="title" class="col-lg-2 control-label">Google+</label>
            <div class="col-lg-10">
                <input value="{{$social->googleplus}}"  type="text" name="soc[googleplus]" class="form-control" id="title" placeholder="https://plus.google.com/23456789/posts">
            </div>
        </div>
        <div class="form-group">
            <label for="title" class="col-lg-2 control-label">YouTube</label>
            <div class="col-lg-10">
                <input value="{{$social->youtube}}"  type="text" name="soc[youtube]" class="form-control" id="title" placeholder="http://youtube.com/mychannel">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label">&nbsp;</label>
            <div class="col-lg-10">
                <button type="submit" class="btn btn-default">Update</button>
            </div>
        </div>

        {{Form::close()}}
    </div>
    <div class="tab-pane" id="bookingInfo">
        {{ Form::open(array('action' => array('PageAdminController@saveBookingInfo'), 'role' => 'form', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'edit-form')) }}

        <div class="form-group">
            <label for="visitsname" class="col-lg-2 control-label">Name/Title</label>
            <div class="col-lg-10">
                <input value="{{$bookingInfo->visitsname}}"  type="text" name="bin[visitsname]" class="form-control" id="visitsname" placeholder="eg. the visits name or title">
            </div>
        </div>

        <div class="form-group">
            <label for="phone" class="col-lg-2 control-label">Phone</label>
            <div class="col-lg-10">
                <input value="{{$bookingInfo->phone}}"  type="text" name="bin[phone]" class="form-control" id="phone" placeholder="eg. the phone">
            </div>
        </div>

        <div class="form-group">
            <label for="add_phone" class="col-lg-2 control-label">Additional Phone</label>
            <div class="col-lg-10">
                <input value="{{$bookingInfo->add_phone}}"  type="text" name="bin[add_phone]" class="form-control" id="add_phone" placeholder="eg. the add_phone">
            </div>
        </div>

        <div class="form-group">
            <label for="address" class="col-lg-2 control-label">Address Line One</label>
            <div class="col-lg-10">
                <input value="{{$bookingInfo->address}}"  type="text" name="bin[address]" class="form-control" id="address" placeholder="eg. the address">
            </div>
        </div>

        <div class="form-group">
            <label for="city" class="col-lg-2 control-label">Address Line Two</label>
            <div class="col-lg-10">
                <input value="{{$bookingInfo->city}}"  type="text" name="bin[city]" class="form-control" id="city" placeholder="eg. the city">
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="col-lg-2 control-label">Contact Email</label>
            <div class="col-lg-10">
                <input value="{{$bookingInfo->email}}"  type="text" name="bin[email]" class="form-control" id="email" placeholder="eg. the email">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label">&nbsp;</label>
            <div class="col-lg-10">
                <button type="submit" class="btn btn-default">Update</button>
            </div>
        </div>

        {{Form::close()}}
    </div>
</div>
@stop