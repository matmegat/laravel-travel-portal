

    <div class="item_description">
        <div class="details">
            <div class="details_name"><span class="outbound">OUTBOUND DETAILS:</span><span  class="total_duration">Total Duration 19h10m</span></div>
            <div class="departs_arrives">
                <div><img src="http://www.mediawego.com/images/flights/airlines/80x27/{{airline_code}}.gif" /><p>{{designator_code}}</p></div>
                <div class="from_in"><span class="timedate">{{departure_time}}</span><br /><span class="depart">Departs from {{departure_name}} ({{departure_code}})</span></div>
                <div class="plane_block"><img class="plane" src="/img/icons/plane.svg" /></div>
                <div class="from_in"><span class="timedate">{{arrival_time}}</span><br /><span class="depart">Arrives at {{arrival_name}} ({{arrival_code}})</span></div>
                <div><span class="duration">{{duration}}</span></div>
            </div>
            <div class="layover">
                <span class="layover_place">Layover in Sydney (SYD)</span><span class="layover_time">9h50m</span>
            </div>
            <div class="departs_arrives">
                <div><img src="/img/logo/qantas.png" /><p>J268</p></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 17:30</span><br /><span class="depart">Departs from Sydney (SYD)</span></div>
                <div class="plane_block"><img class="plane" src="/img/icons/plane.svg" /></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 20:55</span><br /><span class="depart">Arrives in Perth (PER)</span></div>
                <div><span class="duration">5h25m</span></div>
            </div>
        </div>
        <div class="details">
            <div class="details_name inbound_name"><span class="outbound">INBOUND DETAILS:</span><span  class="total_duration">Total Duration 19h10m</span></div>
            <div class="departs_arrives">
                <div><img src="/img/logo/qantas.png" /><p>J162</p></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 06:45</span><br /><span class="depart">Departs from Wellington (WLG)</span></div>
                <div class="plane_block"><img class="plane" src="/img/icons/plane.svg" /></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 07:40</span><br /><span class="depart">Arrives in Sydney (SYD)</span></div>
                <div><span class="duration">3h45m</span></div>
            </div>
            <div class="layover">
                <span class="layover_place">Layover in Sydney (SYD)</span><span class="layover_time">9h50m</span>
            </div>
            <div class="departs_arrives">
                <div><img src="/img/logo/qantas.png" /><p>J268</p></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 17:30</span><br /><span class="depart">Departs from Sydney (SYD)</span></div>
                <div class="plane_block"><img class="plane" src="/img/icons/plane.svg" /></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 20:55</span><br /><span class="depart">Arrives in Perth (PER)</span></div>
                <div><span class="duration">5h25m</span></div>
            </div>
        </div>
        <div class="book_now"><input type="button" value="BOOK NOW"></div>
    </div>


<div dir="ltr" class="clearfix">
    <table class="wego-flight-detail-table">
      <tbody>
        {{#outbound}}
        <tr>
          <td colspan="2" class="wego-flight-date">
            <strong>Outbound Flight</strong> - <span class="wego-dataheader">{{outbound_day}}</span>
          </td>
          <td colspan="2" class="wego-duration">
            Duration: <strong>{{duration}}</strong>
          </td>
        </tr>
        {{#trips}}
        {{#layover}}
        <tr>
          <td class="layover-note" colspan="4">{{time}} layover in {{place}}</td>
        </tr>
        {{/layover}}
        <tr>
          <td class="wego-airline-cell">
            <img src="http://www.mediawego.com/images/flights/airlines/80x27/{{airline_code}}.gif"> <strong>{{designator_code}}</strong>{{#operating_airline_name}}<span class="wego-codeshare-star">*</span>{{/operating_airline_name}}
          </td>
          <td>
            <strong title="{{departure_time}} ({{departure_name}})">{{departure_time}}</strong><br>
            Departs from {{departure_name}} ({{departure_code}})
          </td>
          <td>
            <strong title="{{arrival_time}} ({{arrival_name}})">{{arrival_time}}</strong><br>
            Arrives at {{arrival_name}} ({{arrival_code}})
          </td>
          <td>
            <strong>{{duration}}</strong>
            <br>
            {{aircraft_type}}
          </td>
        </tr>
        {{#operating_airline_name}}
        <tr>
          <td colspan="2"><span class="wego-codeshare-star">*</span> Operated by {{operating_airline_name}}</td>
        </tr>
        {{/operating_airline_name}}
        {{/trips}}
        {{/outbound}}
        {{#inbound}}
        <tr>
          <td colspan="2" class="wego-flight-date">
            <strong>Return Flight</strong> - <span class="wego-dataheader">{{outbound_day}}</span>
          </td>
          <td colspan="2" class="wego-duration">
            Duration: <strong>{{duration}}</strong>
          </td>
        </tr>
        {{#trips}}
        {{#layover}}
        <tr>
          <td class="layover-note" colspan="4">{{time}} layover in {{place}}</td>
        </tr>
        {{/layover}}
        <tr>
          <td class="wego-airline-cell">
            <img src="http://www.mediawego.com/images/flights/airlines/80x27/{{airline_code}}.gif"> <strong>{{designator_code}}</strong>{{#operating_airline_name}}<span class="wego-codeshare-star">*</span>{{/operating_airline_name}}
          </td>
          <td>
            <strong title="{{departure_time}} ({{departure_name}})">{{departure_time}}</strong><br>
            Departs from {{departure_name}} ({{departure_code}})
          </td>
          <td>
            <strong title="{{arrival_time}} ({{arrival_name}})">{{arrival_time}}</strong><br>
            Arrives at {{arrival_name}} ({{arrival_code}})
          </td>
          <td>
            <strong>{{duration}}</strong>
            <br>
            {{aircraft_type}}
          </td>
        </tr>
        {{#operating_airline_name}}
        <tr>
          <td colspan="2"><span class="wego-codeshare-star">*</span> Operated by {{operating_airline_name}}</td>
        </tr>
        {{/operating_airline_name}}
        {{/trips}}
        {{/inbound}}
      </tbody>
    </table>
  </div>



















        <div class="details">
                <div class="details_name"><span class="outbound">OUTBOUND DETAILS:</span><span  class="total_duration">Total Duration 19h10m</span></div>

            @foreach($item['outbound_segments'] as $outbound)
                <div class="departs_arrives">
                    <div><img src="http://www.mediawego.com/images/flights/airlines/80x27/{{$outbound['airline_code']}}.gif" /><p>{{$outbound['designator_code']}}</p></div>
                    <div class="from_in"><span class="timedate">{{$outbound['departure_time']}}</span><br /><span class="depart">Departs from {{$outbound['departure_name']}} ({{$outbound['departure_code']}})</span></div>
                    <div class="plane_block"><img class="plane" src="/img/icons/plane.svg" /></div>
                    <div class="from_in"><span class="timedate">{{$outbound['arrival_time']}}</span><br /><span class="depart">Arrives at {{$outbound['arrival_name']}} ({{$outbound['arrival_code']}})</span></div>
                    <div><span class="duration">{{$duration}}</span></div>
                </div>
                <div class="layover">
                    <span class="layover_place">Layover in Sydney (SYD)</span><span class="layover_time">9h50m</span>
                </div>
            @endforeach





            <div class="departs_arrives">
                <div><img src="/img/logo/qantas.png" /><p>J268</p></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 17:30</span><br /><span class="depart">Departs from Sydney (SYD)</span></div>
                <div class="plane_block"><img class="plane" src="/img/icons/plane.svg" /></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 20:55</span><br /><span class="depart">Arrives in Perth (PER)</span></div>
                <div><span class="duration">5h25m</span></div>
            </div>
        </div>
        <div class="book_now"><input type="button" value="BOOK NOW"></div>








<script>
    window.FLIGHTS_ROUTES[{{$routeKey}}]={
        outbound: {{json_encode($item['outbound_segments'])}},
        inbound: {{isset($item['inbound_segments'])?json_encode($item['inbound_segments']):null}}
    };
</script>
<?php $first_segment = current($item['outbound_segments']) ?>
<?php //var_dump($item) ?>
<div class="item">
    <div class="item_title">
        <div class="img"><img alt="{{$first_segment['airline_code']}}" src="//www.mediawego.com/images/flights/airlines/120x40t/{{$first_segment['airline_code']}}.gif"></div>
        <div class="trevel_info economy"><span class="trevel_class">{{$item['fares']['0']['description']}}</span><span class="transits">1 Stop</span></div>
        <div class="trevel_info trevel_price"><span>Best Rate p.p</span><br /><span class="price">${{ floor($item['best_fare']['price']) }}</span></div>
        <div class="show_hide flights-details-btn" ><img src="/img/icons/select_down.png" /></div>
    </div>
    <div class="item_description">

    </div>
</div>




<script>
    window.FLIGHTS_ROUTES[{{$routeKey}}]={
        outbound: {{json_encode($item['outbound_segments'])}},
        inbound: {{isset($item['inbound_segments'])?json_encode($item['inbound_segments']):null}}
    };
</script>
<?php $first_segment = current($item['outbound_segments']) ?>
<?php //var_dump($item) ?>
<div class="item">
    <div class="item_title">
        <div class="img"><img alt="{{$first_segment['airline_code']}}" src="//www.mediawego.com/images/flights/airlines/120x40t/{{$first_segment['airline_code']}}.gif"></div>
        <div class="trevel_info economy"><span class="trevel_class">{{$item['fares']['0']['description']}}</span><span class="transits">1 Stop</span></div>
        <div class="trevel_info trevel_price"><span>Best Rate p.p</span><br /><span class="price">${{ floor($item['best_fare']['price']) }}</span></div>
        <div class="show_hide flights-details-btn" ><img src="/img/icons/select_down.png" /></div>
    </div>
    <div class="item_description">

    </div>
</div>












<?php var_dump($item); exit(); ?>
<div class="panel panel-info">
    <div class="panel-body">
        <script>
            window.FLIGHTS_ROUTES[{{$routeKey}}]={
                outbound: {{json_encode($item['outbound_segments'])}},
                inbound: {{isset($item['inbound_segments'])?json_encode($item['inbound_segments']):null}}
            };
        </script>
        <button data-key="{{$routeKey}}" class="btn btn-info flights-details-btn">
            Flight Details
        </button>
        <div class="pull-right">
            from
            <b>{{ floor($item['best_fare']['price']) }}</b>
            AUD
            <div class="btn-group">
                <a href="{{ action('FlightsController@redirectToSite', $item['best_fare']['deeplink_params']) }}" class="btn btn-primary">Go!</a>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    @foreach( $item['fares'] as $fare )
                    <li>
                        <a href="{{ action('FlightsController@redirectToSite', $fare['deeplink_params']) }}">
                            {{ $fare['description'] }}
                            {{ floor($fare['price']) }} AUD
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <p class="flight-summary">
            <?php $first_segment = current($item['outbound_segments']) ?>
            <?php $d_date = date_parse($first_segment['departure_time']) ?>
            <?php $last_segment = end($item['outbound_segments']) ?>
            <?php $a_date = date_parse($last_segment['arrival_time']) ?>
            <?php $duration = strtotime($last_segment['arrival_time']) - strtotime($first_segment['departure_time']) ?>
            <span class="airline_codes">
                    <img alt="{{$first_segment['airline_code']}}" src="//www.mediawego.com/images/flights/airlines/27x23/{{$first_segment['airline_code']}}.gif">
            </span>
            <span class="outbound_loc">{{$first_segment['departure_code']}}</span>
            <span class="outbound_time">{{$d_date['hour']}}:{{sprintf('%02d',$d_date['minute'])}}</span>
            <span class="inbound_loc">{{$last_segment['arrival_code']}}</span>
            <span class="inbound_time">{{$a_date['hour']}}:{{sprintf('%02d',$a_date['minute'])}}</span>
            <span class="duration">
                {{floor($duration/3600)}}h{{sprintf('%02d',floor(($duration%3600)/60))}}m
            </span>
            <span class="via">
                @if( count($item['outbound_segments']) == 1 )
                Direct
                @else
                {{ count($item['outbound_segments']) - 1 }} stops
                @endif
            </span>
        </p>

        @if ( isset($item['inbound_segments']) )
        <p class="flight-summary">
            <?php $first_segment = current($item['inbound_segments']) ?>
            <?php $d_date = date_parse($first_segment['departure_time']) ?>
            <?php $last_segment = end($item['inbound_segments']) ?>
            <?php $a_date = date_parse($last_segment['arrival_time']) ?>
            <?php $duration = strtotime($last_segment['arrival_time']) - strtotime($first_segment['departure_time']) ?>
            <span class="airline_codes">
                    <img alt="{{$first_segment['airline_code']}}" src="//www.mediawego.com/images/flights/airlines/27x23/{{$first_segment['airline_code']}}.gif">
            </span>
            <span class="outbound_loc">{{$first_segment['departure_code']}}</span>
            <span class="outbound_time">{{$d_date['hour']}}:{{sprintf('%02d',$d_date['minute'])}}</span>
            <span class="inbound_loc">{{$last_segment['arrival_code']}}</span>
            <span class="inbound_time">{{$a_date['hour']}}:{{sprintf('%02d',$a_date['minute'])}}</span>
            <span class="duration">
                {{floor($duration/3600)}}h{{sprintf('%02d',floor(($duration%3600)/60))}}m
            </span>
            <span class="via">
                @if( count($item['inbound_segments']) == 1 )
                Direct
                @else
                {{ count($item['inbound_segments']) - 1 }} stops
                @endif
            </span>
            <span class="clearfix"></span>
        </p>
        @endif
    </div>
</div>













<div class="item">
    <div class="item_title">
        <div class="img"><img src="/img/logo/qantas.png" /></div>
        <div class="trevel_info economy"><span class="trevel_class">Economy</span><span class="transits">1 Stop</span></div>
        <div class="trevel_info trevel_price"><span>Best Rate p.p</span><br /><span class="price">$808</span></div>
        <div class="show_hide"><img src="/img/icons/select_down.png" /></div>
    </div>
    <div class="item_description">
        <div class="details">
            <div class="details_name"><span class="outbound">OUTBOUND DETAILS:</span><span  class="total_duration">Total Duration 19h10m</span></div>
            <div class="departs_arrives">
                <div><img src="http://www.mediawego.com/images/flights/airlines/80x27/{{airline_code}}.gif" /><p>{{designator_code}}</p></div>
                <div class="from_in"><span class="timedate">{{departure_time}}</span><br /><span class="depart">Departs from {{departure_name}} ({{departure_code}})</span></div>
                <div class="plane_block"><img class="plane" src="/img/icons/plane.svg" /></div>
                <div class="from_in"><span class="timedate">{{arrival_time}}</span><br /><span class="depart">Arrives at {{arrival_name}} ({{arrival_code}})</span></div>
                <div><span class="duration">{{duration}}</span></div>
            </div>
            <div class="layover">
                <span class="layover_place">Layover in Sydney (SYD)</span><span class="layover_time">9h50m</span>
            </div>
            <div class="departs_arrives">
                <div><img src="/img/logo/qantas.png" /><p>J268</p></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 17:30</span><br /><span class="depart">Departs from Sydney (SYD)</span></div>
                <div class="plane_block"><img class="plane" src="/img/icons/plane.svg" /></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 20:55</span><br /><span class="depart">Arrives in Perth (PER)</span></div>
                <div><span class="duration">5h25m</span></div>
            </div>
        </div>
        <div class="details">
            <div class="details_name inbound_name"><span class="outbound">INBOUND DETAILS:</span><span  class="total_duration">Total Duration 19h10m</span></div>
            <div class="departs_arrives">
                <div><img src="/img/logo/qantas.png" /><p>J162</p></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 06:45</span><br /><span class="depart">Departs from Wellington (WLG)</span></div>
                <div class="plane_block"><img class="plane" src="/img/icons/plane.svg" /></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 07:40</span><br /><span class="depart">Arrives in Sydney (SYD)</span></div>
                <div><span class="duration">3h45m</span></div>
            </div>
            <div class="layover">
                <span class="layover_place">Layover in Sydney (SYD)</span><span class="layover_time">9h50m</span>
            </div>
            <div class="departs_arrives">
                <div><img src="/img/logo/qantas.png" /><p>J268</p></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 17:30</span><br /><span class="depart">Departs from Sydney (SYD)</span></div>
                <div class="plane_block"><img class="plane" src="/img/icons/plane.svg" /></div>
                <div class="from_in"><span class="timedate">Thu 14 Nov, 20:55</span><br /><span class="depart">Arrives in Perth (PER)</span></div>
                <div><span class="duration">5h25m</span></div>
            </div>
        </div>
        <div class="book_now"><input type="button" value="BOOK NOW"></div>
    </div>
</div>
