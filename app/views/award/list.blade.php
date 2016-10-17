@extends('layouts.travel')

@section('title')
Awards | Visits
@stop

@section('content')

<div class="page-background nointro" style="background-image: url({{ $header['background'] }})">
	<div class="container">
		<h1>{{ $header['title'] }}</h1>
	</div>
</div>

<div class="main-body blog-listing">

	<div class="container drop-shadow blog-list">
		<div class="row main-list">
		    @foreach($award as $item)
                <div class="col-md-12 item">
                    <div class="row">

                        <div class="col-md-4 image">
                            @if (!empty($item ->primary_photo['url']))
                                <a href="{{ action('AwardController@show', array(date('Y', strtotime($item->created_at)), $item->slug)) }}"><img src="{{{ $item ->primary_photo['url'] }}}" class="responsive"></a>
                            @endif
                        </div>

                        <div class="col-md-6 details">
                            <span class="type">{{ strftime('%b %e, %Y', strtotime($item->created_at)) }}</span>

                            <h3><a href="{{ action('AwardController@show', array(date('Y', strtotime($item->created_at)), $item->slug)) }}">{{{ $item->title }}}</a></h3>

                            <p>{{$item->short_content}}</p>

                            <a href="{{ action('AwardController@show', array(date('Y', strtotime($item->created_at)), $item->slug)) }}" class="more hide-mobile">Read More</a>

                        </div>

                        <div class="hide-desktop col-md-2">
                            <a href="{{ action('AwardController@show', array(date('Y', strtotime($item->created_at)), $item->slug)) }}" class="more">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $award->appends(Input::except('page'))->links() }}
		</div>
	</div>
</div>

@stop

