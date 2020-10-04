export default function showingOW(){

	$('.showingOW').click(function(e){
		var OWName = ($(e.currentTarget).attr('OW'));
		var OW = $(".OW#"+OWName);
		var otherOW = OW.parent().children('.OW').not(OW);
		OW.show();
		OW.animate({opacity:"1"},100, function(){
			otherOW.animate({opacity:"0"}, 100, function(){
				otherOW.hide();
			})
		});

		//current
		var showingOW = $(e.currentTarget)
		var allShowingOW = $(e.currentTarget).parent().children(".showingOW");
		allShowingOW.removeClass("current");
		showingOW.addClass("current");

	});

	$(".closingCross,.closingArrow").click(function(e){
		$(e.currentTarget).parent().parent().animate({opacity:"0"}, 100, function(){
			$(e.currentTarget).parent().parent().hide();
		})
	});

}