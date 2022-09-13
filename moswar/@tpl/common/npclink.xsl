<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template name="npclink">
		<xsl:param name="player" />
		<xsl:param name="array" select='1' />
		<xsl:param name="link" select='1' />
		<xsl:param name="href" select="'player'" />
		<span class="user">
			<i class="npc" title="Гражданин"></i>
			<xsl:choose>
                <xsl:when test="$array = '0' and $player/clan_id > 0 and $player/clan_name != ''">
					<a href="/clan/{$player/clan_id}/"><img src="/@images/clan/clan_{$player/clan_id}_ico.png" class="clan-icon" title="{$player/clan_name}" /></a>
				</xsl:when>
				<xsl:when test="$array = '0' and $player/clan > 0 and $player/clan_name != ''">
					<a href="/clan/{$player/clan}/"><img src="/@images/clan/clan_{$player/clan}_ico.png" class="clan-icon" title="{$player/clan_name}" /></a>
				</xsl:when>
				<xsl:when test="$array = '1' and $player/clan/id > 0 and $player/clan/name != ''">
					<a href="/clan/{$player/clan/id}/"><img src="/@images/clan/clan_{$player/clan/id}_ico.png" class="clan-icon" title="{$player/clan/name}" /></a>
				</xsl:when>
                <xsl:when test="$array = '1' and $player/clan/id > 0 and $player/clan/nm != ''">
					<a href="/clan/{$player/clan/id}/"><img src="/@images/clan/clan_{$player/clan/id}_ico.png" class="clan-icon" title="{$player/clan/nm}" /></a>
				</xsl:when>
                <xsl:when test="$array = '1' and $player/cl/id > 0 and $player/cl/nm != ''">
					<a href="/clan/{$player/cl/id}/"><img src="/@images/clan/clan_{$player/cl/id}_ico.png" class="clan-icon" title="{$player/cl/nm}" /></a>
				</xsl:when>
                <xsl:when test="$player/clan_id > 0 and $player/clan_name != ''">
					<a href="/clan/{$player/clan_id}/"><img src="/@images/clan/clan_{$player/clan_id}_ico.png" class="clan-icon" title="{$player/clan_name}" /></a>
				</xsl:when>
			</xsl:choose>
			<xsl:if test="$player/nickname != ''"><xsl:value-of select="$player/nickname" /></xsl:if>
			<xsl:if test="$player/nm != ''"><xsl:value-of select="$player/nm" /></xsl:if>
			<xsl:if test="$player/level > 0"><span class="level">[<xsl:value-of select="$player/level" />]</span></xsl:if>
			<xsl:if test="$player/lv > 0"><span class="level">[<xsl:value-of select="$player/lv" />]</span></xsl:if>
		</span>
	</xsl:template>

</xsl:stylesheet>