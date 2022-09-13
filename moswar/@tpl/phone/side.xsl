<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

	<xsl:include href="common/playerlink.xsl" />

    <xsl:template match="/data">
		<xsl:if test="count(friends/element) > 0">
			<div class="side-rating">
				<h3><a href="/phone/contacts/friends/">Друзья онлайн</a></h3>
				<ul class="list-users">
					<xsl:for-each select="friends/element">
						<li>
							<xsl:call-template name="playerlink">
								<xsl:with-param name="player" select="current()" />
								<xsl:with-param name="array" select="0" />
							</xsl:call-template>
						</li>
					</xsl:for-each>
				</ul>
			</div>
		</xsl:if>
    </xsl:template>
</xsl:stylesheet>
