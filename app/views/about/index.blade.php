@extends('layouts.travel')

@section('title')
About | Visits
@stop

@section('promo')
<div class="hero  hero--page  hero--diving">
    <div class="container">
        <h1 class="hero__title">{{$info->title}}</h1>
    </div>
</div>
@stop

@section('content')

<div class="page-background nointro" style="background-image: url(img/header-bg/about-page.jpg)">
	<div class="container">
		<h1>{{ $info->title }}</h1>
	</div>
</div>

<div class="main-body">

	<div class="container about-page">
		<div class="row">
			<div class="col-md-6">
				<p class="intro">{{html_entity_decode($info->content)}}</p>

				<span class="line"></span>

				<p><strong>How do I get to Airlie Beach for the Visits Tour?</strong><br/>
				The best way to travel to Airlie Beach would be a domestic flight from Cairns, Brisbane, Sydney or Melbourne with 1 flight daily into one of Whitsunday’s 2 airports.

Whitsunday Coastal Airport about 30 minutes drive or Taxi to Airlie Beach and Hamilton Island Airport about 1 hour ferry to Airlie Beach.

The ferries have set timetables so be sure to arrange your flights and transfers carefully with other scheduled activities.</p>

				<p><strong>Getting around Airlie Beach</strong><br/>
				Airlie Beach is a very small town so you will have everything you need within 3km.  Try to book your accommodation close to the main street if you do not have a car, you will have everything from shopping, markets, restaurants, bottle shops and tour meeting points at your fingertips. There are many places to hire scooters and cars although parking is not easy at most accommodation places and unless you are staying a little bit out of town you won’t need one.

Visits Diving adventures check in office is located in the main street only 2km walk to the meeting point.

Visits Adventure park pick up and drop off is just at the top of the main street so it’s all too easy.</p>

				<p><strong>Should I book in advance?</strong><br/>
				Yes it is always a good idea to book at least two weeks in advanced so that you don’t miss out especially if you are not flexible with your travel dates. The industry has peak and low seasons as seen by our rates. Peak season is October through to March and Low is April through to September.

Visits Diving Adventures is very popular and can be booked out for two weeks in advanced in the low season and up to a month in the peak season.

Don’t miss out! Secure your booking as soon as you can.</p>

				<p><strong>What types of boats are available?</strong><br/>
				Visits Diving Adventures have two Sailing Catamarans fitted with all the diving gear. Catamarans are wide and therefore stable on the water making for a comfortable journey through all kinds of weather. This means less chance of seasickness and less chance of being cancelled due to poor weather conditions.

There are many varieties of vessels to suit the traveller such as: Maxi Yachts, Cruising Yachts, Tall ships, Catamarans, Sailing and diving catamarans, party boats and luxury Boats.</p>

				<p><strong>Choosing your tour</strong><br/>
				You will need to have an idea of how long you would like to spend on a boat first all and the dates you are putting aside for touring Airlie beach. The next step would be to list your preferred boats and then find out what you want to see and do during your tour.

There is a tour and Itinerary to suit everyone, just be sure to know what you want and then let us point you in the best direction.</p>

				<span class="line"></span>

				<h3>Call Us Today</h3>
				<h4>1300 859 853<br>(+617) 4948 2037</h4>

				<a href="http://visits.com.au" class="button">View Tours</a>
				<a href="http://visits.com.au/contact" class="button yellow">Enquire Now</a>

			</div>

			<div class="col-md-6">

				<img src="img/base64/australia-map-photo.png" alt="We Are Here" class="responsive">

				<h3>Where is Airlie Beach?</h3>

				<p>Visits Diving Adventures offers the best overnight Whitsundays Sailing tours, with years of award winning experience treating guests to fully crewed Whitsunday sailing tours.</p>

				<h3>Award winning tours</h3>

				<p>Visits Diving Adventures offers the best overnight Whitsundays Sailing tours, with years of award winning experience treating guests to fully crewed Whitsunday sailing tours.</p>

				<p>Cruises departing from Airlie Beach, the gateway to the Whitsunday Islands and the Outer Great Barrier Reef. The tours take you sailing around the Whitsundays and includes a visit to Whitehaven Beach.</p>

				<img src="img/base64/awards-watermarks.png" alt="Awards" class="responsive">

			</div>

		</div>
	</div>

</div>

@stop
