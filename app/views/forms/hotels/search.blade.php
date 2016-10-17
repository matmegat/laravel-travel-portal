{{ Form::open(array('url' => action('HotelsController@search'), 'method' => 'GET', 'class' => 'hotels-form app-form-hotels-search', 'role' => 'form')) }}

<div class="flights-form">
    <div class="col-md-12">
        <div class="input-group">
            <span class="glyphicon glyphicon-plane input-group-addon"></span>
            {{ Form::text('location_id', Input::get('departure', 'Airlie Beach'),
            array(
            'id' => 'app-form-hotels-search-location',
            'class' => 'form-control form-select2',
            'placeholder' => 'Location'
            )
            )
            }}
        </div>
        {{ $errors->first('location_id', '<div class="label label-warning">:message</div>') }}
    </div>
</div>

<div class="form-row">
    <div class="col-md-6">
        <div class="input-group">
            <span class="glyphicon glyphicon-calendar input-group-addon"></span>
            {{ Form::text('check_in',Input::get('outbound', strftime('%d/%m/%Y', time()+2*3600*24)),
            array('class' => 'form-control app-form-hotels-search-outbound', 'placeholder' => 'Outbound', 'data-date-format' => "dd/mm/yyyy")) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <span class="glyphicon glyphicon-calendar input-group-addon"></span>
            {{ Form::text('check_out',Input::get('inbound',strftime('%d/%m/%Y', time()+3*24*3600)),
            array('class' => 'form-control app-form-hotels-search-inbound', 'placeholder' => 'Inbound', 'data-date-format' => "dd/mm/yyyy")) }}
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="col-md-6">
    <div class="input-group">
        <span class="glyphicon glyphicon-user input-group-addon"></span>
        {{ Form::text('guests','', array(
        'class' => 'form-control',
        'required' => true,
        'placeholder' => 'No. Guests'
        ))}}
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <button class="col-md-12 btn btn-default">
            Search <span class="glyphicon glyphicon-search"></span>
        </button>
    </div>
</div>

{{ Form::close() }}

{{ HTML::script(Config::get('cdn.asset_path') . 'js/app/form/hotels.js') }}