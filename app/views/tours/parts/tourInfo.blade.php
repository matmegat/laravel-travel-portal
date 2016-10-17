@extends('layouts.travel')

@section('content')

    @if (isset($tour['images']) && count($tour['images']) > 0)
        <div class="home-slider page-slider">
            <ul class="slides-container">
                @foreach ($tour['images'] as $key => $imageUrl)
                    <li><img src="{{ $imageUrl }}" alt=""></li>
                @endforeach
            </ul>
            <nav class="slides-navigation">
            <a href="#" class="next">Next</a>
            <a href="#" class="prev">Previous</a>
            </nav>
        </div>
    @endif

    <div class="main-body">

        <div class="container detailpage">

            <div class="row page-title">
                <div class="col-md-8">
                    <h1>{{{ $tour['name'] }}}</h1>
{{--                    <p>{{{ $tour['productTeaser'] }}}</p>--}}
                </div>
                <div class="col-md-4">
                    <a id="scroll-down" href="{{ action('ToursController@book', array('id' => $tour['productId'], 'priceId' => $tour['quickFaresprice']['productPricesDetailsId'])) }}" class="button yellow">Book Now</a>
                </div>
            </div>

            <div class="row">

                <aside class="col-md-4 col-md-push-2">

                    <form class="formplate">
                        <h5>Check Availability</h5>

                        {{--<label>Date</label>--}}
                        {{--<input type="text" placeholder="Start date" class="limitdate datepicker">--}}

                        <label>Number of People</label>
                        <div class="input-number-contain">
                            <span class="input-number-decrement">-</span>
                            <input class="input-number" name="qty" id="qty" type="text" value="1" min="0" max="10">
                            <span class="input-number-increment">+</span>
                        </div>

                        <label>Fare name</label>
                        <select name="optionId" class="form-control">
                            @foreach ($tour['faresprices'] as $faresprice)
                                <option
                                    price="{{ $faresprice['rrp'] }}"
                                    value="{{ $faresprice['productPricesDetailsId'] }}"
                                    data-id="{{{ $faresprice['productPricesDetailsId'] }}}"
                                    data-action="{{ action('ToursController@book', array('id' => $tour['productId'] )) }}"
                                >{{ $faresprice['rrp'] }} ({{ $faresprice['currencyCode'] }}) {{ $faresprice['fareName'] }}</option>
                            @endforeach
                        </select>

                        <span class="price"></span>
                    </form>
                    {{--@if ($tour['productClass'] == 'Z')--}}
                        {{--<label>Package</label>--}}
                        {{--<select name="optionId" class="form-control">--}}
                            {{--@foreach ($tour['faresprices'] as $faresprice)--}}
                                {{--<option price="{{ $faresprice['rrp'] }}" value="{{ $faresprice['productPricesDetailsId'] }}">{{ $faresprice['rrp'] }} ({{ $faresprice['currencyCode'] }}) {{ $faresprice['fareName'] }}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--@endif--}}
                    {{----}}
                    @if ($tour['productClass'] == 'Z')
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 package">
                            @foreach ($value['productPricesDetails']['options'] as $option)
                                <select data-key="{{ $key }}" class="form-control packageProduct">
                                    @foreach ($option['packageProducts'] as $packageProduct)
                                        <option value="{{{ $packageProduct['productPricesDetailsId'] }}}">{{{ $packageProduct['productName'] }}}</option>
                                    @endforeach
                                </select>
                            @endforeach
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 book">
                            <input
                                type="submit"
                                class="btn-default btn book_now"
                                value="BOOK NOW"
                                data-key="{{ $key }}"
                                data-action="{{ action('ToursController@book', array('id' => $tour['productId'] )) }}"
                                />
                        </div>
                    @else
                        <a href="#" class="book_now button yellow">Book Now</a>
                    @endif

                </aside>

                <article class="col-md-8">

                    {{ $tour['productDetails'] }}

                    <h5>Details</h5>
                    <ul class="amenities clearfix">
                        <li><strong>Duration:</strong> {{{ $tour['quickFaresprice']['tripDuration'] }}} @if ($tour['quickFaresprice']['tripDuration'] > 1) Days @else Day @endif</li>
                        <li><strong>Max Guests:</strong> @if ($tour['quickFaresprice']['numPax'] > 0){{{ $tour['quickFaresprice']['numPax'] }}} People @else Unlimited@endif</li>
                    </ul>

                    @if ($tour['pickups'])
                        <h5>Pickups</h5>
                        {{ $tour['pickups'] }}
                    @endif

                    @if ($tour['instructions'])
                        <h5>Instructions</h5>
                        {{ $tour['instructions'] }}
                    @endif

                    @if ($tour['itinerary'])
                        <h5>Itinerary</h5>
                        {{ $tour['itinerary'] }}
                    @endif
                </article>

            </div>


        </div>

    </div>

<script>
    $(document).ready(function(){
        $(".book_now").click(function(e) {
            e.preventDefault();

            var fare = $("select[name=optionId]").find("option:selected");
            var action = fare.attr('data-action');

            var priceIds = [];
            if (fare.attr('data-id')) {
                priceIds.push(fare.attr('data-id'));
            } else {
                var key = $(this).attr('data-key');
                $('.packageProduct[data-key=' + key + ']').each(function() {
                    priceIds.push($(this).val());
                });
            }

            action = action + '?priceId=' + priceIds.join(',');

            action += "&qty=" + $('#qty').val();

            window.location = action;
        });
    });

    $(document).ready(function() {
        $('a.book').click(function(){
            $("#frmBook").submit();
            return false;
        });

        $("select[name=optionId]").change(function(){
            setPrice();
        });
        setPrice();

        $(".input-number-decrement").click(setPrice);
        $(".input-number-increment").click(setPrice);
    });

    function setPrice() {
        var price = $("select[name=optionId]").find("option:selected").attr('price');
        var qty = $("input[name=qty]").val();

        if (qty < 1) {
            $("input[name=qty]").val(1);
            return;
        }

        $("span.price").html("$" + (price*qty) + " (AUD)");
    }
</script>
@stop