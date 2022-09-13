<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
	<div class="column-right-topbg">
	    <div class="column-right-bottombg" align="center">
		<div class="heading clear">
		    <h2>
			<span style="background: url() !important;">Личное дело <xsl:value-of select="player/nickname" /></span>
		    </h2>
		</div>
		<div id="content">
			<div class="block-rounded" style="padding:10px 25px;">
			    <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
					<xsl:for-each select="news/element">
						<h3><xsl:value-of select="dt" /></h3>
						<xsl:value-of select="text" disable-output-escaping="yes" /><br /><br /><br />
					</xsl:for-each>
			</div>
		</div>
		</div>
	</div>
    </xsl:template>
</xsl:stylesheet>