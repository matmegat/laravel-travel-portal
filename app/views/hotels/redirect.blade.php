@extends('layouts.travel')

@section('content')

<div class="hotels">
    <div class="index hotels"
        @if ($pageInfo['backgroundUrl'])
            style="background: url('{{$pageInfo['backgroundUrl']}}') no-repeat; background-size: 100%;"
        @endif
        >

        <div class="container">
            <header>
                <h2>{{ $info->title; }}</h2>
                <div>{{ $info->content; }}</div>
            </header>

            <div class="alert alert-info text-center">
                <h2>
                    Please wait, {{Config::get('site.title')}} is redirecting you to the destination site..
                </h2>
            </div>
        </div>
    </div>
</div>

<script>
    var deeplink = {{ json_encode($deeplink) }};
    window.location.href = deeplink.url;
</script>

@stop

