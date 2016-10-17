@if (count($sessions) > 0)
    @foreach($sessions as $session)
        <form
            method="get"
            action="{{ action('TourRezdyController@book', array(
                'id'       => $productCode,
                'account'  => $account,
            )) }}"
            class="form-inline next-10-events"
        >
            <input type="hidden" name="sessionId" value="{{ $session['id'] }}"/>
            <input type="hidden" name="startTime" value="{{ $session['startTime'] }}"/>

            <div class="row dates">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 day">
                    <h1>{{ date("d", strtotime($session['startTime'])) }}</h1>
                    <p>{{ date("M", strtotime($session['startTime'])) }} </p>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 qty">
                    <input type="text" name="qty" value="1" class="form-control" placeholder="">
                    <p>of {{ $session['seatsAvailable'] }}</p>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 package">
                    <select name="optionId" class="form-control">
                        @foreach ($session['priceOptions'] as $priceKey => $priceOption)
                            <option value="{{ $priceKey }}">${{ $priceOption['price'] }} {{ $priceOption['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-3 book">
                    <button class="book_now">Book Now</button>
                </div>
            </div>
        </form>
    @endforeach
@else
    @if (!empty($travelMonth))
        <p>No options available for selected travel date.</p>
    @else
        <p>No options available for selected months.</p>
    @endif
@endif