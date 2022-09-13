<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template name="showprice">
		<xsl:param name="money" select="'0'" />
		<xsl:param name="ore" select="'0'" />
		<xsl:param name="oil" select="'0'" />
		<xsl:param name="honey" select="'0'" />
		<xsl:param name="exp" select="'0'" />
        <xsl:param name="nohoney" select="0" />
		<xsl:param name="war_zub" select="'0'" />
		<xsl:param name="war_goldenzub" select="'0'" />
		<xsl:param name="huntclub_badge" select="'0'" />
		<xsl:param name="huntclub_mobile" select="'0'" />
		<xsl:param name="petriks" select="'0'" />
		<xsl:param name="fight_star" select="'0'" />
		<xsl:if test="$money > 0"><span class="tugriki"><xsl:value-of select="format-number($money, '###,###,###')" /><i></i></span></xsl:if>
		<xsl:if test="$ore > 0"><span class="ruda"><xsl:value-of select="format-number($ore, '###,###')" /><i></i></span><xsl:if test="$nohoney = 0"> (или <span class="med"><xsl:value-of select="$ore" /><i></i></span>) </xsl:if></xsl:if>
		<xsl:if test="$oil > 0"><span class="neft"><xsl:value-of select="format-number($oil, '###,###')" /><i></i></span><xsl:if test="$nohoney = 0"> (или <span class="med"><xsl:value-of select="number($oil) * 0.2" /><i></i></span>) </xsl:if></xsl:if>
		<xsl:if test="$honey > 0"><span class="med"><xsl:value-of select="format-number($honey, '###,###')" /><i></i></span></xsl:if>
		<xsl:if test="$war_zub > 0"><xsl:value-of select="format-number($war_zub, '###,###')" /><i class="tooth-white"></i></xsl:if>
		<xsl:if test="$war_goldenzub > 0"><xsl:value-of select="format-number($war_goldenzub, '###,###')" /><i class="tooth-golden"></i></xsl:if>
		<xsl:if test="$huntclub_badge > 0"><span class="badge"><xsl:value-of select="format-number($huntclub_badge, '###,###')" /><i></i></span></xsl:if>
		<xsl:if test="$huntclub_mobile > 0"><span class="mobila"><xsl:value-of select="format-number($huntclub_mobile, '###,###')" /><i></i></span></xsl:if>
		<xsl:if test="$fight_star > 0"><span class="star"><xsl:value-of select="format-number($fight_star, '###,###')" /><i></i></span></xsl:if>
		<xsl:if test="$exp > 0"><span class="expa"><xsl:value-of select="$exp" /><i></i></span></xsl:if>
	</xsl:template>

</xsl:stylesheet>
