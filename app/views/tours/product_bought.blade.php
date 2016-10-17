@extends('layouts.travel')

@section('title')
Booking {{$product['Title']}} | Visits
@stop


@section('content')

<div class="tour_details your_details">


    	<header class="topper">
	        <div class="">
	            <div class="container">
	                  <h1><strong>Congratulations!</strong> You successfully bought {{$product['Title']}}!</h1>
        			<small>{{$product['Location']}}</small>
	            </div>
	            @if(count($product['Photos']) > 0)

                <img class="img-responsive" style="width:100%" src="{{$product['Photos'][0]['URL']}}"
                         data-thumb="{{$product['Photos'][0]['URL']}}" alt="{{$product['Photos'][0]['Title']}}"/>

                @endif
	        </div>
	    </header>
	    <article>
	    	<div class="container">
	    		<header>
	                <div class="leftie">
	                    <div>
	                        <h2>Your order information:</h2>
	                    </div>
	                </div>
	                <div class="rightie">
	                    <h2>Total: {{ $total }}</h2>
	                </div>
	            </header>
	            <article>
	            	<div class="leftie user_info">
	            		@foreach ($orderItems as $item)
		                        <h3>Name</h3>
		                        <p>{{{ $item['variation']['InternalItemID'] }}}</p>

		                        <h3>Price</h3>
		                        <p>${{{ $item['item']['UnitPrice'] }}} AUD</p>

		                        <h3>Quantity</h3>
		                        <p>{{{ $item['item']['Quantity'] }}}</p>

		                    @if (!empty($item['variation']['LocalFeeTitle']))

		                        <h3>Local Fee Title</h3>
		                        <p>{{{ $item['variation']['LocalFeeTitle'] }}}</p>

		                        <h3>Local Fee {{{ $item['variation']['LocalFeeAddedToOrder'] ? '(in package)' : '' }}}</h3>
		                        <p>${{{ $item['variation']['LocalFee'] }}} AUD</p>
		                    @endif

		                    	<h3>Date</h3>
		                    	<p>{{{ $event['Date'] }}}
		                            @if( $event['Start'] && $event['End'] )
		                            (from {{{$event['Start']}}} to {{{$event['End']}}})
		                            @endif</p>


							@if (!empty($event['Description']))
		                    	<h3>Description</h3>
		                    	<p>{{{ $event['Description'] }}}</p>
		                	@endif

	                	@endforeach





			    	</div>
			    	<div class="rightie">

			    			<ul class="info_tour_details">
			    				<li>
			    					<h3>Order ID</h3>
			    					<p>{{{$order['ExternalOrderID']}}}</p>
			    				</li>
			    				<li>
			    					<h3>Status</h3>
			    					<p>PAID</p>
			    				</li>
			    			</ul>



			    	</div>
	            </article>
	    	</div>

	    </article>




</div>








@stop