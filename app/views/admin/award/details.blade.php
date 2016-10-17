@extends('layouts.travel')

@section('title')
{{{ $award->title }}} | Visits
@stop

@section('content')

<div
    @if (!empty($award->primary_photo['url']))
        class="page-background nointro blog-post-bg home-slider page-slider" style="background-image: url({{ $award->primary_photo['url'] }})"
    @else
        class="page-background nointro"
    @endif
    >
    <div class="container">
        <h1>{{{ $award->title }}}</h1>
    </div>
</div>

<div class="main-body blog-listing">

    <div class="container drop-shadow about-page">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <article>

                    <p class="intro date">{{strftime('%b %e, %Y',strtotime($award->created_at))}}</p>

                    @include('award.parts.photos')
                    {{ $award->content }}

                    <!-- Social Links -->
                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54871c103bfb337c" async="async"></script><div class="addthis_native_toolbox"></div>
                </article>
            </div>

        </div>

    </div>


    <div class="container pagination-container">
        <div class="row">
            <div class="col-md-push-2 col-md-8">
                @include('award.parts.disqus')
            </div>
        </div>
    </div>

</div>
@stop