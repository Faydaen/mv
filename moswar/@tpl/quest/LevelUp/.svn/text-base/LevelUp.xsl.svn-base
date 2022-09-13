<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/google-counters.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Ура, уровень взят!
                </h2></div>
                <div id="content" class="levelup">
                    <xsl:element name="div">
                        <xsl:choose>
                            <xsl:when test="player/sex = 'male'">
                                <xsl:attribute name='class'>welcome levelup-boy</xsl:attribute>
                            </xsl:when>
                            <xsl:when test="player/sex = 'female'">
                                <xsl:attribute name='class'>welcome levelup-girl</xsl:attribute>
                            </xsl:when>
                        </xsl:choose>
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="text">
                                <table>
                                    <tr>
                                        <td style="width:50%;text-align:center;">Убито:<br /><span class="big"><xsl:value-of select="wins" /></span></td>
                                        <td style="width:50%;text-align:center;">Награблено:<br /><span class="big"><span class="tugriki"><xsl:value-of select="moneygrabbed" /><i></i></span></span></td>
                                        <!--<td style="width:33%">Бонус за прохождение:<br /><span class="big"><span class="tugriki">2000<i></i></span></span></td>-->
                                    </tr>
                                </table>
                                <xsl:call-template name="questbutton">
                                    <xsl:with-param name="quest" select="quest" />
                                </xsl:call-template>
                            </div>
                        </div>
                    </xsl:element>
                </div>
            </div>
        </div>

        <xsl:call-template name="googlecounter_level2"></xsl:call-template>
    </xsl:template>

    <xsl:template name="questbutton">
		<xsl:param name="quest" />
		<xsl:if test="quest/button != ''">
			<form action="/quest/" method="post" style="text-align: center;">
				<input type="hidden" name="action" value="nextstep" />
				<button class="button" type="submit">
					<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
						<div class="c"><xsl:value-of select="$quest/button" /></div>
					</span>
				</button>
			</form>
		</xsl:if>
	</xsl:template>

</xsl:stylesheet>
