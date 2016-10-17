@extends('layouts.master')

@section('content')

@if( isset($news_show_all) && $news_show_all )
<input type="checkbox" id="show_deleted" onclick="document.location.href='{{action('NewsController@manage')}}';"/>
<label for="show_deleted">Hide deleted news</label>
@else
<input type="checkbox" id="show_deleted" onclick="document.location.href='{{action('NewsController@manageAll')}}';"/>
<label for="show_deleted">Show deleted news</label>
@endif

<a href="{{ action('NewsController@add') }}"><i class="fa fa-dashboard fa-fw"></i> Add Article</a>

@foreach($news as $item)

<div @if( $item->is_draft ) title="This Item Is Hidden" @endif class="panel @if( !$item->trashed() ) @if( !$item->is_draft ) panel-info @else panel-default @endif @else panel-warning @endif">
    <div class="panel-heading">

        {{ link_to_action('NewsController@show', $item->title, array(date('Y', strtotime($item->created_at)), $item->slug)) }}

        <div class="pull-right">
            @if($item->is_draft)
                <i class="glyphicon glyphicon-eye-close" title="This item is hidden"></i>
            @else
            <i class="glyphicon glyphicon-globe" title="This item is public"></i>
            @endif
            &nbsp;&nbsp;
            <a href="{{ action('NewsController@edit', array('id' => $item->id)) }}">
                <i class="glyphicon glyphicon-pencil" title="Edit"></i>
            </a>

            @if( !$item->trashed() )
            <a href="{{ action('NewsController@delete', array('id' => $item->id)) }}" onclick="return confirm('Are you sure want to delete this item?');">
                <i class="glyphicon glyphicon-remove" title="Remove"></i>
            </a>
            @else
            <a href="{{ action('NewsController@restore', array('id' => $item->id)) }}">
                Restore
            </a>
            @endif
        </div>
    </div>
    <div class="panel-body">

        <blockquote>
            {{$item->short_content}}
        </blockquote>

        <div>
            @foreach($item->tags as $tag)
            <span class="label label-info">{{ $tag['text'] }}</span>
            @endforeach
        </div>

        <div>{{strftime('%e %b %Y',strtotime($item->created_at))}}, by
            @if (isset($item->user->first_name))
                {{$item->user->first_name}} {{$item->user->last_name}}</div>
            @else
                User doesn't exist anymore
            @endif
    </div>
</div>

@endforeach

{{ $news->links('admin.pagination') }}

@stop