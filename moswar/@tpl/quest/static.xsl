<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/google-counters.xsl" />

    <xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear"><h2>
					<xsl:value-of select="title" />
				</h2></div>
				<div id="content" class="story">
					<div id="StartQuest" class="story{step}{className}">
						<div class="block-rounded">
							<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
							<xsl:if test="text_up != ''">
								<div class="text1">
									<xsl:value-of select="text_up" disable-output-escaping="yes" />
								</div>
							</xsl:if>
							<div class="picture"></div>
							<div class="text2">
								<xsl:value-of select="text_down" disable-output-escaping="yes" />
								
								<form action="/quest/" method="post" class="actions">
									<input type="hidden" name="action" value="nextstep" />
									<button class="button" type="submit">
										<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c"><xsl:value-of select="button" /></div>
										</span>
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <xsl:if test="step = 1">
            <xsl:call-template name="googlecounter_reg"></xsl:call-template>
        </xsl:if>
    </xsl:template>

</xsl:stylesheet>