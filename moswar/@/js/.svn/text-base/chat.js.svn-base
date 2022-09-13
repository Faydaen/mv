/* CHAT */
var chat = {}

var chat_message_from_me = false;
var chat_smart_scroll = true;
var quizReload = false;
chat.max_message_length = 240;

function chatInit() {
	 var channels = ['general','noobs','private','fraction', 'clan', 'battle', 'quiz'];
	 for (var i in channels) {
		if (level == 1) {
			if (channels[i] == 'general' || channels[i] == 'fraction' || channels[i] == 'clan' || channels[i] == 'quiz') {
				$("#channel-"+channels[i]+"-tab").parents("div:first").hide();
			}
		}/* else if (channels[i] == 'noobs' && can_mute == false) {
			$("#channel-"+channels[i]+"-tab").parents("div:first").hide();
		}*/
		if (channels[i] != 'quiz' && (channels[i] != 'noobs' || level == 1)) {
			if ($("#channel-"+channels[i]+"-tab").length) {
				$("#channel-"+channels[i]+"-tab")[0].checked = true;
				$("#tabs div.tab[channel=" + channels[i] + "]").addClass('tab-current');
			}
		}
	 }
}


function chatClickTab(channel) {
	if ($("#channel-"+channel+"-tab").is(":checked")) {
		$("#tabs div.tab[channel=" + channel + "]").addClass('tab-current');
	} else {
		$("#tabs div.tab[channel=" + channel + "]").removeClass('tab-current');
	}
	chatFilterMessages([],true);
	if (channel == 'quiz' && $("#channel-"+channel+"-tab").is(":checked")) {
		quizReload = setInterval(function(){chatReloadMessages('quiz');}, 2000);
	} else {
		clearInterval(quizReload);
	}
}

function chatAddTo(login, private_first) {
	var t1 = 'to [' + login + '] ';
	var t2 = 'private [' + login + '] ';
	var i;
	var input;
	if($("#text").is(":visible")) {
		input = $("#text");
	} else {
		input = $(top.frames["chat-frame-"+getCookie("chatLayout")].window.document).find("#text");
	}
	var s = '' + input.val();
	if ((i = s.indexOf(t1)) >= 0) {
		s = s.substring(0, i) + t2 + s.substring(i + t1.length);
	} else if ((i = s.indexOf(t2)) >= 0) {
		s = s.substring(0, i) + t1 + s.substring(i + t2.length);
	} else {
		s = (private_first) ? t2 + s : t1 + s;
	}
	if (s.length > chat.max_message_length) s = s.substring(0, chat.max_message_length);
	input.val(s);
	input[0].focus();
	return false;
}

function drawPlayers(players) {
	$('#users').html('<ul class="list-users" id="users-list"></ul>');
	$('#chat-room-people-number').html(players.length);
	for (i = 0; i < players.length; i ++) {
		var player = players[i];
		var current = '<li class="user">';
		if (player['fraction'] == 'resident') {
			current += '<i class="resident" title="Коренные" />';
		} else {
			current += '<i class="arrived" title="Понаехавшие" />';
		}
		if (player['clan_id'] > 0) {
			current += '<a href="/clan/' + player['clan_id'] + '/" target="_blank"><img src="/@images/clan/clan_' + player['clan_id'] + '_ico.png" class="clan-icon" title="' + player['clan_name'] + '" /></a>';
		}
		current += '<a href="/player/' + player['id'] + '/" target="_blank" onclick="chatAddTo(\''+player['nickname']+'\'); return false;">' + player['nickname'] + '</a> <span class="level">[' + player['level'] + ']</span>';
		if (can_mute) current += '<i class="icon lips-icon" onclick="top.frames[\'game-frame\'].document.location.href=\'/chat/moderate/' + player['id'] + '/\';"></i>';
		current += '</li>';
		$('#users-list').append(current);
	}
}

function chatFilterMessages(newmessages,forceRedraw) {
	if (forceRedraw) {
		newmessages = messages.slice();
		messages = [];
		$('#messages').html('');
	} else {
		if (!newmessages || newmessages.length <= 0) return;
	}
	
	var i, m, channel;
	if (newmessages && newmessages.length > 0) {
		for (i in newmessages) {
			messages.push(newmessages[i]);
		}
	}

	for (i in newmessages) {
		message = newmessages[i];
		if (message['type'] == 'resident' || message['type'] == 'arrived') {
			channel = 'fraction';
		} else if (message['type'] == 'battle_resident' || message['type'] == 'battle_arrived') {
			channel = 'battle';
		} else {
			channel = message['type'];
		}
		if (message['type'] == 'system') { 
			var current = '';
			if (message['time'] != undefined) {
				current = '<i class="time">' + message['time'] + '</i> ';
			}
			if (message['text'] == 'player_not_in_chat') {
				current = '<div class="chat-message system-message">Игрок сейчас не в чате. <a href="/phone/message/send/' + message['player_to'] + '/invite2chat/" target="_blank">Отправьте ему личное сообщение</a>, чтобы пригласить.</div>';
			} else {
				current = '<div class="chat-message system-message">' + current + message['text'] + '</div>';
			}
			$('#messages').append(current);
		} else {
			var cur_mesage_arr = new Array();
			
			cur_mesage_arr.push('<div class="chat-message');
			
			cur_mesage_arr.push('">');
			
			cur_mesage_arr.push('<i class="time">' + message['time'] + '</i> ');
			if (message['player_from'] > 0) {
				cur_mesage_arr.push('<b class="user" onclick="chatAddTo(\'' + message['player_from_nickname']+'\')">[' + message['player_from_nickname'] + ']</b>');
			} else if (message['player_from_nickname'] == 'Викторина') {
				cur_mesage_arr.push('<b class="user" onclick="chatAddTo(\'quiz\')">[Викторина]</b>');
			} else {
				cur_mesage_arr.push('<b>Объявление!</b>');
			}
			
			if (message['type'] == 'clan') {
				cur_mesage_arr.push('<img src="/@images/clan/clan_' + message['clan_to'] + '_ico.png" />');
			} else if (message['type'] == 'resident') {
				cur_mesage_arr.push('<i class="resident" title="Коренные" />');
			} else if (message['type'] == 'arrived') {
				cur_mesage_arr.push('<i class="arrived" title="Понаехавшие" />');
			} else {
				cur_mesage_arr.push(' ');
			}
			
			// парсим мессагу
			var from_me = Boolean( message['player_from_nickname'] == mynickname );
			var to_me = false;
			var to_clan = false;
			var to_side = false;
			var to_battle = false;
			var is_private = false;
			
			var text = message['text'];
			
			var i=0;
			var j=0;
			
			var c = 0;
			
			
			while ((i=text.indexOf("to [", c))>=0 && (j=text.indexOf("]", i))>0) {
				user2 = text.substring(i+4, j);
				user2L = user2;
				c = j+63;
				if (user2.length>16) continue;
				if (user2.indexOf("'")<0 && user2.indexOf("$")<0 && user2.indexOf('"')<0 && user2.indexOf(':')<0) {
					if (user2L == mynickname) to_me=true;
				}
				text = text.substring(0, i)+'<b class="user" onclick="chatAddTo(\''+(user2L==mynickname?message['player_from_nickname']:user2)+'\')">'+text.substring(i,j+1)+'</b>'+text.substring(j+1);
			}

			c = 0;
			
			i=0;
			j=0;
			
			while (( i = text.indexOf("private [", c) )>=0 && ( j=text.indexOf("]", i) )>0) {
				user2 = text.substring(i+9, j);
				user2L = user2;
				
				c = j+63;

				if (user2.length>16) continue;
				if (user2.indexOf("'")<0 && user2.indexOf("$")<0 && user2.indexOf('"')<0 && user2.indexOf(':')<0) {
					is_private = true;
					if (user2L == mynickname) { // приват мне
						to_me=true;
					} else if (user2L == "clan" || user2L == "side" || user2L == "battle" ) { // приват моему клану/группе
						
						if (user2L == "side") to_side=true;
						else if  (user2L == "clan") to_clan=true;
						else if  (user2L == "battle") to_battle=true;
					}
					text = text.substring(0, i)+'<b class="user" onclick="chatAddTo(\''+(user2L==mynickname?message['player_from_nickname']:user2)+'\',true)">'+text.substring(i,j+1)+'</b>'+text.substring(j+1);
				}
				
				
			}

			
			if (to_me || from_me) {
				cur_mesage_arr.splice(1,0,' chat-message-2me');
			}
			
			cur_mesage_arr.splice(1,0,' chat-message-type-'+message['type']);
			
			cur_mesage_arr.push(text+'<br /></div>');
			
			var current = cur_mesage_arr.join('');
			$('#messages').append(current);
			
		}
	}
	scrollChatBottom();
}

function scrollChatBottom() {
	if (chat_smart_scroll) {
		if ($('#messages')[0].clientHeight + $('#messages')[0].scrollTop > $('#messages')[0].scrollHeight - ($('#messages')[0].clientHeight / 2)) {
			$('#messages')[0].scrollTop = 99999;
		}
		
	} else {
		$('#messages')[0].scrollTop = 99999;
	}
}


function chatSend() {
	if ($("#text").val().length == 0) {
		return false;
	}
	//return false;
	//проверка есть ли юзер в чате
	clearInterval(reloadMessages);
	$.post('/chat/', {action: 'send', text: $('#text').val(), player_to: $('#player_to').val()}, function(data) {
		reloadMessages = setInterval(function(){chatReloadMessages();}, 10000);
		if (data['error'] ==  'mute') {
			data = [{"type": "system", "text": "Вы не можете разговаривать в чате до " + data['endtime'] + "."}];
		} else if (data['error'] ==  'automute') {
			data = [{"type": "system", "text": "На Вас наложена автоматическая молчанка на 15 минут, так как Вы слишком быстро отправляете сообщения."}];
		} else if (data['error'] == 'no_captcha') {
			data = [{"type": "system", "text": "Вы должны ввести проверочный код для возможности писать сообщения."}];
		}
		chat_message_from_me = true;
		chatFilterMessages(data);
		chat_message_from_me = false;
		
	}, 'json');
	$('#text').val('');
}

function chatReloadMessages(type) {
	clearInterval(reloadMessages);
	$.post("/chat/", {action: "loadmessages", type: type}, function (data) {
		chatFilterMessages(data);
	}, "json");
	reloadMessages = setInterval(function(){chatReloadMessages();}, 10000);
}

var reloadUsers;
function chatReloadUsers() {
	clearInterval(reloadUsers);
	$.post("/chat/", {action: "loadusers"}, function (data) {
		drawPlayers(data);
	}, "json");
	reloadUsers = setInterval(function(){chatReloadUsers();}, 60000);
}

function chatMute() {
	$('#admin-result').show();
	if ($('#admin-player').val() == "") {
		$('#admin-result').html("<div class='error'>Выберите игрока из списка.</div>");
		setTimeout(function(){$('#admin-result').hide();}, "5000");
		return;
	} else if ($('#admin-action').val() == "") {
		$('#admin-result').html("<div class='error'>Выберите действие.</div>");
		setTimeout(function(){$('#admin-result').hide();}, "5000");
		return;
	} else if ($('#admin-period').val() == "" && $('#admin-action').val() == "chat_mute") {
		$('#admin-result').html("<div class='error'>Укажите время.</div>");
		setTimeout(function(){$('#admin-result').hide();}, "5000");
		return;
	} else {
		$.post("/player/", {player: $('#admin-player').val(), action: $('#admin-action').val(), period: $('#admin-period').val(), text: $('#admin-text').val(), json: "1", adminaction: "1"}, function(data) {
			$('#admin-result').show();
			if (data['result'] == 1) {
				if (data['action'] == "player mutechat add") {
					$('#admin-result').html("<div class='success'>На игрока наложена молчанка.</div>");
				} else if (data['action'] == "player mutechat cancel") {
					$('#admin-result').html("<div class='success'>С игрока снята молчанка.</div>");
				} else if (data['action'] == "player isolate on") {
					$('#admin-result').html("<div class='success'>Игрок изолирован.</div>");
				} else if (data['action'] == "player isolate off") {
					$('#admin-result').html("<div class='success'>Игрок выпущен из изоляции.</div>");
				}
			} else {
				if (data['error'] == "bad time") {
					$('#admin-result').html("<div class='error'>Укажите время.</div>");
				} else if (data['error'] == "you have not access") {
					$('#admin-result').html("<div class='error'>У Вас нет прав.</div>");
				} else {
					$('#admin-result').html("<div class='error'>Невозможно наложить молчанку на игрока.</div>");
				}
			}
			setTimeout(function(){$('#admin-result').hide();}, "5000");
		}, 'json');
	}
}

function chatClear(login, private_first) {
	$("#messages").html("");
	messages = new Array();
	return false;
}
/* /chat */