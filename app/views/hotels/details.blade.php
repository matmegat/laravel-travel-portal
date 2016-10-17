@extends('layouts.travel')

@section('title')
    {{$hotel['name']}}
@stop

@section('content')
    @if (isset($hotel['images']) && count($hotel['images']) > 0)
        <div class="home-slider page-slider">
            <ul class="slides-container">
                @foreach ($hotel['images'] as $key => $photo)
                    <li><img src="{{ $photo['url'] }}" alt=""></li>
                @endforeach
            </ul>
            <nav class="slides-navigation">
            <a href="#" class="next">Next</a>
            <a href="#" class="prev">Previous</a>
            </nav>
        </div>
    @else
        <div class="page-background nointro">

        </div>
    @endif

    <div class="main-body">

        <div class="container detailpage">

            <div class="row page-title">
                <div class="col-md-8">
                    <h1>{{$hotel['name']}}</h1>
                    <p>{{$hotel['address']}}</p>
                </div>
                <div class="col-md-4">
                    <span>Visits Best Rate</span>
                </div>
            </div>

            <div class="row">

                <aside class="col-md-4 col-md-push-2">
                    <dl>
                      <dt><strong>Provider</strong></dt>
                      <dd>{{$hotel['room_rate_min']['provider_name']}}</dd>
                      <dt><strong>Price</strong></dt>
                      <dd>${{$hotel['room_rate_min']['price_str']}} AUD</dd>
                    </dl>

                    <a href="{{ action('HotelsController@redirectToSite', array('search_id' => $search_id, 'hotel_id' => $hotel['id'], 'room_rate_id' => $hotel['room_rate_min']['id'])) }}" class="button yellow">Book Now</a>

                </aside>

                <article class="col-md-8">

                    <h5>At a Glance</h5>

                    <p class="intro">{{ StringHelper::clearText($hotel['desc']) }}</p>

                    <h5>Amenities</h5>
                    <ul class="amenities clearfix">
                        <li>Air conditioning</li>
                        <li>Internet access</li>
                        <li>Minibar</li>
                        <li>Shower</li>
                    </ul>

                </article>
            </div>


        </div>

        <div class="container tour-tabs">
            <div class="row">
                <a class="col-xs-4 tab active" href="#info">Info</a>
                <a class="col-xs-4 tab" href="#amenities">Amenities</a>
                <a class="col-xs-4 tab" href="#roomrates"><span>Room </span>Rates</a>
            </div>
        </div>

        <div class="container tour-tab-content">

            <div class="row">
                <div class="col-xs-12 tab active" id="info">
                    <p class="intro">{{ StringHelper::clearText($hotel['desc']) }}</p>
                </div>
                <div class="col-xs-12 tab" id="amenities">
                    <ul class="amenities clearfix">
                        <li>Air conditioning</li>
                        <li>Internet access</li>
                        <li>Minibar</li>
                        <li>Shower</li>
                    </ul>
                </div>
                <div class="col-xs-12 tab" id="roomrates">

                    <div class="row item">
                        <div class="col-xs-9 col-md-3"><strong>Provider</strong></div>
                        <div class="col-xs-3 col-md-3"><strong>Price</strong></div>
                        <div class="hide-mobile col-md-6"><strong>Description</strong></div>
                    </div>

                    @foreach($hotel['room_rates'] as $rate)
                        <div class="row item">
                            <div class="col-xs-9 col-md-3">
                                <a href="{{ action('HotelsController@redirectToSite', array('search_id' => $search_id, 'hotel_id' => $hotel['id'], 'room_rate_id' => $rate['id'])) }}">
                                    {{$rate['provider_name']}}
                                </a>
                            </div>
                            <div class="col-xs-3 col-md-3">${{$rate['price_str']}}</div>
                            <div class="col-xs-12 col-md-6">{{$rate['description']}}</div>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <a href="{{ action('HotelsController@redirectToSite', array('search_id' => $search_id, 'hotel_id' => $hotel['id'], 'room_rate_id' => $hotel['room_rate_min']['id'])) }}" class="button yellow hide-desktop">Book Now</a>
                </div>
            </div>

        </div>

    </div>

    {{--<div class="tour_details">
        <header class="topper">
            @if(count($hotel['images']) > 0)
            <div id="myCarousel" class="carousel slide md-height" data-interval="false" data-ride="carousel">
                <!-- Carousel items -->
                <div class="carousel-inner">
                    @for ($i = 0; $i < min(count($hotel['images']), 10); $i++)
                    <div class="{{ $i == 0 ? 'active': '' }} item">
                        <img
                                src="{{ $hotel['images'][$i]['url'] }}"
                                data-thumb="{{ $hotel['images'][$i]['url'] }}"
                                class="image-r img-responsive"
                                />
                    </div>
                    @endfor
                </div>
                <!-- Carousel nav -->
                <a class="carousel-control left" href="#myCarousel" data-slide="prev">
                    <i class="fa fa-chevron-left"></i>
                </a>
                <a class="carousel-control right" href="#myCarousel" data-slide="next">
                    <i class="fa fa-chevron-right"></i>
                </a>
            </div>
            @endif
        </header>
        <article>
            <div class="container">
                <header>
                    <div class="leftie">
                        <div>
                            <h2>{{$hotel['name']}}</h2>
                            <small>{{$hotel['address']}}</small>
                        </div>
                    </div>
                    <div class="rightie">
                        <h2>WINGS BEST RATE</h2>
                    </div>
                </header>
                <article>
                    <div class="leftie">
                        <h3>AT A GLANCE</h3>
                        <p>{{ StringHelper::clearText($hotel['desc']) }}</p>
                        <br>
                        <h3>AMENITIES</h3>
                        <ul class="key_features">
                            <li>Air conditioning</li>
                            <li>Internet access</li>
                            <li>Minibar</li>
                            <li>Shower</li>
                        </ul>
                        
                    </div>
                    <div class="rightie">
                        <ul class="info_tour_details">
                            <li>
                                <h3>Provider</h3>
                                <p>{{$hotel['room_rate_min']['provider_name']}}</p>
                            </li>
                            
                            <li>
                                <h3>Price</h3>
                                <p>${{$hotel['room_rate_min']['price_str']}} AUD</p>
                            </li>

                        </ul>
                        <a href="{{ action('HotelsController@redirectToSite', array('search_id' => $search_id, 'hotel_id' => $hotel['id'], 'room_rate_id' => $hotel['room_rate_min']['id'])) }}" class="book_now">Book Now</a>
                       
                    </div>
                </article>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tabs_details" role="tablist">
                    <li class="active"><a href="#01" role="tab" data-toggle="tab">INFO</a></li>
                    <li><a href="#02" role="tab" data-toggle="tab">AMENITIES</a></li>
                    <li><a href="#03" role="tab" data-toggle="tab">ROOM RATES</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content content_details">
                    <div class="tab-pane active" id="01">
                        <p>{{ StringHelper::clearText($hotel['desc']) }}</p>
                    </div>

                    <div class="tab-pane" id="02">
                        <ul class="key_features">
                            <li>Air conditioning</li>
                            <li>Internet access</li>
                            <li>Minibar</li>
                            <li>Shower</li>
                        </ul>
                    </div>

                    <div class="tab-pane" id="03">
                        <div class="row head">
                            <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
                                <h3>Provider</h3>
                            </div>
                            <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
                                <h3>Price</h3>
                            </div>
                            <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                                <h3>Descriptiondaf</h3>
                            </div>
                            <!--
                            <div class="col-lg-5 col-md-5 hidden-sm hidden-xs">
                                <h3>Travel Date:</h3>
                                <input type="text" name=""  class="head_date_tour date form-control hasDatepicker" value="" placeholder="">
                            </div>
                            -->
                        </div>
                        @foreach($hotel['room_rates'] as $rate)
                        <div class="row dates">
                                

                          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
                              <a href="{{ action('HotelsController@redirectToSite', array('search_id' => $search_id, 'hotel_id' => $hotel['id'], 'room_rate_id' => $rate['id'])) }}">{{$rate['provider_name']}}</a>
                          </div>
                          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
                              {{$rate['price_str']}}
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 ">
                              {{$rate['description']}}
                          </div>
                          
                      </div>
                      @endforeach

                        
                    </div>
                   
                </div>

                <!-- @include('tours.parts.popularTours') -->
            </div>
        </article>
    </div>--}}

@stop