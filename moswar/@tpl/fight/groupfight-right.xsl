<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="fight/groupfight-fighter.xsl" />

    <xsl:template match="/data">
        <xsl:for-each select="players/element">
            <xsl:if test="hp >= 1">
                <xsl:call-template name="fighter">
                    <xsl:with-param name="player" select="current()" />
                    <xsl:with-param name="fighting" select="/data/fighting" />
                    <xsl:with-param name="waiting" select="/data/waiting" />
                    <xsl:with-param name="myside" select="/data/myside" />
                    <xsl:with-param name="myid" select="/data/myid" />
                    <xsl:with-param name="myhp" select="/data/myhp" />
                </xsl:call-template>
            </xsl:if>
        </xsl:for-each>
        <xsl:for-each select="players/element">
            <xsl:if test="hp &lt; 1">
                <xsl:call-template name="fighter">
                    <xsl:with-param name="player" select="current()" />
                    <xsl:with-param name="fighting" select="/data/fighting" />
                    <xsl:with-param name="waiting" select="/data/waiting" />
                    <xsl:with-param name="myside" select="/data/myside" />
                    <xsl:with-param name="myid" select="/data/myid" />
                    <xsl:with-param name="myhp" select="/data/myhp" />
                </xsl:call-template>
            </xsl:if>
        </xsl:for-each>
    </xsl:template>

</xsl:stylesheet>
