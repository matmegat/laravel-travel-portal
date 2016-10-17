<div class="yellow_search_menu_test"  id="tours">
        {{ Form::open( array( 'url' => '/tours/search', 'method' => 'GET', 'id' => 'payment-form')) }}
            <div class="form_input text">
                {{ Form::label('cat', 'I\'M INTERESTED IN', array('class' => '')) }}
            </div>
            <div class="form_input keyword">
                {{ Form::text('keywords', Input::get('keywords'), array( 'class' => 'form-control', 'placeholder' => 'keywords' ))}}
            </div>
            <div class="form_input cat drop_menu">
                <div class = 'dropdown_menu dropdown_menu_cat'>
                    {{ Form::text('select', (!Input::has('cat') || 0 == Input::get('cat'))? 'Choose cat' : $name, $attributes = array('class' => 'select', 'disabled' =>'disabled'))}}
                    {{ Form::hidden('cat', null !== Input::get('cat') ? Input::get('cat') : '0', $attributes = array('class' => 'guests_select select_id'))}}
                    <ul class = 'dropdown'>
                        <li class = "dropdown_item {{ (!Input::has('cat') || 0 == Input::get('cat'))? 'selected_option' : ''}}"><p title="Choose cat">Choose cat</p><input type='hidden' value='0'></li>
                        <li class = "dropdown_item {{ (Input::has('cat') && 525 == Input::get('cat'))? 'selected_option' : ''}}"><p title="Activity">Activity</p><input type='hidden' value='525'></li>
                        <li class = "dropdown_item {{ (Input::has('cat') && 526 == Input::get('cat'))? 'selected_option' : ''}}"><p title="Merchandise">Merchandise</p><input type='hidden' value='526'></li>
                        <li class = "dropdown_item {{ (Input::has('cat') && 527 == Input::get('cat'))? 'selected_option' : ''}}"><p title="Accommodation">Accommodation</p><input type='hidden' value='527'></li>
                        <li class = "dropdown_item {{ (Input::has('cat') && 528 == Input::get('cat'))? 'selected_option' : ''}}"><p title="Multi Day Tour / Activity">Multi Day Tour / Activity</p><input type='hidden' value='528'></li>
                        <li class = "dropdown_item {{ (Input::has('cat') && 529 == Input::get('cat'))? 'selected_option' : ''}}"><p title="Day Tour / Activity">Day Tour / Activity</p><input type='hidden' value='529'></li>
                        <li class = "dropdown_item {{ (Input::has('cat') && 530 == Input::get('cat'))? 'selected_option' : ''}}"><p title="Combo Tour">Combo Tour</p><input type='hidden' value='530'></li>
                        <li class = "dropdown_item {{ (Input::has('cat') && 531 == Input::get('cat'))? 'selected_option' : ''}}"><p title="Transport">Transport</p><input type='hidden' value='531'></li>
                        <li class = "dropdown_item {{ (Input::has('cat') && 532 == Input::get('cat'))? 'selected_option' : ''}}"><p title="Free Product">Free Product</p><input type='hidden' value='532'></li>
                        <li class = "dropdown_item {{ (Input::has('cat') && 543 == Input::get('cat'))? 'selected_option' : ''}}"><p title="Miscellaneous Product">Miscellaneous Product</p><input type='hidden' value='543'></li>
                        <li class = "dropdown_item {{ (Input::has('cat') && 544 == Input::get('cat'))? 'selected_option' : ''}}"><p title="Variable Price Product">Variable Price Product</p><input type='hidden' value='544'></li>
                        <li class = "dropdown_item {{ (Input::has('cat') && 546 == Input::get('cat'))? 'selected_option' : ''}}"><p title="Package">Package</p><input type='hidden' value='546'></li>
                    </ul>
                </div>
            </div>
            <div id="country-select" class="form_input country">
                {{ Form::select('country', $country, Input::get('country'), array( 'placeholder' => 'Country','class' => 'country_select form-control form-select2')) }}
            </div>
            <div class="form_input state">
                <div class="select2-container state_select form-control form-select2" id="s2id_state-select"><a href="javascript:void(0)" onclick="return false;" class="select2-choice select2-default" tabindex="-1">   <span class="select2-chosen">State</span><abbr class="select2-search-choice-close"></abbr>   <span class="select2-arrow"><b></b></span></a></div>
                {{ Form::select('state', array(''=> 'States'), Input::get('state'), array('placeholder' => 'State', 'id' => 'state-select','class' => 'hidden state_select form-control form-select2')) }}
            </div>
            <div class="form_input region">
                <div class="select2-container region_select form-control form-select2" id="s2id_region-select"><a href="javascript:void(0)" onclick="return false;" class="select2-choice select2-default" tabindex="-1">   <span class="select2-chosen">Region</span><abbr class="select2-search-choice-close"></abbr>   <span class="select2-arrow"><b></b></span></a></div>
                {{ Form::select('region', array(''=> 'Region'), Input::get('region'), array('placeholder' => 'Region', 'id' => 'region-select', 'class' => 'hidden region_select form-control form-select2')) }}
            </div>
            <div class="form_input">
                <button type="submit" class="button">Search</button>
            </div>
        {{ Form::close() }}
    <div class="clear"></div>
</div>
{{ HTML::script(Config::get('cdn.asset_path') . 'js/app/form/travel.js') }}
