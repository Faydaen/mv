<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>

	<xsl:include href="common/playerlink.xsl" />

		<xsl:template match="/data">
			<ul type="none" style="width: 100%;">
				<xsl:for-each select="players/element">
					<li style="display: block; float: left; width: 50%;">
						<xsl:call-template name="playerlink">
							<xsl:with-param name="player" select="current()" />
						</xsl:call-template>
					</li>
				</xsl:for-each>
			</ul>
		</xsl:template>
</xsl:stylesheet>