<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template name="clanlink">
		<xsl:param name="clan" />
		<span class="clan-name">
			<xsl:choose>
				<xsl:when test="$clan/fraction = 'arrived' or $clan/fr = 'a'">
					<i class="arrived" title="Понаехавший"></i>
				</xsl:when>
                <xsl:when test="$clan/fraction = 'resident' or $clan/fr = 'r'">
					<i class="resident" title="Коренной"></i>
				</xsl:when>
				<xsl:otherwise></xsl:otherwise>
			</xsl:choose>
            <xsl:if test="$clan/nm != ''">
                <img src="/@images/clan/clan_{$clan/id}_ico.png" class="clan-icon" title="{$clan/nm}" />
                <a href="/clan/{$clan/id}/"><xsl:value-of select="$clan/nm" disable-output-escaping="yes" /></a>
            </xsl:if>
            <xsl:if test="$clan/name != ''">
                <img src="/@images/clan/clan_{$clan/id}_ico.png" class="clan-icon" title="{$clan/name}" />
                <a href="/clan/{$clan/id}/"><xsl:value-of select="$clan/name" disable-output-escaping="yes" /></a>
            </xsl:if>
			<xsl:if test="$clan/level > 0">
				<span class="level">&#160;[<xsl:value-of select="$clan/level" />]</span>
			</xsl:if>
			<xsl:if test="$clan/l > 0">
				<span class="level">&#160;[<xsl:value-of select="$clan/l" />]</span>
			</xsl:if>
		</span>
	</xsl:template>

</xsl:stylesheet>
