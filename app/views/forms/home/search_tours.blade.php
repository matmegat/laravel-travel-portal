{{ Form::open( array( 'url' => '/tours/search', 'class' => 'formplate row tour-filter', 'method' => 'GET', 'id' => 'payment-form', 'role' => 'form')) }}
    <div class="col-md-3">
        {{ Form::text('keywords', Input::get('keywords'), array( 'class' => 'form-control', 'placeholder' => 'keywords' ))}}
    </div>

    <div class="col-md-3 hidden">
        {{ Form::select('cat', array('0'=> 'Choose cat', '525'=>'Activity','526'=>'Merchandise','527'=>'Accommodation','528'=>'Multi Day Tour / Activity','529'=>'Day Tour / Activity','530'=>'Combo Tour', '531'=>'Transport', '532'=>'Free Product','543'=>'Miscellaneous Product', '544'=>'Variable Price Product', '546'=>'Package'), Input::get('cat'), array('class' => 'form-control', 'required' => 'true'))  }}
    </div>

    <div class="col-md-3">
        {{ Form::select('state', array('0'=> 'Loading...'), Input::get('state'), array('id' => 'state-select','class' => 'form-control state_select', 'disabled' => 'disabled')) }}
    </div>

    <div class="col-md-3">
        {{ Form::select('region', array('0' => 'Loading...'), Input::get('region'), array('id' => 'region-select', 'class' => 'form-control region_select', 'disabled' => 'disabled')) }}
    </div>

    <div class="col-md-3">
        <input type="submit" class="button" value="Search">
    </div>

{{ Form::close() }}

{{ Form::hidden('current_region', Input::get('region')) }}
{{ Form::hidden('current_state', Input::get('state')) }}

{{ HTML::script(Config::get('cdn.asset_path') . 'js/app/form/travel.js') }}
