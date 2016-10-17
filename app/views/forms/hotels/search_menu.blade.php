{{ Form::open(array('url' => action('HotelsController@search'), 'method' => 'GET', 'class' => 'formplate row tour-filter', 'role' => 'form')) }}
    <div class="col-md-3">
        {{ Form::select('location_id', array('23' => 'Whitsundays', '8829' => 'Airlie Beach'), Input::get('location_id') ? Input::get('location_id') : 23) }}
    </div>
    <div class="col-md-2">
        {{Form::text(
            'check_in',
            isset($filters['check_in']) ? $filters['check_in'] : '',
            array(
                'class' => 'datepicker',
                'id' => 'hotels_from',
                'placeholder' => 'Check In',
                'data-date-format' => "dd.mm.yyyy",
                'type' => "datetime",
            )
        ) }}
    </div>
    <div class="col-md-2">
        {{Form::text(
            'check_out',
            isset($filters['check_out']) ? $filters['check_out'] : '',
            array(
                'class' => 'datepicker',
                'id' => 'hotels_to',
                'placeholder' => 'Checkout',
                'data-date-format' => "dd.mm.yyyy",
                'type' => "datetime"
            )
        ) }}
    </div>
    <div class="col-md-3">
        {{ Form::select('guests', array(
            '1' => '1 Guest',
            '2' => '2 Guests',
            '3' => '3 Guests',
            '4' => '4 Guests',
            '5' => '5 Guests',
        ), Input::get('location_id') ? Input::get('guests') : 1) }}
    </div>
    <div class="col-md-2">
        {{Form::submit('Search', $attributes = array('class' => "button"))}}
    </div>
{{ Form::close() }}
{{--{{ HTML::script(Config::get('cdn.asset_path') . 'js/app/form/hotels.js') }}--}}