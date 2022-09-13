function automobileRideCheck(ride) {
	var available = true;
	if ($("#direction-" + ride + " span.car-cooldown").attr("timer") > 0) available = false;
	if ($("#direction-" + ride + " span.ride-cooldown").attr("timer") > 0) available = false;
	if (available) {
		$("#direction-" + ride + " .ride-button").removeClass("disabled");
		$("#direction-" + ride + " .ride-button").removeAttr("disabled");
	} else {
		if (!$("#direction-" + ride + " .ride-button").hasClass("disabled")) $("#direction-" + ride + " .ride-button").addClass("disabled");
		$("#direction-" + ride + " .ride-button").attr("disabled");
	}
}

$(document).ready(function() {
	var curTrip = 1;
	$("#cars-trip-choose .object-thumb").bind("click", function() {
		var direction = $("#cars-trip-choose").attr("direction");
		var carHtml = $(this).find(".car-place").html();
		var timer = $(this).find(".timeout span");
		$("#direction-" + direction + " form .car-id").val($(this).attr("carid"));
		$("#direction-" + direction + " .car-place").html(carHtml);
		$("#direction-" + direction + " .car-place *[tooltip=1]").each(function() {
			$(this).attr("title", $(this).attr("tip"));
			$(this).removeAttr("tip");
		});
		simple_tooltip("#direction-" + direction + " .car-place *[tooltip=1]", "tooltip-dir" + direction + "-c" + $(this).attr("carid"));
		if (timer.length) {
			timer = timer.attr("timer");
			if (timer > 0) {
				initTimers();
			}
		}
		var trigger = "automobileRideCheck(" + direction + ");";
		$("#direction-" + direction + " .car-place span.car-cooldown").attr("trigger", trigger);
		$("#direction-" + direction + " span.decrease").html($(this).attr("decrease"));
		automobileRideCheck(direction);
		$("#cars-trip-choose").hide();
	});
	$(".car-choose-link").bind("click", function() {
		var level = parseInt($(this).attr("level"));
		var direction = parseInt($(this).attr("direction"));
		$("#cars-trip-choose").attr("direction", direction);
		$("#cars-trip-choose .object-thumb").each(function() {
			var carLevel = parseInt($(this).attr("level"));
			if (carLevel < level) {
				$(this).hide();
			} else {
				$(this).show();
			}
		});
		$("#cars-trip-choose").show();
	});

	function mycarousel_initCallback(carousel) {
		jQuery("#cars-trip-choose-arrow-right").bind("click", function() {
			carousel.next();
			return false;
		});

		jQuery("#cars-trip-choose-arrow-left").bind("click", function() {
			carousel.prev();
			return false;
		});
	};

	$("div.cars-trip-accordion").jcarousel({
		initCallback: mycarousel_initCallback,
    	wrap: "circular",
		start: (curTrip),
		buttonNextHTML: null,
		buttonPrevHTML: null,
		scroll: 1
    });

	/*
	$("div.cars-trip-accordion").jCarouselLite({
		btnNext: "#cars-trip-choose-arrow-right",
		btnPrev: "#cars-trip-choose-arrow-left",
		visible: 3,
		circular:true,
		start:(curTrip-1)
	});
	*/
});
