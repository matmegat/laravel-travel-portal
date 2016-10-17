$(document).ready(function() {

	$('#mh .list').click(function(){
		$('#mh nav ul').toggleClass('show');
		return false;
	});
    $('#mh .usr_list').click(function(){
		$('#mh .user ul').toggleClass('show');
		return false;
	});

    $('.available_rooms li a').click(function(){
        $('.available_rooms li').removeClass('selected');
        $(this).closest('li').addClass('selected');
        return false;
    });

    // Show flights
    $('.btn_flight_details, .flight_book .btn').click(function(){
        $(this).toggleClass('open');
        $(this).closest('.flight_deal').find(' .flight_details').slideToggle();
        return false;
    });

    // Shoe extras (cars)
    $('.cars_intro .btn_yellow').click(function(){
        $('.cars_extra').slideToggle();
        return false;
    });

});