<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>
    <xsl:include href="common/price.xsl" />
	<xsl:include href="common/playerlink.xsl" />

	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear"><h2>Тачка</h2></div>
				<div id="content" class="auto">
					<div class="car-info">
						<h3 class="curves">
							<div class="goback">
								<span class="arrow">◄</span>
								<a href="/home/">Хата</a>
							</div>
							<xsl:value-of select="car/name" />
						</h3>
						<table class="buttons">
							<tr>
								<td>
									<div class="button">
										<a href="/automobile/ride/" class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Поездка<i class="car-icon"></i></div></a>
									</div>
								</td>
								<td>
									<div class="button">
										<a href="/arbat/" class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Бомбить<i class="taxi-icon"></i></div></a>
									</div>
								</td>
								<td>
									<form method="post" action="/automobile/buypetrol/{car/id}/">
										<div class="button">
											<span class="f" onclick="$(this).parents('form:first').submit();"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Заправка - <span class="{petrol/type}"><xsl:value-of select="petrol/cost" /><i></i></span></div></span>
										</div>
									</form>
								</td>
								<td>
									<div class="button" onclick="openNumber()">
										<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Номер</div></span>
									</div>
								</td>
								<td>
									<form method="post" action="/automobile/favorite/{car/id}/">
										<div type="submit">
											<xsl:choose>
												<xsl:when test="car/favorite = 1">
													<xsl:attribute name="class">button disabled</xsl:attribute>
												</xsl:when>
												<xsl:otherwise>
													<xsl:attribute name="class">button</xsl:attribute>
												</xsl:otherwise>
											</xsl:choose>
											<span class="f">
												<xsl:if test="car/favorite = 0">
													<xsl:attribute name="onclick">if(confirm('Показывать эту тачку в вашем профиле?')) { $(this).parents('form:first').submit(); } else { return false; }</xsl:attribute>
												</xsl:if>
												<i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c"><span style="line-height:0.5; font-size:16px; position:relative; top:0.1em;">&#9829;</span> Любимая</div>
											</span>
										</div>
									</form>
								</td>
								<td>
									<div class="button disabled">
										<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Дозоры</div></span>
									</div>
								</td>
							</tr>
						</table>

						<div class="block-rounded">
							<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
							<table>
								<tr>
									<td class="description">
										<div class="avatar">
											<img class="injured" src="{car/image}-big.png" />
											<xsl:choose>
												<xsl:when test="string-length(car/number) &gt; 10">
													<div class="car-number-place"><span class="car-number" onclick="openNumber()"><xsl:value-of select="car/number" disable-output-escaping="yes" /></span></div>
												</xsl:when>
												<xsl:otherwise>
													<div class="button" onclick="openNumber()">
														<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Установить номер</div></span>
													</div>
												</xsl:otherwise>
											</xsl:choose>
										</div>
										<p><xsl:value-of select="car/description" /></p>
										<p><span class="dashedlink" onclick="$('#car-info-sell-form').toggle();">Продать автомобиль</span></p>
										<form id="car-info-sell-form" method="post" action="/automobile/sellcar/" style="display:none;">
											<p style="margin-bottom:5px;">Вы действительно хотите продать <b><xsl:value-of select="car/name" /></b>?</p>
											<input type="hidden" name="car" value="{car/id}" />
											<button type="submit" class="button">
												<span class="f">
													<i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Продать -
													<xsl:call-template name="showprice">
														 <xsl:with-param name="money" select="sell_cost/money" />
														 <xsl:with-param name="ore" select="sell_cost/ore" />
														 <xsl:with-param name="oil" select="sell_cost/oil" />
														 <xsl:with-param name="nohoney" select="1" />
													</xsl:call-template>
													</div>
												</span>
											</button>
										</form>
									</td>
									<td class="data">
										<p>Характеристики автомобиля влияют на удачность <a href="/automobile/ride/">поездки</a>, а&#160;также в&#160;гонке на&#160;«Дозорах»</p>
										<ul class="stats">
											<li class="stat">
												<div class="label"><b>Скорость</b><i class="question-icon" tooltip="1" title="Скорость||Больше скорость - меньше времени на прохождение этапа в «Дозорах»"></i><span class="num"><xsl:value-of select="car/speed" /></span></div>
												<div class="bar">
													<div>
														<div class="percent" style="width:{car/speed_percent}%;"></div>
														<div class="percent2" style="width:{car/speed_percent2}%;"></div>
													</div>
												</div>
											</li>
											<li class="stat odd">
												<div class="label"><b>Проходимость</b><i class="question-icon" tooltip="1" title="Проходимость||При езде по ямам и колдобинам проходимость позволяет быстрее проходить сложные этапы «Дозоров»."></i><span class="num"><xsl:value-of select="car/passability" /></span></div>
												<div class="bar">
													<div>
														<div class="percent" style="width:{car/passability_percent}%;"></div>
														<div class="percent2" style="width:{car/passability_percent2}%;"></div>
													</div>
												</div>
											</li>
											<li class="stat">
												<div class="label"><b>Управляемость</b><i class="question-icon" tooltip="1" title="Управляемость||Мокрые дороги и лавирование в пробках настоящая проблема для тех, у кого слаба управляемость."></i><span class="num"><xsl:value-of select="car/controllability" /></span></div>
												<div class="bar">
													<div>
														<div class="percent" style="width:{car/controllability_percent}%;"></div>
														<div class="percent2" style="width:{car/controllability_percent2}%;"></div>
													</div>
												</div>
											</li>
											<li class="stat odd">
												<div class="label"><b>Престиж</b><i class="question-icon" tooltip="1" title="Престиж||Крутые могут проехать там, где другим путь закрыт"></i><span class="num"><xsl:value-of select="car/prestige" /></span></div>
												<div class="bar">
													<div>
														<div class="percent" style="width:{car/prestige_percent}%;"></div>
														<div class="percent2" style="width:{car/prestige_percent2}%;"></div>
													</div>
												</div>
											</li>
										</ul>
										<div class="fuel" style="position:relative;">
											<span class="neft"><i style="position:absolute; left:-20px; top:10px;"></i>Топливо: <xsl:value-of select="car/rides" />/5</span>
											<div class="bar"><div><div style="width: {car/rides_percent}%;" class="percent"></div></div></div>
										</div>
									</td>
									<td class="upgrades">
										<div class="objects">
											<xsl:for-each select="improvements/element">
												<span class="object-thumb" tooltip="1" src="{image}">
													<xsl:choose>
														<xsl:when test="available = 1 and exists != 1">
															<xsl:attribute name="class">object-thumb clickable</xsl:attribute>
														</xsl:when>
														<xsl:otherwise>
															<xsl:attribute name="class">object-thumb</xsl:attribute>
														</xsl:otherwise>
													</xsl:choose>
													<xsl:attribute name="title"><xsl:value-of select="name" />||<xsl:value-of select="description" disable-output-escaping="yes" /></xsl:attribute>
													<xsl:attribute name="name"><xsl:value-of select="name" /></xsl:attribute>
													<xsl:attribute name="description"><xsl:value-of select="description" disable-output-escaping="yes" /></xsl:attribute>
													<xsl:attribute name="cost"><xsl:value-of select="cost" /></xsl:attribute>
													<xsl:attribute name="iid"><xsl:value-of select="id" /></xsl:attribute>
													<xsl:if test="available != 1"><i class="icon-locked-small"></i></xsl:if>
													<xsl:if test="exists != 1"><i class="empty"></i></xsl:if>
													<span class="image-place"><img src="{image}" /></span>
												</span>
											</xsl:for-each>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="overtip" id="part-shop" style="margin:-50px 0 0 -150px; display: none;">
			<div class="object">
				<h2></h2>
				<div class="data">
					<div class="description"></div>

					<form class="actions" method="post" action="/automobile/upgradecar/">
						<input type="hidden" name="part" id="part-id" />
						<input type="hidden" name="car" value="{car/id}" />
						<button class="button" type="submit" onclick="">
							<span class="f">
								<i class="rl"></i><i class="bl"></i><i class="brc"></i>
								<div class="c">Купить - <span class="cost"></span></div>
							</span>
						</button>
						&#0160;
						<button class="button" type="button" onclick="$(this).parents('div.overtip:first').hide();">
							<span class="f">
								<i class="rl"></i><i class="bl"></i><i class="brc"></i>
								<div class="c">Отмена</div>
							</span>
						</button>
					</form>
					<i class="thumb"></i>
				</div>
			</div>
			<span class="close-cross" onclick="$(this).parents('div.overtip:first').hide();">&#215;</span>
		</div>
		<div class="alert car-number-alert" id="buy-number" style="display:none;">
			<div class="padding">
				<h2>Номер</h2>
				<div class="data">
					<div class="car-number-choose">
						<!--
						<div class="big">
							<span class="car-number">
								<input type="text" name="number" value="{car/strip_number}" maxlength="6" />
							</span>
						</div>
						<div class="generate-button">
							<button id="generate-number" class="button" type="button">
								<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
									<div class="c">Сгенерировать номер</div>
								</span>
							</button>
							<button id="check-number" class="button" type="button" style="margin-left: 10px; display: none;">
								<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
									<div class="c">Проверить номер</div>
								</span>
							</button>
						</div>
						-->
						<!--
						<div class="clear">
							<ul style="float:left; width:100%;">
								<xsl:for-each select="numbers/element">
									<xsl:if test="position() &lt; 4">
										<li>
											<input type="radio" name="vnumber" value="{cool}" id="car-number-choose-{position()}">
												<xsl:if test="cool = ../../car/number_cool"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if>
											</input>
											<label for="car-number-choose-{position()}">
												<b><xsl:value-of select="name" /></b> -
												<span class="cost"><span class="{cost/type}"><xsl:value-of select="cost/value" /><i></i></span></span><br />
												<xsl:choose>
													<xsl:when test="count(format/element) = 0"><span class="car-number"><xsl:value-of select="format" disable-output-escaping="yes" /></span></xsl:when>
													<xsl:otherwise>
														<xsl:for-each select="format/element">
															<span class="car-number"><xsl:value-of select="current()" disable-output-escaping="yes" /></span>&#0160;
														</xsl:for-each>
													</xsl:otherwise>
												</xsl:choose>
												<div class="hint"><xsl:value-of select="bonus" /></div>
											</label>
										</li>
									</xsl:if>
								</xsl:for-each>
							</ul>
							<ul style="float:right; width:100%;">
								<xsl:for-each select="numbers/element">
									<xsl:if test="position() &gt; 3">
										<li>
											<input type="radio" name="vnumber" value="{cool}" id="car-number-choose-{position()}">
												<xsl:if test="cool = ../../car/number_cool"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if>
											</input>
											<label for="car-number-choose-{position()}">
												<b><xsl:value-of select="name" /></b> -
												<span class="cost"><span class="{cost/type}"><xsl:value-of select="cost/value" /><i></i></span></span><br />
												<xsl:choose>
													<xsl:when test="count(format/element) = 0"><span class="car-number"><xsl:value-of select="format" disable-output-escaping="yes" /></span></xsl:when>
													<xsl:otherwise>
														<xsl:for-each select="format/element">
															<span class="car-number"><xsl:value-of select="current()" disable-output-escaping="yes" /></span>&#0160;
														</xsl:for-each>
													</xsl:otherwise>
												</xsl:choose>
												<div class="hint"><xsl:value-of select="bonus" /></div>
											</label>
										</li>
									</xsl:if>
								</xsl:for-each>
							</ul>
						</div>
						-->
						<div class="clear">
							<ul style="float:left; width:100%;">
								<xsl:for-each select="numbers/element">
									<xsl:if test="position() &lt; 4">
										<li>
											<form action="/automobile/buynumber/" method="post">
												<input type="hidden" name="car" value="{../../car/id}" />
												<input type="hidden" name="cool" value="{cool}" />
												<button class="button" type="submit">
													<span class="f">
														<i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div class="c"><xsl:value-of select="name" /> - <span class="cost"><span class="{cost/type}"><xsl:value-of select="cost/value" /><i></i></span></span></div>
													</span>
												</button>
												<xsl:choose>
													<xsl:when test="count(format/element) = 0"><span class="car-number"><xsl:value-of select="format" disable-output-escaping="yes" /></span></xsl:when>
													<xsl:otherwise>
														<xsl:for-each select="format/element">
															<span class="car-number"><xsl:value-of select="current()" disable-output-escaping="yes" /></span>&#0160;
														</xsl:for-each>
													</xsl:otherwise>
												</xsl:choose>
												<div class="hint"><xsl:value-of select="bonus" /></div>
											</form>
										</li>
									</xsl:if>
								</xsl:for-each>
							</ul>
							<ul style="float:right; width:100%;">
								<xsl:for-each select="numbers/element">
									<xsl:if test="position() &gt; 3">
										<li>
											<form action="/automobile/buynumber/" method="post">
												<input type="hidden" name="car" value="{../../car/id}" />
												<input type="hidden" name="cool" value="{cool}" />
												<button class="button" type="submit">
													<span class="f">
														<i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div class="c"><xsl:value-of select="name" /> - <span class="cost"><span class="{cost/type}"><xsl:value-of select="cost/value" /><i></i></span></span></div>
													</span>
												</button>
												<xsl:choose>
													<xsl:when test="count(format/element) = 0"><span class="car-number"><xsl:value-of select="format" disable-output-escaping="yes" /></span></xsl:when>
													<xsl:otherwise>
														<xsl:for-each select="format/element">
															<span class="car-number"><xsl:value-of select="current()" disable-output-escaping="yes" /></span>&#0160;
														</xsl:for-each>
													</xsl:otherwise>
												</xsl:choose>
												<div class="hint"><xsl:value-of select="bonus" /></div>
											</form>
										</li>
									</xsl:if>
								</xsl:for-each>
							</ul>
						</div>

						<div class="hint" align="center">При продаже машины ГИБДД изымает номер за бесценок.</div>
						
						<div class="elite">
							<div class="link">
								<b><span class="dashedlink" onclick="$('#car-number-choose-elite').toggle(); ">Выбрать элитные VIP-номера</span></b>
							</div>
							<div class="hint" style="text-align:center;">Нафиг не нужно, но очень круто.</div>
							<div id="car-number-choose-elite" class="clear">
								<xsl:if test="car/number_cool &lt; 7"><xsl:attribute name="style">display: none;</xsl:attribute></xsl:if>
								<form method="post" action="/automobile/buynumber/">
									<ul>
										<xsl:for-each select="vipnumbers/element">
											<xsl:if test="position() &lt; count(../../vipnumbers/element) div 2">
												<li>
													<xsl:if test="player != 0 and player/id != ../../car/player">
														<xsl:attribute name="class">taken</xsl:attribute>
													</xsl:if>
													<xsl:if test="../../car/strip_number = number">
														<xsl:attribute name="current">current</xsl:attribute>
														<xsl:attribute name="class">my</xsl:attribute>
													</xsl:if>
													<input type="radio" name="number" value="{number}" id="car-vip-number-choose-{position()}">
														<xsl:if test="player != 0 and player/id != ../../car/player">
															<xsl:attribute name="style">display: none;</xsl:attribute>
														</xsl:if>
														<xsl:if test="../../car/strip_number = number"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if>
													</input>
													<label for="car-vip-number-choose-{position()}">
														<span class="car-number">
															<xsl:if test="player != 0">
																<xsl:attribute name="tooltip">1</xsl:attribute>
																<xsl:attribute name="title">Номер: <xsl:value-of select="fnumber" disable-output-escaping="yes" />||&lt;span class="brown"&gt;Куплен: <xsl:value-of select="date" />&lt;br /&gt;Цена: <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="cost/money" /><xsl:with-param name="ore" select="cost/ore" /><xsl:with-param name="honey" select="cost/honey" /><xsl:with-param name="oil" select="cost/oil" /></xsl:call-template> мёда&lt;/span&gt;</xsl:attribute>
															</xsl:if>
															<xsl:value-of select="fnumber" disable-output-escaping="yes" />
														</span> -
														<xsl:choose>
															<xsl:when test="player = 0">
																<span class="cost"><xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="cost/money" /><xsl:with-param name="ore" select="cost/ore" /><xsl:with-param name="honey" select="cost/honey" /><xsl:with-param name="oil" select="cost/oil" /></xsl:call-template></span>
															</xsl:when>
															<xsl:when test="player/id = ../../car/player and ../../car/strip_number != number and busy = 1">
																<span class="cost"><xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="cost/money" /><xsl:with-param name="ore" select="cost/ore" /><xsl:with-param name="honey" select="cost/honey" /><xsl:with-param name="oil" select="cost/oil" /></xsl:call-template></span>
																<xsl:call-template name="playerlink">
																	<xsl:with-param name="player" select="player" />
																</xsl:call-template>
															</xsl:when>
															<xsl:otherwise>
																<xsl:call-template name="playerlink">
																	<xsl:with-param name="player" select="player" />
																</xsl:call-template>
															</xsl:otherwise>
														</xsl:choose>
													</label>
												</li>
											</xsl:if>
										</xsl:for-each>
									</ul>
									<ul>
										<xsl:for-each select="vipnumbers/element">
											<xsl:if test="position() &gt;= count(../../vipnumbers/element) div 2">
												<li>
													<xsl:if test="player != 0 and player/id != ../../car/player">
														<xsl:attribute name="class">taken</xsl:attribute>
													</xsl:if>
													<xsl:if test="../../car/strip_number = number">
														<xsl:attribute name="current">current</xsl:attribute>
														<xsl:attribute name="class">my</xsl:attribute>
													</xsl:if>
													<input type="radio" name="number" value="{number}" id="car-vip-number-choose-{position()}">
														<xsl:if test="player != 0 and player/id != ../../car/player">
															<xsl:attribute name="style">display: none;</xsl:attribute>
														</xsl:if>
														<xsl:if test="../../car/strip_number = number"><xsl:attribute name="checked">checked</xsl:attribute><xsl:attribute name="current">current</xsl:attribute></xsl:if>
													</input>
													<label for="car-vip-number-choose-{position()}">
														<span class="car-number">
															<xsl:if test="player != 0">
																<xsl:attribute name="tooltip">1</xsl:attribute>
																<xsl:attribute name="title">Номер: <xsl:value-of select="fnumber" disable-output-escaping="yes" />||&lt;span class="brown"&gt;Куплен: <xsl:value-of select="date" />&lt;br /&gt;Цена: <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="cost/money" /><xsl:with-param name="ore" select="cost/ore" /><xsl:with-param name="honey" select="cost/honey" /><xsl:with-param name="oil" select="cost/oil" /></xsl:call-template> мёда&lt;/span&gt;</xsl:attribute>
															</xsl:if>
															<xsl:value-of select="fnumber" disable-output-escaping="yes" />
														</span> -
														<xsl:choose>
															<xsl:when test="player = 0">
																<span class="cost"><xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="cost/money" /><xsl:with-param name="ore" select="cost/ore" /><xsl:with-param name="honey" select="cost/honey" /><xsl:with-param name="oil" select="cost/oil" /></xsl:call-template></span>
															</xsl:when>
															<xsl:when test="player/id = ../../car/player and ../../car/strip_number != number and busy = 1">
																<span class="cost"><xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="cost/money" /><xsl:with-param name="ore" select="cost/ore" /><xsl:with-param name="honey" select="cost/honey" /><xsl:with-param name="oil" select="cost/oil" /></xsl:call-template></span>
																<xsl:call-template name="playerlink">
																	<xsl:with-param name="player" select="player" />
																</xsl:call-template>
															</xsl:when>
															<xsl:otherwise>
																<xsl:call-template name="playerlink">
																	<xsl:with-param name="player" select="player" />
																</xsl:call-template>
															</xsl:otherwise>
														</xsl:choose>
													</label>
												</li>
											</xsl:if>
										</xsl:for-each>
									</ul>
									<div class="hint" align="center">При покупке элитного номера он закрепляется за игроком навсегда. При смене машины элитный номер сохраняется.</div>
									<input type="hidden" name="car" value="{car/id}" />
									<div class="actions">
										<button class="button disabled" id="buy-number-button" disabled="disabled" type="submit">
											<span class="f">
												<i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Сохранить новый номер<span class="cost"></span></div>
											</span>
										</button>
										
									</div>
								</form>
							</div>
						</div>
						
						<div style="text-align:center; margin-top:5px;">
							<button class="button" type="button" onclick="$(this).parents('div.alert:first').hide();">
								<span class="f">
									<i class="rl"></i><i class="bl"></i><i class="brc"></i>
									<div class="c">Отмена</div>
								</span>
							</button>
						</div>
					</div>

				</div>
			</div>
			<span class="close-cross" onclick="$(this).parents('div.alert:first').hide();">&#215;</span>
		</div>
		<script type="text/javascript" src="/@/js/jquery.maskedinput.js"></script>
		<script type="text/javascript" src="/@/js/automobile_car.js"></script>
	</xsl:template>

</xsl:stylesheet>
