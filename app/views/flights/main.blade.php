@extends('layouts.page')

@section('title')
Flights | Visits
@stop

@section('content')
        <div class="flights">
            <div class="index flights">
            <div class="container">
                <header>
                    <h2>{{ $info->title; }}</h2>
                    <div>{{ $info->content; }}</div>
                </header>
            </div>
        </div>
            <div class="content_results">
                <div class="container">
                    <div class="all section_results">
                        @include('forms.flights.search_menu')
                    </div>
                </div>
            </div>
        </div>

@stop