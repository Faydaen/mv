<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/paginator.xsl" />

    <xsl:template match="/data">
		<div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Охотничий клуб
                </h2></div>
                <div id="content" class="hunting">

                    <div class="welcome">
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="text">
                                — Здесь, в клубе любителей пострелять, мы развлекаемся охотой. Охотой за головами.<br />
                                Ты можешь либо заказать человека, либо сам принять заказ и получить награду за убийство.
                            </div>
                        </div>
						<div class="goback">
							<span class="arrow">◄</span><a href="/huntclub/">Выйти в холл</a>
						</div>
                    </div>

                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3>Заказы на меня</h3>
                            <div class="hunting-wanted">
                                <p>Похоже, что вы перешли дорогу не тому человеку и вас заказали.
								<!--В течение часа после заказа, прежде чем ваша ориентировка попадет в руки охотников, 
								Вы можете откупиться и даже раскрыть имя заказчика.--><br />
								Заказ действителен 24 часа.</p>
                                <table class="list">
                                    <tr>
                                        <th>Имя</th>
                                        <th>Причина</th>
										<th class="value">Награда</th>
                                        <th class="date">Добавлен</th>
                                        <th class="action">Логи</th>
                                        <th class="action"></th>
                                    </tr>
                                    <xsl:choose>
                                        <xsl:when test="count(wanted/element) > 0">
                                            <xsl:for-each select="wanted/element">
                                                <tr class="huntstate{state}">
                                                    <td class="name">
                                                        <xsl:choose>
                                                            <xsl:when test="private = 1">Приватный заказ</xsl:when>
                                                            <xsl:when test="opened = 0"><em>скрыто</em></xsl:when>
                                                            <xsl:when test="opened = 1">
                                                                <xsl:call-template name="playerlink"><xsl:with-param name="player" select="current()" /></xsl:call-template>
                                                            </xsl:when>
                                                        </xsl:choose>
                                                    </td>
                                                    <td>
                                                        <xsl:choose>
                                                            <xsl:when test="private = 0 and opened = 1">
                                                                <xsl:value-of select="comment" />
                                                            </xsl:when>
                                                            <xsl:otherwise><em>скрыто</em></xsl:otherwise>
                                                        </xsl:choose>
                                                    </td>
                                                    <td class="value">
                                                        <xsl:choose>
                                                            <xsl:when test="private = 0 and opened = 1">
                                                                <span class="tugriki"><xsl:value-of select="format-number(award, '###,###,###')" /><i></i></span>
                                                                <xsl:if test="xmoney = 2"><br />Удвоенный грабеж</xsl:if>
                                                            </xsl:when>
                                                            <xsl:otherwise><em>скрыто</em></xsl:otherwise>
                                                        </xsl:choose>
                                                    </td>
                                                    <td class="date"><xsl:value-of select="dt" /></td>
                                                    <td>
                                                        <xsl:choose>
                                                            <xsl:when test="count(logs/element) > 0">
                                                                <xsl:for-each select="logs/element">
                                                                    <a href="/alley/fight/{duel}/{sk}/" target="_blank" title="{dt}" alt="{dt}">
                                                                        <xsl:choose>
                                                                            <xsl:when test="kill = 1"><i class="hunting-kill"></i></xsl:when>
                                                                            <xsl:otherwise><i class="hunting-death"></i></xsl:otherwise>
                                                                        </xsl:choose>
                                                                    </a>
                                                                </xsl:for-each>
                                                            </xsl:when>
                                                            <xsl:when test="state = 3">
                                                                Игрок откупился
                                                            </xsl:when>
                                                            <xsl:otherwise>
                                                                Нападений нет
                                                            </xsl:otherwise>
                                                        </xsl:choose>
                                                    </td>
                                                    <td class="action">
                                                        <xsl:if test="private = 0 and opened = 0 and /data/player/playboy = 1">
                                                            <button class="button" onclick="huntclubOpen({hunt})">
                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">Раскрыть — <span class="med">5<i></i></span></div>
                                                                </span>
                                                            </button>
                                                        </xsl:if>
                                                        <xsl:if test="opened = 1">
                                                            <span class="button">
                                                                <a class="f" href="/huntclub/revenge/{id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">Заказать</div>
                                                                </a>
                                                            </span>
                                                        </xsl:if>
                                                        <xsl:if test="state = 0">
															<!--Откупиться нельзя-->
															<!--
                                                            &#0160;<button class="button" onclick="huntclubPayFee({hunt})">
                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">Откупиться — <span class="tugriki"><xsl:value-of select="format-number(money, '###,###,###')" /><i></i></span></div>
                                                                </span>
                                                            </button>
															-->
                                                        </xsl:if>
                                                    </td>
                                                </tr>
                                            </xsl:for-each>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <tr>
                                                <td style="text-align:center;" colspan="5">На вас не сделано ни одного заказа за последнюю неделю.</td>
                                            </tr>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </table>

                            </div>

                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                </div>
            </div>

        </div>
    </xsl:template>

</xsl:stylesheet>