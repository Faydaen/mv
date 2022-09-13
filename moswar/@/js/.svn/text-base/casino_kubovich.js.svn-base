$(document).ready(function() {
	var step = 1;

	$("#kubovich-message button").live("click", function() {
		$("#kubovich-message").hide();
		$("#kubovich-message .data .text").html("");
		nextStep();
	});

	$("#kubovich-error button").live("click", function() {
		$("#kubovich-error").hide();
		$("#kubovich-error .data .text").html("");
	});

	var showMessage = function(text) {
		$("#kubovich-message .data .text").html(text);
		$("#kubovich-message").show();
		$("#kubovich-message").css("top", $(document).scrollTop() + ($(window).height() / 2) - ($("#kubovich-message").height() / 2) - 300);
	}

	var showError = function(text) {
		$("#kubovich-error .data .text").html(text);
		$("#kubovich-error").show();
		$("#kubovich-error").css("top", $(document).scrollTop() + ($(window).height() / 2) - ($("#kubovich-error").height() / 2) - 300);
	}

	var prizePositions = function() {
		var reelRadius = 356/2;
		var reelRadiusPrize = 134;
		var reelAngle = 36*Math.PI/180;
		var reelAngleStart = -18*Math.PI/180;
		for (var i=1; i<=10; i++){
			var prizeX = reelRadius + Math.round( reelRadiusPrize * Math.sin(reelAngleStart+(reelAngle*i)) ) - 32;
			var prizeY = reelRadius - Math.round( reelRadiusPrize * Math.cos(reelAngleStart+(reelAngle*i)) ) - 32;
			$("#prizes span.prize"+i).css({"left":prizeX,"top":prizeY});
		}
	}

	prizePositions();

	var rotateInterval = null;
	var endPosition = null;
	var result = null;

	var takeResult = function() {
		var action = "";
		if ($("div.reel-yellow").length) {
			action = "yellow";
		} else {
			action = "black";
		}
		$.post("/casino/kubovich/", {action : action}, function(data) {
				result = data;
				if (result.success) {
					if (result.wallet) {
						animateNumber($("#fishki-balance-num"), result.wallet.chip);
					}
					endPosition = result.position;
				} else {
					if (!result.ready) {
						$("#prizes").empty();
						$("#reel-turning").attr("class", "");
						$("#push .cost").html(" - скоро");
						$("#push").addClass("disabled");
						$("#steps tr.my").removeClass("my");
						$("#kubovich-smile").show();
						// кубович устал
					} else {
						if (result.reload) {
							var isYellow = false;
							if ($("div.reel-yellow").length) {
								isYellow = true;
							}
							loadData(isYellow);
						} else {
							errorChip();
						}
					}
				}
			}, "json");
	}

	var errorChip = function() {
		showError("<img align='left' src='/@/images/pers/man112_thumb.png' style='margin:0 10px 5px 0;' />У Вас недостаточно фишек. Получите фишки в <a href=\"/casino/#exchange\">кассе</a> и возвращайтесь.");
		clearInterval(rotateInterval);
		rotateInterval = null;
		$("#reel-turning").attr("class", "");
		$("#push").removeClass("disabled");
		$("#kubovich-smile").show();
	}

	var rotate = function() {
		if (rotateInterval == null) {
			var balance = parseInt($("#fishki-balance-num").html().replace(",", ""));
			var cost = parseInt($("#push .fishki").text());
			if (!isNaN(cost) && cost > balance) {
				errorChip();
				return;
			}

			endPosition = null;
			result = null;
			var interval = 0.08;
			var add = 0.02;
			var position = 1;
			var lastRotate = null;
			$("#kubovich-smile").hide();
			$("#push").addClass("disabled");
			takeResult();
			rotateInterval = setInterval(function() {
				var date = new Date();
				var time = date.getTime();
				if (lastRotate == null || (time - lastRotate) > (interval * 1000 / 10)) {
					if (position == 11) position = 1;
					if (add < 0.06) add = add * 1.06;
					interval = interval * (1 + add);
					if (interval > 5 && endPosition != null && endPosition == position) {
						stop(position);
						return;
					}
					lastRotate = time;
					$("#reel-turning").attr("class", "reel-turning" + position);
					position++;
				}
			} , 10);
		}
	}

	var nextStep = function() {
		$("#reel-turning").attr("class", "");
		$("#push").removeClass("disabled");
		if ($("div.reel-yellow").length) {
			$("div.reel-yellow").removeClass("reel-yellow").addClass("reel-bw");
			$(".cellbar .bar .percent").animate({width : 0}, "fast", function() {
				$(".cellbar .bar .percent").hide();
			});

			if ($("#steps tr.my").length) {
				$("#push .cost").html(" - " + $("#steps tr.my td.cost").html());
			} else {
				$("#push .cost").html(" - завтра");
				$("#push").addClass("disabled");
			}
		} else {
			var percentStep = 5;
			var barWidth = $(".cellbar .bar").width();
			$(".cellbar .bar .percent").show();
			var percentWidth = $(".cellbar .bar .percent").width();
			var incWidth = Math.round(barWidth / 100 * percentStep);
			percentWidth = percentWidth + incWidth;
			if (percentWidth >= barWidth) {
				percentWidth = barWidth;
				$("#push-ellow").removeClass("disabled");
			}
			$(".cellbar .bar .percent").animate({width : percentWidth}, "fast");
			var steps = $("#steps tr");
			for (var i = 0; i < steps.length; i++) {
				if ($(steps[i]).hasClass("my")) {
					$(steps[i]).removeClass("my");
					if (steps.length == i + 1) {
						$("#push .cost").html(" - завтра");
						$("#push").addClass("disabled");
					} else {
						$(steps[i + 1]).addClass("my");
						$("#push .cost").html(" - " + $("#steps tr.my td.cost").html());
					}
					break;
				}
			}
		}
		loadData();
	}

	var loadData = function(isYellow) {
		var type = (isYellow) ? "yellow" : "black";
		$.post("/casino/kubovich/", {action: "load", type: type}, function(data) {
			$("#prizes").empty();
			var html = "";
			for (var i = 0; i < data.prizes.length; i++) {
				html += "<span class=\"object prize" + (i + 1) + "\"><img tooltip=\"1\" title=\"" + data.prizes[i].name + "||" + data.prizes[i].description + "\" src=\"" + data.prizes[i].image + "\" /></span>";
			}
			$("#prizes").html(html);
			prizePositions();
			simple_tooltip("#prizes .object img[tooltip=1]", "tooltip-prize-" + step);
			step++;
			switch(data.type) {
				case 1 : // black
					$("div.reel-yellow").removeClass("reel-yellow").addClass("reel-bw");
					break;
				case 2 : // yellow
					$("div.reel-bw").removeClass("reel-bw").addClass("reel-yellow");
					break;
			}
			if (rotateInterval != null) {
				if (data.prizes.length == 0) {
					clearInterval(rotateInterval);
					rotateInterval = null;
					$("#reel-turning").attr("class", "");
					$("#push .cost").html(" - завтра");
					$("#push").addClass("disabled");
					$("#steps tr.my").removeClass("my");
					$("#kubovich-smile").show();
				} else {
					takeResult();
				}
			}

		}, "json");
	}

	var stop = function(position) {
		clearInterval(rotateInterval);
		rotateInterval = null;
		var count = 0;
		var current = 0;
		var stopInterval = setInterval(function() {
			count ++;
			if (current == position) {
				current = 0;
				$("#reel-turning").attr("class", "");
			} else {
				current = position;
				$("#reel-turning").attr("class", "reel-turning" + position);
			}
			if (count > 8) {
				clearInterval(stopInterval);
				$("#kubovich-smile").show();
				if (result.success) {
					showMessage(result.text);
					/*
					var amount = "";
					amount = " (" + result.count + " шт.)";
					showMessage("Вы выиграли <strong>«" + result.name + "»</strong>" + amount + "<div align=\"center\" class=\"clear objects\"><img src=\"" + result.image + "\" /></div>");
					*/
				}
			}
		}, 150);
		if (result.wallet) {
			var wallet = {};
			wallet["money"] = result.wallet.money;
			wallet["ore"] = result.wallet.ore;
			wallet["honey"] = result.wallet.honey;
			updateWallet(wallet);			
		}

		//nextStep();
	}
	$("#push").bind("click", function() {
		if (!$(this).hasClass("disabled")) {
			rotate();
		}
	});

	$("#push-ellow").bind("click", function() {
		if (!$(this).hasClass("disabled")) {
			$("div.reel-bw").removeClass("reel-bw").addClass("reel-yellow");
			$("#push .cost").html(" - бесплатно");
			$("#push").removeClass("disabled");
			$(this).addClass("disabled");
			loadData(true);
		}
	});
});
