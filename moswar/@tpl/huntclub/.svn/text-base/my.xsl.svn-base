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
                            <h3>Мои заказы</h3>
                            <div class="hunting-wanted">
								<p class="hint">Помните, что вы не можете выполнять свои же заказы.</p>
                                <table class="list">
                                    <tr>
                                        <th>Имя</th>
                                        <th class="value">Награда</th>
                                        <th class="date">Добавлен</th>
                                        <th class="action">Логи</th>
                                        <th></th>
                                    </tr>
                                    <xsl:choose>
                                        <xsl:when test="count(wanted/element) > 0">
                                            <xsl:for-each select="wanted/element">
                                                <tr class="huntstate{state}">
                                                    <td class="name"><xsl:call-template name="playerlink"><xsl:with-param name="player" select="current()" /></xsl:call-template></td>
                                                    <td class="value">
                                                        <span class="tugriki"><xsl:value-of select="award" /><i></i></span>
                                                        <xsl:if test="xmoney = 2"><br />Удвоенный грабеж</xsl:if>
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
                                                    <td>
                                                        <xsl:choose>
                                                            <xsl:when test="private = 1">Приватный</xsl:when>
                                                            <xsl:when test="opened = 1">Раскрыт</xsl:when>
                                                            <xsl:when test="opened = 0">Не раскрыт</xsl:when>
                                                        </xsl:choose>
                                                    </td>
                                                </tr>
                                            </xsl:for-each>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <tr>
                                                <td style="text-align:center;" colspan="5">Вы не сделали ни одного заказа за последнюю неделю.</td>
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