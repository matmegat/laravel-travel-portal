@extends('layouts.master')

@section('content')

<ul class="nav nav-tabs">
    <li class="active"><a href="#manage" data-toggle="tab">Manage</a></li>
    <li><a href="#settings" data-toggle="tab">Settings</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="manage">

        @if( isset($news_show_all) && $news_show_all )
        <input type="checkbox" id="show_deleted" onclick="document.location.href='{{action('AwardAdminController@manage')}}';"/>
        <label for="show_deleted">Hide deleted awards</label>
        @else
        <input type="checkbox" id="show_deleted" onclick="document.location.href='{{action('AwardAdminController@manageAll')}}';"/>
        <label for="show_deleted">Show deleted awards</label>
        @endif

        <a href="{{ action('AwardAdminController@add') }}"><i class="fa fa-dashboard fa-fw"></i> Add Award</a>

        @foreach($award as $item)

        <div @if( $item->is_draft ) title="This Item Is Hidden" @endif class="panel @if( !$item->trashed() ) @if( !$item->is_draft ) panel-info @else panel-default @endif @else panel-warning @endif">
            <div class="panel-heading">

                {{ link_to_action('AwardController@show', $item->title, array(date('Y', strtotime($item->created_at)), $item->slug)) }}

                <div class="pull-right">
                    @if($item->is_draft)
                        <i class="glyphicon glyphicon-eye-close" title="This item is hidden"></i>
                    @else
                    <i class="glyphicon glyphicon-globe" title="This item is public"></i>
                    @endif
                    &nbsp;&nbsp;
                    <a href="{{ action('AwardAdminController@edit', array('id' => $item->id)) }}">
                        <i class="glyphicon glyphicon-pencil" title="Edit"></i>
                    </a>

                    @if( !$item->trashed() )
                    <a href="{{ action('AwardAdminController@delete', array('id' => $item->id)) }}" onclick="return confirm('Are you sure want to delete this item?');">
                        <i class="glyphicon glyphicon-remove" title="Remove"></i>
                    </a>
                    @else
                    <a href="{{ action('AwardAdminController@restore', array('id' => $item->id)) }}">
                        Restore
                    </a>
                    @endif
                </div>
            </div>
            <div class="panel-body">

                <blockquote>
                    {{$item->short_content}}
                </blockquote>

                <div>{{strftime('%e %b %Y',strtotime($item->created_at))}}, by
                    @if (isset($item->user->first_name))
                        {{$item->user->first_name}} {{$item->user->last_name}}</div>
                    @else
                        User doesn't exist anymore
                    @endif
            </div>
        </div>

        @endforeach

        {{ $award->links('admin.pagination') }}

    </div>
    <div class="tab-pane" id="settings">
        <div style="margin-top:10px;">
            {{ Form::open(array('action' => array('AwardAdminController@postSaveSettings'), 'files' => true, 'class' => 'form-horizontal')) }}

            <div class="form-group">
                <label for="title" class="col-lg-2 control-label">Page Header</label>
                <div class="col-lg-10">
                    {{ Form::text('dbsettings[page.award_header]', DBconfig::get('page.award_header', 'Awards'), array('class' => 'form-control')) }}
                </div>
            </div>
            <div class="form-group">
                <label for="title" class="col-lg-2 control-label">Header background</label>
                <div class="row">
                    <div class="col-lg-3">
                        {{ Form::file('award_background') }}
                        @if (file_exists($upload_dir.'header.png'))
                            <label>{{ Form::checkbox('award_background_delete', 1) }} delete the header image</label>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        @if (file_exists($upload_dir.'header.png'))
                            <img src="{{ $upload_uri.'header.png' }}" style="max-width:700px;">
                        @else
                            <img src="{{ $upload_uri.'default-header.jpg' }}" style="max-width:700px;">
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-10">
                    <button type="submit" class="btn btn-default">Update</button>
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>
</div>

@stop