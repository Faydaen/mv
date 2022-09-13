<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template name="playerlink">
		<xsl:param name="player" />
		<xsl:param name="array" select='1' />
		<xsl:param name="link" select='1' />
		<xsl:param name="href" select="'player'" />
		<span class="user">
			<xsl:choose>
				<xsl:when test="$player/fraction = 'arrived'">
					<i class="arrived" title="Понаехавший"></i>
				</xsl:when>
                <xsl:when test="$player/fr = 'a'">
                    <i class="arrived" title="Понаехавший"></i>
                </xsl:when>
				<xsl:when test="$player/fraction = 'resident'">
					<i class="resident" title="Коренной"></i>
				</xsl:when>
                <xsl:when test="$player/fr = 'r'">
					<i class="resident" title="Коренной"></i>
				</xsl:when>
				<xsl:when test="$player/fr = 'w' or $player/fraction = 'w' or $player/fraction = 'werewolf' or $player/fr = 'werewolf'">
					<i class="npc-werewolf" title="Оборотень"></i>
				</xsl:when>
			</xsl:choose>
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
			<xsl:choose>
				<xsl:when test="$link = 0 or $player/id = 0 or $player/fr = 'w' or $player/fraction = 'w' or $player/fraction = 'werewolf' or $player/fr = 'werewolf'">
					<xsl:if test="$player/nickname != ''"><xsl:value-of select="$player/nickname" /></xsl:if>
					<xsl:if test="$player/nm != ''"><xsl:value-of select="$player/nm" /></xsl:if>
					<xsl:if test="$player/level > 0"><span class="level">[<xsl:value-of select="$player/level" />]</span></xsl:if>
					<xsl:if test="$player/lv > 0"><span class="level">[<xsl:value-of select="$player/lv" />]</span></xsl:if>
				</xsl:when>
                <xsl:when test="$player/fr = 'npc'">
					<a href="/{$href}/{$player/id}/{$player/fightid}/"><xsl:value-of select="$player/nm" /></a> <span class="level">[<xsl:value-of select="$player/lv" />]</span>
				</xsl:when>
				<xsl:otherwise>
					<xsl:if test="$player/nickname != ''"><a><xsl:attribute name="href">/<xsl:value-of select="$href" />/<xsl:choose><xsl:when test="$player/player_id"><xsl:value-of select="$player/player_id" /></xsl:when><xsl:otherwise><xsl:value-of select="$player/id" /></xsl:otherwise></xsl:choose>/</xsl:attribute><xsl:value-of select="$player/nickname" /></a> <span class="level">[<xsl:value-of select="$player/level" />]</span></xsl:if>
					<xsl:if test="$player/nm != ''"><a href="/{$href}/{$player/id}/"><xsl:value-of select="$player/nm" /></a> <span class="level">[<xsl:value-of select="$player/lv" />]</span></xsl:if>
				</xsl:otherwise>
			</xsl:choose>
		</span>
	</xsl:template>

</xsl:stylesheet>