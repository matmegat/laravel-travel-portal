<!DOCTYPE html>
<!--[if IE 7]><html lang="en-US" class="ie7"><![endif]-->
<!--[if IE 8]><html lang="en-US" class="ie8"><![endif]-->
<!--[if gt IE 8]><html lang="en-US" class="ie new-ie"><![endif]-->
<!--[if !IE]><!--><html lang="en-US"><!--<![endif]-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Visits')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <script src="//use.typekit.net/xku0rws.js"></script>
    <script>try{Typekit.load();}catch(e){}</script>

    <meta name="keywords" content="{{{ isset($info->keywords) ? $info->keywords : '' }}}">
    <meta name="description" content="{{{ isset($info->description) ? $info->description : '' }}}">

    {{ HTML::style(Config::get('cdn.asset_path') . 'js/library/jquery-ui-1.11.4.custom/jquery-ui.min.css') }}
    {{ HTML::style(Config::get('cdn.asset_path') . 'css/style.css') }}
    {{ HTML::style(Config::get('cdn.asset_path') . 'css/style.custom.css') }}

    {{ HTML::script(Config::get('cdn.asset_path') . 'js/jquery-1.11.1.min.js') }}
    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="/img/favicon.ico">
    <link rel="apple-touch-icon" href="/img/apple-touch.png">

    @yield('styles')
</head>

<body>

<header class="site-header">
    @include('layouts.partials.menu')
</header>

    @yield('content')

@include ( 'layouts/footer' )

@include ( 'layouts/partials/ga' )


{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/jquery.validate.min.js') }}
{{-- HTML::script(Config::get('cdn.asset_path') . 'js/library/datepicker.js') --}}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/jquery-ui-1.11.4.custom/jquery-ui.min.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/modernizr-custom-v2.7.1min.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/formplate.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/validation.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/uislider.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/autocomplete.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/slider.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/jquery.raty.min.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/jquery.oLoader.min.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/app/main.js') }}

@yield('scripts')

</body>
</html>
