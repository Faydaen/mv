<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template name="menu2">
        <xsl:param name="page" />
        <xsl:param name="council" />

        <table class="buttons">
            <tr>
                <td>
                    <div class="button">
                        <xsl:if test="$page = 'council'"><xsl:attribute name="class">button button-current</xsl:attribute></xsl:if>
                        <a class="f" href="/sovet/council/">
                            <xsl:if test="$page = 'council'"><xsl:attribute name="href"></xsl:attribute></xsl:if>
                            <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                            <div class="c">Командный центр</div>
                        </a>
                    </div>
                </td>
                <td>
                    <div class="button">
                        <xsl:if test="$page = 'boosts'"><xsl:attribute name="class">button button-current</xsl:attribute></xsl:if>
                        <a class="f" href="/sovet/boosts/">
                            <xsl:if test="$page = 'boosts'"><xsl:attribute name="href"></xsl:attribute></xsl:if>
                            <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                            <div class="c">Усиления</div>
                        </a>
                    </div>
                </td>
                <td>
                    <div class="button">
                        <xsl:if test="$page = 'logs'"><xsl:attribute name="class">button button-current</xsl:attribute></xsl:if>
                        <a class="f" href="/sovet/logs/">
                            <xsl:if test="$page = 'logs'"><xsl:attribute name="href"></xsl:attribute></xsl:if>
                            <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                            <div class="c">Логи</div>
                        </a>
                    </div>
                </td>
                <td>
                    <xsl:choose>
                        <xsl:when test="council = 'founder'">
                            <div class="button">
                                <xsl:if test="$page = 'glava'"><xsl:attribute name="class">button button-current</xsl:attribute></xsl:if>
                                <a class="f" href="/sovet/glava/">
                                    <xsl:if test="$page = 'glava'"><xsl:attribute name="href"></xsl:attribute></xsl:if>
                                    <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                    <div class="c">Кабинет председателя</div>
                                </a>
                            </div>
                        </xsl:when>
                        <xsl:otherwise>
                            <div class="button disabled">
                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                    <div class="c">Кабинет председателя</div>
                                </span>
                            </div>
                        </xsl:otherwise>
                    </xsl:choose>
                </td>
            </tr>
        </table>
    </xsl:template>

</xsl:stylesheet>