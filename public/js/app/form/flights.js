function showLoader() {
    $('body').oLoader({
        wholeWindow: true,
        lockOverflow: true,

        backgroundColor: '#000',
        fadeInTime: 500,
        fadeLevel: 0.4,
        image: '/img/library/oLoader/loader4.gif'
    });
}

function hideLoader() {
    $('body').oLoader('hide');
}

function checkFpCheckbox(chb) {
    chb.attr('checked', 'checked');
    chb.parent('.fp-checkbox').addClass('checked');
}

function unCheckFpCheckbox(chb) {
    chb.removeAttr('checked');
    chb.parent('.fp-checkbox').removeClass('checked');
}

function toggleFpCheckbox(chb) {
    if (chb.is(':checked')) {
        unCheckFpCheckbox(chb);
    } else {
        checkFpCheckbox(chb);
    }
}

function checkAllStops() {
    $('.flight-stop').each(function(ind, el) {
        checkFpCheckbox($(el));
    });
}

function convertMinutes2String(minutes) {
    return Math.ceil(minutes / 60) + ' hours';
}

function convertString2Minutes(value) {
    return Math.ceil(value);
}

function convertMinutes2TimeString(minutes) {
    var mins = minutes%60;
    if (mins < 10) {
        mins = '0' + mins;
    }
    return Math.floor(minutes / 60) + ':' + mins;
}

function getFilters() {
    var filters = {};

    //stops
    var stops = [];

    $('.flight-stop').each(function(ind, el) {
        if (typeof($(el).attr('checked')) != "undefined") {
            stops.push($(el).val());
        }
    });

    if (stops.length) {
        filters.stop_types = stops;
    }

    //airlines
    if ($('.airline_chb:checkbox:checked').size()) {
        var airs = [];

        $('.airline_chb:checkbox:checked').each(function(ind, el) {
            airs.push($(el).attr('code'));
        });

        filters.airline_codes = airs;
    }

    var to = $('.takeofftimes').val();
    filters.outbound_departure_day_time_min = parseInt(to[0]);
    filters.outbound_departure_day_time_max = parseInt(to[1]);

    var sdm = $('.stopovertime').val();
    filters.stopover_duration_min = parseInt(sdm[0]);
    filters.stopover_duration_max = parseInt(sdm[1]);

    var pmu = $('.flightprice').val();
    filters.price_min_usd = parseInt(pmu[0]);
    filters.price_max_usd = parseInt(pmu[1]);

    //duration_min
    var pmu = $('.travelduration').val();
    filters.duration_min = parseInt(pmu[0]);
    filters.duration_max = parseInt(pmu[1]);

    return filters;
}

function takeoffSlider() {
    var filter = FLIGHTS_SEARCH_FILTERS['outbound_departure_day_time_filter'];

    if (!filter) {
        return;
    }

    var min = filter['min'];
    var max = filter['max'];

    $('.takeofftimes').noUiSlider({
        start: [ min, max ],
        step: 5,
        connect: true,
        range: {
            min: [ min ],
            max: [ max ]
        }
    }).on('change', function(value) {
        $('#takeoff_out_start em').html(convertMinutes2TimeString($('.takeofftimes').val()[0]));
        $('#takeoff_out_end em').html(convertMinutes2TimeString($('.takeofftimes').val()[1]));

        updateFlightResults();
    });

    $('#takeoff_out_start em').html(convertMinutes2TimeString($('.takeofftimes').val()[0]));
    $('#takeoff_out_end em').html(convertMinutes2TimeString($('.takeofftimes').val()[1]));
}

function flightPriceSlider() {
    var filter = FLIGHTS_SEARCH_FILTERS['price_filter'];

    if (!filter) {
        return;
    }

    var min = filter['min'];
    var max = filter['max'];
    var curRatio = FLIGHTS_SEARCH_FILTERS['currency']['exchange_rate'];

    $('.flightprice').noUiSlider({
        start: [ min, max ],
        step: 1,
        connect: true,
        range: {
            'min': [ min ],
            'max': [ max ]
        },
        format: wNumb({
            decimals: 0,
            encoder: function(a) { return a * curRatio; }
        })
    }).on('change', function(value) {
        $('#price_start em').html('$' + $('.flightprice').val()[0]);
        $('#price_end em').html('$' + $('.flightprice').val()[1]);

        updateFlightResults();
    });

    $('#price_start em').html('$' + $('.flightprice').val()[0]);
    $('#price_end em').html('$' + $('.flightprice').val()[1]);
}

function stopOvertimeSlider() {
    var filter = FLIGHTS_SEARCH_FILTERS['stopover_duration_filter'];

    if (!filter) {
        return;
    }

    var min = filter['min'];
    var max = filter['max'];

    $('.stopovertime').noUiSlider({
        start: [ min, max ],
        step: 60,
        connect: true,
        range: {
            'min': [ min ],
            'max': [ max ]
        }
    }).on('change', function(value) {
        $('#stopovertime_start em').html(convertMinutes2String($('.stopovertime').val()[0]));
        $('#stopovertime_end em').html(convertMinutes2String($('.stopovertime').val()[1]));

        updateFlightResults();
    });

    $('#stopovertime_start em').html(convertMinutes2String($('.stopovertime').val()[0]));
    $('#stopovertime_end em').html(convertMinutes2String($('.stopovertime').val()[1]));
}

function travelDurationSlider() {
    var filter = FLIGHTS_SEARCH_FILTERS['duration_filter'];

    if (!filter) {
        return;
    }

    var min = filter['min'];
    var max = filter['max'];

    $('.travelduration').noUiSlider({
        start: [ min, max ],
        step: 60,
        connect: true,
        range: {
            'min': [ min ],
            'max': [ max ]
        }
    }).on('change', function(value) {
        $('#travelduration_start em').html(convertMinutes2String($('.travelduration').val()[0]));
        $('#travelduration_end em').html(convertMinutes2String($('.travelduration').val()[1]));

        updateFlightResults();
    });;

    $('#travelduration_start em').html(convertMinutes2String($('.travelduration').val()[0]));
    $('#travelduration_end em').html(convertMinutes2String($('.travelduration').val()[1]));
}

function createAirlinesList(airlines, filtered) {
    var cnt = 0;

    $.each(airlines, function(idx, elem) {
        cnt++;
        var code = elem['code'];
        var container = $('<div></div>');

        var achb = $('<input />', {
            type: 'checkbox',
            id: elem['code']+'_airlines',
            checked: $.inArray(code, filtered) !== -1,
            class: 'white airline_chb',
            code: elem['code']
        });

        achb.appendTo(container);
        $('<span>' + elem.name + '</span>').appendTo(container);
        container.appendTo($('#airlines'));
    });

    if (cnt === filtered.length) {
        checkFpCheckbox($('#all_airlines'));
    }
}

function setAirlinesFilter() {
    var airs = FLIGHTS_SEARCH_FILTERS['airline_filters'];

    if (!airs) {
        return;
    }

    var airCodes = FLIGHTS_SEARCH_DATA['airline_codes'];

    if (airCodes === undefined) {
        airCodes = [];

        $.each(airs, function(idx, elem) {
            airCodes.push(elem['code']);
        });
    }

    createAirlinesList(airs, airCodes);
}

function checkAllAirlines() {
    $('.airline_chb').each(function (ind, el) {
        checkFpCheckbox($(el));
    })
}

function updateFlightResults() {
    showLoader();

    var filters = getFilters();

    $.post(FLIGHTS_UPDATE_URL, {
        f: filters
    }, function(r) {

        $('#result-box').html(r);
        hideLoader();
        //if( history && history.replaceState ) {
        //    history.replaceState(null, document.title, window.FLIGHTS_SEARCH_URL);
        //}

        $('.flight-more-trigger').on('click', function(){
            $(this).parent().parent().next().toggle(100);
            return false;
        });

    }, 'html');
}

$(function() {
    $('.flight-more-trigger').on('click', function(){
        $(this).parent().parent().next().toggle(100);
        return false;
    });

    $( "#app-form-flights-search-departure" ).autocomplete({
        source: [{
            url: '/flights/airports?q=%QUERY%',
            type: 'remote'
        }],
        dropdownWidth: 'auto',
        valueKey: 'id',
        titleKey: 'text',
        filter: function (items, query, source) {
            return items;
        }
    });

    //stops checkboxes

    if ($('#one_way').is(':checked')) {
        $('#flights_to').hide();
    } else {
        $('#flights_to').show();
    }

    $('#one_way').click(function() {
        $('#flights_to').toggle();
    });

    // UI Sliders
    takeoffSlider();
    flightPriceSlider();
    stopOvertimeSlider();
    travelDurationSlider();

    setAirlinesFilter();

    if ($('#select_all').is(':checked')){
        checkAllStops();
    }

    $('.flight-stop').click(function(event) {
        event.stopPropagation();

        if ($(this).attr('checked')) {
            unCheckFpCheckbox($(this));
        } else {
            checkFpCheckbox($(this));
        }

        var countAll = 0;
        var countChecked = 0;
        $('.flight-stop').each(function(ind, el) {
            if (typeof($(el).attr('checked')) != "undefined") {
                countChecked++;
            }

            countAll++;
        });

        if (countChecked == 0) {
            //no chb selected
            checkAllStops();
        } else if (countAll > countChecked) {
            unCheckFpCheckbox($('#select_all'));
        } else {
            checkFpCheckbox($('#select_all'));
        }

        updateFlightResults();
    });

    $('#select_all').change(function() {
        if (this.checked) {
            checkAllStops();
        }

        updateFlightResults();
    });

    $('#all_airlines').change(function() {
        if (this.checked) {
            checkAllAirlines();
        }

        updateFlightResults();
    });

    $('.airline_chb').click(function(event) {
        event.stopPropagation();

        if (!$('.airline_chb:checkbox:checked').size()) {
            //no chb selected
            checkAllAirlines();
        } else {
            unCheckFpCheckbox($('#all_airlines'));

            if ($(this).attr('checked')) {
                unCheckFpCheckbox($(this));
            } else {
                checkFpCheckbox($(this));
            }
        }

        updateFlightResults();
    });
});