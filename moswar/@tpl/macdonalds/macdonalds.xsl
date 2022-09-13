<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>

	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>
						Шаурбургерс
					</h2>
				</div>
				<div id="content" class="shaurburgers">


					<div class="welcome">
						<div class="block-rounded">
							<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
							<div class="text clear">
								<xsl:choose>
									<xsl:when test="is_available = 0">
										— Ты ищешь работу, верно? Пока у нас нет места для тебя. Приходи, как достигнешь 2-го уровня.<br /><br />
										Но можно попытаться <span class="dashedlink" onclick="$('#buy_shaurcap').toggle('fast');">зайти с заднего входа</span>.
										<p id="buy_shaurcap" style="display: none;">
											<img src="/@/images/obj/hat1.png" align="right" />Подойдя ко входу «только для персонала», ты замечаешь, 
											что все сотрудники носят красную Кэпку Шаурмена. Заполучив ее, можно начать работать уже на первом уровне. 
											Кажется ты видел такую в <a href="/berezka/">магазине Березка</a>.
										</p>
									</xsl:when>
									<xsl:otherwise>
										Добро пожаловать в наше королевство! Но ты ведь не кушать сюда пришел, верно? 
										Тебе нужна работа, а нам нужно чтоб кто-то стоял на кассе и улыбался. 
										Чем шире будешь улыбаться, тем больше заработаешь.
									</xsl:otherwise>
								</xsl:choose>
							</div>
						</div>
					</div>
					

					
					<xsl:if test="is_available = 1">
						<xsl:if test="count(result) > 0">
							<xsl:call-template name="error">
								<xsl:with-param name="result" select="result" />
							</xsl:call-template>
						</xsl:if>

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
											<h3>Работа</h3>
											<form class="shaurburgers-work" id="workForm" action="/shaurburgers/" method="post">
												<input type="hidden" name="action" value="work" />
												<xsl:choose>
													<xsl:when test="player/state = 'macdonalds'">
			                                            <table class="process">
			                                                <tr>
			                                                    <td class="label">Вкалываем:</td>
			                                                    <td class="progress">
			                                                        <div class="exp">
			                                                            <div class="bar"><div><div class="percent" style="width:{shaurmapercent}%;" id="shaurmabar"></div></div></div>
			                                                        </div>
			                                                    </td>
			                                                    <td class="value" timer="{timer}" timer2="{shaurmatimetotal}" id="shaurma" intitle="1"><xsl:value-of select="shaurmatimeleft2" /></td>
			                                                </tr>
			                                            </table>

														<div style="margin:5px 0;">
															<span class="button" onclick="macdonaldsLeave();">
																<span class="f">
																	<i class="rl"></i><i class="bl"></i><i class="brc"></i>
																	<div class="c">Улизнуть с работы</div>
																</span>
															</span>
														</div>
														<p>При побеге с&#160;рабочего места вы&#160;не&#160;получите оплаты за&#160;отработанное время.</p>
													</xsl:when>
													<xsl:otherwise>
														<p>Вы можете работать
															<xsl:value-of select="currentskill/tip" />.
															<br />Ваша зарплата —
															<span class="tugriki"><xsl:value-of select="currentskill/salary" /><i></i></span> в час.
														</p>
														
														<xsl:if test="salaryBonus != 0">
															<div class="time-left">
																Дополнительный доход —  <span class="tugriki"><xsl:value-of select="salaryBonus" /><i></i></span> в час
															</div>
														 </xsl:if>
														 
														 <xsl:if test="shaurbadge = 1">
															<p style="text-align:left; margin:10px 0;">
																<img src="/@/images/obj/item10.png" align="left" style="margin-top:-10px" tooltip="1" title="Бейджик менеджера||Значок менеджера позволяет стоять у кассы и получать на 30% больше дохода во время работы." />
																Напялив бейджик менеджера, вы вправе присвоить чаевые вашей смены. 
																Это даст хорошую прибавку к зарплате.
															</p>
														 </xsl:if>
														 
														<div class="time">
															<select name="time">
																<option value="1">1 час</option>
																<option value="2">2 часа</option>
																<option value="3">3 часа</option>
																<option value="4">4 часа</option>
																<option value="5">5 часов</option>
																<option value="6">6 часов</option>
																<option value="7">7 часов</option>
																<option value="8">8 часов</option>
																<xsl:if test="add_hours = 1">
																	<option value="9">9 часов</option>
																	<option value="10">10 часов</option>
																	<option value="11">11 часов</option>
																	<option value="12">12 часов</option>
																</xsl:if>
															</select>
															<span class="button" onclick="$('#workForm').trigger('submit');">
																<span class="f">
																	<i class="rl"></i>
																	<i class="bl"></i>
																	<i class="brc"></i>
																	<div class="c">Работать</div>
																</span>
															</span>
														</div>
                                                        <p>
                                                            На
                                                            следующем уровне вы сможете работать
                                                            <xsl:value-of select="currentskill/tip" /> с&#160;минимальной зарплатой
                                                            <span class="tugriki"><xsl:value-of select="nextlevel/salary" /><i></i></span> в час.
                                                        </p>
														<p>
															<xsl:choose>
																<xsl:when test="nextskill/level > player/level">
																	На
																	<xsl:value-of select="nextskill/level" /> уровне вы сможете работать
																	<xsl:value-of select="nextskill/tip" /> с&#160;минимальной зарплатой
																	<span class="tugriki"><xsl:value-of select="nextskill/salary" /><i></i></span> в час.
																</xsl:when>
															</xsl:choose>
														</p>
														<p>Работая, будьте осторожны. Даже выходя на минутный перекур, вы можете подвергнуться нападению.</p>
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
											<h3>Курсы и тренинги</h3>
											<form class="shaurburgers-training">
												<xsl:if test="train_message != ''">
													<p class="error">
														<xsl:choose>
															<xsl:when test="train_message = 'not_enough_money'">Для прохождения тренинга, вы должны заплатить
																<xsl:if test="nextskill/cost_money>0">
																	<span class="tugriki">
																		<xsl:value-of select="nextskill/cost_money" />
																		<i></i>
																	</span>
																</xsl:if>
																<xsl:if test="nextskill/cost_ore>0">
																	<span class="ruda">
																		<xsl:value-of select="nextskill/cost_ore" />
																		<i></i>
																	</span> или
																	<span class="med">
																		<xsl:value-of select="nextskill/cost_ore" />
																		<i></i>
																	</span>
																</xsl:if>
																, но вам не хватает денег.
															</xsl:when>
															<xsl:when test="train_message = 'not_enough_level'">
																Для прохождения тренинга вы должны получить
																<xsl:value-of select="nextskill/level" /> уровень.
															</xsl:when>
															<xsl:when test="train_message = 'max_skill'">
																Вы уже достигли совершенства.
															</xsl:when>
															<xsl:when test="train_message = 'ok'">
																Вы посетили курсы повышения квалификаций и теперь работаете
																<xsl:value-of select="currentskill/tip" />.
															</xsl:when>
														</xsl:choose>
													</p>
												</xsl:if>
												<xsl:choose>
													<xsl:when test="nextskill/cost_money != ''">
														<p>На данный момент вы получаете Ваши жалкие 
														<span class="tugriki"><xsl:value-of select="currentskill/salary" /><i></i></span>в час.</p>
														<p>Обучение позволит повысить Вашу эффективность и&#160;растянуть улыбку еще на&#160;3&#160;сантиметра, 
														что сразу приведет к&#160;увеличению минимальной зарплаты. 
														После прохождения тренингов вы сможете получать зарплату — <span class="tugriki"><xsl:value-of select="nextskill/salary_bonus" /><i></i></span> в час.
														</p>
														<xsl:choose>
															<xsl:when test="nextskill/level > player/level">
																<p class="brown">Вы сможете пройти тренинг только на
																	<xsl:value-of select="nextskill/level" /> уровне.
																</p>
															</xsl:when>
															<xsl:otherwise>
																<div class="button" onclick="document.location.href='/shaurburgers/train/';">
																	<span class="f">
																		<i class="rl"></i>
																		<i class="bl"></i>
																		<i class="brc"></i>
																		<div class="c">Пройти тренинги -
																			<xsl:if test="nextskill/cost_money>0">
																				<span class="tugriki">
																					<xsl:value-of select="nextskill/cost_money" />
																					<i></i>
																				</span>
																			</xsl:if>
																			<xsl:if test="nextskill/cost_ore>0">
																				<span class="ruda">
																					<xsl:value-of select="nextskill/cost_ore" />
																					<i></i>
																				</span> или
																				<span class="med">
																					<xsl:value-of select="nextskill/cost_ore" />
																					<i></i>
																				</span>
																			</xsl:if>
																		</div>
																	</span>
																</div>
															</xsl:otherwise>
														</xsl:choose>
													</xsl:when>
													<xsl:otherwise>
														<p>Вы уже достигли совершенства.</p>
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
							</tr>
						</table>
					</xsl:if>

				</div>
			</div>
		</div>
	</xsl:template>

    <xsl:template name="error">
		<xsl:param name="error" />
		<xsl:param name="type" />
		<xsl:param name="params" />
		<xsl:param name="action" />
		<xsl:param name="result" />

        <xsl:choose>
            <!-- errors -->
			<xsl:when test="$result/result = 0 and $result/type = 'macdonalds' and $result/action = 'train' and $result/error = 'low level'"><p class="error" align="center">Ваш уровень слишком мал для прохождения тренингов.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'macdonalds' and $result/action = 'train' and $result/error = 'no money'"><p class="error" align="center">Вам не хватает денег для прохождения тренингов.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'macdonalds' and $result/action = 'train' and $result/error = 'you already have max skill'"><p class="error" align="center">Вы уже работаете на самой высокой должности.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'macdonalds' and $result/action = 'leave' and $result/error = 'you are not working'"><p class="error" align="center">Вы не работаете в данный момент.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'macdonalds' and $result/action = 'work' and $result/error = 'bad time'"><p class="error" align="center">Нельзя работать столько времени.</p></xsl:when>
			<!-- successes -->
			<xsl:when test="$result/result = 1 and $result/type = 'macdonalds' and $result/action = 'train'"><p class="success" align="center">Вы успешно посетили тренинги и теперь работаете на новой должности.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'macdonalds' and $result/action = 'work'"><p class="success" align="center">Вы начали рабочую смену.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'macdonalds' and $result/action = 'leave'"><p class="success" align="center">Вы выждали момент, когда никто не видел, и вышли через заднюю дверь.</p></xsl:when>
        </xsl:choose>

    </xsl:template>

</xsl:stylesheet>