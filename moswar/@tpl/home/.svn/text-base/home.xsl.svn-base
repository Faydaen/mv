<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>
	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>
						<span class="home"></span>
					</h2>
				</div>
				<div id="content" class="home">

								
					<div class="welcome">
						<xsl:if test="player/is_home_available = 0">
							<xsl:choose>
								<xsl:when test="player/level &lt; 3">
									<div class="block-rounded">
										<i class="tlc"></i>
										<i class="trc"></i>
										<i class="blc"></i>
										<i class="brc"></i>
										<div class="text">
													У тебя еще нет своей хаты. Все впереди.
										</div>
									</div>
								</xsl:when>
								<xsl:otherwise>
									<div class="block-rounded">
										<i class="tlc"></i>
										<i class="trc"></i>
										<i class="blc"></i>
										<i class="brc"></i>
										<div class="text">
													Чтобы получить хату, надо всё-таки взломать чемоданчик. Пожалуй для этого подойдет
											<a href="/shop/section/weapons/">гаечный ключ</a>.
										</div>
									</div>
								</xsl:otherwise>
							</xsl:choose>
						</xsl:if>
					</div>
								
					<xsl:if test="player/is_home_available = 1">
						<div class="block-rounded">
							<i class="tlc"></i>
							<i class="trc"></i>
							<i class="blc"></i>
							<i class="brc"></i>

							<table>
								<tr>
												<td style="width:48%; text-align:center;">
										<div class="home-slots">
											<h3>Домашняя обстановка</h3>
											<xsl:for-each select="homeInventory/element">
												<xsl:choose>
													<xsl:when test="name != ''">
														<xsl:choose>
															<xsl:when test="type = 'home_safe'">
															</xsl:when>
															<xsl:otherwise>
																<img src="/@/images/obj/{image}" title="{name}||{info}|||{param}: +{value}" tooltip="1" style="background: url(/@/images/ico/gift.png);" />
															</xsl:otherwise>
														</xsl:choose>
													</xsl:when>
													<xsl:otherwise>
														<img src="/@/images/ico/gift.png" />
													</xsl:otherwise>
												</xsl:choose>
											</xsl:for-each>
											<div class="hint">
															Домашнюю обстановку можно улучшить в
												<a href="/shop/section/home/">торговом центре</a>
											</div>
										</div>
									</td>
												<td style="width:16%; text-align:center;">
													<div class="home-slots-safe">
														<h3>Сейф</h3>
														<span class="object-thumb">
															<div class="padding">
																<xsl:if test="count(home_safe)">
																	<img src="/@/images/obj/{home_safe/image}" title="{home_safe/name}||{home_safe/info}|||{home_safe/param}: {home_safe/value}|{home_safe/param_period}: {home_safe/value_period}" tooltip="1" />
																</xsl:if>
															</div>
														</span>
													</div>
												</td>
												<td style="width:36%; padding-left:10px">
										<div class="home-stats">
											<h3>Параметры хаты</h3>
											<ul class="stats">
												<li class="stat odd">

													<div class="label">
														<b>Защита</b>
														<span class="num">
															<xsl:value-of select="player/home_defence" />
														</span>
													</div>
													<div class="bar">
														<div>
															<div class="percent" style="width:{procenthomedefence}%;"></div>
														</div>
													</div>
												</li>
												<li class="stat">
													<div class="label">
														<b>Комфорт</b>
														<span class="num">
															<xsl:value-of select="player/home_comfort" />
														</span>
													</div>
													<div class="bar">
														<div>
															<div class="percent" style="width:{procenthomecomfort}%;"></div>
														</div>
													</div>
												</li>

											</ul>
											<div class="hint">
															Дома и стены помогают. Крепкий тыл хаты влияет на вашу защиту, если на вас напали.
											</div>

										</div>

									</td>
								</tr>
							</table>

						</div>


						<table class="inventary">
							<tr>
								<td style="width:50%; padding:0 5px 0 0;">

									<div class="block-bordered">
										<ins class="t l">
											<ins></ins>
										</ins>
										<ins class="t r">
											<ins></ins>
										</ins>
										<div class="center clear">
											<h3>Аптечка</h3>
											<form class="home-medicine">
												<xsl:if test="heal-message!=''">
													<p style="text-align:center;">
														<b>
															<xsl:value-of select="heal-message" />
														</b>
													</p>
												</xsl:if>
												<p>Бинт и зеленка помогут в считанные секунды восстановить ваше здоровье.</p>
												<div class="button" onclick="document.location.href='/home/heal/';">
													<span class="f">
														<i class="rl"></i>
														<i class="bl"></i>
														<i class="brc"></i>
														<div class="c">Вылечиться —
															<span class="tugriki">
																<xsl:value-of select="heal_cost" />
																<i></i>
															</span>
														</div>
													</span>
												</div>
											</form>

										</div>
										<ins class="b l">
											<ins></ins>
										</ins>
										<ins class="b r">
											<ins></ins>
										</ins>
									</div>
												
									<xsl:if test="travma = 1">
										<div class="block-bordered">
											<ins class="t l">
												<ins></ins>
											</ins>
											<ins class="t r">
												<ins></ins>
											</ins>
											<div class="center clear">
												<h3>Лечение травм</h3>
												<form class="home-medicine">
													<p>У вас травма и вы не можете драться. Либо отдохните 12 часов, либо воспользуйтесь
                                                                чудодейственным отваром лечебных трав.
													</p>
													<div class="button">
														<a class="f" href="/home/travma/">
															<i class="rl"></i>
															<i class="bl"></i>
															<i class="brc"></i>
															<div class="c">Вылечиться —
																<span class="med">5
																	<i></i>
																</span>
															</div>
														</a>
													</div>
												</form>
											</div>
											<ins class="b l">
												<ins></ins>
											</ins>
											<ins class="b r">
												<ins></ins>
											</ins>
										</div>
									</xsl:if>
												
									<div class="block-bordered">
										<ins class="t l">
											<ins></ins>
										</ins>
										<ins class="t r">
											<ins></ins>
										</ins>
										<div class="center clear">
											<h3>Сдавать комнату</h3>

											<form class="home-rent">
												<p>А что это у вас одна комната пустует? Сдавайте ее в аренду какой-нибудь студентке. «Дополнительный заработок не помешает», — подумали вы и стали сдавать комнату.</p>
												<p class="profit">
																Текущий доход: 
													<span class="tugriki">
														<xsl:value-of select="player/home_income" />
														<i></i>
													</span> в час
                                                                <!--xsl:if test="player/level > 5 and player/level &lt; 9"><br />+<span class="tugriki">100<i></i></span> в час компенсация</xsl:if-->
                                                                <!--xsl:if test="player/level > 8"><br />+<span class="tugriki">380<i></i></span> в час компенсация</xsl:if-->
												</p>
												<p class="hint">Комната будет сдаваться
													<b>автоматически</b> с 3-го уровня.
															Чем выше комфорт хаты, тем дороже вы можете сдавать комнату.
												</p>

											</form>
										</div>
										<ins class="b l">
											<ins></ins>
										</ins>
										<ins class="b r">
											<ins></ins>
										</ins>
									</div>

									<xsl:if test="clearrabbits > 0">
										<div class="block-bordered">
											<ins class="t l">
												<ins></ins>
											</ins>
											<ins class="t r">
												<ins></ins>
											</ins>
											<div class="center clear">
												<h3>Удаление негативных эффектов</h3>
												<form class="home-medicine" action="/home/clearrabbits/" method="post">
													<input type="hidden" name="player" value="{player/id}" />
													<img src="/@/images/obj/antigift.png" align="left" />
													<p>Вам подарили один или несколько подарков с негативными эффектами. Эти эффекты сами спадут через
                                                                несколько часов. Но если вы не желаете их терпеть, и хотите, чтобы прямо сейчас стало сухо и комфортно,
                                                                то вы можете их удалить.
													</p>
													<button class="button" type="submit">
														<span class="f">
															<i class="rl"></i>
															<i class="bl"></i>
															<i class="brc"></i>
															<div class="c">Очиститься —
																<span class="med">
																	<xsl:value-of select="clearrabbits" />
																	<i></i>
																</span>
															</div>
														</span>
													</button>
												</form>
											</div>
											<ins class="b l">
												<ins></ins>
											</ins>
											<ins class="b r">
												<ins></ins>
											</ins>
										</div>
									</xsl:if>

									<div class="block-bordered">
										<ins class="t l">
											<ins></ins>
										</ins>
										<ins class="t r">
											<ins></ins>
										</ins>
										<div class="center clear">
											<h3>Защита от зайцев</h3>
											<xsl:choose>
												<xsl:when test="antirabbit = 1">
													<form class="home-medicine">
														<img src="/@/images/obj/antigift2.png" align="left" />
														<p>Защита от подарков с негативными эффектами включена до
															<xsl:value-of select="antirabbitdt" />.
														</p>
													</form>
												</xsl:when>
												<xsl:otherwise>
													<form class="home-medicine" action="/home/antirabbit/" method="post" id="anti-form">
														<input type="hidden" name="player" value="{player/id}" />
														<img src="/@/images/obj/antigift2.png" align="left" />
														<p>Если вы хотите, чтобы другие игроки не могли вам дарить подарки с негативными эффектами,
                                                                    то вы можете защититься, заплатив почтальону за проверку входящих посылок.
														</p>
														<div align="center">
															<p style="text-align:center;">
																<button class="button" type="submit" onclick="$('#anti-form')[0].action = '/home/antirabbit/3/';">
																	<span class="f">
																		<i class="rl"></i>
																		<i class="bl"></i>
																		<i class="brc"></i>
																		<div class="c">Защита на 3 дня —
																			<span class="med">10
																				<i></i>
																			</span>
																		</div>
																	</span>
																</button>
															</p>
															<button class="button" type="submit" onclick="$('#anti-form')[0].action = '/home/antirabbit/7/';">
																<span class="f">
																	<i class="rl"></i>
																	<i class="bl"></i>
																	<i class="brc"></i>
																	<div class="c">Защита на 7 дней —
																		<span class="med">25
																			<i></i>
																		</span>
																	</div>
																</span>
															</button>
														</div>
													</form>
												</xsl:otherwise>
											</xsl:choose>
										</div>
										<ins class="b l">
											<ins></ins>
										</ins>
										<ins class="b r">
											<ins></ins>
										</ins>
									</div>

                                              

								</td>
								<td style="width:50%; padding:0 0 0 5px;">

                                                <!--
												<div class="block-bordered">
													<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
													<div class="center clear">
														<h3>Тренажер</h3>

														<form class="home-trainer">
															<p>Как-то вы вяло выглядите. Тренажер поможет и мышцы накачать и мысли в порядок привести.</p>
															<div class="button" onclick="document.location.href='/trainer/';">
																<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																	<div class="c">Потренироваться</div>
																</span>
															</div>
														</form>

													</div>
													<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
												</div>
												-->
												
									<xsl:if test="1">
										<div style="width:312px;">
											<dl class="vtabs">
												<dt class="selected active">
													<div>
														<div>Полка коллекций</div>
													</div>
												</dt>
												<dd>
													<div class="about">
														<p>
																	Каждый седьмой житель планеты увлекается коллекционированием.
															<span class="dashedlink" onclick="$('#home-collections-about-description').toggle();">Подробнее</span>
														</p>
														<p id="home-collections-about-description" style="display:none;">
																	Это хобби объединяет людей разных возрастов и статусов. От мальчишки с пачкой стикеров Спайдермена до коллекционера спортивных автомобилей — все они с блеском в глазах движутся в поисках новых открытий.
															<br />
															<br />
																	Соберите любую коллекцию и получите причитающийся бонус. Элементы коллекции могут попасться вам в совершенно необычных местах: на работе, в патруле, в боях или в метро.
																	Однако остерегайтесь квартирных взломщиков, которые впопыхах уносят что-нибудь случайное.
														</p>
													</div>
													<div class="object-thumbs">
														<xsl:for-each select="collections/element">
															<div class="object-thumb">
																<div class="padding">
																	<a href="/home/collection/{id}/">
																		<img src="/@/images/obj/collections/{image}" title="{name}" alt="{name}"  />
																	</a>
																	<xsl:if test="progress > 0">
																		<div class="count">
																			<xsl:value-of select="progress" />%
																		</div>
																	</xsl:if>
																	<div class="action">
																		<span onclick="document.location.href='/home/collection/{id}/';">смотреть</span>
																	</div>
																</div>
															</div>
														</xsl:for-each>
														<xsl:if test="count(collections/element) = 0">
															<div class="empty">К сожалению, вы только встали на путь коллекционера и еще не успели заполнить свою коллекцию хотя бы одним экспонатом.</div>
														</xsl:if>
													</div>
													<div class="hint">
																— У вас не будет двух копеек, позвонить из будки?
														<br />
																— Вам какого года?
													</div>
												</dd>
											</dl>
										</div>

									</xsl:if>

									<xsl:choose>
										<xsl:when test="garage = 0">
											<div class="block-bordered">
												<ins class="t l">
													<ins></ins>
												</ins>
												<ins class="t r">
													<ins></ins>
												</ins>
												<div class="center clear">
													<h3>Аллё, гараж?</h3>
													<form class="home-garage-buy" method="post" action="/automobile/upgradegarage/">
														<p>
															<img src="/@/images/obj/cars/1.png" align="left" style="margin:0 11px 0 0" />Представьте, как приятно сесть за руль любимого автомобиля и отправиться в путешествие.
															Но перед заведением своего автомобиля, необходимо купить гараж во дворе своего дома.
														</p>
														<div style="text-align:center">
															<button class="button" type="submit" onclick="$(this).parents('div.alert:first').hide();">
																<span class="f">
																	<i class="rl"></i>
																	<i class="bl"></i>
																	<i class="brc"></i>
																	<xsl:if test="player/level &gt; 4">
																		<div class="c">Купить гараж -
																			<span class="ruda"><xsl:value-of select="garage_cost" /><i></i></span>
																		</div>
																	</xsl:if>
																</span>
															</button>
														</div>
														<xsl:if test="player/level &lt; 7">
															<div class="hint">Можно купить с 7-го уровня</div>
														</xsl:if>
													</form>
												</div>
												<ins class="b l">
													<ins></ins>
												</ins>
												<ins class="b r">
													<ins></ins>
												</ins>
											</div>
										</xsl:when>
										<xsl:otherwise>
											<div class="home-garage">
												<dl class="vtabs">
													<dt class="selected active">
														<div>
															<div>Гараж во дворе
																<span class="num" onclick="$('#home-garage-enlarge').toggle('normal');">(<xsl:value-of select="cars_count" />/<xsl:value-of select="garage" />)</span>
															</div>
														</div>
													</dt>
													<dd>
														<div class="about">
															<p style="margin:0 0 5px 0;">Очевидно, что гараж — любимое место отдыха автомобилиста. Но есть места и поинтереснее.</p>
															<button class="button" type="button" onclick="$(this).parents('div.alert:first').hide(); window.location.href='/automobile/ride/'">
																<span class="f">
																	<i class="rl"></i><i class="bl"></i><i class="brc"></i>
																	<div class="c">Отправиться в поездку. Вжжж<i class="car-icon"></i></div>
																</span>
															</button>
														</div>
														<div class="object-thumbs">
															<xsl:for-each select="cars/element">
																<div class="object-thumb">
																	<div class="padding">
																		<xsl:choose>
																			<xsl:when test="id != 0">
																				<a href="/automobile/car/{id}/">
																					<img src="{image}.png" />
																				</a>
																				<div class="action">
																					<span onclick="document.location.href='/automobile/car/{id}/';">инфо</span>
																				</div>
																			</xsl:when>
																		</xsl:choose>
																	</div>
																</div>
															</xsl:for-each>
														</div>
														<div class="hint">
															<div style="margin:0 0 3px 0;">Cоберите себе тачку на <a href="/automobile/">Автозаводе</a></div>
															<div>
																<xsl:choose>
																	<xsl:when test="garage_max = 1">
																		<span>Ваш гараж уже занял всю территорию двора</span>
																	</xsl:when>
																	<xsl:otherwise>
																		<span class="dashedlink" onclick="$('#home-garage-enlarge').toggle();">Увеличить вместимость гаража</span>
																	</xsl:otherwise>
																</xsl:choose>
															</div>
															<div id="home-garage-enlarge" style="display:none;">
																<form method="post" action="/automobile/upgradegarage/">
																	<button class="button" type="submit" onclick="$(this).parents('div.alert:first').hide();">
																		<span class="f">
																			<i class="rl"></i>
																			<i class="bl"></i>
																			<i class="brc"></i>
																			<div class="c">Добавить одно машино-место -
																				<span class="ruda"><xsl:value-of select="garage_cost" /><i></i></span>
																			</div>
																		</span>
																	</button>
																</form>
															</div>
														</div>
													</dd>
												</dl>
											</div>
										</xsl:otherwise>
									</xsl:choose>
								</td>
							</tr>
						</table>
					</xsl:if>
									
				</div>
			</div>
		</div>
	</xsl:template>
</xsl:stylesheet>
