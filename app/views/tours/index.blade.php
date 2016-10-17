@extends('layouts.travel')

@section('title')
Tours | Visits
@stop

@section('content')

    <div class="page-background" style="background-image: url(/img/header-bg/australia.jpg)">
    	<div class="container">
            <h1>{{ $info->title }}</h1>
            <p>{{ $info->content }}</p>
    	</div>
    </div>

    <div class="main-body">

    	<div class="container home-tab-content page-tab-content">
    		<div class="row">
    			<div class="col-xs-12 tab active">

    			    @include('forms.home.search_tours')

                    <div class="row main-list">
                        @if(isset($featureProducts) && count($featureProducts) > 0)
                            @foreach($featureProducts as $product)
                                @include('tours.parts.product')
                            @endforeach
                        @endif

                        @if($paginator->count() > 0)
                            @foreach($paginator as $product)
                                @include('tours.parts.product')
                            @endforeach

                            {{ $paginator->appends(Input::except('page'))->links() }}
                        @else
                            <div class="list-empty">
                                No events found
                            </div>
                        @endif
                    </div>

    			</div>
    		</div>
    	</div>

    </div>
@stop
