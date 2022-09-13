<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template name="fighter">
		<xsl:param name="player" />
        <xsl:param name="fighting" />
        <xsl:param name="waiting" />
        <xsl:param name="myside" />
        <xsl:param name="myhp" />
        <xsl:param name="myid" />
		<xsl:if test="count($player/id) = 1">
			<li>
				<xsl:choose>
					<xsl:when test="$player/hp >= 1 and $player/id = /data/left/me/id"><xsl:attribute name="class">me alive</xsl:attribute></xsl:when>
					<xsl:when test="$player/hp &lt; 1 and $player/id = /data/left/me/id"><xsl:attribute name="class">me dead</xsl:attribute></xsl:when>
					<!--<xsl:when test="$player/id = /data/player/id"><xsl:attribute name="class">me</xsl:attribute></xsl:when>-->
					<xsl:when test="$player/hp >= 1"><xsl:attribute name="class">alive</xsl:attribute></xsl:when>
					<xsl:when test="$player/hp &lt; 1"><xsl:attribute name="class">dead</xsl:attribute></xsl:when>
				</xsl:choose>
				<xsl:choose>
					<xsl:when test="$fighting = 1 and $myside != $player/sd and $myhp > 0">
						<label for="attack-{$player/id}">
                            <xsl:if test="$waiting = 0">
                                <input type="radio" name="target" id="attack-{$player/id}" value="{$player/id}" />
                            </xsl:if>
							<xsl:call-template name="playerlink">
								<xsl:with-param name="player" select="$player" />
							</xsl:call-template><br />
							<span class="life">
								<span class="bar"><span><span class="percent" style="width:{$player/procenthp}%;"></span></span></span>
								<span class="number" id="fighter{$player/id}-life"><xsl:value-of select="$player/hp" />/<xsl:value-of select="$player/mhp" /></span>
							</span>
							<xsl:if test="$player/pet/nm">
								<img title="{$player/pet/nm} {$player/pet/hp}/{$player/pet/mhp}" class="pet" src="/@/images/obj/{$player/pet/im}" />
							</xsl:if>
						</label>
					</xsl:when>
                    <xsl:when test="$fighting = 1 and $myside = $player/sd and $myid != $player/id and $myhp > 0">
						<label for="defence-{$player/id}">
                            <xsl:if test="$waiting = 0">
                                <input type="radio" name="target" id="defence-{$player/id}" value="{$player/id}" />
                            </xsl:if>
							<xsl:call-template name="playerlink">
								<xsl:with-param name="player" select="$player" />
							</xsl:call-template><br />
							<span class="life">
								<span class="bar"><span><span class="percent" style="width:{$player/procenthp}%;"></span></span></span>
								<span class="number" id="fighter{$player/id}-life"><xsl:value-of select="$player/hp" />/<xsl:value-of select="$player/mhp" /></span>
							</span>
							<xsl:if test="$player/pet/nm">
								<img title="{$player/pet/nm} {$player/pet/hp}/{$player/pet/mhp}" class="pet" src="/@/images/obj/{$player/pet/im}" />
							</xsl:if>
						</label>
					</xsl:when>
					<xsl:otherwise>
						<xsl:call-template name="playerlink">
							<xsl:with-param name="player" select="$player" />
						</xsl:call-template><br />
						<span class="life">
							<span class="bar"><span><span class="percent" style="width:{$player/procenthp}%;"></span></span></span>
							<span class="number" id="fighter{$player/id}-life"><xsl:value-of select="$player/hp" />/<xsl:value-of select="$player/mhp" /></span>
						</span>
						<xsl:if test="$player/pet/nm">
							<img title="{$player/pet/nm} {$player/pet/hp}/{$player/pet/mhp}" class="pet" src="/@/images/obj/{$player/pet/im}" />
						</xsl:if>
					</xsl:otherwise>
				</xsl:choose>
			</li>
		</xsl:if>
	</xsl:template>

</xsl:stylesheet>
