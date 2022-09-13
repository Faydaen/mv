var Register = function() {
	var tryPerson = function()
	{
		var errors = 1;
		$('input[name=name]').val($('input[name=name]').val().replace(/\s+/, ' '));
		if ($('input[name=name]').val().length < 5 || $('input[name=name]').val().length > 20) {
			$('#login-error > span').text('Имя должно быть от 5 до 20 символов');
		} else {
			$('#login-error > span').text('');
			errors--;
		}
		if (errors != 0) {
			return false;
		}
	}

	var tryProtect = function()
	{
		var errors = 3;
		if ($('#email').val().length < 8 || $('#email').val().length > 30) {
			$('#email-error > span').text('Неверный e-mail');
		}
		else {
			$('#email-error > span').text('');
			errors--;
		}
		if ($('#registration-agreement-checkbox:checked').length == 0) {
			$('#registration-agreement-error').show();
		} else {
			$('#registration-agreement-error').hide();
			errors --;
		}
		if ($('#password').val() != $('#retypepassword').val()) {
			$('#password-error > span').text('Пароли не совпадают');
			$('#retypepassword-error > span').text('Пароли не совпадают');
		} else if ($('#password').val().length < 6 || $('#password').val().length > 20) {
			$('#password-error > span').text('Пароль должен быть от 6 до 20 символов');
			$('#retypepassword-error > span').text('');
		} else {
			$('#password-error > span').text('');
			$('#retypepassword-error > span').text('');
			errors--;
		}
		if (errors != 0) {
			return false;
		}
	}

	var changeFractionCounter = 0;
	var changePersonCounter = 0;

	var back = Math.round(Math.random() * 5);
	var person = Math.round(Math.random() * 2);
	var randomFraction = (Math.random() >= 0.5) ? "resident" : "arrived";
	var fraction = (getCookie("register_fraction") && getCookie("register_fraction").length > 0) ? getCookie("register_fraction") : randomFraction;
	var gender = (Math.random() >= 0.5) ? "male" : "female";

	var chars = {
		resident: {
			male: new Array(),
			female: new Array()
		},
		arrived: {
			male: new Array(),
			female: new Array()
		}
	};

	var backs = new Array("avatar-back-6", "avatar-back-1", "avatar-back-2", "avatar-back-3", "avatar-back-4", "avatar-back-5");

	chars.resident.male.push("man4.png");
	chars.resident.male.push("man5.png");
	chars.resident.male.push("man1.png");

	chars.resident.female.push("girl1.png");
	chars.resident.female.push("girl4.png");
	chars.resident.female.push("girl5.png");

	chars.arrived.male.push("man3.png");
	chars.arrived.male.push("man6.png");
	chars.arrived.male.push("man2.png");

	chars.arrived.female.push("girl2.png");
	chars.arrived.female.push("girl3.png");
	chars.arrived.female.push("girl6.png");

	var changeGender = function() {
		if (gender == "male") {
			//gender = "female";
			$("label[for='registration-side-resident']").html("Коренной");
			$("label[for='registration-side-arrived']").html("Понаехавший");
			$("#avatar-gender").html("Пол: мужской");
		} else {
			//gender = "male";
			$("label[for='registration-side-resident']").html("Коренная");
			$("label[for='registration-side-arrived']").html("Понаехавшая");
			$("#avatar-gender").html("Пол: женский");
		}
	}

	var changePerson = function() {
		var avatar = chars[fraction][gender][person];
		var eyes = avatar.replace(".png", "_eyes.gif");
		$("#person-avatar").replaceWith("<img id=\"person-avatar\" style=\"background: url('/@/images/pers/" + avatar + "') repeat scroll 0% 0% transparent;\" src=\"/@/images/pers/" + eyes + "\" />");
		$("#input-person-avatar").val(avatar);
	}

	var changeFraction = function(value) {
		if (value && (value == "resident" || value == "arrived")) {
			fraction = value;
		}
		if (fraction == "resident") {
			$("#avatar-back-thumb-arrived").hide();
			$("#avatar-back-thumb-resident").show();
		} else {
			$("#avatar-back-thumb-arrived").show();
			$("#avatar-back-thumb-resident").hide();
		}
		$("#registration-side-" + fraction).attr("checked", "checked");
		changePerson();
	}

	var changeBack = function() {
		$("#avatar-back").attr("class", backs[back]);
		$("#input-person-background").val(backs[back]);
	}

	$(document).ready(function() {
		if ($("#input-person-background").val() && $("#input-person-background").val().length) {
			back = backs.indexOf($("#input-person-background").val());
			if (back == -1) back = 0;
		}

		var personAvatar = $("#input-person-avatar").val();
		if (personAvatar && personAvatar.length) {
			var tmpPerson = -1;
			tmpPerson = chars.resident.male.indexOf(personAvatar);
			if (tmpPerson != -1) {
				fraction = "resident";
				gender = "male";
				person = tmpPerson;
			}
			tmpPerson = chars.resident.female.indexOf(personAvatar);
			if (tmpPerson != -1) {
				fraction = "resident";
				gender = "female";
				person = tmpPerson;
			}
			tmpPerson = chars.arrived.male.indexOf(personAvatar);
			if (tmpPerson != -1) {
				fraction = "arrived";
				gender = "male";
				person = tmpPerson;
			}
			tmpPerson = chars.arrived.female.indexOf(personAvatar);
			if (tmpPerson != -1) {
				fraction = "arrived";
				gender = "female";
				person = tmpPerson;
			}
		}

		var tmpFraction = $("input[name='side']").filter(":checked").val();
		if (tmpFraction && tmpFraction.length && (tmpFraction == "resident" || tmpFraction == "arrived")) {
			fraction = tmpFraction;
		}

		changeGender();
		changeBack();
		changePerson();
		changeFraction();
	});

	var nextPerson = function() {
		gender = (gender == "female") ? "male" : "female";
		changeGender();
		if (changePersonCounter == 1) {
			person++;
			if (person > 2) person = 0;
			changePersonCounter = 0;
		} else {
			changePersonCounter++;
		}
		changePerson();
	}

	var prevPerson = function() {
		gender = (gender == "female") ? "male" : "female";
		changeGender();
		if (changePersonCounter == 0) {
			person--;
			if (person < 0) person = 2;
			changePersonCounter = 1;
		} else {
			changePersonCounter--;
		}
		changePerson();
	}

	var nextBack = function() {
		back++;
		if (back >= backs.length) back = 0;
		changeBack();
	}

	var prevBack = function() {
		back--;
		if (back < 0) back = backs.length - 1;
		changeBack();
	}

	$(document).ready(function() {
		$("#form-person").bind("submit", tryPerson);
		$("#form-protect").bind("submit", tryProtect);

		$("#pers-arrow-3").bind("click", prevBack);
		$("#pers-arrow-4").bind("click", nextBack);

		$("#pers-arrow-1").bind("click", prevPerson);
		$("#pers-arrow-2").bind("click", nextPerson);
	});

	var randomize = function() {
		gender = (gender == "female") ? "male" : "female";
		changeGender();
		changePerson();
		if (changeFractionCounter == 1) {
			fraction = (fraction == "resident") ? "arrived" : "resident";
			changeFractionCounter = 0;
			changeFraction();
		} else {
			changeFractionCounter = 1;
		}
		if (changePersonCounter == 3) {
			person++;
			if (person > 2) person = 0;
			changePersonCounter = 0;
		} else {
			changePersonCounter++;
		}
		back = Math.round(Math.random() * 5);
		changeBack();
	}

	return {
		randomize: randomize,
		changeFraction: changeFraction
	}

}();