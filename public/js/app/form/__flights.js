var PROGRESS_BAR_INTERVAL = null;

function updateFlightResults(load, progressBar) {

    var progressBar = (typeof progressBar === "undefined") ? true : progressBar;

    if (progressBar) {
        showProgressBar();
    }

    $.post(window.FLIGHTS_UPDATE_URL, {
        f: window.FLIGHTS_SEARCH_DATA,
        load: load
    }, function(r){
        if (progressBar) {
            hideProgressBar();
        }

        $('#result-box').html(r);
        if( history && history.replaceState ) {
            history.replaceState(null, document.title, window.FLIGHTS_SEARCH_URL);
        }
    }, 'html');
}

function getFilterVal(name, def) {
    if( typeof window.FLIGHTS_SEARCH_DATA[ name ] != 'undefined' ) {
        return window.FLIGHTS_SEARCH_DATA[ name ];
    }

    return def;
}

function setFilterVal(name, value) {
    window.FLIGHTS_SEARCH_DATA[ name ] = value;
}

function waitingForFare(timeLeft) {
    //var waitingTime = (15 - timeLeft) * 1000;
    var waitingTime = (15 - timeLeft) * 100000;

    setTimeout(function() {
        updateFlightResults('', false);
    }, waitingTime);

}

function hideProgressBar() {
    window.clearInterval(PROGRESS_BAR_INTERVAL);

    $('#flights-progress-bar')
        .css('width', $('.progress').width() + 'px');
    setTimeout( function() {
        $('#flights-progress').hide();
        $('#flights-progress-bar').css('width','0px');
        window.PROGRESS_BAR_CURRENT = 0;
    }, 1000);
}

function showProgressBar() {
    window.PROGRESS_BAR_CURRENT = 0;
    window.clearInterval(PROGRESS_BAR_INTERVAL);

    PROGRESS_BAR_INTERVAL = window.setInterval(function() {
        window.PROGRESS_BAR_CURRENT = window.PROGRESS_BAR_CURRENT + 500

        if (window.PROGRESS_BAR_CURRENT < 15000) {
            $('#flights-progress').show();
            $('#flights-progress-bar')
                .css('width', Math.floor((window.PROGRESS_BAR_CURRENT / 15000) * $('.progress').width()) + 'px');
        } else {
            $('#flights-progress').hide();
            window.clearInterval(PROGRESS_BAR_INTERVAL)
        }
    }, 500);

}

function array_unique(array){
    return $.grep(array, function(el, index) {
        return index == $.inArray(el, array);
    });
}

function setRange(selector, filters, propName1, propName2, filterName, range_min_name, range_max_name, cbVals, cbValsBack, cbDisp) {
    if( filters[filterName] ) {
        var minVal = getFilterVal(propName1, filters[filterName][range_min_name]);
        var maxVal = getFilterVal(propName2, filters[filterName][range_max_name]);

        var valsRange = {
            min: minVal,
            max: maxVal
        };

        var totalRange = {
            min: filters[filterName][range_min_name],
            max: filters[filterName][range_max_name]
        };

        if( typeof cbVals == 'function' ) {
            valsRange = cbVals(minVal, maxVal);
            totalRange = cbVals(filters[filterName][range_min_name], filters[filterName][range_max_name]);
        }

        if( typeof cbDisp == 'function' ) {
            cbDisp(valsRange.min, valsRange.max);
        }

        $(selector).slider({
            range: true,
            min: totalRange.min,
            max: totalRange.max,
            values: [ valsRange.min, valsRange.max ],
            slide: function (event, ui) {
                var back = {
                    min: ui.values[ 0 ],
                    max: ui.values[ 1 ]
                };
                if( typeof cbValsBack == 'function' ) {
                    back = cbValsBack( back.min, back.max );
                }

                if( typeof cbDisp == 'function' ) {
                    cbDisp(ui.values[ 0 ], ui.values[ 1 ]);
                }

                setFilterVal(propName1, back.min);
                setFilterVal(propName2, back.max);
            },
            stop: function (event, ui) {
                updateFlightResults();
            }
        });
    }
}

function updateFlightFilters(filters) {
    
    

    if( !filters ) {
        return;
    }
    //console.log(filters);
    //price
    setRange('#price-range', filters, 'price_min_usd', 'price_max_usd', 'price_filter', 'min_usd', 'max_usd',
        function(min, max){
            var curRatio = filters['currency']['exchange_rate'];
            // convert USD -> AUD
            return {
                min: Math.floor( min * curRatio ),
                max: Math.ceil( max * curRatio )
            };
        },
        function(min, max){
            var curRatio = filters['currency']['exchange_rate'];
            // convert AUD -> USD
            return {
                min: Math.floor( min / curRatio ),
                max: Math.floor( max / curRatio )
            };
        },
        function(min, max){
            $("#price_start").html("$" + min);
            $("#price_end").html("$" + max);
        }
    );

    //takeoff departure
    setRange('#takeoff-out-range', filters,
        'outbound_departure_day_time_min', 'outbound_departure_day_time_max',
        'outbound_departure_day_time_filter', 'min', 'max',
        function(min,max){return {min:Math.floor(min/60),max:Math.ceil(max/60)};},
        function(min,max){return {min:Math.floor(min*60),max:Math.ceil(max*60)};},
        function(min,max){
            $("#takeoff_out_start").html("" + min + ":00"); 
            $("#takeoff_out_end").html("" + max + ":00");}
    );

    //takeoff arrival
    setRange('#takeoff-in-range', filters,
        'inbound_departure_day_time_min', 'inbound_departure_day_time_max',
        'inbound_departure_day_time_filter', 'min', 'max',
        function(min,max){return {min:Math.floor(min/60),max:Math.ceil(max/60)};},
        function(min,max){return {min:Math.floor(min*60),max:Math.ceil(max*60)};},
        function(min,max){$("#takeoff_in_start").html("" + min + ":00"); $("#takeoff_in_end").html("" + max + ":00");}
    );

    //stopover duration
    setRange('#stopover-duration-range', filters,
        'stopover_duration_min', 'stopover_duration_max',
        'stopover_duration_filter', 'min', 'max',
        function(min,max){return {min:Math.floor(min/60),max:Math.ceil(max/60)};},
        function(min,max){return {min:Math.floor(min*60),max:Math.ceil(max*60)};},
        function(min,max){$("#stopover_duration_start").html(minutes(min*60));$("#stopover_duration_end").html(minutes(max*60));}
    );

    //trip duration
    setRange('#trip-duration-range', filters,
        'duration_min', 'duration_max',
        'duration_filter', 'min', 'max',
        function(min,max){return {min:Math.floor(min/60),max:Math.ceil(max/60)};},
        function(min,max){return {min:Math.floor(min*60),max:Math.ceil(max*60)};},
        function(min,max){$("#trip_duration_start").html(minutes(min*60));$("#trip_duration_end").html(minutes(max*60));}
    );
/*
|***************************************************************************|
|**********                   AIRLINES START                   *************|
|***************************************************************************|
*/

    if( typeof filters['airline_filters'] !== 'undefined' ) {
        var airlines = filters['airline_filters'];
    } else {
        var airlines = [];
    }
    var all_airlines = [];
    var first_airline = [];
    $.each(airlines,function(idx,elem){
        all_airlines.push(elem['code']);
    });

    var airs = getFilterVal('airline_codes', all_airlines);

    //console.log(airs);
    $("#airlines").html('');
    $("#all_airlines").off('click').one('click', function() {
        if( $(this).is(':checked') ) {
            $(this).parent().find("label").addClass('checked');
            $.each(airlines,function(idx,elem){
                all_airlines.push(elem['code']);
            });
            setFilterVal('airline_codes', all_airlines);
        } else {
            $(this).parent().find("label").removeClass('checked');
            $(this).parent().find("#airlines label:first-child").addClass('checked');
            first_airline.push(airlines[0]['code']);
            setFilterVal('airline_codes', first_airline);
        }

        updateFlightResults();
    });
    
     $.each(airlines,function(idx,elem){

        var checked = '';
        var val = elem['code'];
            if($.inArray(val, airs) !== -1) {
                $('#'+val+'_airlines').prop('checked', true);
                $('#'+val+'_airlines').parent().addClass("checked");
                checked = 'checked';
            } else {
                $('#'+val+'_airlines').removeAttr('checked');
                $('#'+val+'_airlines').parent().removeClass("checked");
            }

        var html = $("#airlines").html();
        $("#airlines").html( html + '<label for="'+elem['code']+'_airlines" class="checkbox-inline"><input id="'+elem['code']+'_airlines" type="checkbox" '+checked+' />'+elem['name']+'</label><br />');
       
         //console.log(this);
         //
         airs = array_unique(airs);
        $('body').off('click', '#'+elem['code']+'_airlines').one( 'click' , '#'+elem['code']+'_airlines' , function(){
            $('#'+elem['code']+'_airlines').unbind();
            //alert('sds');
            if( $(this).is(':checked') ) {
                $('#'+val+'_airlines').parent().addClass("checked");

                airs.push(val);
                if( airs.length === airlines.length) {
                    $('#all_airlines').prop('checked', true);
                    $('#all_airlines').parent().addClass("checked");
                }
                airs = array_unique(airs);
            } else {
                $('#'+val+'_airlines').parent().removeClass("checked");
                $("#all_airlines").parent().removeClass("checked");
                $('#all_airlines').removeAttr('checked');
                airs = array_unique(airs);
                var index = airs.indexOf(val);
                if (index > -1) {
                    airs.splice(index, 1);
                }
            }

            airs = array_unique(airs);
            //console.log(FLIGHTS_UPDATE_URL);
            setFilterVal('airline_codes', airs);
            updateFlightResults('load');
        });
        //console.log(airs.length, airlines.length);
        if( airs.length === airlines.length) {
            $('#all_airlines').prop('checked', true);
            $('#all_airlines').parent().addClass("checked");
        } else {
            $("#all_airlines").parent().removeClass("checked");
            $('#all_airlines').removeAttr('checked');
        }
     });
/*
|***************************************************************************|
|**********                   AIRLINES END                     *************|
|***************************************************************************|
*/

/*
|***************************************************************************|
|**********                   STOPS START                      *************|
|***************************************************************************|
*/

    $('#select_all').off('click').one('click', function(e){
        if( $(this).is(':checked') ) {
            $(this).parent().parent().find("input").addClass('checked');
            var all_stops = ['none','one','two_plus'];
            all_stops = array_unique(all_stops);
            setFilterVal('stop_types', all_stops);
        } else {
            $(this).parent().parent().find("label").removeClass('checked');
            $(this).parent().parent().find("label:last-child").addClass('checked');
            var first_stop = [];
            first_stop.push('two_plus');
            setFilterVal('stop_types', first_stop);
        }

        updateFlightResults('load');

    });


    // stops
    var stops = getFilterVal('stop_types', ['two_plus']);

    $.each(['none','one','two_plus'],function(idx,elem){
        var val = elem;
        if($.inArray(val, stops) != -1) {
            $('#flight-stop-' + elem).prop('checked', true);
            $('#flight-stop-' + elem).addClass("checked");
        } else {
            $('#flight-stop-' + elem).removeAttr('checked');
            $('#flight-stop-' + elem).removeClass("checked");
        }
        stops = array_unique(stops);
        $('#flight-stop-' + elem).off('click').one('click', function(){
            if( $(this).is(':checked') ) {
                $('#flight-stop-' + val).addClass("checked");
                stops.push(val);
                if( stops.length === 3) {
                    $('#select_all').prop('checked', true);
                    $('#select_all').addClass("checked");
                }
                stops = array_unique(stops);
            } else {
            $('#flight-stop-' + val).removeClass("checked");
            $('#select_all').removeClass("checked");
            $('#select_all').removeAttr('checked');
                var index = stops.indexOf(val);
                if (index > -1) {
                    stops.splice(index, 1);
                }
            }

            setFilterVal('stop_types', stops);
            updateFlightResults('load');
        });

        if( stops.length === 3) {
            $('#select_all').prop('checked', true);
            $('#select_all').addClass("checked");
        } else {
            $("#select_all").removeClass("checked");
            $('#select_all').removeAttr('checked');
        }
    });
/*
|***************************************************************************|
|**********                   STOPS END                        *************|
|***************************************************************************|
*/

    $('body').off('click', '.price').one('click', '.price', function(){
        var self = $(this).find('img');
        if(self.hasClass("price_rotate")){
            self.removeClass('price_rotate');
            setFilterVal('order', 'asc');
        } else {
            self.addClass('price_rotate');
            setFilterVal('order', 'desc');
        }
        updateFlightResults('load');
    });

    $('.dropdown_item_currency').off('click').one('click' , function(){
        var self = $(this);
        if(self.hasClass("selected_option")){
        } else {
            var val = self.find('p').text();
            var id = self.find('input').val();
            self.parent().find('.selected_option').removeClass('selected_option');
            self.addClass('selected_option');
            self.parent().parent().find(".select").val(val);
            self.parent().parent().find(".select_id").val(id);
            setFilterVal('currency_code', id);
            console.log(getFilterVal('currency_code'));
            updateFlightResults('load');
        }
    });
}

function formatMinutes(minutes) {
    var minutesString;
    minutesString = (minutes % 60) + 'm';
    if (minutes >= 60) {
        return Math.floor(minutes / 60) + 'h' + minutesString;
    } else {
        return minutesString;
    }
};

function minutes(minutes) {
    var minutesString;
    if(minutes % 60 == 0){
        minutesString = (minutes % 60)+'0' + 'min';
    } else {
        minutesString = (minutes % 60) + 'min';
    }
    if (minutes >= 60) {
        return Math.floor(minutes / 60) + 'h ' + minutesString;
    } else {
        return minutesString;
    }
};

function getFlightsDetails(segments) {
    var arrival_timezone_diff, current_timezone_offset, departure_timezone_diff, shared, takeoff_day, trips;
    current_timezone_offset = (new Date()).getTimezoneOffset();
    departure_timezone_diff = 0 - ((current_timezone_offset - moment(segments[0].departure_time)._tzm) / 60);
    arrival_timezone_diff = 0 - ((current_timezone_offset - moment(segments[0].arrival_time)._tzm) / 60);
    takeoff_day = new Date(moment(segments[0].departure_time));
    takeoff_day.setHours(takeoff_day.getHours() - departure_timezone_diff);
    shared = {
        outbound_day: $.datepicker.formatDate('D d M yy', takeoff_day),
        duration: formatMinutes(moment.duration(moment(_.last(segments).arrival_time) - moment(segments[0].departure_time)).asMinutes())
    };
    trips = _.map(segments, function(segment, index, list) {
        var arrival_day, arrival_time, departure_day, departure_time;
        departure_time = moment(segment.departure_time).zone(segment.departure_time);
        arrival_time = moment(segment.arrival_time).zone(segment.arrival_time);
        departure_day = new Date(departure_time);
        departure_day.setHours(departure_day.getHours() - departure_timezone_diff);
        arrival_day = new Date(arrival_time);
        arrival_day.setHours(arrival_day.getHours() - arrival_timezone_diff);
        return {
            departure_time: $.datepicker.formatDate('D d M', departure_day) + ', ' + departure_time.format('HH:mm'),
            departure_code: segment.departure_code,
            departure_name: segment.departure_name,
            arrival_time: $.datepicker.formatDate('D d M', arrival_day) + ', ' + arrival_time.format('HH:mm'),
            arrival_code: segment.arrival_code,
            arrival_name: segment.arrival_name,
            airline_code: segment.airline_code,
            aircraft_type: segment.aircraft_type,
            designator_code: segment.designator_code,
            same_day: departure_time.isSame(arrival_time, 'day'),
            duration: formatMinutes(moment.duration(arrival_time - departure_time).asMinutes()),
            layover: index !== 0 ? {
                time: formatMinutes(moment.duration(departure_time - moment(segments[index - 1].arrival_time).zone(segments[index - 1].arrival_time)).asMinutes()),
                place: segment.departure_name
            } : void 0,
            operating_airline_name: segment.operating_airline_name
        };
    });
    return _.extend(shared, {
        trips: trips
    });
}

(function ($) {
    $(function () {
        $('#app-form-flights-search-departure,#app-form-flights-search-arrival').select2({
            minimumInputLength: 1,
            ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                url: "/flights/airports",
                dataType: 'json',
                data: function (term, page) {
                    return {
                        q: term,
                        page_limit: 10
                    };
                },
                results: function (data, page) {
                    return {'results': data};
                }
            },
            initSelection: function (element, callback) {
                var id = $(element).val();
                if (id !== '') {
                    $.ajax('/flights/airports/' + id, {
                        dataType: "json"
                    }).done(function (data) {
                        callback(data);
                    });
                }
            }
        });

        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        $('.app-form-flights-search').each(function () {

            var el_outbound = $(this).find('.app-form-flights-search-outbound');
            var el_inbound = $(this).find('.app-form-flights-search-inbound');

            var outbound = el_outbound.datepicker({
                onRender: function (date) {
                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate',function (ev) {
                    if (ev.date.valueOf() > inbound.date.valueOf()) {
                        var newDate = new Date(ev.date)
                        newDate.setDate(newDate.getDate() + 1);
                        inbound.setValue(newDate);
                    }
                    outbound.hide();

                    el_inbound.focus();
                }).data('datepicker');

            var inbound = el_inbound.datepicker({
                onRender: function (date) {
                    return date.valueOf() <= outbound.date.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate',function (ev) {
                    inbound.hide();
                }).data('datepicker');

        });

        $('#result-box').on('click', '.flights-details-item', function(){
            var self = $(this);
            var key = self.attr('data-key');
            var html = Mustache.to_html($('#route-item-details-template').html(), {
                outbound: getFlightsDetails( window.FLIGHTS_ROUTES[key]['outbound'] ),
                book_link: window.FLIGHTS_ROUTES[key]['book_link'],
                inbound: !_.isEmpty(window.FLIGHTS_ROUTES[key]['inbound']) ? getFlightsDetails( window.FLIGHTS_ROUTES[key]['inbound'] ) : void 0
            });
            self.find(".item_description").html(html);
        });

        $('.app-form-flights-search-inbound').prop('disabled', !$('#round_trip').is(':checked'));
        $('#round_trip').click(function(){
            $('.app-form-flights-search-inbound').prop('disabled', !$(this).is(':checked'));
        });
    });
})(jQuery);
