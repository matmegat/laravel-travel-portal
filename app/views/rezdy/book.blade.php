@extends('layouts.travel')

@section('title')
Book Tour
@stop

@section('content')

<div class="notification">
    <p>You cannot book less than 720 hours in advanced</p>
</div>

<div class="page-background nointro">
    <div class="container">
        <h1>Book Tour</h1>
    </div>
</div>

<div class="main-body book-tour-page">

    <div class="container about-page">

        @include('layouts.partials._messages')

        <div class="row">
            <div class="col-md-8">
                {{ Form::open(array(
                    'class' => 'formplate body-form contact-form',
                    'id' => 'payment-form',
                )) }}
                    <input type="hidden" name="productCode" value="{{ $tour['productCode'] }}"/>
                    <input type="hidden" name="quantity"    value="{{ $quantity }}"/>
                    <input type="hidden" name="optionId"    value="{{ $optionId }}"/>
                    <input type="hidden" name="startTime"   value="{{ $session['startTimeUtc'] }}"/>
                    <input type="hidden" name="account"     value="{{ $account }}"/>

                    <input type="hidden" name="stripeToken" value=""/>
                    <input type="hidden" name="stripeTokenType" value=""/>
                    <input type="hidden" name="stripeEmail" value=""/>

                    <h3>Contact Details</h3>
                    @foreach($bookingFields['perBooking'] as $bookField)

                        @if($bookField['label'] == 'Voucher Number')
                            <?php continue; ?>
                        @endif

                        @if(!empty($bookField['label']))
                            <label <?php if (!empty($bookField['requiredPerBooking'])) {
    echo "class='required'";
} ?>
                                    for="<?php echo strtolower($bookField['label']); ?>">
                                <?php echo $bookField['label']; ?>
                            </label>

                            @if(strtolower($bookField['label']) != 'country' && (!isset($bookField['listOptions']) || empty($bookField['listOptions'])))
                                {{ Form::text('contact['.camelCase($bookField['label']).']', null, array('id' => strtolower($bookField['label']))+(!empty($bookField['requiredPerBooking']) ? array('required'=>'required') : array())) }}
                            @else
                                @if (strtolower($bookField['label']) == 'country')
                                    {{ Form::select(
                                         'contact[country]',
                                         Config::get('travelapi.countries'),
                                         (Sentry::check() && Sentry::getUser()->country) ? Sentry::getUser()->country : '036',
                                         array(
                                             'id' => 'country'
                                         )
                                        ) }}
                                @else
                                    {{ Form::select(
                                        'contact['.camelCase($bookField['label']).']',
                                        isset($bookField['listOptions']) ? explode("\n", $bookField['listOptions']) : array(),
                                        '',
                                        array(
                                         'id' => strtolower($bookField['label'])
                                        )
                                        ) }}
                                @endif
                            @endif
                        @endif
                    @endforeach


                    <h3>Berths - {{{ $tour['name'] }}}</h3>
                    @for($i=0; $i<$quantity; $i++)
                        <h2>Berth {{{ $i+1 }}}</h2>
                        @foreach($bookingFields['perParticipant'] as $bookField)
                            @if(!empty($bookField['label']))
                                <label <?php if (!empty($bookField['requiredPerParticipant'])) {
    echo "class='required'";
} ?>
                                        for="<?php echo strtolower($bookField['label']); ?>">
                                    <?php echo $bookField['label']; ?>
                                </label>

                                @if($bookField['label'] == 'Drivers licence')
                                    {{ Form::checkbox('berth['.$i.']['.camelCase($bookField['label']).']', 1, null) }}
                                @elseif(strtolower($bookField['label']) != 'country' && (!isset($bookField['listOptions']) || empty($bookField['listOptions'])))
                                    {{ Form::text('berth['.$i.']['.camelCase($bookField['label']).']', null, array('id' => strtolower($bookField['label']))+(!empty($bookField['requiredPerParticipant']) ? array('required'=>'required') : array())) }}
                                @else
                                    @if (strtolower($bookField['label']) == 'country')
                                        {{ Form::select(
                                             'berth['.$i.'][country]',
                                             Config::get('travelapi.countries'),
                                             (Sentry::check() && Sentry::getUser()->country) ? Sentry::getUser()->country : "036",
                                             array(
                                                 'id' => 'country'
                                             )
                                            ) }}
                                    @else
                                        {{ Form::select(
                                            'berth['.$i.']['.camelCase($bookField['label']).']',
                                            isset($bookField['listOptions']) ? explode("\n", $bookField['listOptions']) : array(),
                                            "",
                                            array(
                                             'id' => strtolower($bookField['label'])
                                            )
                                            ) }}
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    @endfor

                    <div class="row">
                        <div class="col-md-6">
                            <input id="btnPay" type="submit" value="Pay for Tour">
                            <script src="https://checkout.stripe.com/checkout.js"></script>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ action('TourRezdyController@tour', array('id' => $tour['productCode'], 'account' => $account)) }}" class="full-size button yellow">Edit Tour</a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>

            <div class="col-md-4 summary">
                <h5>TOUR</h5>
                <p>{{{ $quantity }}} x {{{ $tour['name'] }}}</p>

                <h5>DATE START</h5>
                <p>{{ date("Y-m-d H:i:s", strtotime($session['startTime'])) }}</p>

                <h5>DATE END</h5>
                <p>{{ date("Y-m-d H:i:s", strtotime($session['endTime'])) }}</p>

                <h5>TOTAL PRICE</h5>
                <p>${{{ $tour['priceOptions'][$optionId]['price'] * $quantityPrice['seats'] }}} AUD</p>

            </div>

        </div>
    </div>

</div>
@stop

@section('scripts')
<script>
    $("#payment-form").validate();

    {{--var STATES = {{ json_encode( Config::get('countries.countries') ) }};--}}
    {{--var PHONES = {{ json_encode( Config::get('travelapi.phones') ) }};--}}
    //    $('#country').change(function(){
    //        var code = $(this).val();
    //
    //        if( typeof STATES[ code ] != 'undefined' ) {
    //            $('#state option').remove();
    //            var options = '';
    //            $.each(STATES[code], function(idx, elem){
    //                options += '<option value="'+idx+'">'+elem+'</option>';
    //            });
    //            $('#state').html( options );
    //            $('#state-group').show();
    //        } else {
    //            $('#state-group').hide();
    //        }
    //
    //        if( typeof PHONES[ code ] != 'undefined' ) {
    //            $('#lbl-phone-prefix').html( '+' + PHONES[ code ] );
    //            $('#ipt-phone-prefix').val( PHONES[ code ] );
    //        } else {
    //            $('#lbl-phone-prefix').html( '' );
    //            $('#ipt-phone-prefix').val( '' );
    //        }
    //    });
    //
    //    $('#country').trigger('change');
</script>

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
                description: "{{{ $tour['name'] }}}",
                amount: "{{{ $tour['priceOptions'][$optionId]['price'] * $quantityPrice['seats'] * 100 }}}",
                email: $("input[name=email]").val()
            });
        }
        e.preventDefault();
    });
</script>
@stop