<div class="row">
    <div class="page-header">
        <h3>{{$tour['name']}} <br/>
            <small>{{$tour['productTeaser']}}</small>
        </h3>
    </div>
    
    <img class="img-thumbnail" style="max-height: 300px;" src="{{$tour['productImagePath']}}"
         data-thumb="{{$tour['productImagePath']}}"/>

    <div class="panel panel-primary">
        <div class="panel-heading">Prices</div>
        <div class="panel-body">

            <table class="table table-stripped">
                <tbody>
                <thead>
                <th>Fare Name</th>
                <th>Price</th>
                <th>Currency</th>
                <th>Book Now</th>
                </thead>
                @foreach($tour['faresprices'] as $value)
                <tr>
                    <td>{{$value['fareName']}}</td>
                    <td>{{$value['rrp']}}</td>
                    <td>{{$value['currencyCode']}}</td>
                    <td><a href="{{ action('ToursController@book', array('id' => $tour['productId'], 'priceId' => $value['productPricesDetailsId'])) }}"><input type="submit" class="btn-default btn btn-success" value="BOOK NOW" /></a></td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="infoTab">
        <li><a href="#details" data-toggle="tab">Details</a></li>
        @if($tour['itinerary'] != null)
        <li><a href="#itinerary" data-toggle="tab">Itinerary</a></li>
        @endif
        @if($tour['pickups'] != null)
        <li><a href="#pickups" data-toggle="tab">Pickups</a></li>
        @endif
        <li><a href="#instructions" data-toggle="tab">Instructions</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active" id="details">{{$tour['productDetails']}}</div>
        @if($tour['itinerary'] != null)
        <div class="tab-pane fade" id="itinerary">{{$tour['itinerary']}}</div>
        @endif
        @if($tour['pickups'] != null)
        <div class="tab-pane fade" id="pickups">{{$tour['pickups']}}</div>
        @endif
        <div class="tab-pane fade" id="instructions">{{$tour['instructions']}}</div>
    </div>

    @if($tour['faresprices'][0]['travelStart'] != null)
    <div class="panel panel-success" style="width: 500px;">
        <div class="panel-heading">Travel Period</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">Travel Start</div>
                <div class="col-md-9" style="font-weight: bold;">{{$tour['faresprices'][0]['travelStart']}}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Travel End</div>
                <div class="col-md-9" style="font-weight: bold;">{{$tour['faresprices'][0]['travelEnd']}}</div>
            </div>
        </div>
    </div>
    @endif
</div>





















<div class="row">
    <div class="page-header">
        <h3>{{$tour['name']}} <br/>
            <small>{{$tour['productTeaser']}}</small>
        </h3>
    </div>

    @if(count($tour['results']) > 0)
    <div id="wrapper" style="width: 700px;" class="center-block">
        <div class="panel panel-default">
            <div class="slider-wrapper theme-default">
                <div id="slider">

                    @foreach($tour['results'] as $image)
                    <img class="img-thumbnail" style="max-height: 300px;" src="{{$image['path']}}"
                         data-thumb="{{$image['path']}}" alt="{{$image['caption']}}"/>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    @endif


    <div class="panel panel-primary">
        <div class="panel-heading">Prices</div>
        <div class="panel-body">

            <table class="table table-stripped">
                <tbody>
                <thead>
                <th>Fare Name</th>
                <th>Price</th>
                <th>Currency</th>
                <th>Book Now</th>
                </thead>
                @foreach($tour['faresprices'] as $value)
                <tr>
                    <td>{{$value['fareName']}}</td>
                    <td>{{$value['rrp']}}</td>
                    <td>{{$value['currencyCode']}}</td>
                    <td><a href="{{ action('ToursController@book', array('id' => $tour['productId'], 'priceId' => $value['productPricesDetailsId'])) }}"><input type="submit" class="btn-default btn btn-success" value="BOOK NOW" /></a></td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="infoTab">
        <li><a href="#details" data-toggle="tab">Details</a></li>
        @if($tour['itinerary'] != null)
        <li><a href="#itinerary" data-toggle="tab">Itinerary</a></li>
        @endif
        @if($tour['pickups'] != null)
        <li><a href="#pickups" data-toggle="tab">Pickups</a></li>
        @endif
        <li><a href="#instructions" data-toggle="tab">Instructions</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active" id="details">{{$tour['productDetails']}}</div>
        @if($tour['itinerary'] != null)
        <div class="tab-pane fade" id="itinerary">{{$tour['itinerary']}}</div>
        @endif
        @if($tour['pickups'] != null)
        <div class="tab-pane fade" id="pickups">{{$tour['pickups']}}</div>
        @endif
        <div class="tab-pane fade" id="instructions">{{$tour['instructions']}}</div>
    </div>

    @if($tour['faresprices'][0]['travelStart'] != null)
    <div class="panel panel-success" style="width: 500px;">
        <div class="panel-heading">Travel Period</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">Travel Start</div>
                <div class="col-md-9" style="font-weight: bold;">{{$tour['faresprices'][0]['travelStart']}}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Travel End</div>
                <div class="col-md-9" style="font-weight: bold;">{{$tour['faresprices'][0]['travelEnd']}}</div>
            </div>
        </div>
    </div>
    @endif
</div>



























@extends('layouts.travel')
@section('content')
        <div class="tours">
            <div class="container">
                <header>
                    <h2>{{ $info->title; }}</h2>
                    <div>{{ $info->content; }}</div>
                </header>
                <div class="yellow_search_menu">
                    <div class="left">
                        {{ Form::open(array('url' => 'tours')) }}
                            <span>I’M INTERESTED IN</span>
                            <div class = 'dropdown_menu'>
                                {{ Form::text('select', $value = $selected->name, $attributes = array('class' => 'select', 'disabled' =>'disabled', 'style'=>'background-image:url(http://10.1.1.77:8888/img/icons/'.$selected->icon.'), url(http://10.1.1.77:8888/img/icons/select_input_up.png)'))}}
                                {{ Form::hidden('fun', $value = $selected->id, $attributes = array('class' => 'select_id'))}}
                                <ul class = 'dropdown'>
                                    @foreach ($icons as $icon)
                                    <li class = "dropdown_item"><img src="/img/icons/{{$icon->icon}}"><p>{{$icon->name}}</p><input type='hidden' value='{{$icon->id}}'></li>
                                    @endforeach
                                </ul>
                            </div>
                            {{ Form::text('start_date', $value = $start, $attributes = array('class' => 'date', 'placeholder'=>'Start Date', 'id'=>'from'));}}
                            {{ Form::text('end_date', $value = $end, $attributes = array('class' => 'date', 'placeholder'=>'End Date', 'id'=>'to'));}}
                            {{ Form::submit('SEARCH', array('class' => 'button'));}}
                        {{ Form::close(); }}                           
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="white">
                <div class="container">
                    @foreach ($tours as $tour)
                        <div class="item">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="left">
                                        <div class='header'>
                                            <p class="top">{{$tour['location']}}</p>
                                            <p class="place">{{$tour['name']}}</p>
                                        </div>
                                        <div class="description">
                                           {{ StringHelper::clearText($tour['Content']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="right">
                                        <div class="row">
                                            <div class="col-md-2">
                                            </div>
                                            <div class="col-md-10">
                                                <div class="slidshow">
                                                    <div class="wrapper">
                                                        <div class="slider-wrapper">
                                                            <div class="slider">
                                                                @foreach ($tour['slide_show'] as $picture)
                                                                    @if($picture)
                                                                        <img src="{{ $picture; }}" alt="" data-thumb="img/empty.png"/>
                                                                    @endif
                                                                @endforeach                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bottom">
                            
                                                    </div>
                                                </div>
                                                <div class="footer">
                                                    <p class="rate">
                                                        Best Rate
                                                    </p>
                                                    <p class="cost">
                                                        {{min($tour['price'])}}$
                                                    </p>
                                                </div>
                                                <!-- <div class="maximum_people latent">
                                                    <p>Maximum</p>
                                                    <p></p>
                                                </div> -->
                                                @if($tour['additional_info']!='' || $tour['additional_info']!=null)
                                                    <div class="aditional latent clear">
                                                        <p><b>Additional Information</b></p>
                                                            {{ StringHelper::clearText($tour['additional_info']) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div class='footer buttons'>
                                    <button type="button" class="btn more">View More Info</button>
                                    <button type="button" class="btn book">BOOK NOW</button>
                                </div>
                            </div>
                        </div>   
                    @endforeach
                    @if(empty($tours))
                        <div class="no_results">No Results</div>
                    @endif
                    <div class="pagin">
                        
                    </div>
                </div>
            </div>
        </div>
@stop


<!-- 
@section('search')
{{html_entity_decode($info->content)}}
<div class="jumbotron">
    <div class="container">

        <div class="row">
            <div class="col-md-5 col-md-offset-1">

                @include('forms.hotels.search')

            </div>
        </div>

    </div>
</div>
@stop -->








<article class="listing  clearfix">
    <div class="listing__info">
        <h4 class="listing__category">Australia Tours</h4>
        <h2 class="listing__title">
            <a class="plain-link" href="{{ action('ToursController@info', $product['productId']) }}">{{$product['name']}}</a>
        </h2>

        <div><span class="glyphicon glyphicon-dashboard pull-right">{{$product['faresprices']['0']['tripDuration']}}@if($product['faresprices']['0']['tripDuration'] <= 1)Day @else Days @endif</span></div>

        <div class="listing__description">
            @if($product['faresprices'][0]['travelStart'] != null)
            <div class="panel panel-success">
                <div class="panel-heading">Travel Period</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">Travel Start</div>
                        <div class="col-md-9"{{$product['faresprices'][0]['travelStart']}}>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">Travel End</div>
                        <div class="col-md-9">{{$product['faresprices'][0]['travelEnd']}}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{$product['productDetails']}}
        </div>

        <div class="listing__actions">
            <a class="btn" href="{{ action('ToursController@info', $product['productId']) }}">View More Info</a>

        @if(count($product['faresprices']) == 1)
            <a class="btn  btn--primary" href="{{ action('ToursController@book', array('id' => $product['productId'], 'priceId' => $product['faresprices'][0]['productPricesDetailsId'])) }}">Book Now</a>
        </div>
        @else
            <a class="btn  btn--primary" id="popover{{$product['productId']}}" href="#" data-original-title="Choose Fare type" data-toggle="popover" data-placement="right" data-target="#{{$product['productId']}}">Book Now</a>
        </div>

        <div id="{{$product['productId']}}" style="display: none;">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <table class="table table-stripped">
                        <tbody>
                        <thead>
                        <th>Fare Name</th>
                        <th>Price</th>
                        <th>Currency</th>
                        <th>Book Now</th>
                        </thead>
                        @foreach($product['faresprices'] as $value)
                        <tr>
                            <td>{{$value['fareName']}}</td>
                            <td>{{$value['rrp']}}</td>
                            <td>{{$value['currencyCode']}}</td>
                            <td><a href="{{ action('ToursController@book', array('id' => $product['productId'], 'priceId' => $value['productPricesDetailsId'])) }}"><input type="submit" class="btn" value="BOOK NOW" /></a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div><!-- /.listing__info -->

    <div class="listing__visuals">
        <a href="#"><img src="{{$product['productImagePath']}}" class="slider  listing__imgs" alt="{{$product['name']}}"/></a>
        <p>Rates from</p>
        <p>${{$product['faresprices']['0']['rrp']}} {{$product['faresprices']['0']['currencyCode']}}</p>
    </div>
</article>
