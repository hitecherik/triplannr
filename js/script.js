var main = function(){ 
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
