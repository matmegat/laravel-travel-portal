@foreach ($flights as $flight)
    <div class="result">
        <div class="info img">
            <img src="{{ StringHelper::secureImageUrl('http://0.omg.io/wego/image/upload/flights/airlines_rectangular/'.$flight['marketing_airline_code'].'.png', 'airlines') }}">
        </div>
        <div class="info flight">
            <h4>{{ $flightsSearch['trip']['departure_name'] }}</h4>
            @if (count($flight['outbound_segments']) == 1)
                <span>Direct</span>
            @elseif (count($flight['outbound_segments']) == 2)
                <span>1 Stop</span>
            @else
                <span>{{ count($flight['outbound_segments']) - 1 }} Stops</span>
            @endif
        </div>
        <div class="info rate">
            <span>Best Rate p.p</span>
            <h4>${{ (int)$flight['best_fare']['price'] }} </h4>
        </div>
        <div class="info more">
            <a href="/flights/search/?departure={{ $flightsSearch['trip']['departure_code'] }}&outbound={{ $flightsSearch['trip']['outbound_date'] }}&trip=0"><input class="btn btn-default button" type="button" value="VIEW MORE INFO" /></a>
        </div>
        <div class="item_description"></div>
    </div>
@endforeach