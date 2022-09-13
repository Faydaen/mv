<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/npclink.xsl" />
    <xsl:include href="common/playerslogan.xsl" />
    <xsl:include href="common/stats.xsl" />


    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    <span class="boj"></span>
                </h2></div>
                <div id="content" class="fight">
                    <h3 class="curves clear">
                        <div class="fighter1"><xsl:call-template name="playerlink"><xsl:with-param name="player" select="player" /></xsl:call-template></div>
                        <div class="fighter2">
                            <xsl:choose>
                                <xsl:when test="npc = 1">
                                    <xsl:call-template name="npclink"><xsl:with-param name="player" select="enemy" /></xsl:call-template>
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:call-template name="playerlink"><xsl:with-param name="player" select="enemy" /></xsl:call-template>
                                </xsl:otherwise>
                            </xsl:choose>
                        </div>
                    </h3>

                    <table class="layout">
                        <tr>
                            <td class="fighter1-cell" align="left">
                                <div class="fighter-preview">
                                    <div class="{player/background}" id="avatar-back">
                                        <img style="background: url(/@/images/pers/{player/avatar});" src="/@/images/pers/{player/avatar_without_ext}_eyes.gif" />
                                    </div>
                                    <div class="block-rounded" style="background-color:#f7b142;">
                                        <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                                        <xsl:call-template name="stats">
                                            <xsl:with-param name="player" select="player" />
                                        </xsl:call-template>
                                    </div>
                                    <xsl:call-template name="playerslogan">
                                        <xsl:with-param name="player" select="player" />
                                    </xsl:call-template>
                                </div>
                            </td>
                            <td class="vs"><i class="icon vs-icon"></i></td>
                            <td class="fighter2-cell" align="right">
                                <div class="fighter-preview">
                                    <div class="{enemy/background}" id="avatar-back">
                                        <img style="background: url(/@/images/pers/{enemy/avatar});" src="/@/images/pers/{enemy/avatar_without_ext}_eyes.gif"/>
                                    </div>
                                    <div class="block-rounded" style="background-color:#f7b142;">
                                        <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                                        <xsl:call-template name="stats">
                                            <xsl:with-param name="player" select="enemy" />
                                        </xsl:call-template>
                                    </div>
                                    <xsl:call-template name="playerslogan">
                                        <xsl:with-param name="player" select="enemy" />
                                    </xsl:call-template>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div class="fight-button-block curves">
                        <div class="button button-back">
                            <a class="f" href="/alley/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                <div class="c">Назад</div>
                            </a>
                        </div>
                        <div class="button button-fight">
                            <xsl:choose>
                                <xsl:when test="npc = 1">
                                    <a class="f" href="/alley/attack-npc2/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">Напасть!</div>
                                    </a>
                                </xsl:when>
                                <xsl:otherwise>
                                    <a class="f" href="#" onclick="alleyAttack({enemy/id}, 1, {werewolf});return false;"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">Напасть!</div>
                                    </a>
                                </xsl:otherwise>
                            </xsl:choose>
                        </div>
                        <xsl:if test="search_type != 'nick'">
                            <div class="button button-search">
                                <a class="f" href="/alley/search/again/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                    <div class="c">Искать другого</div>
                                </a>
                            </div>
                        </xsl:if>
                    </div>

                </div>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>