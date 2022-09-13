function automobileBringUpCheck() {
	var available = true;
	if ($(".auto-bombila span.car-cooldown").attr("timer") > 0) available = false;
	if (available && $(".auto-bombila .ride-button").attr("complete") != "complete") {
		$(".auto-bombila .ride-button").removeClass("disabled");
		$(".auto-bombila .ride-button").removeAttr("disabled");
	} else {
		if (!$(".auto-bombila .ride-button").hasClass("disabled")) $(".auto-bombila .ride-button").addClass("disabled");
		$(".auto-bombila .ride-button").attr("disabled");
	}
}
$(document).ready(function() {
	$("#cars-trip-choose .object-thumb").bind("click", function() {
		var carHtml = $(this).find(".car-place").html();
		var timer = $(this).find(".timeout span");
		$(".auto-bombila form #car-id").val($(this).attr("carid"));
		$(".auto-bombila .car-place").html(carHtml);
		$(".auto-bombila .car-place *[tooltip=1]").each(function() {
			$(this).attr("title", $(this).attr("tip"));
			$(this).removeAttr("tip");
		});
		simple_tooltip(".auto-bombila .car-place *[tooltip=1]", "tooltip-bombila-c" + $(this).attr("carid"));
		if (timer.length) {
			timer = timer.attr("timer");
			if (timer > 0) {
				initTimers();
			}
		}
		var trigger = "automobileBringUpCheck();";
		$(".auto-bombila .car-place span.car-cooldown").attr("trigger", trigger);
		$(".auto-bombila span.ride-time").html($(this).attr("time"));
		automobileBringUpCheck();
		$("#cars-trip-choose").hide();
		return false;
	});
});
