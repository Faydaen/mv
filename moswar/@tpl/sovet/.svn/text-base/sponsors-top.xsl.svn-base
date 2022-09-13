<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/clanlink.xsl" />
    <xsl:include href="common/playerlink.xsl" />

    <xsl:template match="/data">
        <xsl:for-each select="sponsors/element">
            <tr>
                <td class="num"><xsl:value-of select="position()" />.</td>
                <td><xsl:call-template name="playerlink"><xsl:with-param name="player" select="current()" /></xsl:call-template></td>
                <td class="value"><span class="tugriki"><xsl:value-of select="format-number(sovetmoney, '###,###,###')" /><i></i></span></td>
            </tr>
        </xsl:for-each>
    </xsl:template>

</xsl:stylesheet>