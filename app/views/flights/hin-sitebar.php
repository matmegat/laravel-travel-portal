
<div class="jumbotron">
    <div class="container">
        <div class="col-md-4 search-sidebar">

            <div class="panel panel-info">
                <div class="panel-heading">
                    Price
                    <span id="price-amount" style="border: 0; color: #f6931f; font-weight: bold;"></span>
                </div>
                <div class="panel-body">
                    <div id="price-range"></div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    Stop types
                </div>
                <div class="panel-body">
                    <div>
                        <input id="flight-stop-none" type="checkbox"/>
                        <label for="flight-stop-none">
                            Direct
                            <span id="flight-stop-price-none"></span>
                        </label>
                    </div>
                    <div>
                        <input id="flight-stop-one" type="checkbox"/>
                        <label for="flight-stop-one">
                            One stop
                            <span id="flight-stop-price-one"></span>
                        </label>
                    </div>
                    <div>
                        <input id="flight-stop-two_plus" type="checkbox"/>
                        <label for="flight-stop-two_plus">
                            Two or more stops
                            <span id="flight-stop-price-two_plus"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    Takeoff
                </div>
                <div class="panel-body">
                    <div>
                        <legend id="takeoff-out-name">{{ Input::get('departure') }}</legend>
                        <span id="takeoff-out" style="border: 0; color: #f6931f; font-weight: bold;"></span>
                        <div id="takeoff-out-range"></div>
                    </div>

                    @if( $round_trip )
                    <div>
                        <legend id="takeoff-in-name">{{ Input::get('arrival') }}</legend>
                        <span id="takeoff-in" style="border: 0; color: #f6931f; font-weight: bold;"></span>
                        <div id="takeoff-in-range"></div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    Stopover Duration
                </div>
                <div class="panel-body">
                    <span id="stopover-duration" style="border: 0; color: #f6931f; font-weight: bold;"></span>
                    <div id="stopover-duration-range"></div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    Trip Duration
                </div>
                <div class="panel-body">
                    <span id="trip-duration" style="border: 0; color: #f6931f; font-weight: bold;"></span>
                    <div id="trip-duration-range"></div>
                </div>
            </div>
        </div>
    </div>
</div> 
