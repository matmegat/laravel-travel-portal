// TODO: This is a temporary solution. Should be redo once UI engineer looks at the layouts.

    $(document).ready(function() {
        var $fun = $('.fun-dropdown');

        var currentIcon = $fun.find('input[name=fun]').val();

        var current = $fun.find('a[data-icon-id=' + currentIcon + ']').html();
        $fun.find('.current-name').html(current);


        $fun.find('a').click(function(e) {
            e.preventDefault();

            var iconId = $(this).data('icon-id');
            var iconName = $(this).html();

            $fun.find('input[name=fun]').val(iconId);
            $fun.find('.current-name').html(iconName);
        });
    });