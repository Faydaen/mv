$(document).ready(function() {
	var start = 0;
	var slots = $("div.cars-produce-accordion ul li");
	for(var i = 0; i < slots.length; i++) {
		if (!$(slots[i]).hasClass("disabled")) {
			start++;
		}
	}
	if (start > 0) start--;

	function mycarousel_initCallback(carousel) {
		jQuery("#cars-produce-choose-arrow-right").bind("click", function() {
			carousel.next();
			return false;
		});

		jQuery("#cars-produce-choose-arrow-left").bind("click", function() {
			carousel.prev();
			return false;
		});
	};

	$("div.cars-produce-choose").jcarousel({
		initCallback: mycarousel_initCallback,
    	wrap: "circular",
		start: start,
		buttonNextHTML: null,
		buttonPrevHTML: null,
		scroll: 1
    });

/*
	$("div.cars-produce-choose").jCarouselLite({
		btnNext: "#cars-produce-choose-arrow-right",
		btnPrev: "#cars-produce-choose-arrow-left",
		visible: 3,
		circular: true,
		start: start,
		afterEnd: function(a) {
		}
	});
	*/
});
