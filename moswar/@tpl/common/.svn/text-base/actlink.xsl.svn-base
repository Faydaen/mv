<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template name="actlink">
		<xsl:param name="act" />
        <span>
            <xsl:choose>
                <xsl:when test="$act/fr = 'r'"><xsl:attribute name="class">name-resident</xsl:attribute></xsl:when>
                <xsl:when test="$act/fr = 'a'"><xsl:attribute name="class">name-arrived</xsl:attribute></xsl:when>
                <xsl:otherwise><xsl:attribute name="class">name-neutral</xsl:attribute></xsl:otherwise>
            </xsl:choose>
            <xsl:choose>
                <xsl:when test="$act/type = 'pet'">
                    <!--b><xsl:value-of select="$act/nm" /></b-->
                    <xsl:value-of select="$act/nm" />
                </xsl:when>
                <xsl:otherwise>
                    <b><xsl:value-of select="$act/nm" />&#0160;[<xsl:value-of select="$act/lv" />]</b>
                </xsl:otherwise>
            </xsl:choose>
        </span>
	</xsl:template>

</xsl:stylesheet>
