<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>

	<xsl:include href="common/price.xsl" />

	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Пирамида WWW</h2>
				</div>
				<div id="content" class="pyramid">

					<div class="welcome">
						<div class="goback">
							<span class="arrow">◄</span><a href="/arbat/">На Арбат</a>
						</div>
						<div class="block-rounded introduction">
							<i class="tlc"></i>
							<i class="trc"></i>
							<i class="blc"></i>
							<i class="brc"></i>
							<div class="text clear">
								Хочешь зарабатывать, ничего не делая? Хочешь, чтобы твой капитал рос, пока ты сидишь в ЖЖ
								или смотришь картинки котиков и белочек? Тогда это как раз для тебя! Пирамида WWW —
								гарантированный доход от безделья в Интернете!
							</div>
						</div>
						<div id="pyramid-working">
							<xsl:if test="pyramid_state != 'working'">
								<xsl:attribute name="style">display: none;</xsl:attribute>
							</xsl:if>
								<div class="picture">
									<div class="text">
										<p>Yes, We Can!
											<br />Вместе мы построим самую большую пирамиду, всем фараонам на зависть.
										</p>
										<div class="pyramid-cost">
											<table>
												<tr>
													<td>Стоимость
														<br />пирамидки
														<br />на&#160;сегодня:
													</td>
													<td>
														<span class="tugriki"><span id="pyramid_cost"><xsl:value-of select="pyramid_cost" /></span><i></i></span>
													</td>
												</tr>
											</table>
										</div>
									</div>
									<div class="police-interested">
										Пирамидой заинтересовались Господа Полицейские <i class="question-icon" tooltip="1" title="Заинтересованность Полиции||Шанс обрушения пирамиды завтра: {pyramid_progress}%|В случае обрушения все ваши пирамидки рассыпятся, а деньги украдут."></i><br />
										<div class="wanted" title="">
											<div class="bar"><div><div class="percent" style="width:{pyramid_progress}%;"></div></div></div>
										</div>
									</div>
									<div class="pyramid-stats">
										<p>Партнеров:
											<br />
											<span class="num" id="pyramid_partners"><xsl:value-of select="format-number(pyramid_partners, '###,###,###')" /></span>
										</p>
										<p>Общий фонд:
											<br />
											<span class="num"><span class="tugriki"><span id="pyramid_fond"><xsl:value-of select="format-number(pyramid_fond, '###,###,###')" /></span><i></i></span></span><br />
											<xsl:if test="pyramid_fond_change != 0">
												<span>
													<xsl:choose>
														<xsl:when test="pyramid_fond_change > 0">
															<xsl:attribute name="style">color:green</xsl:attribute>
															<xsl:attribute name="title">Пирамида растет. Обновляется каждые 4 часа</xsl:attribute>
														</xsl:when>
														<xsl:otherwise>
															<xsl:attribute name="style">color:#ff3300</xsl:attribute>
															<xsl:attribute name="title">Пирамида снижается. Обновляется каждые 4 часа</xsl:attribute>
														</xsl:otherwise>
													</xsl:choose>
													<xsl:choose>
														<xsl:when test="pyramid_fond_change > 0">+</xsl:when>
														<xsl:otherwise>&#8722;</xsl:otherwise>
													</xsl:choose>
													<xsl:value-of select="format-number(pyramid_fond_change_abs, '###,###,###')" />
												</span>
											</xsl:if>
										</p>
									</div>
									<img class="avatar" src="/@/images/pers/man116.png" />
								</div>
								<div class="block-rounded description">
									<i class="tlc"></i>
									<i class="trc"></i>
									<i class="blc"></i>
									<i class="brc"></i>
									<h3>Пирамидки изобилия</h3>
									<div class="padding clear">
										<div class="left">
											<p>
												<img src="/@/images/obj/pyramid.png" align="left" style="margin:-12px 10px 01px -10px" />Стоимость пирамидок растет ежедневно&#160;и
												<b class="green">вырастает за месяц более чем на&#160;1500%.</b>
											</p>

											<p>Однако, в чёрный день, когда весь род людской подвергнется лживому сомнению
														и панике — все начнут продавать свои пирамидки. И когда иссякнет фонд, тогда вся пирамида рухнет.
														Многие прольют слёзы. И лишь единицы будут ликовать.
											</p>

										</div>
										<div class="right">
											<div class="hint">
															В день вы можете совершить <b>только одну</b><br />операцию покупки или продажи пирамидок.
											</div>

												<xsl:if test="when_action_avail = 0">
													<form id="pyramid-buy-form">
																	Кол-во:&#160;
														<input type="text" name="amount" size="3" value="1" id="buy_amount" />&#160;
														<button class="button" type="button" onclick="pyramidBuy($('#buy_amount').val());">
															<span class="f">
																<i class="rl"></i>
																<i class="bl"></i>
																<i class="brc"></i>
																<div class="c">Купить -
																	<span class="tugriki"><span id="pyramid-buy-cost-num"><xsl:value-of select="pyramid_cost" /></span><i></i>
																	</span>
																</div>
															</span>
														</button>
														<div class="hint">
																		Я не халявщик — я партнер!
														</div>
													</form>
													<script type="text/javascript">
																	var pyramid_cost = <xsl:value-of select="pyramid_cost" />;
																	pyramidCostCalculate = function(){
																		$("#pyramid-buy-cost-num").html( Math.round($('#buy_amount').val() || 0) * pyramid_cost );
																	}
																	$("#pyramid-buy-form input[name=amount]").bind("keyup", pyramidCostCalculate).bind("blur", pyramidCostCalculate);
																	$(document).ready(function(){
																		$("#buy_amount").spinner({min: 1}).change(pyramidCostCalculate);
																	});
													</script>
												</xsl:if>

											<p id="nextactiondt" class="borderdata">
												<xsl:if test="when_action_avail = 0">
													<xsl:attribute name="style">display: none;</xsl:attribute>
												</xsl:if>
												Следующую операцию вы сможете провести в <span class="timeleft"><xsl:value-of select="when_action_avail" /></span>
											</p>

											<p class="borderdata">
															У вас в наличии:
												<span class="pyramids"><span id="your_pyramids"><xsl:value-of select="your_pyramids" /></span><i></i></span>
												<div class="hint">Цена продажи равна цене покупки на предыдущий день<br/>(~ -10% от цены пирамидки).</div>
											</p>
											<xsl:if test="when_action_avail = 0">
												<button class="button" type="button" id="pyramidButtonSell" onclick="pyramidSell($('#your_pyramids').val());">
													<xsl:if test="your_pyramids = 0">
														<xsl:attribute name="style">display: none;</xsl:attribute>
													</xsl:if>
													<span class="f">
														<i class="rl"></i>
														<i class="bl"></i>
														<i class="brc"></i>
														<div class="c">Продать все за
															<span class="tugriki"><span id="your_pyramids_sum"><xsl:value-of select="format-number(pyramid_cost_sell * your_pyramids, '###,###,###')" /></span><i></i></span>
														</div>
													</span>
												</button>
											</xsl:if>
											
											<div class="pyramid-forecast clear">
												<div class="link">
													<span class="dashedlink" onclick="$('#pyramid-forecast-content').toggle();">Бабушки советуют</span>
												</div>
												<div id="pyramid-forecast-content" style="display:none;">
													<img align="left" src="/@/images/obj/home3.png" style="margin:-10px 16px 5px 0;" />
													<p align="left">Местные бабульки на лавочке за скромную сумму поделятся слухами и дадут свой совет относительно пирамиды.</p>
													
													<div id="pyramid-forecast-advice">
													</div>
													
													<button id="pyramid-forecast-button" class="button" type="button" onclick="pyramidForecast();">
														<span class="f">
															<i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">
																Получить прогноз - <xsl:call-template name="showprice">
																	<xsl:with-param name="money" select="forecast_price/money" />
																	<xsl:with-param name="ore" select="forecast_price/ore" />
																	<xsl:with-param name="honey" select="forecast_price/honey" />
																</xsl:call-template>
															</div>
														</span>
													</button>
													
												</div>
											</div>

										</div>

									</div>
								</div>
						</div>
						<div id="pyramid-crashed">
							<xsl:if test="pyramid_state != 'crashed'">
								<xsl:attribute name="style">display: none;</xsl:attribute>
							</xsl:if>
							<div class="picture pyramid-fail">
								<h2>Пирамида рухнула ;-(</h2>
							</div>

							<div class="block-rounded description">
								<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
								<div class="padding clear">
									<div class="pyramid-fail-description">
										Все ваши пирамидки рассыпались.<br />
										Новая пирамида стартует через <span class="timeleft" timer="{pyramid_start_in}">...</span>
									</div>
								</div>
							</div>
						</div>
					</div>


				</div>
			</div>
		</div>

	</xsl:template>

</xsl:stylesheet>
