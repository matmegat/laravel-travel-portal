@extends('layouts.travel')

@section('title')
An error has occured | Visits
@stop


@section('content')

<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Error!</strong> {{$error}}
</div>

@stop