@extends('layouts.travel')

@section('title')
FAQ | Visits
@stop

@section('content')

<div class="page-background nointro" style="background-image: url(img/header-bg/faq.jpg)">
	<div class="container">
		<h1>{{ $info->title }}</h1>
	</div>
</div>


<div class="main-body faq-page">
	<div class="container about-page">
        {{ $info->content }}
	</div>
</div>

@stop
