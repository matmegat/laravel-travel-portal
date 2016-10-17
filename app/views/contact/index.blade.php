@extends('layouts.travel')

@section('title')
Contact | Visits
@stop

@section('content')

<div class="page-background nointro" style="background-image: url(img/header-bg/contact.jpg)">
	<div class="container">
		<h1>Contact Visits</h1>
	</div>
</div>

<div class="main-body">

	<div class="container about-page contact-page">
		<div class="row">
			<div class="col-md-6">
                @if(Session::has('success'))
                    <div class="contact alert alert-success">
                        <strong>Success!</strong> {{ Session::get('message') }}
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="contact alert alert-error">
                        <strong>Error!</strong> {{ Session::get('message') }}
                    </div>
                @endif
				<p class="intro">{{$page->text_preview}}</p>

                {{ Form::open(array('url' => action('ContactController@sendContactForm'), 'method' => 'post', 'class' => 'formplate body-form contact-form', 'role' => 'form')) }}

                    <input type="hidden" name="send_email" value="{{$page->email}}">

					<label>First Name</label>
					<input type="text" name="firstname" id="firstname">

					<label>Last Name</label>
					<input type="text" name="lastname" id="lastname">

					<label>Phone Number</label>
					<input type="tel" name="phone" id="phone">

					<label>Email Address</label>
					<input type="email" name="email" id="email">

					<label>I'm Interested In</label>
					<div class="row">
						<div class="col-xs-12">
							<select name="cat" >
		                        <option>-- Select Interest --</option>
		                        <option {{ (Input::has('guests') && 1 == Input::get('guests'))? 'selected' : ''}}>Diving &amp; Sailing</option>
                                <option {{ (Input::has('guests') && 2 == Input::get('guests'))? 'selected' : ''}}>Mini 4WD Tour</option>
                                <option {{ (Input::has('guests') && 3 == Input::get('guests'))? 'selected' : ''}}>Australia Tours</option>
                                <option {{ (Input::has('guests') && 4 == Input::get('guests'))? 'selected' : ''}}>Hotels</option>
                                <option {{ (Input::has('guests') && 5 == Input::get('guests'))? 'selected' : ''}}>Flights</option>
		                    </select>
		                </div>
						<div class="col-xs-6">
							{{Form::text('check_in','', array('class' => 'datepicker', 'id' => 'hotels_from', 'placeholder' => 'Start date', 'data-date-format' => "dd.mm.yyyy")) }}
						</div>
						<div class="col-xs-6">
							{{Form::text('check_out','', array('class' => 'datepicker', 'id' => 'hotels_to', 'placeholder' => 'End date', 'data-date-format' => "dd.mm.yyyy")) }}
						</div>
					</div>
					<label>Number of People</label>
					<div class="input-number-contain">
						<span class="input-number-decrement">–</span>
						<input class="input-number" name="number" type="text" value="1" min="0" max="50">
						<span class="input-number-increment">+</span>
					</div>

					<label>Comments</label>
					<textarea name="comments" rows="5"></textarea>

					<input type="submit" value="Submit" class="">

				{{ Form::close() }}

			</div>

			<div class="col-md-6">
				<div class="map" id="map_canvas">
                    <!--<iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            src="https://maps.google.com/?ie=UTF8&amp;t=m&amp;ll=-20.2690024,148.720316&amp;spn=0.04554,0.072956&amp;z=16&amp;output=embed"></iframe>-->
                </div>

                <h5>We’re Located At</h5>
				<p class="intro located">{{$page->address}}<br>{{$page->city}}</p>

				<span class="line"></span>

				<h3>Call Us Today</h3>
				<h4>{{$page->phone}}<br>{{$page->add_phone}}</h4>

				<a href="http://visits.com.au" class="button">View Tours</a>
				<a href="http://visits.com.au/contact" class="button yellow">Enquire Now</a>

			</div>

		</div>

		<script type="text/javascript">
            function toggleEventMap(idx) {
                var loc = $('#location-event-'+idx).html();
                var container = $('#tr-event-'+idx);
                var day = $('#day-event-'+idx);
                var map_canvas = 'map-event-'+idx;
                var rowspan = $('.rowspan-event-'+idx);

                var more_info = $('#more-info-'+idx);
                var reg = $('#reg-'+idx);

                container.toggle();

                if( container.is(':visible') ) {
                    more_info.text("LESS INFO");
                    rowspan.attr('rowspan', 2);

                    day.addClass('active-day-td');
                    reg.addClass('active-reg');

                    if( !$('#' + map_canvas).attr('loaded') )
                    {
                        $('#' + map_canvas).attr('loaded', true);

                        var mapOptions = {
                            zoom: 14,
                            center: new google.maps.LatLng(0,0),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        }
                        var map = new google.maps.Map(document.getElementById(map_canvas), mapOptions);
                        var geocoder = new google.maps.Geocoder();

                        geocoder.geocode({ 'address': loc}, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                map.setCenter(results[0].geometry.location);

                                var marker = new google.maps.Marker({
                                    map: map,
                                    position: results[0].geometry.location
                                });
                            } else {
                                $(map_canvas).hide();
                                //alert("Geocode was not successful for the following reason: " + status);
                            }
                        });
                    }
                } else {
                    more_info.text("MORE INFO");
                    rowspan.attr('rowspan', 1);
                    day.removeClass('active-day-td');
                    reg.removeClass('active-reg');
                }
            }

            var hasLocation = 'true';
            var userLocation = '{{$page->country}}, {{$page->city}},{{$page->address}}';

            function initialize() {
                if (!hasLocation) {
                    $('#map_canvas').hide();
                }

                var mapNewStyles =
                    [
                        {
                            "featureType": "water",
                            "stylers": [
                              { "color": "#fcd655" }
                            ]
                        },
                        {
                            "featureType": "poi.park",
                            "elementType": "geometry",
                            "stylers": [
                              { "color": "#eccd68" }
                            ]
                        },
                        {
                            "featureType": "landscape.man_made",
                            "stylers": [
                              { "color": "#e9e1c2" }
                            ]
                        },
                        {
                            "featureType": "landscape.natural",
                            "stylers": [
                              { "color": "#ede6cc" }
                            ]
                        },
                        {
                            "featureType": "poi.business",
                            "elementType": "geometry",
                            "stylers": [
                              { "color": "#e0d8b8" }
                            ]
                        },
                        {
                            "featureType": "road.local",
                            "elementType": "geometry.fill",
                            "stylers": [
                              { "weight": 2 }
                            ]
                        },
                    ];


                var mapOptions = {
                    zoom: 16,
                    center: new google.maps.LatLng(0,0),
                    panControl: true,
                    zoomControl: true,
                        zoomControlOptions: {
                          style: google.maps.ZoomControlStyle.LARGE
                        },
                    scaleControl: true,
                    styles: mapNewStyles,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
                var geocoder = new google.maps.Geocoder();

                geocoder.geocode({ 'address': userLocation}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location
                        });
                    } else {
                        $('#map_canvas').hide();
                    }
                });
            }

        </script>

        @section('scripts')
            {{ HTML::script(Config::get('cdn.asset_path') . 'js/app/form/travel.js') }}
        @stop

        <script
            src="//maps.googleapis.com/maps/api/js?key=AIzaSyA0rhg1SdrzK6p9klHh0S09mF1wuSGqSuU&sensor=false&callback=initialize"
            type="text/javascript">
        </script>

	</div>

</div>

{{--<div class="contact">
    <div class="header">
        <div class="container">
            <div class="text">
                <h2>Contact Visits</h2>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-6 contact_left">

                <p>{{$page->text_preview}}</p>

                <br>


                {{ Form::open(array('url' => action('ContactController@sendContactForm'), 'method' => 'post', 'class' => 'form-vertical contact-form', 'role' => 'form')) }}

                <input type="hidden" name="send_email" value="{{$page->email}}">

                <div class="form-group">
                    <label for="firstname" class="control-label">FIRST NAME</label>
                    <input type="text" name="firstname" class="form-control input-lg" id="firstname"/>
                </div>

                <div class="form-group">
                    <label for="lastname" class="control-label">LAST NAME</label>
                    <input type="text" name="lastname" class="form-control input-lg" id="lastname"/>
                </div>

                <div class="form-group">
                    <label for="phone" class="control-label">PHONE NUMBER</label>
                    <input type="text" name="phone" class="form-control input-lg" id="phone"/>
                </div>

                <div class="form-group">
                    <label for="email" class="control-label">EMAIL ADDRESS</label>
                    <input type="text" name="email" class="form-control input-lg" id="email"/>
                </div>


                <div class="form-group interested_in">
                    <label for="interest" class="control-label">I'M INTERESTED IN...</label>
                    <div class="row">
                        <div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('check_in','', array('class' => 'date form-control input-lg', 'id' => 'hotels_from', 'placeholder' => 'Start Date', 'data-date-format' => "dd.mm.yyyy")) }}
                        </div>
                        <div class=" col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            {{Form::text('check_out','', array('class' => 'date form-control input-lg', 'id' => 'hotels_to', 'placeholder' => 'End Date', 'data-date-format' => "dd.mm.yyyy")) }}
                        </div>
                    </div>
                </div>



                <div class="form-group drop_menu">
                    <select name="guests" class="form-control input-lg">
                        <option>-- select interest --</option>
                        <option class = "dropdown_item" {{ (Input::has('guests') && 1 == Input::get('guests'))? 'selected' : ''}}>Diving & Sailing</option>
                        <option class = "dropdown_item" {{ (Input::has('guests') && 2 == Input::get('guests'))? 'selected' : ''}}>Adventure Park</option>
                        <option class = "dropdown_item" {{ (Input::has('guests') && 3 == Input::get('guests'))? 'selected' : ''}}>Australia Tours</option>
                        <option class = "dropdown_item" {{ (Input::has('guests') && 4 == Input::get('guests'))? 'selected' : ''}}>Hotels</option>
                        <option class = "dropdown_item" {{ (Input::has('guests') && 5 == Input::get('guests'))? 'selected' : ''}}>Flights</option>
                    </select>
                </div>

                <div class="form-group">
                    <div class="col-lg-3 col-md-2 col-sm-3 col-xs-5 no-people">
                        <label for="number" class="control-label">NO. PEOPLE</label>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                        <input type="text" name="number" class="form-control input-lg"/>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="form-group contact_left_comment">
                    <label for="comments" class="control-label">COMMENTS</label>
                    <textarea name="comments" rows="5"  class="form-control input-lg"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">SUBMIT</button>
                {{ Form::close() }}

        </div>
        <div class="contact_right col-md-5 col-md-offset-1">
            <div class="right">
                <div class="well" style="height:691px" id="map_canvas"></div>
                <div class="text">
                    <div class="up">
                        <p><b>We’re Located At</b><br/>
                        <span>{{$page->address}}</span><br/>
                        <span>{{$page->city}}</span><br/>
                        </p>
                    </div>
                    <hr/>
                    <div class="down">
                        <p>Call Us Today<br/>
                            <span class="numbers">{{$page->phone}}</span><br/>
                            <span class="numbers">{{$page->add_phone}}</span><br/>
                        </p>
                    </div>
                </div>
                <div class='footer'>
                    <a href="http://visits.com.au"><button type="button" class="btn btn-primary btn-lg">View tours</button></a>
                    <a href="http://visits.com.au/contact"><button type="button" class="btn btn-primary btn-lg">ENQUIRE NOW</button></a>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            function toggleEventMap(idx) {
                var loc = $('#location-event-'+idx).html();
                var container = $('#tr-event-'+idx);
                var day = $('#day-event-'+idx);
                var map_canvas = 'map-event-'+idx;
                var rowspan = $('.rowspan-event-'+idx);

                var more_info = $('#more-info-'+idx);
                var reg = $('#reg-'+idx);

                container.toggle();

                if( container.is(':visible') ) {
                    more_info.text("LESS INFO");
                    rowspan.attr('rowspan', 2);

                    day.addClass('active-day-td');
                    reg.addClass('active-reg');

                    if( !$('#' + map_canvas).attr('loaded') )
                    {
                        $('#' + map_canvas).attr('loaded', true);

                        var mapOptions = {
                            zoom: 14,
                            center: new google.maps.LatLng(0,0),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        }
                        var map = new google.maps.Map(document.getElementById(map_canvas), mapOptions);
                        var geocoder = new google.maps.Geocoder();

                        geocoder.geocode({ 'address': loc}, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                map.setCenter(results[0].geometry.location);

                                var marker = new google.maps.Marker({
                                    map: map,
                                    position: results[0].geometry.location
                                });
                            } else {
                                $(map_canvas).hide();
                                //alert("Geocode was not successful for the following reason: " + status);
                            }
                        });
                    }
                } else {
                    more_info.text("MORE INFO");
                    rowspan.attr('rowspan', 1);
                    day.removeClass('active-day-td');
                    reg.removeClass('active-reg');
                }
            }

            var hasLocation = 'true';
            var userLocation = '{{$page->country}}, {{$page->city}},{{$page->address}}';

            function initialize() {
                if (!hasLocation) {
                    $('#map_canvas').hide();
                }

                var mapNewStyles =
                    [
                        {
                            "featureType": "water",
                            "stylers": [
                              { "color": "#fcd655" }
                            ]
                        },
                        {
                            "featureType": "poi.park",
                            "elementType": "geometry",
                            "stylers": [
                              { "color": "#eccd68" }
                            ]
                        },
                        {
                            "featureType": "landscape.man_made",
                            "stylers": [
                              { "color": "#e9e1c2" }
                            ]
                        },
                        {
                            "featureType": "landscape.natural",
                            "stylers": [
                              { "color": "#ede6cc" }
                            ]
                        },
                        {
                            "featureType": "poi.business",
                            "elementType": "geometry",
                            "stylers": [
                              { "color": "#e0d8b8" }
                            ]
                        },
                        {
                            "featureType": "road.local",
                            "elementType": "geometry.fill",
                            "stylers": [
                              { "weight": 2 }
                            ]
                        },
                    ];


                var mapOptions = {
                    zoom: 16,
                    center: new google.maps.LatLng(0,0),
                    panControl: true,
                    zoomControl: true,
                        zoomControlOptions: {
                          style: google.maps.ZoomControlStyle.LARGE
                        },
                    scaleControl: true,
                    styles: mapNewStyles,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
                var geocoder = new google.maps.Geocoder();

                geocoder.geocode({ 'address': userLocation}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                            icon: "img/map_icon.png"
                        });
                    } else {
                        $('#map_canvas').hide();
                        //alert("Geocode was not successful for the following reason: " + status);
                    }
                });
            }

        </script>

        @section('scripts')
            {{ HTML::script(Config::get('cdn.asset_path') . 'js/app/form/travel.js') }}
        @stop

        <script
            src="//maps.googleapis.com/maps/api/js?key=AIzaSyA0rhg1SdrzK6p9klHh0S09mF1wuSGqSuU&sensor=false&callback=initialize"
            type="text/javascript"></script>

    </div>


</div>--}}
@stop
