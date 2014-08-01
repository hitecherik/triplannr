var main = function(){

	var date = new Date();
	var fullDate = (date.getDate().toString().length == 1 ? "0" : "") + date.getDate().toString() + '/' + ((date.getMonth() + 1).toString().length == 1 ? '0' + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString()) + '/' + date.getFullYear().toString();
	$('#startDate').val(fullDate);

	date.setDate(date.getDate() + 4);
	fullDate = (date.getDate().toString().length == 1 ? "0" : "") + date.getDate().toString() + '/' + ((date.getMonth() + 1).toString().length == 1 ? '0' + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString()) + '/' + date.getFullYear().toString();
	$('#endDate').val(fullDate);

	
	var options = $('nav div'),
		hide = $('.hide');

	$('#nav_show').on('click', function(){
		if ( hide.is(':hidden'))
		{
			options.eq(1).slideToggle(400).removeClass('hide');
		}
		else if (!(hide.is(':hidden')))
		{
			options.eq(1).slideToggle(400).addClass('hide');
		}
	});
 
	$('button[type="submit"]').on('click', validateForm);
}

var validateForm = function(){

	var endDate = $('#endDate').val(),
		startDate = $('#startDate').val(),
		endDateLenCheck = $('#endDate').val().split("/"),
		startDateLenCheck = $('#startDate').val().split("/"),
		dateCheck1 = new Date(),
		dateCheck2 = new Date(),
		postcode = $('#postcode').val();

	dateCheck1.setDate(parseInt(startDateLenCheck[0]));
	dateCheck1.setMonth(parseInt(startDateLenCheck[1]));
	dateCheck1.setYear(parseInt(startDateLenCheck[2]));
	dateCheck1.setDate(dateCheck1.getDate() + 4);

	dateCheck2.setDate(parseInt(endDateLenCheck[0]));
	dateCheck2.setMonth(parseInt(endDateLenCheck[1]));
	dateCheck2.setYear(parseInt(endDateLenCheck[2]));

	var	items = [$("#destination").val(), $('#startDate').val(), $('#endDate').val()],
		activities = [$("#museum")[0].checked, $('#restaurant')[0].checked, $('#beach')[0].checked, $('#cafe')[0].checked, $('#walk')[0].checked, $('#outdoor')[0].checked, $('#indoor')[0].checked],
		j = 0;


	for(var i = 0; i < items.length; i++)
	{
		if (items[i] == null || items[i] == "") 
    	{
        	alert("All required fields must be filled out!");
        	return false;
    	}
	}

	for(var i = 0; i < activities.length; i++)
	{
		if (activities[i]) 
    	{
        	j++;
    	}
	}

	if ( j < 2 )
	{
		alert("Please select at least two checkboxes!");
		return false;
	}


    if (!endDate.match(/\d\d\/\d\d\/\d\d\d\d/) || !endDate.match(/\d\d\/\d\d\/\d\d\d\d/) ||
    			!startDate.match(/\d\d\/\d\d\/\d\d\d\d/) || !startDate.match(/\d\d\/\d\d\/\d\d\d\d/)) {
    	alert("Start and end date fields must be filled out correctly!");
        return false;
    }
    else if ( !postcode.match(/[A-Z]{1,2}[0-9R][0-9A-Z]? [0-9][A-Z]{2}/) ) {
    	alert("Postcode field must be filled out correctly!");
        return false;
    }
    else if (dateCheck2 > dateCheck1) 
    {
    	alert("The maximum trip length is five days.");
    	return false;
    }

}

$(document).ready(main);
