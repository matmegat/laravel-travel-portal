$(function(){

    updateStates();

    updateImages();

    $("#state-select").change(function(){
        var state_id = $("#state-select").val();

        updateRegionsByState(state_id);
    });

    /*var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    $('.contact-form').each(function () {

        var el_outbound = $(this).find('.contact-outbound');
        var el_inbound = $(this).find('.contact-inbound');

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

    });*/

});

function updateRegionsByState(state_id) {
    var $regionSelect = $('#region-select');

    $regionSelect
        .attr('disabled', true)
        .html($('<option></option>').val('').html('Loading...'));

    var data = null;

    if (typeof state_id !== 'undefined') {
        data = {
            state: state_id
        }
    }

    $.ajax({
        type: "GET",
        url: '/tours/regions',
        dataType: "html",
        data: data,
        success: function (regions) {
            $regionSelect
                .html('')
                .append( $('<option></option>').val('').html('-- All --') )

            $.each($.parseJSON(regions), function(id, name) {
                var selected = $('input[name="current_region"]').val() == id ? {'selected': 'selected'} : {};

                $regionSelect.append( $('<option></option>').val(id).attr(selected).html(name) )
            });

            $regionSelect.parent().find('div').remove();
            $regionSelect.removeClass('hidden').removeAttr('disabled');
        }
    });
}

function updateStates() {
    var $stateSelect = $('#state-select');

    $stateSelect.attr('disabled', true).html($('<option></option>').val('').html('Loading...'));

    $.ajax({
        type: "GET",
        url: '/tours/states',
        dataType: "html",
        success: function (states) {
            var currentState = $('input[name="current_state"]').val();

            $stateSelect
                .html('')
                .append( $('<option></option>').val('').html('-- All --') )

            $.each($.parseJSON(states), function(id, name) {
                var selected = currentState == id ? {'selected': 'selected'} : {};

                $stateSelect.append( $('<option></option>').val(id).attr(selected).html(name) )
            });

            $stateSelect.parent().find('div').remove();
            $stateSelect
                .removeClass('hidden')
                .removeAttr('disabled');

            updateRegionsByState(currentState);
        }
    });
}

function updateImages() {

    // product listing image sizing

    $('.main-list').find('.item').each(function() {
        var detailHeight = $(this).find('.details').innerHeight();

        $(this).find('.image:visible').css('max-height', detailHeight+1);
        $(this).find('.image:visible img').css('height', detailHeight+1);
    })
}
