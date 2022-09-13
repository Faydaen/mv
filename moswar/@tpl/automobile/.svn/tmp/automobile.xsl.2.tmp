<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>
    <xsl:include href="common/price.xsl" />

	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear"><h2>Автозавод</h2></div>
				<div id="content" class="auto">
					
					<div class="cars-build">
						<div class="welcome">
							<div class="block-rounded">
								<i class="tlc"></i>
								<i class="trc"></i>
								<i class="blc"></i>
								<i class="brc"></i>
								<div class="text clear">
									Умные инженеры знают, что автомобиль состоит из колес, руля, кузова и моторчика под капотом.
									<b>Постройте 4 цеха</b> и тогда вы сможете
									<b>собирать свой собственный автомобиль</b>. 
									<span class="dashedlink" onclick="$('#cars-bild-instruction').toggle();">Подробнее</span>
								</div>
								<div class="clear instruction" id="cars-bild-instruction">
									<xsl:if test="factory_1 = 0 or factory_2 = 0 or factory_3 = 0 or factory_4 = 0">
										<xsl:attribute name="style">display:block;</xsl:attribute>
									</xsl:if>
									<ul>
										<li>
											<b class="numeric">1</b>
											Награбь стройматериалы <a href="/alley/">в&#160;закоулках</a>
										</li>
										<li>
											<b class="numeric">2</b>
											<!-- Построй из&#160;них все атомобильные цеха -->
											Построй <nobr>по I уровню</nobr> каждого цеха
										</li>
										<li>
											<b class="numeric">3</b>
											Собери свой автомобиль
										</li>
										<li>
											<b class="numeric">4</b>
											И&#160;отправляйся <a href="/automobile/ride/">в&#160;поездку</a>
										</li>
									</ul>
									<span class="close-cross" onclick="$('#cars-bild-instruction').hide();">&#215;</span>
								</div>
								<div class="buildings">
									<b class="bulding-level-rul"><xsl:value-of select="factory_3" /></b>
									<b class="bulding-level-kuzov"><xsl:value-of select="factory_4" /></b>
									<b class="bulding-level-koleso"><xsl:value-of select="factory_1" /></b>
									<b class="bulding-level-motor"><xsl:value-of select="factory_2" /></b>
									<xsl:if test="available = 1">
									<map name="buildings-map">
										<area href="rul/" shape="polygon"
											coords="38, 303, 13, 182, 107, 144, 183, 187, 150, 303, 86, 331"
											onmouseover="$('b.bulding-level-rul').addClass('hover')" onmouseout="$('b.bulding-level-rul').removeClass('hover')"
											tooltip="1" title="{factory_3_name} [{factory_3}]||{factory_3_description}&lt;br /&gt;&lt;br /&gt;(кликните для постройки)" />
										<area href="kuzov/" shape="polygon"
											coords="168, 172, 143, 144, 146, 41, 227, 45, 226, 85, 306, 123, 294, 165, 250, 181"
											onmouseover="$('b.bulding-level-kuzov').addClass('hover')" onmouseout="$('b.bulding-level-kuzov').removeClass('hover')"
											tooltip="1" title="{factory_4_name} [{factory_4}]||{factory_4_description}&lt;br /&gt;&lt;br /&gt;(кликните для постройки)"
											/>
										<area href="koleso/" shape="polygon"
											coords="358, 171, 365, 94, 397, 62, 466, 47, 494, 80, 490, 129, 504, 136, 503, 160, 418, 205"
											onmouseover="$('b.bulding-level-koleso').addClass('hover')" onmouseout="$('b.bulding-level-koleso').removeClass('hover')"
											tooltip="1" title="{factory_1_name} [{factory_1}]||{factory_1_description}&lt;br /&gt;&lt;br /&gt;(кликните для постройки)"
											/>
										<area href="motor/" shape="polygon"
											coords="555, 357, 503, 319, 514, 225, 504, 204, 598, 160, 607, 189, 634, 176, 659, 213, 640, 243, 655, 280, 652, 310"
											onmouseover="$('b.bulding-level-motor').addClass('hover')" onmouseout="$('b.bulding-level-motor').removeClass('hover')"
											tooltip="1" title="{factory_2_name} [{factory_2}]||{factory_2_description}&lt;br /&gt;&lt;br /&gt;(кликните для постройки)"
											/>
									</map>
									</xsl:if>
									<img class="trees" src="/@/images/loc/auto/trees.png" usemap="#buildings-map" />
									<img class="bulding-rul" src="/@/images/loc/auto/building-rul-{factory_3_level}.png" />
									<img class="bulding-kuzov" src="/@/images/loc/auto/building-kuzov-{factory_4_level}.png" />
									<img class="bulding-koleso" src="/@/images/loc/auto/building-koleso-{factory_1_level}.png" />
									<img class="bulding-motor" src="/@/images/loc/auto/building-motor-{factory_2_level}.png" />
								</div>
							</div>
						</div>

						<xsl:if test="cooldown/end != 0">
							<a name="progress"></a>
							<table class="process">
								<tr>
									<td class="label"><xsl:choose><xsl:when test="state='upgrade_factory'">Строится </xsl:when><xsl:when test="state='create_car'">Собирается </xsl:when></xsl:choose><xsl:value-of select="cooldown/progress" />:</td>
									<td class="progress"><div class="exp"><div class="bar"><div><div id="cooldownbar" style="width: 0%;" class="percent"></div></div></div></div></td>
									<td class="value"><span id="cooldown" intitle="0" notitle="1" timer2="{cooldown/total}" timer="{cooldown/rest}" endtime="{cooldown/end}"></span>
										<xsl:if test="cooldown/honey != 0">
											<form action="/automobile/finishbuilding/" method="post" style="display: inline;">
												<button style="margin-left: 10px;" type="submit" class="button">
													<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div style="padding: 0pt 2px;" class="c">Достроить мгновенно - <span class="med"><xsl:value-of select="cooldown/honey" /><i></i></span></div>
													</span>
												</button>
											</form>
										</xsl:if>
									</td>
								</tr>
							</table>
						</xsl:if>

						<!--xsl:if test="factory_1 = 0 and factory_2 = 0 and factory_3 = 0 and factory_4 = 0">
							<div class="block-bordered">
								<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
								<div class="center clear">
									<h3>Где я?</h3>
									<div class="center clear">
									1. Собирай ресурсы<br />
									2. Построй по 1 уровню каждого цеха<br />
									3. Собери первый автомобиль<br />
									4. Отправься в поездку и получи <b>PROFIT!</b><br /><br />
									</div>
								</div>
								<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
							</div>
						</xsl:if-->

						<div class="block-bordered">
							<ins class="t l"><ins></ins></ins>
							<ins class="t r"><ins></ins></ins>
							<div class="center clear">
								<h3>Сборка автомобилей</h3>
								<div class="cars-produce">
									<xsl:choose>
										<xsl:when test="available = 1">
											<p align="center">Развивайте цеха, чтобы можно было собирать улучшенные автомобили.</p>
											<div class="cars-produce-choose">
												<div class="cars-produce-accordion">
													<ul>
														<xsl:for-each select="cars/element">
															<li>
																<xsl:choose>
																	<xsl:when test="disabled = 1">
																		<xsl:attribute name="class">button disabled</xsl:attribute><i class="icon-locked"></i>
																	</xsl:when>
																	<xsl:when test="../../cooldown/end != 0">
																		<i class="icon-locked"></i>
																	</xsl:when>
																</xsl:choose>
																<img src="{image}-big.png" tooltip="1" title="{name}||{description}" />
																<div class="name"><b><xsl:value-of select="name" /></b></div>
																<form action="/automobile/createcar/{id}/" method="post" style="display: inline;">
																	<xsl:if test="disabled != 1">
																		<button type="submit">
																			<xsl:choose>
																				<xsl:when test="../../cooldown/end != 0"><xsl:attribute name="class">button disabled</xsl:attribute><xsl:attribute name="onclick">return false;</xsl:attribute></xsl:when>
																				<xsl:otherwise><xsl:attribute name="class">button</xsl:attribute></xsl:otherwise>
																			</xsl:choose>
																			<span class="f">
																				<i class="rl"></i><i class="bl"></i><i class="brc"></i>
																				<div class="c">Собрать - 
																				<xsl:call-template name="showprice">
																					 <xsl:with-param name="money" select="cost/money" />
																					 <xsl:with-param name="ore" select="cost/ore" />
																					 <xsl:with-param name="oil" select="cost/oil" />
																					 <xsl:with-param name="nohoney" select="1" />
																				</xsl:call-template>
																				</div>
																			</span>
																		</button>
																	</xsl:if>
																</form>
																<div class="hover-area"></div>
															</li>
														</xsl:for-each>
													</ul>
												</div>
												<i class="arrow-left" id="cars-produce-choose-arrow-left"></i>
												<i class="arrow-right" id="cars-produce-choose-arrow-right"></i>
											</div>
										</xsl:when>
										<xsl:otherwise>
											<p>Чтобы начать собирать свои автомобили надо иметь 7-ой уровень</p>
										</xsl:otherwise>
									</xsl:choose>

									
									<input type="hidden" id="regions-choose-id" name="region" />
									<script type="text/javascript" src="/@/js/jquery.jcarousel.js"></script>
									<script type="text/javascript" src="/@/js/automobile.js"></script>
								</div>
							</div>
							<ins class="b l"><ins></ins></ins>
							<ins class="b r"><ins></ins></ins>
						</div>
					</div>
				</div>
			</div>
		</div>
	</xsl:template>
</xsl:stylesheet>
