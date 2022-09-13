<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
	
    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/npclink.xsl" />
    <xsl:include href="common/item.xsl" />
    <xsl:include href="common/stats.xsl" />

    <xsl:key name="act" match="element" use="position" />
	<xsl:key name="actbyid" match="element" use="id" />

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

	<xsl:template name="fight" match="/data">
			<h3 class="curves clear">
				<div class="fighter1">
					<xsl:call-template name="playerlink">
						<xsl:with-param name="player" select="key('act',0)" />
					</xsl:call-template>
				</div>
				<div class="fighter2">
                    <xsl:choose>
                        <xsl:when test="key('act',1)/fr = 'npc'">
                            <xsl:call-template name="npclink">
                                <xsl:with-param name="player" select="key('act',1)" />
                            </xsl:call-template>
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:call-template name="playerlink">
                                <xsl:with-param name="player" select="key('act',1)" />
                            </xsl:call-template>
                        </xsl:otherwise>
                    </xsl:choose>
				</div>
		    </h3>

		    <table class="layout">
			<tr>
			    <td class="fighter1-cell" align="left">
					<ul class="slots">
						<li class="slot1">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/hat" />
							</xsl:call-template>
						</li>
						<li class="slot2">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/talisman" />
							</xsl:call-template>
						</li>
						<li class="slot3">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/cloth" />
							</xsl:call-template>
						</li>
						<li class="slot4">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/weapon" />
							</xsl:call-template>
						</li>
						<li class="slot5">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/accessory1" />
							</xsl:call-template>
						</li>
						<li class="slot6">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/tech" />
							</xsl:call-template>
						</li>
						<li class="slot7">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/shoe" />
							</xsl:call-template>
						</li>
						<li class="slot8">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/pouch" />
							</xsl:call-template>
						</li>
						<li class="slot9">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/jewellery" />
							</xsl:call-template>
						</li>
						<li class="slot10">
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',0)/equipped/cologne" />
							</xsl:call-template>
						</li>
                        <li class="avatar {key('act',0)/bg}">
							<div class="icons-place">
	                            <xsl:if test="key('act',0)/dopings != ''">
									<i class="icon affects-icon" tooltip="1" title="Допинги||{key('act',0)/dopings}"></i>
	                            </xsl:if>
							</div>
							<xsl:choose>
                                <xsl:when test="key('act',0)/av != ''"><img src="/@/images/pers/{key('act',0)/av}" /></xsl:when>
                                <xsl:otherwise><img src="/@/images/pers/{key('act',0)/avatar}" /></xsl:otherwise>
                            </xsl:choose>
						</li>
                        <xsl:choose>
                            <xsl:when test="key('act',2)/im != ''">
                                <xsl:if test="count(key('act',2)/im) > 0">
                                    <li class="slot-pet">
                                        <img src="/@/images/obj/{key('act',2)/im}" />
                                    </li>
                                </xsl:if>
                            </xsl:when>
                            <xsl:otherwise>
                                <xsl:if test="count(key('act',2)/image) > 0">
                                    <li class="slot-pet">
                                        <img src="/@/images/obj/{key('act',2)/image}" />
                                    </li>
                                </xsl:if>
                            </xsl:otherwise>
                        </xsl:choose>
				    </ul>

                </td>
				<td class="vs">
				    <div class="icon vs-icon"><spacer /></div>
					<div class="icon controls">
						<i id="controls-back" class="icon icon-back" onclick="fightBack();"></i>
						<i id="controls-play" class="icon icon-play" onclick="fightPlay();"></i>
						<i style="display:none;" class="icon icon-pause"></i>
						<i id="controls-forward" class="icon icon-forward" onclick="fightForward();"></i>
					</div>
					<div class="viewanimation"><a href="/alley/fight/{id}/{sk}/animation/">Смотреть в&#160;анимации</a></div>
				</td>

				<td class="fighter2-cell" align="right">
				    <ul class="slots">
						<xsl:element name="li">
							<xsl:attribute name="class">slot1</xsl:attribute>
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/hat" />
							</xsl:call-template>
						</xsl:element>
						<xsl:element name="li">
							<xsl:attribute name="class">slot2</xsl:attribute>
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/talisman" />
							</xsl:call-template>
						</xsl:element>
						<xsl:element name="li">
							<xsl:attribute name="class">slot3</xsl:attribute>
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/cloth" />
							</xsl:call-template>
						</xsl:element>
						<xsl:element name="li">
							<xsl:attribute name="class">slot4</xsl:attribute>
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/weapon" />
							</xsl:call-template>
						</xsl:element>
						<xsl:element name="li">
							<xsl:attribute name="class">slot5</xsl:attribute>
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/accessory1" />
							</xsl:call-template>
						</xsl:element>
						<xsl:element name="li">
							<xsl:attribute name="class">slot6</xsl:attribute>
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/tech" />
							</xsl:call-template>
						</xsl:element>
						<xsl:element name="li">
							<xsl:attribute name="class">slot7</xsl:attribute>
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/shoe" />
							</xsl:call-template>
						</xsl:element>
						<xsl:element name="li">
							<xsl:attribute name="class">slot8</xsl:attribute>
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/pouch" />
							</xsl:call-template>
						</xsl:element>
						<xsl:element name="li">
							<xsl:attribute name="class">slot9</xsl:attribute>
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/jewellery" />
							</xsl:call-template>
						</xsl:element>
						<xsl:element name="li">
							<xsl:attribute name="class">slot10</xsl:attribute>
							<xsl:call-template name="item">
								<xsl:with-param name="item" select="key('act',1)/equipped/cologne" />
							</xsl:call-template>
						</xsl:element>
						<li class="avatar {key('act',1)/bg}">
							<div class="icons-place">
                            <xsl:if test="key('act',1)/dopings != ''">
                                <i class="icon affects-icon" tooltip="1" title="Допинги||{key('act',1)/dopings}"></i>
                            </xsl:if>
							</div>
							<xsl:choose>
                                <xsl:when test="key('act',1)/av != ''"><img src="/@/images/pers/{key('act',1)/av}" /></xsl:when>
                                <xsl:otherwise><img src="/@/images/pers/{key('act',1)/avatar}" /></xsl:otherwise>
                            </xsl:choose>
						</li>
                        <xsl:choose>
                            <xsl:when test="key('act',3)/im != ''">
                                <xsl:if test="count(key('act',3)/im) > 0">
                                    <li class="slot-pet">
                                        <img src="/@/images/obj/{key('act',3)/im}" />
                                    </li>
                                </xsl:if>
                            </xsl:when>
                            <xsl:otherwise>
                                <xsl:if test="count(key('act',3)/image) > 0">
                                    <li class="slot-pet">
                                        <img src="/@/images/obj/{key('act',3)/image}" />
                                    </li>
                                </xsl:if>
                            </xsl:otherwise>
                        </xsl:choose>
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
						<span id="fighter1-life"><xsl:value-of select="key('act',0)/hp" />/<xsl:choose><xsl:when test="key('act',0)/mhp > 0"><xsl:value-of select="key('act',0)/mhp" /></xsl:when><xsl:otherwise><xsl:value-of select="key('act',0)/maxhp" /></xsl:otherwise></xsl:choose></span>
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

                    <xsl:if test="key('act',0)/pet/im != ''">
                        <div class="pet">
                            <div class="block-rounded">
                                <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                                <div class="life">
                                    <div class="clear">
                                        <img title="{key('act',0)/pet/nm}" src="/@/images/obj/{key('act',0)/pet/im}-icon.png" />
                                        Жизни питомца: <span id="pet0-life"><xsl:value-of select="key('act',0)/pet/hp" />/<xsl:value-of select="key('act',0)/pet/mhp" /></span>
                                    </div>
                                    <div class="bar"><div><div class="percent" style="width:{key('act',0)/pet/hppcnt}%;"></div></div></div>
                                </div>
                            </div>
                        </div>
                    </xsl:if>
					
				    </td>
				    <td class="log">
					<!--
					<div align="center" style="padding-bottom: 10px;">
						<a href="/alley/fight/{id}/{sk}/animation/">Смотреть анимационный бой</a>
					</div>
					-->
					<div id="timer-block">
					    Тик-так:
					    <span id="time-left">2</span>
					</div>
					<ul id="fight-log">
					    <li class="result">
						<h3>Результат боя <xsl:if test="id > 0">№<a href="/alley/fight/{id}/{sk}/"><xsl:value-of select="id" /></a></xsl:if><br />
							<xsl:value-of select="time" /> (<xsl:value-of select="date" />)
						</h3>
						<xsl:choose>
							<xsl:when test="winner > 0">
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
									<span class="expa" title="Опыт: {exp}"><xsl:value-of select="exp" /><i></i></span>
									<xsl:if test="count(params/carpart) != 0">
										<span class="object-thumb">
											<img src="{params/carpart/i}" alt="{params/carpart/n}"  tooltip="1" title="{params/carpart/n}||Полезная вещь в строительстве автомобильных цехов." />
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

								<xsl:if test="count(backlink) > 0">
									<div class="backlink" align="center">
										<div class="button">
											<a class="f" href="{backlink/url}"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c"><xsl:value-of select="backlink/name" /></div>
											</a>
										</div>
									</div>
								</xsl:if>

								<!--xsl:if test="flag > 0">
									<br /><xsl:choose>
										<xsl:when test="winner = flag">
											<b><xsl:call-template name="actlink"><xsl:with-param name="act" select="key('actbyid',flag)" /></xsl:call-template></b> сохраняет флаг.
										</xsl:when>
										<xsl:otherwise>
											<b><xsl:call-template name="actlink"><xsl:with-param name="act" select="key('actbyid',winner)" /></xsl:call-template></b> захватывает флаг.
										</xsl:otherwise>
									</xsl:choose>
								</xsl:if-->
								
							</xsl:when>
							<xsl:otherwise>
								<div align="center">Ничья!
									<xsl:if test="count(backlink) > 0">
										<div class="backlink" align="center">
											<div class="button">
												<a class="f" href="{backlink/url}"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c"><xsl:value-of select="backlink/name" /></div>
												</a>
											</div>
										</div>
									</xsl:if>
								</div>
							</xsl:otherwise>
						</xsl:choose>
						<xsl:if test="count(/data/duellogtext) = 1">
							<xsl:value-of select="/data/duellogtext" disable-output-escaping="yes" />
						</xsl:if>
						<xsl:call-template name="questbutton">
							<xsl:with-param name="quest" select="quest" />
						</xsl:call-template>
					    </li>
						<xsl:for-each select="log/element">
							<li rel="{current()/element[2]/element[1]}/{key('act', 0)/mhp}:{current()/element[2]/element[2]}/{key('act', 1)/mhp}:{current()/element[2]/element[3]}/{key('act', 0)/pet/mhp}:{current()/element[2]/element[4]}/{key('act', 1)/pet/mhp}">
                                <xsl:choose>
                                    <xsl:when test="current()/element[1]/element[1]/element[3]/element[1] = 11"><h4><b>Произошел наезд</b></h4></xsl:when>
                                    <xsl:when test="current()/element[1]/element[1]/element[3]/element[1] = 12"><h4><b>Сел и уехал</b></h4></xsl:when>
                                    <xsl:otherwise>
                                        <h4><b>Ход <xsl:value-of select="count(/data/log/element) - position() + 1 - /data/naezdkostil" /></b></h4>
                                    </xsl:otherwise>
                                </xsl:choose>
                                <xsl:variable name="item" select="current()" />
                                <xsl:for-each select="$item/element[1]/element">
                                    <xsl:variable name="step" select="current()" />
                                    <xsl:variable name="stepp" select="position()" />
                                    <xsl:variable name="action" select="current()/element[3]/element[1]" />
                                    <xsl:element name="div">
                                        <xsl:if test="$action = 2 or $action = 3"><xsl:attribute name="class">critical</xsl:attribute></xsl:if>
                                        <xsl:if test="$action = 11 or $action = 12"><xsl:attribute name="class">rundown</xsl:attribute></xsl:if>
                                        <xsl:if test="$action = 11 or $action = 12"><i class="icon icon-bike"></i></xsl:if>
                                        <xsl:if test="$action = 21"><i class="icon icon-set-adddamage"></i></xsl:if>
                                        <xsl:if test="$action = 22"><i class="icon icon-set-blockdamage"></i></xsl:if>
                                        <xsl:if test="$action = 31"><i class="icon icon-set-perk-knockout"></i></xsl:if>
                                        <xsl:if test="$action = 32"><i class="icon icon-set-perk-vampir"></i></xsl:if>
                                        <xsl:if test="$action = 33"><i class="icon icon-set-perk-ratkiller"></i></xsl:if>
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
                                                <xsl:otherwise><xsl:value-of select="current()" disable-output-escaping="yes" /></xsl:otherwise>
                                            </xsl:choose>
                                        </xsl:for-each>
                                        <xsl:if test="$action != 0 and $action != 12 and $action &lt; 30"> (–<xsl:value-of select="current()/element[3]/element[2]" />)</xsl:if>
                                        <xsl:if test="$action = 33"> (–<xsl:value-of select="current()/element[3]/element[2]" />)</xsl:if>
                                        <xsl:if test="$action = 32"> (+<xsl:value-of select="current()/element[3]/element[2]" />)</xsl:if>
										<xsl:if test="$action = 50">
											<xsl:choose>
												<xsl:when test="count(current()/element[3]/element[2]) = 1 and current()/element[3]/element[2] > 0">
												  (-<xsl:value-of select="current()/element[3]/element[2]" />)
												</xsl:when>
												<xsl:otherwise> (промах)</xsl:otherwise>
											</xsl:choose>
										</xsl:if>
                                    </xsl:element>
                                </xsl:for-each>
							</li>
						</xsl:for-each>
                        <!--xsl:choose>
                            <xsl:when test="key('act', 0)/mhp > 0">
                                <li rel="{key('act', 0)/hp}/{key('act', 0)/mhp}:{key('act', 1)/hp}/{key('act', 1)/mhp}">
                            </xsl:when>
                            <xsl:otherwise>
                                <li rel="{key('act', 0)/hp}/{key('act', 0)/maxhp}:{key('act', 1)/hp}/{key('act', 1)/maxhp}">
                            </xsl:otherwise>
                        </xsl:choose-->
                        <li rel="{key('act', 0)/hp}/{key('act', 0)/mhp}:{key('act', 1)/hp}/{key('act', 1)/mhp}:{key('act', 0)/pet/hp}/{key('act', 0)/pet/mhp}:{key('act', 1)/pet/hp}/{key('act', 1)/pet/mhp}">
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
						<xsl:choose>
							<xsl:when test="params/werewolf = 1">
								var playerId = 0;
							</xsl:when>
							<xsl:when test="key('act', 0)/id = player/id and interactive = 1 and params/werewolf != 1">
								var playerId = 1;
							</xsl:when>
							<xsl:when test="key('act', 1)/id = player/id and interactive = 1">
								var playerId = 2;
							</xsl:when>
							<xsl:otherwise>
								var playerId = 0;
							</xsl:otherwise>
						</xsl:choose>
						var timer;
						var timeleft = 2;
						fightGo();
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
                        <span id="fighter2-life"><xsl:value-of select="key('act',1)/hp" />/<xsl:choose><xsl:when test="key('act',1)/mhp > 0"><xsl:value-of select="key('act',1)/mhp" /></xsl:when><xsl:otherwise><xsl:value-of select="key('act',1)/maxhp" /></xsl:otherwise></xsl:choose></span>
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

                    <xsl:if test="key('act',1)/pet/nm != ''">
                        <div class="pet">
                            <div class="block-rounded">
                                <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                                <div class="life">
                                    <div class="clear">
                                        <img title="{key('act',1)/pet/nm}" src="/@/images/obj/{key('act',1)/pet/im}-icon.png" />
                                        Жизни питомца: <span id="pet1-life"><xsl:value-of select="key('act',1)/pet/hp" />/<xsl:value-of select="key('act',1)/pet/mhp" /></span>
                                    </div>
                                    <div class="bar"><div><div class="percent" style="width:{key('act',1)/pet/hppcnt}%;"></div></div></div>
                                </div>
                            </div>
                        </div>
                    </xsl:if>

				    </td>
				</tr>
			    </table>
	</xsl:template>
	<xsl:template name="error">
		<xsl:param name="error" />
		<xsl:choose>
			<xsl:when test="$error = 'fight not found'">
			<div style="text-align: center; font-size: 34px; color:#ba7327; margin-top:110px; font-family:Comic Sans MS;">Это было давно<br />и не правда</div>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>
					<span class="boj"></span>
					</h2>
				</div>
				<div id="content" class="fight">
					<xsl:choose>
						<xsl:when test="result = 0">
							<xsl:call-template name="error">
								<xsl:with-param name="error" select="error" />
							</xsl:call-template>
						</xsl:when>
						<xsl:otherwise>
							<xsl:call-template name="fight" />
						</xsl:otherwise>
					</xsl:choose>
				</div>
			</div>
		</div>
	</xsl:template>

</xsl:stylesheet>