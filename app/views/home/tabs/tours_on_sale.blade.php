@include('forms.home.search_tours', array('url' => '/tours/search'))

<div class="row main-list">
    @foreach ($toursSale as $product)
        @include('tours.parts.product')
    @endforeach
</div>