@extends('layouts.travel')

@section('title')
Flights | Visits
@stop

@section('scripts')

{{--{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/select2.js') }}--}}

{{--{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/mustache.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/underscore.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/moment.js') }}
--}}

{{ HTML::script(Config::get('cdn.asset_path') . 'js/app/form/flights.js') }}

@stop

@section('content')

<div class="page-background" style="background-image: url(/img/header-bg/flights.jpg)">
	<div class="container">
		<h1>{{ $info->title; }}</h1>
		<p>{{ $info->content; }}</p>
	</div>
</div>

<div class="main-body">

	<div class="container home-tab-content page-tab-content">
		<div class="row">
			<div class="col-xs-12 flight-filter tab active">

			    @include('forms.flights.search_menu')

			</div>
		</div>
        <div class="row">
            <div class="col-md-4 aside-filter">
                @include('flights.sidebar')
            </div>

            <div class="col-md-8" id="result-box">
                @include('flights.update-results')
            </div>

        </div>
	</div>

</div>

        {{--<div class="flights">
            <div
                class="index flights"
                @if ($pageInfo['backgroundUrl'])
                    style="background: url('{{$pageInfo['backgroundUrl']}}') no-repeat; background-size: 100%;"
                @endif
            >
            <div class="container">
                <header>
                    <h2>{{ $info->title; }}</h2>
                    <div>{{ $info->content; }}</div>
                </header>
            </div>
        </div>
            <div class="content_results">
                <div class="container">
                    <div class="section_results">
                        @include('forms.flights.search_menu')
                        @include('flights.sidebar')
                        <div class ="flights_results">
                            <div class="progress progress-striped active" id="flights-progress">
                                <div class="progress-bar"  role="progressbar" id="flights-progress-bar">
                                    <span class="sr-only">Search in progress</span>
                                </div>
                            </div>
                            <script>
                                window.FLIGHTS_SEARCH_TIME_LEFT = 0;
                            </script>
                            <div id="result-box">
                                @include('flights.update-results')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@include('flights.parts.fare-details')--}}

@stop