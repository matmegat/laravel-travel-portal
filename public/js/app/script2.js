$( document ).ready( function(){

/*
|***************************************************************************|
|**********                   DATEPICKER START                 *************|
|***************************************************************************|
*/


	var dateToday = new Date();
	/*$( "#flights_from" ).datepicker({
		dateFormat: 'dd.mm.yy',
	    minDate: dateToday,
      	numberOfMonths: 1,
	    inline: true,
	    firstDay: 1,
	    showOtherMonths: true,
      	onClose: function( selectedDate ) {
            var minDate = $(this).datepicker('getDate');
            if (minDate) {
                minDate.setDate(minDate.getDate() + 1);
            }

            $("#flights_to").datepicker('option', 'minDate', minDate || 1);
            if (!$("#flights_to").datepicker('getDate')) {
                $("#flights_to").datepicker('setDate', minDate);
            }
	    }
    }).datepicker('widget').wrap('<div class="ll-skin-melon"/>');

    $( "#flights_to" ).datepicker({
		dateFormat: 'dd.mm.yy',
	    minDate: dateToday,
      	numberOfMonths: 1,
	    inline: true,
	    firstDay: 1,
	    showOtherMonths: true,
      	onClose: function( selectedDate ) {
       		$( "#flights_from" ).datepicker( "option", "maxDate", selectedDate );
      	}
    }).datepicker('widget').wrap('<div class="ll-skin-melon"/>');*/

    /*$( "#tours_from" ).datepicker({
		dateFormat: 'dd.mm.yy',
	    minDate: dateToday,
      	numberOfMonths: 1,
	    inline: true,
	    firstDay: 1,
	    showOtherMonths: true,
      	onClose: function( selectedDate ) {
	        $( "#tours_to" ).datepicker( "option", "minDate", selectedDate );
	    }
    }).datepicker('widget').wrap('<div class="ll-skin-melon"/>');

    $( "#tours_to" ).datepicker({
		dateFormat: 'dd.mm.yy',
	    minDate: dateToday,
      	numberOfMonths: 1,
	    inline: true,
	    firstDay: 1,
	    showOtherMonths: true,
      	onClose: function( selectedDate ) {
       		$( "#tours_from" ).datepicker( "option", "maxDate", selectedDate );
      	}
    }).datepicker('widget').wrap('<div class="ll-skin-melon"/>');

	$( "#hotels_from" ).datepicker({
		dateFormat: 'dd.mm.yy',
	    minDate: dateToday,
      	numberOfMonths: 1,
	    inline: true,
	    firstDay: 1,
	    showOtherMonths: true,
      	onClose: function(selectedDate) {
            var minDate = $(this).datepicker('getDate');
            if (minDate) {
                minDate.setDate(minDate.getDate() + 1);
            }

            $("#hotels_to").datepicker('option', 'minDate', minDate || 1);
            if (!$("#hotels_to").datepicker('getDate')) {
                $("#hotels_to").datepicker('setDate', minDate);
            }
	    }
    }).datepicker('widget').wrap('<div class="ll-skin-melon"/>');

    $( "#hotels_to" ).datepicker({
		dateFormat: 'dd.mm.yy',
	    minDate: dateToday,
      	numberOfMonths: 1,
	    inline: true,
	    firstDay: 1,
	    showOtherMonths: true,
      	onClose: function( selectedDate ) {
       		$( "#hotels_from" ).datepicker( "option", "maxDate", selectedDate );
      	}
    }).datepicker('widget').wrap('<div class="ll-skin-melon"/>');*/

/*
|***************************************************************************|
|**********                   DATEPICKER END                   *************|
|***************************************************************************|
*/

/*
|***************************************************************************|
|**********                   TABS START                       *************|
|***************************************************************************|
*/

	//$(".tab_a" ).click(function() {
	//	var self = $(this);
	//	self.parent().parent().find(".active").removeClass( "active");
	//	self.parent().addClass('active');
	//	return false;
	//});

/*
|***************************************************************************|
|**********                   TABS END                         *************|
|***************************************************************************|
*/

/*
|***************************************************************************|
|**********                   SELECT START                     *************|
|***************************************************************************|
*/

	$('select').change(function(){
		$(this).blur();
	});
	$('option').bind('click' , function(){
		$(this).parent().blur();
	});

/*
|***************************************************************************|
|**********                   SELECT END                       *************|
|***************************************************************************|
*/

/*
|***************************************************************************|
|**********                   VIEW MORE START                  *************|
|***************************************************************************|
*/

	/*$(".btn").bind('click' , function(){
		var self = $(this);
		if ( self.hasClass('more') ){
			self.parent().parent().find(".latent").slideToggle(500, function(){
				self.text('View less Info');
			});
			self.removeClass('more');
			self.addClass('less');
			return false;
		} 
		if ( self.hasClass('less') ) {
			self.parent().parent().find(".latent").slideUp(500, function(){
				self.text('View More Info');
			});
			self.removeClass('less');
			self.addClass('more');
			return false;
		}
	});*/

/*
|***************************************************************************|
|**********                   VIEW MORE END                    *************|
|***************************************************************************|
*/

/*
|***************************************************************************|
|**********                   FLIGHTS START                    *************|
|***************************************************************************|
*/
	
	/*$('.price').on('click', function(){
		var self = $(this).find('img');
		if(self.hasClass("price_rotate")){
		} else {
		}
	});*/

/*
|***************************************************************************|
|**********                   FLIGHTS END                      *************|
|***************************************************************************|
*/

/*
|***************************************************************************|
|**********                   NICE SCROLL START                *************|
|***************************************************************************|
*/

	/*$("html").niceScroll({
     	zindex: 9999,
     	cursoropacitymin: 0.7,
     	cursorwidth: 10,
     	cursorborder: 0,
     	mousescrollstep: 40,
     	scrollspeed: 150
	});*/

	/*$(window).scroll(function(){
		var doc = document.documentElement, body = document.body;
		var top = (doc && doc.scrollTop  || body && body.scrollTop  || 0);
		top = top/3;
		$('body').css({'background-position-y': '-'+top+'px'});
	});*/  

/*
|***************************************************************************|
|**********                   NICE SCROLL END                  *************|
|***************************************************************************|
*/

/*
|***************************************************************************|
|**********                   INDEX PAGE MENU START            *************|
|***************************************************************************|
*/
//
	//$(".diving_menu, .adventure_menu, .australia_menu")
	//.on('mouseenter', function(){
	//	var self = $(this);
	//	var text = self.find("p").html();
	//	text = "VIEW <br />"+text+"<br />TOURS";
	//	self.find("p").html(text);
	//})
	//.on( "mouseleave",function(){
	//	var self = $(this);
	//	var text = self.find("input").val();
	//	self.find("p").html(text);
	//});
/*
|***************************************************************************|
|**********                   INDEX PAGE MENU END              *************|
|***************************************************************************|
*/


  $( "#startpage_search_tabs" ).tabs();
                  

})



$(".head_date_tour").datepicker( {
    format: "mm-yyyy",
    viewMode: "months", 
    minViewMode: "months"
});
