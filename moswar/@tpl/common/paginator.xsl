<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template name="paginator">
		<xsl:param name="pages" />
		<xsl:param name="page" />
		<xsl:param name="link" />
		<xsl:param name="arrow_text" select="1" />
		<xsl:if test="count($pages/element) > 1">
			<div class="pagescroll">
				<div class="block-rounded">
					<xsl:if test="$page > 1"><a href="{$link}{$page - 1}/"><span class="arrow">&#8592;</span><xsl:if test="arrow_text = 1"> влево</xsl:if></a></xsl:if>
					<xsl:for-each select="$pages/element">
						<xsl:choose>
							<xsl:when test="current() = 'spacer'">…</xsl:when>
							<xsl:when test="current() = $page"><strong><xsl:value-of select="current()" /></strong></xsl:when>
							<xsl:otherwise><a class="num" href="{$link}{current()}/"><xsl:value-of select="current()" /></a></xsl:otherwise>
						</xsl:choose>
					</xsl:for-each>
					<xsl:if test="$page &lt; count($pages/element)"><a href="{$link}{$page + 1}/"><xsl:if test="arrow_text = 1">вправо </xsl:if><span class="arrow">&#8594;</span></a></xsl:if>
				</div>
			</div>
		</xsl:if>
	</xsl:template>

</xsl:stylesheet>