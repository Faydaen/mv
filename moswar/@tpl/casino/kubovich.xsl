<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>

	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Кубович</h2>
				</div>
				<div id="content" class="casino">
							
					<div class="kubovich">
						<div class="welcome">
							<div class="goback">
								<span class="arrow">◄</span>
								<a href="/casino/">Выйти в холл Казино</a>
							</div>
							<div class="corner-links">
								<div class="balance">
									<b>Баланс: </b>
									<span class="fishki"><span id="fishki-balance-num"><xsl:value-of select="chip" /></span><i></i></span>
									<a href="/casino/#exchange">Разменять</a>
								</div>
								<div class="chat-link">
									<a href="#" onclick="openChat('casino');">Включить чат</a>
								</div>
							</div>
							<div class="reel-place">
								<div class="icon reel">
									<div class="objects" id="prizes">
										<xsl:if test="ready = 1">
											<xsl:for-each select="prizes/element">
												<span>
													<xsl:attribute name="class">object prize<xsl:value-of select="position()" /></xsl:attribute>
													<img src="{image}" tooltip="1" title="{name}||{description}" />
												</span>
											</xsl:for-each>
										</xsl:if>
									</div>
									<div id="reel-turning" class=""></div>
									<div class="reel-bw"></div>
									<i class="icon owl"></i>
								</div>
								<div id="kubovich-smile"></div>
											
								<div class="controls">
									<table align="center">
										<tr>
											<td>
												<div style="float: left; background: #F3B643;">
													<button class="button" type="button" id="push">
														<xsl:choose>
															<xsl:when test="step = 10 or ready = 0"><xsl:attribute name="class">button disabled</xsl:attribute></xsl:when>
															<xsl:otherwise><xsl:attribute name="class">button</xsl:attribute></xsl:otherwise>
														</xsl:choose>
														<span class="f">
															<i class="rl"></i>
															<i class="bl"></i>
															<i class="brc"></i>
															<div class="c">Крутить барабан 
																<span class="cost"> -
																	<xsl:choose>
																		<xsl:when test="ready = 0">скоро</xsl:when>
																		<xsl:when test="step = 10">завтра</xsl:when>
																		<xsl:otherwise>
																			<xsl:choose>
																				<xsl:when test="cost = 0">бесплатно</xsl:when>
																				<xsl:otherwise>
																					<span class="fishki">
																						<xsl:value-of select="cost" />
																						<i>
																							<xsl:if test="cost = 0">
																								<xsl:attribute name="style">width: 1px; background:none;</xsl:attribute>
																							</xsl:if>
																						</i>
																					</span>
																				</xsl:otherwise>
																			</xsl:choose>
																		</xsl:otherwise>
																	</xsl:choose>
																</span>
															</div>
														</span>
													</button>
												</div>
											</td>
											<td class="supergame">
												<div class="padding">
													<div class="icon cellbar">
														<div class="bar"><div><div class="percent" style="">
															<xsl:choose>
																<xsl:when test="progress = 0">
																	<xsl:attribute name="style">width: 0px; display: none;</xsl:attribute>
																</xsl:when>
																<xsl:otherwise>
																	<xsl:attribute name="style">width: <xsl:value-of select="progress" />%;</xsl:attribute>
																</xsl:otherwise>
															</xsl:choose>
														</div></div></div>
													</div>
													<button title="Желтый Барабан доступен только для активных игроков. Играйте чаще и он придёт к Вам." type="button" id="push-ellow">
														<xsl:choose>
															<xsl:when test="progress = 100 and ready = 1">
																<xsl:attribute name="class">button</xsl:attribute>
															</xsl:when>
															<xsl:otherwise>
																<xsl:attribute name="class">button disabled</xsl:attribute>
															</xsl:otherwise>
														</xsl:choose>
														<span class="f">
															<i class="rl"></i>
															<i class="bl"></i>
															<i class="brc"></i>
															<div class="c">Желтый барабан<i class="icon reel-yellow"></i></div>
														</span>
													</button>
												</div>
											</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="block-rounded">
								<i class="tlc"></i>
								<i class="trc"></i>
								<i class="blc"></i>
								<i class="brc"></i>
								<div class="text clear">
									<h3>Не надо слов, просто крутите барабан!</h3>
									<div id="steps" class="clear " style="float:right; width:200px; margin:0 0 0 10px">
											<xsl:for-each select="steps/element">

											</xsl:for-each>
										<div style="float:left; margin-right:10px;">
											<table class="list">
												<xsl:for-each select="steps/element">
													<xsl:if test="position() &lt; 6">
														<xsl:call-template name="step" />
													</xsl:if>
												</xsl:for-each>
											</table>
										</div>
										<div style="float:left;">
											<table class="list">
												<xsl:for-each select="steps/element">
													<xsl:if test="position() &gt; 5 and position() &lt; 11">
														<xsl:call-template name="step" />
													</xsl:if>
												</xsl:for-each>
											</table>
										</div>
									</div>
									<div class="ready-false">
										<xsl:if test="ready = 1"><xsl:attribute name="style">display: none;</xsl:attribute></xsl:if>
										<h3>Кубович устал</h3>
										На сегодня игра «Сова Чудес» оконченна. Следующая игра начнется завтра утром, днем или может быть вечером. Никто не знает когда ведущий оправится от предыдущих «подарков».
									</div>
									<div class="ready-true">
										<xsl:if test="ready = 0"><xsl:attribute name="style">display: none;</xsl:attribute></xsl:if>
										<h3>Играем сегодня</h3>
										Каждый игрок, начиная и игру непременно вручает Кубовичу банку солений. К сожалению наш ведущий не в силах съесть все соления, что ему приносят и уже через 4 часа после начала вынужден взять перерыв.<br />
										<xsl:if test="ready = 1">
										Кубович пойдёт отдыхать через: <span intitle="0" notitle="1" timer="{timer/rest}" endtime="{timer/end}"></span>
										</xsl:if>
									</div>
												Ежедневно, каждому столичнику выпадает счастье сыграть с Кубовичем.
												Правила еще проще, чем на телеэкране: никаких слов угадывать не надо, просто крутите барабан и выигрывайте призы.
									<b>Чем чаще крутите барабан, тем слаще призы.</b> Однако, не более 10 раз в сутки.
												Причем 
									<b>первое суточное кручение — бесплатно.</b>
								</div>
							</div>
						</div>			
					</div>
				</div>
			</div>
		</div>
		<div class="alert" id="kubovich-message">
			<div class="padding">
				<h2>Кубович говорит</h2>
				<div class="clear data">
					<div class="text">
					</div>
					<div class="actions">
						<button class="button" type="button"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">OK</div></span></button>
					</div>
				</div>
			</div>
		</div>
		<div class="alert alert-error alert2" id="kubovich-error">
			<div class="padding">
				<h2>Кубович говорит</h2>
				<div class="clear data">
					<div class="text">
					</div>
					<div class="actions">
						<button class="button" type="button"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">OK</div></span></button>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="/@/js/casino_kubovich.js"></script>
	</xsl:template>
	<xsl:template name="step">
		<tr>
			<xsl:if test="(position() - 1) =  ../../step and ../../ready = 1">
				<xsl:attribute name="class">my</xsl:attribute>
			</xsl:if>
			<td class="num"><xsl:value-of select="position()" />.</td>
			<td class="cost">
				<span class="fishki">
					<xsl:choose>
						<xsl:when test="current() = 0">бесплатно</xsl:when>
						<xsl:otherwise><xsl:value-of select="current()" /></xsl:otherwise>
					</xsl:choose>
					<i>
						<xsl:if test="current() = 0">
							<xsl:attribute name="style">width: 1px; background:none;</xsl:attribute>
						</xsl:if>
					</i>
				</span>
			</td>
		</tr>
	</xsl:template>
</xsl:stylesheet>
