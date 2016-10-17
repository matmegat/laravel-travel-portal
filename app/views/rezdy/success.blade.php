@extends('layouts.travel')

@section('title')
Booking {{ $tour['name'] }}
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
            <div class="col-md-4 total-cost">
                <h5>Total</h5>
                <p>${{ $response['totalAmount'] }} (AUD)</p>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4 col-md-push-8 summary">
                <h5>ORDER ID</h5>
                <p>{{{ $response['orderNumber'] }}}</p>

                <h5>STATUS</h5>
                <p>Paid</p>
            </div>

            <div class="col-md-8 col-md-pull-4 content">
                <h5>Name</h5>
                <p>{{{ $tourBookInfo['productName'] }}} ({{{ $tourBookInfo['quantities'][0]['optionLabel'] }}})</p>

                <h5>Price</h5>
                <p>${{ $response['totalAmount'] }} (AUD)</p>

                <h5>Quantity</h5>
                <p>{{{ $tourBookInfo['totalQuantity'] }}}</p>

                <h5>Date start</h5>
                <p>{{ date('Y-m-d H:i:s', strtotime($tourBookInfo['startTime'])) }}</p>

                <h5>Date end</h5>
                <p>{{ date('Y-m-d H:i:s', strtotime($tourBookInfo['endTime'])) }}</p>
            </div>

        </div>
    </div>

</div>

@stop