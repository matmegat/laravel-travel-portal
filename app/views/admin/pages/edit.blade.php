@extends('layouts.master')

@section('title')
Edit Page
@stop

@section('scripts')

@stop

@section('content')

<div>{{ HTML::linkAction('PageAdminController@manage', '<< Manage Pages') }}</div>

<h2>Edit Page</h2>

{{Form::open(array(
    'action' => array('PageAdminController@editProcess', $id),
    'role' => 'form',
    'method' => 'POST',
    'class' => 'form-horizontal',
    'id' => 'edit-form',
    'enctype' => 'multipart/form-data'
))}}

@if(isset($page))
    <div class="form-group">
        <label for="title" class="col-lg-2 control-label">Title</label>
        <div class="col-lg-10">
            <input value="{{$page->title}}"  type="text" name="page[title]" class="form-control" id="title" placeholder="Title">
        </div>
    </div>

    <div class="form-group">
        <label for="short-content" class="col-lg-2 control-label">Content</label>
        <div class="col-lg-6">
            <textarea name="page[short_content]" rows="6" class="form-control" id="short-content" placeholder="Short description">{{$page->content}}</textarea>
        </div>
    </div>

    @if ($toursEdit)
        @foreach ($tours as $account => $items)
            <div class="form-group">
                <label for="tags" class="col-lg-2 control-label">Tours {{ $account }}</label>
                <div class="col-lg-10">
                    <select name="toursAssigned[{{ $account }}][]" multiple class="form-control">
                        @foreach($items as $productCode => $name)
                            <option {{ in_array($productCode, $selectedTours[$account]) ? 'selected="selected"' : '' }} value="{{ $productCode }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endforeach
    @endif

    <div class="form-group">
        <label for="short-content" class="col-lg-2 control-label">Background image</label>
        <div class="col-lg-3">
            <input name="page[background]" type="file" class="form-control">
        </div>
        <div class="col-lg-7">
            @if ($pageInfo['backgroundUrl'])
                <img src="{{$pageInfo['backgroundUrl']}}">
                <a href="{{action('PageAdminController@removeBackground', array('id' => $id))}}">remove image</a>
            @endif
        </div>
    </div>

    <h2>Manage Meta Data</h2>

    <div class="form-group">
        <label for="title" class="col-lg-2 control-label">Keywords</label>
        <div class="col-lg-10">
            <input value="{{$page->keywords}}"  type="text" name="page[keywords]" class="form-control" id="title" placeholder="keywords">
        </div>
    </div>
    <div class="form-group">
        <label for="title" class="col-lg-2 control-label">Description</label>
        <div class="col-lg-10">
            <input value="{{$page->description}}"  type="text" name="page[description]" class="form-control" id="title" placeholder="description">
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">&nbsp;</label>
        <div class="col-lg-10">
            <button type="submit" class="btn btn-default">Update</button>
        </div>
    </div>

@else

    <div class="form-group">
        <label for="title" class="col-lg-2 control-label">Title</label>
        <div class="col-lg-10">
            <input value=""  type="text" name="page[title]" class="form-control" id="title" placeholder="Title">
        </div>
    </div>

    <div class="form-group">
        <label for="title" class="col-lg-2 control-label">Sub Title</label>
        <div class="col-lg-10">
            <input value=""  type="text" name="page[sub_title]" class="form-control" id="title" placeholder="Sub Title">
        </div>
    </div>

    <div class="form-group">
        <label for="short-content" class="col-lg-2 control-label">Content</label>
        <div class="col-lg-10">
            <textarea  type="text" name="page[short_content]" class="form-control" id="short-content" placeholder="Short description">

            </textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="tags" class="col-lg-2 control-label">tours IDs</label>
        <div class="col-lg-10">
            <select name="toursAssigned[]" multiple class="form-control">
                @foreach($tours as $item)
                    <option {{ isset($item['selected']) ? 'selected="selected"' : '' }} value="{{$item['ID']}}">{{$item['Title']}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <h2>Manage Meta Data</h2>

    <div class="form-group">
        <label for="title" class="col-lg-2 control-label">Keywords</label>
        <div class="col-lg-10">
            <input value=""  type="text" name="page[keywords]" class="form-control" id="title" placeholder="keywords">
        </div>
    </div>
    <div class="form-group">
        <label for="title" class="col-lg-2 control-label">Description</label>
        <div class="col-lg-10">
            <input value=""  type="text" name="page[description]" class="form-control" id="title" placeholder="description">
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">&nbsp;</label>
        <div class="col-lg-10">
            <button type="submit" class="btn btn-default">Update</button>
        </div>
    </div>

@endif

{{ Form::close() }}

@stop