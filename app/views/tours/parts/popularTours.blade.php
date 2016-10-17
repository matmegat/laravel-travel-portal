@if (!empty($popularTours))
<div class="panel panel-primary">
    <div class="panel-heading">You may also be interested in the following tour(s)</div>
    <div class="panel-body">
        <div>
            @foreach($popularTours as $popularTour)
            <div class="col-md-3" style="text-align: center;">
                <a href="{{ action('ToursController@info', array('id' => $popularTour['productId'])) }}">
                    <img class="img-thumbnail" style="max-height: 100px;" src="{{$popularTour['productImagePath']}}"/>
                </a>
                <p>
                    <a href="{{ action('ToursController@info', array('id' => $popularTour['productId'])) }}">{{$popularTour['name']}}</a>
                </p>
                <p style="font-weight: bold;">
                    @if ($popularTour['price']['min'] == $popularTour['price']['max'])
                    $ {{$popularTour['price']['min']}}
                    @else
                    $ {{$popularTour['price']['min']}} - {{$popularTour['price']['max']}}
                    @endif
                </p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif