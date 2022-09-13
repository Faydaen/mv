<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/clanlink.xsl" />
    <xsl:include href="common/clan-error.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    <span class="clan"></span>
                </h2></div>
                <div id="content" class="clan">

                    <div class="welcome" style="margin-bottom:15px;">
                        <i class="emblem">
                            <xsl:attribute name="style">background:url(http://img.moswar.ru/@images/clan/clan_<xsl:value-of select="clan/id" />_logo.png);</xsl:attribute>
                        </i>
                    </div>

                    <xsl:if test="count(result) > 0">
                        <div class="report">
                            <xsl:call-template name="error">
                                <xsl:with-param name="result" select="result" />
                            </xsl:call-template>
                        </div>
                    </xsl:if>

                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <div class="clan-diplomacy">
                                <h3>Дипломатия</h3>

								<xsl:if test="/data/diplomat = 1 and /data/clan/state = ''">
									<div align="center" class="clan-diplomacy-detective">
										<p>Если у вашего клана нет времени на поиск врагов, то вы можете воспользоваться услугами частного сыщика. Он поможет вам найти подходящих соперников для войны.<br />
										<b>Будьте внимательны! Сыщик даст посмотреть на список только раз, после чего этот компромат будет уничтожен.</b></p>
										<div style="text-align:center;">
											<button class="button" onclick="clanHireDetective();">
												<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">Нанять сыщика - <span class="med"><xsl:value-of select="cost_hire_detective/honey" /><i></i></span></div>
												</span>
											</button>
										</div>
									</div>
								</xsl:if>
								
								<p><i>— Если мы хотим пользоваться миром, приходится сражаться. (Цицерон)</i></p>
								
                                <xsl:choose>
                                    <xsl:when test="count(clan/diplomacy/element) = 0">
                                        <p>Ваш клан порочных связей не имеет. Скучно.</p>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <table class="list-clans clans-diplomacy-table">
                                            <xsl:for-each select="clan/diplomacy/element">
                                                <tr>
                                                    <td class="name">
                                                        <span class="clan-name">
                                                            <xsl:choose>
                                                                <xsl:when test="fraction = 'arrived'"><i class="arrived" title="Понаехавший"></i></xsl:when>
                                                                <xsl:when test="fraction = 'resident'"><i class="resident" title="Коренной"></i></xsl:when>
                                                            </xsl:choose>
                                                            <img src="/@images/clan/clan_{id}_ico.png" class="clan-icon" title="{name}" />
                                                            <a href="/clan/{id}/"><xsl:value-of select="name" /></a>
                                                        </span>
                                                    </td>
                                                    <td class="state">
                                                        <xsl:choose>
                                                            <xsl:when test="state = 'accepted' and type = 'union'">
                                                                <span class="friend">союз</span>
                                                            </xsl:when>
                                                            <xsl:when test="(state = 'paused' or state = 'step1' or state='step2') and type = 'war'">
                                                                <span class="enemy">война до <xsl:value-of select="dt2" /></span>
                                                                <xsl:choose>
                                                                    <xsl:when test="state = 'paused'"> (<a href="/faq/war/#paused">подготовка к войне</a>)</xsl:when>
                                                                    <xsl:when test="state = 'step1'"> (<a href="/faq/war/#step1">первый этап</a>)</xsl:when>
                                                                    <xsl:when test="state = 'step2'"> (<a href="/faq/war/#step2">второй этап</a>)</xsl:when>
                                                                </xsl:choose>
                                                            </xsl:when>
                                                            <xsl:when test="state = 'proposal' and type = 'union'">
                                                                <xsl:choose>
                                                                    <xsl:when test="clan1 = /data/clan/id">
                                                                        <i>мы предложили союз, ждем ответ</i>
                                                                    </xsl:when>
                                                                    <xsl:otherwise>
                                                                        <i>нам предложили союз</i>
                                                                    </xsl:otherwise>
                                                                </xsl:choose>
                                                            </xsl:when>
                                                            <xsl:when test="state = 'proposal' and type = 'war'">
                                                                <i>нам предложили присоединиться к войне</i>
                                                            </xsl:when>
                                                        </xsl:choose>
                                                    </td>
                                                    <td class="actions">

                                                        <xsl:choose>
                                                            <xsl:when test="type = 'union' and state='accepted'">
                                                                <xsl:if test="/data/diplomat = 1 and (clan1 = /data/clan/id or clan2 = /data/clan/id) and /data/myclan/war = 0">
                                                                    <button class="button" onclick="clanDiplomacyInt({diplomacy}, 'union_cancel');">
                                                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                            <div class="c">Разорвать</div>
                                                                        </span>
                                                                    </button>
                                                                </xsl:if>
                                                            </xsl:when>

                                                            <xsl:when test="type = 'union' and state='proposal'">
                                                                <xsl:if test="/data/diplomat = 1 and clan2 = /data/clan/id">
                                                                    <xsl:choose>
                                                                        <xsl:when test="/data/atwar = 1">
                                                                            Вы сможете принять или отклонить предложение только после завершения
                                                                            Вашей текущей войны.
                                                                        </xsl:when>
                                                                        <xsl:when test="/data/myunions &lt; 2">
                                                                            <button class="button" onclick="clanDiplomacyInt({diplomacy}, 'union_accept');">
                                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                                    <div class="c">Принять <span class="ruda"><xsl:value-of select="number(/data/myunions) + 1" />00<i></i></span> (или <span class="med"><xsl:value-of select="number(/data/myunions) + 1" />00<i></i></span>)</div>
                                                                                </span>
                                                                            </button>&#160;
                                                                            <button class="button" onclick="clanDiplomacyInt({diplomacy}, 'union_decline');">
                                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                                    <div class="c">Отклонить</div>
                                                                                </span>
                                                                            </button>
                                                                        </xsl:when>
                                                                        <xsl:when test="/data/myunions >= 2">
                                                                            Нельзя заключить более 2-х союзов одновременно.
                                                                        </xsl:when>
                                                                    </xsl:choose>
                                                                </xsl:if>
                                                            </xsl:when>

                                                            <xsl:when test="type = 'war' and state='proposal'">
                                                                <xsl:if test="/data/diplomat = 1">
                                                                    <xsl:choose>
                                                                        <xsl:when test="/data/atwar = 1">
                                                                            Вы сможете принять или отклонить предложение только после завершения
                                                                            Вашей текущей войны.
                                                                        </xsl:when>
                                                                        <xsl:otherwise>
                                                                            <button class="button" onclick="clanDiplomacyInt({diplomacy}, 'war_accept');">
                                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                                    <div class="c">Принять</div>
                                                                                </span>
                                                                            </button>
                                                                            &#0160;
                                                                            <button class="button" onclick="clanDiplomacyInt({diplomacy}, 'war_decline');">
                                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                                    <div class="c">Отклонить</div>
                                                                                </span>
                                                                            </button>
                                                                        </xsl:otherwise>
                                                                    </xsl:choose>
                                                                </xsl:if>
                                                            </xsl:when>

                                                            <xsl:when test="type = 'war' and surrender = 1 and (state='step2')">
                                                                <xsl:if test="/data/diplomat = 1 and (clan1 = /data/clan/id or clan2 = /data/clan/id)">
                                                                    <button class="button" onclick="clanDiplomacyInt({diplomacy}, 'war_surrender');">
                                                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                            <div class="c">Капитулировать</div>
                                                                        </span>
                                                                    </button>
                                                                </xsl:if>
                                                            </xsl:when>

                                                            <xsl:when test="type = 'war' and exit = 1 and (state='paused' or state='step1' or state='step2')">
                                                                <xsl:if test="/data/diplomat = 1 and (clan1 = /data/clan/id or clan2 = /data/clan/id)">
                                                                    <button class="button" onclick="clanDiplomacyInt({diplomacy}, 'war_exit');">
                                                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                            <div class="c">Выйти из войны</div>
                                                                        </span>
                                                                    </button>
                                                                </xsl:if>
                                                            </xsl:when>
                                                        </xsl:choose>

                                                    </td>
                                                </tr>
                                            </xsl:for-each>
                                        </table>
                                    </xsl:otherwise>
                                </xsl:choose>

								<p>Помните, что во время войны вы не можете заключать или разрывать союзы, а также принимать в клан новых
                                воинов.</p>

                                
                            </div>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                </div>
            </div>
        </div>
	</xsl:template>
</xsl:stylesheet>