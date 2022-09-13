<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <!--xsl:requies hre="common/playerlink.xsl" /-->

    <xsl:template name="topic-item">
        <tr class="{class}">
            <td class="read">
                <xsl:choose>
                    <xsl:when test="read = 1"><i class="icon icon-messages-nonew "></i></xsl:when>
                    <xsl:otherwise><i class="icon icon-messages-new "></i></xsl:otherwise>
                </xsl:choose>
            </td>
            <td class="name">
                <xsl:if test="deleted = 1">(удалено) </xsl:if><a href="/forum/topic/{topic}/"><xsl:value-of select="title" disable-output-escaping="yes" /></a>&#160;
                <xsl:if test="count(pages/element) > 1">
                    <small>
                        <xsl:for-each select="pages/element">
                            <xsl:choose>
                                <xsl:when test="current() = 'spacer'">…&#160;</xsl:when>
                                <xsl:otherwise>
                                    <a href="/forum/topic/{../../topic}/{current()}/"><xsl:value-of select="current()" /></a>
                                    <xsl:if test="current() &lt; count(../element)">&#160;</xsl:if>
                                </xsl:otherwise>
                            </xsl:choose>
                        </xsl:for-each>
                    </small>
                </xsl:if>
            </td>
            <td class="author"><xsl:call-template name="playerlink">
                            <xsl:with-param name="player" select="author" />
                        </xsl:call-template></td>
            <td class="replies"><xsl:value-of select="amount" /></td>
            <td class="last">
                <xsl:choose>
                    <xsl:when test="player/nickname != ''">
                        <xsl:value-of select="dt" />&#160;<a href="/forum/topic/{topic}/{count(pages/element)}#p{post_id}">ответ</a> от
                        <nobr><xsl:call-template name="playerlink">
                            <xsl:with-param name="player" select="player" />
                        </xsl:call-template></nobr>
                    </xsl:when>
                    <xsl:otherwise>
                        <i>нет ответов</i>
                    </xsl:otherwise>
                </xsl:choose></td>
        </tr>
	</xsl:template>

</xsl:stylesheet>
