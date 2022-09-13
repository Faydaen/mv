<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/actlink.xsl" />

    <xsl:template match="/data">
        <div class="result">
            <h3>Результат боя №<a href="/fight/{id}/"><xsl:value-of select="id" /></a><br />
            <xsl:value-of select="time" /> (<xsl:value-of select="date" />)</h3>
            <xsl:choose>
                <xsl:when test="winners/side != ''">
                    <div>Победители: <b><i class="{winners/code}"></i><xsl:value-of select="winners/name" />
                        (<xsl:value-of select="winners/alive" />/<xsl:value-of select="winners/count" />)</b>
                    </div>
                    <xsl:if test="type = 'flag'">
                        <div>
                            <xsl:call-template name="actlink">
                                <xsl:with-param name="act" select="flag/player" />
                            </xsl:call-template>&#0160;<xsl:choose>
                                <xsl:when test="flag/result = 'captured'">захватывает</xsl:when>
                                <xsl:when test="flag/result = 'defended'">сохраняет</xsl:when>
                            </xsl:choose> флаг
                        </div>
                    </xsl:if>
                    <div>
                        <xsl:choose>
                            <xsl:when test="killer = '' or damager = ''">

                            </xsl:when>
                            <xsl:otherwise>
                                <xsl:choose>
                                    <xsl:when test="killer/player/id = damager/player/id">
                                        Самый большой вклад в победу вносит <xsl:call-template name="actlink">
                                            <xsl:with-param name="act" select="killer/player" />
                                        </xsl:call-template> (убийств: <xsl:value-of select="killer/kills" />, урон: <xsl:value-of select="damager/damage" />) и
                                        получает <span class="star">1<i></i></span>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        Самый большой вклад в победу вносят <xsl:call-template name="actlink">
                                            <xsl:with-param name="act" select="killer/player" />
                                        </xsl:call-template> (убийств: <xsl:value-of select="killer/kills" />) и <xsl:call-template name="actlink">
                                            <xsl:with-param name="act" select="damager/player" />
                                        </xsl:call-template> (урон: <xsl:value-of select="damager/damage" />) и получают по <span class="star">1<i></i></span>
                                    </xsl:otherwise>
                                </xsl:choose>
                            </xsl:otherwise>
                        </xsl:choose>
                    </div>
                    <xsl:if test="type = 'bank' and winners/side = 'a'">
                        <div>Каждый из грабителей смог унести из банка <span class="tugriki"><xsl:value-of select="format-number(results/am, '###,###,###')" /><i></i></span></div>
                    </xsl:if>
                    <xsl:if test="results/as > 0">
                        <div>Каждый из победившей команды получает дополнительную награду <span class="star"><xsl:value-of select="results/as" /><i></i></span></div>
                    </xsl:if>
                    <xsl:if test="type = 'level'">
                        <!--
                        <div>Каждый из оставшихся в живых получает в награду&#0160;
                        <xsl:if test="results/am > 0"><span class="tugriki"><xsl:value-of select="results/am" /><i></i></span></xsl:if> <xsl:if test="results/ao > 0"><span class="ruda"><xsl:value-of select="results/ao" /><i></i></span></xsl:if></div>
                        -->
                        <span class="dashedlink" onclick="$('#fight-perplayer-results').toggle();">Игроки победившей команды получают в награду:</span>
                        <div id="fight-perplayer-results" style="display:none;">
                            <xsl:for-each select="winners/players/element">
                                <xsl:if test="current()/am > 0 or current()/ao > 0">
                                    <div>
                                        <xsl:call-template name="actlink">
                                            <xsl:with-param name="act" select="current()" />
                                        </xsl:call-template>:
                                        <xsl:if test="current()/am > 0">&#0160;<span class="tugriki"><xsl:value-of select="current()/am" /><i></i></span></xsl:if>
                                        <xsl:if test="current()/ao > 0">&#0160;<span class="ruda"><xsl:value-of select="current()/ao" /><i></i></span></xsl:if>
                                    </div>
                                </xsl:if>
                            </xsl:for-each>
                        </div>
                    </xsl:if>
                    <xsl:if test="type = 'chaotic'">
                        <span class="dashedlink" onclick="$('#fight-perplayer-results').toggle();">Игроки победившей команды получают в награду:</span>
                        <div id="fight-perplayer-results" style="display:none;">
                            <xsl:for-each select="winners/players/element">
                                <xsl:if test="current()/an > 0">
                                    <div>
                                        <xsl:call-template name="actlink">
                                            <xsl:with-param name="act" select="current()" />
                                        </xsl:call-template>:
                                        <xsl:if test="current()/an > 0">&#0160;<span class="neft"><xsl:value-of select="current()/an" /><i></i></span></xsl:if>
                                    </div>
                                </xsl:if>
                            </xsl:for-each>
                        </div>
                    </xsl:if>
                </xsl:when>
                <xsl:otherwise>
                    Ничья!
                    <xsl:if test="type = 'flag'">
                        <div>
                            <xsl:call-template name="actlink">
                                <xsl:with-param name="act" select="flag/player" />
                            </xsl:call-template>&#0160;<xsl:choose>
                                <xsl:when test="flag/result = 'captured'">захватывает</xsl:when>
                                <xsl:when test="flag/result = 'defended'">сохраняет</xsl:when>
                            </xsl:choose> флаг
                        </div>
                    </xsl:if>
                </xsl:otherwise>
            </xsl:choose>
        </div>
    </xsl:template>

</xsl:stylesheet>
