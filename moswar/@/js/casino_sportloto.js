$(document).ready(function() {
	var musicOn = false;

	$("#casino-sportloto-ticket-new div.numbers b").bind("click", function(){
		if(!$(this).hasClass("checked") && $("#casino-sportloto-ticket-new div.numbers b.checked").length < 5 ){
			$(this).addClass("checked");
		} else {
			$(this).removeClass("checked");
		}
	});

	$("#casino-sportloto-ticket-randomize").bind("click", function(){
		var numbers = $("#casino-sportloto-ticket-new div.numbers b");
		numbers.removeClass("checked");
		var nums = new Array();
		for (var i = 0; i < 5; i++) {
			var num = 1 + Math.round((numbers.length - 1) * Math.random());
			while (nums.indexOf(num) != -1) {
				var num = 1 + Math.round((numbers.length - 1) * Math.random());
			}
			nums.push(num);
		}
		for (var i = 0; i < 5; i++) {
			$(numbers[nums[i] - 1]).addClass("checked");
		}

	});

	$("#button-prize-get").bind("click", function() {
		if ($("#button-prize-get").attr("disabled") != "disabled") {
			$("#prize-error").hide();
			$("#button-prize-get").attr("disabled", "disabled");
			$.post("/casino/sportloto/", {action : "prize"}, function(data) {
				$("#button-prize-get").removeAttr("disabled");
				if (data.success) {
					animateNumber($("#fishki-balance-num"), data.chip);
				} else {
					switch (data.error) {
						case "no_tickets" :
							$("#prize-error").html("Вы не успели забрать выигрыш");
							break;
					}
					$("#prize-error").show();
				}
				$("#get-prize-holder").slideUp("fast", function() {
					$("#get-prize-holder").remove();
				});
			}, "json");
		}
	});

	$("#button-ticket-get").bind("click", function(){
		if ($("#button-ticket-get").attr("disabled") != "disabled") {
			$("#ticket-error").hide();
			if ($("#casino-sportloto-ticket-new div.numbers b.checked").length != 5) {
				$("#ticket-error").html("Выберите 5 (!) номеров");
				$("#ticket-error").show();
			} else {
				var numbers = new Array();
				var numbersObj = $("#casino-sportloto-ticket-new div.numbers b.checked");
				for (var i = 0; i < numbersObj.length; i++) {
					numbers.push(parseInt($(numbersObj[i]).html()));
				}
				$("#button-ticket-get").attr("disabled", "disabled");
				$.post("/casino/sportloto/", {action : "ticket", "numbers[]" : numbers}, function(data) {
					$("#button-ticket-get").removeAttr("disabled");
					if (data.success) {
						animateNumber($("#fishki-balance-num"), data.chip);
						var position = $("#today-tickets tr").length;
						var html = '<tr>\
										<td class="num">#' + position + '</td>\
										<td class="numbers">';
						for (var i = 0; i < data.numbers.length; i++) {
							html += '<b class="icon">' + data.numbers[i] + '</b>';
						}
						html += '</td>\
										<td class="value"></td>\
									</tr>';
						$("#today-tickets").append(html);
						$("#button-ticket-select div.c").html('Купить билетик - <span class="fishki">60<i></i></span>');
						$('#casino-sportloto-ticket-new').slideUp('fast');
						$('#casino-sportloto-ticket-new div.numbers b').removeClass('checked');
						showMessage("Вы купили билетик удачи!", "Розыгрыш состоится сегодня в полночь. В случае удачи, выигрыш следует забрать <b>в течение суток</b>, иначе он перейдет в фонд казино.");
					} else {
						switch (data.error) {
							case "numbers_range" :
								$("#ticket-error").html("Соберитесь! Вам нужно выбрать числа от 1 до 25. Это не сложно!");
								break;
							case "numbers_count" :
								$("#ticket-error").html("Нужно выбрать 5 чисел");
								break;
							case "chip_limit" :
								$("#ticket-error").html("<img align='left' src='/@/images/pers/man112_thumb.png' style='margin:0 10px 5px 0;' />У Вас недостаточно фишек. Получите фишки в <a href=\"/casino/#exchange\">кассе</a> и возвращайтесь.");
								break;
							case "tickets_limit" :
								$("#ticket-error").html("Вы уже купили 100 билетов сегодня");
								break;
						}
						$("#ticket-error").show();
					}
				}, "json");
			}
		}
	});

	$("#casino-sportloto-musiclink").bind("click", function() {
		if (Sounding.getSound() != null) {
			if (!musicOn) {
				Sounding.getSound().playSound("sportloto", "layer1", true);
				musicOn = true;
				$("#casino-sportloto-musiclink span").html("Выключить мелодию");
			} else {
				Sounding.getSound().stopSound("layer1");
				musicOn = false;
				$("#casino-sportloto-musiclink span").html("Послушать мелодию");
			}
		}
	});

	var initSwf = function() {
		var flashvars = {};
		var params = {};
		params.allowscriptaccess = "always";
		var attributes = {};
		attributes.type = "application/x-shockwave-flash";
		attributes.id = "musicswf";
		attributes.name = "music";
		swfobject.embedSWF("/@/swf/sounding.swf", "musicSwf", "1", "1", "9.0.0", "/@/swf/expressInstall.swf", flashvars, params, attributes);
	};

	initSwf();

	$("#sportloto-message button").live("click", function() {
		$("#sportloto-message").hide();
		$("#sportloto-message .data .text").html("");
		nextStep();
	});

	var showMessage = function(title, text) {
		$("#sportloto-message h2").html(title);
		$("#sportloto-message .data .text").html(text);
		$("#sportloto-message").show();
		$("#sportloto-message").css("top", $(document).scrollTop() + ($(window).height() / 2) - ($("#sportloto-message").height() / 2) - 500);
	}
});

var Sounding = function() {
	var sound = null;

	var init = function() {
		sound = $("#musicswf")[0];
		sound.loadSound("sportloto", "/@/swf/sportloto.mp3");
	}

	var getSound = function() {
		return sound;
	}

	return {
		init : init,
		getSound : getSound
	}
}();