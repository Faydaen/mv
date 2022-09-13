<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>

	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear"><h2>Поездка</h2></div>
				<div id="content" class="auto">
					<div class="cars-trip">
						<div class="welcome">
							<div class="block-rounded">
								<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
								<div class="text clear">
									<div class="goback"><span class="arrow">&#9668;</span><a href="/home/">В хату</a></div>
									<img align="left" src="/@/images/obj/collections/1-loot.png" style="margin:-6px 10px -6px 2px;" />
									Хватит сидеть дома. Пакуйте чемоданы и наводите марафет. Пора сесть за руль и&#160;куда-нибудь съездить.
									Поездка позволит отдохнуть и набраться сил.
									<div class="hint" style="margin-top:6px;">
										Разные поездки требуют подходящих тачек. Вы их можете создать на <a href="/automobile/">Автозаводе</a>.
									</div>
								</div>
							</div>
						</div>

						<div class="cars-trip-choose">
							<div class="cars-trip-accordion">
								<ul>
									<xsl:for-each select="rides/element">
										<li id="direction-{id}">
											<xsl:if test="disabled = 1"><xsl:attribute name="class">locked</xsl:attribute></xsl:if>
											<div class="block-rounded">
												<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
												<div class="picture" style="background:url({image}.jpg);" tooltip="1">
													<xsl:attribute name="title"><xsl:value-of select="name" />||<xsl:value-of select="bonus" disable-output-escaping="yes" /></xsl:attribute>
													<xsl:if test="cooldown != 0">
														<span class="timeout"><i class="icon-locked-small"></i><br /><span intitle="0" class="ride-cooldown" trigger="automobileRideCheck({id});" notitle="1" timer="{cooldown/rest}" endtime="{cooldown/end}"></span></span>
													</xsl:if>
												</div>
												<h3><xsl:value-of select="name" /></h3>
												<div class="actions">
													<form action="/automobile/ride/" method="post">
														<input type="hidden" name="direction" value="{id}" />
														<input type="hidden" class="car-id" name="car" value="{car/id}" />
														<button class="button ride-button" type="submit">
															<xsl:choose>
																<xsl:when test="car/cooldown/end != 0 or cooldown != 0 or car/disabled = 1">
																	<xsl:attribute name="class">button ride-button disabled</xsl:attribute>
																	<xsl:attribute name="disabled">disabled</xsl:attribute>
																</xsl:when>
																<xsl:otherwise>
																	<xsl:attribute name="class">button ride-button</xsl:attribute>
																</xsl:otherwise>
															</xsl:choose>
															<span class="f">
																<i class="rl"></i><i class="bl"></i><i class="brc"></i>
																<div class="c">Съездить</div>
															</span>
														</button>
													</form>
												</div>
												<div class="require">
													Минимум для поездки требуется:<br />
													<span class="object-thumb">
														<div class="car-place">
															<xsl:if test="car/disabled = 1">
																<span class="timeout">
																	<i class="icon-locked-small"></i>
																</span>
															</xsl:if>
															<xsl:if test="car/cooldown/end != 0">
																<span class="timeout" tooltip="1" title="Машина в сервисе||Машина на техосмотре после поездки. Воспользоваться ею можно будет через некоторое время.">
																	<i class="icon-locked-small"></i><br />
																	<span intitle="0" notitle="1" class="car-cooldown" trigger="automobileRideCheck({id});" timer="{car/cooldown/rest}" endtime="{car/cooldown/end}"></span>
																</span>
															</xsl:if>
															<img src="{car/image}.png" tooltip="1">
																<xsl:attribute name="title"><xsl:value-of select="car/name" />||<xsl:value-of select="car/description" disable-output-escaping="yes" /><xsl:value-of select="car/stats" disable-output-escaping="yes" /></xsl:attribute>
															</img>
														</div>
													</span>
													<br />
													Время поездки: <xsl:value-of select="time" />&#0160;
													<span class="success decrease">
														<xsl:value-of select="car/decrease" />
													</span>
													<xsl:if test="has_another = 1">
														<div><span class="dashedlink car-choose-link" level="{level}" direction="{id}">Выбрать другую тачку</span></div>
													</xsl:if>
												</div>
												<xsl:if test="disabled = 1">
													<div class="hover-area" tooltip="1">
														<xsl:attribute name="title"><xsl:value-of select="name" />||<xsl:value-of select="bonus" disable-output-escaping="yes" /></xsl:attribute>
													</div>
												</xsl:if>
												<xsl:if test="disabled = 1"><i class="icon-locked" tooltip="1" title="Поездка недоступна||Для этой поездки вам необходимо обзавестись машиной не хуже, чем &lt;strong&gt;{car/name}&lt;/strong&gt;&lt;br /&gt;&lt;center&gt;&lt;img src='{car/image}.png' /&gt;&lt;/center&gt;"></i></xsl:if>
											</div>
										</li>
									</xsl:for-each>
								</ul>
							</div>
							<i class="arrow-left-circle" id="cars-trip-choose-arrow-left"></i>
							<i class="arrow-right-circle" id="cars-trip-choose-arrow-right"></i>

							<div id="cars-trip-choose" class="alert" style="display:none;">
								<div class="padding">
									<h2 id="alert-title">Выберите тачку для поездки</h2>
									<div class="data clear">
										<div class="objects">
											<xsl:for-each select="cars/element">
												<span class="object-thumb" level="{level}" decrease="{decrease}" carid="{id}">
													<div class="car-place">
														<xsl:if test="cooldown/end != 0">
															<span class="timeout" tooltip="1" title="Машина в сервисе||Машина на техосмотре после поездки. Воспользоваться ею можно будет через некоторое время." tip="Машина в сервисе||Машина на техосмотре после поездки. Воспользоваться ею можно будет через некоторое время.">
																<i class="icon-locked-small"></i><br /><span class="car-cooldown" intitle="0" notitle="1" timer="{cooldown/rest}" endtime="{cooldown/end}"></span>
															</span>
														</xsl:if>
														<img src="{image}.png" tooltip="1">
															<xsl:attribute name="title"><xsl:value-of select="name" />||<xsl:value-of select="description" disable-output-escaping="yes" /><xsl:value-of select="stats" disable-output-escaping="yes" /></xsl:attribute>
															<xsl:attribute name="tip"><xsl:value-of select="name" />||<xsl:value-of select="description" disable-output-escaping="yes" /><xsl:value-of select="stats" disable-output-escaping="yes" /></xsl:attribute>
														</img>
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

						</div>
						<input type="hidden" id="regions-choose-id" name="region" />
						<script type="text/javascript" src="/@/js/jquery.jcarousel.js"></script>
						<script type="text/javascript" src="/@/js/automobile_ride.js"></script>
					</div>
				</div>
			</div>
		</div>
	</xsl:template>

</xsl:stylesheet>
