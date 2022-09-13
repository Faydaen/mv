/**
 * Masked Input Plugin
 * http://digitalbush.com/projects/masked-input-plugin/
 * Version: 1.1.4
 * Release: 2008-07-29
 */
(function($) {

	//Helper Function for Caret positioning
	$.fn.caret=function(begin,end){
		if(this.length==0) return;
		if (typeof begin == 'number') {
            end = (typeof end == 'number')?end:begin;
			return this.each(function(){
				if(this.setSelectionRange){
					this.focus();
					this.setSelectionRange(begin,end);
				}else if (this.createTextRange){
					var range = this.createTextRange();
					range.collapse(true);
					range.moveEnd('character', end);
					range.moveStart('character', begin);
					range.select();
				}
			});
        } else {
            if (this[0].setSelectionRange){
				begin = this[0].selectionStart;
				end = this[0].selectionEnd;
			}else if (document.selection && document.selection.createRange){
				var range = document.selection.createRange();
				begin = 0 - range.duplicate().moveStart('character', -100000);
				end = begin + range.text.length;
			}
			return {begin:begin,end:end};
        }
	};

	//Predefined character definitions
	var charMap={
		'9':"[0-9]",
		'a':"[A-Za-z]",
		'*':"[A-Za-z0-9]"
	};

	//Helper method to inject character definitions
	$.mask={
		addPlaceholder : function(c,r){
			charMap[c]=r;
		}
	};

	$.fn.unmask=function(){
		return this.trigger("unmask");
	};

	//Main Method
	$.fn.mask = function(mask,settings) {
		settings = $.extend({
			placeholder: "_",
			completed: null
		}, settings);

		//Build Regex for format validation
		var re = new RegExp("^"+
		$.map( mask.split(""), function(c,i){
		  return charMap[c]||((/[A-Za-z0-9]/.test(c)?"":"\\")+c);
		}).join('')+
		"$");

		return this.each(function(){
			var input=$(this);
			var buffer=new Array(mask.length);
			var locked=new Array(mask.length);
			var valid=false;
			var ignore=false;  			//Variable for ignoring control keys
			var firstNonMaskPos=null;

			//Build buffer layout from mask & determine the first non masked character
			$.each( mask.split(""), function(i,c){
				locked[i]=(charMap[c]==null);
				buffer[i]=locked[i]?c:settings.placeholder;
				if(!locked[i] && firstNonMaskPos==null)
					firstNonMaskPos=i;
			});

			function focusEvent(){
				checkVal();
				writeBuffer();
				setTimeout(function(){
					$(input[0]).caret(valid?mask.length:firstNonMaskPos);
				},0);
			};

			function keydownEvent(e){
				var pos=$(this).caret();
				var k = e.keyCode;
				ignore=(k < 16 || (k > 16 && k < 32 ) || (k > 32 && k < 41));

				//delete selection before proceeding
				if((pos.begin-pos.end)!=0 && (!ignore || k==8 || k==46)){
					clearBuffer(pos.begin,pos.end);
				}
				//backspace and delete get special treatment
				if(k==8){//backspace
					while(pos.begin-->=0){
						if(!locked[pos.begin]){
							buffer[pos.begin]=settings.placeholder;
							if($.browser.opera){
								//Opera won't let you cancel the backspace, so we'll let it backspace over a dummy character.
								s=writeBuffer();
								input.val(s.substring(0,pos.begin)+" "+s.substring(pos.begin));
								$(this).caret(pos.begin+1);
							}else{
								writeBuffer();
								$(this).caret(Math.max(firstNonMaskPos,pos.begin));
							}
							return false;
						}
					}
				}else if(k==46){//delete
					clearBuffer(pos.begin,pos.begin+1);
					writeBuffer();
					$(this).caret(Math.max(firstNonMaskPos,pos.begin));
					return false;
				}else if (k==27){//escape
					clearBuffer(0,mask.length);
					writeBuffer();
					$(this).caret(firstNonMaskPos);
					return false;
				}
			};

			function keypressEvent(e){
				if(ignore){
					ignore=false;
					//Fixes Mac FF bug on backspace
					return (e.keyCode == 8)? false: null;
				}
				e=e||window.event;
				var k=e.charCode||e.keyCode||e.which;
				var pos=$(this).caret();

				if(e.ctrlKey || e.altKey){//Ignore
					return true;
				}else if ((k>=41 && k<=122) ||k==32 || k>186){//typeable characters
					var p=seekNext(pos.begin-1);
					if(p<mask.length){
						if(new RegExp(charMap[mask.charAt(p)]).test(String.fromCharCode(k))){
							buffer[p]=String.fromCharCode(k);
							writeBuffer();
							var next=seekNext(p);
							$(this).caret(next);
							if(settings.completed && next == mask.length)
								settings.completed.call(input);
						}
					}
				}
				return false;
			};

			function clearBuffer(start,end){
				for(var i=start;i<end&&i<mask.length;i++){
					if(!locked[i])
						buffer[i]=settings.placeholder;
				}
			};

			function writeBuffer(){
				return input.val(buffer.join('')).val();
			};

			function checkVal(){
				//try to place charcters where they belong
				var test=input.val();
				var pos=firstNonMaskPos;
				for(var i=0;i<mask.length;i++){
					if(!locked[i]){
						buffer[i]=settings.placeholder;
						while(pos++<test.length){
							//Regex Test each char here.
							var reChar=new RegExp(charMap[mask.charAt(i)]);
							if(test.charAt(pos-1).match(reChar)){
								buffer[i]=test.charAt(pos-1);
								break;
							}
						}
					}
				}
				var s=writeBuffer();
				if(!s.match(re)){
					//input.val("");
					//clearBuffer(0,mask.length);
					valid=false;
				}else
					valid=true;
				cleanVal();
			};

			function cleanVal()
			{
			    ClearAll = true;
			    for (i=0; i<locked.length; i++)
			    {
			        if (!locked[i] && buffer[i] != "_")
			        {
			            ClearAll = false;
			        }
			    }
			    if (ClearAll) {
			        input.val("");
			    } else {
    			    var val = input.val();
    			    val = val.replace(/\(_+\)/gmi, '');
    			    val = val.replace(/_/gmi, '');
    			    input.val(val);
			    }
			}

			function seekNext(pos){
				while(++pos<mask.length){
					if(!locked[pos])
						return pos;
				}
				return mask.length;
			};

			input.one("unmask",function(){
				input.unbind("focus",focusEvent);
				input.unbind("blur",checkVal);
				input.unbind("keydown",keydownEvent);
				input.unbind("keypress",keypressEvent);
				if ($.browser.msie)
					this.onpaste= null;
				else if ($.browser.mozilla)
					this.removeEventListener('input',checkVal,false);
			});
			input.bind("focus",focusEvent);
			input.bind("blur",checkVal);
			input.bind("keydown",keydownEvent);
			input.bind("keypress",keypressEvent);
			//Paste events for IE and Mozilla thanks to Kristinn Sigmundsson
			if ($.browser.msie)
				this.onpaste= function(){setTimeout(checkVal,0);};
			else if ($.browser.mozilla)
				this.addEventListener('input',checkVal,false);

			checkVal();//Perform initial check for existing values
		});
	};
})(jQuery);


/*
 * jQuery UI @VERSION
 *
 * Copyright (c) 2008 Paul Bakaus (ui.jquery.com)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI
 */
;(function($) {

$.ui = {
	plugin: {
		add: function(module, option, set) {
			var proto = $.ui[module].prototype;
			for(var i in set) {
				proto.plugins[i] = proto.plugins[i] || [];
				proto.plugins[i].push([option, set[i]]);
			}
		},
		call: function(instance, name, args) {
			var set = instance.plugins[name];
			if(!set) { return; }

			for (var i = 0; i < set.length; i++) {
				if (instance.options[set[i][0]]) {
					set[i][1].apply(instance.element, args);
				}
			}
		}
	},
	cssCache: {},
	css: function(name) {
		if ($.ui.cssCache[name]) { return $.ui.cssCache[name]; }
		var tmp = $('<div class="ui-gen">').addClass(name).css({position:'absolute', top:'-5000px', left:'-5000px', display:'block'}).appendTo('body');

		//if (!$.browser.safari)
			//tmp.appendTo('body');

		//Opera and Safari set width and height to 0px instead of auto
		//Safari returns rgba(0,0,0,0) when bgcolor is not set
		$.ui.cssCache[name] = !!(
			(!(/auto|default/).test(tmp.css('cursor')) || (/^[1-9]/).test(tmp.css('height')) || (/^[1-9]/).test(tmp.css('width')) ||
			!(/none/).test(tmp.css('backgroundImage')) || !(/transparent|rgba\(0, 0, 0, 0\)/).test(tmp.css('backgroundColor')))
		);
		try { $('body').get(0).removeChild(tmp.get(0));	} catch(e){}
		return $.ui.cssCache[name];
	},
	disableSelection: function(e) {
		e.unselectable = "on";
		e.onselectstart = function() { return false; };
		if (e.style) { e.style.MozUserSelect = "none"; }
	},
	enableSelection: function(e) {
		e.unselectable = "off";
		e.onselectstart = function() { return true; };
		if (e.style) { e.style.MozUserSelect = ""; }
	},
	hasScroll: function(e, a) {
		var scroll = /top/.test(a||"top") ? 'scrollTop' : 'scrollLeft', has = false;
		if (e[scroll] > 0) return true; e[scroll] = 1;
		has = e[scroll] > 0 ? true : false; e[scroll] = 0;
		return has;
	}
};


/** jQuery core modifications and additions **/

var _remove = $.fn.remove;
$.fn.remove = function() {
	$("*", this).add(this).trigger("remove");
	return _remove.apply(this, arguments );
};

// $.widget is a factory to create jQuery plugins
// taking some boilerplate code out of the plugin code
// created by Scott GonzУЁlez and JУЖrn Zaefferer
function getter(namespace, plugin, method) {
	var methods = $[namespace][plugin].getter || [];
	methods = (typeof methods == "string" ? methods.split(/,?\s+/) : methods);
	return ($.inArray(method, methods) != -1);
}

$.widget = function(name, prototype) {
	var namespace = name.split(".")[0];
	name = name.split(".")[1];

	// create plugin method
	$.fn[name] = function(options) {
		var isMethodCall = (typeof options == 'string'),
			args = Array.prototype.slice.call(arguments, 1);

		if (isMethodCall && getter(namespace, name, options)) {
			var instance = $.data(this[0], name);
			return (instance ? instance[options].apply(instance, args)
				: undefined);
		}

		return this.each(function() {
			var instance = $.data(this, name);
			if (isMethodCall && instance && $.isFunction(instance[options])) {
				instance[options].apply(instance, args);
			} else if (!isMethodCall) {
				$.data(this, name, new $[namespace][name](this, options));
			}
		});
	};

	// create widget constructor
	$[namespace][name] = function(element, options) {
		var self = this;

		this.widgetName = name;
		this.widgetBaseClass = namespace + '-' + name;

		this.options = $.extend({}, $.widget.defaults, $[namespace][name].defaults, options);
		this.element = $(element)
			.bind('setData.' + name, function(e, key, value) {
				return self.setData(key, value);
			})
			.bind('getData.' + name, function(e, key) {
				return self.getData(key);
			})
			.bind('remove', function() {
				return self.destroy();
			});
		this.init();
	};

	// add widget prototype
	$[namespace][name].prototype = $.extend({}, $.widget.prototype, prototype);
};

$.widget.prototype = {
	init: function() {},
	destroy: function() {
		this.element.removeData(this.widgetName);
	},

	getData: function(key) {
		return this.options[key];
	},
	setData: function(key, value) {
		this.options[key] = value;

		if (key == 'disabled') {
			this.element[value ? 'addClass' : 'removeClass'](
				this.widgetBaseClass + '-disabled');
		}
	},

	enable: function() {
		this.setData('disabled', false);
	},
	disable: function() {
		this.setData('disabled', true);
	}
};

$.widget.defaults = {
	disabled: false
};


/** Mouse Interaction Plugin **/

$.ui.mouse = {
	mouseInit: function() {
		var self = this;

		this.element.bind('mousedown.'+this.widgetName, function(e) {
			return self.mouseDown(e);
		});

		// Prevent text selection in IE
		if ($.browser.msie) {
			this._mouseUnselectable = this.element.attr('unselectable');
			this.element.attr('unselectable', 'on');
		}

		this.started = false;
	},

	// TODO: make sure destroying one instance of mouse doesn't mess with
	// other instances of mouse
	mouseDestroy: function() {
		this.element.unbind('.'+this.widgetName);

		// Restore text selection in IE
		($.browser.msie
			&& this.element.attr('unselectable', this._mouseUnselectable));
	},

	mouseDown: function(e) {
		// we may have missed mouseup (out of window)
		(this._mouseStarted && this.mouseUp(e));

		this._mouseDownEvent = e;

		var self = this,
			btnIsLeft = (e.which == 1),
			elIsCancel = (typeof this.options.cancel == "string" ? $(e.target).is(this.options.cancel) : false);
		if (!btnIsLeft || elIsCancel || !this.mouseCapture(e)) {
			return true;
		}

		this._mouseDelayMet = !this.options.delay;
		if (!this._mouseDelayMet) {
			this._mouseDelayTimer = setTimeout(function() {
				self._mouseDelayMet = true;
			}, this.options.delay);
		}

		if (this.mouseDistanceMet(e) && this.mouseDelayMet(e)) {
			this._mouseStarted = (this.mouseStart(e) !== false);
			if (!this._mouseStarted) {
				e.preventDefault();
				return true;
			}
		}

		// these delegates are required to keep context
		this._mouseMoveDelegate = function(e) {
			return self.mouseMove(e);
		};
		this._mouseUpDelegate = function(e) {
			return self.mouseUp(e);
		};
		$(document)
			.bind('mousemove.'+this.widgetName, this._mouseMoveDelegate)
			.bind('mouseup.'+this.widgetName, this._mouseUpDelegate);

		return false;
	},

	mouseMove: function(e) {
		// IE mouseup check - mouseup happened when mouse was out of window
		if ($.browser.msie && !e.button) {
			return this.mouseUp(e);
		}

		if (this._mouseStarted) {
			this.mouseDrag(e);
			return false;
		}

		if (this.mouseDistanceMet(e) && this.mouseDelayMet(e)) {
			this._mouseStarted =
				(this.mouseStart(this._mouseDownEvent, e) !== false);
			(this._mouseStarted ? this.mouseDrag(e) : this.mouseUp(e));
		}

		return !this._mouseStarted;
	},

	mouseUp: function(e) {
		$(document)
			.unbind('mousemove.'+this.widgetName, this._mouseMoveDelegate)
			.unbind('mouseup.'+this.widgetName, this._mouseUpDelegate);

		if (this._mouseStarted) {
			this._mouseStarted = false;
			this.mouseStop(e);
		}

		return false;
	},

	mouseDistanceMet: function(e) {
		return (Math.max(
				Math.abs(this._mouseDownEvent.pageX - e.pageX),
				Math.abs(this._mouseDownEvent.pageY - e.pageY)
			) >= this.options.distance
		);
	},

	mouseDelayMet: function(e) {
		return this._mouseDelayMet;
	},

	// These are placeholder methods, to be overriden by extending plugin
	mouseStart: function(e) {},
	mouseDrag: function(e) {},
	mouseStop: function(e) {},
	mouseCapture: function(e) { return true; }
};

$.ui.mouse.defaults = {
	cancel: null,
	distance: 1,
	delay: 0
};

})(jQuery);

/*
 * jQuery UI Dialog
 *
 * Copyright (c) 2008 Richard D. Worth (rdworth.org)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Dialog
 *
 * Depends:
 *	ui.core.js
 *	ui.draggable.js
 *	ui.resizable.js
 */
(function($) {

$.widget("ui.dialog", {
	init: function() {
		var self = this,
			options = this.options,
			resizeHandles = typeof options.resizable == 'string'
				? options.resizable
				: 'n,e,s,w,se,sw,ne,nw',

			uiDialogContent = this.element
				.addClass('content')
				.wrap('<div/>')
				.wrap('<div/>'),

			uiDialogContainer = (this.uiDialogContainer = uiDialogContent.parent()
				.addClass('container')
				.css({position: 'relative', width: '100%', height: '100%'})),

			title = options.title || uiDialogContent.attr('title') || '',
			uiDialogTitlebar = (this.uiDialogTitlebar =
				$('<div class="titlebar"/>'))
				.append('<span class="title">' + title + '</span>')
				.append('<span class="titlebar-close">Закрыть</span>')
				.prependTo(uiDialogContainer),

			uiDialog = (this.uiDialog = uiDialogContainer.parent())
				.appendTo(document.body)
				.hide()
				.addClass('dialog')
				.addClass(options.dialogClass)
				// add content classes to dialog
				// to inherit theme at top level of element
				.addClass(uiDialogContent.attr('className'))
				.removeClass('content')
				.css({
					position: 'absolute',
					width: options.width,
					height: options.height,
					overflow: 'hidden',
					zIndex: options.zIndex
				})
				// setting tabIndex makes the div focusable
				// setting outline to 0 prevents a border on focus in Mozilla
				.attr('tabIndex', -1).css('outline', 0).keydown(function(ev) {
					if (options.closeOnEscape) {
						var ESC = 27;
						(ev.keyCode && ev.keyCode == ESC && self.close());
					}
				})
				.mousedown(function() {
					self.moveToTop();
				}),

			uiDialogButtonPane = (this.uiDialogButtonPane = $('<div/>'))
				.addClass('buttonpane')
				.appendTo(uiDialog);

		this.uiDialogTitlebarClose = $('.titlebar-close', uiDialogTitlebar)
			.click(function() {
				self.close();
				return false;
			});

		this.createButtons(options.buttons);
		this.isOpen = false;

		(options.bgiframe && $.fn.bgiframe && uiDialog.bgiframe());
		(options.autoOpen && this.open());
	},

	setData: function(key, value){
		(setDataSwitch[key] && this.uiDialog.data(setDataSwitch[key], value));
		switch (key) {
			case "buttons":
				this.createButtons(value);
				break;
			case "height":
				this.uiDialog.height(value);
				break;
			case "position":
				this.position(value);
				break;
			case "title":
				$(".title", this.uiDialogTitlebar).text(value);
				break;
			case "width":
				this.uiDialog.width(value);
				break;
		}

		$.widget.prototype.setData.apply(this, arguments);
	},

	position: function(pos) {
		var wnd = $(window), doc = $(document),
			pTop = doc.scrollTop(), pLeft = doc.scrollLeft(),
			minTop = pTop;

		if ($.inArray(pos, ['center','top','right','bottom','left']) >= 0) {
			pos = [
				pos == 'right' || pos == 'left' ? pos : 'center',
				pos == 'top' || pos == 'bottom' ? pos : 'middle'
			];
		}
		if (pos.constructor != Array) {
			pos = ['center', 'middle'];
		}
		if (pos[0].constructor == Number) {
			pLeft += pos[0];
		} else {
			switch (pos[0]) {
				case 'left':
					pLeft += 0;
					break;
				case 'right':
					pLeft += wnd.width() - this.uiDialog.width();
					break;
				default:
				case 'center':
					pLeft += (wnd.width() - this.uiDialog.width()) / 2;
			}
		}
		if (pos[1].constructor == Number) {
			pTop += pos[1];
		} else {
			switch (pos[1]) {
				case 'top':
					pTop += 0;
					break;
				case 'bottom':
					pTop += wnd.height() - this.uiDialog.height();
					break;
				default:
				case 'middle':
					pTop += (wnd.height() - this.uiDialog.height()) / 2;
			}
		}

		// prevent the dialog from being too high (make sure the titlebar
		// is accessible)
		pTop = Math.max(pTop, minTop);
		this.uiDialog.css({top: pTop, left: pLeft});
	},

	size: function() {
		var container = this.uiDialogContainer,
			titlebar = this.uiDialogTitlebar,
			content = this.element,
			tbMargin = parseInt(content.css('margin-top')) + parseInt(content.css('margin-bottom')),
			lrMargin = parseInt(content.css('margin-left')) + parseInt(content.css('margin-right'));
		content.height(container.height() - titlebar.outerHeight() - tbMargin);
		content.width(container.width() - lrMargin);
	},

	open: function() {
		if (this.isOpen) { return; }

		this.overlay = this.options.modal ? new $.ui.dialog.overlay(this) : null;
		this.uiDialog.appendTo('body');
		this.position(this.options.position);
		this.uiDialog.show(this.options.show);
		this.options.autoResize && this.size();
		this.moveToTop(true);

		// CALLBACK: open
		var openEV = null;
		var openUI = {
			options: this.options
		};
		this.uiDialogTitlebarClose.focus();
		this.element.triggerHandler("dialogopen", [openEV, openUI], this.options.open);

		this.isOpen = true;
	},

	// the force parameter allows us to move modal dialogs to their correct
	// position on open
	moveToTop: function(force) {
		if ((this.options.modal && !force)
			|| (!this.options.stack && !this.options.modal)) { return; }

		var maxZ = this.options.zIndex, options = this.options;
		$('.ui-dialog:visible').each(function() {
			maxZ = Math.max(maxZ, parseInt($(this).css('z-index'), 10) || options.zIndex);
		});
		(this.overlay && this.overlay.$el.css('z-index', ++maxZ));
		this.uiDialog.css('z-index', ++maxZ);
	},

	close: function() {
		(this.overlay && this.overlay.destroy());
		this.uiDialog.hide(this.options.hide);

		// CALLBACK: close
		var closeEV = null;
		var closeUI = {
			options: this.options
		};
		this.element.triggerHandler("dialogclose", [closeEV, closeUI], this.options.close);

		this.isOpen = false;
	},

	destroy: function() {
		(this.overlay && this.overlay.destroy());
		this.uiDialog.hide();
		this.element
			.unbind('.dialog')
			.removeData('dialog')
			.removeClass('content')
			.hide().appendTo('body');
		this.uiDialog.remove();
	},

	createButtons: function(buttons) {
		var self = this,
			hasButtons = false,
			uiDialogButtonPane = this.uiDialogButtonPane;

		// remove any existing buttons
		uiDialogButtonPane.empty().hide();

		$.each(buttons, function() { return !(hasButtons = true); });
		if (hasButtons) {
			uiDialogButtonPane.show();
			$.each(buttons, function(name, fn) {
				$('<button/>')
					.text(name)
					.click(function() { fn.apply(self.element[0], arguments); })
					.appendTo(uiDialogButtonPane);
			});
		}
	}
});

$.extend($.ui.dialog, {
	defaults: {
		autoOpen: true,
		autoResize: true,
		bgiframe: false,
		buttons: {},
		closeOnEscape: true,
		draggable: false,
		height: 200,
		minHeight: 100,
		minWidth: 150,
		modal: false,
		overlay: {},
		position: 'center',
		resizable: false,
		stack: true,
		width: 400,
		zIndex: 1000
	},

	overlay: function(dialog) {
		this.$el = $.ui.dialog.overlay.create(dialog);
	}
});

$.extend($.ui.dialog.overlay, {
	instances: [],
	events: $.map('focus,mousedown,mouseup,keydown,keypress,click'.split(','),
		function(e) { return e + '.dialog-overlay'; }).join(' '),
	create: function(dialog) {
		if (this.instances.length === 0) {
			// prevent use of anchors and inputs
			// we use a setTimeout in case the overlay is created from an
			// event that we're going to be cancelling (see #2804)
			setTimeout(function() {
				$('a, :input').bind($.ui.dialog.overlay.events, function() {
					// allow use of the element if inside a dialog and
					// - there are no modal dialogs
					// - there are modal dialogs, but we are in front of the topmost modal
					var allow = false;
					var $dialog = $(this).parents('.dialog');
					if ($dialog.length) {
						var $overlays = $('.dialog-overlay');
						if ($overlays.length) {
							var maxZ = parseInt($overlays.css('z-index'), 10);
							$overlays.each(function() {
								maxZ = Math.max(maxZ, parseInt($(this).css('z-index'), 10));
							});
							allow = parseInt($dialog.css('z-index'), 10) > maxZ;
						} else {
							allow = true;
						}
					}
					return allow;
				});
			}, 1);

			// allow closing by pressing the escape key
			$(document).bind('keydown.dialog-overlay', function(e) {
				var ESC = 27;
				(e.keyCode && e.keyCode == ESC && dialog.close());
			});

			// handle window resize
			$(window).bind('resize.dialog-overlay', $.ui.dialog.overlay.resize);
		}

		var $el = $('<div/>').appendTo(document.body)
			.addClass('dialog-overlay').css($.extend({
				borderWidth: 0, margin: 0, padding: 0,
				position: 'absolute', top: 0, left: 0,
				width: this.width(),
				height: this.height()
			}, dialog.options.overlay));

		(dialog.options.bgiframe && $.fn.bgiframe && $el.bgiframe());

		this.instances.push($el);
		return $el;
	},

	destroy: function($el) {
		this.instances.splice($.inArray(this.instances, $el), 1);

		if (this.instances.length === 0) {
			$('a, :input').add([document, window]).unbind('.dialog-overlay');
		}

		$el.remove();
	},

	height: function() {
		if ($.browser.msie && $.browser.version < 7) {
			var scrollHeight = Math.max(
				document.documentElement.scrollHeight,
				document.body.scrollHeight
			);
			var offsetHeight = Math.max(
				document.documentElement.offsetHeight,
				document.body.offsetHeight
			);

			if (scrollHeight < offsetHeight) {
				return $(window).height() + 'px';
			} else {
				return scrollHeight + 'px';
			}
		} else {
			return $(document).height() + 'px';
		}
	},

	width: function() {
		if ($.browser.msie && $.browser.version < 7) {
			var scrollWidth = Math.max(
				document.documentElement.scrollWidth,
				document.body.scrollWidth
			);
			var offsetWidth = Math.max(
				document.documentElement.offsetWidth,
				document.body.offsetWidth
			);

			if (scrollWidth < offsetWidth) {
				return $(window).width() + 'px';
			} else {
				return scrollWidth + 'px';
			}
		} else {
			return $(document).width() + 'px';
		}
	},

	resize: function() {
		var $overlays = $([]);
		$.each($.ui.dialog.overlay.instances, function() {
			$overlays = $overlays.add(this);
		});

		$overlays.css({
			width: 0,
			height: 0
		}).css({
			width: $.ui.dialog.overlay.width(),
			height: $.ui.dialog.overlay.height()
		});
	}

});

$.extend($.ui.dialog.overlay.prototype, {
	destroy: function() {
		$.ui.dialog.overlay.destroy(this.$el);
	}
});

})(jQuery);

function jQueryDialogClose(dialog)
{
    $("#" + this.id).dialog("close");
}