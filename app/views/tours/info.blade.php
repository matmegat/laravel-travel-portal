@extends('layouts.travel')

@section('title')
{{$tour['name']}} | Visits
@stop


@section('content')

@include('tours.parts.tourInfo')

@stop