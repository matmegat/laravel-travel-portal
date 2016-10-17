@extends('layouts.travel')

@section('title')
YOUR VOUCHER | Visits
@stop



@section('content')
@if($voucher != null)
    <div class="alert alert-success"><b>Well done!</b> You successfully booked order.</div>
@elseif ($error)
    <div class="alert alert-danger"><b>Error.</b> Please try again.</div>
@endif
<!--
<iframe class="voucher" src="{{action('ToursController@voucher', $voucher)}}"></iframe>
-->
@stop