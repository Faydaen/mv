<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template name="enemy-name">
        <xsl:param name="enemy"></xsl:param>
        <xsl:param name="npctype"></xsl:param>
        <xsl:param name="form">1</xsl:param>

        <xsl:choose>
            <xsl:when test="$form = 1">
                <xsl:choose>
                    <xsl:when test="$enemy = 'arrived'">Понаехавшим</xsl:when>
                    <xsl:when test="$enemy = 'resident'">Коренным</xsl:when>
                    <xsl:when test="$enemy = 'npc' and $npctype = 3">Риэлторшам</xsl:when>
                    <xsl:when test="$enemy = 'npc' and $npctype = 4">Рейдерам</xsl:when>
                    <xsl:when test="$enemy = 'npc' and $npctype = 5">Взяточникам</xsl:when>
                </xsl:choose>
            </xsl:when>
            <xsl:when test="$form = 2">
                <xsl:choose>
                    <xsl:when test="$enemy = 'arrived'">понаехавших</xsl:when>
                    <xsl:when test="$enemy = 'resident'">коренных</xsl:when>
                    <xsl:when test="$enemy = 'npc' and $npctype = 3">риэлторов</xsl:when>
                    <xsl:when test="$enemy = 'npc' and $npctype = 4">рейдеров</xsl:when>
                    <xsl:when test="$enemy = 'npc' and $npctype = 5">взяточников</xsl:when>
                </xsl:choose>
            </xsl:when>
            <xsl:when test="$form = 3">
                <xsl:choose>
                    <xsl:when test="$enemy = 'arrived'">Понаехавшие</xsl:when>
                    <xsl:when test="$enemy = 'resident'">Коренные</xsl:when>
                    <xsl:when test="$enemy = 'rieltor' or ($enemy = 'npc' and $npctype = 3)">Риэлторы</xsl:when>
                    <xsl:when test="$enemy = 'raider' or ($enemy = 'npc' and $npctype = 4)">Рейдеры</xsl:when>
                    <xsl:when test="$enemy = 'grafter' or ($enemy = 'npc' and $npctype = 5)">Взяточники</xsl:when>
                </xsl:choose>
            </xsl:when>
            <xsl:when test="$form = 4">
                <xsl:choose>
                    <xsl:when test="$enemy = 'arrived'">arrived</xsl:when>
                    <xsl:when test="$enemy = 'resident'">resident</xsl:when>
                    <xsl:when test="$enemy = 'rieltor'">girl107</xsl:when>
                    <xsl:when test="$enemy = 'raider'">man110</xsl:when>
                    <xsl:when test="$enemy = 'grafter'">man109</xsl:when>
                </xsl:choose>
            </xsl:when>
        </xsl:choose>
    </xsl:template>

</xsl:stylesheet>