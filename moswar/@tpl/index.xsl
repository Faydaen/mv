<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" doctype-system="http://www.w3.org/TR/html4/strict.dtd" doctype-public="-//W3C//DTD HTML 4.01//EN" indent="yes" />
	<xsl:template match="/data">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="Понаехали тут! - самая циничная онлайн игра о жизни в столице!" name="description" />
<meta content="бесплатная браузерная игра, онлайн игра, бесплатная игра, браузерная игра, понаехали, понаехали тут, игра" name="keywords" />
<!-- для моего мира  -->
<meta name="mrc__share_title" content="Понаехали тут! - Циничная игра о жизни в столице" /> 
<meta name="mrc__share_description" content="Коренные столичники VS Понаехавшие захватчики" /> 
<link rel="image_src" href="http://www.moswar.ru/@/images/logo.jpg" />
<!-- / для моего мира  -->
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="/@/css/style.css" />
<title>Понаехали, тут! - Циничная игра о жизни в столице</title>
<script type="text/javascript" src="/@/js/script.js"></script>
<script type="text/javascript" src="/@/js/index.js"></script>
</head>
<body id="page-index">

<div class="main-bg" align="center">
	<div class="main-block">
		<div class="main-block-topbg">

			<div id="main" class="clear">
				<div class="header clear">
					<a href="/" id="logo" style="background:none;"><img src="/@/images/logo.png" title="— Понаехали тут!" alt="— Понаехали тут!" /></a>
				</div>
				<div class="column-single" align="center">
					<div class="main-image">
						<span class="register" onclick="setCookie('register_fraction', '{preferedFraction}'); window.location.href='/play/';"></span>
						<xsl:if test="referer != ''">
							<div style="background:#fff; width: 420px; height: 80px; position: absolute; top: 172px; left: 268px; font-size: 18px; letter-spacing: -0.01ex; font-weight: bold; color:#ef5621;">
								<xsl:choose><xsl:when test="sex='male'">Злобный </xsl:when><xsl:otherwise>Злобная </xsl:otherwise></xsl:choose><span style="color:#c33d0e;"><xsl:value-of select="referer" /></span> <xsl:choose><xsl:when test="sex='male'"> заманил </xsl:when><xsl:otherwise> заманила </xsl:otherwise></xsl:choose> Вас в&#160;столичные разборки. И&#160;теперь на&#160;Вашей шее висит судьба дураков и&#160;дорог.
							</div>
						</xsl:if>
					</div>
					<div class="choose">
						<span class="resident" onclick="setCookie('register_fraction', 'resident'); window.location.href='/play/';"></span>
						<span class="vs"></span>
						<span class="arrived" onclick="setCookie('register_fraction', 'arrived'); window.location.href='/play/';"></span>
					</div>
					
					<table class="texts">
						<tr>
							<td>
								<img src="/@/images/index/2.jpg" alt="Бесплатная браузерная онлайн игра - Понаехали тут!" title="Бесплатная браузерная онлайн игра - Понаехали тут!" /><br />
								Ты&#160;узнаешь Тайну <br />империи Шаурбургерса
							</td>
							<td>
								<img src="/@/images/index/1.jpg" alt="Бесплатная браузерная игра - Понаехали тут!" title="Бесплатная браузерная игра - Понаехали тут!" /><br />
								Научишься выживать <br />в&#160;жестоком мегаполисе
							</td>
							<td>
								<img src="/@/images/index/3.jpg" alt="Браузерная игра - Понаехали тут!" title="Браузерная игра - Понаехали тут!" /><br />
								Сможешь войти в доверие<br /> кому угодно
							</td>
							<td>
								<img src="/@/images/index/4.jpg" alt="Бесплатная онлайн игра - Понаехали тут!" title="Бесплатная онлайн игра - Понаехали тут!" /><br />
								Что нашли строители <br />новой ветки метро?
							</td>
						</tr>
					</table>

					<div class="bar-login">
						<div class="corner">
							<table><tr><td class="inside">
								<form action="/" method="post">
									<input type="hidden" name="action" value="login" />
									<xsl:if test="login-error!=''">
										<div class="error"><span><xsl:value-of select="login-error" /></span></div>
									</xsl:if>
									<label for="login-email"><b>E-mail</b>: </label>
									<input type="text" name="email" id="login-email" maxlength="30" />
									&#160; &#160;
									<label for="login-password"><b>Пароль</b>: </label>

									<input type="password" name="password" id="login-password" maxlength="40" />
									&#160; &#160;
									<button type="submit" class="button">
										<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Войти</div>
										</span>
									</button>
									&#160; &#160;
									<input type="checkbox" name="remember" id="login-remember" checked="checked" />
									<label for="login-remember"> Запомнить меня</label>
									&#160; &#160;
									<a href="/auth/remind/">Забыли пароль?</a>
									&#160; &#160;
									<a href="/login/">Войти по имени</a>
								</form>
							</td></tr></table>
						</div>
					</div>
					
					<!--
					<table style="margin: 15px 0 0 0;" class="texts">
						<tr>
							<td>
								<img title="Бесплатная браузерная онлайн игра - Понаехали тут!" alt="Бесплатная браузерная онлайн игра - Понаехали тут!" src="/@/images/index/2.jpg" /><br />
								Ты&#160;узнаешь Тайну <br />империи Шаурбургерса
							</td>
							<td align="center" style="width: 50%;" rowspan="2">
								<iframe class="youtube-player" type="text/html" width="300" height="255" src="http://www.youtube.com/embed/GpqgygH8c5I" frameborder="0"></iframe>
							</td>
							<td>
								<img title="Бесплатная браузерная игра - Понаехали тут!" alt="Бесплатная браузерная игра - Понаехали тут!" src="/@/images/index/1.jpg" /><br />
								Научишься выживать <br />в&#160;жестоком мегаполисе
							</td>
						</tr>
						<tr>
							<td>
								<img title="Браузерная игра - Понаехали тут!" alt="Браузерная игра - Понаехали тут!" src="/@/images/index/3.jpg" /><br />
								Сможешь войти в доверие<br /> кому угодно
							</td>
							<td>
								<img title="Бесплатная онлайн игра - Понаехали тут!" alt="Бесплатная онлайн игра - Понаехали тут!" src="/@/images/index/4.jpg" /><br />
								Что нашли строители <br />новой ветки метро?
							</td>
						</tr>
					</table>
					<hr style="width:800px;" />
					-->

					<div class="links">
						<a href="/faq/">Вопросы и ответы</a>
						<a href="/news/">Новости</a>
						<a href="http://forum.theabyss.ru/index.php?showforum=499" target="_blank">Форум</a>
						<a href="/rating/">Рейтинг</a>
						<a href="/licence/">Условия использования</a>
						<a href="/licence/rules/">Правила общения</a>
						<!-- <a href="/support/">Контакты</a> -->
						<a href="http://vkontakte.ru/club17459738" target="_blank">Вконтакте</a>
					</div>

					<div style="padding:10px 0 0 200px; text-align:left; position:relative;">
						<table>
							<tr>
								<td width="22%" style="vertical-align:top;">
									<div class="age" style="margin:0;">
										Рекомендуемый возраст: <nobr>18—240 лет</nobr>
										<br />
										Онлайн: <b><xsl:value-of select="online" /></b><span>/</span><xsl:value-of select="registered" />
									</div>
								</td>
								<td width="45%" style="vertical-align:top;" id="buttons1"></td>
								<td width="28%" style="vertical-align:top;" id="buttons2"></td>
							</tr>
						</table>
						
						<script type="text/javascript">
							<![CDATA[
							function ButtonVkontakte(){
								if(typeof VK == "undefined") { 
									setTimeout(ButtonVkontakte,1000);
								} else {
									$("#buttons-vkontakte").html(VK.Share.button({
										url: "http://www.moswar.ru",
										title: "Понаехали тут! — Циничная игра о жизни в столице",
										description: "Коренные столичники VS Понаехавшие захватчики",
										image: "http://www.moswar.ru/@/images/logo.jpg",
										noparse: true,
										type: "round_nocount" 
									}));
									$("#vkshare0 td div div").html("Сохранить");
								}
							}
							$(document).ready(function(){
								var b1 = '<iframe scrolling="no" frameborder="0" allowtransparency="true" style="height: 64px; width: 310px;" src="http://www.facebook.com/plugins/like.php?href=http://www.moswar.ru/"></iframe>';
								var b2 = '<table style="width: 180px;" align="center">'+
										'	<tr>'+
										'		<td>'+
										'			<script type="text/javascript" src="http://vkontakte.ru/js/api/share.js?5" charset="windows-1251"></scr'+'ipt>'+
										'			<div id="buttons-vkontakte" style="height:21px;"></div>'+
										'		</td>'+
										'	</tr>'+
										'	<tr>'+
										'		<td style="vertical-align:middle; padding:2px 0;">'+
										'			<a class="mrc__share" href="http://connect.mail.ru/share?share_url=http%3A%2F%2Fwww.moswar.ru" target="_blank"><b style="padding-left:2px;">В Мой Мир</b></a>'+
										'			<script src="http://cdn.connect.mail.ru/js/share/2/share.js" type="text/javascript"></scr'+'ipt>'+
										'		</td>'+
										'	</tr>'+
										'	<tr>'+
										'		<td style="vertical-align:middle;">'+
										'			<a href="http://twitter.com/home?status=Понаехали Тут! - циничная игра о жизни в столице ;-) http://www.moswar.ru" target="_blank"><img src="/@/images/twit.png" title="Twitter" alt="Twitter" /></a>'+
										'		</td>'+
										'	</tr>'+
										'</table>';
								 
								$("#buttons1").html(b1);
								$("#buttons2").html(b2);
								ButtonVkontakte();
							});
							]]>
						</script>
						
						
						<div class="age" style="margin-top:5px;">
							<strong>Бесплатная браузерная онлайн игра</strong> «Понаехали тут!» — это новая юмористическая и очень циничная онлайн игра о тяжелой жизни в столице.
							Среди прочих браузерных игр ее выделяет интересный сюжет и квестовая система.
						</div>
						<img src="/@/images/obj/gift4.png" id="index-object-image" style="left:60px; top:30px; position:absolute;" />
					</div>
<!--
					<dl id="register-splash" class="splash" style="display:none;">
						<dt class="selected"><div><div><span id="register-splash-close" class="close">&#0215;</span><span id="registration-side">Регистрация</span></div></div></dt>
						<dd>
							<form>
							<input type="hidden" name="avatar" />
							<input type="hidden" name="background" />
							<table class="layout avatar-change">
								<tr>
									<td class="label">Выберите сторону</td>
									<td class="input" colspan="2" style="text-align:left; font-weight:bold;">
										<input type="radio" name="side" id="registration-side-resident" value="resident" style="vertical-align:bottom;" onclick="changeSide();" /><label for="registration-side-resident"><i class="resident"></i>Коренной столичник</label><br />
										<input type="radio" name="side" id="registration-side-arrived" value="arrived" style="vertical-align:bottom;" onclick="changeSide();" /><label for="registration-side-arrived"><i class="arrived"></i>Понаехавший захватчик</label>
									</td>
								</tr>
								<tr>
									<td class="label">Укажите e-mail</td>
									<td class="input"><input id="email" type="text" name="email" maxlength="32" /></td>
									<td id="email-error"><span class="error"><xsl:value-of select="email-error" /></span></td>
								</tr>
								<tr>
									<td class="label">Придумайте имя</td>
									<td class="input"><input type="text" name="name" maxlength="16" /></td>
									<td id="login-error"><span class="error"><xsl:value-of select="login-error" /></span></td>
								</tr>
								<tr>
									<td class="label">Впишите пароль</td>
									<td class="input"><input type="password" id="password" name="password" maxlength="16" /></td>
									<td id="password-error"><span class="error"><xsl:value-of select="password-error" /></span></td>
								</tr>
								<tr>
									<td class="label">Повторите пароль</td>
									<td class="input"><input type="password" id="retypepassword" maxlength="16" /></td>
									<td id="retypepassword-error"><span class="error"></span></td>
								</tr>
								<tr>
									<td class="label">Пригласительный билет (если есть)</td>
									<td class="input"><xsl:choose>
											<xsl:when test="referer != ''">
												<b><xsl:value-of select="referer" /></b>
											</xsl:when>
											<xsl:otherwise>
												<input type="text" id="invite" name="invite" maxlength="40" value="{referer}" />
											</xsl:otherwise>
										</xsl:choose></td>
									<td id="invite-error"><span class="error"><xsl:value-of select="invite-error" /></span></td>
								</tr>
								<tr>
									<td><div id="pers-arrow-1"></div></td>
									<td rowspan="2" class="pers">
										<div id="avatar-back" class="avatar-back-6"><img src="/@/images/pers/girl1_eyes.gif" style="background:url(/@/images/pers/girl1.png)" /></div>
									</td>
									<td><div id="pers-arrow-2"></div></td>
								</tr>
								<tr>
									<td><div id="pers-arrow-3"></div></td>
									<td><div id="pers-arrow-4"></div></td>
								</tr>
								<tr>
									<td></td>
									<td class="gender"><div id="avatar-gender">Пол: женский</div></td>
								</tr>
								<tr>
									<td colspan="3" class="submit">
										<p>
											<input type="checkbox" id="registration-agreement-checkbox" />
											<label for="registration-agreement-checkbox">
												Я согласен с
												<a target="_blank" href="/licence/">пользовательским соглашением</a>,
												<a target="_blank" href="/licence/game_rules/">правилами игры</a>,<br />
												<a target="_blank" href="/licence/rules/">правилами общения</a>,
												<a target="_blank" href="/licence/dogovor-oferta/">договором-офертой</a>.
											</label>
										</p>
										<div id="registration-agreement-error" class="error" style="display: none;">Необходимо Ваше согласие с правилами.</div>
										
										<span class="button" style="margin-top:5px;">
											<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Готово</div>
											</span>
										</span>
									</td>
								</tr>
							</table>
							</form>
							<script>
								<xsl:if test="mode = 'register'">
									//registerSplashShow("<xsl:value-of select="preferedFraction" />");
									//setCookie('register_fraction', '{preferedFraction}');
									//window.location.href='/play/';
								</xsl:if>
							</script>
						</dd>
					</dl>
-->
				</div>
			</div>
		</div>
	</div>
</div>

<!--
<div id="unreconstruction">
	<p><span>Вход временно закрыт. Ведутся технические работы.</span></p>
	<div class="fader"></div>
</div>
-->
<!--
<script type="text/javascript">
<![CDATA[
$(document).ready( function(){
	indexObjectImages = [
		"weapon5.png",
		"item5.png",
		"gift4.png",
		"gift35.png",
		"gift6.png",
		"clan2.png",
		"accessory1.png",
		"flag.png",
		"hat13.png",
		"weapon19.png",
		"gift50.png",
		"symbol4.png",
		"collections/6-7.png"
	];
	var i = Math.floor( Math.random( ) * (indexObjectImages.length) )
	$("#index-object-image").attr("src","/@/images/obj/"+indexObjectImages[i])
});
]]>
</script>
-->

<div align="center" class="counters clear">
	<!--LiveInternet counter--><script type="text/javascript"><![CDATA[<!--
	document.write("<a href='http://www.liveinternet.ru/click' "+
	"target=_blank><img style='margin:0 10px;' src='http://counter.yadro.ru/hit?t17.11;r"+
	escape(document.referrer)+((typeof(screen)=="undefined")?"":
	";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
	screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
	";"+Math.random()+
	"' alt='' title='LiveInternet: показано число просмотров за 24"+
	" часа, посетителей за 24 часа и за сегодня' "+
	"border='0' width='88' height='31'><\/a>")
	//-->]]></script><!--/LiveInternet-->

	<a href="http://www.ddestiny.ru" target="_blank"><img style="position:relative; top:-4px; margin:0 10px" src="/@/images/destiny-logo.png" /></a>
</div>

<script src="http://mc.yandex.ru/metrika/watch.js" type="text/javascript"></script>
<script type="text/javascript">
<![CDATA[
try { var yaCounter449953 = new Ya.Metrika(449953); } catch(e){}
]]>
</script>
<noscript><div style="position: absolute;"><img src="http://mc.yandex.ru/watch/449953" alt="" /></div></noscript>

<script type="text/javascript">
<![CDATA[
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-11575786-1");
pageTracker._setDomainName(".moswar.ru");
pageTracker._trackPageview();
} catch(err) {}
]]>
</script>


</body>
</html>
    </xsl:template>
</xsl:stylesheet>