@extends('layouts.travel')

@section('title'){{ $item['name'] }} @stop

@section('content')
    @if (isset($item['images']) && count($item['images']) > 0)
        <div class="home-slider page-slider">
            <ul class="slides-container">
                @foreach ($item['images'] as $key => $photo)
                    <li><img src="{{ $photo['itemUrl'] }}" alt=""></li>
                @endforeach
            </ul>
            <nav class="slides-navigation">
            <a href="#" class="next">Next</a>
            <a href="#" class="prev">Previous</a>
            </nav>
        </div>
    @else
        <div class="page-background nointro">

        </div>
    @endif

    <div class="main-body">

        <div class="container detailpage">
            <div class="row page-title">
                <div class="col-md-8">
                    <h1>{{ $item['name'] }}</h1>
                    {{--<p>Half Day - Afternoon</p>--}}
                </div>
                <div class="col-md-4">
                    <a id="scroll-down" href="#" class="button yellow">Book Now</a>
                </div>
            </div>
            @if($errors->first())
                <div class="notification">
                    <p>{{$errors->first()}}</p>
                </div>
            @endif
            <div class="row">

                <aside class="col-md-4 col-md-push-2">

                    <form
                        id="frmBook"
                        method="get"
                        action="{{ action('TourRezdyController@book', array(
                            'id'       => $item['productCode'],
                            'account'  => $account,
                        )) }}"
                        class="formplate"
                    >
                        <h5>Check Availability</h5>

                        <label>Date</label>
                        <input type="text" name="startTime" placeholder="Start date" class="limitdate">

                        <label>Number of People</label>
                        <div class="input-number-contain">
                            <span class="input-number-decrement">-</span>
                            <input class="input-number" type="text" name="qty" value="1" min="0" max="10">
                            <span class="input-number-increment">+</span>
                        </div>

                        <label>Package</label>
                        <select name="optionId" class="form-control">
                            @foreach ($item['priceOptions'] as $priceKey => $priceOption)
                                <option data-price="{{ $priceOption['price'] }}" value="{{ $priceKey }}" data-seatsused="{{ isset($priceOption['seatsUsed']) ? intval($priceOption['seatsUsed']) : 1 }}">${{ $priceOption['price'] }} {{ $priceOption['label'] }}</option>
                            @endforeach
                        </select>
                    </form>

                    <span class="price"></span>

                    <a href="#" class="book button yellow">Book Now</a>

                </aside>

                <article class="col-md-8">
                    @include('layouts.partials._messages')

                    {{ $item['description'] }}
                </article>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script>

        var account = '{{ $account }}';
        var accountid = '{{ $accountid }}';
        var datelist = {{ json_encode($weekends) }};

        $(document).ready(function() {
            $('.limitdate').val(datelist[0]);
            $('.limitdate').datepicker({
                defaultDate: datelist[0],
                minDate: new Date(),
                dateFormat: 'dd.mm.yy',
                beforeShowDay: function(mydate  , inst) {
                    return checkAvailability(mydate);
                },
                onChangeMonthYear: function(year, month, inst) {
                    loadAvailability(account, accountid, year+'-'+(month<10 ? '0'+month.toString() : month ));
                }
            });

            function loadAvailability(account, id, date) {
                $.ajax('/tour-availability/'+account+'/'+id+'/'+date, {
                    async: false,
                    dataType: 'json'
                }).done(function (data) {
                    datelist = $.extend(true, datelist, data);
                    $('.limitdate').datepicker("refresh");
                });
            }

            function checkAvailability(d)
            {
                // normalize the date for searching in array
                var dmy = ("00" + d.getDate()).slice(-2) + ".";
                dmy += ("00" + (d.getMonth() + 1)).slice(-2) + ".";
                dmy += d.getFullYear();

                if ($.inArray(dmy, datelist) >= 0) {
                    return [true, ""];
                }
                else {
                    return [false, ""];
                }
            }

            $('a.book').click(function(){
                $("#frmBook").submit();
                return false;
            });

            $("select[name=optionId]").change(function(){
                setPrice(1);
            });
            setPrice(1);

            $(".input-number-decrement").click(setDecPrice);
            $(".input-number-increment").click(setIncPrice);

            var preBookError = $('.notification');
            if (preBookError.length > 0) {
                preBookError.offset({top:110, left:110})
                preBookError.addClass('active');
                window.setTimeout(function(){
                    $('.notification').attr('style', '');
                    $('.notification').removeClass('active');
                }, 5000);
            }
        });

        function setDecPrice() { setPrice(-1); }
        function setIncPrice() { setPrice(1); }

        function setPrice(step) {
            var qty = parseInt($("input[name=qty]").val());
            var price = parseFloat($("select[name=optionId]").find("option:selected").data('price'));
            var seatsUsed = parseInt($("select[name=optionId]").find("option:selected").data('seatsused'));

            if (qty < 1) {
                qty = 1;
            }

            if (seatsUsed > 1) {
                var min = qty%seatsUsed;
                if (min != 0 && step == 1) {
                    qty += 1;
                } else {
                    qty -= 1;
                }

                if (qty%seatsUsed != 0) {
                    qty += 1;
                }
            }

            if (qty == 0) {
                return setPrice(1);
            }

            var seats = qty/seatsUsed;
            var priceOutput = seats*price;

            $("input[name=qty]").val(qty);
            $("span.price").html("$" + priceOutput + " (AUD)");
        }

    </script>
@stop