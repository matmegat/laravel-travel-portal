<?php

$count = count($item['outbound_segments']);
if (isset($item['inbound_segments'])) {
    $count += count($item['inbound_segments']);
} else {
    $count += 1;
} ?>
<div class="row flight-overview">
    <div class="col-xs-7 col-md-9 flight-name">
        <img src="{{ StringHelper::secureImageUrl('http://0.omg.io/wego/image/upload/flights/airlines_rectangular/'.$item['marketing_airline_code'].'.png', 'airlines') }}" alt="{{$item['marketing_airline_code']}}" class="responsive">
        <h5>
            @if (!empty($show_departure))
                {{ $item['outbound_segments'][0]['departure_name'] }}
            @else
                {{ $item['fares']['0']['description'] }}
            @endif
        </h5>
        <p>{{ $count==2? 'Direct' : ($count==3? ($count-2).' Stop' : ($count-2).' Stops') }}</p>
    </div>
    <div class="col-xs-3 col-md-2 flight-rate">
        <p>Best Rate p.p</p>
        <h3>{{ isset($filters['currency']['code']) && $filters['currency']['code'] == 'AUD'? 'A$' : '$' }}{{ floor($item['best_fare']['price']) }}</h3>
    </div>
    <div class="col-xs-2 col-md-1 show-more"><a href="#" class="flight-more-trigger">Info</a></div>
</div>
<div class="row flight-details">

    <div class="col-xs-12">
        @if (isset($item['outbound_segments']))

            <div class="row intro">
                <div class="col-sm-6"><h5>Outbound Details</h5></div>
                <div class="col-sm-6"><p>Total Duration: {{$item['total_duration']}}</p></div>
            </div>

            @foreach( $item['outbound_segments'] as $outbound)
                <div class="row itinerary">
                    <div class="col-md-2">
                        <img src="{{ StringHelper::secureImageUrl('http://0.omg.io/wego/image/upload/flights/airlines_rectangular/'.$item['marketing_airline_code'].'.png', 'airlines') }}" alt="virgin" class="responsive">
                        <h5>{{$outbound['designator_code']}}</h5>
                    </div>
                    <div class="col-md-3">
                        <h5>{{$outbound['outtime']}}</h5>
                        <p>Departs from {{$outbound['departure_name']}} ({{$outbound['departure_code']}})</p>
                    </div>
                    <div class="col-md-2">
                        <span class="flyicon"></span>
                    </div>
                    <div class="col-md-3">
                        <h5>{{$outbound['intime']}}</h5>
                        <p>Arrives at {{$outbound['arrival_name']}} ({{$outbound['arrival_code']}})</p>
                    </div>
                    <div class="col-md-2">
                        <span class="duration">{{$outbound['duration']}}</span>
                    </div>
                </div>
                @if ($outbound['layover'])
                    <div class="row layover">
                        <div class="col-md-12">
                            <h5>Layover in {{$outbound['layover_place']}} {{$outbound['layover_duration']}}</h5>
                        </div>
                    </div>
                @endif

            @endforeach

        @endif

        @if (isset($item['inbound_segments']))
            <div class="row intro">
                <div class="col-sm-6"><h5>Inbound Details</h5></div>
                <div class="col-sm-6"><p>Total Duration: {{$item['total_duration']}}</p></div>
            </div>

            @foreach( $item['inbound_segments'] as $inbound)
                <div class="row itinerary">
                    <div class="col-md-2">
                        <img src="http://www.mediawego.com/images/flights/airlines/80x27/{{$item['marketing_airline_code']}}.gif" alt="virgin" class="responsive">
                        <h5>{{$inbound['designator_code']}}</h5>
                    </div>
                    <div class="col-md-3">
                        <h5>{{$outbound['outtime']}}</h5>
                        <p>Departs from {{$inbound['departure_name']}} ({{$inbound['departure_code']}})</p>
                    </div>
                    <div class="col-md-2">
                        <span class="flyicon"></span>
                    </div>
                    <div class="col-md-3">
                        <h5>{{$outbound['intime']}}</h5>
                        <p>Arrives at {{$inbound['arrival_name']}} ({{$inbound['arrival_code']}})</p>
                    </div>
                    <div class="col-md-2">
                        <span class="duration">{{$inbound['duration']}}</span>
                    </div>
                </div>
                @if ($inbound['layover'])
                    <div class="row layover">
                        <div class="col-md-12">
                            <h5>Layover in {{$inbound['layover_place']}} {{$inbound['layover_duration']}}</h5>
                        </div>
                    </div>
                @endif

            @endforeach

        @endif

        <div class="row booknow">
            <div class="col-md-12">
                <a href="{{ isset($item['best_fare']['deeplink_params']) ? action("FlightsController@redirectToSite", $item['best_fare']['deeplink_params']) : 'null' }}">Book Now</a>
            </div>
        </div>

    </div>

</div>



{{--<script>
    window.FLIGHTS_ROUTES[{{$routeKey}}]={
        outbound: {{json_encode($item['outbound_segments'])}},
        inbound: {{isset($item['inbound_segments'])?json_encode($item['inbound_segments']):"null"}},
        book_link: "{{ isset($item['best_fare']['deeplink_params']) ? action("FlightsController@redirectToSite", $item['best_fare']['deeplink_params']) : 'null' }}"
    };
</script>
<?php $first_segment = current($item['outbound_segments']); ?>
<?php 
 $count = count($item['outbound_segments']);
 if (isset($item['inbound_segments'])) {
     $count += count($item['inbound_segments']);
 } else {
    $count += 1;
} ?>
<div data-key="{{$routeKey}}" class="result_holder item flights-details-item">
    <div class="result">
        <div class="info img">
            <img alt="{{$item['marketing_airline_code']}}"
                 src="//www.mediawego.com/images/flights/airlines/120x40t/{{$item['marketing_airline_code']}}.gif">
        </div>

        <div class="info flight">

            @if (!empty($show_departure))
                <h4 class="flight_caption departure_city" title="{{$item['outbound_segments'][0]['departure_name']}}">
                    {{ $item['outbound_segments'][0]['departure_name'] }}
                </h4>
            @else
                <h4 class="flight_caption" title="{{$item['fares']['0']['description']}}">
                    {{ $item['fares']['0']['description'] }}
                </h4>
            @endif

            <span class="transits">
                {{ $count==2? 'Direct' : ($count==3? ($count-2).' Stop' : ($count-2).' Stops') }}
            </span>
        </div>

        <div class="info rate">
            <span>Best Rate p.p</span><br/>
            <h4 class="price" title="{{ isset($filters['currency']['code']) && $filters['currency']['code'] == 'AUD'? 'A$' : '$' }}{{ floor($item['best_fare']['price']) }}">
                {{ isset($filters['currency']['code']) && $filters['currency']['code'] == 'AUD'? 'A$' : '$' }}{{ floor($item['best_fare']['price']) }}
            </h4>
        </div>
        <!--<div class="show_hide flights-details-btn box_rotate info more ">-->
        <div class="show_hide flights-details-btn info more ">
            <img src="/img/icons/select_down.png" class=""/>
        </div>
    </div>
    <div class="item_description">
    </div>
</div>--}}



