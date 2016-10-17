@include('forms.home.search_tours', array('url' => '/tours/search'))
<div class="row main-list">
    @foreach ($tours as $i => $tour)
        <div class="col-md-12 item">
            <div class="row">
                <div class="col-md-4 image">
                    @if (!empty($tour['images'][0]['itemUrl']))
                        <a href="{{ action('TourRezdyController@tour', array('id' => $tour['productCode'], 'account' => $tour['account'])) }}">
                            <img src="{{ $tour['images'][0]['itemUrl'] }}" class="responsive" />
                        </a>
                    @else
                        <div class="">NO TOUR IMAGE</div>
                    @endif
                </div>

                <div class="col-md-6 details">
                    <span class="type">{{ array_get(\Config::get('rezdy.tourHeader'), $tour['account'], $tour['account']) }}</span>

                    <h3><a href="{{ action('TourRezdyController@tour', array('id' => $tour['productCode'], 'account' => $tour['account'])) }}">{{ $tour['name'] }} </a></h3>

                    <ul class="icons hide-mobile">
                        <li><a class="diving" href="#">Diving</a></li>
                        <li><a class="family" href="#">Family</a></li>
                        <li><a class="adventure" href="#">Adventure</a></li>
                    </ul>

                    <span class="length">Full Day</span>

                    <p>{{{ $tour['shortDescription'] }}}</p>

                    <a href="{{ action('TourRezdyController@tour', array('id' => $tour['productCode'], 'account' => $tour['account'])) }}" class="more hide-mobile">View more info</a>

                </div>

                <div class="hide-desktop clearfix actions">
                    <div class="col-xs-6 col-sm-6">
                        <ul class="icons">
                            <li><a class="diving" href="#">Diving</a></li>
                            <li><a class="family" href="#">Family</a></li>
                            <li><a class="adventure" href="#">Adventure</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-6 col-sm-6">
                        <strong class="rate"><span>Rates from</span>${{ $tour['prices']['min'] }}<span> AUD </span></strong>
                    </div>
                </div>

                <div class="hide-desktop col-md-2">
                    <a href="{{ action('TourRezdyController@tour', array('id' => $tour['productCode'], 'account' => $tour['account'])) }}" class="more">View more info</a>
                </div>

                <div class="hide-mobile col-md-2 actions">
                    <strong class="rate"><span>Rates from</span>${{ $tour['prices']['min'] }}<span> AUD </span></strong>
                </div>
            </div>
        </div>
    @endforeach
</div>