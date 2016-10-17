<div class="wrap first-wrap">

    <h1 class="logo"><a href="/">Visits Whitsunday Adventures</a></h1>

    <button class="menu-btn" type="button">
        <span></span>
    </button>

    <nav class="othermenu">
        <li>{{ link_to_route('about', 'About') }}</li>
        <li class="dot">&bull;</li>
        <li>{{ link_to_route('contact', 'Contact') }}</li>
        <li class="dot">&bull;</li>
        <li>{{ link_to_route('news', 'Blog') }}</li>
        <li class="dot">&bull;</li>
        <li>{{ link_to_route('awards', 'Awards') }}</li>
        <li class="dot">&bull;</li>
        <li>{{ link_to_route('eco-tourism', 'Ecotourism') }}</li>
    </nav>

    <form role="search" action="/search" method="GET">
        <input type="text" class="search-field" placeholder="Search Tours" name="query">
    </form>

</div>

<nav class="mainmenu">
    <ul class="wrap second-wrap">
        <li>
            <a @if($active_tab == 'sailing') class="active" @endif href="{{ action('TourRezdyController@tours', array('account' => 'sailing')) }}">
                <span class="sailing"></span>Sail and Snorkel
            </a>
        </li>
        <li>
            <a @if($active_tab == 'adventure') class="active" @endif href="{{ action('TourRezdyController@tours', array('account' => 'adventure')) }}">
                <span class="adventure"></span>Mini 4WD Tour
            </a>
        </li>
        <li>
            <a @if($active_tab == 'tours') class="active" @endif href="{{ action('ToursController@home') }}">
                <span class="australia"></span>Australia Tours
            </a>
        </li>
        <li>
            <a @if($active_tab == 'hotels') class="active" @endif href="{{ action('HotelsController@index') }}">
                <span class="hotels"></span>Hotels
            </a>
        </li>
        <li>
            <a @if($active_tab == 'flights') class="active" @endif href="{{ action('FlightsController@index') }}">
                <span class="flights"></span>Flights
            </a>
        </li>
    </ul>
</nav>