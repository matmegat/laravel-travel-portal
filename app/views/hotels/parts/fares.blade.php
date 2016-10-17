<div class="col-md-12 item">

    <div class="row">
        <div class="col-md-4 image">
            @if (!empty($hotel['details']['hotel']['image']))
                <a href="{{action('HotelsController@hotelDetail', array('search_id' => $search_id, 'hotel_id' => $hotel['id']))}}">
                    <img src="{{ StringHelper::secureImageUrl($hotel['details']['hotel']['image']) }}" class="responsive" />
                </a>
            @else
                <div class="no_image">NO HOTEL IMAGE</div>
            @endif
        </div>

        <div class="col-md-6 details">
            <span class="type">{{'ACCOMODATION'}}</span>

            <h3><a href="{{action('HotelsController@hotelDetail', array('search_id' => $search_id, 'hotel_id' => $hotel['id']))}}">{{$hotel['name']}} <small>{{$hotel['address']}}</small></a></h3>

            <span class="star hide-mobile" data-score="{{$hotel['stars']}}"></span>

            <div class="description">
                @if(count($description = explode('<hr />', $hotel['desc']))>1)
               {{$description['0']}}
               <p class="latent">
               {{$description['1']}}
               </p>
               @else
               {{$description['0']}}
               @endif
            </div>

            <a href="{{action('HotelsController@hotelDetail', array('search_id' => $search_id, 'hotel_id' => $hotel['id']))}}   " class="more hide-mobile">View more info</a>

        </div>

        <div class="hide-desktop clearfix actions">
            <div class="col-xs-6 col-sm-6">
                <span class="star" data-score="{{$hotel['stars']}}"></span>
            </div>
            <div class="col-xs-6 col-sm-6">
                <strong class="rate">
                    @if (!empty($hotel['details']['hotel']['room_rate_min']['price_str']))
                        <span>Best rate</span>${{ (int)$hotel['details']['hotel']['room_rate_min']['price_str'] }}
                    @else
                        <span>No price</span>
                    @endif
                </strong>
            </div>
        </div>

        <div class="hide-desktop col-md-2">
            <a href="{{action('HotelsController@hotelDetail', array('search_id' => $search_id, 'hotel_id' => $hotel['id']))}}" class="more">View more info</a>
        </div>

        <div class="hide-mobile col-md-2 actions">
            <strong class="rate">
                @if (!empty($hotel['details']['hotel']['room_rate_min']['price_str']))
                    <span>Best rate</span>${{ (int)$hotel['details']['hotel']['room_rate_min']['price_str'] }}
                @else
                    <span>No price</span>
                @endif
            </strong>
        </div>
    </div>

</div>