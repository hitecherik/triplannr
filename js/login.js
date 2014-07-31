var main = function(){

	// var box = $('#login'),
	// 	$(window) = winD,
	// 	winWidth = winD.width() / 2 - box.outerWidth() / 2;

	// $(window).on('resize', function(){
	// 	winWidth = winD.width() / 2 - box.outerWidth() / 2;
	// 	box.css('left', minWidth);
	// });


	var options = $('nav div'),
		hide = $('.hide');

	$('#nav_show').on('click', function(){
		if ( hide.is(':hidden'))
		{
			options.eq(1).slideToggle(400)
								.removeClass('hide');
		}
		else if ( !(hide.is(':hidden')) )
		{
			options.eq(1).slideToggle(400)
								.addClass('hide');
		}
	});
 
	$('button[type="submit"]').on('click', validateForm);
}

var validateForm = function(){

	var endDate = $('#endDate').val(),
		startDate = $('#startDate').val();
		postcode = $('#postcode').val();

	// var	items = [$("#destination").val(), $('#startDate').val(), $('#endDate').val(),
	// 				$("#hotel").val(), $('#postcode').val()];

	var	items = [$("#destination").val(), $('#startDate').val(), $('#endDate').val()];

	for(var i = 0; i < items.length; i++)
	{
		if (items[i] == null || items[i] == "") 
    	{
        	alert("All required fields must be filled out!");
        	return false;
    	}
	}

    if (!endDate.match(/\d\d\/\d\d\/\d\d\d\d/) || !endDate.match(/\d\d\/\d\d\/\d\d\d\d/)) {
    	alert("Start and end date fields must be filled out correctly!");
        return false;
    }
    else if ( !postcode.match(/..\d\s\d../) && !postcode.match(/..\d\d\s\d../) ) {
    	alert("Postcode field must be filled out correctly!");
        return false;
    }
}

$(document).ready(main);


