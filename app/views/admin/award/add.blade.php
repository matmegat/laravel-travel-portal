@extends('layouts.master')

@section('content')



<h2>Add News</h2>

{{ Form::open(array('action' => array('AwardAdminController@addProcess'), 'files' => true, 'role' => 'form', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'edit-form')) }}


<div class="form-group">
    <label class="col-lg-2 control-label">Image</label>
    <div class="col-lg-10">
        <input type="file" name="main_image" class="form" id="image" value=""/>
    </div>
</div>

<div class="form-group">
    <label for="title" class="col-lg-2 control-label">Title</label>
    <div class="col-lg-10">
        <input value="" required="true" type="text" name="award[title]" class="form-control" id="title" placeholder="Title">
    </div>
</div>

<div class="form-group">
    <label for="status" class="col-lg-2 control-label">Status</label>
    <div class="col-lg-10">
        {{ Form::select('award[is_draft]', array('1' => 'Draft', '0' => 'Public'), 1, array('class' => 'form-contol')) }}
    </div>
</div>

<div class="form-group">
    <label for="short-content" class="col-lg-2 control-label">Short Description</label>
    <div class="col-lg-10">
        <textarea type="text" name="award[short_content]" class="form-control" id="short-content" placeholder="Short description"></textarea>
    </div>
</div>

<div class="form-group">
    <label for="content" class="col-lg-2 control-label">award Content</label>
    <div class="col-lg-10">
        <textarea rows="20" type="text" name="award[content]" class="form-control" id="content" placeholder="award Content"></textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label">&nbsp;</label>
    <div class="col-lg-10">
        <button type="submit" class="btn btn-default">Create</button>
    </div>
</div>

{{ Form::close() }}
@stop