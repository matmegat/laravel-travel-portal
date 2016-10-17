@if (count($news->photos) == 1)
    <p>
        <img src="{{{ $news->primary_photo['url'] }}}">
    </p>
@elseif (count($news->photos) > 1)
    <div id="carousel-news-{{ $news->id }}" class="carousel slide" data-interval="false" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @foreach ($news->photos as $photo)
                <li data-target="#carousel-news-{{ $news->id }}" data-slide-to="{{ $photo['id'] }}" class="<?= $photo['is_primary'] ? 'active' : '' ?>"></li>
            @endforeach
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            @foreach ($news->photos as $photo)
                <div class="item <?= $photo['is_primary'] ? 'active' : '' ?>">
                    <img src="{{{ $photo['url'] }}}" alt="...">
                    <div class="carousel-caption">
                        <h4>{{{ $photo['caption'] }}}</h4>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-news-{{ $news->id }}" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-news-{{ $news->id }}" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
@endif