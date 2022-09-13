<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
            <div class="heading clear">
                <h2>Активация игрока</h2>
            </div>
            <div id="content" class="agreement">
                <div class="welcome">
                <div class="block-rounded">
                    <i class="tlc"></i>
                    <i class="trc"></i>
                    <i class="blc"></i>
                    <i class="brc"></i>
                    <div class="text">
                    
						<xsl:choose>
							<xsl:when test="player/accesslevel = -1">
								<p>Внимание, ваш персонаж депортирован. Для того, чтобы продолжить играть, воспользуйтесь <a href="#" onclick="$('#unlock').toggle();">дополнительными услугами</a>.</p>
							</xsl:when>
							<xsl:when test="player/accesslevel = -2">
								<p>Внимание, вы заморозили персонажа менее 48 часов назад. Чтобы разморозить персонажа, вы должны подождать окончания этого срока или воспользоваться <a href="#" onclick="$('#unlock').toggle();">дополнительными услугами</a>.</p>
								<p>Если вы зайдете через <span timer="{time}"></span>, то ваш персонаж автоматически разморозится.</p>
							</xsl:when>
						</xsl:choose>

						<xsl:choose>
							<xsl:when test="error = 'no money'">
								<p class="error" align="center">У вас не хватает денег.</p>
							</xsl:when>
						</xsl:choose>

						<div id="unlock" style="display: none;">
							<br />
							<xsl:choose>
								<xsl:when test="player/accesslevel = -1">
									<p>Разблокироваться сейчас - платно: <span class="med"><xsl:value-of select="format-number(costHoney, '###,###')" /><i></i></span></p>
								</xsl:when>
								<xsl:when test="player/accesslevel = -2">
									<p>Разморозиться сейчас - платно: <span class="med"><xsl:value-of select="format-number(costHoney, '###,###')" /><i></i></span></p>
								</xsl:when>
							</xsl:choose>
							<xsl:choose>
								<xsl:when test="player/honey &lt; costHoney">
									<p>У вас не хватает меда. Вы можете купить мед в <a href="/stash/">заначке</a>.</p>
								</xsl:when>
								<xsl:otherwise>
									<p><form action="/unlock/" method="post">
										<input type="hidden" name="action" value="unlock" />
										<button class="button" type="submit">
                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">
													<xsl:choose>
														<xsl:when test="player/accesslevel = -1">
															Разблокироваться
														</xsl:when>
														<xsl:when test="player/accesslevel = -2">
															Разморозиться
														</xsl:when>
													</xsl:choose>
													&#0160;— <span class="med"><xsl:value-of select="costHoney" /><i></i></span></div>
                                            </span>
                                        </button>
									</form></p>
								</xsl:otherwise>
							</xsl:choose>
						</div>
                    </div>
							</div>
                </div>

            </div>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>