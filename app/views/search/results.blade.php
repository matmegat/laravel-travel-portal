@extends('layouts.travel')

@section('title')
Search Results | Visits
@stop

@section('content')

<div class="page-background nointro searchpage">
	<div class="container">
		<h1>Search Results</h1>
	</div>
</div>

<div class="main-body">

	<div class="container home-tabs search-tabs">
		<div class="row">
			<a class="col-xs-4 tab active" href="#tours">Tours</a>
			<a class="col-xs-4 tab" href="#blogs">Blogs</a>
			<a class="col-xs-4 tab" href="#pages">Pages</a>
		</div>
	</div>

	<div class="container home-tab-content search-tab-content">
		<div class="row">
            <div class="col-xs-12">
                <form class="formplate row tour-filter" action="/search" method="GET">
                    <div class="col-md-9">
                        <input type="text" placeholder="Search Term" name="query" value="{{$query}}">
                    </div>
                    <div class="col-md-3">
                        <input type="submit" value="Search Again">
                    </div>
                </form>
            </div>

            <div class="col-xs-12 tab active" id="tours">

                <div class="row main-list">
                    @if(count($tours) > 0)
                        @foreach($tours as $product)
                            @include('tours.parts.product')
                            {{--<div class="col-md-12 item">
                                <div class="row">
                                    <div class="col-md-4 image">
                                        @if (!empty($tour['images'][0]['path']))
                                            <a href="/tours/view/{{$tour['productId']}}">
                                                <img src="{{ $tour['images'][0]['path'] }}" class="responsive" />
                                            </a>
                                        @else
                                            <div class="">NO TOUR IMAGE</div>
                                        @endif
                                    </div>

                                    <div class="col-md-6 details">

                                        <h3><a href="/tours/view/{{$tour['productId']}}">{{ $tour['name'] }} </a></h3>

                                        <ul class="icons hide-mobile">
                                            <li><a class="diving" href="#">Diving</a></li>
                                            <li><a class="family" href="#">Family</a></li>
                                            <li><a class="adventure" href="#">Adventure</a></li>
                                        </ul>

                                        <span class="length">Full Day</span>

                                        <div class="description">{{ $tour['productDetails'] }}</div>

                                        <a href="/tours/view/{{$tour['productId']}}" class="more hide-mobile">View more info</a>

                                    </div>

                                    <div class="hide-desktop clearfix actions">
                                        <div class="col-xs-6 col-sm-6">
                                            <ul class="icons">
                                                <li><a class="diving" href="#">Diving</a></li>
                                                <li><a class="family" href="#">Family</a></li>
                                                <li><a class="adventure" href="#">Adventure</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <strong class="rate"><span>Rates from</span>${{ $tour['priceMin'] }}<span> AUD </span></strong>
                                        </div>
                                    </div>

                                    <div class="hide-desktop col-md-2">
                                        <a href="/tours/view/{{$tour['productId']}}" class="more">View more info</a>
                                    </div>

                                    <div class="hide-mobile col-md-2 actions">
                                        <strong class="rate"><span>Rates from</span>${{ $tour['priceMin'] }}<span> AUD </span></strong>
                                    </div>
                                </div>
                            </div>--}}
                        @endforeach
                        {{ $tours->appends(Input::except('page'))->links() }}
                    @else
                        <div class="row main-list">
                            <div class="searching">No Results Found!</div>
                        </div>
                    @endif
                </div>

            </div>
            <div class="col-xs-12 tab" id="blogs">

                <div class="row main-list">
                    @if(count($news) > 0)
                        @foreach($news as $blog)
                            <div class="col-md-12 item">
                                <div class="row">

                                    <div class="col-md-4 image">
                                        @if (!empty($blog->primary_photo['url']))
                                            <a href="{{ action('NewsController@show', array(date('Y', strtotime($blog->created_at)), $blog->slug)) }}"><img src="{{{ $blog->primary_photo['url'] }}}" class="responsive"></a>
                                        @endif
                                    </div>

                                    <div class="col-md-6 details">
                                        <span class="type">{{strftime('%b %e, %Y',strtotime($blog->created_at))}}</span>

                                        <h3><a href="{{ action('NewsController@show', array(date('Y', strtotime($blog->created_at)), $blog->slug)) }}">{{{ $blog->title }}}</a></h3>

                                        <p>{{$blog->short_content}}</p>

                                        <a href="{{ action('NewsController@show', array(date('Y', strtotime($blog->created_at)), $blog->slug)) }}" class="more hide-mobile">Read More</a>

                                    </div>

                                    <div class="hide-desktop col-md-2">
                                        <a href="{{ action('NewsController@show', array(date('Y', strtotime($blog->created_at)), $blog->slug)) }}" class="more">Read More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="searching">No Results Found!</div>
                    @endif
                </div>

            </div>
            <div class="col-xs-12 tab" id="pages">

                <div class="row main-list">
                    @if(count($pages) > 0)
                        @foreach($pages as $page)
                            <div class="col-md-12 item">
                                <div class="row">
                                    <a href="/page/redirect/{{$page->page_id}}"><h2>{{$page->title}}</h2></a>
                                    <p>
                                        {{$page->sub_title}}
                                    </p>
                                    <div class="col-md-6 details">
                                        <a href="/page/redirect/{{$page->page_id}}" class="more hide-mobile">View Page</a>
                                    </div>

                                    <div class="hide-desktop col-md-2">
                                        <a href="/page/redirect/{{$page->page_id}}" class="more">View Page</a>
                                    </div>
                                </div>
                            </div>
                            {{--<a href="/page/redirect/{{$page->page_id}}"><h2>{{$page->title}}</h2></a>
                            <div class="description">
                                {{$page->sub_title}}
                            </div>
                            <div class="footer buttons view_more_info_narrow">
                                <a href="/page/redirect/{{$page->page_id}}">
                                    <button class="btn btn-default btn-lg" type="button">View Page</button>
                                </a>
                            </div>--}}
                        @endforeach
                    @else
                        <div class="searching">No Results Found!</div>
                    @endif
                </div>

            </div>
		</div>
	</div>
</div>

{{--<div class="search_results">
    <div class="header">
        <div class="container">

            <div class="text">
                <h2>Search Results</h2>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row start_page">
            <div id="startpage_search_tabs">
                <!-- Nav tabs -->

                <ul class="tabs">
                    <li>
                        <a href="#tours_search">TOURS</a>
                    </li>
                    <li>
                        <a href="#blogs_search">BLOGS</a>
                    </li>
                    <li>
                        <a href="#pages_search">PAGES</a>
                    </li>
                </ul>

                <div class="clear"></div>

                <div class="quick_tours" aria-labelledby="ui-id-1" role="tabpanel" aria-expanded="true" aria-hidden="false" style="background-color: #f8c22f;">
                    <div id="tours" class="search_tours">
                        <form role="form" accept-charset="UTF-8" action="/search" method="GET">
                            <div class="text form-group col-md-2 col-sm-4">
                                <label class="" for="cat"><strong>SEARCHING:</strong></label>
                            </div>
                            <div class="form-group col-md-8 col-sm-4">
                                <input type="text" name="query" placeholder="keywords" class="form-control" value="{{$query}}">
                            </div>

                            <div class="form-group col-md-2 col-sm-4">
                                <button class="btn btn-primary btn-md button btn-block" type="submit">SEARCH</button>
                            </div>
                        </form>
                        <div class="clear"></div>
                    </div>
                </div>

                <!-- Tab panes -->
                <div style="margin-top: 50px" id="tours_search">
                    <div class="tab-pane active section_results" id="home">
                		<div class="results">
                			@if(count($tours) > 0)
	                            @foreach($tours as $tour)
	                            <div class="result">
	                                <div class="img">
	                                    @if(!empty($tour['images'][0]))
	                                    <a href="/tours/view/{{$tour['productId']}}">
	                                        <img class="" src="{{$tour['images'][0]['path']}}" alt=""/>
	                                    </a>
	                                    @endif
	                                </div>
	                                <div class="info">
	                                    <a href="/tours/view/{{$tour['productId']}}">
	                                        <h2>{{$tour['name']}}</h2>
	                                    </a>
	                                    <div class="description">
	                                        {{$tour['productDetails']}}
	                                    </div>
	                                    <div class="footer buttons view_more_info_narrow">
	                                        <a href="/tours/view/{{$tour['productId']}}">
	                                            <button class="btn btn-default btn-lg" type="button">View More Info</button>
	                                        </a>

	                                    </div>
	                                </div>
	                            </div>
	                            @endforeach

	                        {{ $tours->appends(Input::except('page'))->links() }}

	                        @else
	                        <div class="alert-warning search-alert">Tours not found</div>
	                        @endif
                		</div>

                    </div>
                </div>

                <div style="margin-top: 50px" id="blogs_search">
                    <div class="tab-pane active section_results" id="home">
                    	<div class="results">
                    		@if(count($news) > 0)
	                            @foreach($news as $blog)
                                    <div class="result">
                                        <div class="img">
                                            @include('news.parts.photos', array('news' => $blog))
                                        </div>
                                        <div class="info">
                                            <a href="/news/details/{{ $blog->id }}"><h2>{{ $blog->title }}</h2></a>
                                            <div class="description">
                                                {{ $blog->short_content }}
                                            </div>
                                            <div class="footer buttons view_more_info_narrow">
                                                <a href="/news/details/{{ $blog->id }}">
                                                    <button class="btn btn-default btn-lg" type="button">View Blog</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
	                            @endforeach
	                        @else
	                            <div class="alert-warning search-alert">Blog items not found</div>
	                        @endif
                    	</div>
                    </div>
                </div>

                <div style="margin-top: 50px" id="pages_search">
                    <div class="tab-pane active section_results" id="home">
                        @if(count($pages) > 0)
                            @foreach($pages as $page)
                                <div class="result page">
                                    <div class="info">
                                        <a href="/page/redirect/{{$page->page_id}}"><h2>{{$page->title}}</h2></a>
                                        <div class="description">
                                            {{$page->sub_title}}
                                        </div>
                                        <div class="footer buttons view_more_info_narrow">
                                            <a href="/page/redirect/{{$page->page_id}}">
                                                <button class="btn btn-default btn-lg" type="button">View Page</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert-warning search-alert">Pages not found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>--}}

@stop