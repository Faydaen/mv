$(document).ready(function() {
	var result = null;

	var slotPictures = [ "pic-russia-1", "pic-russia-2", "pic-russia-3", "pic-russia-4", "pic-russia-5", "pic-russia-6", "pic-russia-7", "pic-russia-8", "pic-russia-9" ];

	$("#slots-error button").live("click", function() {
		$("#slots-error").hide();
		$("#slots-error .data .text").html("");
	});

	var showError = function(text) {
		$("#slots-error .data .text").html(text);
		$("#slots-error").show();
		$("#slots-error").css("top", $(document).scrollTop() + ($(window).height() / 2) - ($("#slots-error").height() / 2) - 300);
	}

	/* подготовить барабан  */
	var slotsPrepareBelt = function(rollid, winid){
		var html = "";
		var belt = $("#roll" + rollid + " div.belt");
		belt.html("");
		/* create sorted array */
		var slotPicturesCopy = slotPictures.slice(0);
		var slotPicturesWin = slotPicturesCopy.splice( winid-1 , 1 );
		var slotPicturesWinNearest = slotPicturesCopy.splice( (Math.round(Math.random() * slotPicturesCopy.length)) - 1 , 1 );
		slotPicturesCopy.sort ( function slotsPrepareBeltShuffle(){
			return (Math.round(Math.random()) - 0.5);
		} );
		slotPicturesCopy.push ( slotPicturesWinNearest );
		slotPicturesCopy.push ( slotPicturesWin );
		slotPicturesCopy = slotPicturesCopy.concat ( slotPicturesCopy );
		for(var i=0, j=slotPicturesCopy.length; i<j; i++){
			html += '<i class="icon ' + slotPicturesCopy[i] + '"></i>';
		}
		belt.html(html);
	}

	var slotsEndRoll = function(rollid){
		$("#roll" + rollid + " div.belt").css("bottom", -200);
		$("#roll" + rollid + "-animation").hide();
		$("#roll" + rollid + " div.belt").show();
		/*
		if (Sounding.getSound() != null) {
			Sounding.getSound().stopSound("layer" + rollid);
		}
		*/

		$("#roll" + rollid + " div.belt").animate({
			"bottom": -800
		},350 ,"linear", function(){
			if(3 == rollid){
				$("#slots-roll-1").removeClass("disabled");
				$("#slots-roll-2").removeClass("disabled");
				$("#slots-roll-3").removeClass("disabled");
				
				/* celebrate winning */
				if (result != null) {
					animateNumber($("#tablo .fishki span"), result.jackpot);

					if (result.win) {
						$("#payline").show();
						var comb = result.comb[0] + "" + result.comb[1] + "" + result.comb[2];
						if (!$("#table-c-" + comb).length) {
							comb = result.comb[0] + "" + result.comb[1] + "any";
						}
						if (!$("#table-c-" + comb).length) {
							comb = result.comb[0] + "anyany";
						}
						if (!$("#table-c-" + comb).length) {
							comb = "any" + result.comb[1] + "" + + result.comb[2];
						}
						if (!$("#table-c-" + comb).length) {
							comb = "anyany" + result.comb[2];
						}
						if (!$("#table-c-" + comb).length) {
							comb = "any" + result.comb[1] + "any";
						}
						if (!$("#table-c-" + comb).length) {
							comb = result.comb[0] + "any" + result.comb[2];
						}
						$("#table-c-" + comb).addClass("blink");
						animateNumber($("#fishki-balance-num"), result.newchip);
						var sc = result.profit;
						if (result.jwin) sc = "j";
						$("#table-c-" + comb + "-" + sc).addClass("blink");
						$("#tablo").blur();
						$("#slots-win-sum").html("+" + result.profit);
						$("#slots-win-sum").show();
						$("#slots-win-sum").css({
							"top":"190px",
							"right":"200px",
							"fontSize":"100px",
							"opacity": 1
						})
						$("#slots-win-sum").animate({
								"top":"10px",
								"right":"95px",
								"fontSize":"10px",
								"opacity": 0
							}, 1000, "easein", function(){
								$(this).hide();
							}
						);
					}
				}
			}
		});
	}

	var slotsStartRoll = function(rollid){
		$("#slots-roll-1").addClass("disabled");
		$("#slots-roll-2").addClass("disabled");
		$("#slots-roll-3").addClass("disabled");
		/**
		if (Sounding.getSound() != null) {
			Sounding.getSound().playSound("roll", "layer" + rollid, true);
		}
		*/
		$("#roll" + rollid + " div.belt").animate({
			"bottom": -1500
		},300 ,"linear", function(){
			$("#roll" + rollid + " div.belt").hide();
			$("#roll" + rollid + "-animation").show();
		});
	}

	var errorChip = function() {
		showError("<img align='left' src='/@/images/pers/man112_thumb.png' style='margin:0 10px 5px 0;' />У Вас недостаточно фишек. Получите фишки в <a href=\"/casino/#exchange\">кассе</a> и возвращайтесь.");
	}

	var slotsRoll = function(cost){
		var balance = parseInt($("#fishki-balance-num").html().replace(",", ""));
		if (cost > balance) {
			errorChip();
			return;
		}

		$("#payline").hide();
		$("#slots-payout-table td").removeClass("blink");
		$("#slots-win-sum").hide();

		/* start rotate */
		setTimeout(function() { slotsStartRoll(1); }, 100);
		setTimeout(function() { slotsStartRoll(2); }, 200);
		setTimeout(function() { slotsStartRoll(3); }, 300);

		$.post("/casino/slots/", { action : "spin", count : cost }, function(data) {
			if (data.success) {
				result = data;
				slotsPrepareBelt(1, data.result[0]);
				slotsPrepareBelt(2, data.result[1]);
				slotsPrepareBelt(3, data.result[2]);
				animateNumber($("#fishki-balance-num"), data.chip);

				setTimeout(function() { slotsEndRoll(1); }, 1500 + 2000 );
				setTimeout(function() { slotsEndRoll(2); }, 2500 + 2000 );
				setTimeout(function() { slotsEndRoll(3); }, 3500 + 2000 );
			}
		}, "json");
		/* end rotate */
	}

/*
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
*/
	slotsPrepareBelt(1, Math.round(Math.random() * 9));
	$("#roll1 div.belt").css("bottom", -800);
	slotsPrepareBelt(2, Math.round(Math.random() * 9));
	$("#roll2 div.belt").css("bottom", -800);
	slotsPrepareBelt(3, Math.round(Math.random() * 9));
	$("#roll3 div.belt").css("bottom", -800);

	$("#slots-roll-1").bind("click", function() { if (!$(this).hasClass("disabled")) slotsRoll(10); });
	$("#slots-roll-2").bind("click", function() { if (!$(this).hasClass("disabled")) slotsRoll(20); });
	$("#slots-roll-3").bind("click", function() { if (!$(this).hasClass("disabled")) slotsRoll(30); });
});

/*
var Sounding = function() {
	var sound = null;

	var init = function() {
		sound = $("#musicswf")[0];
		sound.loadSound("roll", "/@/swf/sportloto.mp3");
	}

	var getSound = function() {
		return sound;
	}

	return {
		init : init,
		getSound : getSound
	}
}();
*/