<div id="carousel-news-{{ $award->id }}" class="carousel slide" data-interval="false" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        @foreach ($award->photos as $photo)
            <li data-target="#carousel-news-{{ $award->id }}" data-slide-to="{{ $photo['id'] }}" class="<?= $photo['is_primary'] ? 'active' : '' ?>"></li>
        @endforeach
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        @foreach ($award->photos as $photo)
            <div class="item <?= $photo['is_primary'] ? 'active' : '' ?>">
                <img src="{{{ $photo['url'] }}}">
                <div class="carousel-caption">
                    <h4>{{{ $photo['caption'] }}}</h4>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-news-{{ $award->id }}" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-news-{{ $award->id }}" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>