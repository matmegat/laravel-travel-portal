@extends('layouts.travel')

@section('title')
    Home | Visits
@stop

@section('scripts')
    {{ HTML::script(Config::get('cdn.asset_path') . 'js/app/home.js') }}

    <script>
        $(document).ready(function () {
            $('.flight-more-trigger').on('click', function () {
                $(this).parent().parent().next().toggle(100);
                return false;
            });
        });
    </script>
    @if (!empty($flightSearch['search_id']) && !empty($flightSearch['trip']['id']))
        <script>
            /*(function($){
             updateResults(
             "{{ action('HomeController@flightsTab', array('search_id' => $flightSearch['search_id'], 'trip_id' => $flightSearch['trip']['id'])) }}",
             "flights_results"
             );
             })(jQuery);*/
        </script>
    @endif
@stop

@section('content')

    <div class="home-slider">
        <ul class="slides-container">
            <li>
                <img src="{{ asset('img/slider-home/diving2.jpg') }}" alt="">

                <div class="slide-content diving">
                    <span></span>

                    <h2>Sail and Snorkel</h2>

                    <p>
                        Swim amongst the Dugongs, reef sharks and sea turtles on a Visits Great Barrier Reef adventure.
                    </p>
                </div>
            </li>
            <li>
                <img src="{{ asset('img/slider-home/adventure.jpg') }}" alt="">

                <div class="slide-content adventure">
                    <span></span>

                    <h2>Mini 4WD Tour</h2>

                    <p>
                        Visits will take you exploring the amazing Whitsunday hinterland and mud pit challenge in a mini
                        4WD.
                    </p>
                </div>
            </li>
            <li>
                <img src="{{ asset('img/slider-home/australia.jpg') }}" alt="">

                <div class="slide-content australia">
                    <span></span>

                    <h2>Australia Tours</h2>

                    <p>
                        The incredible natural environment of Australia has always been important to its inhabitants.
                    </p>
                </div>
            </li>
        </ul>
        <nav class="slides-navigation">
            <a href="#" class="next">Next</a>
            <a href="#" class="prev">Previous</a>
        </nav>
    </div>

    <div class="main-body">

        <div class="container home-tabs">
            <div class="row">
                <a class="col-xs-4 tab active" href="#tours">Quick Search Tours</a>
                @if (count($toursAustralia) > 0)
                <a class="col-xs-4 tab" href="#tours_australia">Australia Tours</a>
                @endif
                @if (count($toursSale) > 0)
                <a class="col-xs-4 tab" href="#tours_on_sale">Tours On Sale</a>
                @endif
            </div>
        </div>

        <div class="container home-tab-content">
            <div class="row">
                <div class="col-xs-12 tab active" id="tours">
                    @include('home.tabs.tours')
                </div>
                <div class="col-xs-12 tab" id="tours_australia">
                    @include('home.tabs.tours_australia')
                </div>
                <div class="col-xs-12 tab" id="tours_on_sale">
                    @include('home.tabs.tours_on_sale')
                </div>
            </div>

        </div>

        <div class="container the-content">
            <div class="col-md-12">
                <h3>What is Visits?</h3>
            </div>
            <div class="col-md-6">
                <p>Visits Whitsunday Adventures is an Australian owned and operated, multi award winning advanced Eco
                    certified tour operator. Based in Airlie Beach, Queensland, providing the
                    perfect access point for Whitsunday Island holiday adventures and Whitsunday Hinterland tours
                    maintaining our environment with advanced methods designed to minimise environmental
                    impact.</p>

                    <p>Visits operates sailing, snorkelling, and mini 4WD tours around the Whitsundays. Travel
                    to Whitehaven Beach and explore the beautiful white sands, swim amongst the aquatic wildlife,
                    sail across Australia's magnificent blue waters, visit the adventure park for scenic trails and
                    loads of fun in the mud.</p>

                <p>Stop dreaming about a tropical island getaway and actually get on board a Visits Sailing Adventure.
                    Learn sailing on luxury catamaran with the help of Visits' friendly crew, or relax on board, enjoying
                    catered meals, hot showers and a surround sound entertainment system. </p>
            </div>
            <div class="col-md-6">
                <p>Visits Whitsunday Islands adventures offer the best in snorkelling and sailing adventures. Visiting
                    Whitehaven Beach, you can discover the iconic white sands which have become famous across the world
                    as the epitome of tropical escape.</p>

                <p>Snorkel amongst the unique aquatic wildlife of Australia’s natural wonder, the Great Barrier Reef.
                    Snorkelling is available on all tours, so everyone can discover the magic of Great Barrier Reef.</p>

                <p>The Whitsunday Tourism Awards are the region’s premier tourism event, established to pay tribute to
                    the enormous contribution made by the region’s tourism operators and service providers and to
                    encourage excellence within the Whitsunday tourism industry. Visits has won awards twice: 2010
                    Adventure Tourism and 2011 Steve Irwin Ecotourism Award.</p>

            </div>
        </div>

    </div>

@stop