{{ Form::open(array('url' => $search)) }}
<div class='form-group col-md-3 col-sm-3'>
    <label class="" for="cat">I'M INTERESTED IN</label>
</div>
<div class='form-group col-md-3 col-sm-12 fun-dropdown'>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <div class="current-name"></div>
    <div class="caret"></div>
    </button>
    <ul class="dropdown-menu interest_list" role="menu">
        @foreach ($icons as $icon)
        <li>
            <a href="#" data-icon-id="{{ $icon->id }}" data-icon-name="{{$icon->name}}">
                <img src="/img/icons/{{$icon->icon}}"> {{$icon->name}}
            </a>
        </li>
        @endforeach
        {{ Form::hidden('fun', $selected->id, array('class' => 'select_id'))}}
    </ul>
</div>
<div class='form-group col-md-2 col-sm-4'>
    {{ Form::text('start_date', $value = $start, $attributes = array('class' => 'date form-control', 'placeholder'=>'Start Date', 'id'=>'tours_from'));}}
</div>
<div class='form-group col-md-2 col-sm-4'>
    {{ Form::text('end_date', $value = $end, $attributes = array('class' => 'date  form-control', 'placeholder'=>'End Date', 'id'=>'tours_to'));}}
</div>
<div class='form-group col-md-2 col-sm-4'>
    {{ Form::submit('SEARCH', array('class' => 'btn btn-primary btn-md button form-control'));}}
</div>
{{ Form::close(); }}
<div class="clear"></div>