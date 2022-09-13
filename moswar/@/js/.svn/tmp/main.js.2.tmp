if(!Array.indexOf) {
	Array.prototype.indexOf = function(obj) {
		for(var i = 0; i < this.length; i ++) {
			if (this[i] == obj) {
				return i;
			}
		}
		return -1;
	}
}

//" + LANG_MAIN_81 + "

var area = '';

var postVerifyKey = '';

var glob = new Object;

//" + LANG_MAIN_50 + "

function setTitle(str) {
	if (top.frames.length > 1) {
		top.document.title = str;
	} else {
		document.title = str;
	}
}

function setCaretPosition(ctrl, pos){
	if(ctrl.setSelectionRange)
	{
		ctrl.focus();
		ctrl.setSelectionRange(pos,pos);
	}
	else if (ctrl.createTextRange) {
		var range = ctrl.createTextRange();
		range.collapse(true);
		range.moveEnd('character', pos);
		range.moveStart('character', pos);
		range.select();
	}
}

function getCaretPosition (ctrl) {
	var CaretPos = 0;	// IE Support
	if (document.selection) {
	ctrl.focus ();
		var Sel = document.selection.createRange ();
		Sel.moveStart ('character', -ctrl.value.length);
		CaretPos = Sel.text.length;
	}
	// Firefox support
	else if (ctrl.selectionStart || ctrl.selectionStart == '0')
		CaretPos = ctrl.selectionStart;
	return (CaretPos);
}

function reloadTextSize(obj) {
	var maxTextSize = $(obj).parents("form:first").find("input[name='maxTextSize']").val();
	var currentTextSize = $(obj).val().length;
	if (currentTextSize > maxTextSize) {
		var pos = getCaretPosition(obj);
		$(obj).val($(obj).val().substr(0, maxTextSize));
		setCaretPosition(obj, pos);
		obj.scrollTop = obj.scrollHeight;
		currentTextSize = $(obj).val().length;
	}
	$(obj).parents("form:first").find("span[rel='currentTextSize']").html(maxTextSize - currentTextSize);
	return true;
}

$(document).ready(function() {
	var ta = $(".messages-add textarea");
	if (ta.length > 0) {
		setInterval(function() {reloadTextSize(ta[0]);} , 100);
	}
});

function animateNumber(holder, newValue) {
	var current = parseInt($(holder).text().replace(/[^0-9]/g, ""));
	var diff = 0;
	var step = 0;
	if (current > newValue) {
		diff = current - newValue;
		step = Math.ceil(diff / 16) * -1;
	} else {
		diff = newValue - current;
		step = Math.ceil(diff / 16);
	}
	if (step != 0) {
		var changed = current;
		var changeInterval = setInterval(function() {
			changed += step;
			if ((changed >= newValue && step > 0) || (changed <= newValue && step < 0)) {
				clearInterval(changeInterval);
				$(holder).html($(holder).html().replace(/[0-9\,]+/, formatNumber(newValue)));
			} else {
				$(holder).html($(holder).html().replace(/[0-9\,]+/, formatNumber(changed)));
			}
		}, 50);
	}
}

function countdown(obj) {
	if ($(obj).length == 0) {
		return;
	}
	var timer = $(obj).attr('timer');
	if ($(obj).attr('endtime') > 0) {
		timer = $(obj).attr('endtime') - $('#servertime').attr('rel');
	}
	var s = timer % 60;
	var m = Math.floor(timer / 60) % 60;
	var h = Math.floor(timer / 3600);
	if (s < 10) {
		s = '0' + s;
	}
	if (m < 10) {
		m = '0' + m;
	}
	if (h < 10) {
		h = '0' + h;
	}
	var sTime = h + ':' + m + ':' + s;
	$(obj).text(sTime);
	timer--;
	$(obj).attr('timer', timer);

	/* write to title */
	if ($(obj).attr("intitle") == 1) {
		var sTitle = document.title;
		if( /^\s?\[[^\]]*\]/.test(sTitle) ){
			sTitle = sTitle.replace(/^\s?\[([^\]]*)\]/,'['+sTime+']');
		} else {
			sTitle = '['+sTime+'] ' + sTitle;
		}
        sTitle = sTitle.replace("0-1", "00").replace("0-1", "00").replace("0-1", "00"); // костыль
		setTitle(sTitle);
	}

    // bar
    if ($(obj)[0].id != "" && $("#" + $(obj)[0].id + "bar")[0] != null) {
        var bar = $("#" + $(obj)[0].id + "bar");
        if (bar.attr("reverse") == "1") {
            bar.css("width", (100 - Math.round(($(obj).attr("timer2") - timer) / $(obj).attr("timer2") * 100)) + "%");
        } else {
            bar.css("width", Math.round(($(obj).attr("timer2") - timer) / $(obj).attr("timer2") * 100) + "%");
        }
    }

	if (timer >= 0) {
		setTimeout(function(){countdown(obj);}, 1000);
	} else {
		if ($(obj).attr('id') != 'timeout') {
			onTimerCompleteEvent($(obj).id);
		}
		if ($(obj).attr("trigger")) {
			eval($(obj).attr("trigger"));
		}
		if($(obj).is("td.value") && $(obj).parents("table:first").is("table.process")){
			// if this is table.process
			$(obj).parents("table.process:first").addClass("process-blinking");
		} else {
			var interval = setInterval(function(){
				if("hidden" == $(obj).css("visibility")){
					$(obj).css("visibility","visible");
				} else {
					$(obj).css("visibility","hidden");
				}
			}, "800");
		}
	}
}

var currenthp, maxhp;
function healInit()
{
	currenthp = new Number($('#currenthp').text());
	maxhp = new Number($('#maxhp').text());
	if (currenthp < maxhp) {
		setTimeout(heal, 10000);
	}
}
function heal()
{
	var inc = 180;
	var playerInfo = $("#personal a.name b").text();
	if (playerInfo.length) {
		var level = parseInt(playerInfo.match("\\[([0-9]+)\\]")[1]);
		if (level == 1) {
			inc = inc / 6;
		}
	}

	currenthp += maxhp / inc;
	if (currenthp > maxhp) {
		currenthp = maxhp;
	}
	setHP(currenthp);
	if (currenthp < maxhp) {
		setTimeout(heal, 10000);
	}
}
function setHP(hp)
{
	currenthp = hp;
	$("#currenthp").text(Math.round(currenthp));
	var percent = Math.round(currenthp / maxhp * 100);
	var time = 1500;
	$('#playerHpBar').animate({width: percent + '%'}, time);
	if ($("#equipment-accordion").length) {
		$('.pers-statistics .life .bar .percent').animate({width: percent + '%'}, time);
		$(".pers-statistics .life .currenthp").text(Math.round(currenthp));
	}
}

var initTimers = function() {
		$('*[timer]').each(function(){
		if ($(this).attr("timer") > 0 && $(this).attr("timer") != '') {
			if ($(this).attr("notitle") != 1) {
				$(this).show();
			}
			countdown($(this));
		}
	});
};

$(document).ready(function()
{
	initTimers();
	setTitle(document.title);
	healInit();
	simple_tooltip("*[tooltip=1]","tooltip");
	//$('html,body').animate({scrollTop: 60}, 500);
	$("#smiles img").click(function() {
		emoticon(" :" + $(this).attr("alt") + ": ", $("#smiles").attr("rel"));
		if ($("#smiles").attr("alt") == '1') {
			$("#overtip-smiles").hide();
		}
	});
	setInterval(function(){
		var time = $("#servertime").attr("rel");
		var d = new Date();
		d.setTime((time - (-180) * 60) * 1000); // серверное время здесь
		var m = d.getUTCMinutes();
		if (m < 10) {
			m = "0" + m;
		}
		var s = d.getUTCSeconds();
		if (s < 10) {
			s = "0" + s;
		}
		$("#servertime").html(d.getUTCHours() + ":" + m + ":" + s);
		time ++;
		$("#servertime").attr("rel", time);
	}, "1000");

    // alert
    $("div.alert[rel='show']").show();
	
	// frooze links & buttons
	$("div.action[rel!='notfreeze']").not(".disabled").click(function(){
		$("div.action").addClass('disabled').attr('onclick', 'return false;');
	});
	$("button.button[rel='freeze']").click(function(){
		if ($(this).attr("type") == "submit") {
			$(this).parents("form:first")[0].submit();
			$(this).parents("form:first").bind("submit", function(){return false;})
		}                                                                          
		$(this).addClass('disabled').attr('disabled', 'disabled').unbind("click");
	});

	//$(".tugriki-block span").text(intToKM($(".tugriki-block span").text().replace(/,/g, "")));
	//$(".ruda-block span").text(intToKM($(".ruda-block span").text().replace(/,/g, "")));
	//$(".med-block span").text(intToKM($(".med-block span").text().replace(/,/g, "")));
	//$(".neft-block span").text(intToKM($(".neft-block span").text().replace(/,/g, "")));
});                                                                                                 

/*
var intToKM = function(count) {
	if (count > 1000000) {
		count = count / 1000000;
		count = count.toFixed(1);
		count += "M";
	} else {
		if (count > 1000) {
			count = count / 1000;
			count = count.toFixed(1);
			count += "k";
		}
	}
	return count.toString().replace(".", ",");
}
*/

function postUrl(path, params, method) {                                                                                                   
	if ($('#service-form').length > 0) {                                                            
		return false;                                                                               
	}                                                                                               
    var formHtml = '<form action="' + path + '" method="' + method + '" style="display:none;" id="service-form">';
    for(var key in params) {                                                                        
        formHtml += '<input type="hidden" name="' + key + '" value="' + params[key] + '" />';       
    }                                                                                               
    formHtml += '</form>';                                                                          
                                                                                                    
    $("#main").append(formHtml);                                                                    
    $("#service-form").submit();                                                                    
}                                                                                                   
                                                                                                    
function input(query, value, path)                                                                  
{                                                                                                   
	var value = prompt(query, value);                                                               
	if (value != null) {                                                                            
		postUrl(path, {param: value}, "post");                                                      
	}                                                                                               
}                                                                                                   
                                                                                                    
function showCaptcha(returnUrl)
{                                                                                                   
	if ($("#captcha").length > 0) {                                                                 
		$("#captcha").remove();                                                                     
	}                                                                                               
	//$("body").append("<div id='captcha' class='overtip' style='background-color: !important; position: absolute; display: block; width: 300px; height: auto; top: 40%; left: 40%; min-width: 300px; min-height: 100px; text-align: center;'><h2>" + LANG_MAIN_58 + "</h2><div class='data'>" + LANG_MAIN_10 + "<div id='captcha_inside'><img src='/captcha/&" + Math.random() +  "' /><br /><input type='text' id='captcha_code' name='captcha' value='' /><br /><input type='button' onclick='checkCaptcha(\"" + returnUrl + "\");' value='" + LANG_MAIN_64 + "' /></div></div></div>");
	$("body").append("<div id='captcha' class='overtip passport-check'><div class='text'><div id='captcha_inside'>" + LANG_MAIN_25 + "<br />—" + LANG_MAIN_24 + "<b>" + LANG_MAIN_44 + "</b>" + LANG_MAIN_72 + "</div></div><div class='number'><input type='text' id='captcha_code' name='captcha' value='' /><br /><button class='button' type='button' onclick='checkCaptcha(\"" + returnUrl + "\");'><span class='f'><i class='rl'></i><i class='bl'></i><i class='brc'></i><div class='c'>" + LANG_MAIN_71 + "</div></span></button></div><div class='captcha'><img src='/captcha/&" + Math.random() +  "' /></div></div>");
}                                                                                                   
                                                                                                    
function checkCaptcha(returnUrl)                                                                    
{                                                                                                   
	var code = $('#captcha_code').val();                                                            
	$('#captcha_inside').html('<br /><i>' + LANG_MAIN_42 + '</i><br />&nbsp;');                     
	$.post("/captcha/", {action: "check_captcha", code: code}, function(data) {                     
		if (data == 'ok') {                                                                         
			$('#captcha_inside').html('<br /><i>' + LANG_MAIN_46 + '</i><br />&nbsp;');             
			setTimeout(function(){document.location.href=returnUrl;}, "500");                       
		} else {                                                                                    
			$('#captcha_inside').html('<br /><i>' + LANG_MAIN_63 + '</i><br />&nbsp;');             
			setTimeout(function(){showCaptcha(returnUrl)}, "500");                                  
		}                                                                                           
	});                                                                                             
}                                                                                                   
                                                                                                    
function emoticon(text, elementId)                                                                  
{                                                                                                   
	if (document.getElementById(elementId).createTextRange && document.getElementById(elementId).caretPos) {
		var caretPos = document.getElementById(elementId).caretPos;                                 
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;  
	} else {                                                                                        
		document.getElementById(elementId).value += text;                                           
	}                                                                                               
	$("#" + elementId).trigger('focus');                                                            
}           

function simple_tooltip_hide (tooltipid) {
	var tooltip = $("#"+tooltipid);
	tooltip.parents('div.overtip:first').hide();
	tooltip.attr("nohide","");
	tooltip.parents('div.overtip:first').find("span.close-cross").hide();
}                                                                                        
                                                                                                    
function simple_tooltip(target_items, name)                                                         
{                                                                                                   
	$(target_items).each(function(i){                                                               
		var content = $(this).attr('title').replace(/\s{2,}/m, '');                                 
		if (content.split('||').length > 1) {                                                       
			var arr = content.split('||');                                                          
			var title = arr[0];                                                                     
			if (arr[2]) {                                                                           
				var desc = arr[1];                                                                  
				content = arr[2];                                                                   
			} else {                                                                                
				content = arr[1];                                                                   
			}                                                                                       
		}                                                                                           
		if (content.split('|').length > 1) {                                                        
			var arr = content.split('|');                                                           
			content = '';                                                                           
			if (arr) {                                                                              
				for (var j = 0; j < arr.length; j++) {                                              
					if (arr[j] && arr[j].replace('	', '').length > 2) content += "<span class='brown'>" + arr[j] + "</span><br />";
				}                                                                                   
			}                                                                                       
			if (desc) {                                                                             
				content = desc + "<br />" + content;                                                
			}                                                                                       
		}                                                                                           
        var image = "";                                                                             
		if ($(this).attr('src') && $(this).attr('src').length > 0) {                                
			image = '<img src="' + $(this).attr('src') + '" />';                                    
		}  
		
        if (image == "") {                                                                          
            $("body").append("<div class='overtip' style='position: absolute; display: none; max-width: 250px; z-index:90;'><div class='help' id='"+name+i+"'>"+
				"<h2>" + title + "</h2><div class='data'>" + content + "</div></div>"+
				( $(this).attr("clickable") ? "<span class='close-cross' onclick='simple_tooltip_hide(\""+name+i+"\");' style='display:none;'>&#215;</span>" : "" )+
				"</div>");
        } else {                                                                                    
	        $("body").append("<div class='overtip' style='position: absolute; display: none; max-width: 250px; z-index:90;'><div class='object' id='"+name+i+"'>"+
				"<h2>" + title + "</h2><div class='data'>" + content + "<i class='thumb'>" + image + "</i></div></div>"+
				( $(this).attr("clickable") ? "<span class='close-cross' onclick='simple_tooltip_hide(\""+name+i+"\");' style='display:none;'>&#215;</span>" : "" )+
				"</div>");
        }                                                                                           
		$(this).removeAttr("title").mouseover(function(kmouse){  
			var nohide = $("#"+name+i).attr("nohide");
			if( !nohide ) {
				$("#"+name+i).parents('div.overtip:first').css({opacity:1, display:"none"}).fadeIn(400);
			}
		}).mousemove(function(kmouse){   
			var nohide = $("#"+name+i).attr("nohide");
			if( !nohide ) {
				var left = kmouse.pageX+15;
				var width = $("#"+name+i).parents('div.overtip:first').width();
				var windowWidth = $(window).width();
				if (left + width > windowWidth - 10) {
					left = windowWidth - width - 10;
				}
				$("#"+name+i).parents('div.overtip:first').css({left:left, top:kmouse.pageY+15});
			}
		}).mouseout(function(){     
			var nohide = $("#"+name+i).attr("nohide");
			if( !nohide ) {
				$("#"+name+i).parents('div.overtip:first').fadeOut(400);                                
			}
		});                                                                                         
		
		/* click to fixate tooltip */
		if( $(this).attr("clickable") ){
			$(this).bind("click", function(){
				var tooltip= $("#"+name+i);
				if(tooltip.attr("nohide") && tooltip.is(":visible")){
					tooltip.attr("nohide","");
					tooltip.parents('div.overtip:first').find("span.close-cross").hide();
				} else {
					tooltip.parents('div.overtip:first').show();
					tooltip.attr("nohide","1");
					tooltip.parents('div.overtip:first').find("span.close-cross").show();
				}
			});
			$(this).attr("title",LANG_MAIN_129);
		}
	});                                                                                             
}                                                                                                   
                                                                                                    
function setCookie (name, value, path, expires, domain, secure) {                                   
	path = "/";                                                                                     
	document.cookie = name + "=" + escape(value) +                                                  
		((expires) ? "; expires=" + expires : "") +                                                 
		((path) ? "; path=" + path : "") +                                                          
		((domain) ? "; domain=" + domain : "") +                                                    
		((secure) ? "; secure" : "");                                                               
}                                                                                                   
                                                                                                    
function getCookie(name)                                                                            
{                                                                                                   
	var cookie = " " + document.cookie;                                                             
	var search = " " + name + "=";                                                                  
	var setStr = null;                                                                              
	var offset = 0;                                                                                 
	var end = 0;                                                                                    
	if (cookie.length > 0) {                                                                        
		offset = cookie.indexOf(search);                                                            
		if (offset != -1) {                                                                         
			offset += search.length;                                                                
			end = cookie.indexOf(";", offset);                                                      
			if (end == -1) {                                                                        
				end = cookie.length;                                                                
			}                                                                                       
			setStr = unescape(cookie.substring(offset, end));                                       
		}                                                                                           
	}                                                                                               
	return(setStr);                                                                                 
}                                                                                                   
                                                                                                    
function formatNumber(number, decimals, decimalsPoint, thousandsSeparator)                          
{                                                                                                   
	number = Number(number) || 0;                                                                   
    if (decimals > 0) {                                                                             
        number = Math.round(number * (decimals * 10)) / (decimals * 10);                            
    }                                                                                               
    var a = Math.floor(number);                                                                     
    var b = number - a;                                                                             
    a = a + ""; //" + LANG_MAIN_51 + "                                                              
    var a2 = "";                                                                                    
    var j = 0;                                                                                      
    for (var i = a.length - 1; i >= 0; i--) {                                                       
        a2 += a.charAt(j);                                                                          
        j++;                                                                                        
        if (i % 3 == 0 && i != 0) {                                                                 
            a2 += thousandsSeparator;                                                               
        }                                                                                           
    }                                                                                               
    if (decimals > 0) {                                                                             
        a2 = a2 + decimalsPoint + b;                                                                
    }                                                                                               
    return a2;                                                                                      
}                                                                                                   
                                                                                                    
function updatePlayerBlockMoney(sum, op)                                                            
{                                                                                                   
    var money = $("#personal .tugriki-block").attr("title");                                        
    money = money.split(':');                                                                       
    money = parseInt($.trim(money[1]));                                                             
    switch (op) {                                                                                   
        case "+":money += sum;break;                                                                
        case "-":money -= sum;break;                                                                
    }                                                                                               
    $("#personal .tugriki-block").attr("title", LANG_MAIN_101 + "" + money);                        
    $("#personal .tugriki-block").html('<b class="tugriki"></b><br>' + formatNumber(money, 0, "", ","));
}                                                                                                   
                                                                                                    
var showHelpTips = function()                                                                       
{                                                                                                   
    $("#overtip-help-alley").show("normal");                                                        
    if(!jQuery.browser.msie)$("#background").show();                                                
}                                                                                                   
                                                                                                    
var closeHelpTips = function(obj)                                                                   
{                                                                                                   
    $(obj).parents('div.overtip:first').hide('fast');                                               
    $('#background').hide();                                                                        
    setCookie("hideHelpTips","1");                                                                  
}                                                                                                   
                                                                                                    
function onTimerCompleteEvent(type) {
	if (typeof(type) != "undefined") {
		area = type;
	}
    switch (area) {
        case "metro":
            $("#kopaem").hide();
            var myRat = $.ajax({url:"/metro/myrat/", async:false}).responseText;
            if (myRat != "0") {
                $("#welcome-no-rat").hide();
                $("#content-no-rat").hide();
                $("#welcome-rat").show();
                $("#ratlevel").html(myRat);
            } else {
                $("#ore_chance").html($.ajax({url:"/metro/myorechance/", async:false}).responseText + "%");
                $("#vykopali").show();
            }
            break;

        case "metro_rat":
            $("#ratsearch").hide();
            var ratLevel = $.ajax({url:"/metro/myrat/", async:false}).responseText;
            if (ratLevel == "0") {
                $("#ratnotfound").show();
            } else {
                $("#welcome-no-rat").hide();
                $("#content-no-rat").hide();
                $("#ratlevel").html(ratLevel);
                $("#welcome-rat").show();
            }
            break;

        case "factory_petrik":
            $("#factory_petrik_1").hide();
            $("#factory_petrik_2").show();
            break;

        case "trainer_vip":
            $("#trainer_vip_1").hide();
            $("#trainer_vip_2").show();
            break;

        case "alley":
            $("#leave-patrol-button").hide();
            break;

		case "neft":
			$("#neft-attack-now").hide();
			break;

		case 'petarena_train':
			petarenaTrainComplete();
			break;
    }
}

/*
        $.post($("#" + formId)[0].action, $("#" + formId).serialize(), function(status)
        {
            if (status == "1") {
                eval(onSuccess + "();");
            }
        });
*/

function openChat(room) {
	if (room && room.length) {
		setCookie('chat_room', room);
	}
	if (top.frames.length <= 1) {
		setCookie('lasturl',document.location.href);
		document.location.href = '/chat/';
	}else {
		if (room && room.length && room == "casino") {
			document.location.href = '/casino/';
		} else {
			document.location.href = '/chat/rooms/';
		}
	}
	
}

//" + LANG_MAIN_67 + "
function sendForm(formId, formCheckFunction)
{
    var checked;
    eval("checked = " + formCheckFunction + "();");
    if (checked) {
        $("#" + formId)[0].submit();
    }
}

//" + LANG_MAIN_106 + "

function forumAddVoteOption()
{
	$("input[name='option[]']:last").after('<p><input type="text" name="option[]" /></p>');
}

function forumRemoveVoteOption()
{
	$("input[name='option[]']:gt(1):last").parents('p:first').remove();
}

function forumDeletePost(post, topic)
{
    if (confirm(LANG_MAIN_54) == true) {
		$.post("/forum/topic/" + topic + "/", {action: "delete", post: post, topic: topic, ajax: 1}, function(status)
        {                                                                                           
            if (status == "1") {                                                                    
                $("#post-" + post + "-li").addClass("deleted");                                     
                $("#post-" + post + "-dellink").remove();                                           
            } else {                                                                                
                alert(LANG_MAIN_105);                                                               
            }                                                                                       
        });                                                                                         
        //postUrl("/forum/topic/" + topic + "/", {action: "delete", post: post, topic: topic}, "post");
    }                                                                                               
}                                                                                                   
                                                                                                    
function forumDeleteTopic(topic, forum)                                                             
{                                                                                                   
	var result = confirm(LANG_MAIN_37);                                                             
    if (result == true) {                                                                           
		postUrl("/forum/" + forum + "/", {action: "delete", topic: topic, forum: forum}, "post");   
    }                                                                                               
}                                                                                                   
                                                                                                    
function forumCloseTopic(topic)                                                                     
{                                                                                                   
	postUrl("/forum/topic/" + topic + "/", {action: "close", topic: topic}, "post");                
}                                                                                                   
                                                                                                    
function forumOpenTopic(topic)                                                                      
{                                                                                                   
	postUrl("/forum/topic/" + topic + "/", {action: "open", topic: topic}, "post");                 
}                                                                                                   
                                                                                                    
function forumCloseForum(forum)                                                                     
{                                                                                                   
	postUrl("/forum/" + forum + "/", {action: "close", forum: forum}, "post");                      
}                                                                                                   
                                                                                                    
function forumOpenForum(forum)                                                                      
{                                                                                                   
	postUrl("/forum/" + forum + "/", {action: "open", forum: forum}, "post");                       
}                                                                                                   
                                                                                                    
function forumMoveTopic(topic, forum)                                                               
{                                                                                                   
	postUrl("/forum/topic/" + topic + "/", {action: "move topic", topic: topic, forum: forum}, "post");
}                                                                                                   
                                                                                                    
function forumQuote(post)                                                                           
{                                                                                                   
	var text = $(post).find("td:eq(1) > span").html();                                              
	text = text.replace(/<(\/?)(b|i|u)>/gim, "[$1$2]");                                             
	text = text.replace(/<br\s?\/?>/gim, "");                                                       
	text = text.replace(/<img src=".*\/([^\.]+)\.gif" align="absmiddle"\s?\/?>/gim, " :$1: ");      
	var i = 0;                                                                                      
	while (text.indexOf("<div ", 0) != -1 && i <= 20) {                                             
		text = text.replace(/<div align="center">([^<]+)<\/div>/gim, '[center]$1[/center]');        
		text = text.replace(/<div align="right">([^<]+)<\/div>/gim, '[right]$1[/right]');           
		text = text.replace(/<div align="left">([^<]+)<\/div>/gim, '[left]$1[/left]');              
		text = text.replace(/<div class="quote">([^<]+)<\/div>/gim, '[quote]$1[/quote]');           
		i ++;                                                                                       
	}                                                                                               
	var text = "[quote][b]" + $(post).find("td:eq(1) span.user").text() + "[/b] ([i]" + $(post).find("td:eq(1) div.date span:first").text() + "[/i])\r\n" + text + "[/quote]\r\n";
	emoticon(text, 'posttext');
}

//" + LANG_MAIN_86 + "

function macdonaldsLeave()
{
	var result = confirm(LANG_MAIN_14);
	if (result == true) {
		postUrl('/shaurburgers/', {action: 'leave'}, 'post');
	}
}

/* Alley */

function alleyPatrolLeave() {
	var result = confirm(LANG_MAIN_11);
	if (result == true) {
		postUrl('/alley/', {action: 'leave'}, 'post');
	}
}

function alleySovetTakeDayPrize()
{
    postUrl("/alley/sovet-take-day-prize/", {}, "post");
}

function alleyInitCarousel(curRegion)
{
    $("#regions-choose-id").val(curRegion);
    $("div.regions-choose").jCarouselLite({
        btnNext: "#region-choose-arrow-right",
        btnPrev: "#region-choose-arrow-left",
        visible: 1,
        circular:true,
        start:(curRegion-1),
        afterEnd: function(a) {
			if($(a).find("i.icon-locked").length) {
				$("#alley-patrol-button").addClass("disabled");
				$("#alley-patrol-button").attr("disabled",true);
			} else {
				$("#alley-patrol-button").removeClass("disabled");
				$("#alley-patrol-button").attr("disabled",false);
			}
            /* посмотреть класс иконки и оставить только цифру */
            curRegion = Number( $(a).find("i[class*='region']").attr("class").replace(/\D*/i,"") );
            $("#regions-choose-id").val(curRegion);
        }
    });
}

function alleyAttack(playerId, force, werewolf, useitems) {
	force = typeof(force) != 'undefined' ? force : 0;
	werewolf = typeof(werewolf) != 'undefined' ? werewolf : 0;
	useitems = typeof(useitems) != 'undefined' ? useitems : 0;
	if (typeof(player) == 'undefined' || player['werewolf'] != 1 || force == 1) {
		postUrl('/alley/', {action: 'attack', 'player': playerId, 'werewolf': werewolf, 'useitems': useitems}, 'post');
	} else {
		$('#attack-panel').remove();
		$('body').append("<div class='alert' style='display: block !important;' id='attack-panel'><div class='padding'><h2>Напасть</h2><div class='data'>У Вас при себе есть маска оборотня. Вы можете воспользоваться ей и напасть анонимно, а можете сделать это открыто. Решайте сами.<br /><table><tr><td width='50%' align='center'>"
			+ "<img src='/@/images/pers/" + player['avatar_thumb'] + "' /><br /><b>" + player['nickname'] + " [" + player['level'] + "]</b><br />\n\
<div class='button' onclick='alleyAttack(" + playerId + ", 1, 0);'><span class='f'><i class='rl'></i><i class='bl'></i><i class='brc'></i><div class='c'>Напасть собой</div></span></div>"
			+ "</td><td width='50%' align='center'>"
			+ "<img src='/@/images/pers/npc2_thumb.png' /><br /><b>Оборотень [" + player['werewolf_level'] + "]</b><br />\n\
<div class='button' onclick='alleyAttack(" + playerId + ", 1, 1);'><span class='f'><i class='rl'></i><i class='bl'></i><i class='brc'></i><div class='c'>Напасть оборотнем</div></span></div>"
			+ "</td></tr></table></div></div></div>");
		var p = $('#attack-panel').offset();
		$('#attack-panel').css({"top": window.pageYOffset + Math.round(window.innerHeight/2) - $('#attack-panel').height()});
	}
}

/* /Alley */

//" + LANG_MAIN_121 + "

function bankUpdateRudaMoneySum(ore)
{
    ore = isNaN(ore) ? 0 : Math.abs(ore);
    $("#tugriks").html((ore * 750) + "<i></i>");
}

//" + LANG_MAIN_104 + "

function phoneDeleteMessages(type)
{
	if (window.confirm(LANG_MAIN_26) == true) {
		postUrl('/phone/messages/' + type + "/", {action: "delete"}, 'post');
	}
}

function phoneConfirmDeleteContact(nickname, id, type)
{
    if (window.confirm(LANG_MAIN_17 + "" + nickname + "?") == true) {
		postUrl("/phone/contacts/", {action:"delete", id:id, nickname:nickname, type:type}, "post");
    }                                                                                               
}                                                                                                   
                                                                                                    
function phoneDeleteLogs()                                                                          
{                                                                                                   
	if (window.confirm(LANG_MAIN_30) == true) {                                                     
		postUrl('/phone/logs/', {action: "delete"}, 'post');                                        
	}                                                                                               
}                                                                                                   
                                                                                                    
function phoneComplainMessage(id)                                                                   
{                                                                                                   
	if (window.confirm(LANG_MAIN_3 + "\n\r" + LANG_MAIN_6) == true) {                               
		postUrl('/phone/messages/', {action: "complain", id: id}, 'post');                          
	}                                                                                               
}                                                                                                   
                                                                                                    
//" + LANG_MAIN_111 + "                                                                             
                                                                                                    
function metroWork()                                                                                
{                                                                                                   
	postUrl("/metro/", {action: "work"}, "post");                                                   
}                                                                                                   
                                                                                                    
function metroDig()                                                                                 
{                                                                                                   
	postUrl("/metro/", {action: "dig"}, "post");                                                    
}                                                                                                   
                                                                                                    
function metroLeave()                                                                               
{                                                                                                   
	var result = confirm(LANG_MAIN_13);                                                             
	if (result == true) {                                                                           
		postUrl('/metro/', {action: 'leave'}, 'post');                                              
	}                                                                                               
}                                                                                                   
                                                                                                    
function metroSearchRat(playerId)                                                                   
{                                                                                                   
    postUrl("/metro/search-rat/", {player: playerId}, "post");                                      
}                                                                                                   
                                                                                                    
function metroLeave2()                                                                              
{                                                                                                   
	postUrl('/metro/', {action: 'leave'}, 'post');                                                  
}                                                                                                   
                                                                                                    
function metroAttackRat(playerId)                                                                   
{                                                                                                   
    postUrl("/alley/attack-npc/1/", {player: playerId}, "post");                                    
}                                                                                                   
                                                                                                    
//" + LANG_MAIN_122 + "                                                                             
                                                                                                    
// mo to dip int                                                                                    
function clanLeave() {                                                                              
	var result = confirm(LANG_MAIN_35);                                                             
	if (result == true) {                                                                           
		postUrl("/clan/profile/", {action: "leave"}, "post");                                       
	}                                                                                               
}                                                                                                   
                                                                                                    
// mo to dip int                                                                                    
function clanAccept(player_id) {                                                                    
	postUrl("/clan/profile/", {action: "accept", player: player_id}, "post");                       
}                                                                                                   
                                                                                                    
// mo to dip int                                                                                    
function clanDrop(player_id)                                                                        
{                                                                                                   
    if (window.confirm(LANG_MAIN_18)) {                                                             
        postUrl("/clan/profile/", {action: "drop", player: player_id}, "post");                     
    }                                                                                               
}                                                                                                   
                                                                                                    
// mo to dip int                                                                                    
function clanRefuse(player_id) {                                                                    
	postUrl("/clan/profile/", {action: "refuse", player: player_id}, "post");                       
}                                                                                                   
                                                                                                    
// delete                                                                                           
function clanDissolve() {                                                                           
	var result = confirm(LANG_MAIN_8);                                                              
	if (result == true) {                                                                           
		postUrl("/clan/profile/", {action: "dissolve"}, "post");                                    
	}                                                                                               
}                                                                                                   
                                                                                                    
                                                                                                    
function clanDiplomacyExt(clanId, diplomacyType)                                                    
{                                                                                                   
    switch (diplomacyType) {                                                                        
        case "apply":
            confirmText = LANG_MAIN_4;                                                              
            break;                                                                                  
                                                                                                    
        case "apply_cancel":
            confirmText = LANG_MAIN_5;                                                              
            break;                                                                                  
                                                                                                    
        case "union_propose":
            confirmText = LANG_MAIN_9;                                                              
            break;                                                                                  
                                                                                                    
        case "union_propose_cancel":
            confirmText = LANG_MAIN_2;                                                              
            break;                                                                                  
                                                                                                    
        case "attack":
            confirmText = LANG_MAIN_27;                                                             
            break;                                                                                  
                                                                                                    
        default:
            confirmText = LANG_MAIN_76;                                                             
            break;                                                                                  
    }                                                                                               
    if (confirm(confirmText) == true) {                                                             
		postUrl("/clan/" + clanId + "/", {action: diplomacyType}, "post");                          
	}                                                                                               
}                                                                                                   
                                                                                                    
function clanDiplomacyInt(diplomacyId, diplomacyType)                                               
{                                                                                                   
    switch (diplomacyType) {                                                                        
        case "canceltitle":
            confirmText = LANG_MAIN_1;                                                              
            break;                                                                                  
                                                                                                    
        case "war_exit":
            confirmText = LANG_MAIN_32;                                                             
            break;                                                                                  
                                                                                                    
        default:
            confirmText = LANG_MAIN_76;                                                             
            break;                                                                                  
    }                                                                                               
    if (confirm(confirmText) == true) {                                                             
		postUrl("/clan/profile/", {action: diplomacyType, diplomacy: diplomacyId}, "post");         
	}                                                                                               
}                                                                                                   
                                                                                                    
function clanInternalAction(action, param)                                                          
{                                                                                                   
    switch (action) {                                                                               
        case "canceltitle":
            confirmText = LANG_MAIN_23;                                                             
            url = "team/canceltitle/";                                                              
            break;                                                                                  
                                                                                                    
        default:
            confirmText = LANG_MAIN_76;                                                             
            break;                                                                                  
    }                                                                                               
    if (confirm(confirmText) == true) {                                                             
		postUrl("/clan/profile/" + url, {action:action, param:param}, "post");                      
	}                                                                                               
}                                                                                                   
                                                                                                    
function clanWarehouseTake(inventoryId, itemCode)                                                   
{                                                                                                   
    $.post("/clan/profile/warehouse/take/", {inventory: inventoryId, code: itemCode}, function(data) {
		if (data == 1) {                                                                            
            document.location.href = "/clan/profile/warehouse/";                                    
        } else if (data == -1) {                                                                    
            alert(LANG_MAIN_33);                                                                    
        }                                                                                           
	});                                                                                             
}                                                                                                   
                                                                                                    
function clanWarehousePut(inventoryId, itemCode)                                                    
{                                                                                                   
    $.post("/clan/profile/warehouse/put/", {inventory: inventoryId, code: itemCode}, function(data) {
		if (data == 1) {                                                                            
            document.location.href = "/clan/profile/warehouse/";                                    
        } else if (data == -1) {                                                                    
            alert(LANG_MAIN_60);                                                                    
        }                                                                                           
	});                                                                                             
}                                                                                                   
                                                                                                    
function clanShowWarUserLogs(clan) {                                                                                                   
	if (clan == 0) {
		$('#clan-warstat1-table tr.user-logs').hide();                                              
	} else {
		if ($('#clan-warstat1-table tr.user-logs[rel=clan' + clan + '] td:first').is(':visible')) {           
		   $('#clan-warstat1-table tr.user-logs[rel=clan' + clan + ']').hide();                     
		} else {                                                                                    
		    $('#clan-warstat1-table tr.user-logs[rel=clan' + clan + ']').show();                    
		}                                                                                           
	}                                                                                               
}                                                                                                   
                                                                                                    
function clanTeamCalcCost()                                                                         
{                                                                                                   
    var cost = 0;                                                                                   
    if ($("select[name=founder]").val() != curFounderId) {                                          
        cost += 50000;                                                                              
    }                                                                                               
    if ($("select[name=adviser]").val() != curAdviserId) {                                          
        cost += 5000;                                                                               
    }                                                                                               
    if ($("select[name=money]").val() != curMoneyId) {                                              
        cost += 5000;                                                                               
    }                                                                                               
    if ($("select[name=forum]").val() != curForumId) {                                              
        cost += 5000;                                                                               
    }                                                                                               
    if ($("select[name=diplomat]").val() != curDiplomatId) {                                        
        cost += 5000;                                                                               
    }                                                                                               
    if ($("select[name=people]").val() != curPeopleId) {                                            
        cost += 5000;                                                                               
    }                                                                                               
    $("#cur-tugriks").html(formatNumber(cost,0,".",",") + "<i></i>");                               
                                                                                                    
    if (cost > 0) {                                                                                 
        $("#button-price").show();                                                                  
    } else {                                                                                        
        $("#button-price").hide();                                                                  
    }                                                                                               
    if (cost > clanMoney || cost == 0) {                                                            
        $("#roles-submit").addClass("disabled");                                                    
        $("#roles-submit").attr("disabled", true);                                                  
        if (cost > clanMoney) {                                                                     
            $("#no-money").show();                                                                  
        }                                                                                           
    } else {                                                                                        
        $("#roles-submit").removeClass("disabled");                                                 
        $("#roles-submit").attr("disabled", false);                                                 
        $("#no-money").hide();                                                                      
    }                                                                                               
}                                                                                                   
                                                                                                    
function clanHireDetective() {                                                                      
	postUrl("/clan/profile/", {action:'hire_detective'}, "post");                                   
}                                                                                                   
                                                                                                    
function clanTakeRest() {                                                                           
	if (confirm(LANG_CLAN_TAKEREST_CONFIRM) == true) {                                              
		postUrl("/clan/profile/", {action:'take_rest'}, "post");                                    
	}                                                                                               
}                                                                                                   
                                                                                                    
//" + LANG_MAIN_96 + "                                                                              
                                                                                                    
//" + LANG_MAIN_43 + "                                                                              
function checkPresentForm()                                                                         
{                                                                                                   
    if ($("#present-form-playerid").val() == "") {                                                  
        if (!$("#to-me")[0].checked) {                                                              
            player = $.trim($("#present-form-player").val());                                       
            if (player == "") {                                                                     
                $("#present-form div.report").show();                                               
                $("#present-form div.error").html(LANG_MAIN_53);                                    
                return false;                                                                       
            }                                                                                       
            if ($.ajax({url:"/shop/playerexists/" + encodeURIComponent(player) + "/", async:false}).responseText == "0") {
                $("#present-form div.report").show();                                               
                $("#present-form div.error").html(LANG_MAIN_114 + "<b>" + player + "</b>" + LANG_MAIN_82);
                return false;                                                                       
            }                                                                                       
        }                                                                                           
    }else {                                                                                        
        if ($.ajax({url:"/shop/playeridexists/" + $("#present-form-playerid").val() + "/", async:false}).responseText == "0") {
            $("#present-form div.report").show();                                                   
            $("#present-form div.error").html(LANG_MAIN_114 + "<b>" + player + "</b>" + LANG_MAIN_82);
            return false;                                                                           
        }                                                                                           
    }                                                                                               
    return true;                                                                                    
}                                                                                                   
                                                                                                    
//" + LANG_MAIN_39 + "                                                                              
function showPresentForm(key, itemId, itemName)
{                                                                                                   
    //$("#present-form")[0].action = "/shop/section/gifts/buy/" + itemId + "/";                     
	$("#itemid").val(itemId);
	$("#present_form_buy_key").val(key);
    $("#present-form-player").val("");                                                              
    $("#present-form-comment").val("");                                                             
    $("#present-form-private")[0].checked = false;                                                  
    $("#present-form-anonimous")[0].checked = false;                                                
    $("#present-form-present").html(itemName);                                                      
    $("#present-form div.report").hide();                                                           
    $("#present-panel").show();                                                                     
	$("#present-panel").css('top', $(document).scrollTop()+($(window).height() / 2)-($("#present-panel").height()/2)-200); /* 200 = $('div.column-right').offset().top */
}                                                                                                   
                                                                                                    
function shopBuyItem(key, item, return_url, amount, type) {
	if (!amount) amount = 1;                                                                        
	if (!type) type = 'normal';                                                                     
	postUrl('/shop/', {'key': key, 'action': 'buy', 'item': item, 'amount': amount, 'return_url': return_url, 'type': type}, 'post');
	$('li.object div.actions div.button').addClass('disabled');                                     
}                                                                                                   
                                                                                                    
function shopSellItem(item, return_url) {                                                           
	postUrl('/shop/', {'action': 'sell', 'item': item, 'return_url': return_url}, 'post');          
	$('li.object div.actions div.button').addClass('disabled');                                     
}                                                                                                   
                                                                                                    
//" + LANG_MAIN_116 + "                                                                             
                                                                                                    
function fightShowLog(element)                                                                      
{                                                                                                   
    if (!element) {                                                                                 
        element = $("#fight-log li:hidden:last");                                                   
    }                                                                                               
    element.slideDown("normal");                                                                    
    lifes = element.attr("rel").split(":");                                                         
                                                                                                    
    fighter1_life = lifes[0].split("/");                                                            
    $("#fighter1-life").html(Math.max(fighter1_life[0], 0) + '/' + fighter1_life[1]);               
    $("#fighter1-life").parent().find("div.percent").animate( {width: Math.ceil(100 * fighter1_life[0] / fighter1_life[1]) + "%"}, 1500 );
                                                                                                    
    fighter2_life = lifes[1].split("/");                                                            
    $("#fighter2-life").html(Math.max(fighter2_life[0], 0) + '/' + fighter2_life[1]);               
    $("#fighter2-life").parent().find("div.percent").animate( {width: Math.ceil(100 * fighter2_life[0] / fighter2_life[1]) + "%"}, 1500 );
                                                                                                    
    if (lifes[2] != "") {                                                                           
        pet1_life = lifes[2].split("/");                                                            
        $("#pet0-life").html(Math.max(pet1_life[0], 0) + '/' + pet1_life[1]);                       
        $("#pet0-life").parent().parent().find("div.percent").animate( {width: Math.ceil(100 * pet1_life[0] / pet1_life[1]) + "%"}, 1500 );
    }                                                                                               
                                                                                                    
    if (lifes[3] != "") {                                                                           
        pet2_life = lifes[3].split("/");                                                            
        $("#pet1-life").html(Math.max(pet2_life[0], 0) + '/' + pet2_life[1]);                       
        $("#pet1-life").parent().parent().find("div.percent").animate( {width: Math.ceil(100 * pet2_life[0] / pet2_life[1]) + "%"}, 1500 );
    }

    if (interactive && playerId > 0) {
        if (playerId == 1) {
            setHP(fighter1_life[0]);
        } else {
            setHP(fighter2_life[0]);
        }
    }
}

function fightTimer()
{
    $("#time-left").html(timeleft);
    timeleft--;
    if(timeleft < 0) {
        var element = $("#fight-log li:hidden:last");
        timeleft = 2;
        var lifes;
        var fighter1_life, fighter2_life;
        if(1 == $("#fight-log li").index(element)) {
            timeleft = 2;
            $("#timer-block").hide();
            fightShowLog(element);
        } else if($("#fight-log li").index(element) == -1) {
            $('#timer-block').hide();
            window.clearInterval(timer);
            $("#controls-play").addClass("disabled");
            $("#controls-forward").addClass("disabled");
        } else if($("#fight-log li").index(element) == 0) {
            //fightShowLog(element);
            element.slideDown("normal");
            $('#timer-block').hide();
            window.clearInterval(timer);
            $("#controls-play").addClass("disabled");
            $("#controls-forward").addClass("disabled");
        } else {
            fightShowLog(element);
        }
    }
}

function fightGo()
{
    $(document).ready(function(){
        if(interactive) {
            $("#controls-play").addClass("disabled");
            fightShowLog();
            timer = window.setInterval("fightTimer()", 1000);
        } else {
            fightForward();
        }
    });
}

function fightBack()
{
    if ($("#controls-back").hasClass("disabled")) {
        return;
    }

    $('#timer-block').hide();
    window.clearInterval(timer);

    $("#fight-log li").hide();
    $($("#fight-log li")[$("#fight-log li").length - 1]).show();

    $("#controls-back").addClass("disabled");
    $("#controls-play").removeClass("disabled");
    $("#controls-forward").removeClass("disabled");

    lifes = $($('#fight-log > li[rel]')[$('#fight-log > li[rel]').length - 1]).attr("rel").split(":");
                                                                                                    
    fighter1_life = lifes[0].split("/");                                                            
    $("#fighter1-life").html(Math.max(fighter1_life[0], 0) + '/' + fighter1_life[1]);               
    $("#fighter1-life").parent().find("div.percent").animate( {width: Math.ceil(100 * Math.max(fighter1_life[0], 0) / fighter1_life[1]) + "%"}, 1500 );
                                                                                                    
    fighter2_life = lifes[1].split("/");                                                            
    $("#fighter2-life").html(Math.max(fighter2_life[0], 0) + '/' + fighter2_life[1]);               
    $("#fighter2-life").parent().find("div.percent").animate( {width: Math.ceil(100 * Math.max(fighter2_life[0], 0) / fighter2_life[1]) + "%"}, 1500 );
                                                                                                    
    if (lifes[2] != "") {                                                                           
        pet1_life = lifes[2].split("/");                                                            
        $("#pet0-life").html(Math.max(pet1_life[0], 0) + '/' + pet1_life[1]);                       
        $("#pet0-life").parent().parent().find("div.percent").animate( {width: Math.ceil(100 * Math.max(pet1_life[0], 0) / pet1_life[1]) + "%"}, 1500 );
    }                                                                                               
                                                                                                    
    if (lifes[3] != "") {                                                                           
        pet2_life = lifes[3].split("/");                                                            
        $("#pet1-life").html(Math.max(pet2_life[0], 0) + '/' + pet2_life[1]);                       
        $("#pet1-life").parent().parent().find("div.percent").animate( {width: Math.ceil(100 * Math.max(pet2_life[0], 0) / pet2_life[1]) + "%"}, 1500 );
    }                                                                                               
}                                                                                                   
                                                                                                    
function fightPlay()                                                                                
{                                                                                                   
    if ($("#controls-play").hasClass("disabled")) {                                                 
        return;                                                                                     
    }                                                                                               
                                                                                                    
    $("#controls-back").removeClass("disabled");                                                    
    $("#controls-play").addClass("disabled");                                                       
    $("#controls-forward").removeClass("disabled");                                                 
                                                                                                    
    timeleft = 2;                                                                                   
    fightShowLog();                                                                                 
    timer = window.setInterval("fightTimer()", 1000);                                               
}                                                                                                   
                                                                                                    
function fightForward()                                                                             
{                                                                                                   
    if ($("#controls-forward").hasClass("disabled")) {                                              
        return;                                                                                     
    }                                                                                               
                                                                                                    
    $("#controls-back").removeClass("disabled");                                                    
    $("#controls-play").addClass("disabled");                                                       
    $("#controls-forward").addClass("disabled");                                                    
                                                                                                    
    $("#fight-log li").show();                                                                      
    $('#timer-block').hide();                                                                       
    lifes = $('#fight-log > li[rel]').attr("rel").split(":");                                       
                                                                                                    
    fighter1_life = lifes[0].split("/");                                                            
    $("#fighter1-life").html(Math.max(fighter1_life[0], 0) + '/' + fighter1_life[1]);               
    $("#fighter1-life").parent().find("div.percent").animate( {width: Math.ceil(100 * Math.max(fighter1_life[0], 0) / fighter1_life[1]) + "%"}, 1500 );
                                                                                                    
    fighter2_life = lifes[1].split("/");                                                            
    $("#fighter2-life").html(Math.max(fighter2_life[0], 0) + '/' + fighter2_life[1]);               
    $("#fighter2-life").parent().find("div.percent").animate( {width: Math.ceil(100 * Math.max(fighter2_life[0], 0) / fighter2_life[1]) + "%"}, 1500 );
                                                                                                    
    if (lifes[2] != "") {                                                                           
        pet1_life = lifes[2].split("/");                                                            
        $("#pet0-life").html(Math.max(pet1_life[0], 0) + '/' + pet1_life[1]);                       
        $("#pet0-life").parent().parent().find("div.percent").animate( {width: Math.ceil(100 * Math.max(pet1_life[0], 0) / pet1_life[1]) + "%"}, 1500 );
    }                                                                                               
                                                                                                    
    if (lifes[3] != "") {                                                                           
        pet2_life = lifes[3].split("/");                                                            
        $("#pet1-life").html(Math.max(pet2_life[0], 0) + '/' + pet2_life[1]);                       
        $("#pet1-life").parent().parent().find("div.percent").animate( {width: Math.ceil(100 * Math.max(pet2_life[0], 0) / pet2_life[1]) + "%"}, 1500 );
    }                                                                                               
}                                                                                                   
                                                                                                    
//" + LANG_MAIN_70 + "                                                                              
                                                                                                    
function groupFightPlayerDie(id,hp)                                                                 
{                                                                                                   
    if(hp <= 0) {                                                                                   
        $("#fighter"+id+"-life").parents("li:first").addClass("dead")                               
    }                                                                                               
}                                                                                                   
                                                                                                    
function groupFightShowLog(element)                                                                 
{                                                                                                   
    return;                                                                                         
    if (!element) {                                                                                 
        element = $("#fight-log li:hidden:last");                                                   
    }                                                                                               
    element.slideDown("normal");                                                                    
    if (element.attr("rel")){                                                                       
        var players = element.attr("rel").split(":");                                               
        for (var i=0; i<players.length; i++) {                                                      
            var lifes = players[i].split("/");                                                      
            var hp = lifes[1];                                                                      
            var id = lifes[0];                                                                      
            $("#fighter"+id+"-life").html(hp + "/" + lifes[2]);                                     
            $("#fighter"+id+"-life").parent().find("span.percent").animate( {width: Math.ceil(100*hp/lifes[2]) + "%"}, 1000, false, groupFightPlayerDie(id, hp));
        }
    }
    element.next().find('div.text').slideToggle(); /*" + LANG_MAIN_41 + "*/
}

function groupFightTimer()
{
    $("#time-left").html(timeleft);
    timeleft--;
    if (timeleft == -1) {
        document.location.href = document.location.href.replace(/#/, "");
    }
}

function groupFigthBindCick()
{
    $("#fightGroupForm input[name=target]").bind("click", function()
    {
        if( $(this).parents("li:first").hasClass("dead") ) {
			return false;
		}
		if (this.id.indexOf("attack") >= 0) {
            $("#fightGroupForm label").removeClass("selected");
            var username = $(this).parents("li:first").find("span.user").text(); //" + LANG_MAIN_77 + "
            $("#fight-button-text").html(LANG_MAIN_78 + "" + username);                             
            $(this).parents("label:first").addClass("selected");                                    
            $("#actionfield").val('attack');                                                        
        } else if (this.id.indexOf("defence") >=0 ) {                                               
            $("#fightGroupForm label").removeClass("selected");                                     
            var username = $(this).parents("li:first").find("span.user").text(); //" + LANG_MAIN_77 + "
            $("#fight-button-text").html(LANG_MAIN_83 + "" + username);                             
            $(this).parents("label:first").addClass("selected");                                    
            $("#actionfield").val('defence');                                                       
        } else if (this.id.indexOf("use") >= 0 && $(this).parents("li:first").hasClass("filled")) { 
            $("#fightGroupForm label").removeClass("selected");                                     
            var itemname = $(this).attr("rel"); //" + LANG_MAIN_45 + "                              
            $("#fight-button-text").html(LANG_MAIN_69 + "" + itemname);                             
            $(this).parents("label:first").addClass("selected");                                    
            $("#actionfield").val('useitem');                                                       
        }                                                                                           
    });                                                                                             
	                                                                                                
	/* ie label bug fix */                                                                          
	$("#fightGroupForm li.filled").bind("click", function(){                                        
		if($.browser.msie) {                                                                        
			$(this).find('input')[0].click();                                                       
		}                                                                                           
	});                                                                                             
}                                                                                                   
                                                                                                    
function groupFightMakeStep()                                                                       
{                                                                                                   
	$("button[type=submit]").addClass('disabled');                                                  
	$("button[type=submit]").parents("div.center:first").find("div.hint").hide();                   
	$.post("/fight/", {action: $('#actionfield').val(), item: $("input:radio[name=item]:checked").val(), target: $("input:radio[name=target]:checked").val(), json: 1}, function(data) {
		$("button[type=submit]").hide()                                                             
		$("div.waiting").show();                                                                    
	});                                                                                             
}                                                                                                   
                                                                                                    
function groupFightRupor()                                                                          
{                                                                                                   
    $.post("/fight/", {action: "rupor", rupor: $("#rupor").val(), json: 1}, function(data) {        
		$("#rupor-div").html("<i>— " + $("#rupor").val() + "</i>");                                 
	});                                                                                             
}                                                                                                   
                                                                                                    
function groupFightForceJoin(fightId)                                                               
{                                                                                                   
    postUrl("/fight/", {action:"join fight", fight:fightId, force_join:1}, "post");                 
}                                                                                                   
                                                                                                    
function groupFightTryRedirect()                                                                    
{                                                                                                   
    $.get("/player/ajax/state/" + offset + "/", {}, function(data)                                  
    {                                                                                               
        if (data.state == "fight" && !isNaN(data.stateparam)) {                                     
            document.location.href = "/fight/" + data.stateparam + "/";                             
        }                                                                                           
    }, "json");                                                                                     
    setTimeout("groupFightTryRedirect()", 10000);                                                   
}                                                                                                   
                                                                                                    
function groupFightRuporNoenter(event)                                                              
{                                                                                                   
	if($.browser.msie){                                                                             
		if(window.event && window.event.keyCode == 13) {                                            
			groupFightRupor();                                                                      
			return false;                                                                           
		}                                                                                           
	} else if( event && event.which== 13 ) {                                                        
		groupFightRupor();                                                                          
		return false;                                                                               
	}                                                                                               
}                                                                                                   
                                                                                                    
//" + LANG_MAIN_80 + "                                                                              
                                                                                                    
/*" + LANG_MAIN_19 + "*/                                                                            
function photoModerate(photo, action) {                                                             
	if (action == '---') {                                                                          
		return;                                                                                     
	}                                                                                               
	var reason = "";                                                                                
	if (action != 'accept') {                                                                       
		reason = action;                                                                            
		action = "cancel";                                                                          
		if (reason == LANG_MAIN_115) {                                                              
			reason = prompt(LANG_MAIN_62);                                                          
			if (reason == null || reason == "") {                                                   
				alert(LANG_MAIN_47);                                                                
				return;                                                                             
			}                                                                                       
		}                                                                                           
	}                                                                                               
	$.post("/photos/", {action: action, photo: photo, reason: reason}, function() {                 
		$("#photo" + photo).remove();                                                               
		if (!$("ul.photos-moderate-list li").length) {                                              
			window.location.reload();                                                               
		}                                                                                           
	});                                                                                             
}                                                                                                   
                                                                                                    
function photoAction(photo) {                                                                       
	var action = $('#photoAction option:selected').val();                                           
	if (action == '---') {                                                                          
		return;                                                                                     
	}                                                                                               
	var reason = "";                                                                                
	if (action == 'cancel') {                                                                       
		reason = $('#photoAction option:selected').text();                                          
		if (reason == LANG_MAIN_115) {                                                              
			reason = prompt(LANG_MAIN_62);                                                          
			if (reason == null || reason == "") {                                                   
				alert(LANG_MAIN_47);                                                                
				return;                                                                             
			}                                                                                       
		}                                                                                           
	}                                                                                               
	postUrl("/photos/", {action: action, photo: photo, reason: reason}, "post");                    
}                                                                                                   
                                                                                                    
function photoRate(photo, value, type) {                                                            
	postUrl("/photos/", {action: "rate", photo: photo, value: value, type: type}, "post");          
}                                                                                                   
                                                                                                    
function photoDelete(photo)                                                                         
{                                                                                                   
	if (confirm(LANG_MAIN_29) == true) {                                                            
		postUrl("/photos/", {action: "delete", photo: photo}, "post");                              
	}                                                                                               
}                                                                                                   
                                                                                                    
function photoAccept(photo)                                                                         
{                                                                                                   
	postUrl("/photos/", {action: "accept", photo: photo}, "post");                                  
}                                                                                                   
                                                                                                    
function photoCancel(photo)                                                                         
{                                                                                                   
	postUrl("/photos/", {action: "cancel", photo: photo}, "post");                                  
}                                                                                                   
                                                                                                    
function photoSetInProfile(photo)                                                                   
{                                                                                                   
	postUrl("/photos/", {action: "set in profile", photo: photo}, "post");                          
}                                                                                                   
                                                                                                    
function photoShow(key) {                                                                           
	var toShow = null;                                                                              
	if (key == 'next') {                                                                            
		key = photoCurrent+1;                                                                       
		                                                                                            
	} else if (key == 'prev') {                                                                     
		key = photoCurrent-1;                                                                       
	}                                                                                               
	if (photos[key]) {                                                                              
		toShow = photos[key];                                                                       
		photoCurrent = key;                                                                         
	}                                                                                               
	if (toShow != null) {                                                                           
		$('#imgRating').html(toShow['rating']);                                                     
		$('#imgVotes').html(toShow['amount']);                                                      
		$('#img').attr('src', toShow['src']);                                                       
		$('#img').attr('rel', toShow['id']);                                                        
		$('#ten-id').val(toShow['id']);                                                             
		$('#pers-photos-thumbs a').removeClass('current');                                          
		$('#pers-photos-thumbs a img[rel='+ toShow['id'] +']').parents('a:first').addClass('current');
		if (photos[key-1]) {                                                                        
			$('div.photo-vote a.previous').show();                                                  
		} else {                                                                                    
			$('div.photo-vote a.previous').hide();                                                  
		}
		if (photos[key+1]) {
			$('div.photo-vote a.next').show();                                                      
		} else {                                                                                    
			$('div.photo-vote a.next').hide();                                                      
		}                                                                                           
		if (toShow['for_contest'] > 0) {                                                            
			$('#photoInContest').show();
			$('#photoInContest a').attr('href', '/photos/contest/' + toShow['for_contest'] + '/');
		} else {
			$('#photoInContest').hide();
		}
		if (toShow['status'] == 'new') {                                                            
			$('#newPhoto').show();                                                                  
		} else {                                                                                    
			$('#newPhoto').hide();                                                                  
		}                                                                                           
		if (toShow['status'] == 'canceled') {                                                       
			$('#photoCanceled').show();                                                             
		} else {                                                                                    
			$('#photoCanceled').hide();                                                             
		}                                                                                           
		if (toShow['in_profile'] == 1) {                                                            
			$('#photoInProfile').show();                                                            
		} else {                                                                                    
			$('#photoInProfile').hide();                                                            
		}                                                                                           
		document.location.hash = toShow['id'];                                                      
		$('h3[rel=playerlink]').html(renderPlayerlink(toShow));                                     
		$('#linkToThisPage').val($('#linkToThisPage').val().replace(/\#[0-9]+/, '#' + toShow['id']));
	}                                                                                               
}                                                                                                   
                                                                                                    
function renderPlayerlink(player) {                                                                 
	var ret = '<span class="user">';                                                                
	var id;                                                                                         
	if (player['player_id']) {                                                                      
		id = player['player_id'];                                                                   
	} else {                                                                                        
		id = player['id'];                                                                          
	}                                                                                               
	if (player['fraction'] == 'resident') {                                                         
		ret += '<i class="resident" title="Коренной"></i>';                                         
	} else {                                                                                        
		ret += '<i class="arrived" title="Понаехавший"></i>';                                       
	}                                                                                               
	if (player['clan'] > 0) {                                                                       
		ret += '<a href="/clan/' + player['clan'] + '/"><img src="/@images/clan/clan_' + player['clan'] + '_ico.png" class="clan-icon" title="' + player['clan_name'] + '"></a>';
	}                                                                                               
	ret += '<a href="/player/' + id + '/">' + player['nickname'] + '</a><span class="level">[' + player['level'] + ']</span>';
	return ret;                                                                                     
}                                                                                                   
function photoGetNumberById(id) {                                                                   
	for (var i = 0; i < photos.length; i ++) {                                                      
		if (photos[i]['id'] == id) {                                                                
			return i;                                                                               
		}                                                                                           
	}                                                                                               
	return false;                                                                                   
}                                                                                                   
                                                                                                    
//" + LANG_MAIN_90 + "                                                                              
                                                                                                    
function playerSellPet(id)                                                                          
{                                                                                                   
	var result = confirm(LANG_MAIN_31);                                                             
	if (result == true) {                                                                           
		postUrl("/shop/section/zoo/sell/" + id + "/", {}, "get");                                   
	}                                                                                               
}                                                                                                   
                                                                                                    
function changePetName(oldName) {
	var newName = prompt(LANG_MAIN_38, oldName);
	if (newName != null) {
		/*$.post('/player/changepetname/', {name: newName}, function(data){
			document.location.href = '/player/';
		});*/
		postUrl('/player/changepetname/', {action: "changePetName", name: newName}, "post");
	}
}
                                                                                                    
function adminFormActionOnChange(select)                                                            
{                                                                                                   
    //$('#admin-form-period')[0].disabled = (select.selectedIndex < 3 || select.selectedIndex == 11) ? true : false;
	$('#admin-form tr[rel]').hide();                                                                
	var v = select.options[select.selectedIndex].value;                                             
	if (v != '') {                                                                                  
		$('#admin-form tr[rel=\'' + v + '\']').show();                                              
	}                                                                                               
	                                                                                                
}                                                                                                   
                                                                                                    
function loadPlayerComments(playerId, offset)                                                       
{                                                                                                   
    $.get("/player/" + playerId + "/admin-history/" + offset + "/", {}, function(data)              
    {                                                                                               
        if (data.length > 0) {                                                                      
            html = "<table class='datatable'><tr><td class='d'><b>" + LANG_MAIN_125 + "</b></td><td class='m'><b>" + LANG_MAIN_87 + "</b></td><td class='a'><b>" + LANG_MAIN_93 + "</b></td><td><b>" + LANG_MAIN_113 + "</b></td><td><b>" + LANG_MAIN_79 + "</b></td></tr>";
            for (i = 0; i < (data.length - 1); i++) {                                               
                html += "<tr " + (i % 2 ? "class='odd'" : "") + "><td>" + data[i].d + "</td><td><a href='/player/" + data[i].id + "/'>" + data[i].nm + "</a></td><td>" + data[i].a + "</td><td>" + data[i].p + "</td><td>" + data[i].c + "</td></tr>";
            }                                                                                       
            html += "</table>";                                                                     
            html += showAdminReportPager(data[data.length - 1].id, offset, playerId, "loadPlayerComments");
                                                                                                    
            $("#pers-admin2-block").html(html);                                                     
        }                                                                                           
    }, "json");                                                                                     
}                                                                                                   
                                                                                                    
function loadPlayerDuels(playerId, offset)                                                          
{                                                                                                   
    $.get("/player/" + playerId + "/admin-duels/" + offset + "/", {}, function(data)                
    {                                                                                               
        if (data.length > 0) {                                                                      
            html = "<table class='datatable'><tr><td class='d'><b>" + LANG_MAIN_125 + "</b></td><td><b>" + LANG_MAIN_127 + "</b></td><td><b>" + LANG_MAIN_88 + "</b></td><td><b>" + LANG_MAIN_99 + "</b></td></tr>";
            for (i = 0; i < (data.length - 1); i++) {                                               
                html += "<tr " + (i % 2 ? "class='odd'" : "") + "><td>" + data[i].dt + "</td>" +    
                    "<td><a href='/alley/fight/" + data[i].d + "/" + data[i].sk + "/'>" + (data[i].type == "fight_defended" ? LANG_MAIN_112 : LANG_MAIN_91)  + " &rarr; " +
                    (data[i].r == "win" ? LANG_MAIN_103 : (data[i].r = "loose" ? LANG_MAIN_89 : LANG_MAIN_123)) + "</td>" +
                    "<td><a href='/player/" + data[i].pid + "/'>" + data[i].pnm + " [" + data[i].plv + "]</a></td>" +
                    "<td>" + LANG_MAIN_117 + "" + data[i].x + "<br />" + LANG_MAIN_95 + "" + data[i].m + "<br />" + LANG_MAIN_118 + "" + data[i].z + "</td></tr>";
            }                                                                                       
            html += "</table>";                                                                     
            html += showAdminReportPager(data[data.length - 1].id, offset, playerId, "loadPlayerDuels");
                                                                                                    
            $("#pers-admin2-block").html(html);                                                     
        }                                                                                           
    }, "json");                                                                                     
}                                                                                                   
                                                                                                    
function loadPlayerMessages(playerId, offset)                                                       
{                                                                                                   
    $.get("/player/" + playerId + "/admin-messages/" + offset + "/", {}, function(data)             
    {                                                                                               
        if (data.length > 0) {                                                                      
            var html = "<table class='datatable'><tr><td class='d'><b>" + LANG_MAIN_125 + "</b></td><td><b>" + LANG_MAIN_100 + "</b></td><td><b>" + LANG_MAIN_126 + "</b></td>" +
                "<td><b>" + LANG_MAIN_127 + "</b></td><td><b>" + LANG_MAIN_92 + "</b></td></tr>";   
            for (i = 0; i < (data.length - 1); i++) {                                               
                html += "<tr " + (i % 2 ? "class='odd'" : "") + "><td>" + data[i].dt + "</td>" +    
                    "<td>" + (data[i].p1 == 0 ? LANG_MAIN_128 : "<a href='/player/" + data[i].p1 + "'>" + data[i].pnm1  + " [" + data[i].plv1 + "]</a></td>") +
                    "<td>" + (data[i].p2 == 0 ? LANG_MAIN_128 : "<a href='/player/" + data[i].p2 + "'>" + data[i].pnm2  + " [" + data[i].plv2 + "]</a></td>") +
                    "<td>" + (data[i].type == "message" ? LANG_MAIN_109 : (data[i].type = "clan_message" ? LANG_MAIN_98 : (data[i].type = "system_notice" ? LANG_MAIN_75 : ""))) + "</td>" +
                    "<td>" + data[i].text + "</td></tr>";                                           
            }                                                                                       
            html += "</table>";                                                                     
            html += showAdminReportPager(data[data.length - 1].id, offset, playerId, "loadPlayerMessages");
                                                                                                    
            $("#pers-admin2-block").html(html);                                                     
        }                                                                                           
    }, "json");                                                                                     
}                                                                                                   
                                                                                                    
function showAdminReportPager(total, offset, playerId, func)                                        
{                                                                                                   
    var html = "<p>" + LANG_MAIN_84;                                                                
    if (total > 20) {                                                                               
        pages = Math.floor(total / 20);                                                             
        if (pages != total / 20) {                                                                  
            pages++;                                                                                
        }                                                                                           
        for (i = 0; i < pages; i++) {                                                               
            offset2 = i * 20;                                                                       
            if (offset2 == offset) {                                                                
                html += " <b>" + (i + 1) + "</b>&nbsp;";                                            
            }else {
                html += " <a href='javascript:void(0);' onclick='" + func + "(" + playerId + ", " + offset2 + ");'>" + (i + 1) + "</a>&nbsp;";
            }                                                                                       
        }                                                                                           
                                                                                                    
    } else {                                                                                        
        html += "<b>1</b>";                                                                         
    }                                                                                               
    html += "</p>";                                                                                 
    return html;                                                                                    
}                                                                                                   
                                                                                                    
//" + LANG_MAIN_73 + "                                                                              
                                                                                                    
var stats = ["health","strength","dexterity","resistance","intuition","attention","charism"];       
var stat_upgrade_time = 10; /*" + LANG_MAIN_49 + "*/                                                
                                                                                                    
function trainerCost(statmy, stataverage, stat)                                                     
{                                                                                                   
    var k = [2.5, 2.9, 2.6, 2.8, 2.4, 2.2, 2.7];                                                    
    var minK = 2.6;                                                                                 
                                                                                                    
    var statK = k[stat] / minK;                                                                     
                                                                                                    
                                                                                                    
    var ratio = Number(statmy) / Number(stataverage);                                               
    var cost = (Math.pow(2, ratio) - 1) * (Math.pow(3, ratio) - 1) * 3.3 * statK;                   
    cost *= 10; //" + LANG_MAIN_74 + "                                                              
	if (cost<10) cost=10;                                                                           
    return cost;                                                                                    
}                                                                                                   
                                                                                                    
function trainerCostAdd(currentstat, needstat, averagestat, stat)                                   
{                                                                                                   
    var sum = 0;                                                                                    
    for (var i = currentstat + 1; i <= needstat; i++) {                                             
        sum += trainerCost(i, averagestat, stat);                                                   
    }                                                                                               
    return sum;                                                                                     
}                                                                                                   
                                                                                                    
                                                                                                    
function trainerCalculatorCalculate()                                                               
{                                                                                                   
    var stats_amount_sum = 0;                                                                       
    var stats_cost_sum = 0;                                                                         
                                                                                                    
    var tr;                                                                                         
    var curstat;                                                                                    
    var needstat;                                                                                   
    var mystat;                                                                                     
    var stat_cost;                                                                                  
    var averagestat;                                                                                
	//var anabolics =  Number($("#trainer-anabolics-total").text());                                
	var submitbutton = $("#calculator button.button");                                              
                                                                                                    
    for (var i = 0, j = stats.length; i < j; i++) {                                                 
        tr = $("#calculator").find("tr[rel=" + stats[i] + "]");                                     
        curstat = Number(tr.find("td.my span.number").html()) || 0;                                 
        needstat = Number(tr.find("input[type=text]").val()) || 0;                                  
        if (needstat < 0) {                                                                         
            needstat = 0;                                                                           
        }                                                                                           
        mystat = curstat + needstat;                                                                
                                                                                                    
        /*" + LANG_MAIN_52 + "*/                                                                    
        stats_amount_sum += needstat;                                                               
                                                                                                    
        /*" + LANG_MAIN_48 + "*/                                                                    
        averagestat = Number(tr.find("td.average span.number").text());                             
                                                                                                    
        /*" + LANG_MAIN_57 + "*/                                                                    
        stat_cost = trainerCostAdd(curstat, mystat, averagestat, i);                                
                                                                                                    
        stats_cost_sum += Math.floor(stat_cost * 10) / 10;                                          
                                                                                                    
        $("#calculator").find("tr[rel=" + stats[i] + "]").find("td.cost span.number").html(Math.floor(stat_cost * 10) / 10);
                                                                                                    
        var stars = tr.find("td.advantage span.percent");                                           
        if (averagestat > 0) {                                                                      
            var stats_ratio = mystat / averagestat;                                                 
            if (stats_ratio <= 1.2) {                                                               
                stars.css("width", "0%");                                                           
            } else if (stats_ratio <= 1.4) {                                                        
                stars.css("width", "20%");                                                          
            } else if (stats_ratio <= 1.6) {                                                        
                stars.css("width", "40%");                                                          
            } else if (stats_ratio <= 1.8) {                                                        
                stars.css("width", "60%");                                                          
            } else if (stats_ratio <= 2) {                                                          
                stars.css("width", "80%");                                                          
            } else if (stats_ratio > 2) {                                                           
                stars.css("width", "100%");                                                         
            }                                                                                       
        }                                                                                           
		/*" + LANG_MAIN_61 + "+" + LANG_MAIN_119 + "*/                                              
		if (needstat == 0) {                                                                        
			tr.find("i.minus-icon").addClass("minus-icon-disabled");                                
		} else {                                                                                    
			tr.find("i.minus-icon").removeClass("minus-icon-disabled");                             
		}                                                                                           
		if (needstat == 99) {                                                                       
			tr.find("i.plus-icon").addClass("plus-icon-disabled");                                  
		} else {                                                                                    
			tr.find("i.plus-icon").removeClass("plus-icon-disabled");                               
		}                                                                                           
    }                                                                                               
    $("#calculator").find("tr[rel=total] td.my").find("span.number").html(stats_amount_sum);        
    $("#calculator").find("tr[rel=total] td.my").find("span.time").html(stats_amount_sum * stat_upgrade_time);
                                                                                                    
    $("#stats_upgrade_cost").html(formatNumber(Math.ceil(stats_cost_sum), 0, "", ","));             
                                                                                                    
    if ($("#trainer-anabolics-deficit-checkbox")[0] != null) {                                      
        //if ((myAnabolics2 + myAnabolics) < Math.ceil(stats_cost_sum) && $("#trainer-anabolics-deficit-checkbox")[0].checked) {
        if ((myAnabolics2 + myAnabolics) < Math.ceil(stats_cost_sum)) {                             
            $("#trainer-anabolics-deficit").hide();                                                 
            $("#trainer-anabolics-deficit2").show();                                                
                                                                                                    
            submitbutton.addClass("disabled");                                                      
            submitbutton.attr("disabled", true);                                                    
        } else if ((myAnabolics2 + myAnabolics) >= Math.ceil(stats_cost_sum) && $("#trainer-anabolics-deficit-checkbox")[0].checked) {
            $("#trainer-anabolics-deficit2").hide();                                                
            $("#trainer-anabolics-deficit").show();                                                 
                                                                                                    
            if ($("#trainer-anabolics-deficit-checkbox").is(":checked")) {                          
                submitbutton.removeClass("disabled");                                               
                submitbutton.attr("disabled", false);                                               
            } else {                                                                                
                submitbutton.addClass("disabled");                                                  
                submitbutton.attr("disabled", true);                                                
            }                                                                                       
        } else if (myAnabolics < Math.ceil(stats_cost_sum)) {                                       
            $("#trainer-anabolics-deficit2").hide();                                                
            $("#trainer-anabolics-deficit").show();                                                 
                                                                                                    
            submitbutton.addClass("disabled");                                                      
            submitbutton.attr("disabled", true);                                                    
        } else {                                                                                    
            $("#trainer-anabolics-deficit").hide();                                                 
            $("#trainer-anabolics-deficit2").hide();                                                
                                                                                                    
            submitbutton.removeClass("disabled");                                                   
            submitbutton.attr("disabled", false);                                                   
        }                                                                                           
    }                                                                                               
}                                                                                                   
                                                                                                    
function trainerCalculatorInit()                                                                    
{                                                                                                   
    for (var i = 0, j = stats.length; i < j; i++) {                                                 
        $("#calculator").find("tr[rel=" + stats[i] + "]").find("td.my span.number").html(stats_my[i]);
        $("#calculator").find("tr[rel=" + stats[i] + "]").find("td.average span.number").html(stats_average[i]);
        $("#calculator").find("tr[rel=" + stats[i] + "]").find("input[type=text]").bind("keyup", function()
        {                                                                                           
            trainerCalculatorCalculate();                                                           
        });                                                                                         
		$("#calculator").find("tr[rel="+stats[i]+"]").find("i.plus-icon").bind("click",function(){  
			var input = $(this).parents("b:first").find("input[type=text]");                        
			var newvalue = Number(input.val())+1;                                                   
			if(newvalue>=0 && newvalue<=99){                                                        
				input.val(newvalue);                                                                
				trainerCalculatorCalculate();                                                       
			}                                                                                       
		});                                                                                         
		$("#calculator").find("tr[rel="+stats[i]+"]").find("i.minus-icon").bind("click",function(){ 
			var input = $(this).parents("b:first").find("input[type=text]");                        
			var newvalue = Number(input.val())-1;                                                   
			if(newvalue>=0 && newvalue<=99){                                                        
				input.val(newvalue);                                                                
				trainerCalculatorCalculate();                                                       
			}                                                                                       
		});                                                                                         
		$("#trainer-anabolics-deficit-checkbox").bind("click", function()                           
        {                                                                                           
			trainerCalculatorCalculate();                                                           
		})                                                                                          
        trainerCalculatorCalculate();                                                               
    }                                                                                               
}                                                                                                   
                                                                                                    
function trainerAnabolicsPrepareCount()                                                             
{                                                                                                   
	var i = Number($("#trainer-personal-anabolics-number").val());                                  
    $("#count-span").html(i * 10);                                                                  
	$("#trainer-personal-anabolics-petric").html(i);                                                
	$("#trainer-personal-anabolics-med").html(i);                                                   
}                                                                                                   
                                                                                                    
function trainerAnabolicsPrepareInit()                                                              
{                                                                                                   
	$("#trainer-personal-anabolics-number").bind("keyup", function()                                
    {                                                                                               
		trainerAnabolicsPrepareCount();                                                             
	});                                                                                             
}                                                                                                   
                                                                                                    
function socialProfileFormInit()                                                                    
{                                                                                                   
    $("#city-tr").hide();                                                                           
    $("#metro-tr").hide();                                                                          
    if ($("#country-select").val() != "") {                                                         
        $("#city-tr").show();                                                                       
    }                                                                                               
    if ($("#city-select").val() != "") {                                                            
        $("#metro-tr").show();                                                                      
    }                                                                                               
}                                                                                                   
                                                                                                    
function socialProfileFormShowHide()                                                                
{                                                                                                   
    if ($("#city-select").val() == "" || $("#metro-select")[0].options.length == 1) {               
        $("#metro-tr").hide();                                                                      
    }                                                                                               
    if ($("#country-select").val() == "" || $("#city-select")[0].options.length == 1) {             
        $("#city-tr").hide();                                                                       
    }                                                                                               
}                                                                                                   
                                                                                                    
function socialProfileLoadCities()                                                                  
{                                                                                                   
    $("#metro-tr").hide();                                                                          
    $("#city-tr").hide();                                                                           
    if ($("#country-select").val() != "") {                                                         
        $.ajax({url:"/settings/load-items/city/" + $("#country-select").val() + "/", async:false, success:function(data){
            if (data.length > 0) {                                                                  
                $("#city-select").html("");                                                         
                $("#city-select").append('<option value="">' + LANG_MAIN_68 + '</option>');         
                for (i = 0; i < data.length; i++) {                                                 
                    $("#city-select").append('<option value="' + data[i].id + '">' + data[i].nm + '</option>');
                }                                                                                   
                $("#city-tr").show();                                                               
            }                                                                                       
        }, dataType:"json"});                                                                       
    }                                                                                               
}                                                                                                   
                                                                                                    
function socialProfileLoadMetros()                                                                  
{                                                                                                   
    $("#metro-tr").hide();                                                                          
    if ($("#city-select").val() != "") {                                                            
        $.ajax({url:"/settings/load-items/metro/" + $("#city-select").val() + "/", async:false, success:function(data){
            if (data.length > 0) {                                                                  
                $("#metro-select").html("");                                                        
                $("#metro-select").append('<option value="">' + LANG_MAIN_68 + '</option>');        
                for (i = 0; i < data.length; i++) {                                                 
                    $("#metro-select").append('<option value="' + data[i].id + '">' + data[i].nm + '</option>');
                }                                                                                   
                $("#metro-tr").show();                                                              
            }                                                                                       
        }, dataType:"json"});                                                                       
    }                                                                                               
}                                                                                                   
                                                                                                    
//" + LANG_MAIN_85 + "                                                                              
                                                                                                    
function alleyNaperstkiPlay(cells)                                                                  
{                                                                                                   
    $.get("/alley/naperstki/play/" + cells + "/", {}, function(data)                                
    {                                                                                               
        if (data != "") {                                                                           
            $("#naperstki-step1").hide();                                                           
            $("#naperstki-step3").hide();                                                           
            $("#naperstki-step2-cells" + (data.c == 3 ? 9 : 3)).hide();                             
            $("#naperstki-step2-cells" + data.c).show();                                            
            desk = "";                                                                              
            for (var i = 0; i < data.c; i++) {                                                      
                if (i == 3 || i == 6) {                                                             
                    desk += "<br />";                                                               
                }                                                                                   
                switch (data.d[i]) {                                                                
                    case "0":
                        desk += '<i id="thimble' + i + '" class="icon thimble-closed-active" onclick="alleyNaperstkiGuess(' + i + ');"></i>';
                        break;                                                                      
                    case "1":
                        desk += '<i id="thimble' + i + '" class="icon thimble-closed"></i>';        
                        break;                                                                      
                    case "2":
                        desk += '<i id="thimble' + i + '" class="icon thimble-guessed"></i>';       
                        break;                                                                      
                    case "3":
                        desk += '<i id="thimble' + i + '" class="icon thimble-empty"></i>';         
                        break;                                                                      
                }                                                                                   
            }                                                                                       
            $("#naperstki-step2 .thimbles").html(desk);                                             
            $("#naperstki-ruda").html(data.r + "<i></i>");                                          
            $("#naperstki-left").html(data.c == 3 ? 1 - data.g : 3 - data.g);                       
            $("#naperstki-step2").show();                                                           
                                                                                                    
            updatePlayerBlockMoney(cells == 3 ? 500 : (cells == 9 ? 1500 : 0), "-");                
        } else {                                                                                    
            alert(LANG_MAIN_0);                                                                     
            alleyNaperstkiLeave();                                                                  
        }                                                                                           
    }, "json");                                                                                     
}                                                                                                   
                                                                                                    
function alleyNaperstkiGuess(cell)                                                                  
{                                                                                                   
    $.get("/alley/naperstki/guess/" + cell + "/", {}, function(data)                                
    {                                                                                               
        if (data != "") {                                                                           
            if (data.left == 0) {                                                                   
                $("#naperstki-step2 .thimbles i").removeClass("thimble-closed-active").addClass("thimble-closed");
                $("#naperstki-step3").show();                                                       
            }                                                                                       
            $("#naperstki-left").html(data.left);                                                   
            $("#naperstki-ruda").html(data.ruda + "<i></i>");                                       
            $("#thimble" + cell).removeClass("thimble-closed");                                     
            if (data.result == "1") {                                                               
                $("#thimble" + cell).addClass("thimble-guessed");                                   
            } else {                                                                                
                $("#thimble" + cell).addClass("thimble-empty");                                     
            }                                                                                       
        }                                                                                           
    }, "json");                                                                                     
}                                                                                                   
                                                                                                    
function alleyNaperstkiLeave()                                                                      
{                                                                                                   
    $.get("/alley/naperstki/leave/", {}, function(data){}, "json");                                 
    $("#naperstki").hide();                                                                         
}                                                                                                   
                                                                                                    
//" + LANG_MAIN_66 + "                                                                              
                                                                                                    
var huntclubAward = 0;                                                                              
var huntclubPrice = 0;                                                                              
var huntclubCheckPlayer = false;                                                                    
                                                                                                    
function huntclubShowForm()                                                                         
{                                                                                                   
    var player = $("#nickname2").val();                                                             
                                                                                                    
    if (player == "") {                                                                             
        $("#nickname-error").show();                                                                
        $("#nickname-error").html(LANG_MAIN_53);                                                    
    } else {                                                                                        
        $("#nickname").val(player);                                                                 
        huntclubCheckNicknameAndMoney(player);                                                      
        $("#hunting-order-form-cost-tugriki").html(formatNumber(huntclubPrice, 0, "", ","));        
    }                                                                                               
    $("#hunting-order-form").show();                                                                
    return false;                                                                                   
}                                                                                                   
                                                                                                    
function huntclubZakazCost(level, playerZakaz, myZakaz)
{                                                                                                   
    return 40 * (level - 2) * (playerZakaz > myZakaz ? playerZakaz : myZakaz);                      
}                                                                                                   
                                                                                                    
function huntclubCheckForm()                                                                        
{                                                                                                   
    var player = $("#nickname").val();                                                              
    huntclubAward = $("#award").val();                                                              
    huntclubAward = isNaN(huntclubAward) ? 0 : Math.abs(huntclubAward);                             
    $("#award").val(huntclubAward);                                                                 
    huntclubCheckNicknameAndMoney(player);                                                          
                                                                                                    
    var ok2 = true;                                                                                 
    if ($("#hunting-order-form-grand")[0].checked && ((myOre + myHoney) < 5 || ($("#hunting-order-form-private") && $("#hunting-order-form-private")[0].checked && (myOre + myHoney) < 10))) {
        $("#vip-error").html(LANG_MAIN_56 + "/" + LANG_MAIN_124);                                   
        $("#vip-error").show();                                                                     
        ok2 = false;                                                                                
    } else {                                                                                        
        $("#vip-error").hide();                                                                     
    }                                                                                               
    var ok = true;                                                                                  
    if ($("#hunting-order-form-private") && $("#hunting-order-form-private")[0].checked && (myHoney < 5 || ($("#hunting-order-form-grand")[0].checked && ((myOre + myHoney) < 10 || myHoney < 5)))) {
        $("#private-error").html(LANG_MAIN_59);                                                     
        $("#private-error").show();                                                                 
        ok = false;                                                                                 
    } else {                                                                                        
        $("#private-error").hide();                                                                 
    }                                                                                               
    var ok3 = true;                                                                                 
    if (huntclubAward > myLevel * 1000) {                                                           
        $("#award-error").html(LANG_MAIN_34 + "— <span class='tugriki'>" + (myLevel * 1000) + "<i></i></span>");
        $("#award-error").show();                                                                   
        ok3 = false;                                                                                
    } else {                                                                                        
        $("#award-error").hide();                                                                   
    }                                                                                               
    if (huntclubCheckPlayer && ok && ok2 && ok3) {                                                  
        $("#hunt-form").submit();                                                                   
    }                                                                                               
}                                                                                                   
                                                                                                    
function huntclubCheckForm2()                                                                       
{                                                                                                   
    var player = $("#nickname").val();                                                              
    huntclubAward = $("#award").val();                                                              
    huntclubAward = isNaN(huntclubAward) ? 0 : Math.abs(huntclubAward);                             
    $("#award").val(huntclubAward);                                                                 
    huntclubCheckNicknameAndMoney(player);                                                          
}                                                                                                   
                                                                                                    
function huntclubCheckNicknameAndMoney(player)                                                      
{                                                                                                   
    $.ajax({url:"/huntclub/checkplayer/" + encodeURIComponent(player) + "/", async:false, dataType:"json", contentType:"application/x-www-form-urlencoded; charset=UTF-8", success:function(data)
    {                                                                                               
        $("#nickname-ok").hide();                                                                   
        if (data.id <= 0) {                                                                         
            $("#nickname-error").show();                                                            
            huntclubCheckPlayer = false;                                                            
        }                                                                                           
        if (data.id == 0) {                                                                         
            $("#nickname-error").html(LANG_MAIN_65);                                                
        } else if (data.id == -1) {                                                                 
            $("#nickname-error").html(LANG_MAIN_7);                                                 
        } else if (data.id == -2) {                                                                 
            $("#nickname-error").html(LANG_MAIN_20);                                                
        } else if (data.id == -3) {                                                                 
            $("#nickname-error").html(LANG_MAIN_36);                                                
        } else if (data.id == -4) {                                                                 
            $("#nickname-error").html(LANG_MAIN_21);                                                
        } else if (data.id == -5) {                                                                 
            $("#nickname-error").html(LANG_MAIN_22);                                                
        } else if (data.id == -6) {                                                                 
            $("#nickname-error").html(LANG_MAIN_12);                                                
        } else if (data.level < 3) {                                                                
            $("#nickname-error").show();                                                            
            $("#nickname-error").html(LANG_MAIN_15);                                                
            huntclubCheckPlayer = false;                                                            
        } else if (data.playerzakaz >= 3) {                                                         
            $("#nickname-error").show();                                                            
            $("#nickname-error").html(LANG_MAIN_16);                                                
            huntclubCheckPlayer = false;                                                            
        } else {                                                                                    
            $("#nickname-error").hide();                                                            
            $("#nickname-ok").show();                                                               
            huntclubPrice = huntclubZakazCost(data.level, data.playerzakaz, data.myzakaz);
            $("#hunting-order-form-cost-tugriki").html(formatNumber((huntclubPrice + huntclubAward), 0, "", ","));
            if ((huntclubPrice + huntclubAward) > myMoney) {                                        
                $("#money-error").html(LANG_MAIN_55);                                               
                $("#money-error").show();                                                           
                //$("#form-submit").addClass("disabled");                                           
                //$("#form-submit").attr("disabled", true);                                         
                huntclubCheckPlayer = false;                                                        
            } else {                                                                                
                $("#money-error").hide();                                                           
                //$("#form-submit").removeClass("disabled");                                        
                //$("#form-submit").attr("disabled", false);                                        
                huntclubCheckPlayer = true;                                                         
            }                                                                                       
        }                                                                                           
    }});                                                                                            
}                                                                                                   
                                                                                                    
function huntclubCancel()                                                                           
{                                                                                                   
    $('#hunting-order-form').hide();                                                                
    $('#nickname2').val('');                                                                        
    $('#nickname').val('');                                                                         
    $('#award').val('');                                                                            
    $('#hunting-order-form-cost-tugriki')[0].checked = false;                                       
    $('#comment').val('');                                                                          
    huntclubAward = 0;                                                                              
    huntclubPrice = 0;                                                                              
    huntclubCheckPlayer = false;                                                                    
    return false;                                                                                   
}                                                                                                   
                                                                                                    
function huntclubVipCheck()                                                                         
{                                                                                                   
    if($("#hunting-order-form-grand")[0].checked) {                                                 
        $("#hunting-order-form-cost-grand").show();                                                 
        $("#hunting-order-form-levels").html("[0&hellip;+2]").css("font-weight","bold");            
        if ($("#hunting-order-form-grand")[0].checked && ((myOre + myHoney) < 5 || ($("#hunting-order-form-private")[0].checked && (myOre + myHoney) < 10))) {
            $("#vip-error").html(LANG_MAIN_56 + "/" + LANG_MAIN_124);                               
            $("#vip-error").show();                                                                 
        } else {                                                                                    
            $("#vip-error").hide();                                                                 
        }                                                                                           
    } else {                                                                                        
        $("#hunting-order-form-cost-grand").hide();                                                 
        $("#vip-error").hide();                                                                     
        $("#hunting-order-form-levels").html("[-1&hellip;+1]").css("font-weight","normal");         
    }                                                                                               
}                                                                                                   
                                                                                                    
function huntclubPrivateCheck()                                                                     
{                                                                                                   
    if($("#hunting-order-form-private")[0].checked) {                                               
        $("#hunting-order-form-cost-private").show();                                               
        if ($("#hunting-order-form-private")[0].checked && (myHoney < 5 || ($("#hunting-order-form-grand")[0].checked && ((myOre + myHoney) < 10 || myHoney < 5)))) {
            $("#private-error").html(LANG_MAIN_59);                                                 
            $("#private-error").show();                                                             
        } else {                                                                                    
            $("#private-error").hide();                                                             
        }                                                                                           
    } else {                                                                                        
        $("#hunting-order-form-cost-private").hide();                                               
        $("#private-error").hide();                                                                 
    }                                                                                               
}                                                                                                   
                                                                                                    
function huntclubAwardKeyUp()                                                                       
{                                                                                                   
    if (!isNaN($("#award").val())) {                                                                
        $("#hunting-order-form-cost-tugriki").html(formatNumber(huntclubPrice + parseInt($("#award").val()), 0, "", ","));
    }                                                                                               
}                                                                                                   
                                                                                                    
function huntclubPayFee(huntId)                                                                     
{                                                                                                   
    if (window.confirm(LANG_MAIN_28)) {                                                             
        postUrl("/huntclub/me/pay-fee/", {hunt: huntId}, "post");                                   
    }                                                                                               
}                                                                                                   
                                                                                                    
function huntclubOpen(huntId)                                                                       
{                                                                                                   
    if (window.confirm(LANG_MAIN_40)) {                                                             
        postUrl("/huntclub/me/open/", {hunt: huntId}, "post");                                      
    }                                                                                               
}                                                                                                   
                                                                                                    
function huntclubClearComment(id)                                                                   
{                                                                                                   
    if (window.confirm(LANG_MAIN_94) == true) {                                                     
        $.ajax({url:"/huntclub/clear-comment/" + id + "/", async:false});                           
        $("#comment" + id).html("");                                                                
    }                                                                                               
}                                                                                                   
                                                                                                    
/*" + LANG_MAIN_102 + "*/                                                                           
                                                                                                    
$(".filter_topphotos").live("click", function() {                                                   
	$("#photostop-" + $(".filter_topphotos.current").attr("rel")).hide();                           
	$(".filter_topphotos").removeClass("current");                                                  
	$(this).addClass("current");                                                                    
	$("#photostop-" + $(".filter_topphotos.current").attr("rel")).show();                           
	//setCookie("filter_topphotos", $(this).attr("rel"))                                            
	//window.location.reload();                                                                     
});                                                                                                 
                                                                                                    
$(".filter_toppeople").live("click", function() {                                                   
	$("#peopletop-" + $(".filter_toppeople.current").attr("rel")).hide();                           
	$(".filter_toppeople").removeClass("current");                                                  
	$(this).addClass("current");                                                                    
	$("#peopletop-" + $(".filter_toppeople.current").attr("rel")).show();                           
	//setCookie("filter_toppeople", $(this).attr("rel"))                                            
	//window.location.reload();                                                                     
});                                                                                                 
                                                                                                    
function loadPhotosSearchFamilies(value) {                                                          
	$("#family-select").load("/photos/load-items/families/" + value + "/");                         
}                                                                                                   
                                                                                                    
function loadPhotosSearchCities(value) {                                                            
	$("#city-select").load("/photos/load-items/cities/" + value + "/");                             
	$("#metro-select").html("<option>" + LANG_MAIN_120 + "</option>");                              
}                                                                                                   
                                                                                                    
function loadPhotosSearchMetros(value) {                                                            
	$("#metro-select").load("/photos/load-items/metros/" + value + "/");                            
}                                                                                                   
/* /" + LANG_MAIN_110 + "*/                                                                         
                                                                                                    
                                                                                                    
/* Home */                                                                                          
function homeThimbleGuess(collectionId, position) {                                                 
	postUrl("/home/collection/" + collectionId + "/thimble/", {"action": "guess", "position": position}, "post");
}                                                                                                   
/* /Home */                                                                                         
                                                                                                    
//" + LANG_MAIN_107 + "                                                                             
                                                                                                    
function sovetAutoHideLozung(param)                                                                 
{                                                                                                   
    var html = $("#council-speach-text" + param).html();                                            
    if(html.length > 400) {                                                                         
        html = html.replace(/((\n|.){1,320}\s)((\n|.)*)/,"$1<span class=\"hidden\" style=\"display:none\">$3</span><span class=\"how dashedlink\" onclick=' $(this).parent().find(\"span.hidden\").show(\"fast\"); $(this).hide().parent().find(\"span.hide\").show();'>" + LANG_MAIN_97 + "</span><span class='hide dashedlink' onclick='$(this).parent().find(\"span.hidden\").hide(\"fast\"); $(this).hide().parent().find(\"span.show\").show();' style='display:none;'>" + LANG_MAIN_108 + "</span>")
    }
    $("#council-speach-text" + param).html(html);
}


/* Police */

function policeWerewolfBegin(level, withItem) {
	if (level == 0) {
		$("#police-werewolf-error").html(LANG_POLICE_WEREWOLF_ERROR)
		$("#police-werewolf-error").show();
		return false;
	} else {
		withItem = typeof(withItem) != 'undefined' ? withItem : 0;
		$("#police-werewolf-error").hide();
		postUrl("/police/", {"action": "werewolf_begin", "level": level, "with_item": withItem}, "post");
	}
}

function policeWerewolfExtension(return_url) {
	return_url = typeof(return_url) != 'undefined' ? return_url : '';
	postUrl("/police/", {"action": "werewolf_extension", "return_url": return_url}, "post");
}

function policeWerewolfCancel() {
	postUrl("/police/", {"action": "werewolf_cancel", "return_url": "/police/"}, "post");
}

function policeWerewolfRegeneration() {
	$('#loading-stats').show();
	$('#id="policeWerewolfRegenerationButton"').attr("disabled", "disabled").addClass("disabled");
	setTimeout(function(){$.post("/police/", {"action": "werewolf_regeneration", "ajax": 1}, function(data){
		var max1 = max2 = 0;
		for (i in data['stats']) {
			if (i.substr(0, 6) == "rating") {
				if (data['stats'][i] > max2) {
					max2 = data['stats'][i];
				}
			} else {
				if (data['stats'][i] > max1) {
					max1 = data['stats'][i];
				}
			}
		}
		$('#loading-stats').hide();
		$('#id="policeWerewolfRegenerationButton"').attr("disabled", "").removeClass("disabled");
		for (i in data['stats']) {
			$("li[rel='" + i + "'] span.num").html(data['stats'][i]);
			if (i.substr(0, 6) == "rating") {
				$("li[rel='" + i + "'] div.bar div.percent").animate({"width": Math.round(data['stats'][i] / max2 * 100) + "%"}, "slow");
			} else {
				$("li[rel='" + i + "'] div.bar div.percent").animate({"width": Math.round(data['stats'][i] / max1 * 100) + "%"}, "slow");
			}
		}
		$("p.borderdata span.icon").addClass('icon-star-empty').removeClass('icon-star-filled');
		$("p.borderdata span.icon:lt(" + data['stars'] + ")").removeClass('icon-star-empty').addClass('icon-star-filled');
		$("div.life span[rel='hp']").html(data['hp'] + "/" + data['hp']);
		
		if (data['wallet']) {
			updateWallet(data['wallet']);
		}
	}, "json");}, "2000");
}

function showAlleySearchTab(flag){
	if( "werewolf" == flag ){
		$("#alley-search-myself").hide();
		$("#alley-search-myself-tab").removeClass("current");
		$("#alley-search-werewolf").show();
		$("#alley-search-werewolf-tab").addClass("current");
		setCookie("alleysearchtab","werewolf");
	} else {
		$("#alley-search-myself").show();
		$("#alley-search-myself-tab").addClass("current");
		$("#alley-search-werewolf").hide();
		$("#alley-search-werewolf-tab").removeClass("current");
		setCookie("alleysearchtab","");
	}
}

/* /Police */

function updateWallet(wallet) {
	if (typeof(wallet['money']) != "undefined") {
		$("div#personal ul.wallet li.tugriki-block").attr("title", $("div#personal ul.wallet li.tugriki-block").attr("title").replace(/[0-9]+/, wallet['money']));
		animateNumber($("div#personal ul.wallet span[rel='money']"), wallet['money']);
	}
	if (typeof(wallet['ore']) != "undefined") {
		$("div#personal ul.wallet li.ruda-block").attr("title", $("div#personal ul.wallet li.ruda-block").attr("title").replace(/[0-9]+/, wallet['ore']));
		animateNumber($("div#personal ul.wallet span[rel='ore']"), wallet['ore']);
	}
	if (typeof(wallet['honey']) != "undefined") {
		$("div#personal ul.wallet li.med-block").attr("title", $("div#personal ul.wallet li.med-block").attr("title").replace(/[0-9]+/, wallet['honey']));
		animateNumber($("div#personal ul.wallet span[rel='honey']"), wallet['honey']);
	}
	if (typeof(wallet['oil']) != "undefined") {
		$("div#personal ul.wallet li.neft-block").attr("title", $("div#personal ul.wallet li.neft-block").attr("title").replace(/[0-9]+/, wallet['oil']));
		animateNumber($("div#personal ul.wallet span[rel='oil']"), wallet['oil']);
	}
}

function formatNumber(nStr) {
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function showObjectOvertip(obj, params, itemId)
{
	var offset_left = Math.round ( $(obj).offset().left - $("div.column-right").offset().left + ($(obj).width()/2) );
	var offset_top = Math.round ( $(obj).offset().top - $("div.column-right").offset().top + ($(obj).height()/3) );
	$("#object-overtip-place").css({"left":offset_left, "top":offset_top});
	$("#object-overtip-place").show();

    params = eval("(" + params + ")");

    $("#object-overtip-place h2").html(params.c);
    if (params.fa != "") {
        $("#object-overtip-place form")[0].action = params.fa;
    }
    $($("#object-overtip-place form div")[0]).html("");
    if (params.t != "") {
        $($("#object-overtip-place form div")[0]).append("<p>" + params.t + "</p>");
    }
    if (params.b != "") {
        $("#object-overtip-place button.button div").html(params.b);
    }
    if (params.ff.length > 0) {
        for (var i in params.ff) {
            var field = params.ff[i];
            $($("#object-overtip-place form div")[0]).append(showObjectOvertip_getField(field.c, field.n, field.t, field.v, field.p));
        }
    }
    $($("#object-overtip-place form div")[0]).append(showObjectOvertip_getField("", "inventory", "hidden", itemId, ""));
}

function showObjectOvertip_getField(caption, name, type, value, params) {
    var html = "";
    switch (type) {
        case "text":html = caption + ': <input type="text" name="' + name + '" value="' + (value ? value : "") + '" />';break;
        case "checkbox":html = '<input type="checkbox" name="' + name + '" ' + (value == 1 ? "checked" : "") + ' /> ' + caption;break;
        case "hidden":html = '<input type="hidden" name="' + name + '" value="' + value + '" />';break;
    }
    return '<div style="margin:5px 0">' + html + '</div>';
}

function hidePerks (important) {
	if (important) {
		/* hide if cross pressed */
		$("#perks-popup").hide();
		$("#perks-popup").attr("nohide","");
		$("#perks-popup span.close-cross").hide();
	} else {
		var nohide = $("#perks-popup").attr("nohide");
		if(!nohide){
			$("#perks-popup").hide();
		}
	}
}

function showPerks(obj,nohide)
{
    var offset_left = Math.round ( $(obj).offset().left - $("div.column-right").offset().left + $(obj).width() );
	var offset_top = Math.round ( $(obj).offset().top - $("div.column-right").offset().top + $(obj).height() );
	$("#perks-popup").css({"left":offset_left, "top":offset_top});
	if (nohide) {
		$("#perks-popup").show();
		$("#perks-popup").attr("nohide","1");
		$("#perks-popup span.close-cross").show();
	} else {
		$("#perks-popup").show();
	}
}

function citymapMouseover(i)
{
    $('#citymap-land-'+i).addClass('hover');
}
function citymapMouseout(i)
{
    $('#citymap-land-'+i).removeClass('hover');
}

function initObjectsChoose(id,radioname){
	if($.browser.msie) {
		$("#"+id+" .object-thumb").bind("click", function(){
			$(this).find('input')[0].click();
		});
	}
	$("#"+id+" input[name="+radioname+"]").bind("click", function(){
		$("#"+id+" label").removeClass("selected");
		$(this).parents("label:first").addClass("selected");
	});
	$("#"+id+" input[name="+radioname+"]:last").attr("checked",true).parents("label:first").addClass("selected");
}

function showAlertSelectItem(title, text, button_title, items, field_name, form_action, params) {
	if (items.length == 0) {
		return;
	}
	
	var html = "<div class=\"alert alert-big\" id=\""+field_name+"-alert\" style=\"display:block\">\
	<div class=\"padding\">\
		<h2>" + title + "</h2>\
		<div class=\"clear data\">\
			<form action=\"" + form_action + "\" method=\"post\">";
	for (var i in params) {
		html += "<input type=\"hidden\" name=\"" + i + "\" value=\"" + params[i] + "\" />";
	}
	html += "<p>" + text +  "</p>\
				<div class=\"objects objects-choose\" id=\"reward1\">\
					<h3>Выберите желаемое</h3>";
	var j = 1;
	for (i in items) {
		if (typeof(items[i]['image']) == 'undefined') {
			continue;
		}
		html += "<span class=\"object-thumb\">\
						<label class=\"\" for=\"objects-" + j + "\">\
							<img src=\"/@/images/obj/" + items[i]['image'] + "\" title=\"" + items[i]['name'] + "\" alt=\"" + items[i]['name'] + "\">";
		if (items[i]['amount'] > 1) {
			html += "<span class=\"count\">" + items[i]['amount'] + "</span>";
		}
		html += "			<b class=\"radio\"><input type=\"radio\" name=\"" + field_name + "\" id=\"objects-" + j + "\" value=\"" + i + "\"></b>\
						</label>\
					</span>";
		j ++;
	}
	html += "<div class=\"actions\">\
					<button class=\"button\" type=\"submit\">\
						<span class=\"f\"><i class=\"rl\"></i><i class=\"bl\"></i><i class=\"brc\"></i>\
							<div class=\"c\">" + button_title + "</div>\
						</span>\
					</button>\
				</div>\
				<script type=\"text/javascript\">\
					initObjectsChoose(\"reward1\",\"" + field_name + "\");\
				</script>\
			</form>\
		</div>\
	</div>\
</div>";
	$('body').append(html);
	$("#"+field_name+"-alert").css('top', $(document).scrollTop()+($(window).height() / 2)-($("#"+field_name+"-alert").height()/2) );
}

function sovetBoostsX2(cb, id, sp1) {
    if (cb.checked) {
        $("#chars-" + id).html($("#chars-" + id).html().replace(sp1 + "%", "<b>" + (sp1 * 2) + "%</b>"));
        $("#price-" + id).html(formatNumber($("#price-" + id).html().replace(/[^\d]/g, "") * 2, 0, "", ",") + "<i></i>");
    } else {
        $("#chars-" + id).html($("#chars-" + id).html().replace("<b>" + (sp1 * 2) + "%</b>", sp1 + "%"));
        $("#price-" + id).html(formatNumber($("#price-" + id).html().replace(/[^\d]/g, "") / 2, 0, "", ",") + "<i></i>");
    }
}


/* neft */

function pipelineScroll() {
    $("#pipeline-scroll").parents("div.pipeline-scroll-place:first").css("backgroundPosition", "-"+Math.round( $("#pipeline-scroll").scrollLeft()/6 ) +"px 0px" );
    if ( $("#pipeline-scroll").scrollLeft() == 0 ) {
        $("#pipeline-arrow-left").hide();
    } else if ( $("#pipeline-scroll")[0].offsetWidth + $("#pipeline-scroll").scrollLeft() >= 1980 ) {
        $("#pipeline-arrow-right").hide();
    } else {
        $("#pipeline-arrow-left").show();
        $("#pipeline-arrow-right").show();
    }
}
function neftPrepare() {
    $("#pipeline-scroll").bind("scroll", pipelineScroll);
    $(document).ready( function(){
        pipelineScroll();

        $("#pipeline-scroll").animate({
            "scrollLeft": Math.round( $("#pipeline-scroll div.enemy-place:first").offset().left - $("#pipeline-scroll").offset().left - 320) +"px"
        },100);
    });

    $("#pipeline-arrow-right").bind("click", function(){
        $("#pipeline-scroll").animate({
            "scrollLeft":"+=332px"
        },600);
    });
    $("#pipeline-arrow-left").bind("click", function(){
        $("#pipeline-scroll").animate({
            "scrollLeft":"-=332px"
        },600);
    });

    $("#ventel-avatar").bind("mouseover", function(kmouse){
        $("#ventel-overtip").show();
    }).bind("mousemove", function(kmouse){
		var relative = $("#pipeline-scroll").parents("div.pipeline-scroll-place:firts").offset()
		$("#ventel-overtip").css({left:kmouse.pageX+15-relative.left, top:kmouse.pageY+15-relative.top});
	});
    $("#ventel-avatar").bind("mouseout", function(){
        $("#ventel-overtip").hide();
    });
}

function neftAttack(now) {
    postUrl("/alley/", {now: now ? 1 : 0, action: "attack-npc3"}, "post");
}


/* Pet */

function petarenaTrain(pet, skill, return_url) {
	return_url = typeof(return_url) != 'undefined' ? return_url : '';
	if (return_url == "ajax") {
		$.post("/petarena/train/" + pet + "/" + skill + "/", {"action": "train", "pet": pet, "skill": skill, "ajax": 1, "postkey": postVerifyKey}, function(data) {
			if (data['result'] == 0) {
				showAlert('', data['error'], 1);
			} else {
				if (data['wallet']) {
					updateWallet(data['wallet']);
				}
				var skills = new Array('focus', 'loyality', 'mass');
				for (var i in skills) {
					if (typeof(data['pet'][skills[i]]) == "undefined") {
						continue;
					}
					$("ul.stats li.stat[rel='" + skills[i] + "'] div.label span.num").html(data['pet'][skills[i]]);
					//data['pet'][skills[i]]
					$("ul.stats li.stat[rel='" + skills[i] + "'] div.bar div.percent").animate({width: parseInt(data['pet'][skills[i] + '_procent']) + "%"});
					$("ul.stats li.stat[rel='" + skills[i] + "'] div.text span[rel='cost']").html(generateMoney(data['pet'][skills[i] + '_cost']));
				}
				generateTimerTable($("#trainpanel"), 'train', 'Питомец отдыхает: ', data['pet']['lasttrainduration'], data['pet']['lasttrainduration'], 'petarenaTrainComplete();');
				$("ul.stats button.button").attr("disabled", "disabled").addClass("disabled");
				var html = '';
				if (parseInt(data['pet']['restore_cost']) > 0) {
					html += "<button class='button' type='button' style='margin-left:10px;' onclick='petarenaRestore(" + pet + ");'><span class='f'><i class='rl'></i><i class='bl'></i><i class='brc'></i><div class='c' style='padding:0 2px'>Снять усталость - <span class='med'>" + data['pet']['restore_cost'] + "<i></i></span></div></span></button>";
				}
				if (data['knut'] == 1) {
					html += "<button class='button' type='button' style='margin-left:10px;' onclick='petarenaRestore(" + pet + ", 1);'><span class='f'><i class='rl'></i><i class='bl'></i><i class='brc'></i><div class='c' style='padding:0 2px'>Использовать кнут<i></i></span></div></span></button>";
				}
				$("#trainpanel > table td.value").append(html);
				$("div.petarena-training h3.curves span[rel='level']").html(data['pet']['level']);
				$("td.avatar img").attr("src", "/@/images/obj/" + data['pet']['image']);
			}
		}, "json");
	} else {
		postUrl("/petarena/train/" + pet + "/" + skill + "/", {"action": "train", "pet": pet, "skill": skill, "return_url": return_url, "postkey": postVerifyKey}, "post");
	}
}

function petarenaTrainComplete() {
	$("ul.stats button.button").attr("disabled", "").removeClass("disabled");
	$("#trainpanel").html('');
	
	var sTitle = document.title;
	sTitle = sTitle.replace(/^\s?\[([^\]]*)\]/, '');
	sTitle = sTitle.replace("0-1", "00").replace("0-1", "00").replace("0-1", "00"); // костыль
	setTitle(sTitle);
}

function petarenaChangeName(pet, oldName) {
	var newName = prompt(LANG_MAIN_38, oldName);
	if (newName != null) {
		$.post("/petarena/changename/" + pet + "/", {"action": "changename", "pet": pet, "name": newName, "ajax": 1, "postkey": postVerifyKey}, function(data){
			if (data['result'] == 0) {
				showAlert('', data['error'], 1);
			} else {
				$("div.petarena-training h3.curves span[rel='name']").html(data['pet']['name']);
			}
		}, "json");
	}
}

function petarenaSetActive(pet) {
	$("table.buttons:first td[rel='active'] div.button").attr("disabled", "disabled");
	$("table.buttons:first td[rel='active'] div.button").attr("class", "button disabled");
	$.post("/petarena/active/" + pet + "/", {"action": "active", "pet": pet, "ajax": 1, "postkey": postVerifyKey}, function(data) {
		if (data['pet']['active'] == 1) {
			$("table.buttons:first td[rel='active'] div.button").attr("disabled", "disabled");
			$("table.buttons:first td[rel='active'] div.button").attr("class", "button disabled");
		} else {
			$("table.buttons:first td[rel='active'] div.button").attr("disabled", "");
			$("table.buttons:first td[rel='active'] div.button").attr("class", "button");
		}
	}, "json");
}

function petarenaSell(petId, petImage) {
	showConfirm("<img src='/@/images/obj/" + petImage + "' align='left' /> Вы уверены, что хотите продать своего питомца?", {"Нет, я передумал": null, "Да =(": function(obj, params){postUrl("/petarena/sell/" + params['pet'] + "/", {"action": "sell", "pet": params['pet']}, "post");}}, {"pet": petId});
}

function petFoodConfirm(foodId, petName, petImage) {
	showConfirm("<img src='/@/images/obj/" + petImage + "' align='left' /> Вы уверены, что хотите покормить <b>" + petName + "</b>? Если вы хотите покормить другого питомца, то надо сделать его активным сначала.", {"Нет, я передумал": null, "Кормить": function(obj, params){document.location.href = "/player/use/" + params['food'] + "/";}}, {"food": foodId});
}

function petarenaMood(pet) {
	$("span.smile1").show();
	$("span.smile1").animate({"top":"90px", "left":"-200px", "fontSize":"10px", "opacity": 0}, 1100, "easein", function() {
		$(this).hide();
		$(this).attr("style", "display: none;");
	});
	$("span.smile2").show();
	$("span.smile2").animate({"top":"90px", "left":"-200px", "fontSize":"10px", "opacity": 0}, 1000, "", function() {
		$(this).hide();
		$(this).attr("style", "display: none;");
	});
	$("span.smile3").show();
	$("span.smile3").animate({"top":"90px", "left":"-200px", "fontSize":"10px", "opacity": 0},1300,"easein", function() {
		$(this).hide();
		$(this).attr("style", "display: none;");
	});
	$("#pet-scratch").attr("disabled", "disabled");
	$("#pet-scratch").attr("class", "button disabled");
	$.post("/petarena/mood/" + pet + "/", {"action": "mood", "pet": pet, "ajax": 1, "postkey": postVerifyKey}, function(data) {
		if (data['result']) {
			showAlert('', data['text'], 0);
		} else {
			showAlert(LANG_MAIN_105, data['error'], 0);
		}
		$("#pet-scratch").attr("disabled", "");
		$("#pet-scratch").attr("class", "button");
		$("#pet-tonus span[rel='tonus']").html(data['pet']['mood']);
		$("#pet-tonus div.percent").css('width', data['pet']['mood']);
	}, "json");
}

function petarenaRespawn(pet) {
	$("div.cure button.button").attr("disabled", "disabled").addClass('disabled');
	$.post("/petarena/respawn/" + pet + "/", {"action": "respawn", "pet": pet, "ajax": 1, "postkey": postVerifyKey}, function(data) {
		$("div.cure button.button").attr("disabled", "").removeClass('disabled');
		if (data['wallet']) {
			updateWallet(data['wallet']);
		}
		if (data['result'] == 0) {
			showAlert('Ошибка', data['error'], 1);
		} else {
			$("#restore").attr("timer", data['restore_in']);
			if (data['restore_in'] == 0) {
				$("div.cure").remove();
				$("td.avatar img").removeClass("injured");
			} else {
				if (typeof(data['healing_cost']) != "undefined") {
					$("div.cure button.button").attr("disabled", "").removeClass('disabled');
					$("div.cure button.button span.ruda").html(data['healing_cost'] + "<i></i>");
					$("div.cure button.button span[rel='heal']").html(data['healing_name']);
				} else {
					$("div.cure > p").remove();
				}
			}
			showAlert('', data['text'], 1);
		}
	}, "json");
}

function petarenaShowPetInProfile(obj) {
	var show = $(obj).is(':checked') ? 1 : 0;
	$(obj).attr("disabled", "disabled");
	$.post("/petarena/showpetinprofile/" + show + "/", {"action": "showpetinprofile", "show": show, "ajax": 1, "postkey": postVerifyKey}, function(data) {
		$(obj).attr("disabled", "");
	});
}

function petarenaRestore(pet, knut) {
	if (typeof(knut) == "undefined") {
		knut = 0;
	}
	$.post("/petarena/restore/" + pet + "/", {"action": "restore", "pet": pet, "ajax": 1, "knut": knut, "postkey": postVerifyKey}, function(data) {
		if (data['result'] == 0) {
			showAlert('', data['error'], 1);
		} else {
			if (data['wallet']) {
				updateWallet(data['wallet']);
			}
			//$("#trainpanel > div.petarena-training-form").empty();
			$("#trainpanel *[timer]").attr("timer", "0");
			$("#trainpanel").empty();

			var sTitle = document.title;
			sTitle = sTitle.replace(/^\s?\[([^\]]*)\]/, '');
			setTitle(sTitle);
			
			setTimeout(function(){$("ul.stats button.button").attr("disabled", "").removeClass("disabled");}, "1000");
		}
	}, "json");
}

/* Pet end */

function generateTimerTable(obj, id, title, timer, timetotal, trigger) {
	var out = "<table class='process'>\
					<tr>\
						<td class='label'>" + title + "</td>\
						<td class='progress'>\
							<div class='exp'>\
								<div class='bar'>\
									<div>\
										<div class='percent' style='width:0%;' id='" + id + "bar'></div>\
									</div>\
								</div>\
							</div>\
						</td>\
						<td class='value'>\
							<span timer='" + timer + "' timer2='" + timetotal + "' id='train' intitle='1' trigger='" + trigger + "'>xx:xx</span>\
						</td>\
					</tr>\
				</table>";
	$(obj).html(out);
	countdown($('#' + id));
}

function generateMoney(money) {
	var out = "";
	for (var i in money) {
		var cl = null
		switch (i) {
			case 'money':
				var cl = 'tugriki';
				break;

			case 'ore':
				var cl = 'ruda';
				break;

			case 'honey':
				var cl = 'med';
				break;
			
			case 'oil':
				var cl = 'neft';
				break;
		}
		if (cl != null) {
			out += "<span class='" + cl + "'>" + formatNumber(money[i]) + "<i></i></span>";
		}
	}
	return out;
}

function showAlert(title, text, error) {
	if (error) {
		var cl = "alert-error";
	} else {
		var cl = "";
	}
	if (title != "") {
		title = "<h2 id='alert-title'>" + title + "</h2>";
	}
	var html = "<div class='alert " + cl + " alert" + ($('div.alert').length + 1) + "'><div class='padding'>" + title + "<div class='data'><div id='alert-text'>" + text + "</div><div class='actions'><div class='button'><a class='f' href='#' onclick='$(this).parents(\"div.alert:first\").remove();'><i class='rl'></i><i class='bl'></i><i class='brc'></i><div class='c'>OK</div></a></div></div></div></div></div>";
	$("body").append(html);
	$("div.alert").show();
}
var callbacks = [];
function serialize(obj) {
	var returnVal;
	if (obj != undefined) {
		switch (obj.constructor) {
			case Array:
			var vArr="[";
			for (var i = 0; i < obj.length; i ++) {
				if (i > 0) vArr += ",";
				vArr += serialize(obj[i]);
			}
			vArr += "]"
			return vArr;
			
			case String:
				returnVal = escape("'" + obj + "'");
				return returnVal;
			case Number:
				returnVal = isFinite(obj) ? obj.toString() : null;
				return returnVal;    
			case Date:
				returnVal = "#" + obj + "#";
				return returnVal;  
			default:
			if (typeof obj == "object") {
				var vobj=[];
				for (attr in obj) {
					if (typeof obj[attr] != "function") {
						vobj.push('"' + attr + '":' + serialize(obj[attr]));
					}
				}
				if (vobj.length > 0)
					return "{" + vobj.join(",") + "}";
				else
					return "{}";
			} else {
				return obj.toString();
			}
		}
	}
	return null;
}
function closeAlert(obj) {
	$(obj).parents("div.alert:first").remove();
}
function unfreezeButton(obj) {
	$(obj).attr("disabled", "").removeClass("disabled");
}

function showConfirm(text, buttons, params) {
	var title = "<h2 id='alert-title'>Вы уверены?</h2>";
	var html = "<div class='alert alert" + ($('div.alert').length + 1) + "'><div class='padding'>" + title + "<div class='data'><div id='alert-text'>" + text + "</div><div class='actions'>";
	if (typeof(params) == "undefined") {
		params = {};
	}
	for (i in buttons) {
		var title = i;
		var callback = buttons[i];
		if (callback === null) {
			callback = function(obj, params){closeAlert(obj);};
		}
		var n = callbacks.length;
		callbacks[n] = callback;
		html += "<button class='button' onclick='callbacks[" + n + "](this, " + new String(serialize(params)).replace("'", "\\'") + ");'><span class='f'><i class='rl'></i><i class='bl'></i><i class='brc'></i><div class='c'>" + title + "</div></span></button>&nbsp;";
	}
	html += "</div></div></div></div>";
	$("body").append(html);
	$("div.alert").show();
}

/* alley - flash fight */

function thisMovie(movieName) {
	if (navigator.appName.indexOf("Microsoft") != -1) {
		return window[movieName];
	}
	else {
		return document[movieName];
	}
}

function fightAnimationBack(){
	if ($("#controls-back").hasClass("disabled")) {
		return;
	}
	$("#controls-back").addClass("disabled");
	$("#controls-play").removeClass("disabled");
	$("#controls-forward").removeClass("disabled");
	fightAnimationResultHide();
	$("#fight-animation-result-link").hide();

	// метод, определенный во флешке
	thisMovie("fightgame").rewindFlashFromJS();
}
function fightAnimationPlay(){
	if ($("#controls-play").hasClass("disabled")) {
		return;
	}
	$("#controls-back").removeClass("disabled");
	$("#controls-play").addClass("disabled");
	$("#controls-forward").removeClass("disabled");
	fightAnimationResultHide();

	// метод, определенный во флешке
	thisMovie("fightgame").playFlashFromJS();
}
function fightAnimationForward(){
	if ($("#controls-forward").hasClass("disabled")) {
		return;
	}
	$("#controls-back").removeClass("disabled");
	$("#controls-play").addClass("disabled");
	$("#controls-forward").addClass("disabled");
	fightAnimationResultShow();

	// метод, определенный во флешке
	thisMovie("fightgame").goForwardFlashFromJS();
}
function fightAnimationResultHide(){
	$("#fight-animation-result").hide();
	$("#fight-animation-result-link").show("fast");
}
function fightAnimationResultShow(){
	$("#fight-animation-result").show();
	$("#fight-animation-result-link").hide();
}

function showOverFlashWin() {
	//метод, вызываемый из флешки
	fightAnimationResultShow();
}

/* Pyramid */
function pyramidBuy(amount) {
	$("button.button").attr("disabled", "disabled").addClass('disabled');
	$.post("/pyramid/buy/" + amount + "/", {"action": "buy", "amount": amount, "ajax": 1, "postkey": postVerifyKey}, function(data) {
		$("button.button").attr("disabled", "").removeClass('disabled');
		pyramidProcessResult(data);
	}, "json");
}

function pyramidSell(amount) {
	$("button.button").attr("disabled", "disabled").addClass('disabled');
	$.post("/pyramid/sell/" + amount + "/", {"action": "sell", "ajax": 1, "postkey": postVerifyKey}, function(data) {
		$("button.button").attr("disabled", "").removeClass('disabled');
		pyramidProcessResult(data);
	}, "json");
}

function pyramidForecast() {
	$("button.button").attr("disabled", "disabled").addClass('disabled');
	$('#pyramid-forecast-advice').html('<div class="hint">Бабушки думают...</div>');
	$.post("/pyramid/forecast/", {"action": "forecast", "ajax": 1, "postkey": postVerifyKey}, function(data) {
		$("button.button").attr("disabled", "").removeClass('disabled');
		pyramidProcessResult(data);
	}, "json");
}

function pyramidProcessResult(data) {
	if (data['wallet']) {
		updateWallet(data['wallet']);
	}
	if (data['result'] == 0) {
		showAlert('Ошибка', data['error'], 1);
	} else if (data['text']) {
		showAlert('', data['text'], 1);
	}
	if (data['pyramid']) {
		animateNumber($('#pyramid_cost'), data['pyramid']['pyramid_cost']);
		animateNumber($('#pyramid_partners'), data['pyramid']['pyramid_partners']);
		animateNumber($('#pyramid_fond'), data['pyramid']['pyramid_fond']);
		if (data['pyramid']['pyramid_state'] == 'crashed') {
			$('#pyramid-working').hide();
			$('#pyramid-crashed span.timeleft').attr('timer', data['pyramid']['pyramid_start_in']);
			countdown($('#pyramid-crashed span.timeleft'));
			$('#pyramid-crashed').show();
		}
	}
	if (data['player']) {
		animateNumber($('#your_pyramids'), data['player']['your_pyramids']);
		animateNumber($('#your_pyramids_sum'), data['player']['your_pyramids'] * data['pyramid']['pyramid_cost']);
		$('#pyramidButtonSell').show();
		if (data['player']['when_action_avail'] != 0) {
			$('#pyramid-buy-form').remove();
			$('#pyramidButtonSell').remove();
			$('#nextactiondt span.timeleft').html(data['player']['when_action_avail']);
			$('#nextactiondt').show();
		}
	}
	if (data['advise']) {
		$('#pyramid-forecast-advice').html('<div class="hint">' + data['advise'] + '</div>');
	}
}
/* /Pyramid */
