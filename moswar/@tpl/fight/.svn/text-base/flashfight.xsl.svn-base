<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
	
    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/npclink.xsl" />
    <xsl:include href="common/item.xsl" />
    <xsl:include href="common/stats.xsl" />
	
	<xsl:key name="act" match="element" use="position" />
	<xsl:key name="actbyid" match="element" use="id" />

	<xsl:template name="questbutton">
		<xsl:param name="quest" />
		<xsl:if test="quest/button != ''">
			<form action="/quest/" method="post" style="text-align: center;">
				<input type="hidden" name="action" value="nextstep" />
				<button class="button" type="submit">
					<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
						<div class="c"><xsl:value-of select="$quest/button" /></div>
					</span>
				</button>
			</form>
		</xsl:if>
	</xsl:template>
	
	<xsl:template name="actlink">
		<xsl:param name="act" />
        <xsl:choose>
            <xsl:when test="$act/nm != ''">
                <xsl:choose>
                    <xsl:when test="$act/type = 'pet'">
                        <b><xsl:value-of select="$act/nm" /></b>
                    </xsl:when>
                    <xsl:otherwise>
                        <b><xsl:value-of select="$act/nm" /> [<xsl:value-of select="$act/lv" />]</b>
                    </xsl:otherwise>
                </xsl:choose>
            </xsl:when>
            <xsl:otherwise>
                <xsl:choose>
                    <xsl:when test="$act/type = 'pet'">
                        <b><xsl:value-of select="$act/name" /></b>
                    </xsl:when>
                    <xsl:otherwise>
                        <b><xsl:value-of select="$act/nickname" /> [<xsl:value-of select="$act/level" />]</b>
                    </xsl:otherwise>
                </xsl:choose>
            </xsl:otherwise>
        </xsl:choose>
	</xsl:template>

	<xsl:template match="/data">
		<div class="column-right-topbg">
						<div class="column-right-bottombg" align="center">
							<div class="heading clear"><h2>
								<span class="boj"></span>
							</h2></div>
							<div id="content" class="fight">
								<div class="fight-animation">
									<div class="icon fight-animation-block">
										<div>
										
										<script>
											var flashvars = {battle: <xsl:value-of select="id" />, sk: "<xsl:value-of select="sk" />", xml: "<xsl:value-of select="xml" />"};
											var params = {};
											params.allowscriptaccess = "always";
											params.wmode = "opaque";
											var attributes = {};
											attributes.type = "application/x-shockwave-flash";
											attributes.id = "fightgame";
											attributes.name = "fightgame";
											swfobject.embedSWF("/@/other/fightgame/fightgame.swf", "fightSwf", "600", "400", "9.0.0", "expressInstall.swf", flashvars, params, attributes);
										</script>
										
										<div id="fightSwf">
											У вас не установлен Adobe Flash Player. Сейчас начнется автоматическая установка. Если не начентся, то Вы неудачник или специально отключили данный плагин =(
										</div>
										
										</div>
									
										<div class="actions">
											<div class="viewtext">
												<xsl:if test="count(quest/button) = 0">
													<a href="/alley/fight/{id}/{sk}/text/">Смотреть бой в текстовом виде</a>
												</xsl:if>
												<xsl:call-template name="questbutton">
													<xsl:with-param name="quest" select="quest" />
												</xsl:call-template>
											</div>
											<div class="icon controls"><i 
												id="controls-back" class="icon disabled icon-back" onclick="fightAnimationBack()"></i><i 
												id="controls-forward" class="icon icon-forward" onclick="fightAnimationForward()"></i>
											</div>
											<div class="viewresults" id="fight-animation-result-link" style="display:none;">
												<span class="dashedlink" onclick="fightAnimationResultShow();">Результаты боя</span>
											</div>
										</div> 
									</div>
							
									<div class="alert" id="fight-animation-result" style="display:none;">
										<div class="padding">
											<h2>
												Результат боя №<a href="/alley/fight/{id}/{sk}/text/"><xsl:value-of select="id" /></a><br />
												<xsl:value-of select="time" /> (<xsl:value-of select="date" />)
											</h2>
											<div class='data'>
												<div id="fight-log">
													<div class="result">
														<xsl:choose>
															<xsl:when test="winner != 0">
																<div>
																	Победитель:
																	<b><xsl:call-template name="actlink"><xsl:with-param name="act" select="key('actbyid',winner)" /></xsl:call-template></b>
																</div>
																
																<div>
																	<b><xsl:call-template name="actlink"><xsl:with-param name="act" select="key('actbyid',winner)" /></xsl:call-template></b> получает
																	<xsl:choose>
																		<xsl:when test="count(params/pft) > 0">
																			<xsl:if test="params/pft/m > 0">
																				<span class="tugriki" title="Монеты: {params/pft/m}"><xsl:value-of select="format-number(params/pft/m, '###,###,###')" /><i></i></span>
																			</xsl:if>
																			<xsl:if test="params/pft/o > 0">
																				<span class="ruda" title="Руда: {params/pft/o}"><xsl:value-of select="format-number(params/pft/o, '###,###,###')" /><i></i></span>
																			</xsl:if>
																			<xsl:if test="params/pft/n > 0">
																				<span class="neft" title="Нефть: {params/pft/n}"><xsl:value-of select="format-number(params/pft/n, '###,###,###')" /><i></i></span>
																			</xsl:if>
																		</xsl:when>
																		<xsl:otherwise>
																			<span class="tugriki" title="Монет: {profit}"><xsl:value-of select="format-number(profit, '###,###,###')" /><i></i></span>
																		</xsl:otherwise>
																	</xsl:choose>
																	<span class="expa"><xsl:value-of select="exp" /><i></i></span>
																	<xsl:if test="count(params/carpart) != 0">
																		<span class="object-thumb">
																			<img src="{params/carpart/i}" alt="{params/carpart/name}"  tooltip="1" title="{params/carpart/n}||Полезная вещь в строительстве автомобильных цехов." />
																			<span class="count"><xsl:value-of select="format-number(params/carpart/c, '###,###,###')" /></span>
																		</span>
																	</xsl:if>
																</div>
																
																<xsl:if test="params/zub = 1">
																	<div>
																		<b><xsl:call-template name="actlink"><xsl:with-param name="act" select="key('act',0)" /></xsl:call-template></b>
																		выбивает <!--i class="tooth"></i-->зуб у
																		<b><xsl:call-template name="actlink"><xsl:with-param name="act" select="key('act',1)" /></xsl:call-template></b>.
																	</div>
																</xsl:if>
																<xsl:if test="params/utug > 0">
																	<div class="hint">
																		<b><xsl:call-template name="actlink"><xsl:with-param name="act" select="key('act',0)" /></xsl:call-template></b>
																		при помощи раскаленного утюга уговаривает
																		<b><xsl:call-template name="actlink"><xsl:with-param name="act" select="key('act',1)" /></xsl:call-template></b>
																		отдать на <xsl:value-of select="params/utug" />% больше монет.
																	</div>
																</xsl:if>

																<xsl:if test="count(params/hnt) > 0">
																	<div>
																		<b><xsl:call-template name="actlink"><xsl:with-param name="act" select="key('act',0)" /></xsl:call-template></b> получает 
																		<span class="badge"><xsl:value-of select="params/hnt/b" /><i></i></span>
																		<xsl:if test="params/hnt/a > 0">
																			<span class="tugriki"><xsl:value-of select="params/hnt/a" /><i></i></span>
																		</xsl:if>
																		за удачную охоту 
																		<xsl:if test="params/hnt/m = 1">
																			и даже отжимает <span class="mobila"><i></i>мобилу</span> 
																			у&#160;<b><xsl:call-template name="actlink"><xsl:with-param name="act" select="key('act',1)" /></xsl:call-template></b>
																		</xsl:if>.
																	</div>
																</xsl:if>

															</xsl:when>
															<xsl:otherwise>
																<div align="center">Ничья!
																	<xsl:if test="flag > 0">
																		<br /><b><xsl:call-template name="actlink"><xsl:with-param name="act" select="key('actbyid',flag)" /></xsl:call-template></b> сохраняет флаг.
																	</xsl:if>
																</div>
															</xsl:otherwise>
														</xsl:choose>
														<xsl:if test="count(/data/duellogtext) = 1">
															<xsl:value-of select="/data/duellogtext" disable-output-escaping="yes" />
														</xsl:if>
													</div>
												</div>
												<div class="actions">
													<xsl:if test="count(quest/button) = 0">
														<xsl:choose>
															<xsl:when test="count(backlink) > 0">
																<div class="button">
																	<a class="f" href="{backlink/url}"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																		<div class="c"><xsl:value-of select="backlink/name" /></div>
																	</a>
																</div>
															</xsl:when>
															<xsl:otherwise>
																<div class="button">
																	<a class="f" href="/alley/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																		<div class="c">В закоулки</div>
																	</a>
																</div>
															</xsl:otherwise>
														</xsl:choose>
													</xsl:if>
													<xsl:call-template name="questbutton">
														<xsl:with-param name="quest" select="quest" />
													</xsl:call-template>
												</div>
											</div>
										</div>
										<span class="close-cross" onclick="fightAnimationResultHide();">&#215;</span>
									</div>
								
								</div>

							</div>
						</div>
					</div>
	</xsl:template>

</xsl:stylesheet>