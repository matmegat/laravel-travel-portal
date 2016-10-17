@extends('layouts.travel')

@section('title')
Booking Tour {{$tour['name']}}
@stop

@section('content')

<div class="page-background nointro">
    <div class="container">
        <h1>Book Tour</h1>
    </div>
</div>

<div class="main-body book-tour-page">

    <div class="container about-page">
        <div class="row">
            <div class="col-md-8">
                {{ Form::open( array( 'url' => '/tours/confirmation', 'class' => 'formplate body-form contact-form', 'id' => 'payment-form') ) }}
                    <input type="hidden" name="productId" value="{{$tour['productId']}}"/>
                    @foreach ($priceIds as $priceId)
                        <input type="hidden" name="priceId[]" value="{{$priceId}}"/>
                    @endforeach
                    <input type="hidden" name="quanity" value="{{$qty}}"/>
                    <input type="hidden" name="packageId" value="{{$packageId}}"/>

                    <input type="hidden" name="stripeToken" value=""/>
                    <input type="hidden" name="stripeTokenType" value=""/>
                    <input type="hidden" name="stripeEmail" value=""/>

                    <label for="emailaddress">Email Address</label><input type="email" name="email" required id="emailaddress" value="{{ Sentry::Check() ? Sentry::getUser()->email : '' }}">

                    <label for="first-name">First Name</label><input name="firstname" required type="text" id="first-name" value="{{ Sentry::Check() ? Sentry::getUser()->first_name : '' }}">

                    <label for="last-name">Last Name</label><input name="lastname" required type="text" id="last-name" value="{{ Sentry::Check() ? Sentry::getUser()->last_name : '' }}">

                    <label for="country">Country</label>
                    {{ Form::select(
                        'country',
                        Config::get('travelapi.countries'),
                        (Sentry::check() && Sentry::getUser()->country) ? Sentry::getUser()->country : "036",
                        array(
                            'id' => 'country'
                        )
                    ) }}

                    <label for="telephone">Telephone</label><input name="phone" required type="text" id="telephone" value="{{ Sentry::Check() ? Sentry::getUser()->phone : '' }}">

                    <div class="row">
                        <div class="col-md-6">
                            <input id="btnPay" type="submit" value="Pay for Tour">
                            <script src="https://checkout.stripe.com/checkout.js"></script>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ action('ToursController@info', array('id' => $tour['productId'])) }}" class="full-size button yellow">Edit Tour</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4 summary">
                <h5>TOUR</h5>
                <p>{{{ $qty }}} x {{{ $tour['name'] }}}</p>

                @if (!empty($tour['address']['formattedAddress']))
                    <h5>ADDRESS</h5>
                    <p>{{{ $tour['address']['formattedAddress'] }}}</p>
                @endif

                <h5>FARE NAME</h5>
                <p>{{{ $qty }}} x {{{ implode(' & ', $farespricesNames) }}}</p>

                <h5>TOTAL PRICE</h5>
                <p>${{{ $priceTour }}} AUD</p>

            </div>

        </div>
    </div>

</div>

<script>
    var handler = StripeCheckout.configure({
        key: '{{ $stripeKey }}',
        token: function(token) {
            $("input[name=stripeToken]").val(token.id);
            $("input[name=stripeTokenType]").val(token.type);
            $("input[name=stripeEmail]").val(token.email);
            $("#payment-form").submit();
        }
    });

    document.getElementById('btnPay').addEventListener('click', function(e) {
        if ($("#payment-form").valid()) {
            // Open Checkout with further options
            handler.open({
                description: "{{$tour['name']}}",
                amount: "{{$priceTour * 100}}",
                email: $("input[name=email]").val()
            });
        }
        e.preventDefault();
    });
</script>
@stop