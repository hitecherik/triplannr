var main = function(){

	var introDetails = {
		howTo: $('.instructions'),

		init: function() {

			$('.button')
				.on('click', this.show)

		},

		show: function() {
			var iD = introDetails,
				box = iD.howTo;

			// if ( box.is(':hidden'))
			// {
				iD.hide.call(box);
				iD.howTo.slideToggle(300);
			// }
		},

		hide: function() {

			var $this = $(this);
			if ( $this.find('span.close')[0] ) return;

			$('<span class="close">X</span>')
				.appendTo(this)
				.on('click', function(){
					$this.slideUp(300);
				});

		}
	};

	//=================================================

	introDetails.init();

	$('#nav_show').on('click', function(){
		$('.hide').removeClass('hide');
		$('ul.dropdown').slideToggle(400);
	});

}

$(document).ready(main);
