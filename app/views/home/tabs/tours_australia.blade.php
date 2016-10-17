@include('forms.home.search_tours', array('url' => '/tours/search'))

<div class="row main-list">
    @foreach ($toursAustralia as $product)
        @include('tours.parts.product')
    @endforeach
</div>