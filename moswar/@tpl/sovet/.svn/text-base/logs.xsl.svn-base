<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/paginator.xsl" />
    <xsl:include href="sovet/menu1.xsl" />
    <xsl:include href="sovet/menu2.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Амбарная книга Совета
                </h2></div>
                <div id="content" class="council">

                    <xsl:call-template name="menu1">
                        <xsl:with-param name="page" select="'council'" />
                        <xsl:with-param name="council" select="council" />
                    </xsl:call-template>

                    <div class="welcome">

                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="text">
                                Задача совета — принимать решения и управлять ходом боевых действий.<br />
                                Члены совета — это бравые генералы и проницательные стратеги.
                                От пламенного обращения Председателя совета к народу зависит, кто захватит столицу.
                            </div>
                        </div>
                    </div>

                    <xsl:call-template name="menu2">
                        <xsl:with-param name="page" select="'logs'" />
                        <xsl:with-param name="council" select="council" />
                    </xsl:call-template>

                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3></h3>
                            <div class="clan-store-logs phone">
                                <p>Штатный летописец старается фиксировать наиболее важные события в жизни Совета. А так как уследить за всем невозможно,
                                то он сосредоточен на финансовых вопросах. И только на особо крупных.</p>
                                <table class="messages-list">
                                    <xsl:choose>
                                        <xsl:when test="count(log/element) > 0">
                                            <xsl:for-each select="log/element">
                                                <tr>
                                                    <td class="date">
                                                        <xsl:value-of select="dt" />
                                                    </td>
                                                    <td class="text">
                                                        <!--xsl:if test="count(params/p) > 0">
                                                        <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/p" /></xsl:call-template> &#0160;
                                                        </xsl:if-->
                                                        <xsl:choose>
															<xsl:when test="action = 'bsta'">Активировано усиление <b><xsl:value-of select="params/b" /></b> стоимостью <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span>
																<br />За усиление голосовали:
																<xsl:for-each select="params/y/element">
																	<xsl:call-template name="playerlink"><xsl:with-param name="player" select="current()" /></xsl:call-template>
																	<xsl:if test="position() != last()">, </xsl:if>
																</xsl:for-each>
															</xsl:when>
                                                            <xsl:when test="action = 'svk'">Выборы в Совет принесли в казну <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span></xsl:when>
                                                            <xsl:when test="action = 'mvk'">Голосование за район принесло в казну <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span></xsl:when>
                                                            <xsl:when test="action = 'dpst'">Игрок <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/p" /></xsl:call-template>
                                                            сделал особо крупный вклад в казну в размере <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span></xsl:when>
                                                            <xsl:when test="action = 'mz'">Захвачен <b><xsl:value-of select="params/n" /></b> район</xsl:when>
															<xsl:when test="action = 'mz2'">Битва за район <b><xsl:value-of select="params/n" /></b> проиграна</xsl:when>
                                                        </xsl:choose>
                                                    </td>
                                                    <td class="actions"></td>
                                                </tr>
                                            </xsl:for-each>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <p>В летописи Совета пока еще нет ни одной записи.</p>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </table>

                                <xsl:call-template name="paginator">
                                    <xsl:with-param name="pages" select="pages" />
                                    <xsl:with-param name="page" select="page" />
                                    <xsl:with-param name="link" select="'/sovet/logs/'" />
                                </xsl:call-template>
                            </div>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                </div>
            </div>

        </div>
    </xsl:template>

</xsl:stylesheet>