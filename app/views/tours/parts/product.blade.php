<div class="col-md-12 item">
    <div class="row">

        <div class="col-md-4 image">
            @if(!empty($product['images']))
                <a href="{{ action('ToursController@info', $product['productId']) }}">
                    <img src="{{ $product['images'][0]['path'] }}" class="responsive">
                </a>
            @else
                <div class="no_image"><p>NO TOUR IMAGE</p></div>
            @endif
        </div>

        <div class="col-md-6 details">
            <span class="type">Australia Tours</span>

            <h3>
                <a href="{{ action('ToursController@info', $product['productId']) }}">
                {{ preg_replace('/^WT\d+\ |^\(WT.+\)\ /', '',  trim($product['name']))}}
                </a>
            </h3>

            <ul class="icons hide-mobile">
                <li><a class="diving" href="#">Diving</a></li>
                <li><a class="family" href="#">Family</a></li>
                <li><a class="adventure" href="#">Adventure</a></li>
            </ul>

            <span class="length">Full Day</span>

            <p>{{{strip_tags($product['productTeaser'])}}}</p>

            <a href="{{ action('ToursController@info', $product['productId']) }}" class="more hide-mobile">View more info</a>

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
                <strong class="rate"><span>Rates from</span>${{ $product['priceMin'] }}</strong>
            </div>
        </div>

        <div class="hide-desktop col-md-2">
            <a href="{{ action('ToursController@info', $product['productId']) }}" class="more">View more info</a>
        </div>

        <div class="hide-mobile col-md-2 actions">
            <strong class="rate"><span>Rates from</span>${{ $product['priceMin'] }}</strong>
        </div>
    </div>
</div>