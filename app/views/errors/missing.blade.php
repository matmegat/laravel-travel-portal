<!DOCTYPE html>
<!--[if IE 7]><html lang="en-US" class="ie7"><![endif]-->
<!--[if IE 8]><html lang="en-US" class="ie8"><![endif]-->
<!--[if gt IE 8]><html lang="en-US" class="ie new-ie"><![endif]-->
<!--[if !IE]><!--><html lang="en-US"><!--<![endif]-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>404 | Visits</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />
<!--
    <script src="//use.typekit.net/omr6oja.js"></script>
    <script>try{Typekit.load();}catch(e){}</script>
 -->
    <script src="//use.typekit.net/xku0rws.js"></script>
    <script>try{Typekit.load();}catch(e){}</script>

    <meta name="keywords" content="{{{ isset($info->keywords) ? $info->keywords : '' }}}">
    <meta name="description" content="{{{ isset($info->description) ? $info->description : '' }}}">

    {{ HTML::style(Config::get('cdn.asset_path') . '/css/style.css') }}

    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
    <link rel="shortcut icon" href="/img/favicon.ico">
    <link rel="apple-touch-icon" href="/img/apple-touch.png">

    @yield('styles')

    {{ HTML::script(Config::get('cdn.asset_path') . 'js/jquery-1.11.1.min.js') }}
    {{--{{ HTML::script(Config::get('cdn.asset_path') . 'js/jquery-ui-1.10.4.custom.js') }} --}}

    {{ HTML::script(Config::get('cdn.asset_path') . 'js/library/jquery.validate.min.js') }}


    {{--
    {{ HTML::script(Config::get('cdn.asset_path') . 'js/library/additional-methods.min.js') }}
    {{ HTML::script(Config::get('cdn.asset_path') . 'js/library/jquery.maskedinput.js') }}
    {{ HTML::script(Config::get('cdn.asset_path') . 'js/library/bootstrap.min.js') }}
    {{ HTML::script(Config::get('cdn.asset_path') . 'js/library/select2.js') }}
    {{ HTML::script(Config::get('cdn.asset_path') . 'js/library/holder.js') }}
    {{ HTML::script(Config::get('cdn.asset_path') . 'js/library/formplate.js') }}

    {{ HTML::script(Config::get('cdn.asset_path') . 'js/library/typeahead.js') }}
    {{ HTML::script(Config::get('cdn.asset_path') . 'js/library/handlebars.js') }}
    {{ HTML::script(Config::get('cdn.asset_path') . 'js/bootstrap-switch.js') }}

    {{ HTML::script(Config::get('cdn.asset_path') . 'js/jquery.mousewheel.min.js') }}
    {{ HTML::script(Config::get('cdn.asset_path') . 'js/jquery.infinitescroll.min.js') }}
    {{ HTML::script(Config::get('cdn.asset_path') . 'js/jquery.nicescroll.min.js') }}
    {{ HTML::script(Config::get('cdn.asset_path') . 'js/jquery.nouislider.min.js') }}


    --}}

    @yield('scripts')



</head>

<body class="fourohfour">

  <header class="fourohfour-header">
    <h1>404</h1>
    <h2>Take a wrong turn?</h2>
  </header>

  <footer class="fourohfour-footer">
    <h3 class="logo"><a href="/">Visits Diving Adventures</a></h3>

    <form role="search" action="/search" method="GET">
        <input type="text" class="search-field" placeholder="Search tours, flights and hotels..." name="query">
    </form>

    <div class="follow-us">
        <ul class="social-icons">
            <li class="facebook"><a href="https://www.facebook.com/visitswhitsundayadventures">Facebook</a></li>
            <li class="twitter"><a href="https://twitter.com/visitsadventures">Twitter</a></li>
            <li class="googleplus"><a href="https://google.com/+VisitsAus">Google+</a></li>
            <li class="youtube"><a href="https://www.youtube.com/user/visitswhitsunday">Youtube</a></li>
        </ul>

        <a class="email-link" href="mailto:info@visits.com.au">info@visits.com.au</a>
    </div>
  </footer>

  @include ( 'layouts/partials/ga' )


{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/datepicker.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/modernizr-custom-v2.7.1min.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/formplate.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/validation.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/uislider.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/autocomplete.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/slider.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/jquery.raty.min.js') }}
{{ HTML::script(Config::get('cdn.asset_path') . 'js/library/jquery.oLoader.min.js') }}

{{ HTML::script(Config::get('cdn.asset_path') . 'js/app/main.js') }}
{{--{{ HTML::script(Config::get('cdn.asset_path') . 'js/app/script1.js') }}--}}
{{--{{ HTML::script(Config::get('cdn.asset_path') . 'js/app/script2.js') }}--}}
{{--{{ HTML::script(Config::get('cdn.asset_path') . 'js/app.js') }}--}}
{{--{{ HTML::script(Config::get('cdn.asset_path') . 'js/app/form/search_menu.js') }}--}}
</body>
</html>
