$(document).ready(function() {
	var alowedCodes = new Array(8, 16, 35, 36, 37, 39, 46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105);
	var changeRateOre = function (e){
		if (e && e.keyCode && alowedCodes.indexOf(e.keyCode) == -1) {
			return false;
		}
		$("#stash-change-ore-chip").html(Number($("#stash-change-ore").val() * 10) || 0);
	}

	var changeRateHoney = function (e){
		if (e && e.keyCode && alowedCodes.indexOf(e.keyCode) == -1) {
			return false;
		}
		$("#stash-change-honey-chip").html(Number($("#stash-change-honey").val() * 10) || 0);
	}

	var changeRateChip = function (e){
		if (e && e.keyCode && alowedCodes.indexOf(e.keyCode) == -1) {
			return false;
		}
		$("#stash-change-chip-ore").html(Number(Math.floor($("#stash-change-chip").val() / 10)) || 0);
	}

	changeRateOre();
	changeRateHoney();
	changeRateChip();
	
	$("#stash-change-ore").bind("change", changeRateOre).bind("blur", changeRateOre).bind("keyup", changeRateOre).bind("keydown", changeRateOre);
	$("#stash-change-honey").bind("change", changeRateHoney).bind("blur", changeRateHoney).bind("keyup", changeRateHoney).bind("keydown", changeRateHoney);
	$("#stash-change-chip").bind("change", changeRateChip).bind("blur", changeRateChip).bind("keyup", changeRateChip).bind("keydown", changeRateChip);

	var showExchangeResult = function(block, type, text) {
		$("#exchange-result-ore").hide();
		$("#exchange-result-honey").hide();
		$("#exchange-result-chip").hide();

		$("#" + block).attr("class", type);
		$("#" + block).html(text);
		$("#" + block).show();
	}

	$("#button-change-ore").bind("click", function() {
		if ($("#button-change-ore").attr("disabled") != "disabled") {
			var count = $("#stash-change-ore").val();
			$("#button-change-ore").attr("disabled", "disabled");
			$.post("/casino/", {action: "ore", count: count}, function(data) {
				$("#button-change-ore").removeAttr("disabled");
				var type = "";
				var text = "";
				var block = "exchange-result-ore";
				if (data.success) {
					animateNumber($("#fishki-balance-num"), data.chip);
					var wallet = {};
					wallet["ore"] = data.ore;
					updateWallet(wallet);
					text = "Вы успешно обменяли <span class=\"ruda\">" + count + "<i></i></span> на <span class=\"fishki\">" + data.count + "<i></i></span>";
					type = "success";
				} else {
					type = "error";
					if (data.error == "null") {
						text = "На ноль менять нельзя";
					} else if (data.nemoney) {
						// Не хватает руды
						text = "У вас не хватает руды для такого обмена";
					} else {
						// Нельзя больше 200 фишек в день
						if (data.rest = 0) {
							text = "Вы уже получили сегодня 200 фишек и ваш лимит исчерпан. Но можете обратиться <span class=\"dashedlink\" onclick=\"$('#casino-casher-illegal').toggle('fast');\">к подпольному крупье</span>";
						} else {
							text = "Антиазартный комитет запрещает получать более 200 фишек в день. Разве только вам поможет <span class=\"dashedlink\" onclick=\"$('#casino-casher-illegal').toggle('fast');\">подпольный крупье</span>";
						}
					}
				}
				showExchangeResult(block, type, text);
			}, "json");
		}
	});

	$("#button-change-honey").bind("click", function() {
		if ($("#button-change-honey").attr("disabled") != "disabled") {
			var count = $("#stash-change-honey").val();
			$("#button-change-honey").attr("disabled", "disabled");
			$.post("/casino/", {action: "honey", count: count}, function(data) {
				$("#button-change-honey").removeAttr("disabled");
				var type = "";
				var text = "";
				var block = "exchange-result-honey";
				if (data.success) {
					animateNumber($("#fishki-balance-num"), data.chip);
					var wallet = {};
					wallet["honey"] = data.honey;
					updateWallet(wallet);
					text = "Вы успешно обменяли <span class=\"med\">" + count + "<i></i></span> на <span class=\"fishki\">" + data.count + "<i></i></span>";
					type = "success";
				} else {
					type = "error";
					if (data.error == "null") {
						text = "На ноль менять нельзя";
					} else if (data.nemoney) {
						// Не хватает мёда
						text = "У вас не хватает мёда для такого обмена";
					}
				}
				showExchangeResult(block, type, text);
			}, "json");
		}
	});

	$("#button-change-chip").bind("click", function() {
		if ($("#button-change-chip").attr("disabled") != "disabled") {
			var count = $("#stash-change-chip").val();
			$("#button-change-chip").attr("disabled", "disabled");
			$.post("/casino/", {action: "chip", count: count}, function(data) {
				$("#button-change-chip").removeAttr("disabled");
				var type = "";
				var text = "";
				var block = "exchange-result-chip";
				if (data.success) {
					animateNumber($("#fishki-balance-num"), data.chip);
					var wallet = {};
					wallet["ore"] = data.ore;
					updateWallet(wallet);
					count = Math.floor(count / 10) * 10;
					text = "Вы успешно обменяли <span class=\"fishki\">" + count + "<i></i></span> на <span class=\"ruda\">" + data.count + "<i></i></span>";
					type = "success";
				} else {
					type = "error";
					if (data.nechip) {
						// Нет столько фишек
						text = "У вас не хватает фишек для такого обмена";
					}
					if (!data.allow) {
						// Нельзя выводить меньше 50
						text = " К сожалению, минимальная сумма получения выигрыша - 50 фишек";
					}
				}
				showExchangeResult(block, type, text);
			}, "json");
		}
	});

});


