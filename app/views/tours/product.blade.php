@extends('layouts.travel')

@section('title')
{{$product['Title']}} | Visits
@stop
@section('styles')
    <style type="text/css">
        body {
            background: none;
        }
    </style>
@stop

@section('content')
    <div class="tour_details">
        <header class="topper">
            @if(count($product['Photos']) > 0)
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        @foreach ($product['Photos'] as $key => $photo)
                            @if ($key == 0)
                                <div class="item active">
                                    <img src="{{ $photo['URL'] }}" alt="">
                                </div>
                            @else
                                <div class="item">
                                    <img src="{{ $photo['URL'] }}" alt="">
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <i class="fa fa-chevron-left"></i>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
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
                            <h2>{{$product['Title']}}</h2>
                        </div>
                    </div>
                    <div class="rightie">
                        <h2>from: ${{ $product['quickBook']['Price'] }} (AUD) </h2>
                    </div>
                </header>
                <article>
                    <div class="leftie">
                        <h3>Overview</h3>
                        <p>{{{ strip_tags(StringHelper::clearText($product['WhatToBring'])) }}}</p>
                        <br>
                        <h3>Key Features</h3>
                        <p>{{ StringHelper::clearText($product['Content']) }}</p>
                    </div>
                    <div class="rightie">
                        <ul class="info_tour_details">
                            <li>
                                <h3>Departs</h3>
                                <p>{{ date("l", strtotime($product['quickBook']['Date'])) }}</p>
                            </li>
                            <li>
                                <h3>Duration</h3>
                                @if (empty($product['quickBook']['Start']) || empty($product['quickBook']['End']))
                                    <p>1 Day</p>
                                @else
                                    <p>{{ $product['quickBook']['Start'] }} - {{ $product['quickBook']['End'] }}</p>
                                @endif
                            </li>
                            <li>
                                <h3>No. Guests</h3>
                                <p>{{ $product['quickBook']['Quantity'] }} People</p>
                            </li>
                            @if (!empty($product['Location']))
                                <li>
                                    <h3>Location</h3>
                                    <p>{{ $product['Location'] }}</p>
                                </li>
                            @endif
                        </ul>
                        <form method="get" action="{{ action('ToursController@bookProduct', array('product' => $product['ID'])) }}" class="form-inline next-10-events">
                            <input type="hidden" name="event_id" value="{{ $product['quickBook']['ID'] }}"/>
                            <input type="hidden" name="qty" value="1" class="form-control" placeholder="">
                            <input type="hidden" name="variation_id" class="form-control" value="{{ $product['quickBook']['Variation']['ID'] }}">
                            <button class="book_now">Book Now</button>
                        </form>
                    </div>
                </article>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tabs_details" role="tablist">
                    <li class="active"><a href="#01" role="tab" data-toggle="tab">BOOKING</a></li>
                    <li><a href="#02" role="tab" data-toggle="tab">Info</a></li>
                    <li><a href="#03" role="tab" data-toggle="tab">Itenerary</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content content_details">
                    <div class="tab-pane active" id="01">
                        <div class="row head">
                            <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
                                <h3>Date</h3>
                            </div>
                            <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
                                <h3>QTY</h3>
                            </div>
                            <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                                <h3>Package</h3>
                            </div>
                            <!--
                            <div class="col-lg-5 col-md-5 hidden-sm hidden-xs">
                                <h3>Travel Date:</h3>
                                <input type="text" name=""  class="head_date_tour date form-control hasDatepicker" value="" placeholder="">
                            </div>
                            -->
                        </div>

                        @if(count($product['Next10Events']) > 0)
                            @foreach($product['Next10Events'] as $value)
                                <form method="get" action="{{ action('ToursController@bookProduct', array('product' => $product['ID'])) }}" class="form-inline next-10-events">
                                    <input type="hidden" name="event_id" value="{{ $value['ID'] }}"/>

                                    <div class="row dates">
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 day">
                                            <h1>{{ date("d", strtotime($value['Date'])) }}</h1>
                                            <p>{{ date("M", strtotime($value['Date'])) }} </p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 qty">
                                            <input type="text" name="qty" value="1" class="form-control" placeholder="">
                                            <p>of {{$value['Quantity']}}</p>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 package">
                                            <select name="variation_id" class="form-control">
                                                @foreach($product['Variations'] as $value)
                                                    <option value="{{$value['ID']}}">${{$value['Price']}} {{$value['InternalItemID']}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-3 book">
                                            <button class="book_now">Book Now</button>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <div class="tab-pane" id="02">{{ StringHelper::clearText($product['Features']) }}</div>
                    <div class="tab-pane" id="03">{{ StringHelper::clearText($product['Itinerary']) }}</div>
                </div>

                <!-- @include('tours.parts.popularTours') -->
            </div>
        </article>
    </div>
@stop