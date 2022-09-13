jQuery.fn.outerHTML = function(s) {
return (s)
? this.before(s).remove()
: jQuery("<p>").append(this.eq(0).clone()).html();
}

function in_array (needle, haystack, argStrict) {
	var key = '', strict = !!argStrict;
	if (strict) {
		for (key in haystack) {
			if (haystack[key] === needle) {
				return true;
			}
		}
	} else {
		for (key in haystack) {
			if (haystack[key] == needle) {
				return true;
			}
		}
	}
	return false;
}

function date(format, timestamp) {
	var that = this,
	jsdate, f, formatChr = /\\?([a-z])/gi, formatChrCb,
	_pad = function (n, c) {
		if ((n = n + "").length < c) {
			return new Array((++c) - n.length).join("0") + n;
		} else {
			return n;
		}
	},
	txt_words = ["Sun", "Mon", "Tues", "Wednes", "Thurs", "Fri", "Satur",
	"January", "February", "March", "April", "May", "June", "July",
	"August", "September", "October", "November", "December"],
	txt_ordin = {
		1: "st",
		2: "nd",
		3: "rd",
		21: "st",
		22: "nd",
		23: "rd",
		31: "st"
	};
	formatChrCb = function (t, s) {
		return f[t] ? f[t]() : s;
	};
	f = {
		// Day
		d: function () { // Day of month w/leading 0; 01..31
			return _pad(f.j(), 2);
		},
		D: function () { // Shorthand day name; Mon...Sun
			return f.l().slice(0, 3);
		},
		j: function () { // Day of month; 1..31
			return jsdate.getDate();
		},
		l: function () { // Full day name; Monday...Sunday
			return txt_words[f.w()] + 'day';
		},
		N: function () { // ISO-8601 day of week; 1[Mon]..7[Sun]
			return f.w() || 7;
		},
		S: function () { // Ordinal suffix for day of month; st, nd, rd, th
			return txt_ordin[f.j()] || 'th';
		},
		w: function () { // Day of week; 0[Sun]..6[Sat]
			return jsdate.getDay();
		},
		z: function () { // Day of year; 0..365
			var a = new Date(f.Y(), f.n() - 1, f.j()),
			b = new Date(f.Y(), 0, 1);
			return Math.round((a - b) / 864e5) + 1;
		},

		// Week
		W: function () { // ISO-8601 week number
			var a = new Date(f.Y(), f.n() - 1, f.j() - f.N() + 3),
			b = new Date(a.getFullYear(), 0, 4);
			return 1 + Math.round((a - b) / 864e5 / 7);
		},

		// Month
		F: function () { // Full month name; January...December
			return txt_words[6 + f.n()];
		},
		m: function () { // Month w/leading 0; 01...12
			return _pad(f.n(), 2);
		},
		M: function () { // Shorthand month name; Jan...Dec
			return f.F().slice(0, 3);
		},
		n: function () { // Month; 1...12
			return jsdate.getMonth() + 1;
		},
		t: function () { // Days in month; 28...31
			return (new Date(f.Y(), f.n(), 0)).getDate();
		},

		// Year
		L: function () { // Is leap year?; 0 or 1
			var y = f.Y(), a = y & 3, b = y % 4e2, c = y % 1e2;
			return 0 + (!a && (c || !b));
		},
		o: function () { // ISO-8601 year
			var n = f.n(), W = f.W(), Y = f.Y();
			return Y + (n === 12 && W < 9 ? -1 : n === 1 && W > 9);
		},
		Y: function () { // Full year; e.g. 1980...2010
			return jsdate.getFullYear();
		},
		y: function () { // Last two digits of year; 00...99
			return (f.Y() + "").slice(-2);
		},

		// Time
		a: function () { // am or pm
			return jsdate.getHours() > 11 ? "pm" : "am";
		},
		A: function () { // AM or PM
			return f.a().toUpperCase();
		},
		B: function () { // Swatch Internet time; 000..999
			var H = jsdate.getUTCHours() * 36e2, // Hours
			i = jsdate.getUTCMinutes() * 60, // Minutes
			s = jsdate.getUTCSeconds(); // Seconds
			return _pad(Math.floor((H + i + s + 36e2) / 86.4) % 1e3, 3);
		},
		g: function () { // 12-Hours; 1..12
			return f.G() % 12 || 12;
		},
		G: function () { // 24-Hours; 0..23
			return jsdate.getHours();
		},
		h: function () { // 12-Hours w/leading 0; 01..12
			return _pad(f.g(), 2);
		},
		H: function () { // 24-Hours w/leading 0; 00..23
			return _pad(f.G(), 2);
		},
		i: function () { // Minutes w/leading 0; 00..59
			return _pad(jsdate.getMinutes(), 2);
		},
		s: function () { // Seconds w/leading 0; 00..59
			return _pad(jsdate.getSeconds(), 2);
		},
		u: function () { // Microseconds; 000000-999000
			return _pad(jsdate.getMilliseconds() * 1000, 6);
		},

		// Timezone
		e: function () { // Timezone identifier; e.g. Atlantic/Azores, ...
			// The following works, but requires inclusion of the very large
			// timezone_abbreviations_list() function.
			/*              var abbr = '', i = 0, os = 0;
            if (that.php_js && that.php_js.default_timezone) {
                return that.php_js.default_timezone;
            }
            if (!tal.length) {
                tal = that.timezone_abbreviations_list();
            }
            for (abbr in tal) {
                for (i = 0; i < tal[abbr].length; i++) {
                    os = -jsdate.getTimezoneOffset() * 60;
                    if (tal[abbr][i].offset === os) {
                        return tal[abbr][i].timezone_id;
                    }
                }
            }
*/
			return 'UTC';
		},
		I: function () { // DST observed?; 0 or 1
			// Compares Jan 1 minus Jan 1 UTC to Jul 1 minus Jul 1 UTC.
			// If they are not equal, then DST is observed.
			var a = new Date(f.Y(), 0), // Jan 1
			c = Date.UTC(f.Y(), 0), // Jan 1 UTC
			b = new Date(f.Y(), 6), // Jul 1
			d = Date.UTC(f.Y(), 6); // Jul 1 UTC
			return 0 + ((a - c) !== (b - d));
		},
		O: function () { // Difference to GMT in hour format; e.g. +0200
			var a = jsdate.getTimezoneOffset();
			return (a > 0 ? "-" : "+") + _pad(Math.abs(a / 60 * 100), 4);
		},
		P: function () { // Difference to GMT w/colon; e.g. +02:00
			var O = f.O();
			return (O.substr(0, 3) + ":" + O.substr(3, 2));
		},
		T: function () { // Timezone abbreviation; e.g. EST, MDT, ...
			// The following works, but requires inclusion of the very
			// large timezone_abbreviations_list() function.
			/*              var abbr = '', i = 0, os = 0, default = 0;
            if (!tal.length) {
                tal = that.timezone_abbreviations_list();
            }
            if (that.php_js && that.php_js.default_timezone) {
                default = that.php_js.default_timezone;
                for (abbr in tal) {
                    for (i=0; i < tal[abbr].length; i++) {
                        if (tal[abbr][i].timezone_id === default) {
                            return abbr.toUpperCase();
                        }
                    }
                }
            }
            for (abbr in tal) {
                for (i = 0; i < tal[abbr].length; i++) {
                    os = -jsdate.getTimezoneOffset() * 60;
                    if (tal[abbr][i].offset === os) {
                        return abbr.toUpperCase();
                    }
                }
            }
*/
			return 'UTC';
		},
		Z: function () { // Timezone offset in seconds (-43200...50400)
			return -jsdate.getTimezoneOffset() * 60;
		},

		// Full Date/Time
		c: function () { // ISO-8601 date.
			return 'Y-m-d\\Th:i:sP'.replace(formatChr, formatChrCb);
		},
		r: function () { // RFC 2822
			return 'D, d M Y H:i:s O'.replace(formatChr, formatChrCb);
		},
		U: function () { // Seconds since UNIX epoch
			return jsdate.getTime() / 1000 | 0;
		}
	};
	this.date = function (format, timestamp) {
		that = this;
		jsdate = (
			(typeof timestamp === 'undefined') ? new Date() : // Not provided
			(timestamp instanceof Date) ? new Date(timestamp) : // JS Date()
			new Date(timestamp * 1000) // UNIX timestamp (auto-convert to int)
			);
		return format.replace(formatChr, formatChrCb);
	};
	return this.date(format, timestamp);
}

Chat = function() {
	var chat = null;
	var player = null;
	var prevRoom = null;
	var room = null;
	var lastcome = null;
	var smiles = new Array('angel','angry','angry2','applause','attention','box','bye','chase','child','crazy','cry','dance','dance2','dance3','dance4','devil',
		'dontknow','flag','girl','gun','gun2','gun3','gun4','gun5','gun6','gun7','gun8','hello','hello2','holiday','holiday2','kiss','kiss2','kiss3','lol',
		'love','love2','molotok','music','music2','play','police','punk','rtfm','rtfm2','skull','sleep','smoke','smoke2','sport','sumo','tema','tounge','wall',
		'why','yessir','zver','popcorn','winner','mol','strah','haha');


	function alertError(title, text) {
		var html = '<div class="alert alert-error" style="display: block;" rel="show">\
			<div class="padding">\
				<h2 id="alert-title">' + title + '</h2>\
				<div class="data">\
					<div id="alert-text">' + text + '</div>\
					<div class="actions">\
						<button class="button" onclick="$(this).parents(\'div.alert:first\').remove();">\
							<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>\
								<div class="c">OK</div>\
							</span>\
						</button>\
					</div>\
				</div>\
			</div>\
		</div>';
		$(top.frames['game-frame'].document.body).append(html);
	}

	function alertMessage(title, text) {
		var html = '<div class="alert" style="display: block;" rel="show">\
			<div class="padding">\
				<h2 id="alert-title">' + title + '</h2>\
				<div class="data">\
					<div id="alert-text">' + text + '</div>\
					<div class="actions">\
						<button class="button" onclick="$(this).parents(\'div.alert:first\').remove();">\
							<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>\
								<div class="c">OK</div>\
							</span>\
						</button>\
					</div>\
				</div>\
			</div>\
		</div>';
		$(top.frames['game-frame'].document.body).append(html);
	}

	var connect = function() {
		if(top.frames['game-frame'].location.href.match("dev.moswar.ru")) {
			chat.setHost("prod.dev.moswar.ru");
			chat.setPort(8081);
		} else {
			chat.setHost("85.112.113.75");
			chat.setPort(8081);
		}
		chat.setAuth(getCookie("userid"), getCookie("authkey"));
		chat.connect();
	}

	var error = function(error) {
	}

	var init = function() {
		chat = $("#chatswf")[0];
		connect();
	}

	var scrollChatBottom = function() {
		var ratio = ($("#messages")[0].clientHeight + $("#messages")[0].scrollTop) / $("#messages")[0].scrollHeight;

		if (ratio > 0.85 || player.nickname == data.data.sender.nickname) {
			$("#messages")[0].scrollTop = 99999;
		}
	}

	var sortPlayers = function() {
		var list = $("#users-list li");
		var arr = new Array();
		list.each(function() {
			var li = $(this);
			arr.push({
				name: li.find("a.player-nickname").html(),
				html: li.outerHTML()
			});
			
		});
		var s = function(i, ii) {
			if (i.name > ii.name)
				return 1;
			else if (i.name < ii.name)
				return -1;
			else
				return 0;
		}
		arr.sort(s);
		var html = "";
		for (var i = 0; i < arr.length; i++) {
			html += arr[i].html;
		}
		$("#users-list").html(html);
	}

	var chatFilterMessages = function(data) {

		if (data.data.message) {
			var matches = data.data.message.match(/:([\w]+):/g);
			if (matches && matches.length) {
				var j = 0;
				for (i = 0; i < matches.length; i++) {
					if (!matches[i]) break;
					var smile = matches[i].replace(/:/g, "");
					if (in_array(smile, smiles)) {
						if (j == 3) break;
						data.data.message = data.data.message.replace(matches[i], "<img onclick=\"Chat.addSmile('" + matches[i].replace(/:/g, "") + "')\" src=\"/@/images/smile/" + matches[i].replace(/:/g, "") + ".gif\" align=\"absmiddle\" />");
						j++;
					}
				}
			}
		}
		if (data.data.type == "casino") {
			data.data.time += 7;
		}
		data.data.time = date("H:i:s", data.data.time);

		if (data.data.type == "system") {
			if (data.data.reauth) {
				$("#chatswf").remove();
				$("#text").attr("disabled", "disabled");
				$("button").attr("disabled", "disabled");
				chat = null;
			}
			var current = "";
			if (data.data.time != undefined) {
				current = "<i class=\"time\">" + data.data.time + "</i> ";
			}
			current = "<div class=\"chat-message system-message\">" + current + data.data.message + "</div>";
			$("#messages").append(current);
		} else {
			var cur_mesage_arr = new Array();

			cur_mesage_arr.push("<div class=\"chat-message");
			cur_mesage_arr.push("\">");

			cur_mesage_arr.push("<i class=\"time\">" + data.data.time + "</i> ");
			if (data.data.sender && data.data.sender.id) {
				cur_mesage_arr.push("<b class=\"user\" onclick=\"Chat.addTo('" + data.data.sender.nickname + "')\">[" + data.data.sender.nickname + "]</b>");
			} else if (data.data.sender.nickname == LANG_CHAT_NEW_22) {
				cur_mesage_arr.push("<b class=\"user\" onclick=\"Chat.addTo('quiz')\">[" + LANG_CHAT_NEW_22 + "]</b>");
			} else {
				cur_mesage_arr.push("<b>" + LANG_CHAT_NEW_17 + "</b>");
			}

			switch(data.data.type) {
				case "clan" :
					cur_mesage_arr.push("<img src=\"/@images/clan/clan_" + data.data.sender.clan_id + "_ico.png\" />");
					break;
				case "resident" :
					cur_mesage_arr.push("<i class=\"resident\" title=\"" + LANG_CHAT_NEW_24 + "\" />");
					break;
				case "arrived" :
					cur_mesage_arr.push("<i class=\"arrived\" title=\"" + LANG_CHAT_NEW_18 + "\" />");
					break;
				default:
					cur_mesage_arr.push(" ");
					break;
			}

			//" + LANG_CHAT_NEW_11 + "
			var from_me = Boolean(data.data.sender.id == player.id);
			var to_me = false;
			var text = data.data.message;

			if (text.match(new RegExp("(to|private)\\s+\\[" + player.nickname + "\\]", "gi")) != null) {
				to_me = true;
			}

			text = text.replace(new RegExp("to\\s+\\[" + player.nickname + "\\]", "gi"), "to <b class=\"user\" onclick=\"Chat.addTo('" + data.data.sender.nickname + "')\">[" + player.nickname + "]</b>");
			text = text.replace(new RegExp("private\\s+\\[" + player.nickname + "\\]", "gi"), "private <b class=\"user\" onclick=\"Chat.addTo('" + data.data.sender.nickname + "', true)\">[" + player.nickname + "]</b>");
			text = text.replace(/to\s+\[([^\]]+)\]/gi, "to <b class=\"user\" onclick=\"Chat.addTo('$1')\">[$1]</b>");
			text = text.replace(/private\s+\[([^\]]+)\]/gi, "private <b class=\"user\" onclick=\"Chat.addTo('$1', true)\">[$1]</b>");

			if (to_me || from_me) {
				cur_mesage_arr.splice(1, 0, " chat-message-2me");
			}

			cur_mesage_arr.splice(1, 0, " chat-message-type-" + data.data.type);

			cur_mesage_arr.push(text + "<br /></div>");

			current = cur_mesage_arr.join("");

			if (data.data.type == "casino") {
				setTimeout(function() { $("#messages").append(current); }, 7000);
			} else {
				$("#messages").append(current);
			}
		}
		
		scrollChatBottom();
	}

	var createPlayerHtml = function(currentPlayer) {
		var current = "<li class=\"user\" id=\"chat-player-" + currentPlayer.id + "\">";
		if (currentPlayer.fraction == "resident") {
			current += "<i class=\"resident\" title=\"" + LANG_CHAT_NEW_24 + "\" />";
		} else {
			current += "<i class=\"arrived\" title=\"" + LANG_CHAT_NEW_18 + "\" />";
		}
		if (currentPlayer.clan_id > 0) {
			current += "<a href=\"/clan/" + currentPlayer.clan_id + "/\" target=\"_blank\"><img src=\"/@images/clan/clan_" + currentPlayer.clan_id + "_ico.png\" class=\"clan-icon\" title=\"" + currentPlayer.clan_name + "\" /></a>";
		}
		current += "<a href=\"/player/" + currentPlayer.id + "/\" class=\"player-nickname\" target=\"_blank\" onclick=\"Chat.addTo('" + currentPlayer.nickname + "'); return false;\">" + currentPlayer.nickname + "</a> <span class=\"level\">[" + currentPlayer.level + "]</span>";
		if (player.mute_chat_access && player.mute_chat_access != "0" && player.mute_chat_access != 0) current += "<i class=\"icon lips-icon\" onclick=\"top.frames['game-frame'].document.location.href='/chat/moderate/" + currentPlayer.id + "/';\"></i>";
		current += "</li>";
		return current;
	}

	var drawPlayers = function(players) {
		$("#users").html("<ul class=\"list-users\" id=\"users-list\"></ul>");
		$("#chat-room-people-number").html(players.length);
		for (var i = 0; i < players.length; i ++) {
			$("#users-list").append(createPlayerHtml(players[i]));
		}
		sortPlayers();
	}

	var addTo = function(login, private_first) {
		var t1 = 'to [' + login + '] ';
		var t2 = 'private [' + login + '] ';
		var i;
		var input;
		if($("#text").is(":visible")) {
			input = $("#text");
		} else {
			input = $(top.frames["chat-frame-" + getCookie("chatLayout")].window.document).find("#text");
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

	var addSmile = function(smile) {
		var input;
		if($("#text").is(":visible")) {
			input = $("#text");
		} else {
			input = $(top.frames["chat-frame-" + getCookie("chatLayout")].window.document).find("#text");
		}
		var val = input.val();
		if (val.length) val += " ";
		input.val(val + ":" + smile + ":");
		input[0].focus();
		return false;
	}

	var requestAuth = function(data) {
	//console.log(data);
	}

	// TODO" + LANG_CHAT_NEW_0 + "
	var requestCome = function(data) {
		$("#users-list").append(createPlayerHtml(data.data.player));
		sortPlayers();
		var count = parseInt($("#chat-room-people-number").html());
		count++;
		$("#chat-room-people-number").html(count)
		top.frames["game-frame"].window.$(".chat-rooms-list #chat-room-" + data.data.roomCode + " span.num").html(count);
	//getRooms();
	}

	var requestLeave = function(data) {
		$("#users-list #chat-player-" + data.data.player.id).remove();
		var count = parseInt($("#chat-room-people-number").html());
		count--;
		$("#chat-room-people-number").html(count)
		top.frames["game-frame"].window.$(".chat-rooms-list #chat-room-" + data.data.roomCode + " span.num").html(count);

	//getRooms();
	}

	var requestMessage = function(data) {
		chatFilterMessages(data);
	}

	var requestMute = function(data) {
		data.data.type = "system";
		data.data.message = LANG_CHAT_NEW_20 + "" + data.data.moderator.nickname + "" + LANG_CHAT_NEW_5 + ""  + data.data.player.nickname +  "" + LANG_CHAT_NEW_15 + ""  + data.data.period +  ". (" + LANG_CHAT_NEW_21 + "" + data.data.reason  + ").";
		chatFilterMessages(data);
	}

	var requestIsolate = function(data) {		
	//console.log(data);
	}

	var requestUnmute = function(data) {
		data.data.type = "system";
		data.data.message = LANG_CHAT_NEW_20 + "" + data.data.moderator.nickname + "" + LANG_CHAT_NEW_6 + ""  + data.data.player.nickname +  ".";
		chatFilterMessages(data);
	}

	var requestUnisolate = function(data) {
	//console.log(data);
	}

	var responseRooms = function(data) {
		var html = "";
		for (var i = 0; i < data.data.rooms.length; i++) {
			if (data.data.rooms[i].code) {
				html += createRoomHtml(data.data.rooms[i]);
			}
		}
		top.frames["game-frame"].window.$(".chat-rooms-list").html(html);
	}

	var responseAuth = function(data) {
		player = data.data.player;
		var newRoom = null;
		if (player.level == 1) {
			newRoom = getCookie("chat_room");
			if (!newRoom || !newRoom.length) newRoom = "noobs";
		} else {
			newRoom = getCookie("chat_room");
			if (!newRoom || !newRoom.length) newRoom = "general";
		}
		chat.actionCome(newRoom);
	}

	var responseCome = function(data) {
		if (data.success) {
			setCookie("chat_room", data.data.room.code);
			drawPlayers(data.data.room.players);
			$("#chat-room-name").html(data.data.room.name);
			room = data.data.room.code;
			lastcome = new Date().getTime();
		} else {
			if (room == null) {
				var newRoom = null;
				if (prevRoom && prevRoom != data.data.roomCode) newRoom = prevRoom;
				else {
					if (player.level == 1) {
						newRoom = "noobs";
					} else {
						newRoom = "general";
					}
				}
				if (data.error) alertError(LANG_CHAT_NEW_13, data.error);
				chat.actionCome(newRoom);
			}
		}
		getRooms();
	}

	var responseLeave = function(data) {
		if (data.success) {
			if (room) prevRoom = room;
			room = null;
			clear();
		}
	}

	var responseMessage = function(data) {
		if (data.success == false) {
			data.data.type = "system";
			switch (data.error) {
				case "mute" :
					data.data.message = LANG_CHAT_NEW_4 + "" + data.data.period + ".";
					break;
				case "captcha" :
					data.data.message = LANG_CHAT_NEW_1;
					break;
				case "automute" :
					data.data.message = LANG_CHAT_NEW_3 + "" + data.data.period + "" + LANG_CHAT_NEW_2;
					break;
				case "frozen" :
					data.data.message = LANG_CHAT_NEW_FROZEN;
					break;
				case "deported" :
					data.data.message = LANG_CHAT_NEW_DEPORTED;
					break;
			}
		}

		chatFilterMessages(data);
	}

	var responseMute = function(data) {
		alertMessage(LANG_CHAT_NEW_16, LANG_CHAT_NEW_19 + "" + data.data.player.nickname + "" + LANG_CHAT_NEW_8 + "" + data.data.period);
	}

	var responseIsolate = function(data) {
		alertMessage(LANG_CHAT_NEW_16, LANG_CHAT_NEW_19 + "" + data.data.player.nickname + "" + LANG_CHAT_NEW_7 + "" + data.data.period);
	}

	var responseUnmute = function(data) {
		alertMessage(LANG_CHAT_NEW_16, LANG_CHAT_NEW_23 + "" + data.data.player.nickname + "" + LANG_CHAT_NEW_12);
	}

	var responseUnisolate = function(data) {
		alertMessage(LANG_CHAT_NEW_16, LANG_CHAT_NEW_23 + "" + data.data.player.nickname + "" + LANG_CHAT_NEW_14);
	}

	var actionMessage = function() {
		if ($("#text").val().length == 0) {
			return false;
		}
		if (chat) {
			if (chat.actionMessage($("#text").val())) {
				$("#text").val("");
			}
		}
	}

	var createRoomHtml = function(currentRoom) {
		var html = "<li";
		if(currentRoom.code == room) {
			html += " class=\"current\"";
		}
		html += " id=\"chat-room-" + currentRoom.code + "\">";
		html += "<a href=\"javascript:void(0);\" onclick=\"top.frames['chat-frame-' + getCookie('chatLayout')].Chat.come('" + currentRoom.code + "')\">" + currentRoom.name + "</a><span class=\"num\">" + currentRoom.count + "</span>";
		html += "<div class=\"hint\">" + currentRoom.description;
		if (currentRoom.code == "clan" || currentRoom.code == "battle") {
			html += "<br /><span class=\"dashedlink\" onclick=\"top.frames['chat-frame-' + getCookie('chatLayout')].Chat.addTo('" + currentRoom.code + "')\">to [" + currentRoom.code + "]</span>";
		}
		html += "</div></li>";
		return html;
	}

	var getRooms = function() {
		if (chat && top.frames["game-frame"].window.$(".chat-rooms-list").length) {
			chat.actionRooms();
		}
	}

	var come = function(newRoom) {
		var time = new Date().getTime();
		if (chat && room != newRoom && (time - lastcome) > 3000) {
			chat.actionCome(newRoom);
		}
	}

	var clear = function() {
		$("#messages").html("");
		return false;
	}

	var moderate = function(action, player, time, reason) {
		if (!action.length) {
			alertError(LANG_CHAT_NEW_25, LANG_CHAT_NEW_9);
			return false;
		}
		if ((!reason || !reason.length) && (action == "mute" || action == "isolate")) {
			alertError(LANG_CHAT_NEW_25, LANG_CHAT_NEW_10);
			return false;
		}
		switch(action) {
			case "mute" :
				chat.actionMute(player, time, reason);
				break;
			case "unmute" :
				chat.actionUnmute(player);
				break;
			case "isolate" :
				chat.actionIsolate(player, time, reason);
				break;
			case "unisolate" :
				chat.actionUnisolate(player);
				break;
		}
	}

	return {
		init: init,
		requestAuth: requestAuth,
		requestCome: requestCome,
		requestLeave: requestLeave,
		requestMessage: requestMessage,
		requestMute: requestMute,
		requestIsolate: requestIsolate,
		requestUnmute: requestUnmute,
		requestUnisolate: requestUnisolate,
		getRooms: getRooms,
		responseAuth: responseAuth,
		responseCome: responseCome,
		responseLeave: responseLeave,
		responseMessage: responseMessage,
		responseMute: responseMute,
		responseIsolate: responseIsolate,
		responseUnmute: responseUnmute,
		responseUnisolate: responseUnisolate,
		responseRooms: responseRooms,
		actionMessage: actionMessage,
		addTo: addTo,
		addSmile: addSmile,
		come: come,
		clear: clear,
		moderate: moderate,
		error: error
	};
}();
