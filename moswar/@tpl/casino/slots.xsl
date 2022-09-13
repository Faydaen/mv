<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>
	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div id="musicSwf"></div>
				<div class="heading clear">
					<h2>Слот-автомат</h2>
				</div>
				<div id="content" class="casino">
					<div class="casino-slots">
						<div class="welcome">
							<div class="goback">
								<span class="arrow">◄</span>
								<a href="/casino/">Выйти в холл Казино</a>
							</div>

							<div class="corner-links">
								<div class="balance">
									<b>Баланс: </b>
									<span class="fishki">
										<span id="fishki-balance-num">
											<xsl:value-of select="chip" />
										</span>
										<i></i>
									</span>
									<a href="/casino/#exchange">Разменять</a>
								</div>
								<div class="chat-link">
									<a href="#" onclick="openChat('casino');">Включить чат</a>
								</div>
							</div>

							<div id="roll1">
								<div class="belt">
									<i class="icon pic-russia-1"></i>
									<i class="icon pic-russia-2"></i>
									<i class="icon pic-russia-3"></i>
									<i class="icon pic-russia-4"></i>
									<i class="icon pic-russia-5"></i>
									<i class="icon pic-russia-6"></i>
									<i class="icon pic-russia-7"></i>
									<i class="icon pic-russia-8"></i>
									<i class="icon pic-russia-9"></i>
								</div>
							</div>
							<div id="roll2">
								<div class="belt">
									<i class="icon pic-russia-1"></i>
									<i class="icon pic-russia-2"></i>
									<i class="icon pic-russia-3"></i>
									<i class="icon pic-russia-4"></i>
									<i class="icon pic-russia-5"></i>
									<i class="icon pic-russia-6"></i>
									<i class="icon pic-russia-7"></i>
									<i class="icon pic-russia-8"></i>
									<i class="icon pic-russia-9"></i>
								</div>
							</div>
							<div id="roll3">
								<div class="belt">
									<i class="icon pic-russia-1"></i>
									<i class="icon pic-russia-2"></i>
									<i class="icon pic-russia-3"></i>
									<i class="icon pic-russia-4"></i>
									<i class="icon pic-russia-5"></i>
									<i class="icon pic-russia-6"></i>
									<i class="icon pic-russia-7"></i>
									<i class="icon pic-russia-8"></i>
									<i class="icon pic-russia-9"></i>
								</div>
							</div>
							<div id="roll1-animation" style="display:none;"></div>
							<div id="roll2-animation" style="display:none;"></div>
							<div id="roll3-animation" style="display:none;"></div>
							<div class="roll1-shadow"></div>
							<div class="roll2-shadow"></div>
							<div class="roll3-shadow"></div>
							<div id="payline" style="display:none;"></div>
							<div id="tablo">
								<span class="fishki"><span><xsl:value-of select="jackpot" /></span><i></i></span>
							</div>

							<div class="actions">
								<div class="element" style="width:120px;">
									<button class="button" type="button" id="slots-roll-1">
										<span class="f">
											<i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Вертеть - <span class="fishki">10<i></i></span></div>
										</span>
									</button>
								</div>
								<div class="element" style="width:125px;">
									<button class="button" type="button" id="slots-roll-2">
										<span class="f">
											<i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Крутить - <span class="fishki2">20<i></i></span></div>
										</span>
									</button>
								</div>
								<div class="element" style="width:140px;">
									<button class="button" type="button" id="slots-roll-3">
										<span class="f">
											<i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Вращать - <span class="fishki3">30<i></i></span></div>
										</span>
									</button>
								</div>
							</div>

							<div id="slots-win-sum" style="display:none;"></div>

							<div class="block-rounded">
								<i class="tlc"></i>
								<i class="trc"></i>
								<i class="blc"></i>
								<i class="brc"></i>
								<div class="text clear">
									<div style="float:left; width:49%;">
										<table class="payout" id="slots-payout-table">
											<tr>
												<th>Ставка:</th>
												<th><span class="fishki"><i></i></span></th>
												<th><span class="fishki2"><i></i></span></th>
												<th><span class="fishki3"><i></i></span></th>
											</tr>
											<xsl:for-each select="table/element">
												<xsl:if test="position() &lt; 10">
													<xsl:call-template name="row" />
												</xsl:if>
											</xsl:for-each>
										</table>
									</div>
									<div style="float:right; width:49%;">
										<table class="payout" id="slots-payout-table">
											<tr>
												<th>Ставка:</th>
												<th><span class="fishki"><i></i></span></th>
												<th><span class="fishki2"><i></i></span></th>
												<th><span class="fishki3"><i></i></span></th>
											</tr>
											<xsl:for-each select="table/element">
												<xsl:if test="position() &gt; 9">
													<xsl:call-template name="row" />
												</xsl:if>
											</xsl:for-each>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="alert alert-error alert2" id="slots-error">
			<div class="padding">
				<h2>Ошибка</h2>
				<div class="clear data">
					<div class="text">
					</div>
					<div class="actions">
						<button class="button" type="button"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">OK</div></span></button>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="/@/js/casino_slots.js"></script>
	</xsl:template>
	<xsl:template name="row">
		<tr>
			<td class="lot" id="table-c-{s1}{s2}{s3}">
				<i class="icon thumb-{c1}{s1}"></i>
				<i class="icon thumb-{c2}{s2}"></i>
				<i class="icon thumb-{c3}{s3}"></i>
				<!-- <i class="icon thumb-any"></i> -->
			</td>
			<td class="win" id="table-c-{s1}{s2}{s3}-{v1}"><span class="fishki"><xsl:value-of select="v1" /><i></i></span></td>
			<td class="win" id="table-c-{s1}{s2}{s3}-{v2}"><span class="fishki"><xsl:value-of select="v2" /><i></i></span></td>
			<xsl:choose>
				<xsl:when test="v3 = 'j'">
					<td class="jackpot" id="table-c-{s1}{s2}{s3}-{v3}"><i class="icon thumb-jackpot"></i></td>
				</xsl:when>
				<xsl:otherwise>
					<td class="win" id="table-c-{s1}{s2}{s3}-{v3}"><span class="fishki"><xsl:value-of select="v3" /><i></i></span></td>
				</xsl:otherwise>
			</xsl:choose>
		</tr>
	</xsl:template>
</xsl:stylesheet>
