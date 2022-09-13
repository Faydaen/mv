<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>

	<xsl:include href="common/price.xsl" />

	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Питомец</h2>
				</div>
				<div id="content" class="petarena">

					<div class="petarena-training">

						<h3 class="curves">
							<div class="goback">
								<span class="arrow">◄</span>
								<a href="/petarena/">Дрессировочная</a>
							</div>
							<span rel="name"><xsl:value-of select="pet/name" disable-output-escaping="yes" /></span> [<span rel="level"><xsl:value-of select="pet/level" /></span>]
							<i class="question-icon" tooltip="1" title="Уровень питомца||Чем сильнее надрессирован питомец, тем выше его уровень"></i>
						</h3>

						<div class="pet-info">
							<div class="block-rounded">
								<i class="tlc"></i>
								<i class="trc"></i>
								<i class="blc"></i>
								<i class="brc"></i>
								<xsl:if test="pet/dead = 1">
									<div class="cure">
										<p>Ваш питомец потерял много жизней и попал в кому!<br /></p>

										<table class="process">
											<tr>
												<td class="label">Он самостоятельно вылечится через:</td>
												<td class="progress">
													<div class="exp">
														<div class="bar">
															<div>
																<div class="percent" style="width:{restorepercent}%;" id="restorebar"></div>
															</div>
														</div>
													</div>
												</td>
												<td class="value">
													<span timer="{restoretimer}" timer2="{restoretimetotal}" id="restore" intitle="1" trigger="petarenaRestoreComplete();"><xsl:value-of select="restoretimeleft2" /></span>
												</td>
											</tr>
										</table>
										
										<xsl:if test="count(healing) = 1">
											<p>Вы можете ускорить лечение на 1 день:
												<button class="button" type="button" style="margin-left:10px;" onclick="petarenaRespawn({pet/id});">
													<span class="f">
														<i class="rl"></i>
														<i class="bl"></i>
														<i class="brc"></i>
														<div class="c" style="padding:0 2px"><span rel="heal"><xsl:value-of select="healing/name" /></span> -
															<span class="ruda"><xsl:value-of select="healing/cost" /><i></i></span>
														</div>
													</span>
												</button>
											</p>
										</xsl:if>
									</div>
								</xsl:if>

								<table>
									<tr>
										<td class="description">
											<p><xsl:value-of select="pet/info" /></p>

											<div class="life">Жизни: <xsl:value-of select="pet/hp" />/<xsl:value-of select="pet/maxhp" />
												<i class="question-icon" tooltip="1" title="Потеря жизни||В случае, если ваш питомец потеряет все жизни в бою — он впадет в кому. В таком случае он потеряет 5% характеристик, но навыки дрессировки не потеряются. Выходить из комы он будет 4 дня, если не применить реанимацию. Поэтому лучше следить за здоровьем любимца. "></i>
												<div class="bar">
													<div>
														<div style="width: {pet/procenthp}%;" class="percent"></div>
													</div>
												</div>
											</div>
											<div class="tonus" id="pet-tonus">
												Настроение: <span rel="tonus"><xsl:value-of select="pet/mood" /></span>%
												<i class="question-icon" tooltip="1" title="Настроение питомца||Чем лучше настроение у вашего питомца, тем лучше настроение у вас"></i>
												<div class="bar">
													<div><div style="width: {pet/mood}%;" class="percent"></div></div>
												</div>
											</div>
										</td>
										<td class="avatar">
											<div style="position:relative;">
												<img src="/@/images/obj/{pet/image}">
													<xsl:if test="pet/dead = 1">
														<xsl:attribute name="class">injured</xsl:attribute>
													</xsl:if>
												</img>

												<span class="smile1" style="display:none;">&#9786;</span>
												<span class="smile2" style="display:none;">&#9787;</span>
												<span class="smile3" style="display:none;">;-)</span>
											</div>
										</td>
										<td class="data">
											<div class="clear">
												<p>
													<span class="brown">Развитие:
														<b><xsl:value-of select="pet/procent" />%</b>
														<i class="question-icon" tooltip="1" title="Характеристики питомца||Чем сильнее хозяин, тем сильнее питомец. Каждая победа над питомцем противника прибавляет в развитии."></i> от характеристик хозяина:
													</span>
												</p>
												<div>
													<span class="brown">Здоровье: <xsl:value-of select="pet/health" /></span><br />
													<span class="brown">Сила: <xsl:value-of select="pet/strength" /></span><br />
													<span class="brown">Ловкость: <xsl:value-of select="pet/dexterity" /></span><br />
													<span class="brown">Хитрость: <xsl:value-of select="pet/intuition" /></span><br />
													<span class="brown">Внимательность: <xsl:value-of select="pet/attention" /></span><br />
													<span class="brown">Выносливость: <xsl:value-of select="pet/resistance" /></span><br />
													<span class="brown">Харизма: <xsl:value-of select="pet/charism" /></span><br />
												</div>
											</div>
										</td>
									</tr>
								</table>
							</div>

							<table class="buttons">
								<tr>
									<td>
										<div class="button">
											<span class="f" onclick="petarenaChangeName({pet/id}, '{pet/nickname}');">
												<i class="rl"></i>
												<i class="bl"></i>
												<i class="brc"></i>
												<div class="c">Сменить кличку</div>
											</span>
										</div>
									</td>
									<td>
										<div class="button" id="pet-scratch">
											<span class="f" onclick="petarenaMood({pet/id});">
												<i class="rl"></i>
												<i class="bl"></i>
												<i class="brc"></i>
												<div class="c">Почесать брюшко</div>
											</span>
										</div>
									</td>
									<td rel="active">
										<div class="button">
											<xsl:if test="pet/active = 1">
												<xsl:attribute name="disabled">disabled</xsl:attribute>
												<xsl:attribute name="class">button disabled</xsl:attribute>
											</xsl:if>
											<span class="f" onclick="petarenaSetActive({pet/id});">
												<i class="rl"></i>
												<i class="bl"></i>
												<i class="brc"></i>
												<div class="c">Брать в бой</div>
											</span>
										</div>
									</td>
									<td>
										<div class="button disabled">
											<span class="f">
												<i class="rl"></i>
												<i class="bl"></i>
												<i class="brc"></i>
												<div class="c">Тренировочный бой</div>
											</span>
										</div>
									</td>
									<td>
										<button id="sellbutton" class="button" type="button" onclick="petarenaSell({pet/id}, '{pet/imagesmall}')">
											<xsl:if test="pet/dead = 1">
												<xsl:attribute name="class">button disabled</xsl:attribute>
												<xsl:attribute name="disabled">disabled</xsl:attribute>
											</xsl:if>
											<span class="f">
												<i class="rl"></i>
												<i class="bl"></i>
												<i class="brc"></i>
												<div class="c">Продать питомца</div>
											</span>
										</button>
									</td>
								</tr>
							</table>
						</div>

						<div class="block-bordered">
							<ins class="t l">
								<ins></ins>
							</ins>
							<ins class="t r">
								<ins></ins>
							</ins>
							<div class="center clear">
								<h3>Дрессировка питомца</h3>
								
								<div class="petarena-training-form">

									<span id="trainpanel">
										<xsl:if test="pet/can_train = 0">
											<table class="process">
												<tr>
													<td class="label">Питомец отдыхает:</td>
													<td class="progress">
														<div class="exp">
															<div class="bar">
																<div>
																	<div class="percent" style="width:{trainpercent}%;" id="trainbar"></div>
																</div>
															</div>
														</div>
													</td>
													<td class="value">
														<span timer="{traintimer}" timer2="{traintimetotal}" id="train" intitle="1" trigger="petarenaTrainComplete();"><xsl:value-of select="traintimeleft2" /></span>
														<xsl:choose>
															<xsl:when test="restore_cost > 0 or count(items/knut/id) = 1">
																<xsl:if test="restore_cost > 0">
																	<button class="button" type="button" style="margin-left:10px;" onclick="petarenaRestore({pet/id});">
																		<span class="f">
																			<i class="rl"></i>
																			<i class="bl"></i>
																			<i class="brc"></i>
																			<div class="c" style="padding:0 2px">Снять усталость -
																				<span class="med"><xsl:value-of select="restore_cost" />
																					<i></i>
																				</span>
																			</div>
																		</span>
																	</button>
																</xsl:if>
																<xsl:if test="count(items/knut/id) = 1">
																	<button class="button" type="button" style="margin-left:10px;" onclick="petarenaRestore({pet/id}, 1);">
																		<span class="f">
																			<i class="rl"></i>
																			<i class="bl"></i>
																			<i class="brc"></i>
																			<div class="c" style="padding:0 2px">Использовать кнут
																			</div>
																		</span>
																	</button>
																</xsl:if>
															</xsl:when>
															<xsl:otherwise>
																<p>Твой питомец сегодня слишком много тренировался и хочет отдохнуть.</p>
															</xsl:otherwise>
														</xsl:choose>
													</td>
												</tr>
											</table>
										</xsl:if>
									</span>

									<div style="float:left; width:47%;">
										<p>Хорошо надрессированный питомец – отличный помощник в дуэлях и групповых боях.
													Он может укусить врага или защитить вас от вражеского питомца.
										</p>
										<p>Главное — поручить дрессировку профессионалам</p>

										<img src="/@/images/ico/pet-trainer.png" style="position:absolute; left:60px; bottom:-1px;" />
									</div>

									<div style="float:right; width:50%">
										<ul class="stats">
											<li class="stat" rel="focus">
												<div class="label">
													<b>Нацеленность</b>
													<span class="num"><xsl:value-of select="pet/focus" /></span>
												</div>
												<div class="bar">
													<div>
														<div class="percent" style="width:{pet/focus_procent}%;"></div>
													</div>
												</div>
												<div class="text">
													<button class="button" type="button" onclick="petarenaTrain({pet/id}, 'focus', 'ajax');">
														<xsl:if test="pet/can_train = 0">
															<xsl:attribute name="class">button disabled</xsl:attribute>
															<xsl:attribute name="disabled">disabled</xsl:attribute>
														</xsl:if>
														<span class="f">
															<i class="rl"></i>
															<i class="bl"></i>
															<i class="brc"></i>
															<div class="c">Повысить -
																<span rel="cost"><xsl:call-template name="showprice">
																	<xsl:with-param name="money" select="pet/focus_cost/money" />
																	<xsl:with-param name="ore" select="pet/focus_cost/ore" />
																	<xsl:with-param name="oil" select="pet/focus_cost/oil" />
																	<xsl:with-param name="nohoney" select="1" />
																</xsl:call-template>
																</span>
															</div>
														</span>
													</button>
													Позволяет чаще атаковать
													<b>вражеского хозяина</b>, минуя его питомца.
													Шанс атаки зависит от преданности вражеского питомца.
												</div>
											</li>
											<li class="stat" rel="loyality">
												<div class="label">
													<b>Преданность</b>
													<span class="num"><xsl:value-of select="pet/loyality" /></span>
												</div>
												<div class="bar">
													<div>
														<div class="percent" style="width:{pet/loyality_procent}%;"></div>
													</div>
												</div>
												<div class="text">
													<button class="button" type="button" onclick="petarenaTrain({pet/id}, 'loyality', 'ajax');">
														<xsl:if test="pet/can_train = 0">
															<xsl:attribute name="class">button disabled</xsl:attribute>
															<xsl:attribute name="disabled">disabled</xsl:attribute>
														</xsl:if>
														<span class="f">
															<i class="rl"></i>
															<i class="bl"></i>
															<i class="brc"></i>
															<div class="c">Повысить -
																<span rel="cost"><xsl:call-template name="showprice">
																	<xsl:with-param name="money" select="pet/loyality_cost/money" />
																	<xsl:with-param name="ore" select="pet/loyality_cost/ore" />
																	<xsl:with-param name="oil" select="pet/loyality_cost/oil" />
																	<xsl:with-param name="nohoney" select="1" />
																</xsl:call-template></span>
															</div>
														</span>
													</button>
													Защита хозяина от вражеского питомца. Снижает процент шанса атаки.
												</div>
											</li>
											<li class="stat" rel="mass">
												<div class="label">
													<b>Массивность</b>
													<span class="num"><xsl:value-of select="pet/mass" /></span>
												</div>
												<div class="bar">
													<div>
														<div class="percent" style="width:{pet/mass_procent}%;"></div>
													</div>
												</div>
												<div class="text">
													<button class="button" type="button" onclick="petarenaTrain({pet/id}, 'mass', 'ajax');">
														<xsl:if test="pet/can_train = 0">
															<xsl:attribute name="class">button disabled</xsl:attribute>
															<xsl:attribute name="disabled">disabled</xsl:attribute>
														</xsl:if>
														<span class="f">
															<i class="rl"></i>
															<i class="bl"></i>
															<i class="brc"></i>
															<div class="c">Повысить -
																<span rel="cost"><xsl:call-template name="showprice">
																	<xsl:with-param name="money" select="pet/mass_cost/money" />
																	<xsl:with-param name="ore" select="pet/mass_cost/ore" />
																	<xsl:with-param name="oil" select="pet/mass_cost/oil" />
																	<xsl:with-param name="nohoney" select="1" />
																</xsl:call-template></span>
															</div>
														</span>
													</button>
													Навык, позволяющий испугать вражеского питомца так, что тот пропустит свой ход.
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<ins class="b l">
								<ins></ins>
							</ins>
							<ins class="b r">
								<ins></ins>
							</ins>
						</div>

					</div>

				</div>
			</div>
		</div>

	</xsl:template>

</xsl:stylesheet>