<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" />
	
    <xsl:include href="common/price.xsl" />

    <xsl:template match="/data">
					<div class="column-right-topbg">
						<div class="column-right-bottombg" align="center">
							<div class="heading clear"><h2>
								<span class="stash"></span>
							</h2></div>
							<div id="content" class="stash">
							
								<div style="float:right; width:140px; text-align:center;">
									<img src="/@/images/pers/man101.png" style="margin-bottom:50px" />
									<!--
									<br />
									<a href="http://www.webmoney.ru/" target="_blank"><img src="http://www.megastock.ru/Doc/88x31_accept/brown_rus.gif" alt="www.webmoney.ru" border="0" /></a>
									-->
								</div>
								
								<div  style="margin-right:150px">
									<div class="stash-about">
										<div class="block-rounded">
											<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
											Любой, даже самый глупый американец, знает, что по нашим улицам разгуливают медведи с бубенцами.
											И, чтобы выжить в диких городских условиях и раздобрить косолапых, каждому из нас приходится иметь при себе баночку меда.
											Он нужен всем, и можно даже сказать, что мед — это универсальная валюта.
										</div>
									</div>
									<table>
										<!--
										<tr>
											<td colspan="2">
												<div class="block-bordered">
													<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
													<div class="center clear">
														<h3 style="color:red;">Ваш персонаж депортирован</h3>
														<div class="stash-block">
															<p><b>Причина: по собственному желанию</b></p>
															<p> 
																Депортированные персонажи не могут принимать участия в игре. <br />
																Но иногда, существует возможность вернуться в игру уплатив немного мёда.<br />Подробнее о <a href="/licence/dopolnitelnyeuslugi/">дополнительных услугах</a>.
															</p>
															<div align="center">
																<button class="button" onclick="">
																	<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																		<div class="c">Вернуть меня в игру - <span class="med">100<i></i></span></div>
																	</span>
																</button>
															</div>
															
														</div>
													</div>
													<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
												</div>
											</td>
										</tr>
										-->
										<tr>
											<td style="width:50%; padding:0 5px 0 0;">
												<div class="block-bordered">
													<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
													<div class="center clear">
														<h3>Мажор</h3>
														<div class="stash-major">
															<blockquote>
																Раскройте рты, сорвите уборы<br />По улице чешут мальчики-мажоры<br />© Шевчук
															</blockquote>
															<br clear="all" />
															<p>Преимущественные возможности мажора:</p>
															<ul>
																<li><b>Торопыжка:</b> бои раз в 5 минут</li>
																<li><b>Ищейка:</b> поиск противников по уровню</li>
																<li><b>240 минут в день:</b> удвоенное время патрулирования</li>
																<li><b>Бонус: </b><span class="tugriki"><xsl:value-of select="bonus" /><i></i></span></li> <!-- Цифра равна левелной зарплате в шаурбургерсе * 24 часа -->
																<li><b>Подарок:</b> Пяни</li>
																<li><b>Скидки:</b> продление статуса — всего <span class="med">17<i></i></span> (во время активного мажорства)</li>
															</ul>
															<div align="center">
																<xsl:choose>
																	<xsl:when test="player/playboy = 1">
																		<p>Ваш статус мажора закончится <xsl:value-of select="datetime" />.</p>
																		<xsl:element name="div">
																			<xsl:choose>
																				<xsl:when test="player/honey >= 17">
																					<xsl:attribute name="class">button</xsl:attribute>
																					<a class="f" href="/stash/becomemajor/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																						<div class="c">Продлить на 14 дней — <xsl:call-template name="showprice"><xsl:with-param name="honey" select="'17'" /></xsl:call-template></div>
																					</a>
																				</xsl:when>
																				<xsl:otherwise>
																					<xsl:attribute name="class">button disabled</xsl:attribute>
																					<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																						<div class="c">Продлить на 14 дней — <xsl:call-template name="showprice"><xsl:with-param name="honey" select="'17'" /></xsl:call-template></div>
																					</span>
																				</xsl:otherwise>
																			</xsl:choose>
																		</xsl:element>
																	</xsl:when>
																	<xsl:otherwise>
																		<xsl:element name="div">
																			<xsl:choose>
																				<xsl:when test="player/honey >= 22">
																					<xsl:attribute name="class">button</xsl:attribute>
																					<a class="f" href="/stash/becomemajor/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																						<div class="c">Стать мажором на 14 дней — <xsl:call-template name="showprice"><xsl:with-param name="honey" select="'22'" /></xsl:call-template></div>
																					</a>
																				</xsl:when>
																				<xsl:otherwise>
																					<xsl:attribute name="class">button disabled</xsl:attribute>
																					<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																						<div class="c">Стать мажором на 14 дней — <xsl:call-template name="showprice"><xsl:with-param name="honey" select="'22'" /></xsl:call-template></div>
																					</span>
																				</xsl:otherwise>
																			</xsl:choose>
																		</xsl:element>
																	</xsl:otherwise>
																</xsl:choose>
																<xsl:if test="count(major_cert) = 1">
																	<br /><br />
																	<a name="cert_major_3d"></a>
																	<h3>Сертификат мажорика</h3>
																	<p>Являясь счастливым обладателем Сертификата мажорика, вы можете <b>бесплатно</b> получить статус мажора сроком на <xsl:value-of select="major_cert/time" /> дня.</p>
																	<div class="button">
																		<a class="f" href="/stash/usecert/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																			<div class="c">Стать мажором</div>
																		</a>
																	</div>
																</xsl:if>
															</div>
														</div>
													</div>
													<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
												</div>
												
												<div class="block-bordered">
													<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
													<div class="center clear">
														<h3>Разменять</h3>
														<script>
															var exchangeRate = <xsl:value-of select="exchange_rate" />;
															<![CDATA[
															var stashChangeRate = function (){
																$("#stash-change-med").val($("#stash-change-med").val().replace(/[^\d]/, ''));
																$("#stash-change-coins").html(Number($("#stash-change-med").val() * exchangeRate)||0);
															}
															$(document).ready(function(){
																stashChangeRate();
																$("#stash-change-med").bind("change",stashChangeRate).bind("blur",stashChangeRate).bind("keyup",stashChangeRate);
															});
														]]>
														</script>
														<form class="stash-change" action="/stash/change/" method="post">
															<input type="hidden" name="post_key" value="{post_key}" />
															<p style="margin-top:0;">Уличные менялы всегда готовы поменять <span class="med"><i></i>мёд</span> на <span class="tugriki"><i></i>монеты</span>.</p>
															<xsl:if test="action = 'change'">
															<xsl:choose>
																<xsl:when test="result = '0' and error = 'no money'">
																	<p class="error">У вас не хватает мёда для такого обмена.</p>
																</xsl:when>
																<xsl:when test="result = '0' and error = 'post_key'">
																	<p class="error">Вы уверены?</p>
																</xsl:when>
																<xsl:when test="result = '0' and error = 'empty'">
																</xsl:when>
																<xsl:when test="result = '1'">
																	<p class="success">Вы успешно обменяли <span class="med"><xsl:value-of select="params/honey" /><i></i></span> на <span class="tugriki"><xsl:value-of select="params/money" /><i></i></span>.</p>
																</xsl:when>
															</xsl:choose>
															</xsl:if>
															<p><span class="med"><input type="text" size="3" value="1" id="stash-change-med" name="honey" /><i></i></span> = <span class="tugriki"><span id="stash-change-coins"><xsl:value-of select="exchange_rate" /></span><i></i></span></p>
															<p>
																<button class="button" type="submit">
																	<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																		<div class="c">Разменять</div>
																	</span>
																</button>
															</p>
															
															<xsl:choose>
																<xsl:when test="player_level > 2">
																	<p style="margin-top:0;">На следующем уровне вы сможете поменять <span class="med">1<i></i>мёд</span> на <span class="tugriki"><xsl:value-of select="exchange_rate_next_level" /><i></i>монет</span>.</p>
																</xsl:when>
																<xsl:otherwise>
																	<p style="margin-top:0;">На 4 уровне вы сможете поменять <span class="med">1<i></i>мёд</span> на <span class="tugriki">120<i></i>монет</span>.</p>
																</xsl:otherwise>
															</xsl:choose>
															
															
														</form>
													</div>
													<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
												</div>
											</td>
											<td style="width:50%; padding:0 0 0 5px;">
												<div class="block-bordered">
													<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
													<div class="center clear">
														<h3>Медовая заначка</h3>
														<form class="stash-buy" method="post" id="stash-buy-form">
															<p>Способ добычи:
															<select name="type" id="stash-buy-select">
                                                                <option value="mobile">Мобильный платеж +40% бонус</option>
                                                                <option value="webmoney">WebMoney +40% бонус</option>
                                                                <option value="yandex">Яндекс.Деньги +40% бонус</option>
																<option value="onlinedengi">ДеньгиОнлайн +40% бонус</option>
                                                                <option value="rbk">RBK Money +40% бонус</option>
                                                                <option value="qiwi">Терминалы QIWI +40% бонус</option>
                                                                <option value="sms">SMS</option>
															</select>
															<script type="text/javascript">
															$("#stash-buy-select").bind("change", function(){
																if("visa" == this.value) { $("#stash-buy-form").bind("submit",StashBuyVisa); }
																else { $("#stash-buy-form").unbind("submit",StashBuyVisa); }
															});
															</script>
															</p>
															<button  class="button" type="submit">
																<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																	<div class="c">Добыть мед</div>
																</span>
															</button>
															<p>От 30 рублей за <span class="med">7<i></i></span>, а также <b style="color:green">скидки и бонусы</b></p>
														</form>

														<!--
                                                        <h3>Другие способы</h3>
														<form class="stash-buy" method="post">
	                                                        <p align="left">
																<a target="_blank"><xsl:attribute name="href">https://2pay.ru/oplata/?id=2314&amp;v1=<xsl:value-of select="player/id" />&amp;v2=&amp;v3=&amp;page=3021&amp;country=0</xsl:attribute><img align="left" style="padding:0 5px 5px 0;" src="/@/images/2paylogo.png" /></a>
	                                                            При помощи системы 2pay.ru вы можете оплатить покупку мёда через терминалы, при помощи Яндекс.Денег, пластиковой карты или множеством других способов.
	                                                        </p>
	                                                        <p>
	                                                            <a target="_blank"><xsl:attribute name="href">https://2pay.ru/oplata/?id=2314&amp;v1=<xsl:value-of select="player/id" />&amp;v2=&amp;v3=&amp;page=3021&amp;country=0</xsl:attribute>Перейти на страницу оплаты</a>
	                                                        </p>
														</form>
                                                        -->
													</div>
													<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
												</div>
													
												<div class="block-bordered">
													<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
													<div class="center clear">
														<h3>Пригласите и научите друзей</h3>
														<div class="stash-invite">
															Пригласите в игру своих друзей, и они станут вашими учениками. И, если вы хороший сэнсэй-учитель, вы получите <span class="ruda">1<i></i></span> за каждый взятый ими уровень, начиная с 3-го.
															<p><b>Разошлите эту ссылку своим друзьям:</b>
															<input onclick="this.select()" value="http://www.moswar.ru/register/{player/id}/" /></p>
															<p class="total">
																Учеников: <xsl:value-of select="referers" />
															</p>														
															<p>Когда у вас будет 30 учеников, докачавшихся до 3-го уровня, мэрия города даст вам справку на бесплатную регистрацию клана.</p>
														</div>
														<h3><span class="dashedlink" onclick="stashInviteSocial()">Поделись ссылкой с друзьями</span></h3>
														<div class="stash-invite" id="stash-invite" style="display:none;"></div>
													</div>
													<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
												</div>
												<script type="text/javascript">
													<![CDATA[
													function ButtonVkontakte(){
														if(typeof VK == "undefined") { 
															setTimeout(ButtonVkontakte,1000);
														} else {
															$("#buttons-vkontakte").html(VK.Share.button({
																url: "http://www.moswar.ru/register/]]><xsl:value-of select="player/id" /><![CDATA[",
																title: "Понаехали тут! — Циничная игра о жизни в столице",
																description: "Коренные столичники VS Понаехавшие захватчики",
																image: "http://www.moswar.ru/@/images/logo.jpg",
																noparse: true,
																type: "round_nocount" 
															}));
															$("#vkshare0 td div div").html("Сохранить");
														}
													}
													function stashInviteSocial(){
														if( $("#stash-invite").is(":visible") ){
															$("#stash-invite").hide();
														} else {
															$("#stash-invite").show();
															if( "" == $("#stash-invite").html() ){
																var html = 	'<table style="width: 180px;" align="center">'+
																			'	<tr>'+
																			'		<td style="padding:1px 0;">'+
																			'			<script type="text/javascript" src="http://vkontakte.ru/js/api/share.js?5" charset="windows-1251"></scr'+'ipt>'+
																			'			<div id="buttons-vkontakte" style="height:21px;"></div>'+
																			'		</td>'+
																			'		<td rowspan="4">'+
																			'			<a title="Написать в Google Buzz" class="google-buzz-button" href="http://www.google.com/buzz/post" '+
																			'			data-button-style="normal-count" data-url="www.moswar.ru/register/]]><xsl:value-of select="player/id" /><![CDATA["'+
																			'			data-message="Понаехали тут! — Циничная игра о жизни в столице"'+
																			'			data-imageurl="http://www.moswar.ru/@/images/logo.png" target="_blank"></a>'+
																			'			<script type="text/javascript" src="http://www.google.com/buzz/api/button.js"></scr'+'ipt>'+
																			'		</td>'+
																			'	</tr>'+
																			'	<tr>'+
																			'		<td style="padding:1px 0;">'+
																			'			<meta name="mrc__share_title" content="Понаехали тут! — Циничная игра о жизни в столице" /> '+
																			'			<meta name="mrc__share_description" content="Коренные столичники VS Понаехавшие захватчики" /> '+
																			'			<link rel="image_src" href="http://www.moswar.ru/@/images/logo.png" />'+
																			'			<a class="mrc__share" href="http://connect.mail.ru/share?share_url=http%3A%2F%2Fmoswar.ru/register/]]><xsl:value-of select="player/id" /><![CDATA[" target="_blank">Мой Мир</a>'+
																			'			<script src="http://cdn.connect.mail.ru/js/share/2/share.js" type="text/javascript"></scr'+'ipt>'+
																			'		</td>'+
																			'	</tr>'+
																			'	<tr>'+
																			'		<td style="padding:1px 0;">'+
																			'			<a name="fb_share" type="button_count" share_url="http://www.moswar.ru/register/]]><xsl:value-of select="player/id" /><![CDATA[" href="http://www.facebook.com/sharer.php" target="_blank">Facebook</a>'+
																			'			<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></scr'+'ipt>'+
																			'		</td>'+
																			'	</tr>'+
																			'	<tr>'+
																			'		<td style="padding:1px 0;">'+
																			'			<a href="http://twitter.com/home?status=Понаехали Тут! - циничная игра о жизни в столице ;-) http://www.moswar.ru/register/]]><xsl:value-of select="player/id" /><![CDATA[" target="_blank"><img src="/@/images/twit.png" title="Twitter" alt="Twitter" /></a>'+
																			'		</td>'+
																			'	</tr>'+
																			'</table>';
																 
																$("#stash-invite").html(html);
																ButtonVkontakte();
															}
														}
													}
													]]>
												</script>

											</td>
										</tr>
									</table>
									
								</div>

							</div>
						</div>
					</div>
    </xsl:template>
</xsl:stylesheet>
