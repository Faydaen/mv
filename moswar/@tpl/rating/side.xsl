<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/clanlink.xsl" />
    <xsl:include href="common/playerlink.xsl" />

    <xsl:template match="/data">
		<xsl:if test="count(moneygrabbed/players/element) > 0">
			<div class="side-rating">
				<h3><a href="/rating/moneygrabbed/">Топ грабителей</a></h3>
				<ul class="list-users">
					<xsl:for-each select="moneygrabbed/players/element">
						<li>
							<xsl:call-template name="playerlink">
								<xsl:with-param name="player" select="current()" />
							</xsl:call-template>
						</li>
					</xsl:for-each>
				</ul>
			</div>
		</xsl:if>
					
		<xsl:if test="count(clans/clans/element) > 0">
			<div class="side-rating">
				<h3><a href="/rating/clans/">Топ кланов</a></h3>
				<ul class="list-users">
					<xsl:for-each select="clans/clans/element">
						<li>
							<xsl:call-template name="clanlink">
								<xsl:with-param name="clan" select="current()" />
							</xsl:call-template>
						</li>
					</xsl:for-each>
				</ul>
			</div>
		</xsl:if>
    </xsl:template>

</xsl:stylesheet>