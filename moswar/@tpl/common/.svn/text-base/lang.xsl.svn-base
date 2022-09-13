<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl" version="1.0">
    <xsl:output method="html"/>

    <xsl:template name="wordcase">
		<xsl:param name="n" />
		<xsl:param name="n1" />
		<xsl:param name="n2" />
		<xsl:param name="n5" />

		<xsl:choose>
			<xsl:when test="php:function('fmod', php:function('abs', number($n)), 100) > 10 and php:function('fmod', php:function('abs', number($n)), 100) &lt; 20"><xsl:value-of select="$n5" /></xsl:when>
			<xsl:when test="php:function('fmod', php:function('abs', number($n)), 10) > 1 and php:function('fmod', php:function('abs', number($n)), 10) &lt; 5"><xsl:value-of select="$n2" /></xsl:when>
			<xsl:when test="php:function('fmod', php:function('abs', number($n)), 100) = 1"><xsl:value-of select="$n1" /></xsl:when>
			<xsl:otherwise><xsl:value-of select="$n5" /></xsl:otherwise>
		</xsl:choose>
	</xsl:template>

</xsl:stylesheet>