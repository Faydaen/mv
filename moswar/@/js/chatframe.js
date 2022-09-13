var chatMinHeight = 152;
var chatMinWidth = 300;
var chatMaxHeight = 600;
var chatMaxWidth = 800;
/*

var chatMaxHeight = gameFrame.document.body ? gameFrame.document.body.clientHeight : ( gameFrame.document.documentElement ? document.documentElement.clientHeight : 500 );
var chatMaxWidth = gameFrame.document.body ? gameFrame.document.body.clientWidth : ( gameFrame.document.documentElement ? document.documentElement.clientWidth : 700 );
*/

/* смена размера нижнего  фрейма */
function chatHeightChange(direction){
	var frameHeight = Number( $(top.document).find("#chat-frameset-vertical").attr("rows").split(",")[1] ) || $(top.document).find("#chat-frame-bottom")[0].offsetHeight || $("#chat-bottom")[0].offsetHeight || 0;
	var step = 80;
	var newFrameHeight;
	if(direction=="up"){
		newFrameHeight = frameHeight+step;
	} else if(direction=="down") {
		newFrameHeight = frameHeight-step;
	} else {
		newFrameHeight = 220;
	}
	if(newFrameHeight<chatMinHeight) {
		newFrameHeight = chatMinHeight;
	} else if(newFrameHeight>chatMaxHeight) {
		newFrameHeight = chatMaxHeight;
	}
	$(top.document).find("#chat-frameset-vertical").attr("rows","*,"+newFrameHeight);
	chatBottomResize();
	setCookie("chatHeight",newFrameHeight);
}

/* подгоняет окно под размер нижнего фрейма */
function chatBottomResize(){
	var frameHeight = Number( $(top.document).find("#chat-frameset-vertical").attr("rows").split(",")[1] ) || $(top.document).find("#chat-frame-bottom")[0].offsetHeight || $("#chat-bottom")[0].offsetHeight || 0;
	var differenceHeight = ( $("#chat-headline").is(":visible")?$("#chat-headline")[0].offsetHeight-8:0 ) + ( $("#chat-footerline").is(":visible") ? $("#chat-footerline")[0].offsetHeight:0 );
	var contentHeight = frameHeight - differenceHeight;
	var usersObj = $("#users");
	var messagesObj = $("#messages");
	if(usersObj.is(":visible")) {
		usersObj.css("height",contentHeight);
	}
	if(messagesObj.is(":visible")) {
		messagesObj.css("height",contentHeight);
	}
}

/* смена размера бокового фрейма */
function chatWidthChange(direction){
	var frameWidth = Number( $(top.document).find("#chat-frameset-horizontal").attr("cols").split(",")[0] ) || $(top.document).find("#chat-frame-left")[0].offsetWidth || $("#chat-left")[0].offsetWidth || 0;
	var step = 100;
	var newFrameWidth;
	if(direction=="right"){
		newFrameWidth = frameWidth+step;
	} else if(direction=="left") {
		newFrameWidth = frameWidth-step;
	} else {
		newFrameWidth = chatMinWidth;
	}
	if(newFrameWidth<chatMinWidth) {
		newFrameWidth = chatMinWidth;
	} else if(newFrameWidth>chatMaxWidth) {
		newFrameWidth = chatMaxWidth;
	}
	$(top.document).find("#chat-frameset-horizontal").attr("cols",newFrameWidth+",*");
	setCookie("chatWidth",newFrameWidth);
	chatLeftResize();
}

/* подгоняет окно под размер бокового (левого) фрейма */
function chatLeftResize(){
	var frameHeight = $(top.document).find("#chat-frame-left")[0].offsetHeight || $("#chat-left")[0].offsetHeight || 0;
	var differenceHeight = ( $("#chat-headline").is(":visible")?$("#chat-headline")[0].offsetHeight-8:0 ) + ( $("#chat-footerline").is(":visible")?$("#chat-footerline")[0].offsetHeight:0 );
	var usersHeight = $("#users").is(":visible") ? $("#users")[0].offsetHeight-8 : 0;
	if($("#messages").is(":visible") && "left"==getCookie("chatLayout")) { 
		$("#messages").css("height",frameHeight-differenceHeight-usersHeight); 
		var chatWidth = getCookie("chatWidth") || 300;
		$("#messages").css("width",chatWidth-2); 
	}
}

/* смена расположения фреймов */
function chatFramesLayout(side){
	var chatSize;
	if(side == "left") {
		chatSize = getCookie("chatWidth") || 300;
		$(top.document).find("#chat-frameset-vertical").attr("rows","*,0");
		$(top.document).find("#chat-frameset-horizontal").attr("cols",chatSize+",*");
		$(top.document).find("#chat-frame-bottom").attr("src","about:blank");
		$(top.document).find("#chat-frame-left").attr("src","/chat/chat/left/");
		setCookie("chatLayout","left");
	} else {
		chatSize = getCookie("chatHeight") || 252;
		$(top.document).find("#chat-frameset-horizontal").attr("cols","0,*");
		$(top.document).find("#chat-frameset-vertical").attr("rows","*,"+chatSize);
		$(top.document).find("#chat-frame-left").attr("src","about:blank");
		$(top.document).find("#chat-frame-bottom").attr("src","/chat/chat/bottom/");
		setCookie("chatLayout","bottom");
	}
}

/* открытие чата */
function chatOpen(){
	var chatLayout = getCookie("chatLayout")||(screen.height >=800 ? "bottom" : "left");
	chatFramesLayout(chatLayout);
}

/* закрытие чата */
function chatClose(){
	$(top.document)[0].location.href = top.frames["game-frame"].document.location.href;
}

/* включить чат, если есть чат-фрейм и фреймы пустые */
if (top.frames.length && self == top.frames["game-frame"].window) {
	var t1 = $(top.document).find("#chat-frame-left").attr("src");
	var t2 = $(top.document).find("#chat-frame-bottom").attr("src");
	if (t1 == "about:blank" && t2 == "about:blank") {
		$(top.frames["game-frame"].window.document).ready(function(){
			chatOpen();
		});
	}
	$(top.frames["game-frame"].window.document).ready(function(){
		$(top.frames["game-frame"].window.document).find("#icon-relaod").show();
	});
}