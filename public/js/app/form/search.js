(function ($) {
    $(function () {

        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        $('.accommodation_form').each(function(){

            var el_checkin = $(this).find('.app-form-search-checkin');
            var el_checkout = $(this).find('.app-form-search-checkout');

            var checkin = el_checkin.datepicker({
                onRender: function (date) {
                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate',function (ev) {
                    if (ev.date.valueOf() > checkout.date.valueOf()) {
                        var newDate = new Date(ev.date)
                        newDate.setDate(newDate.getDate() + 1);
                        checkout.setValue(newDate);
                    }
                    checkin.hide();

                    el_checkout.focus();
                }).data('datepicker');

            var checkout = el_checkout.datepicker({
                onRender: function (date) {
                    return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate',function (ev) {
                    checkout.hide();
                }).data('datepicker');

        });

    });
})(jQuery);
