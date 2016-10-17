<div class="page-background" style="background-image: url({{ $backgroundImg }})">
	<div class="container">
		<h1>{{{ $pageInfo['title'] }}}</h1>
		<p>{{{ $pageInfo['content'] }}}</p>
	</div>
</div>

<div class="main-body">

	<div class="container home-tab-content page-tab-content">

		<div class="row">

			<div class="col-xs-12 tab active">
                @include('forms.home.search_tours')

                <div class="row main-list">
                    @if (empty($tours))
                        <div class="list-empty">No Results</div>
                    @else
                        @foreach ($tours as $tour)
                            <div class="col-md-12 item">
                                <div class="row">

                                    <div class="col-md-4 image">
                                        @if (!empty($tour['images']))
                                            <a href="{{ action('TourRezdyController@tour', array('id' => $tour['productCode'], 'account' => $account))}}">
                                                <img src="{{$tour['images'][0]['thumbnailUrl']}}" class="responsive">
                                            </a>
                                        @else
                                            <div class="no_image"><p>NO TOUR IMAGE</p></div>
                                        @endif
                                    </div>

                                    <div class="col-md-6 details">
                                        <span class="type">{{ array_get(\Config::get('rezdy.tourHeader'), $tour['account'], $tour['account']) }}</span>

                                        <h3><a href="{{ action('TourRezdyController@tour', array('id' => $tour['productCode'], 'account' => $account))}}">{{ $tour['name'] }}</a></h3>

                                        <div class="live-chat hide-mobile">
                                            <div data-id="77a25edc4c" class="livechat_button"><a href="https://www.livechatinc.com/customer-service/?partner=lc_1931882&amp;utm_source=chat_button">customer service</a></div>
                                        </div>

                                        <span class="length">Full Day</span>

                                        <p>{{{ $tour['shortDescription'] }}}</p>

                                        <a href="{{ action('TourRezdyController@tour', array('id' => $tour['productCode'], 'account' => $account))}}" class="more hide-mobile">View more info</a>

                                    </div>

                                    <div class="hide-desktop clearfix actions">
                                        <div class="col-xs-6 col-sm-6">
                                            <div class="live-chat">
                                                <div data-id="77a25edc4c" class="livechat_button"><a href="https://www.livechatinc.com/customer-service/?partner=lc_1931882&amp;utm_source=chat_button">customer service</a></div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6">
                                            <strong class="rate"><span>Rates from</span>${{ $tour['prices']['min']}} <span> AUD </span></strong>
                                        </div>
                                    </div>

                                    <div class="hide-desktop col-md-2">
                                        <a href="{{ action('TourRezdyController@tour', array('id' => $tour['productCode'], 'account' => $account))}}    " class="more">View more info</a>
                                    </div>

                                    <div class="hide-mobile col-md-2 actions">
                                        <strong class="rate"><span>Rates from</span>${{ $tour['prices']['min']}} <span> AUD </span></strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{ $tours->links() }}
                    @endif
                </div>
			</div>

		</div>

	</div>

</div>
