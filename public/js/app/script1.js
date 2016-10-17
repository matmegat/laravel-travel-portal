$( document ).ready( function(){

	/*$( ".one_way" ).click(function() {
		var self = $(this);
		self.removeClass("active");
		self.parent().find("input").val(0);
		$('#flights_to').val('');
		$('#flights_to').attr('disabled','disabled');
		$('#flights_to').attr('placeholder','One Way');
		self.parent().find(".reload").addClass( "active" );
	});

	$( ".reload" ).click(function() {
		var self = $(this);
		self.removeClass("active");
		self.parent().find("input").val(1);
		$('#flights_to').removeAttr('disabled');
		$('#flights_to').attr('placeholder','Return');
		self.parent().find(".one_way").addClass( "active" );
	});*/

	//$('#result-box').on('click', '.show_hide', function(){
	//	var self = $(this);
	//	var rotate = self.parent().parent().find(".item_description");
	//	if(rotate.is(":visible")){
	//		self.addClass('box_rotate box_transition');
	//		rotate.slideUp();
	//	} else if(!rotate.is(":visible")) {
	//		self.removeClass('box_rotate');
	//		rotate.slideDown();
	//	}
	//});

	/*$('.flights_results').on('click', ".show_hide", function() {
		var self = $(this);
		var rotate = self.parent().parent().find(".item_description");
		(rotate).toggleClass('open');
		(self).toggleClass('rotate');
	});*/

	$(".dropdown_menu" ).click(function(event) {
		event.stopPropagation();
		var self = $(this);
		self.find( ".dropdown" ).slideToggle();
		/*var bg = self.find(".select").css('backgroundImage').split(",");
		if ($(".dropdown").is(":visible")) {
			self.find(".select").css('backgroundImage', bg[0]+' ,url(/img/icons/select_input_down.png)');
		} else {
			self.find(".select").css('backgroundImage', bg[0]+' ,url(/img/icons/select_input_up.png)');
		}*/
	});

	$('html').click(function(){
		if ($(".dropdown").is(":visible")) {
			$(".dropdown").hide();
		}
	});

	$(".dropdown_item").click(function() {
		var self = $(this);
		var src = self.find('img').attr('src');
		var val = self.find('p').text();
		var id = self.find('input').val();
		self.parent().find('.selected_option').removeClass('selected_option');
		self.addClass('selected_option');
		if(src)
			self.parent().parent().find(".select").css('backgroundImage','url('+src+'),url(/img/icons/select_input_down.png)');
		self.parent().parent().find(".select").val(val);
		self.parent().parent().find(".select_id").val(id);
	});

	$(".pager li").click(function() {
/*		$( ".form" ).submit();
		alert('asd');
		*/
	});
})
