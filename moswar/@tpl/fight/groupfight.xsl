<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

	<xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/actlink.xsl" />
    <xsl:include href="common/item.xsl" />
    <xsl:include href="fight/groupfight-fighter.xsl" />

    <xsl:key name="actbyid" match="element" use="id" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    <span class="boj"></span>
                </h2></div>
                <div id="content" class="fight-group">

                    <form id="fightGroupForm" action="/fight/" method="post">
                        <input type="hidden" name="action" id="actionfield" value="attack" />
                        <input type="hidden" name="target" id="target" value="random" />
						
					<!-- заголовок, кол-во игроков -->
					<xsl:choose>
                        <xsl:when test="fight/state = 'starting'">
                            <h3 class="curves clear">
                                <div class="group1"><i class=""></i>Отбор игроков...</div>
                                <div class="group2"><i class=""></i>Отбор игроков...</div>
                                <img src="/@/images/ico/vs.png" />
                            </h3>
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:choose>
                                <xsl:when test="type = 'chaotic' or type = 'level' or type = 'clanwar' or type = 'metro'">
                                    <h3 class="curves welcome-groupfight clear">
                                        <div class="group1"><i class="{left/code}"></i><xsl:value-of select="left/name" /> (<xsl:value-of select="left/alive" />/<xsl:value-of select="left/count" />)</div>
                                        <div class="group2"><i class="{right/code}"></i><xsl:value-of select="right/name" /> (<xsl:value-of select="right/alive" />/<xsl:value-of select="right/count" />)</div>
                                    </h3>
                                </xsl:when>
                                <xsl:when test="type = 'flag'">
                                    <h3 class="curves welcome-groupfight-flag clear">
                                        <div class="group1"><i class="{left/code}"></i><xsl:value-of select="left/name" /> (<xsl:value-of select="left/alive" />/<xsl:value-of select="left/count" />)</div>
                                        <div class="group2"><i class="{right/code}"></i><xsl:value-of select="right/name" /> (<xsl:value-of select="right/alive" />/<xsl:value-of select="right/count" />)</div>
                                    </h3>
                                </xsl:when>
                                <xsl:when test="type = 'bank'">
                                    <h3 class="curves welcome-groupfight-bank clear">
                                        <div class="group1"><i class="{left/code}"></i><xsl:value-of select="left/name" /> (<xsl:value-of select="left/alive" />/<xsl:value-of select="left/count" />)</div>
                                        <div class="group2"><i class="{right/code}"></i><xsl:value-of select="right/name" /> (<xsl:value-of select="right/alive" />/<xsl:value-of select="right/count" />)</div>
                                    </h3>
                                </xsl:when>
                                <xsl:otherwise>
                                    <h3 class="curves clear">
                                        <div class="group1"><i class="{left/code}"></i><xsl:value-of select="left/name" /> (<xsl:value-of select="left/alive" />/<xsl:value-of select="left/count" />)</div>
                                        <div class="group2"><i class="{right/code}"></i><xsl:value-of select="right/name" /> (<xsl:value-of select="right/alive" />/<xsl:value-of select="right/count" />)</div>
                                        <img src="/@/images/ico/vs.png" />
                                    </h3>
                                </xsl:otherwise>
                            </xsl:choose>
                        </xsl:otherwise>
                    </xsl:choose>
					<!-- /заголовок, кол-во игроков -->

                        <table class="data">
                            <tr>
                                <td class="group">
<!-- игрока слева -->
                                    <ul class="list-users">
                                        <xsl:if test="fight/state != 'starting'">
                                            <xsl:if test="left/me/hp >= 1">
                                                <xsl:call-template name="fighter">
                                                    <xsl:with-param name="player" select="left/me" />
                                                    <xsl:with-param name="fighting" select="/data/fighting" />
                                                    <xsl:with-param name="waiting" select="/data/waiting" />
                                                    <xsl:with-param name="myside" select="/data/myside" />
                                                    <xsl:with-param name="myid" select="/data/myid" />
                                                    <xsl:with-param name="myhp" select="/data/myhp" />
                                                </xsl:call-template>
                                            </xsl:if>
                                            <xsl:for-each select="left/players/element">
                                                <xsl:if test="id != /data/left/me/id and hp >= 1">
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
                                            <xsl:if test="left/me/hp &lt; 1">
                                                <xsl:call-template name="fighter">
                                                    <xsl:with-param name="player" select="left/me" />
                                                    <xsl:with-param name="fighting" select="/data/fighting" />
                                                    <xsl:with-param name="waiting" select="/data/waiting" />
                                                    <xsl:with-param name="myside" select="/data/myside" />
                                                    <xsl:with-param name="myid" select="/data/myid" />
                                                    <xsl:with-param name="myhp" select="/data/myhp" />
                                                </xsl:call-template>
                                            </xsl:if>
                                            <xsl:for-each select="left/players/element">
                                                <xsl:if test="id != /data/left/me/id and hp &lt; 1">
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
                                        </xsl:if>
                                    </ul>
<!-- /игроки слева -->
                                </td>

                                <td class="log">
								
			                        <xsl:if test="fighting = 1 and player/level > 1 and count(fight/items) > 0">
			                            <div class="fight-slots clear">
											<xsl:attribute name="class">
												<xsl:choose>
													<xsl:when test="type = 'flag' or type = 'chaotic' or type = 'level' or type = 'clanwar' or type = 'metro' or type = 'bank'">fight-slots fight-slots-welcomed clear</xsl:when>
													<xsl:otherwise>fight-slots clear</xsl:otherwise>
												</xsl:choose>
											</xsl:attribute>
											<table align="center">
												<tr>
													<xsl:for-each select="fight/items/element">
														<xsl:choose>
															<xsl:when test="current() != ''">
																<td>
																	<li class="filled">
																		<label for="use-{id}">
																			<!--img title="{nm}" src="/@/images/obj/{im}"/-->
																			<xsl:call-template name="item">
																				<xsl:with-param name="item" select="current()" />
																			</xsl:call-template>
																			<span class="count">#<xsl:value-of select="drb" /></span>
																			<xsl:if test="/data/waiting = 0 and /data/myhp > 0">
																				<b><input type="radio" name="target" value="{id}" id="use-{id}" rel="{name}" /></b>
																			</xsl:if>
																		</label>
																	</li>
																</td>
															</xsl:when>
															<xsl:otherwise>
																<td>
																	<li class="empty">
																		<img src="/@/images/ico/slot.png" />
																	</li>
																</td>
															</xsl:otherwise>
														</xsl:choose>
													</xsl:for-each>
												</tr>
											</table>
										</div>
			                        </xsl:if>
								
<!-- кнопка нападения, только в бою -->
                                    <xsl:if test="fighting = 1">
                                        <div id="fight-actions">
                                            <div class="block-bordered">
                                                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                                <div class="center clear">
                                                    <div id="timer-block">
                                                        Тик-так: <span id="time-left"><xsl:value-of select="nextstep" /></span>
                                                    </div>
                                                    <xsl:choose>
                                                        <xsl:when test="fight/state = 'finishing'">
                                                            <div class="waiting">Завершение боя...</div>
                                                        </xsl:when>
                                                        <xsl:when test="fight/state = 'starting'">
                                                            <div class="waiting">Запуск боя...</div>
                                                        </xsl:when>
                                                        <xsl:when test="left/me/hp > 0">
                                                            <div class="hint">Выберите противника (справа) и нажмите кнопку:</div>
                                                            <div class="action">
                                                                <xsl:choose>
                                                                    <xsl:when test="waiting=1">
                                                                        <div class="waiting">Ждём остальных...</div>
                                                                    </xsl:when>
                                                                    <xsl:otherwise>
                                                                        <button onclick="groupFightMakeStep();return false;" type="submit" class="button"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                            <div class="c" id="fight-button-text">Атаковать: случайного</div></span>
                                                                        </button>
                                                                        <div class="waiting" style="display:none;">Ждём остальных...</div>
                                                                    </xsl:otherwise>
                                                                </xsl:choose>
                                                            </div>
                                                        </xsl:when>
                                                        <xsl:otherwise>
                                                            <div class="waiting">Жуем попкорн, пьем пепси<br />и смотрим представление...</div>
                                                        </xsl:otherwise>
                                                    </xsl:choose>
                                                </div>
                                                <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                            </div>
                                        </div>
                                        <xsl:if test="rupor = 1 and waiting = 0">
                                            <div class="block-bordered" style="margin-top:-8px">
                                                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                                <div class="center clear">
                                                    <div id="rupor-div">
                                                        <input type="text" name="rupor" id="rupor" value="" maxlength="120" onkeypress="return groupFightRuporNoenter(event)" />
														<button onclick="groupFightRupor();" class="button" type="button"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">Крикнуть</div></span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                            </div>
                                        </xsl:if>
                                    </xsl:if>
                                    <xsl:if test="viewing = 1">
                                        <div id="fight-actions">
                                            <div class="block-bordered">
                                                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                                <div class="center clear">
                                                    <div id="timer-block">
                                                        Тик-так: <span id="time-left"><xsl:value-of select="nextstep" /></span>
                                                    </div>
                                                    <xsl:choose>
                                                        <xsl:when test="fight/state = 'finishing'">
                                                            <div class="waiting">Завершение боя...</div>
                                                        </xsl:when>
                                                        <xsl:otherwise>
                                                            <div class="waiting">Жуем попкорн, пьем пепси<br />и смотрим представление...</div>
                                                        </xsl:otherwise>
                                                    </xsl:choose>
                                                </div>
                                                <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                            </div>
                                        </div>
                                    </xsl:if>
<!-- /кнопка нападения, только в бою -->

                                    <ul id="fight-log">
										<!-- результат боя, только для завершенных -->
										<xsl:if test="fight/state = 'finished' and fightresults != ''">
											<li>
												<xsl:value-of select="fightresults" disable-output-escaping="yes" />
											</li>
										</xsl:if>
										<!-- /результат боя, только для завершенных -->
                                        
                                        <!--xsl:if test="page > 0 and count(log/element) > 0"-->
                                        <xsl:if test="page > 0">
                                            <li>
                                                <h4><b>Ход <xsl:value-of select="page" /></b></h4>
                                                <div class="text">
                                                    <!-- вывод лога -->
                                                    <xsl:value-of select="log" disable-output-escaping="yes" />
                                                    <!-- /вывод лога -->
                                                </div>
                                            </li>
                                        </xsl:if>
                                        <xsl:if test="page = 0">
                                            <li>
                                                <h4><b>Начало</b></h4>
                                                <div class="text">
                                                    <xsl:choose>
                                                        <xsl:when test="type = 'bank'">
                                                            <p>На часах показывало <xsl:value-of select="fight/time" /> (<xsl:value-of select="fight/date" />), когда
                                                            подкупленный охранник банка совершенно случайно забыл закрыть за собой заднюю дверь, в которую
                                                            тут же незаметно проскользнули удачливые грабители.</p>
                                                        </xsl:when>
                                                        <xsl:otherwise>
                                                            <p>На часах показывало <xsl:value-of select="fight/time" /> (<xsl:value-of select="fight/date" />), когда
                                                            куча вооруженных и настроенных воинственно по отношению друг к другу людей случайно оказалась в одном
                                                            безлюдном месте.</p>
                                                        </xsl:otherwise>
                                                    </xsl:choose>
                                                </div>
                                            </li>
                                        </xsl:if>
                                    </ul>
                                    <script type="text/javascript">
                                        var interactive = false; /* для режима боя */
                                        var timer;
                                        <xsl:if test="count(nextstep) > 0">
                                            var timeleft = <xsl:value-of select="nextstep" />;
                                        </xsl:if>
                                        $("#fight-log > li").show();
                                        <xsl:if test="fight/state != 'finished'">
                                            timer = window.setInterval(function(){ groupFightTimer(); }, 1000);
                                        </xsl:if>
										
                                    </script>
                                </td>
                                <td class="group">
                                    <ul class="list-users">
                                        <xsl:if test="fight/state != 'starting'">
                                            <xsl:value-of select="rightplayers" disable-output-escaping="yes" />
                                        </xsl:if>
                                    </ul>
                                </td>
                            </tr>
                        </table>

                        <xsl:value-of select="pager" disable-output-escaping="yes" />
                    </form>
                    <script type="text/javascript">
                        groupFigthBindCick();
                    </script>
                </div>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>