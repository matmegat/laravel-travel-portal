@extends('layouts.master')
    @section('content')
        <h2>Edit News</h2>
        {{ Form::open(array('action' => array('NewsController@editProcess', $item->id), 'files' => true, 'role' => 'form', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'edit-form')) }}
            <div class="form-group">
                <label for="title" class="col-lg-2 control-label">Images</label>
                <div class="col-lg-10">
                    @foreach ($item->getPhotos() as $photo)
                        <div class="col-lg-12">
                            <div class="col-lg-2">
                                <img src="{{{ $photo['url'] }}}" class="img-thumbnail img-responsive">
                            </div>
                            <div class="col-lg-9">
                                <input value="{{{ $photo['caption'] }}}" type="text" name="photos_captions[{{ $photo['id'] }}]" class="form-control" placeholder="Image caption">
                            </div>
                            <br><br>
                            <div class="col-lg-9">
                                <input type="checkbox" name="remove_photos[{{ $photo['id'] }}]" value="1" /> Remove image
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="title" class="col-lg-2 control-label"></label>
                <div class="col-lg-10">
                    <input type="file" name="photo" />
                </div>
            </div>

            <div class="form-group">
                <label for="title" class="col-lg-2 control-label">Title</label>
                <div class="col-lg-10">
                    <input value="{{{$item->title}}}" required="true" type="text" name="news[title]" class="form-control" id="title" placeholder="Title">
                </div>
            </div>

            <div class="form-group">
                <label for="title" class="col-lg-2 control-label">Slug</label>
                <div class="col-lg-10">
                    <input value="{{{$item->slug}}}" required="true" type="text" name="news[slug]" class="form-control" id="title" placeholder="Slug">
                </div>
            </div>

            <div class="form-group">
                <label for="status" class="col-lg-2 control-label">Status</label>
                <div class="col-lg-10">
                    {{ Form::select('news[is_draft]', array('1' => 'Draft', '0' => 'Public'), $item->is_draft, array('class' => 'form-contol')) }}
                </div>
            </div>

            <div class="form-group">
                <label for="short-content" class="col-lg-2 control-label">Short Description</label>
                <div class="col-lg-10">
                    <textarea required="true" type="text" name="news[short_content]" class="form-control" id="short-content" placeholder="Short description">{{{$item->short_content}}}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="content" class="col-lg-2 control-label">News Content</label>
                <div class="col-lg-10">
                    <textarea rows="20" required="true" type="text" name="news[content]" class="form-control" id="content" placeholder="News Content">{{{$item->content}}}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="tags" class="col-lg-2 control-label">Tags</label>
                <div class="col-lg-10">
                    <input type="text" name="tags" id="tags" value="{{{ implode(',', $item->getTagsTexts()) }}}"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-10">
                    <button type="submit" class="btn btn-default">Update</button>
                </div>
            </div>
        {{ Form::close() }}
    @stop