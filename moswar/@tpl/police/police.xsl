<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>

	<xsl:include href="common/price.xsl" />

	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>
						<span class="police"></span>
					</h2>
				</div>
				<div id="content" class="police">

					<div class="welcome">
						<div class="block-rounded">
							<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
							<div class="text">
								<xsl:choose>
									<xsl:when test="player/state = 'police' and player/timer > unixtime">
										— В нашем городе не принято баклашить. Потусуй-ка в аквариуме.<br /><br />

										<b>
											<xsl:choose>
												<xsl:when test="player/stateparam = 'admin'">Вы были задержаны модератором. Вас отпустят через:&#0160;</xsl:when>
												<xsl:otherwise>Вас задержали за драки и отпустят через:&#0160;</xsl:otherwise>
											</xsl:choose>
											<xsl:element name="span">
												<xsl:attribute name="class">timer</xsl:attribute>
												<xsl:attribute name="timer"><xsl:value-of select="player/timer - unixtime" /></xsl:attribute>
											</xsl:element>
										</b>
									</xsl:when>
									<xsl:otherwise>
										Милиция следит за беспорядками в городе и укрощает пыл самых ретивых буянов.
									</xsl:otherwise>
								</xsl:choose>
							</div>
						</div>
					</div>

					<table>
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
										<h3>Розыск</h3>
										<form class="police-attention">
											<p>После каждой драки вы попадаете под более пристальное внимание милиции. Когда внимание положительное, вас объявят в розыск и рано или поздно посадят на 3 часа.</p>
											<p>Этого не случится, если вы вовремя раскаетесь и придете с повинной.</p>
											<p>Если вы деретесь не часто, вам не стоит беспокоиться о розыске, поскольку милиция предпочитает ловить рецидивистов.</p>

											<div align="center">
												<div class="wanted">
													Текущий розыск: <xsl:if test="player/suspicion > 0">+</xsl:if><xsl:value-of select="player/suspicion" />
													<i class="start">-5</i>
													<i class="end">+5</i>
													<div class="bar">
														<div>
															<div class="percent" style="width:{procentsuspicion}%;"></div>
														</div>
													</div>
												</div>

											</div>

											<xsl:if test="fine_message = 'no_money'">
												<p class="error">У вас не хватает денег для оплаты залога.</p>
											</xsl:if>
											<div class="button" onclick="document.location.href='/police/fine/';">
												<span class="f">
													<i class="rl"></i>
													<i class="bl"></i>
													<i class="brc"></i>
													<xsl:choose>
														<xsl:when test="player/state = 'police' and player/timer > unixtime">
															<div class="c">Заплатить штраф —
																<xsl:call-template name="showprice">
																	<xsl:with-param name="ore" select="'5'" />
																</xsl:call-template>
															</div>
														</xsl:when>
														<xsl:otherwise>
															<div class="c">Дать взятку —
																<xsl:call-template name="showprice">
																	<xsl:with-param name="money" select="fine" />
																</xsl:call-template>
															</div>
														</xsl:otherwise>
													</xsl:choose>

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

								<div class="block-bordered">
									<ins class="t l">
										<ins></ins>
									</ins>
									<ins class="t r">
										<ins></ins>
									</ins>
									<div class="center clear">
										<h3>Высокие связи</h3>
										<form class="police-relations">
											<xsl:choose>
												<xsl:when test="player/relations_time >= timestamp">
													<p class="time">
														Связи налажены до <xsl:value-of select="player/relations_until" />
													</p>
												</xsl:when>
												<xsl:otherwise>
													<xsl:choose>
														<xsl:when test="relations_message = 'no_money'">
															<p class="error">У вас не хватает денег</p>
														</xsl:when>
													</xsl:choose>

													<p>Наладив связи с руководством милиции, вы можете не беспокоиться о вашем розыске в течение недели.</p>
													<div class="button" onclick="document.location.href='/police/relations/';">
														<span class="f">
															<i class="rl"></i>
															<i class="bl"></i>
															<i class="brc"></i>
															<div class="c">Наладить связи —
																<xsl:call-template name="showprice">
																	<xsl:with-param name="ore" select="'20'" />
																</xsl:call-template>
															</div>
														</span>
													</div>
												</xsl:otherwise>
											</xsl:choose>
										</form>
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
								<div class="block-bordered">
									<ins class="t l">
										<ins></ins>
									</ins>
									<ins class="t r">
										<ins></ins>
									</ins>
									<div class="center clear">
										<h3>Паспортный стол</h3>

										<form class="police-passport">

											<p>Паспортный стол оказывает услуги населению по смене имени, аватара и прописки.</p>
											<div class="button" onclick="document.location.href='/police/passport/';">
												<span class="f">
													<i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">Паспортный стол</div>
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

								<xsl:if test="player/level >= 5">
									<div class="block-bordered">
										<ins class="t l">
											<ins></ins>
										</ins>
										<ins class="t r">
											<ins></ins>
										</ins>
										<div class="center clear">
											<h3>Оборотни в погонах</h3>

											<div class="police-werewolf">
												<p>
													<img src="/@/images/pers/npc2_thumb.png" align="left" style="margin:-5px 16px 5px 0;" />
													В каждом человеке живет его другое Я. И порою, очень хочется нацепить погоны и выпустить свое альтер эго на свободу.
													<span class="dashedlink" onclick="$('#police-werewolf-description').toggle();">Подробнее</span>
												</p>
												<p id="police-werewolf-description" style="display:none;">
													После получения способностей оборотня вы сможете нападать, как будто вы игрок выбранного уровня.
													Таким образом, вы будете получать причитающийся <span class="expa"><i></i>опыт</span> и выбивать <span class="mobila"><i></i>мобилки</span>.
													При этом нападения оборотнем абсолютно <b>анонимны</b> и главное — <b>можно нападать на <i class="{player/fraction}"></i>своих</b>.
													Однако, оборотни не участвуют в групповых боях и войнах, поэтому не могут выбивать зубы.
												</p>
												<xsl:choose>
													<xsl:when test="player2/werewolf = 0">
														<form>
															<p class="error" align="center" id="police-werewolf-error" style="display:none;"></p>
															<label>Выберите оборотня:</label>&#160;
															<select id="werewolfLevel">
																<option value="0">не выбрано</option>
																<xsl:for-each select="werewolf_levels/element">
																	<option value="{current()}"><xsl:value-of select="current()" /> уровень</option>
																</xsl:for-each>
															</select>

															<xsl:if test="shoulderstrap = 1">
																<button class="button" style="margin:5px 0;" onclick="policeWerewolfBegin($('#werewolfLevel option:selected').val(), 1);" type="button">
																	<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																		<div class="c">Воспользоваться погонами</div>
																	</span>
																</button><br />
															</xsl:if>
															<button class="button" style="margin:5px 0;" onclick="policeWerewolfBegin($('#werewolfLevel option:selected').val());" type="button">
																<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																	<div class="c">Выпустить оборотня - <span class="med"><xsl:value-of select="costs/werewolf_begin" /><i></i></span> на 1 час</div>
																</span>
															</button>
															<div class="hint">Доступно с 5-го уровня</div>
														</form>
													</xsl:when>
													<xsl:otherwise>
														<table class="process">
															<tr>
																<td class="label">Оборотень выпущен:</td>
																<td class="progress">
																	<div class="exp">
																		<div class="bar"><div><div class="percent" style="width:{werewolfpercent}%;" id="werewolfbar"></div></div></div>
																	</div>
																</td>
																<td class="value" timer="{werewolftimeleft}" timer2="{werewolftimetotal}" id="werewolf"><xsl:value-of select="werewolftimeleft2" /></td>
															</tr>
														</table>

														<div align="center">
															<button class="button" onclick="document.location.href='/police/werewolf/';">
																<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																	<div class="c">Посмотреть</div>
																</span>
															</button>
															&#160;
															<button class="button" onclick="policeWerewolfExtension();">
																<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																	<div class="c">Продлить на час - <span class="med"><xsl:value-of select="costs/werewolf_extension" /><i></i></span></div>
																</span>
															</button>
														</div>
													</xsl:otherwise>
												</xsl:choose>
											</div>
										</div>
										<ins class="b l">
											<ins></ins>
										</ins>
										<ins class="b r">
											<ins></ins>
										</ins>
									</div>
								</xsl:if>
							</td>
						</tr>
					</table>

				</div>
			</div>
		</div>
	</xsl:template>

</xsl:stylesheet>