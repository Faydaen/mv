<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template name="stats">
		<xsl:param name="player" />
        <ul class="stats">
            <li class="stat odd">
                <div class="label">
                    <b>Здоровье</b>
                    <xsl:element name="span">
                        <xsl:attribute name="class">num</xsl:attribute>
                        <xsl:choose>
                            <xsl:when test="$player/h0 != '' and $player/h != ''">
                                <xsl:attribute name="tooltip">1</xsl:attribute>
                                <xsl:attribute name="title">Здоровье||Персонаж: <xsl:value-of select="$player/h0" />
                                    <xsl:choose>
                                        <xsl:when test="count($player/x/h) > 0">
                                            <xsl:for-each select="$player/x/h/element">
                                                |<xsl:choose>
                                                    <xsl:when test="si = -1">Другие влияния</xsl:when>
                                                    <xsl:when test="si = -2">Процентные влияния</xsl:when>
                                                    <!--xsl:otherwise><xsl:call-template name="itemname"><xsl:with-param name="id" select="si" /></xsl:call-template></xsl:otherwise-->
                                                    <xsl:otherwise><xsl:value-of select="nm" /></xsl:otherwise>
                                                </xsl:choose>: <xsl:value-of select="format-number(value, '+###;–###')" /><xsl:value-of select="p" />
                                            </xsl:for-each>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:if test="$player/h != 0">|Бонусы/штрафы: <xsl:if test="$player/h > 0">+</xsl:if><xsl:value-of select="$player/h" /></xsl:if>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </xsl:attribute>
                                <xsl:value-of select="$player/h0 + $player/h" />
                            </xsl:when>
                            <xsl:when test="$player/h != 0"><xsl:value-of select="$player/h" /></xsl:when>
                            <xsl:otherwise><xsl:value-of select="$player/health_finish" /></xsl:otherwise>
                        </xsl:choose>
                    </xsl:element>
                </div>
                <div class="bar"><div><xsl:choose>
                    <xsl:when test="$player/ph != 0 and $player/ph2 != ''"><div class="percent" style="width:{$player/ph}%;"></div><div class="percent2" style="width:{$player/ph2}%;"></div><div class="percent3" style="width:{$player/ph3}%;"></div></xsl:when>
                    <xsl:otherwise><div class="percent" style="width: {$player/procenthealth}%;"></div></xsl:otherwise>
                </xsl:choose></div></div>
            </li>
            <li class="stat">
                <div class="label">
                    <b>Сила</b>
                    <xsl:element name="span">
                        <xsl:attribute name="class">num</xsl:attribute>
                        <xsl:choose>
                            <xsl:when test="$player/s0 != '' and $player/s != ''">
                                <xsl:attribute name="tooltip">1</xsl:attribute>
                                <xsl:attribute name="title">Сила||Персонаж: <xsl:value-of select="$player/s0" />
                                    <xsl:choose>
                                        <xsl:when test="count($player/x/s) > 0">
                                            <xsl:for-each select="$player/x/s/element">
                                                |<xsl:choose>
                                                    <xsl:when test="si = -1">Другие влияния</xsl:when>
                                                    <xsl:when test="si = -2">Процентные влияния</xsl:when>
                                                    <!--xsl:otherwise><xsl:call-template name="itemname"><xsl:with-param name="id" select="si" /></xsl:call-template></xsl:otherwise-->
                                                    <xsl:otherwise><xsl:value-of select="nm" /></xsl:otherwise>
                                                </xsl:choose>: <xsl:value-of select="format-number(value, '+###;–###')" /><xsl:value-of select="p" />
                                            </xsl:for-each>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:if test="$player/s != 0">|Бонусы/штрафы: <xsl:if test="$player/s > 0">+</xsl:if><xsl:value-of select="$player/s" /></xsl:if>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </xsl:attribute>
                                <xsl:value-of select="$player/s0 + $player/s" />
                            </xsl:when>
                            <xsl:when test="$player/s != 0"><xsl:value-of select="$player/s" /></xsl:when>
                            <xsl:otherwise><xsl:value-of select="$player/strength_finish" /></xsl:otherwise>
                        </xsl:choose>
                    </xsl:element>
                </div>
                <div class="bar"><div><xsl:choose>
                    <xsl:when test="$player/ps != 0 and $player/ps2 != ''"><div class="percent" style="width:{$player/ps}%;"></div><div class="percent2" style="width:{$player/ps2}%;"></div><div class="percent3" style="width:{$player/ps3}%;"></div></xsl:when>
                    <xsl:otherwise><div class="percent" style="width: {$player/procentstrength}%;"></div></xsl:otherwise>
                </xsl:choose></div></div>
            </li>
            <li class="stat odd">
                <div class="label">
                    <b>Ловкость</b>
                    <xsl:element name="span">
                        <xsl:attribute name="class">num</xsl:attribute>
                        <xsl:choose>
                            <xsl:when test="$player/d0 != '' and $player/d != ''">
                                <xsl:attribute name="tooltip">1</xsl:attribute>
                                <xsl:attribute name="title">Ловкость||Персонаж: <xsl:value-of select="$player/d0" />
                                    <xsl:choose>
                                        <xsl:when test="count($player/x/d) > 0">
                                            <xsl:for-each select="$player/x/d/element">
                                                |<xsl:choose>
                                                    <xsl:when test="si = -1">Другие влияния</xsl:when>
                                                    <xsl:when test="si = -2">Процентные влияния</xsl:when>
                                                    <!--xsl:otherwise><xsl:call-template name="itemname"><xsl:with-param name="id" select="si" /></xsl:call-template></xsl:otherwise-->
                                                    <xsl:otherwise><xsl:value-of select="nm" /></xsl:otherwise>
                                                </xsl:choose>: <xsl:value-of select="format-number(value, '+###;–###')" /><xsl:value-of select="p" />
                                            </xsl:for-each>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:if test="$player/d != 0">|Бонусы/штрафы: <xsl:if test="$player/d > 0">+</xsl:if><xsl:value-of select="$player/d" /></xsl:if>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </xsl:attribute>
                                <xsl:value-of select="$player/d0 + $player/d" />
                            </xsl:when>
                            <xsl:when test="$player/d != 0"><xsl:value-of select="$player/d" /></xsl:when>
                            <xsl:otherwise><xsl:value-of select="$player/dexterity_finish" /></xsl:otherwise>
                        </xsl:choose>
                    </xsl:element>
                </div>
                <div class="bar"><div><xsl:choose>
                    <xsl:when test="$player/pd != 0 and $player/pd2 != ''"><div class="percent" style="width:{$player/pd}%;"></div><div class="percent2" style="width:{$player/pd2}%;"></div><div class="percent3" style="width:{$player/pd3}%;"></div></xsl:when>
                    <xsl:otherwise><div class="percent" style="width: {$player/procentdexterity}%;"></div></xsl:otherwise>
                </xsl:choose></div></div>
            </li>
            <li class="stat">
                <div class="label">
                    <b>Выносливость</b>
                    <xsl:element name="span">
                        <xsl:attribute name="class">num</xsl:attribute>
                        <xsl:choose>
                            <xsl:when test="$player/r0 != '' and $player/r != ''">
                                <xsl:attribute name="tooltip">1</xsl:attribute>
                                <xsl:attribute name="title">Выносливость||Персонаж: <xsl:value-of select="$player/r0" />
                                    <xsl:choose>
                                        <xsl:when test="count($player/x/r) > 0">
                                            <xsl:for-each select="$player/x/r/element">
                                                |<xsl:choose>
                                                    <xsl:when test="si = -1">Другие влияния</xsl:when>
                                                    <xsl:when test="si = -2">Процентные влияния</xsl:when>
                                                    <!--xsl:otherwise><xsl:call-template name="itemname"><xsl:with-param name="id" select="si" /></xsl:call-template></xsl:otherwise-->
                                                    <xsl:otherwise><xsl:value-of select="nm" /></xsl:otherwise>
                                                </xsl:choose>: <xsl:value-of select="format-number(value, '+###;–###')" /><xsl:value-of select="p" />
                                            </xsl:for-each>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:if test="$player/r != 0">|Бонусы/штрафы: <xsl:if test="$player/r > 0">+</xsl:if><xsl:value-of select="$player/r" /></xsl:if>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </xsl:attribute>
                                <xsl:value-of select="$player/r0 + $player/r" />
                            </xsl:when>
                            <xsl:when test="$player/r != 0"><xsl:value-of select="$player/r" /></xsl:when>
                            <xsl:otherwise><xsl:value-of select="$player/resistance_finish" /></xsl:otherwise>
                        </xsl:choose>
                    </xsl:element>
                </div>
                <div class="bar"><div><xsl:choose>
                    <xsl:when test="$player/pr != 0 and $player/pr2 != ''"><div class="percent" style="width:{$player/pr}%;"></div><div class="percent2" style="width:{$player/pr2}%;"></div><div class="percent3" style="width:{$player/pr3}%;"></div></xsl:when>
                    <xsl:otherwise><div class="percent" style="width: {$player/procentresistance}%;"></div></xsl:otherwise>
                </xsl:choose></div></div>
            </li>
            <li class="stat odd">
                <div class="label">
                    <b>Хитрость</b>
                    <xsl:element name="span">
                        <xsl:attribute name="class">num</xsl:attribute>
                        <xsl:choose>
                            <xsl:when test="$player/i0 != '' and $player/i != ''">
                                <xsl:attribute name="tooltip">1</xsl:attribute>
                                <xsl:attribute name="title">Хитрость||Персонаж: <xsl:value-of select="$player/i0" />
                                    <xsl:choose>
                                        <xsl:when test="count($player/x/i) > 0">
                                            <xsl:for-each select="$player/x/i/element">
                                                |<xsl:choose>
                                                    <xsl:when test="si = -1">Другие влияния</xsl:when>
                                                    <xsl:when test="si = -2">Процентные влияния</xsl:when>
                                                    <!--xsl:otherwise><xsl:call-template name="itemname"><xsl:with-param name="id" select="si" /></xsl:call-template></xsl:otherwise-->
                                                    <xsl:otherwise><xsl:value-of select="nm" /></xsl:otherwise>
                                                </xsl:choose>: <xsl:value-of select="format-number(value, '+###;–###')" /><xsl:value-of select="p" />
                                            </xsl:for-each>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:if test="$player/i != 0">|Бонусы/штрафы: <xsl:if test="$player/i > 0">+</xsl:if><xsl:value-of select="$player/i" /></xsl:if>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </xsl:attribute>
                                <xsl:value-of select="$player/i0 + $player/i" />
                            </xsl:when>
                            <xsl:when test="$player/i != 0"><xsl:value-of select="$player/i" /></xsl:when>
                            <xsl:otherwise><xsl:value-of select="$player/intuition_finish" /></xsl:otherwise>
                        </xsl:choose>
                    </xsl:element>
                </div>
                <div class="bar"><div><xsl:choose>
                    <xsl:when test="$player/pi != 0 and $player/pi2 != ''"><div class="percent" style="width:{$player/pi}%;"></div><div class="percent2" style="width:{$player/pi2}%;"></div><div class="percent3" style="width:{$player/pi3}%;"></div></xsl:when>
                    <xsl:otherwise><div class="percent" style="width: {$player/procentintuition}%;"></div></xsl:otherwise>
                </xsl:choose></div></div>
            </li>
            <li class="stat">
                <div class="label">
                    <b>Внимательность</b>
                    <xsl:element name="span">
                        <xsl:attribute name="class">num</xsl:attribute>
                        <xsl:choose>
                            <xsl:when test="$player/a0 != '' and $player/a != ''">
                                <xsl:attribute name="tooltip">1</xsl:attribute>
                                <xsl:attribute name="title">Внимательность||Персонаж: <xsl:value-of select="$player/a0" />
                                    <xsl:choose>
                                        <xsl:when test="count($player/x/a) > 0">
                                            <xsl:for-each select="$player/x/a/element">
                                                |<xsl:choose>
                                                    <xsl:when test="si = -1">Другие влияния</xsl:when>
                                                    <xsl:when test="si = -2">Процентные влияния</xsl:when>
                                                    <!--xsl:otherwise><xsl:call-template name="itemname"><xsl:with-param name="id" select="si" /></xsl:call-template></xsl:otherwise-->
                                                    <xsl:otherwise><xsl:value-of select="nm" /></xsl:otherwise>
                                                </xsl:choose>: <xsl:value-of select="format-number(value, '+###;–###')" /><xsl:value-of select="p" />
                                            </xsl:for-each>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:if test="$player/a != 0">|Бонусы/штрафы: <xsl:if test="$player/a > 0">+</xsl:if><xsl:value-of select="$player/a" /></xsl:if>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </xsl:attribute>
                                <xsl:value-of select="$player/a0 + $player/a" />
                            </xsl:when>
                            <xsl:when test="$player/a != 0"><xsl:value-of select="$player/a" /></xsl:when>
                            <xsl:otherwise><xsl:value-of select="$player/attention_finish" /></xsl:otherwise>
                        </xsl:choose>
                    </xsl:element>
                </div>
                <div class="bar"><div><xsl:choose>
                    <xsl:when test="$player/pa != 0 and $player/pa2 != ''"><div class="percent" style="width:{$player/pa}%;"></div><div class="percent2" style="width:{$player/pa2}%;"></div><div class="percent3" style="width:{$player/pa3}%;"></div></xsl:when>
                    <xsl:otherwise><div class="percent" style="width: {$player/procentattention}%;"></div></xsl:otherwise>
                </xsl:choose></div></div>
            </li>
            <li class="stat odd">
                <div class="label">
                    <b>Харизма</b>
                    <xsl:element name="span">
                        <xsl:attribute name="class">num</xsl:attribute>
                        <xsl:choose>
                            <xsl:when test="$player/c0 != '' and $player/c != ''">
                                <xsl:attribute name="tooltip">1</xsl:attribute>
                                <xsl:attribute name="title">Харизма||Персонаж: <xsl:value-of select="$player/c0" />
                                    <xsl:choose>
                                        <xsl:when test="count($player/x/c) > 0">
                                            <xsl:for-each select="$player/x/c/element">
                                                |<xsl:choose>
                                                    <xsl:when test="si = -1">Другие влияния</xsl:when>
                                                    <xsl:when test="si = -2">Процентные влияния</xsl:when>
                                                    <!--xsl:otherwise><xsl:call-template name="itemname"><xsl:with-param name="id" select="si" /></xsl:call-template></xsl:otherwise-->
                                                    <xsl:otherwise><xsl:value-of select="nm" /></xsl:otherwise>
                                                </xsl:choose>: <xsl:value-of select="format-number(value, '+###;–###')" /><xsl:value-of select="p" />
                                            </xsl:for-each>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:if test="$player/c != 0">|Бонусы/штрафы: <xsl:if test="$player/c > 0">+</xsl:if><xsl:value-of select="$player/c" /></xsl:if>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </xsl:attribute>
                                <xsl:value-of select="$player/c0 + $player/c" />
                            </xsl:when>
                            <xsl:when test="$player/c != 0"><xsl:value-of select="$player/c" /></xsl:when>
                            <xsl:otherwise><xsl:value-of select="$player/charism_finish" /></xsl:otherwise>
                        </xsl:choose>
                    </xsl:element>
                </div>
                <div class="bar"><div><xsl:choose>
                    <xsl:when test="$player/pc != 0 and $player/pc2 != ''"><div class="percent" style="width:{$player/pc}%;"></div><div class="percent2" style="width:{$player/pc2}%;"></div><div class="percent3" style="width:{$player/pc3}%;"></div></xsl:when>
                    <xsl:otherwise><div class="percent" style="width:{$player/procentcharism}%;"></div></xsl:otherwise>
                </xsl:choose></div></div>
            </li>
        </ul>
	</xsl:template>

</xsl:stylesheet>
