@extends('layouts.travel')

@section('scripts')
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/mustache.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/underscore.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/moment.js') }}

{{ HTML::script(Config::get('cdn.asset_path') . 'js/app/form/hotels.js') }}

@stop

@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"/>
@stop

@section('topbar')


@section('title')
Searching Hotels
@stop

<div class="jumbotron">
    <div class="container">

        <div class="row">
            <div class="col-md-5 col-md-offset-1">

                @include('forms.hotels.search')

            </div>

            <div class="col-md-5">
                <h3>Here is a long text going far far away to 3 lines of this header and may be even further!</h3>

                <h5>
                    And here goes long text too, far far away to now alwady 4 lines of this header and no further.
                    Because it is set up so by design of this page.
                    This text is not so important, so it's done smaller than above.
                </h5>
            </div>
        </div>

    </div>
</div>

@stop

@section('content')

<div class="progress progress-striped active" id="hotels-progress">
    <div class="progress-bar" role="progressbar" id="hotels-progress-bar">
        <span class="sr-only">Search in progress</span>
    </div>
</div>

<script>
    window.HOTELS_SEARCH_TIME_LEFT = {{ $time_left}} * 1000;
</script>
<div class="row">
    <div class="col-md-8">

        <div id="result-box" style="padding-top: 20px;">
            @include('hotels.update-results')
        </div>

    </div>

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

        <div class="panel panel-info stars">
            <div class="panel-heading">
                Stars
            </div>
            <div class="panel-body">
                <div><input name="stars5" value="5" type="checkbox"/><span class="star" data-score="5"></span></div>
                <div><input name="stars4" value="4" type="checkbox"/><span class="star" data-score="4"></span></div>
                <div><input name="stars3" value="3" type="checkbox"/><span class="star" data-score="3"></span></div>
                <div><input name="stars2" value="2" type="checkbox"/><span class="star" data-score="2"></span></div>
                <div><input name="stars1" value="1" type="checkbox"/><span class="star" data-score="1"></span></div>
            </div>
        </div>

        <div class="panel panel-info property_type">
            <div class="panel-heading">
                Accommodation Type
            </div>
            <div class="panel-body">
                <div>
                    <input class="js-checkbox-filter" name="property_type1" value="1" type="checkbox"/>
                    <span>Hotel</span>
                </div>
                <div><input class="js-checkbox-filter" name="property_type2" value="2" type="checkbox"/>
                    <span>Hostel</span>
                </div>
                <div><input class="js-checkbox-filter" name="property_type3" value="3" type="checkbox"/>
                    <span>Bed and breakfast</span>
                </div>
                <div><input class="js-checkbox-filter" name="property_type4" value="4" type="checkbox"/>
                    <span>Apartment</span>
                </div>
                <div><input class="js-checkbox-filter" name="property_type5" value="5" type="checkbox"/>
                    <span>Resort</span>
                </div>
                <div><input class="js-checkbox-filter" name="property_type6" value="6" type="checkbox"/>
                    <span>Villa</span>
                </div>
                <div><input class="js-checkbox-filter" name="property_type7" value="7" type="checkbox"/>
                    <span>Motel</span>
                </div>
            </div>
        </div>

        <div class="panel panel-info amenities">
            <div class="panel-heading">
                Hotel Amenities
            </div>
            <div class="panel-body">
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="8">
                    <span class="filters-options-text grey">Pet-friendly</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="20">
                    <span class="filters-options-text">Bar/Lounge</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="15">
                    <span class="filters-options-text grey">Breakfast Buffet</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="14">
                    <span class="filters-options-text">Casino</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="12">
                    <span class="filters-options-text">Business Centre</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="7">
                    <span class="filters-options-text">Non-smoking Rooms</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="6">
                    <span class="filters-options-text">Airconditioning</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="9">
                    <span class="filters-options-text">Safe/Vault</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="10">
                    <span class="filters-options-text">Babysitting/Child Services</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="19">
                    <span class="filters-options-text grey">Fitness Centre</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="1">
                    <span class="filters-options-text">Highspeed Internet</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="13">
                    <span class="filters-options-text grey">Car Rental</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="3">
                    <span class="filters-options-text">Parking</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="2">
                    <span class="filters-options-text">Swimming Pool</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="4">
                    <span class="filters-options-text">Restaurant</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="11">
                    <span class="filters-options-text">Meeting/Banquet Facilities</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="18">
                    <span class="filters-options-text">Spa &amp; Wellness Centre</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="17">
                    <span class="filters-options-text">Golfcourse</span>
                </div>
                <div>
                    <input class="js-checkbox-filter" name="amenity_ids[]" type="checkbox" value="5">
                    <span class="filters-options-text">Facilities for Disabled</span>
                </div>
            </div>
        </div>

    </div>
</div>

@stop