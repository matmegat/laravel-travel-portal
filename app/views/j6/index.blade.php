<div class="{{ $class1 }}">
    <div
        class="index {{ $class2 }}"
        @if ($pageInfo['backgroundUrl'])
            style="background: url('{{$pageInfo['backgroundUrl']}}') no-repeat; background-size: 100%;"
        @endif
    >
        <div class="container">
            <header>
                <h2>{{ $pageInfo['title']; }}</h2>
                <div>{{ $pageInfo['content']; }}</div>
            </header>
            <div class="search_menu">
                @include('forms.home.search_tours')
            </div>
        </div>
    </div>
    <div class="content_results">
        <div class="container">
            <div class="section_results">
                @foreach ($tours as $tour)
                    <div class="result">
                        <div class="img">
                            @if (!empty($tour['images']))
                                <div id="myCarousel_{{ $tour['id'] }}" class="carousel slide" data-interval="false" data-ride="carousel">
                                    <!-- Carousel indicators -->
                                    <ol class="carousel-indicators">
                                        @for ($i = 0; $i < count($tour['images']); $i++)
                                            <li data-target="#myCarousel_{{ $tour['id'] }}" data-slide-to="{{ $i }}" {{ $i == 0 ? 'class="active"': '' }} ></li>
                                        @endfor
                                    </ol>
                                    <!-- Carousel items -->
                                    <div class="carousel-inner">
                                        @for ($i = 0; $i < count($tour['images']); $i++)
                                            <div class="{{ $i == 0 ? 'active': '' }} item">
                                                <img src="{{$tour['images'][$i]}}" data-thumb="img/empty.png" class="image-r"/>
                                            </div>
                                        @endfor
                                    </div>
                                    <!-- Carousel nav -->
                                    <a class="carousel-control left" href="#myCarousel_{{ $tour['id'] }}" data-slide="prev">
                                        <i class="fa fa-chevron-left"></i>
                                    </a>
                                    <a class="carousel-control right" href="#myCarousel_{{ $tour['id'] }}" data-slide="next">
                                        <i class="fa fa-chevron-right"></i>
                                    </a>
                                </div>
                            @else
                                <div class="no_image"><p>NO TOUR IMAGE</p></div>
                            @endif
                            <div class="rate">
                                <span>Rates from</span>
                                <p class="price">
                                    @if ($tour['maxPrice'] != $tour['minPrice'])
                                        ${{ $tour['minPrice'] }} - ${{ $tour['maxPrice'] }}
                                    @else
                                        ${{ $tour['minPrice'] }}
                                    @endif
                                    <span> AUD </span>
                                </p>
                            </div>
                            @if($tour['additional_info']!='' || $tour['additional_info']!=null)
                                <div class="aditional latent clear">
                                    <p><b>Additional Information</b></p>
                                    {{ StringHelper::clearText($tour['additional_info']) }}
                                </div>
                            @endif
                        </div>
                        <div class="info">
                            <span>{{$tour['small_title']}}</span>
                            <h2 title="{{$tour['name']}}">{{$tour['name']}}</h2>
                            <div class="description">
                                {{ StringHelper::clearText($tour['content']) }}
                            </div>
                            <div class='footer buttons view_more_info_narrow'>
                                <a href="{{action('ToursController@viewProduct', array('product' => $tour['id']))}}">
                                    <button type="button" class="btn btn-default btn-lg">View More Info</button>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if (empty($tours))
                    <div class="no_results">No Results</div>
                @endif

                {{ $tours->links() }}
            </div>
        </div>
    </div>
</div>