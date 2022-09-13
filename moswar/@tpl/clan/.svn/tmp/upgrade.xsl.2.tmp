<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/price.xsl" />
    <xsl:include href="common/clan-error.xsl" />

    <xsl:template match="/data">
		<div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
			    <div class="heading clear"><h2>
					<xsl:choose>
						<xsl:when test="current/code = 'clan_pacifistcert'">
							Клановая миролюбивость
						</xsl:when>
						<xsl:otherwise>
							Клановая оборона
						</xsl:otherwise>
					</xsl:choose>
                </h2></div>
                <div id="content" class="clan">

					<div class="clan-slot-upgrade">

						<div class="block-bordered">
							<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
							<div class="center clear" align="center">
								<table class="progressbar" align="center">
									<tr>
										<td style="width:60%;">
											<ul class="stats">
												<li class="stat">
													<div class="label">
														<b>Уровень</b><span class="num">[<xsl:value-of select="current/itemlevel" />/<xsl:value-of select="maxlevels" />]</span>
													</div>
													<div class="bar"><div><div style="width:{percentlevel}%;" class="percent"></div></div></div>
												</li>
											</ul>
										</td>
										<td style="width:40%;">
											<xsl:choose>
												<xsl:when test="/data/money = 1 and current/itemlevel &lt; maxlevels">
													<form action="/clan/profile/upgrade/{code}/" method="post" align="center">
														<input type="hidden" name="code" value="{code}" />
														<input type="hidden" name="inventory" value="{inventory}" />
														<button class="button" type="submit"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Улучшить - <xsl:call-template name="showprice">
															<xsl:with-param name="money" select="next/money" />
															<xsl:with-param name="ore" select="next/ore" />
															<xsl:with-param name="honey" select="next/honey" />
														</xsl:call-template></div></span></button>
													</form>
												</xsl:when>
												<xsl:otherwise>
													<xsl:choose>
														<xsl:when test="current/itemlevel &lt; maxlevels">
															<p>Соберите необходимую сумму в казне клана и глава сможет улучшить этот предмет.</p>
														</xsl:when>
														<xsl:otherwise>
															<p></p>
														</xsl:otherwise>
													</xsl:choose>
												</xsl:otherwise>
											</xsl:choose>
										</td>
									</tr>
								</table>
							</div>
							<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
						</div>

						<ul class="objects" style="margin-bottom:20px;">
							<li class="object object-current">
								<h2><xsl:value-of select="current/name" /> [<xsl:value-of select="current/itemlevel" />] <span class="hint">— текущий уровень</span></h2>
								<div class="data">
									<div class="text">
										<h4>Описание</h4>
										<xsl:value-of select="current/info" />
									</div>
									<div class="characteristics">
										<h4>Воздействия</h4>
										<xsl:value-of select="current/unlockedby" />: <xsl:value-of select="current/itemlevel" /><br />
										<!--
										<h4>Требования</h4>
										Наличие: <br />
										-->
										<h4>Стоимость</h4>
										Покупка: <xsl:if test="current/money > 0"><span class="tugriki"><xsl:value-of select="current/money" /><i></i></span></xsl:if> <xsl:if test="current/ore > 0"><span class="ruda"><xsl:value-of select="current/ore" /><i></i></span></xsl:if> <xsl:if test="current/honey > 0"><span class="med"><xsl:value-of select="current/honey" /><i></i></span></xsl:if><br />
									</div>
									<i class="thumb"><img src="/@/images/obj/{current/image}" alt="" title="" /></i>
								</div>
							</li>
							<xsl:if test="current/itemlevel &lt; maxlevels">
								<li class="object">
									<h2><xsl:value-of select="next/name" /> [<xsl:value-of select="next/itemlevel" />] <span class="hint">— предстоящий уровень</span></h2>
									<div class="data">
										<div class="text">
											<h4>Описание</h4>
											<xsl:value-of select="next/info" />
										</div>
										<div class="characteristics">
											<h4>Воздействия</h4>
											<xsl:value-of select="next/unlockedby" />: <xsl:value-of select="next/itemlevel" /><br />
											<xsl:if test="next/clanlevel > 0">
												<h4>Требования</h4> Уровень клана: <xsl:value-of select="next/clanlevel" /><br />
											</xsl:if>
											<!--
											<h4>Требования</h4>
											Уровень: 1<br />
											-->
											<h4>Стоимость</h4>
											Покупка: <xsl:if test="next/money > 0"><span class="tugriki"><xsl:value-of select="next/money" /><i></i></span></xsl:if> <xsl:if test="next/ore > 0"><span class="ruda"><xsl:value-of select="next/ore" /><i></i></span></xsl:if> <xsl:if test="next/honey > 0"><span class="med"><xsl:value-of select="next/honey" /><i></i></span></xsl:if><br />
										</div>
										<i class="thumb"><img src="/@/images/obj/{next/image}" alt="" title="" /></i>
									</div>
								</li>
							</xsl:if>
						</ul>

						<xsl:if test="current/code = 'clan_pacifistcert'">
		                    <div class="block-bordered">
		                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
		                        <div class="center clear">
		                            <h3>Время пацифиста</h3>
		                            <form  class="clan-pacifist-time" action="/clan/profile/upgrade/{current/code}/" method="post">
		                                <input type="hidden" name="code" value="{current/code}" />
		                                <p>Пацифисты могут оградиться от нападений во время войны.
		                                Можно выбрать любое суточное время, когда нападения на бойцов признаются негуманными и поэтому не засчитываются. А также не начинаются групповые разборки.
		                                В это время бойцы могут поспать или искушать портвейна.</p>
                                        <p>У каждого клана свое «время пацифиста». Бои между кланами будут происходить и засчитываться только в промежуток, когда это время не действует.</p>

		                                <p class="now"><b>Время ненападения: <xsl:value-of select="current/itemlevel" /> час(а)</b><br />
		                                <b>Период ненападения: <xsl:value-of select="wpt" />:40 — <xsl:value-of select="wpt2" />:40</b></p>

		                                <xsl:choose>
		                                    <xsl:when test="war = 1">
		                                        <p><em>Вы не можете изменить время ненападения во время войны.</em></p>
		                                    </xsl:when>
                                            <xsl:when test="/data/diplomat = 1">
                                                <p class="set">
		                                            <select name="param">
		                                                <xsl:value-of select="wptselect" disable-output-escaping="yes" />
		                                            </select>
		                                            <br /><br />
		                                            <button class="button" type="submit">
		                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
		                                                    <div class="c">Указать время пацифиста</div>
		                                                </span>
		                                            </button>
		                                        </p>
                                            </xsl:when>
		                                    <xsl:otherwise>
		                                        <p><em>Только Глава клана, Заместитель главы и Дипломат могут устанавливать время ненападения.</em></p>
		                                    </xsl:otherwise>
		                                </xsl:choose>
		                                
		                            </form>
		                        </div>
		                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
		                    </div>
						</xsl:if>
					</div>
                </div>
            </div>
        </div>
	</xsl:template>
</xsl:stylesheet>