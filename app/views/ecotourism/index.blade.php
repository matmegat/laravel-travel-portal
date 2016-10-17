@extends('layouts.travel')

@section('title')
Eco Tourism | Visits
@stop

@section('promo')
<div class="hero  hero--page  hero--diving">
    <div class="container">
        <h1 class="hero__title">{{$info->title}}</h1>
    </div>
</div>
@stop

@section('content')

<div class="page-background nointro" style="">
	<div class="container">
		<h1>{{ $info->title }}</h1>
	</div>
</div>

<div class="main-body">

	<div class="container about-page">
		<div class="row">
			<div class="col-md-12">
				<p class="intro">{{html_entity_decode($info->content)}}</p>
			</div>
		</div>
	</div>

</div>

@stop
