function openNumber() {
	$('#buy-number').show();
	setTimeout(function() { $('#buy-number .big .car-number input').focus(); }, 200);
	$('#buy-number').bind("keydown", function() {
		if (!$("#buy-number-button").hasClass("disabled")) $("#buy-number-button").addClass("disabled");
		$("#buy-number-button").attr("disabled", "disabled");
		$("#buy-number .generate-button button#check-number").show();
	});
}

$(document).ready(function() {
	$.mask.definitions["~"] = "[АВЕКМНОРСТУХавекмнорстух]";
	$("#buy-number .big .car-number input").mask("~999~~", { placeholder: " " });

	var checkNumber = function() {
		$.post("/automobile/checknumber/", { number: $("#buy-number .big .car-number input").val() }, function(response) {
			response = parseInt(response);
			if (response > 0) {
				$("#buy-number ul li input:checked").removeAttr("checked");
				$("#buy-number ul li input[value=" + response + "]").attr("checked", "checked");
				$("#buy-number-button .cost").html(" - " + $($("#buy-number ul li input:checked")[0].parentNode).find(".cost").html());
				$("#buy-number-button").removeClass("disabled");
				$("#buy-number-button").removeAttr("disabled");
			} else {
				var message = "";
				switch (response) {
					case -2 :
						message = "Такой номер можно закрепить только на велосипед.";
						break;
					case -1 :
						message = "Кто-то с таким номером уже бороздит просторы неризиновой.";
						break;
				}
				if (!$("#buy-number-button").hasClass("disabled")) $("#buy-number-button").addClass("disabled");
				$("#buy-number-button").attr("disabled", "disabled");
				showAlert('Ошибка', message, 1);
			}
		});
	};

	$("#buy-number .generate-button button#check-number").bind("click", checkNumber);

	var generateNumber = function() {
		if (parseInt($("#buy-number ul li input:checked").val()) > 0 && parseInt($("#buy-number ul li input:checked").val()) < 7) {
			$.post("/automobile/generatenumber/", { cool: $("#buy-number ul li input:checked").val() }, function(number) {
				if (number == "0") {
					var message = "";
					switch (cool) {
						case "0" :
							message = "Ушлые бомбилы уже расхватали все номера. Либо оставляй свой, либо выбирай номер другой категории.";
							break;
						case "1" :
							message = "Номерок блатной, три семерочки, да вот только он не твой, нету корочки. Нет больше свободных номеров в этой категории, попрубуй поискать в других.";
							break;
						case "2" :
							message = "Лихие мажоры еще вчера разобрали все такие номерки. Попробуй найти что-нибудь в других категориях.";
							break;
						case "3" :
							message = "Все красивые номера давно прицеплены к гламурным машинкам подружек олигархов. Попытай счастье с другими категориями номеров.";
							break;
						case "4" :
							message = "Хотел безнаказанно ездить на двухста по встречке? Так вот не выйдет, не осталось номеров, дающих авто-индульгенцию. Попробуй поискать в других категориях.";
							break;
						case "5" :
							message = "Спецномера всегда в дефиците. Их не хватает даже на самих чиновников, не говоря уже об их многочисленных помошниках. Вот и тебе не хватило. Попробуй поискать менее крутые номера.";
							break;
					}
					if (!$("#buy-number-button").hasClass("disabled")) $("#buy-number-button").addClass("disabled");
					$("#buy-number-button").attr("disabled", "disabled");
					showAlert('Ошибка', message, 1);
				} else {
					$("#buy-number .generate-button button#check-number").hide();
					$("#buy-number .big .car-number input").val(number);
					$("#buy-number-button .cost").html(" - " + $($("#buy-number ul li input:checked")[0].parentNode).find(".cost").html());
					$("#buy-number-button").removeClass("disabled");
					$("#buy-number-button").removeAttr("disabled");
				}
			});
		} else {
			$("#buy-number .generate-button button#check-number").hide();
			$("#buy-number .big .car-number input").val($("#buy-number ul li input:checked").val());
			if ($($("#buy-number ul li input:checked")[0].parentNode).find(".cost").length) {
				$("#buy-number-button .cost").html(" - " + $($("#buy-number ul li input:checked")[0].parentNode).find(".cost").html());
			} else {
				$("#buy-number-button .cost").html("");
			}
			if ($("#buy-number ul li input:checked").attr("current") == "current") {
				$("#buy-number-button").addClass("disabled");
				$("#buy-number-button").attr("disabled", "disabled");
			} else {
				$("#buy-number-button").removeClass("disabled");
				$("#buy-number-button").removeAttr("disabled");
			}
		}
	};

	$("#buy-number .generate-button button#generate-number").bind("click", generateNumber);
	$("#buy-number ul li input").bind("click", generateNumber);
	if ($("#buy-number ul li input:checked").length) {
		if ($($("#buy-number ul li input:checked")[0].parentNode).find(".cost").length) {
			$("#buy-number-button .cost").html(" - " + $($("#buy-number ul li input:checked")[0].parentNode).find(".cost").html());
		}
	}
	$(".upgrades .objects .clickable").bind("click", function() {
		$("#part-shop h2").html($(this).attr("name"));
		$("#part-shop .description").html($(this).attr("description"));
		$("#part-shop .thumb").html($(this).find(".image-place").html());
		$("#part-shop .cost").html($(this).attr("cost"));
		$("#part-shop #part-id").val($(this).attr("iid"));
		$("#part-shop").show();
	});
});
