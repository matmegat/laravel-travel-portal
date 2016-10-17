@if( $tag['id'] != $selected_tag )
<a class="rounded" href="{{ action('NewsController@listNews', array('tag' => $tag['id']) + Input::except('tag')) }}">{{{ $tag['text'] }}}</a>
@else
<a class="rounded label-success" href="{{ action('NewsController@listNews') }}">{{{ $tag['text'] }}}</a>
@endif