@if ($paginator)
    @if (count($paginator))
        @foreach ($paginator as $routeKey => $hotel)
            @include('hotels.parts.fares')
        @endforeach

        {{ $paginator->appends(Input::except('page'))->links() }}
    @else
        <div class="searching">
            No hotels found..
        </div>
    @endif
@else
    <div class="searching">
        We're searching for hotels right now, it will take just few seconds, be patient!

        <script>
            $(function() {
                refreshResults(2000, '{{action("HotelsController@updateResults", $params)}}');
            });
        </script>
    </div>
@endif