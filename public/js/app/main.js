function inputNumber(el) {

    var min = el.attr('min') || false;
    var max = el.attr('max') || false;

    var els = {};

    els.dec = el.prev();
    els.inc = el.next();

    el.each(function() {
        init($(this));
    });

    function init(el) {

        els.dec.on('click', decrement);
        els.inc.on('click', increment);

        function decrement() {
            var value = el[0].value;
            value--;
            if(!min || value >= min) {
                el[0].value = value;
            }
        }

        function increment() {
            var value = el[0].value;
            value++;
            if(!max || value <= max) {
                el[0].value = value++;
            }
        }
    }
}

(function($){
    $(function(){
        $('body').formplate();

        $('#scroll-down').click(function(e){
            e.preventDefault();
            $('html, body').animate({
                scrollTop: ($(this).offset().top
                - 108)}, 700);
        });

        // Home page tabs
        $('.home-tabs a').click(function(e){
            e.preventDefault();
            var scrollTo = $('footer');
            $('.home-tabs a').removeClass('active');
            $(this).addClass('active');
            $('html, body').animate({
                scrollTop: ($(this).offset().top
                - 108)}, 700);

            var currentTab = $(this).attr("href");
            $(".home-tab-content .tab").removeClass('active');
            $(currentTab).addClass('active');

        });

        // Tour page tabs
        $('.tour-tabs a').click(function(e){
            e.preventDefault();
            var scrollTo = $('footer');
            $('.tour-tabs a').removeClass('active');
            $(this).addClass('active');
            var currentTab = $(this).attr("href");
            $(".tour-tab-content .tab").removeClass('active');
            $(currentTab).addClass('active');
        });

        // Date Picker
        //$('.datepicker').datetimepicker({timepicker: false, format: 'd.m.Y', closeOnDateSelect: true});
        $('.datepicker').datepicker({ dateFormat: 'dd.mm.yy' });

        $('.star').raty({
            score: function() {
                return $(this).attr('data-score');
            },
            path: '/img/library/raty',
            readOnly: true,
            half: true
        });

        // Menu Button
        $('.menu-btn').click(function(e) {
            e.preventDefault();
            $(this).toggleClass('is-active');
            $('header').toggleClass('active');
            $('body').toggleClass('menuopen');
        });

        var slider = $('.home-slider');
        slider.superslides({animation: 'fade', play: 4000});
        slider.on('animating.slides', function () {
            $(this).addClass('animating');
        });
        slider.on('animated.slides', function () {
            $(this).removeClass('animating');
        });
    });

    inputNumber($('.input-number'));
})(jQuery);

/*window.onload = function() {
    // Main nav toggle
    var mainNavToggle = document.getElementById('mainNavToggle'),
        mainNav       = document.getElementById('mainNav');

    mainNavToggle.onclick = function(e) {
        e.preventDefault();
        this.classList.toggle('main-nav-toggle--is-showing');
        mainNav.classList.toggle('main-nav--is-showing');
    }
}*/
