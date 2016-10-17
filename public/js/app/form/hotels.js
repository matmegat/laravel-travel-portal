function refreshResults(interval, url) {
    window.setTimeout(function() {
        updateHotelsResults(interval, url);
    }, interval);
}

function updateHotelsResults(interval, url) {
    $.post(
        url,
        function (r) {
            if (r == 'refresh') {
                refreshResults(interval, url);
            } else {
                $('#result-box').html(r);
            }
        },
        'html'
    );
}

function array_unique(array) {
    return $.grep(array, function (el, index) {
        return index == $.inArray(el, array);
    });
}

(function ($) {
    $(function () {
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        $('.app-form-hotels-search').each(function () {

            var el_outbound = $(this).find('.app-form-hotels-search-outbound');
            var el_inbound = $(this).find('.app-form-hotels-search-inbound');

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

        if (typeof window.HOTELS_SEARCH_TIME_LEFT != 'undefined') {
            var timeLeft = window.HOTELS_SEARCH_TIME_LEFT;
            if (timeLeft < 30000) {
                $('#hotels-progress').fadeIn();

                $('#hotels-progress-bar')
                    .css('width', Math.floor((timeLeft / 30000) * $('.progress').width()) + 'px')
                    .animate({ width: $('.progress').width() }, {
                        complete: function () {
                            $('#hotels-progress').fadeOut();
                        },
                        duration: 30000 - timeLeft
                    });
            } else {
                $('#hotels-progress').hide();
            }
        }

        $('#result-box').on('click', '.hotels-details-btn', function () {
            var key = $(this).attr('data-key');
            var html = Mustache.to_html($('#route-item-details-template').html(), {
                outbound: getFlightsDetails(window.HOTELS_ROUTES[key]['outbound']),
                inbound: !_.isEmpty(window.HOTELS_ROUTES[key]['inbound']) ? getFlightsDetails(window.HOTELS_ROUTES[key]['inbound']) : void 0
            });
            $('#fare-details .modal-body').html(html);
            $('#fare-details').modal();
        });

    });
})(jQuery);