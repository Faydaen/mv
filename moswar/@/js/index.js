avatarImages = ['resident','arrived'];
avatarImages['resident'] = [ 'man1.png', 'girl1.png', 'man4.png', 'girl4.png', 'man5.png', 'girl5.png' ];
avatarImages['arrived'] = [ 'man2.png', 'girl2.png', 'man3.png', 'girl3.png', 'man6.png', 'girl6.png' ];
avatarBackgrounds = [ 'avatar-back-1', 'avatar-back-2', 'avatar-back-3', 'avatar-back-4', 'avatar-back-5', 'avatar-back-6' ];
var avatarImages_current = 1;
var avatarBackgrounds_current = 5;

function changeAvatarImage(dir)
{
	var side = $("input[name=side]:checked").val();
	if (!avatarImages[side]) return;
    if ('next' == dir) {
        avatarImages_current = (avatarImages_current + 1) % avatarImages[side].length;
    } else if ('previous' == dir) {
        avatarImages_current = (avatarImages_current - 1) % avatarImages[side].length;
        if (avatarImages_current < 0) {
            avatarImages_current = avatarImages[side].length - 1;
        }
    } else {
		
	}
    $("#avatar-back img").attr("src", "/@/images/pers/" + avatarImages[side][avatarImages_current].replace(/\.png/, "_eyes.gif"));
    $("#avatar-back img").css("background", "url(/@/images/pers/" + avatarImages[side][avatarImages_current] + ")");
    $("#avatar-gender").html("Пол: "+ (avatarImages[side][avatarImages_current].indexOf("man") >= 0 ? "мужской" : "женский") );
    $("input[name=avatar]").val(avatarImages[side][avatarImages_current]);
}

function changeAvatarBackground(dir)
{
    if ('next' == dir) {
        avatarBackgrounds_current = (avatarBackgrounds_current + 1) % avatarBackgrounds.length;
    } else {
        avatarBackgrounds_current = (avatarBackgrounds_current - 1) % avatarBackgrounds.length;
        if (avatarBackgrounds_current < 0) {
            avatarBackgrounds_current = avatarBackgrounds.length - 1;
        }
    }
    $("#avatar-back").attr('class', avatarBackgrounds[avatarBackgrounds_current]);
    $('input[name=background]').val(avatarBackgrounds[avatarBackgrounds_current]);
}

function changeSide()
{
	changeAvatarImage();
}

function registerSplashShow(side)
{
    if ($('#register-splash').is(':hidden')) {
        /*
        $('input[name=side]').val (side);
        if('arrived' == side) {
            $("#registration-side").html("Регистрация понаехавшего");
        } else {
            $("#registration-side").html("Регистрация коренного");
        }
        */
        $("#registration-side-" + side).attr("checked", true);
		changeAvatarImage();
        $('#register-splash').show();
    } else {
        $('#register-splash').hide();
    }
}

function tryRegister()
{
    var errors = 4;
    if ($('#email').val().length < 8 || $('#email').val().length > 30) {
        $('#email-error > span').text('Неверный e-mail');
    }
    else {
        $('#email-error > span').text('');
        errors--;
    }
    $('input[name=name]').val($('input[name=name]').val().replace (/\s+/, ' '));
    if ($('input[name=name]').val ().length < 5 || $('input[name=name]').val ().length > 20) {
        $('#login-error > span').text('Имя должно быть от 5 до 20 символов');
    } else {
        $('#login-error > span').text('');
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
    if (errors == 0) {
        $.post ('/', {side: $('input[name=side]:checked').val(), email: $('#email').val(), name: $('input[name=name]').val(), password: $('#password').val(), avatar: $('input[name=avatar]').val (), background: $('input[name=background]').val (), invite: $('input[name=invite]').val(), action: 'register'}, function (data) {
            eval (data);
        });
    }
}

$(document).ready(function()
{
    $("input[name=avatar]").val(avatarImages[avatarImages_current]);
    $("input[name=background]").val(avatarBackgrounds[avatarBackgrounds_current]);

    $('#pers-arrow-1').bind('click', function(){ changeAvatarImage('previous'); });
    $('#pers-arrow-2').bind('click', function(){ changeAvatarImage('next'); });
    $('#pers-arrow-3').bind('click', function(){ changeAvatarBackground('previous'); });
    $('#pers-arrow-4').bind('click', function(){ changeAvatarBackground('next'); });

    $('#register-splash-close').bind('click', registerSplashShow);
	changeAvatarImage();

    $('td.submit > span.button').bind('click', tryRegister);
    $('div.bar-login span.button').bind('click', function(){
        $(this).parents ('form:first').trigger('submit');
    });
});