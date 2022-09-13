<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
	<xsl:include href="general.xsl" />
	<xsl:key name="act" match="element" use="position" />
	<xsl:key name="actbyid" match="element" use="id" />
    <xsl:template match="/data">
	<div class="column-right-topbg">
	    <div class="column-right-bottombg" align="center">
		<div class="heading clear">
		    <h2>
			<span class="boj"></span>
		    </h2>
		</div>
		<div id="content" class="fight">
		    <h3 class="curves clear">
			<div class="fighter1">
				<xsl:call-template name="playerlink">
					<xsl:with-param name="player" select="key('act',0)" />
				</xsl:call-template>
			</div>
			<div class="fighter2">
			    <xsl:call-template name="playerlink">
					<xsl:with-param name="player" select="key('act',1)" />
					<xsl:with-param name="link" select="0" />
				</xsl:call-template>
			</div>
		    </h3>

		    <table class="layout">
			<tr>
			    <td class="fighter1-cell" align="left">
					<ul class="slots">
						<li class="slot1">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/weapon" />
							</xsl:call-template>
						</li>
						<li class="slot2">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/cloth" />
							</xsl:call-template>
						</li>
						<li class="slot3">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/pouch" />
							</xsl:call-template>
						</li>
						<li class="slot4">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/cologne" />
							</xsl:call-template>
						</li>
						<li class="slot5">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/talisman" />
							</xsl:call-template>
						</li>
						<li class="slot6">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/accessory1" />
							</xsl:call-template>
						</li>
						<li class="slot7">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/accessory2" />
							</xsl:call-template>
						</li>
						<li class="slot8">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/accessory3" />
							</xsl:call-template>
						</li>
						<li class="slot9">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/accessory4" />
							</xsl:call-template>
						</li>
						<li class="slot10">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/accessory5" />
							</xsl:call-template>
						</li>
						<li class="avatar">
							<img src="/@/images/pers/{key('act',0)/avatar}" />
						</li>
						<li class="slot-pet">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/pet" />
							</xsl:call-template>
						</li>
				    </ul>
				</td>
				<td class="vs">
				    <div>
					<spacer />
				    </div>
				</td>
				<td class="fighter2-cell" align="right">
				    <ul class="slots">
						<li class="slot1">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/weapon" />
							</xsl:call-template>
						</li>
						<li class="slot2">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/cloth" />
							</xsl:call-template>
						</li>
						<li class="slot3">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/pouch" />
							</xsl:call-template>
						</li>
						<li class="slot4">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/cologne" />
							</xsl:call-template>
						</li>
						<li class="slot5">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/talisman" />
							</xsl:call-template>
						</li>
						<li class="slot6">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/accessory1" />
							</xsl:call-template>
						</li>
						<li class="slot7">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/accessory2" />
							</xsl:call-template>
						</li>
						<li class="slot8">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/accessory3" />
							</xsl:call-template>
						</li>
						<li class="slot9">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/accessory4" />
							</xsl:call-template>
						</li>
						<li class="slot10">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/accessory5" />
							</xsl:call-template>
						</li>
						<li class="avatar">
							<img src="/@/images/pers/{key('act',1)/avatar}" />
						</li>
						<li class="slot-pet">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/pet" />
							</xsl:call-template>
						</li>
				    </ul>
				    </td>
				</tr>
			    </table>

			    <table class="data">
				<tr>
				    <td class="fighter1">
					<div class="block-rounded" style="background-color:#f5cf6e;">
					    <i class="tlc"></i>
					    <i class="trc"></i>
					    <i class="blc"></i>
					    <i class="brc"></i>
					    <div class="life">
						Жизни:
						<span id="fighter1-life"><xsl:value-of select="key('act',0)/hp" />/<xsl:value-of select="key('act',0)/maxhp" /></span>
						<div class="bar">
						    <div>
							<div class="percent" style="width:{key('act',0)/procenthp}%;"></div>
						    </div>
						</div>
					    </div>
					</div>

					<div class="block-rounded" style="background-color:#f7b142;">
					    <i class="tlc"></i>
					    <i class="trc"></i>
					    <i class="blc"></i>
					    <i class="brc"></i>
					    <xsl:call-template name="stats">
							<xsl:with-param name="player" select="key('act',0)" />
						</xsl:call-template>
					</div>
				    </td>
				    <td class="log">
					<div id="timer-block">
					    Тик-так:
					    <span id="time-left">5</span>
					</div>
					<ul id="fight-log">
					    <li class="result">
						<!--
						Если один из бойцов = игрок, то в зависимости от победившего надо написать Победа! / Поражение! / Ничья!
						<h2>Победа!</h2>
						-->
						<h3>Результат боя №
						    <a href="/alley/fight/{id}/"><xsl:value-of select="id" /></a>
						    <br />
						 <xsl:value-of select="time" /> (<xsl:value-of select="date" />)
						</h3>
						<xsl:choose>
							<xsl:when test="winner > 0">
								<div>Победитель:
									<b><xsl:value-of select="key('actbyid',winner)/nickname" /> [<xsl:value-of select="key('actbyid',winner)/level" />]</b>
								</div>
								<div>
									<b><xsl:value-of select="key('actbyid',winner)/nickname" /> [<xsl:value-of select="key('actbyid',winner)/level" />]</b> получил
									<span class="tugriki" title="Монет: {profit}"><xsl:value-of select="profit" /><i></i></span>
									<span class="expa"><xsl:value-of select="exp" /><i></i></span>
								</div>
							</xsl:when>
							<xsl:otherwise>
								<div align="center">Ничья!</div>
							</xsl:otherwise>
						</xsl:choose>
					    </li>
						<xsl:for-each select="log/element">
							<li rel="{current()/element[2]/element[1]}/{key('act', 0)/maxhp}:{current()/element[2]/element[2]}/{key('act', 1)/maxhp}">
							<h4>
								<b>Ход <xsl:value-of select="count(/data/log/element) - position() + 1" /></b>
							</h4>
							<xsl:variable name="item" select="current()" />
							<xsl:for-each select="$item/element[1]/element">
								<xsl:variable name="step" select="current()" />
								<xsl:variable name="stepp" select="position()" />
								<xsl:element name="div">
									<xsl:if test="current()/element[3]/element[1] = 2 or current()/element[3]/element[1] = 3">
										<xsl:attribute name="class">critical</xsl:attribute>
									</xsl:if>
									<xsl:for-each select="$step/element[3]/element[3]/element">
										<xsl:choose>
											<xsl:when test="current() = '1'">
												<xsl:call-template name="actlink">
													<xsl:with-param name="act" select="key('act',$step/element[1])" />
												</xsl:call-template>
											</xsl:when>
											<xsl:when test="current() = '2'">
												<xsl:call-template name="actlink">
													<xsl:with-param name="act" select="key('act',$step/element[2])" />
												</xsl:call-template>
											</xsl:when>
											<xsl:otherwise><xsl:value-of select="current()" /></xsl:otherwise>
										</xsl:choose>
									</xsl:for-each>
									<xsl:if test="current()/element[3]/element[1] != 0"> (-<xsl:value-of select="current()/element[3]/element[2]" />)</xsl:if>
								</xsl:element>
							</xsl:for-each>
							</li>
						</xsl:for-each>
					    <li rel="{key('act', 0)/hp}/{key('act', 0)/maxhp}:{key('act', 1)/hp}/{key('act', 1)/maxhp}">
						<h4>
						    <b>Начало</b>
						</h4>
						<div>На часах показывало <xsl:value-of select="time" /> (<xsl:value-of select="date" />).</div>
						<div>
							<xsl:for-each select="attack-string/element">
								<xsl:choose>
									<xsl:when test="current() = '1'">
										<xsl:call-template name="actlink">
											<xsl:with-param name="act" select="key('act',0)" />
										</xsl:call-template>
									</xsl:when>
									<xsl:when test="current() = '2'">
										<xsl:call-template name="actlink">
											<xsl:with-param name="act" select="key('act',1)" />
										</xsl:call-template>
									</xsl:when>
									<xsl:otherwise><xsl:value-of select="current()" /></xsl:otherwise>
								</xsl:choose>
							</xsl:for-each>
						</div>
					    </li>
					</ul>
					<script type="text/javascript">
						<xsl:choose>
							<xsl:when test="interactive = '1'">
								var interactive = true; /* для режима боя */
							</xsl:when>
							<xsl:otherwise>
								var interactive = false; /* для режима боя */
							</xsl:otherwise>
						</xsl:choose>
						<![CDATA[

						var timer;
						var timeleft = 3;

						function showLog(element){
						    if(!element) element = $("#fight-log li:hidden:last");
						    element.slideDown("normal");
						    lifes = element.attr("rel").split(":");

						    fighter1_life = lifes[0].split("/")
						    $("#fighter1-life").html(Math.max(fighter1_life[0], 0) + '/' + fighter1_life[1]);
						    $("#fighter1-life").parent().find("div.percent").animate( { width: Math.ceil(100*fighter1_life[0]/fighter1_life[1]) + "%" }, 1500 );

						    fighter2_life = lifes[1].split("/")
						    $("#fighter2-life").html(Math.max(fighter2_life[0], 0) + '/' + fighter2_life[1]);
						    $("#fighter2-life").parent().find("div.percent").animate( { width: Math.ceil(100*fighter2_life[0]/fighter2_life[1]) + "%" }, 1500 );
						}

						function fighttimer(){
						    $("#time-left").html(timeleft);
						    timeleft--;
						    if(timeleft < 0){
							var element = $("#fight-log li:hidden:last");
							timeleft = 3;
							var lifes;
							var fighter1_life, fighter2_life;
							if(1 == $("#fight-log li").index(element)) {
							    timeleft = 3;
							    $("#timer-block").hide();
							    showLog(element);
							} else if(0 == $("#fight-log li").index(element)) {
							    showLog(element);
								$('#timer-block').hide();
							    window.clearInterval(timer);
							} else {
							    showLog(element)
							}
						    }
						}
						$(document).ready(function(){
							if(interactive) {
								showLog();
								timer = window.setInterval("fighttimer()",1000);
							} else {
								$("#fight-log li").show();
								$('#timer-block').hide();
								lifes = $('#fight-log > li[rel]').attr("rel").split(":");
								fighter1_life = lifes[0].split("/");
								$("#fighter1-life").html(Math.max(fighter1_life[0], 0) + '/' + fighter1_life[1]);
								$("#fighter1-life").parent().find("div.percent").animate( { width: Math.ceil(100*Math.max(fighter1_life[0], 0)/fighter1_life[1]) + "%" }, 1500 );
								fighter2_life = lifes[1].split("/");
								$("#fighter2-life").html(Math.max(fighter2_life[0], 0) + '/' + fighter2_life[1]);
								$("#fighter2-life").parent().find("div.percent").animate( { width: Math.ceil(100*Math.max(fighter2_life[0], 0)/fighter2_life[1]) + "%" }, 1500 );
							}
						});
						]]>
					</script>

				    </td>
				    <td class="fighter2">
					<div class="block-rounded" style="background-color:#f5cf6e;">
					    <i class="tlc"></i>
					    <i class="trc"></i>
					    <i class="blc"></i>
					    <i class="brc"></i>
					    <div class="life">
						Жизни:
						<span id="fighter2-life"><xsl:value-of select="key('act',1)/hp" />/<xsl:value-of select="key('act',1)/maxhp" /></span>
						<div class="bar">
						    <div>
							<div class="percent" style="width:{key('act',1)/procenthp}%;"></div>
						    </div>
						</div>
					    </div>
					</div>

					<div class="block-rounded" style="background-color:#f7b142;">
					    <i class="tlc"></i>
					    <i class="trc"></i>
					    <i class="blc"></i>
					    <i class="brc"></i>
					    <xsl:call-template name="stats">
							<xsl:with-param name="player" select="key('act',1)" />
						</xsl:call-template>
					</div>
				    </td>
				</tr>
			    </table>

			</div>
		    </div>
		</div>
	    </xsl:template>
		<xsl:template name="actlink">
			<xsl:param name="act" />
			<xsl:choose>
				<xsl:when test="$act/type = 'pet'">
					<b><xsl:value-of select="$act/name" /></b>
				</xsl:when>
				<xsl:otherwise>
					<b><xsl:value-of select="$act/nickname" /> [<xsl:value-of select="$act/level" />]</b>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:template>
</xsl:stylesheet>
