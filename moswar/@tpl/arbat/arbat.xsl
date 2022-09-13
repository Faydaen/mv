<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
            <div class="heading clear">
                <h2>
                    Арбат
                </h2>
            </div>

            <div id="content" class="square street2">

                <table class="buttons">
                    <tr>
						<td>
							<div class="button" id="square-berezka-button">
								<a class="f" href="/berezka/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
									<div class="c">Магазин Берёзка</div>
								</a>
							</div>
						</td>
                        <td>
                            <div class="button" id="square-bank-button">
                                <a class="f" href="/bank/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                    <div class="c">Банк</div>
                                </a>
                            </div>
                        </td>
						<td>
							<div class="button" id="square-huntclub-button">
								<a class="f" href="/huntclub/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
									<div class="c">Охотничий клуб</div>
								</a>
							</div>
						</td>
                        <td>
                            <div class="button" id="square-casino-button">
                                <a class="f" href="/casino/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                    <div class="c">Казино</div>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="button" id="square-pizzeria-button">
                                <a class="f" href="/underconstruction/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                    <div class="c">Пиццерия</div>
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="welcome">
					<a href="/berezka/"><i id="square-berezka-pic" title="Магазин Берёзка"></i></a>
					<a href="/bank/"><i id="square-bank-pic" title="Банк"></i></a>
					<a href="/huntclub/"><i id="square-huntclub-pic" title="Охотничий клуб"></i></a>
                    <a href="/casino/"><i id="square-casino-pic" title="Казино"></i></a>
                    <a href="/underconstruction/"><i id="square-pizzeria-pic" title="Пиццерия"></i></a>
                </div>

                <h3 class="curves clear">
                    <table class="buttons">
                        <tr>
                            <td style="width:33%;">
                                <div class="button" id="square-pizzeria-button">
                                    <a class="f" href="/square/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">&#8592; Центральная площадь</div>
                                    </a>
                                </div>
                            </td>
                            <td style="width:67%;">
                            </td>
                        </tr>
                    </table>
                </h3>
				<table>
					<tr>
						<td style="width:50%; padding:0 5px 0 0;">
							<a name="automobile"></a>
							<div class="block-bordered">
								<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
								<div class="center clear">
									<h3>День бомбилы</h3>
									<div class="auto-bombila">
										<xsl:if test="automobile/enabled = 1"><div intitle="0" notitle="1" timer="{automobile/timer}" endtime="{automobile/endtime}" class="timeleft"></div></xsl:if>
										<p style="margin-top:0px;">Для настоящего столичника <b>Понедельник</b> — день тяжелый.
										Просыпаясь после бурных выходных неизвестно где, они просят вас подвезти их.</p>

										<xsl:choose>
											<xsl:when test="automobile/enabled = 1">
												<p>Садитесь за баранку свой тачки и подвозите попутчиков. Чем престижнее ваш автомобиль, тем интереснее попутчик.</p>
											</xsl:when>
											<xsl:otherwise>
												<p class="hint">Сегодня мало клиентов. И вы решили, что лучше всего бомбить <b>в понедельник</b>, после выходных.</p>
											</xsl:otherwise>
										</xsl:choose>

										<xsl:choose>
											<xsl:when test="playerlevel &lt; 7">
												<div class="borderdata">Вам еще рано за руль. Доберитесь до 7 уровня.</div>
											</xsl:when>
											<xsl:otherwise>
												<xsl:choose>
													<xsl:when test="automobile/process/timer = 0">
														<xsl:if test="automobile/enabled = 1">
															<xsl:choose>
																<xsl:when test="count(cars/element) = 0">
																	<p><div class="borderdata">Сначала обзаведись <a href="/automobile/">машиной</a>, пешеход.</div><br/></p>
																</xsl:when>
																<xsl:otherwise>
																	<form action="/automobile/bringup/" method="post">
																		<input type="hidden" name="car" id="car-id" value="{automobile/car/id}" />
																		<table class="action">
																			<tr>
																				<td class="car">
																					<div style="max-height:100px;">
																						<span class="object-thumb">
																							<div class="car-place">
																								<xsl:if test="automobile/car/cooldown/end != 0">
																									<span class="timeout" tooltip="1" title="Машина в сервисе||Машина на техосмотре после поездки. Воспользоваться ею можно будет через некоторое время.">
																										<i class="icon-locked-small"></i><br />
																										<span intitle="0" notitle="1" class="car-cooldown" trigger="automobileBringUpCheck();" timer="{automobile/car/cooldown/rest}" endtime="{automobile/car/cooldown/end}"></span>
																									</span>
																								</xsl:if>
																								<a href="/automobile/car/{automobile/car/id}">
																									<img src="{automobile/car/image}.png" tooltip="1">
																										<xsl:attribute name="title"><xsl:value-of select="automobile/car/name" />||<xsl:value-of select="automobile/car/description" disable-output-escaping="yes" /><xsl:value-of select="automobile/car/stats" disable-output-escaping="yes" /></xsl:attribute>
																									</img>
																								</a>
																							</div>
																						</span>
																						<xsl:if test="count(cars/element) &gt; 1"><br /><div><span class="dashedlink" onclick="$('#cars-trip-choose').toggle();">Выбрать другую тачку</span></div></xsl:if>
																					</div>
																				</td>
																				<td>
																					<button type="submit">
																						<xsl:choose>
																							<xsl:when test="automobile/car/cooldown/end != 0 or automobile/complete = 1">
																								<xsl:attribute name="class">button ride-button disabled</xsl:attribute>
																								<xsl:attribute name="disabled">disabled</xsl:attribute>
																								<xsl:if test="automobile/complete = 1">
																									<xsl:attribute name="complete">complete</xsl:attribute>
																								</xsl:if>
																							</xsl:when>
																							<xsl:otherwise>
																								<xsl:attribute name="class">button ride-button</xsl:attribute>
																							</xsl:otherwise>
																						</xsl:choose>
																						<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																							<div class="c">Бомбить - <span class="ride-time"><xsl:value-of select="automobile/car/time" /></span></div>
																						</span>
																					</button>
																					<i class="question-icon" tooltip="1" title="Шеф, подбрось!||Время в пути за висит от &lt;b&gt;Скорости&lt;/b&gt;, &lt;b&gt;Проходимости&lt;/b&gt; и &lt;b&gt;Управляемости&lt;/b&gt; вашей тачки. А чем выше &lt;b&gt;Престиж&lt;/b&gt;, тем больше баллов за попутчика."></i>
																				</td>
																			</tr>
																		</table>
																	</form>
																</xsl:otherwise>
															</xsl:choose>
														</xsl:if>
													</xsl:when>
													<xsl:otherwise>
														<table class="process">
															<tr>
																<td class="label">В пути:</td>
																<td class="progress"><div class="exp"><div class="bar"><div><div class="percent" id="cooldownbar" style="width: 0%;"></div></div></div></div></td>
																<td id="cooldown" intitle="0" notitle="1" timer="{automobile/process/timer}" timer2="{automobile/process/total}" endtime="{automobile/process/endtime}" class="value"></td>
															</tr>
														</table>
													</xsl:otherwise>
												</xsl:choose>
												<table class="collectbar">
													<tr>
														<td class="stars">
															<span style="cursor:pointer;" class="icon icon-star-{automobile/prize1}"></span>
															<span style="cursor:pointer;" class="icon icon-star-{automobile/prize2}"></span>
															<span style="cursor:pointer;" class="icon icon-star-{automobile/prize3}"></span>
														</td>
														<td class="progress">
															<div class="textbar">
																<div class="percent" id="" style="width:{automobile/count/percent}%;"></div>
																<div class="num">Баллов набрано: <b><xsl:value-of select="automobile/count/current" /></b> из <b><xsl:value-of select="automobile/count/max" /></b></div>
															</div>
														</td>
														<td class="actions">
															<form method="post" action="/automobile/bringupbonus/">
																<button class="button" type="submit">
																	<xsl:choose>
																		<xsl:when test="automobile/prize = 0">
																			<xsl:attribute name="class">button disabled</xsl:attribute>
																			<xsl:attribute name="disabled">disabled</xsl:attribute>
																		</xsl:when>
																		<xsl:otherwise>
																			<xsl:attribute name="class">button</xsl:attribute>
																		</xsl:otherwise>
																	</xsl:choose>
																	<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																		<div class="c">Бонус<i class="loot-icon"></i></div>
																	</span>
																</button>
															</form>
														</td>
													</tr>
												</table>
											</xsl:otherwise>
										</xsl:choose>
									</div>
								</div>
								<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
							</div>
						</td>
						<td style="width:50%; padding:0 0 0 5px;">
							<div class="block-bordered">
								<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
								<div class="center clear">
									<h3>Пирамида WWW</h3>
									<div class="square-pyramid">
										<p>
											<img src="/@/images/pers/man116_thumb.png" align="right" />Великий комбинатор отсидел в тюрьме и&#160;взялся за старое.
											Его новая пирамида обещает перевернуть всю мировую экономику.
											Но&#0160;большинство скептиков уверены, что <b>пирамида обязательно рухнет, и многие вкладчики останутся обманутыми.</b>
										</p>
										<p align="center">
											<button class="button" type="button" onclick="document.location.href='/pyramid/';">
												<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">
														Войти в пирамиду
													</div>
												</span>
											</button>
										</p>
									</div>
								</div>
								<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
							</div>
						</td>
					</tr>
				</table>
				<div id="cars-trip-choose" class="alert" style="display:none;">
					<div class="padding">
						<h2 id="alert-title">Выберите тачку для поездки</h2>
						<div class="data clear">
							<div class="objects">
								<xsl:for-each select="cars/element">
									<span class="object-thumb" level="{level}" time="{time}" carid="{id}">
										<div class="car-place">
											<xsl:if test="cooldown/end != 0">
												<span class="timeout" tooltip="1" title="Машина в сервисе||Машина на техосмотре после поездки. Воспользоваться ею можно будет через некоторое время." tip="Машина в сервисе||Машина на техосмотре после поездки. Воспользоваться ею можно будет через некоторое время.">
													<i class="icon-locked-small"></i><br /><span class="car-cooldown" intitle="0" notitle="1" timer="{cooldown/rest}" endtime="{cooldown/end}"></span>
												</span>
											</xsl:if>
											<a href="/automobile/car/{id}">
											<img src="{image}.png" tooltip="1">
												<xsl:attribute name="title"><xsl:value-of select="name" />||<xsl:value-of select="description" disable-output-escaping="yes" /><xsl:value-of select="stats" disable-output-escaping="yes" /></xsl:attribute>
												<xsl:attribute name="tip"><xsl:value-of select="name" />||<xsl:value-of select="description" disable-output-escaping="yes" /><xsl:value-of select="stats" disable-output-escaping="yes" /></xsl:attribute>
											</img>
											</a>
										</div>
									</span>
								</xsl:for-each>
							</div>
							<div class="actions">
								<button class="button" type="button" onclick="$(this).parents('div.alert:first').hide();">
									<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Закрыть</div></span>
								</button>
							</div>
						</div>
					</div>
					<span class="close-cross" onclick="$(this).parents('div.alert:first').hide();">&#215;</span>
				</div>

				<script type="text/javascript" src="/@/js/arbat.js"></script>
                <script type="text/javascript">
                $("#square-berezka-button").bind("mouseover",function(){ $("#square-berezka-pic").addClass("hover"); });
                $("#square-berezka-button").bind("mouseout",function(){ $("#square-berezka-pic").removeClass("hover"); });
                $("#square-bank-button").bind("mouseover",function(){ $("#square-bank-pic").addClass("hover"); });
                $("#square-bank-button").bind("mouseout",function(){ $("#square-bank-pic").removeClass("hover"); });
                $("#square-huntclub-button").bind("mouseover",function(){ $("#square-huntclub-pic").addClass("hover"); });
                $("#square-huntclub-button").bind("mouseout",function(){ $("#square-huntclub-pic").removeClass("hover"); });
                $("#square-casino-button").bind("mouseover",function(){ $("#square-casino-pic").addClass("hover"); });
                $("#square-casino-button").bind("mouseout",function(){ $("#square-casino-pic").removeClass("hover"); });
                $("#square-pizzeria-button").bind("mouseover",function(){ $("#square-pizzeria-pic").addClass("hover"); });
                $("#square-pizzeria-button").bind("mouseout",function(){ $("#square-pizzeria-pic").removeClass("hover"); });
                </script>

            </div>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>