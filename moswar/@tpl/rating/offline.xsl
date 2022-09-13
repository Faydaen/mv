<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

	<xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/clanlink.xsl" />
    <xsl:include href="common/paginator.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Рейтинг
                </h2></div>
				<div id="content" class="rating">
					<div style="text-align: center; font-size: 34px; color:#ba7327; margin-top:110px; font-family:Comic Sans MS;">Счетоводы ушли на полдник</div>
                </div>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>
