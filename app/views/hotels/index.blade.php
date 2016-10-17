@extends('layouts.travel')

@section('title')
Hotels | Visits
@stop

@section('content')

<div class="page-background" style="background-image: url(img/header-bg/hotels.jpg)">
	<div class="container">
		<h1>{{ $info->title }}</h1>
		<p>{{ $info->content }}</p>
	</div>
</div>

<div class="main-body">

	<div class="container home-tab-content page-tab-content">
		<div class="row">
			<div class="col-xs-12 tab active">
                @include('forms.hotels.search_menu')

                <div class="row main-list">
                    @if (isset($params))
                        @include('hotels.update-results')
                    @else
                        <div class="searching">
                            No hotels found...
                        </div>
                    @endif
                </div>

			</div>
	    </div>
	</div>
</div>

@stop