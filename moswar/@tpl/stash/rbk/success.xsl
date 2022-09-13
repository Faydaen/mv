<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/google-counters.xsl" />

    <xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Мёд куплен / Покупка мёда через RBK Money</h2>
				</div>
				<div id="content" class="stash">

					<div style="float: right; width: 140px; text-align: center;">
						<img src="/@/images/pers/man101.png" align="right" />
					</div>

					<div style="margin-right:150px">
						<p>Вы успешно добыли <span class="med"><xsl:value-of select="amount" /><i></i></span> через RBK Money.</p>
					</div>
				</div>
			</div>
		</div>

        <xsl:call-template name="googlecounter_payment"></xsl:call-template>
    </xsl:template>

</xsl:stylesheet>