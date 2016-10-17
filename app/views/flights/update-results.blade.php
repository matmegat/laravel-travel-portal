
<script>
    FLIGHTS_ROUTES = {};
    FLIGHTS_SEARCH_URL = '{{action("FlightsController@searchResults", @$params)}}';
    FLIGHTS_UPDATE_URL = '{{action("FlightsController@updateResults", @$params)}}';
    @if(isset($user_filters))
        FLIGHTS_SEARCH_DATA = {{json_encode($user_filters)}};
    @endif

    @if(isset($filters))
        FLIGHTS_SEARCH_FILTERS = {{json_encode($filters)}};
    @endif

    $(function(){
        //updateFlightFilters(window.FLIGHTS_SEARCH_FILTERS);

        @if( count($paginator) )
            @if( $time_left <= 15)
                //waitingForFare({{$time_left}});
            @else
                //hideProgressBar();
            @endif
        @endif
    });
</script>

@if( @$paginator )
    <div class="row flight-result-filter">
        @if( count($paginator) )
            <div class="col-xs-7 col-md-6"><p>Showing {{count($paginator)}} of {{ $paginator->appends(Input::except('page'))->getTotal() }} results</p></div>
            <div class="col-xs-5 col-md-6"><a href="#" class="price-filter">Price Ascending</a></div>
        @else
            <div class="col-xs-7 col-md-6"><p>Showing 0 of 0 results</p></div>
            <div class="col-xs-5 col-md-6">No flights found...</div>
        @endif
    </div>
    @foreach( $paginator as $routeKey => $item)
        @include('flights.parts.fares')
    @endforeach
@else
    <div class="results_header">Showing <strong>0</strong> of <strong>0</strong> results<span class="price">Price</span></div>

    <div class="alert alert-info">
        We're searching for flights right now, it will take just few seconds, be patient!
        <script>
            $(function() {
                updateFlightResults();
            });
        </script>
    </div>

@endif

    {{--<div class="row flight-result-filter">
        <div class="col-xs-7 col-md-6"><p>Showing 10 of 30 results</p></div>
        <div class="col-xs-5 col-md-6"><a href="#" class="price-filter">Price Accending</a></div>
    </div>

    <div class="row flight-overview">
        <div class="col-xs-7 col-md-9 flight-name">
            <img src="img/flights/virgin.png" alt="virgin" class="responsive">
            <h5>Adelaide</h5>
            <p>2 Stops</p>
        </div>
        <div class="col-xs-3 col-md-2 flight-rate">
            <p>Best Rate p.p</p>
            <h3>$776</h3>
        </div>
        <div class="col-xs-2 col-md-1 show-more"><a href="#" class="flight-more-trigger">Info</a></div>
    </div>
    <div class="row flight-details">

        <div class="col-xs-12">
            <div class="row intro">
                <div class="col-sm-6"><h5>Outbound Details</h5></div>
                <div class="col-sm-6"><p>Total Duration: 9h45m</p></div>
            </div>
            <div class="row itinerary">
                <div class="col-md-2">
                    <img src="img/flights/virgin-small.png" alt="virgin" class="responsive">
                    <h5>VA204</h5>
                </div>
                <div class="col-md-3">
                    <h5>Sat 6 Dec, 06:05</h5>
                    <p>Departs from Adelaide (ADL)</p>
                </div>
                <div class="col-md-2">
                    <span class="flyicon"></span>
                </div>
                <div class="col-md-3">
                    <h5>Sat 6 Dec, 07:55</h5>
                    <p>Arrives at Melbourne (MEL)</p>
                </div>
                <div class="col-md-2">
                    <span class="duration">1hr 20min</span>
                </div>
            </div>
            <div class="row layover">
                <div class="col-md-12">
                    <h5>Layover in Melbourne 1hr30min</h5>
                </div>
            </div>
            <div class="row itinerary">
                <div class="col-md-2">
                    <img src="img/flights/virgin-small.png" alt="virgin" class="responsive">
                    <h5>VA204</h5>
                </div>
                <div class="col-md-3">
                    <h5>Sat 6 Dec, 06:05</h5>
                    <p>Departs from Adelaide (ADL)</p>
                </div>
                <div class="col-md-2">
                    <span class="flyicon"></span>
                </div>
                <div class="col-md-3">
                    <h5>Sat 6 Dec, 07:55</h5>
                    <p>Arrives at Melbourne (MEL)</p>
                </div>
                <div class="col-md-2">
                    <span class="duration">1hr 20min</span>
                </div>
            </div>
            <div class="row booknow">
                <div class="col-md-12">
                    <a href="#">Book Now</a>
                </div>
            </div>

        </div>

    </div>--}}


    {{--@if(@$invalid) })
        <div class="results_header">Showing <strong>0</strong> of <strong>0</strong> results<span class="price">Price</span></div>

        <div class="alert alert-danger">
            No flights found...
        </div>
    @else
        @if( @$paginator )

            @if( count($paginator) )
                <div class="results_header">Showing <strong>{{count($paginator)}}</strong> of <strong>{{ $paginator->appends(Input::except('page'))->getTotal() }}</strong> results<span class="price">Price <img src="/img/icons/sort.png" class="{{ (!is_object($user_filters) && isset($user_filters['order']) && $user_filters['order'] == 'desc')? 'price_rotate' : '' }}"></span></div>
                @foreach( $paginator as $routeKey => $item)
                    @include('flights.parts.fares')
                @endforeach
            @else
                <div class="results_header">Showing <strong>0</strong> of <strong>0</strong> results<span class="price">Price</span></div>

                <div class="alert alert-danger">
                    No flights found..
                </div>
                <script>
                    stopWatingForFare();
                </script>

            @endif
        @else
            <div class="results_header">Showing <strong>0</strong> of <strong>0</strong> results<span class="price">Price</span></div>

            <div class="alert alert-info">
                We're searching for flights right now, it will take just few seconds, be patient!
            </div>
            <script>
                $(function(){
                    updateFlightResults('');
                });
            </script>
        @endif
    @endif--}}

@if( @$paginator )
    {{ $paginator->appends(Input::except('page'))->links() }}
@endif
