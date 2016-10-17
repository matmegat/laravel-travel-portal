@extends('layouts.travel')

@section('title')
Booking {{$product['Title']}} | Visits
@stop

@section('styles')
<style type="text/css">
    body {
        background: none;
    }
</style>
@stop

@section('content')
<div class="tour_details your_details">
	<header class="topper">
        <div class="">
            <div class="container">
                 <h1>{{$product['Title']}}</h1>
            </div>
            @if(count($product['Photos']) > 0)
            <img class="img-responsive" style="width:100%" src="{{$product['Photos'][0]['URL']}}"
                 data-thumb="{{$product['Photos'][0]['URL']}}" alt="{{$product['Photos'][0]['Title']}}"/>
            @endif
        </div>
    </header>
    <article>
        <div class="container">
            <div class="item">
            	<header>
	                <div class="leftie">
	                    <div>
	                        <h2>Your Details</h2>
	                    </div>
	                </div>
	                <div class="rightie">
	                    <h2>Your summary</h2>
	                </div>
	            </header>

	            <article>
		            <form id="product_order_form" method="post" class="form-horizontal"
	                              action="{{ action('ToursController@orderProduct', array('product' => $product['ID'], 'event_id' => $event['ID'], 'variation_id' => $variation['ID'], 'qty' => $qty)) }}">

		            	<div class="leftie user_info">
	                        <div class="row">
	                            <div class="col-lg-5 col-md-5 col-sm-6">
	                                {{ Form::label('email', 'Email Address', array('class' => '')) }}
	                            </div>
	                            <div class="col-lg-5 col-md-5 col-sm-6">
	                                {{ Form::email('email', Sentry::Check()?Sentry::getUser()->email:'', array('class' => 'form-control', 'required' => 'true', 'email' =>
	                                    'true')) }}
	                            </div>
	                        </div>

	                        <div class="row">
	                            <div class="col-lg-5 col-md-5 col-sm-6">
	                                {{ Form::label('firstname', 'First Name', array('class' => '')) }}
	                            </div>
	                            <div class="col-lg-5 col-md-5 col-sm-6">
	                                {{ Form::text('firstname', Sentry::Check()?Sentry::getUser()->first_name:'', array('class' => 'form-control', 'required' => 'true')) }}
	                            </div>
	                        </div>

	                        <div class="row">
	                            <div class="col-lg-5 col-md-5 col-sm-6">
	                               {{ Form::label('lastname', 'Last Name', array('class' => '')) }}
	                            </div>
	                            <div class="col-lg-5 col-md-5 col-sm-6">
	                                {{ Form::text('lastname', Sentry::Check()?Sentry::getUser()->last_name:'', array('class' => 'form-control', 'required' => 'true')) }}
	                            </div>
	                        </div>

	                        <div class="row">
	                            <div class="col-lg-5 col-md-5 col-sm-6">
	                                {{ Form::label('phone', 'Telephone', array('class' => '')) }}
	                            </div>
	                            <div class="col-lg-5 col-md-5 col-sm-6">
	                                <div class="input-group">
	                                    <span class="input-group-addon" id="lbl-phone-prefix"></span>
	                                    <input type="hidden" name="mobilephone[0]" id="ipt-phone-prefix" value=""/>
	                                    {{ Form::text('mobilephone[1]', Sentry::Check()?Sentry::getUser()->phone:'', array('class' => 'form-control phone')) }}
	                                </div>
	                            </div>
	                        </div>

	                        <div class="row">
	                            <div class="col-lg-5 col-md-5 col-sm-6">
	                                {{ Form::label('country', 'Country', array('class' => 'control-label col-lg-4')) }}
	                            </div>
	                            <div class="col-lg-5 col-md-5 col-sm-6">
	                                {{ Form::select('country', $countries, (Sentry::check() && Sentry::getUser()->country)?Sentry::getUser()->country:'AU', array('class' =>
	                                    'form-control', 'required' => 'true')) }}
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="col-lg-6 col-md-6 col-sm-6">

	                            	<script src="https://checkout.stripe.com/checkout.js"></script>

	                                <button id="payButton" class="btn btn-block btn-primary btn-lg">Pay for Tour</button>

	                                <script>
	                                    $form = $('#product_order_form');

	                                    var handler = StripeCheckout.configure({
	                                        key: "{{ $stripeKey }}",
	                                        image: '/img/visits-logo.png',
	                                        currency: 'aud',
	                                        token: function(token, args) {
	                                            $form.append($('<input>').attr({ type: 'hidden', name: 'stripeToken', value: token.id })).submit();
	                                        }
	                                    });

	                                    document.getElementById('payButton').addEventListener('click', function(e) {

	                                        e.preventDefault();

	                                        if ($form.valid()) {
	                                            handler.open({
	                                                name: 'Tour payment',
	                                                description: "{{{$product['Title']}}}",
	                                                amount: "{{$price * 100}}",
	                                                email: $form.find('#email').val()
	                                            });
	                                        }
	                                    });


	                                </script>





	                            </div>

	                        </div>
	                    </div>

	                    <div class="rightie">
		                    <ul class="info_tour_details">
		                        <li>
		                            <h3>Name</h3>
		                            <p>{{{$product['Title']}}}</p>
		                        </li>

		                        <li>
		                            <h3>Location</h3>
		                            <p>{{{$product['Location']}}}</p>
		                        </li>

		                        <li>
		                            <h3>Date</h3>
		                            <p>{{{ $event['Date'] }}}
		                                        @if( $event['Start'] && $event['End'] )
		                                        (from {{{$event['Start']}}} to {{{$event['End']}}})
		                                        @endif</p>
		                        </li>

		                        <li>
		                            <h3>QTY</h3>
		                            <p>{{{$qty}}}</p>
		                        </li>

		                        <li>
		                            <h3>Type</h3>
		                            <p>{{{$variation['InternalItemID']}}}</p>
		                        </li>


		                        <li class="total">
		                            <h3>Total Price</h3>
		                            <p>${{{$price}}} AUD</p>
		                        </li>
		                    </ul>
		                </div>
                </form>
	            </article>

                <div class="">


            <script>
                $('#product_order_form').validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        lastname: {
                            required: true,
                            minlength: 2
                        },
                        firstname: {
                            required: true,
                            minlength: 2
                        },
                        mobilephone: {
                            required: true,

                            minlength: 5
                        },
                        country: {
                            required: true
                        }
                    }
                });

            </script>


                    <script>
                        // TODO: Move out to the separate script file
                        var PHONES = {{ json_encode( Config::get('countries.phones') ) }};
                        $('.phone').mask("999 99?9 99 99");
                        $('#country').change(function(){
                            var code = $(this).val();

                            if( typeof PHONES[ code ] != 'undefined' ) {
                                $('#lbl-phone-prefix').html( '+' + PHONES[ code ] );
                                $('#ipt-phone-prefix').val( PHONES[ code ] );
                            } else {
                                $('#lbl-phone-prefix').html( '' );
                                $('#ipt-phone-prefix').val( '' );
                            }
                        });
                        $('#country').trigger('change');
                    </script>
                </div>
            </div>
        </div>
    </article>
</div>
@stop