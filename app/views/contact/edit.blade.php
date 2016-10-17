@extends('layouts.master')

@section('title')
Edit Page
@stop

@section('content')

<h2>Edit Contact</h2>

{{ Form::open(array('action' => array('ContactController@editProcess', $id), 'role' => 'form', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'edit-form')) }}


<div class="form-group">
    <label for="description" class="col-lg-3 control-label">Text preview</label>
    <div class="col-lg-9">
        <textarea  type="text" name="text_preview" rows="5" class="form-control" id="short-content">{{$page->text_preview}}</textarea>
    </div>
</div>

<div class="form-group">
    <label for="email" class="col-lg-3 control-label">Email Address</label>
    <div class="col-lg-9">
        <input value="{{$page->email}}"  type="text" name="email" class="form-control">
    </div>
</div>


<div class="form-group">
    <label for="country" class="col-lg-3 control-label">Country</label>
    <div class="col-lg-9">
        <input value="{{$page->country}}"  type="text" name="country" class="form-control">
    </div>
</div>


<div class="form-group">
    <label for="city" class="col-lg-3 control-label">City</label>
    <div class="col-lg-9">
        <input value="{{$page->city}}"  type="text" name="city" class="form-control">
    </div>
</div>


<div class="form-group">
    <label for="address" class="col-lg-3 control-label">Address</label>
    <div class="col-lg-9">
        <input value="{{$page->address}}"  type="text" name="address" class="form-control">
    </div>
</div>

<div class="form-group">
    <label for="address" class="col-lg-3 control-label">Phone</label>
    <div class="col-lg-9">
        <input value="{{$page->phone}}"  type="text" name="phone" class="form-control">
    </div>
</div>

<div class="form-group">
    <label for="address" class="col-lg-3 control-label">Additional phone</label>
    <div class="col-lg-9">
        <input value="{{$page->add_phone}}"  type="text" name="add_phone" class="form-control">
    </div>
</div>


<h2>Manage Meta Data</h2>


<div class="form-group">
    <label for="title" class="col-lg-3 control-label">Keywords</label>
    <div class="col-lg-9">
        <input value="{{$info->keywords}}"  type="text" name="page[keywords]" class="form-control" id="title" placeholder="keywords">
    </div>
</div>
<div class="form-group">
    <label for="title" class="col-lg-3 control-label">Description</label>
    <div class="col-lg-9">
        <input value="{{$info->description}}"  type="text" name="page[description]" class="form-control" id="title" placeholder="description">
    </div>
</div>

<div class="form-group">
    <label class="col-lg-3 control-label">&nbsp;</label>
    <div class="col-lg-9">
        <button type="submit" class="btn btn-default">Update</button>
    </div>
</div>

@stop