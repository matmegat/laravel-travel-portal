{{ Form::open(array('url' => action('FlightsController@search'), 'method' => 'GET', 'class' => 'formplate row tour-filter', 'role' => 'form')) }}

    <div class="col-md-2 check-contain">
        <input type="checkbox" class="contrast onewaycheck" {{ $one_way ? 'checked' : '' }} name="one_way" id="one_way" >One Way
    </div>

    <div class="col-md-2">
        {{ Form::text('departure', Input::get('departure'), array('id' => 'app-form-flights-search-departure', 'class' => 'fp-select', 'placeholder' => 'Departing from', 'multiple' => 1))}}
    </div>
    <div class="col-md-2">
        {{ Form::select('arrival', array('PPP' => 'Proserpine', 'HTI' => 'Hamilton Island'), Input::get('arrival'))}}
    </div>
    <div class="col-md-2">
        {{ Form::text('outbound',Input::get('outbound'), array('class' => 'datepicker', 'placeholder' => 'Depart', 'id' => 'flights_from','data-date-format' => "dd.mm.yyyy")) }}
    </div>
    <div class="col-md-2">
        {{ Form::text('inbound', Input::get('inbound'), array('class' => 'datepicker onwayhide', 'placeholder' => 'Return','id' => 'flights_to', 'data-date-format' => "dd.mm.yyyy" )) }}
    </div>
    <div class="col-md-2">
        {{Form::submit('Search', $attributes = array('class' => "button"))}}
    </div>

{{ Form::close() }}