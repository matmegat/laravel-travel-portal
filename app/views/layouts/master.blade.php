<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="keywords" content="{{{ isset($info->keywords) ? $info->keywords : '' }}}">
    <meta name="description" content="{{{ isset($info->description) ? $info->description : '' }}}">

    <title>@yield('title', 'Visits')</title>

    <!-- Bootstrap Core CSS -->
    {{ HTML::style(Config::get('cdn.asset_path') . '/css/library/bootstrap.min.css') }}

    <!-- Custom CSS -->
    {{ HTML::style(Config::get('cdn.asset_path') . '/css/library/sb-admin-2.css') }}

    <!-- Custom Fonts -->
    {{ HTML::style(Config::get('cdn.asset_path') . '/css/library/font-awesome.min.css') }}

    @yield('styles')

    @section('scripts')
    @endsection

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ action('PageAdminController@manage') }}">Visits Admin</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="{{ url('/user/logout') }}">
                    <i class="fa fa-sign-out fa-fw"></i> Logout
                </a>
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            {{ Form::open(array('url' => action('ToursAdminController@postSearch'))) }}
                            {{ Form::text('search', null, array('class' => 'form-control', 'placeholder' => 'Search ...')) }}
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            {{ Form::close() }}
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="{{ action('PageAdminController@manage') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ action('UserController@manage') }}"><i class="fa fa-users"></i> Manage Users</a>
                    </li>
                    <li>
                        <a href="{{ action('PageAdminController@manage') }}"><i class="fa fa-file-text-o"></i> Manage Pages</a>
                    </li>
                    <li>
                        <a href="{{ action('ToursAdminController@getIndex') }}"><i class="fa fa-sun-o"></i> Manage Tours</a>
                    </li>
                    <li>
                        <a href="{{ action('NewsController@manage') }}"><i class="fa fa-picture-o"></i> Manage Blog</a>
                    </li>
                    <li>
                        <a href="{{ action('AwardAdminController@manage') }}"><i class="fa fa-trophy"></i> Manage Awards</a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    @yield('promo')

    @yield('search')

    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                @yield('content')
            </div>
        </div>
        <!-- /.row -->
    </div>
</div>

<!-- jQuery -->
{{ HTML::script(Config::get('cdn.asset_path') . 'js/jquery.min.js') }}

<!-- Bootstrap Core JavaScript -->
{{ HTML::script(Config::get('cdn.asset_path') . 'js/bootstrap.min.js') }}

<!-- Custom Theme JavaScript -->
{{ HTML::script(Config::get('cdn.asset_path') . 'js/sb-admin-2.js') }}

</body>
</html>