<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template name="menu1">
        <xsl:param name="page" />
        <xsl:param name="council" />

        <table class="buttons">
            <tr>
                <td>
                    <div class="button">
                        <xsl:if test="$page = '/'"><xsl:attribute name="class">button button-current</xsl:attribute></xsl:if>
                        <a class="f" href="/sovet/">
                            <xsl:if test="$page = '/'"><xsl:attribute name="href"></xsl:attribute></xsl:if>
                            <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                            <div class="c">Холл</div>
                        </a>
                    </div>
                </td>
                <td>
                    <div class="button">
                        <xsl:if test="$page = 'map'"><xsl:attribute name="class">button button-current</xsl:attribute></xsl:if>
                        <a class="f" href="/sovet/map/">
                            <xsl:if test="$page = 'map'"><xsl:attribute name="href"></xsl:attribute></xsl:if>
                            <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                            <div class="c">Карта города</div>
                        </a>
                    </div>
                </td>
                <td>
                    <div class="button">
                        <xsl:if test="$page = 'warstats'"><xsl:attribute name="class">button button-current</xsl:attribute></xsl:if>
                        <a class="f" href="/sovet/warstats/">
                            <xsl:if test="$page = 'warstats'"><xsl:attribute name="href"></xsl:attribute></xsl:if>
                            <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                            <div class="c">Битва</div>
                        </a>
                    </div>
                </td>
                <td>
                    <xsl:choose>
                        <xsl:when test="$council = 'accepted' or $council = 'founder'">
                            <div class="button">
                                <xsl:if test="$page = 'council'"><xsl:attribute name="class">button button-current</xsl:attribute></xsl:if>
                                <a class="f" href="/sovet/council/">
                                    <xsl:if test="$page = 'council'"><xsl:attribute name="href"></xsl:attribute></xsl:if>
                                    <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                    <div class="c">Членам совета</div>
                                </a>
                            </div>
                        </xsl:when>
                        <xsl:otherwise>
                            <div class="button disabled">
                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                    <div class="c">Членам совета</div>
                                </span>
                            </div>
                        </xsl:otherwise>
                    </xsl:choose>
                </td>
            </tr>
        </table>
    </xsl:template>

</xsl:stylesheet>