@extends('layouts.travel')

@section('title')
Booking {{$tour['name']}}
@stop

@section('content')

<div class="page-background nointro payment-tour-header">
    <div class="container">
        <h1>You have purchased:</br>{{ $tour['name'] }}</h1>
    </div>
</div>

<div class="main-body payment-tour">

    <div class="container detailpage">
        <div class="row page-title">
            <div class="col-md-8">
                <h1>Your Order Information</h1>
                <p>Please check over the details below</p>
            </div>
            <div class="col-md-4">
                <h5>Total</h5>
                <p>${{ $priceTour }} (AUD)</p>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4 col-md-push-8 summary">
                <h5>ORDER ID</h5>
                <p>{{{ $voucherId }}}</p>

                <h5>STATUS</h5>
                <p>Paid</p>
            </div>

            <div class="col-md-8 col-md-pull-4 content">
                <h5>Name</h5>
                @foreach ($fares as $item)
                    <p>{{{ $item['fareName'] }}}</p>
                @endforeach

                <h5>Price</h5>
                <p>${{ $priceTour }} (AUD)</p>

                <h5>Quantity</h5>
                <p>{{{ $qty }}}</p>

                @if (!empty($tour['productTeaser']))
                    <h5>TEASER</h5>
                    <p>{{{ $tour['productTeaser'] }}}</p>
                @endif

                @if (!empty($tour['address']['formattedAddress']))
                    <h5>ADDRESS</h5>
                    <p>{{{ $tour['address']['formattedAddress'] }}}</p>
                @endif
            </div>

        </div>
    </div>

</div>

@stop