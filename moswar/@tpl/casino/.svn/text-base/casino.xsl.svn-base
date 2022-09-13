<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>

	<xsl:include href="common/playerlink.xsl" />

	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Казино</h2>
				</div>
				<div id="content" class="casino">
					<div class="welcome">

						<div class="corner-links">
							<div class="balance">
								<b>Баланс: </b>
								<span class="fishki">
									<span id="fishki-balance-num"><xsl:value-of select="chip" /></span>
									<i></i>
								</span>
								<a href="/casino/#exchange">Разменять</a>
							</div>
							<div class="chat-link">
								<a href="#" onclick="openChat('casino');">Включить чат</a>
							</div>
						</div>

						<div class="block-rounded">
							<i class="tlc"></i>
							<i class="trc"></i>
							<i class="blc"></i>
							<i class="brc"></i>
							<div class="text clear">
								Добро пожаловать в подпольное Казино. Чувствуйте себя как дома. Ваш дом — наш дом.
							</div>
						</div>
					</div>
					
					<table class="buttons">
						<tr>
							<td style="width:25%;">
								<div class="button">
									<a class="f" href="/casino/kubovich/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										<div class="c">Кубович</div>
									</a>
								</div>
							</td>
							<td style="width:25%;">
								<div class="button">
									<a class="f" href="/casino/slots/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										<div class="c">Слоты</div>
									</a>
								</div>
							</td>
							<td style="width:25%;">
								<div class="button">
									<a class="f" href="/casino/sportloto/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										<div class="c">Спортлото</div>
									</a>
								</div>
							</td>
							<td style="width:25%;">
								<div class="button disabled" onclick="return false;">
									<span class="f" href="/casino/blackjack/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										<div class="c">Блэкджек</div>
									</span>
								</div>
							</td>
						</tr>
					</table>

					<table>
						<tr>
							<td style="width:50%; padding:0 5px 0 0;">
								<a name="exchange"></a>
								<div class="block-bordered">
									<ins class="t l"><ins></ins></ins>
									<ins class="t r"><ins></ins></ins>
									<div class="center clear">
										<h3>Касса</h3>

										<div class="casino-casher">
											<p>Кассир с удовольствием разменяет вашу руду на фишки:</p>
											
											<div style="text-align:center;">
												<span class="ruda">
													<input type="text" size="3" maxlength="6" value="1" id="stash-change-ore" />
													<i></i>
												</span>
															=
												<span class="fishki">
													<span id="stash-change-ore-chip">10</span>
													<i></i>
												</span>
												<button class="button" id="button-change-ore">
													<span class="f">
														<i class="rl"></i>
														<i class="bl"></i>
														<i class="brc"></i>
														<div class="c">Купить фишки</div>
													</span>
												</button>
											</div>
											<div style="text-align:center;" id="exchange-result-ore"></div>
											<p class="hint">
												Антиазартный комитет пристально следит за здоровьем столичников и разрешает выдавать
												игрокам <b>не более 200 фишек</b> в сутки.
											</p>
											<p class="hint">
												<img src="/@/images/pers/man112_thumb.png" style="margin-top:-18px; cursor:pointer;" align="right" onclick="$('#casino-casher-illegal').toggle('fast');" />Однако, местный крупье решил немного подзаработать и&#160;готов
												<b class="dashedlink" onclick="$('#casino-casher-illegal').toggle('fast');">продать больше фишек в обход кассы</b>
											</p>
											<div style=" width:302px; overflow:hidden; text-align:center; padding-top:1px">
												<div id="casino-casher-illegal" style="display:none;">
													<span class="med">
														<input type="text" size="3" maxlength="6" value="20" id="stash-change-honey" />
														<i></i>
													</span> =
													<span class="fishki">
														<span id="stash-change-honey-chip">200</span>
														<i></i>
													</span>
													<button class="button" id="button-change-honey">
														<span class="f">
															<i class="rl"></i>
															<i class="bl"></i>
															<i class="brc"></i>
															<div class="c">Купить фишки</div>
														</span>
													</button>
												</div>
												<div style="text-align:center;" id="exchange-result-honey"></div>
											</div>
											<script type="text/javascript">
											<![CDATA[
												$(document).ready(function(){
													if("#exchange" == document.location.hash){
														$("#casino-casher-illegal").show();
													}
												});
											]]>
											</script>
										</div>
										<div class="hrline"></div>
										<h3>Забрать выигрыш</h3>

										<div class="casino-casher">
											<div style="text-align:center;">
												<span class="fishki">
													<input type="text" size="3" maxlength="6" value="50" id="stash-change-chip" />
													<i></i>
												</span>
															=
												<span class="ruda">
													<span id="stash-change-chip-ore">5</span>
													<i></i>
												</span>
												<button class="button" id="button-change-chip">
													<span class="f">
														<i class="rl"></i>
														<i class="bl"></i>
														<i class="brc"></i>
														<div class="c">Получить руду</div>
													</span>
												</button>
											</div>
											<div style="text-align:center;" id="exchange-result-chip"></div>
											<div class="hint" style="text-align:center; margin-top:5px;">Минимальная сумма вывода — 50 фишек</div>
										</div>
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
										<h3>Сегодняшние везунчики</h3>
										<div class="casino-luckylist">
											<p>Эти ребята поймали удачу за хвост. Перед вами самые везучие игроки нашего казино за сегодня:</p>
											<table class="list">
												<tr>
													<th class="num">№</th>
													<th>Имя</th>
													<th class="value">Выигрыш</th>
												</tr>
												<xsl:for-each select="luckylist/element">
													<tr>
														<xsl:if test="position() &lt; 4"><xsl:attribute name="class">special</xsl:attribute></xsl:if>
														<xsl:if test="my = 'true'"><xsl:attribute name="class">my</xsl:attribute></xsl:if>
														<td class="num"><xsl:value-of select="position" />.</td>
														<td>
															<xsl:call-template name="playerlink">
																<xsl:with-param name="player" select="player" />
															</xsl:call-template>
														</td>
														<td class="value">
															<span class="fishki"><xsl:value-of select="format-number(player/profit, '###,###,###,###')" /><i></i></span>
														</td>
													</tr>
												</xsl:for-each>
											</table>
											<div class="hint" style="text-align:center; margin-top:5px;">Очисти свою карму — будь везучим!</div>
										</div>
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

				</div>
			</div>
		</div>
		<script type="text/javascript" src="/@/js/casino.js"></script>
	</xsl:template>

</xsl:stylesheet>
