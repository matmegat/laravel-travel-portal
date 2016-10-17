<div class="heading">
    <h5>Filter your results</h5>
    <a href="#" class="showfilter">Show</a>
</div>
<div class="filter-content">

    <div class="item formplate">
        <h5>Stops</h5>
        <div>
            <input type="checkbox" class="white" checked id="select_all">Select all
        </div>
        <div>
            <input type="checkbox" class="white flight-stop" id="flight-stop-none" value="none" >Direct
            <input type="checkbox" class="white flight-stop" id="flight-stop-one" value="one" >1 stop
            <input type="checkbox" class="white flight-stop" id="flight-stop-two_plus" value="two_plus" >2+ stops
        </div>
    </div>

    <div class="item">
        <h5>Takeoff Times</h5>
        <p>
            Outgoing Flight
            @if (Input::get('departure'))
                from - {{ Input::get('departure') }}
            @endif
        </p>
        <div class="sections">
            <span id="takeoff_out_start" class="start"><em></em></span>
            <span id="takeoff_out_end" class="end"><em></em></span>
        </div>
        <div class="takeofftimes"></div>
    </div>

    <div class="item">
        <h5>Price</h5>
        <div class="sections">
            <span id="price_start" class="start"><em></em></span>
            <span id="price_end" class="end"><em></em></span>
        </div>
        <div class="flightprice"></div>
    </div>

    <div class="item">
        <h5>Stop Over Duration</h5>
        <div class="sections">
            <span id="stopovertime_start" class="start"><em></em></span>
            <span id="stopovertime_end" class="end"><em></em></span>
        </div>
        <div class="stopovertime"></div>
    </div>

    <div class="item">
        <h5>Total Travel Duration</h5>
        <div class="sections">
            <span id="travelduration_start" class="start"><em></em></span>
            <span id="travelduration_end" class="end"><em></em></span>
        </div>
        <div class="travelduration"></div>
    </div>

    <div class="item formplate">
        <h5>Airlines</h5>
        <div id="airlines">
            <div>
                <input type="checkbox" class="white" id="all_airlines">All airlines
            </div>
        </div>
    </div>

</div>

{{--<div class="sidebar">
    <div class="station"><span class="bold">Filter your results</span></div>
    <div class="station">

        <header><span>Stops</span></header>

        <label for="select_all" class="checkbox-inline">
            <input id="select_all"  type="checkbox" checked />
            Select All
        </label>

        <br />

        <label for="flight-stop-none" class="checkbox-inline">
            <input id="flight-stop-none"  type="checkbox" checked />Direct
        </label>

        <label for="flight-stop-one" class="checkbox-inline">
            <input id="flight-stop-one" type = "checkbox" checked />1 stop
        </label>

        <label for="flight-stop-two_plus" class="checkbox-inline">
            <input id="flight-stop-two_plus" type="checkbox" checked />2+ stops
        </label>

    </div>
    <div class="station">
        <header>Takeoff Times</header>
        <div class="slider_range">
            <div class="title">Outgoing Flight
                @if (Input::get('departure'))
                    from - {{ Input::get('departure') }}
                @endif
            </div>
            <div class="sections"><span id="takeoff_out_start" class="start"></span><span id="takeoff_out_end" class="end"></span></div>
            <div id="takeoff-out-range" class="range_div"></div>
        </div>

        @if( $round_trip )
        <div class="slider_range">
            <div class="title">Inbound Flight @if (Input::get('arrival')) from - {{ Input::get('arrival') }} @endif</div>
            <div class="sections"><span id="takeoff_in_start" class="start"></span><span id="takeoff_in_end"  class="end"></span></div>
            <div id="takeoff-in-range" class="range_div"></div>
        </div>
        @endif
    </div>
    <div  class="station drop_menu">
        <header>Price</header>
        <div class="slider_range">
            <div class="sections"><span id="price_start" class="start"></span><span id="price_end" class="end"></span></div>
            <div id="price-range" class="price_range_div"></div>
        </div>
    </div>
    <div class="station">
        <header>Stop Over Duration</header>
        <div class="slider_range">
            <div class="sections"><span id="stopover_duration_start" class="start"></span><span id="stopover_duration_end" class="end"></span></div>
            <div id="stopover-duration-range" class="time_range_div"></div>
        </div>
    </div>
    <div class="station">
        <header>Total Travel Duration</header>
        <div class="slider_range">
            <div class="sections"><span id="trip_duration_start" class="start"></span><span id="trip_duration_end" class="end"></span></div>
            <div id="trip-duration-range" class="time_range_div"></div>
        </div>
    </div>
    <div class="station">
        <header><span>Airlines</span></header>
        <label for="all_airlines" class="checkbox-inline"><input id="all_airlines" type="checkbox" checked />All airlines</label><br />
        <div id="airlines">
        </div>
    </div>
</div>--}}