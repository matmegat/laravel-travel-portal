{{ Form::open(array('url' => action('FlightsController@search'), 'method' => 'GET', 'class' => 'flights-form app-form-flights-search', 'role' => 'form')) }}

<div class="flights-form">
    <div class="col-md-12">
        <div class="input-group">
            <span class="glyphicon glyphicon-plane input-group-addon"></span>
            {{ Form::text('departure', Input::get('departure'),
            array(
            'id' => 'app-form-flights-search-departure',
            'class' => 'form-control form-select2',
            'placeholder' => 'Departure from'
            )
            )
            }}
        </div>
        {{ $errors->first('departure', '<div class="label label-warning">:message</div>') }}
    </div>
</div>
<div class="form-row">
    <div class="col-md-12">
        <div class="input-group">
            <span class="glyphicon glyphicon-plane input-group-addon"></span>
            {{ Form::text('arrival', Input::get('arrival', Config::get('wego.default_destination')),
            array(
            'id' => 'app-form-flights-search-arrival',
            'class' => 'form-control form-select2',
            'placeholder' => 'Arrival to'
            )
            )
            }}
        </div>
        {{ $errors->first('arrival', '<div class="label label-warning">:message</div>') }}
    </div>
</div>

<div class="form-row">
    <div class="col-md-6">
        <div class="input-group">
            <span class="glyphicon glyphicon-calendar input-group-addon"></span>
            {{ Form::text('outbound',Input::get('outbound', strftime('%d/%m/%Y', time()+2*3600*24)),
            array('class' => 'form-control app-form-flights-search-outbound', 'placeholder' => 'Outbound', 'data-date-format' => "dd/mm/yyyy")) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <span class="glyphicon glyphicon-calendar input-group-addon"></span>
            {{ Form::text('inbound',Input::get('inbound',strftime('%d/%m/%Y', time()+3*24*3600)),
            array('class' => 'form-control app-form-flights-search-inbound', 'placeholder' => 'Inbound', 'data-date-format' => "dd/mm/yyyy")) }}
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="form-row">
    <div class="col-md-6">
        <div class="input-group">
            <span class="glyphicon glyphicon-user input-group-addon"></span>
            {{ Form::select('amount',array(
            '1' => '1 adult',
            '2' => '2 adults',
            '3' => '3 adults',
            '4' => '4 adults',
            ), Input::get('amount'),
            array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="col-md-6">
        <button class="col-md-12 btn btn-default">
            Search <span class="glyphicon glyphicon-search"></span>
        </button>
    </div>

    <div class="clearfix"></div>
</div>

<div class="form-row">
    <div class="col-md-12">
        <div class="form-group">
            <input class="form-control" type="checkbox" name="round_trip" id="round_trip" @if( $round_trip ) checked="checked" @endif/>
            <label for="round_trip">Round trip</label>
        </div>
    </div>
</div>

{{ Form::close() }}

{{--{{ HTML::script(Config::get('cdn.asset_path') . 'js/app/form/flights.js') }}--}}