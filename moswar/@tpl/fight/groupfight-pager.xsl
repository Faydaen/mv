<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="pagescroll"><div class="block-rounded">
            <xsl:for-each select="steps/element">
                <xsl:choose>
                    <xsl:when test="/data/page = count(/data/steps/element) - position() + 1">
                        &#0160;<strong class="current"><xsl:value-of select="count(/data/steps/element) - position() + 1" /></strong>
                    </xsl:when>
                    <xsl:otherwise>&#0160;<a href="/fight/{/data/id}/{count(/data/steps/element) - position() + 1}/" class="num"><xsl:value-of select="count(/data/steps/element) - position() + 1" /></a> </xsl:otherwise>
                </xsl:choose>
            </xsl:for-each>
            <xsl:choose>
                <xsl:when test="page = 0"> <strong class="current">Начало</strong> </xsl:when>
                <xsl:otherwise>&#0160;<a href="/fight/{id}/0/" class="num">Начало</a> </xsl:otherwise>
            </xsl:choose>
        </div></div>
    </xsl:template>

</xsl:stylesheet>