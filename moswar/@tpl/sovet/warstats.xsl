<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="sovet/enemyname.xsl" />
    <xsl:include href="sovet/menu1.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Статистика противостояния
                </h2></div>
                <div id="content" class="council">

                    <xsl:call-template name="menu1">
                        <xsl:with-param name="page" select="'warstats'" />
                        <xsl:with-param name="council" select="council" />
                    </xsl:call-template>

                    <xsl:if test="day = 1">
                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>Выборы в Совет</h3>
                                <div class="council-battle">
                                    <p>
                                        Сегодня стороны выбирают членов Совета.
                                    </p>
                                </div>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </xsl:if>

                    <xsl:if test="day = 2">
                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>Атака</h3>
                                <div class="council-battle">
                                    <p>
                                        Сегодня стороны выбирают район города для атаки.
                                    </p>
                                </div>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </xsl:if>

                    <xsl:if test="day > 2">
                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <xsl:choose>
                                    <xsl:when test="day &lt; 4">
                                        <h3>Подготовка к битве</h3>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <h3>Атака</h3>
                                    </xsl:otherwise>
                                </xsl:choose>
                                <div class="council-battle">
                                    <xsl:choose>
                                        <xsl:when test="day &lt; 3 or (day = 3 and hour &lt; 1)">
                                            <p>Обработка результатов голосования.</p>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <p>
                                                <!--Эта неделя началась очень бурно.<br />-->
                                                <i class="resident"></i><b>Коренные</b> атаковали район <b><xsl:value-of select="resident/station" /></b>,
                                                    который принадлежит <i class="{resident/enemy}"></i><b><xsl:call-template name="enemy-name">
                                                        <xsl:with-param name="enemy" select="resident/enemy" />
                                                        <xsl:with-param name="npctype" select="resident/enemy_npc" />
                                                        <xsl:with-param name="form" select="1" /></xsl:call-template></b>.<br />
                                                <i class="arrived"></i><b>Понаехавшие</b> атаковали район <b><xsl:value-of select="arrived/station" /></b>,
                                                    который принадлежит <i class="{arrived/enemy}"></i><b><xsl:call-template name="enemy-name">
                                                        <xsl:with-param name="enemy" select="arrived/enemy" />
                                                        <xsl:with-param name="npctype" select="arrived/enemy_npc" />
                                                        <xsl:with-param name="form" select="1" /></xsl:call-template></b>.<br />
                                            </p>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </div>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </xsl:if>

                    <xsl:if test="day > 3">
                        <div class="block-bordered">
                            <div class="council-battle" style="padding:0;">
                                <table>
                                    <tr>
                                        <td style="width:50%; padding:0 5px 0 0;">
                                            <div class="clear council-battle-attack">
                                                <h3 class="title">
                                                    Атака района<br />
                                                    <xsl:value-of select="resident/station" />
                                                </h3>

                                                <h3>Дуэльные сражения</h3>
                                                <div class="hint" align="center">В зачет идут победы в дуэлях между сторонами проводимые в четверг с 0:00 до 24:00</div>

												<table class="council-battle-advantage">
													<tr>
														<td><h3><i class="resident"></i>Очков у&#160;коренных</h3></td>
														<td class="vs"></td>
														<td><h3><i class="{resident/enemy}"></i>Очков у&#160;<xsl:call-template name="enemy-name">
                                                                <xsl:with-param name="enemy" select="resident/enemy" />
                                                                <xsl:with-param name="npctype" select="resident/enemy_npc" />
                                                                <xsl:with-param name="form" select="2" /></xsl:call-template></h3>
														</td>
													</tr>
													<tr>
														<td colspan="3" class="progress">
															<div class="textbar">
																<div class="percent" style="width:{resident/points1percent}%;"></div>
																<div class="num" title="{resident/points1percent}%">Перевес (<xsl:value-of select="resident/points1percent" />%)</div>
															</div>
														</td>
													</tr>
													<tr>
														<td class="side">
															<span class="num"><xsl:value-of select="format-number(resident/points1, '#,###,###')" /></span>
															<xsl:if test="resident/points12 > 0">
																<div class="handicap"><div><span>
																	+<xsl:value-of select="format-number(resident/points12, '#,###,###')" />
																	<i class="question-icon" tooltip="1" title="Фора||Преимущество притесненной стороны, у&#160;которой меньше территорий"></i>
																</span></div></div>
															</xsl:if>
														</td>
														<td class="vs"><div class="icon vs-icon"></div></td>
														<td class="side">
															<span class="num"><xsl:value-of select="format-number(resident/points1enemy, '#,###,###')" /></span>
															<xsl:if test="resident/points1enemy2 > 0">
																<div class="handicap"><div><span>
																	+<xsl:value-of select="format-number(resident/points1enemy2, '#,###,###')" />
																	<i class="question-icon" tooltip="1" title="Фора||Преимущество притесненной стороны, у&#160;которой меньше территорий"></i>
																</span></div></div>
															</xsl:if>
														</td>
													</tr>
												</table>

                                                <xsl:if test="day > 4">
                                                    <h3>Групповые бои</h3>
                                                    <div class="hint" align="center">Проводятся в пятницу <a href="/alley/">в закоулках</a><br />каждый час с 9:00 до 24:00</div>
													<div class="hint" align="center">1 групповой бой = <xsl:value-of select="format-number(points2, '#,###,###')" /> очков</div>
                                                    
													<table class="council-battle-advantage">
														<tr>
															<td><h3><i class="resident"></i>Очков у&#160;коренных</h3></td>
															<td class="vs"></td>
															<td><h3><i class="{resident/enemy}"></i>Очков у&#160;<xsl:call-template name="enemy-name">
                                                                <xsl:with-param name="enemy" select="resident/enemy" />
                                                                <xsl:with-param name="npctype" select="resident/enemy_npc" />
                                                                <xsl:with-param name="form" select="2" /></xsl:call-template></h3>
															</td>
														</tr>
														<tr>
															<td colspan="3" class="progress">
																<div class="textbar">
																	<div class="percent" style="width:{resident/points2percent}%;"></div>
																	<div class="num" title="{resident/points2percent}%">Перевес (<xsl:value-of select="resident/points2percent" />%)</div>
																</div>
															</td>
														</tr>
														<tr>
															<td class="side">
																<span class="num"><xsl:value-of select="format-number(resident/points2, '#,###,###')" /></span>
																<xsl:if test="resident/points22 > 0">
																	<div class="handicap"><div><span>
																		+<xsl:value-of select="format-number(resident/points22, '#,###,###')" />
																		<i class="question-icon" tooltip="1" title="Фора||Преимущество притесненной стороны, у&#160;которой меньше территорий"></i>
																	</span></div></div>
																</xsl:if>
															</td>
															<td class="vs"><div class="icon vs-icon"></div></td>
															<td class="side">
																<span class="num"><xsl:value-of select="format-number(resident/points2enemy, '#,###,###')" /></span>
																<xsl:if test="resident/points2enemy2 > 0">
																	<div class="handicap"><div><span>
																		+<xsl:value-of select="format-number(resident/points2enemy2, '#,###,###')" />
																		<i class="question-icon" tooltip="1" title="Фора||Преимущество притесненной стороны, у&#160;которой меньше территорий"></i>
																	</span></div></div>
																</xsl:if>
															</td>
														</tr>
													</table>
													
													<!--
													<table class="council-battle-stats">
                                                        <tr>
                                                            <td class="side">
                                                                <h3><i class="resident"></i>Очков у&#160;коренных</h3>
                                                                <span class="num"><xsl:value-of select="format-number(resident/points2, '#,###,###')" /></span>
																<xsl:if test="resident/points22 > 0">
																	<div class="handicap"><div><span>
																		+<xsl:value-of select="format-number(resident/points22, '#,###,###')" />
																		<i class="question-icon" tooltip="1" title="Фора||Преимущество притесненной стороны, у&#160;которой меньше территорий"></i>
																	</span></div></div>
																</xsl:if>
                                                            </td>
                                                            <td class="vs"><div class="icon vs-icon"></div></td>
                                                            <td class="side">
                                                                <h3><i class="{resident/enemy}"></i>Очков у&#160; <xsl:call-template name="enemy-name">
                                                                    <xsl:with-param name="enemy" select="resident/enemy" />
                                                                    <xsl:with-param name="npctype" select="resident/enemy_npc" />
                                                                    <xsl:with-param name="form" select="2" /></xsl:call-template></h3>
                                                                <span class="num"><xsl:value-of select="format-number(resident/points2enemy, '#,###,###')" /></span>
																<xsl:if test="resident/points2enemy2 > 0">
																	<div class="handicap"><div><span>
																		+<xsl:value-of select="format-number(resident/points2enemy2, '#,###,###')" />
																		<i class="question-icon" tooltip="1" title="Фора||Преимущество притесненной стороны, у&#160;которой меньше территорий"></i>
																	</span></div></div>
																</xsl:if>
                                                            </td>
                                                        </tr>
														<tr>
															<td colspan="3" class="progress">
																<div class="textbar">
																	<div class="percent" style="width:{resident/points2percent}%;"></div>
																	<div class="num" title="{resident/points2percent}%">Перевес (<xsl:value-of select="resident/points2percent" />%)</div>
																</div>
															</td>
														</tr>
                                                    </table>
													-->
                                                </xsl:if>

                                                <h3>Общий счет</h3>
                                                <div class="hint" align="center">Сумма очков за дуэли и групповые бои. Исход после окончания групповых боев</div>
                                                <table class="council-battle-stats">
                                                    <tr>
                                                        <td class="side">
                                                            <h3><i class="resident"></i>Очков у&#160;коренных</h3>
                                                            <span class="num"><xsl:value-of select="format-number(resident/resultpoints, '#,###,###')" /></span>
                                                        </td>
                                                        <td class="vs"><div class="icon vs-icon"></div></td>
                                                        <td class="side">
                                                            <h3><i class="{resident/enemy}"></i>Очков у&#160;<xsl:call-template name="enemy-name">
                                                                <xsl:with-param name="enemy" select="resident/enemy" />
                                                                <xsl:with-param name="npctype" select="resident/enemy_npc" />
                                                                <xsl:with-param name="form" select="2" /></xsl:call-template></h3>
                                                            <span class="num"><xsl:value-of select="format-number(resident/resultpoints_enemy, '#,###,###')" /></span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                        <td style="width:50%; padding:0 5px 0 0;">

                                            <div class="clear council-battle-defence">
                                                <h3 class="title">
                                                    Атака района<br />
                                                    <xsl:value-of select="arrived/station" />
                                                </h3>

                                                <h3>Дуэльные сражения</h3>
                                                <div class="hint" align="center">В зачет идут победы в дуэлях между сторонами проводимые в четверг с 0:00 до 24:00</div>

												<table class="council-battle-advantage">
													<tr>
														<td><h3><i class="arrived"></i>Очков у&#160;понаехавших</h3></td>
														<td class="vs"></td>
														<td><h3><i class="{arrived/enemy}"></i>Очков у&#160;<xsl:call-template name="enemy-name">
                                                                <xsl:with-param name="enemy" select="arrived/enemy" />
                                                                <xsl:with-param name="npctype" select="arrived/enemy_npc" />
                                                                <xsl:with-param name="form" select="2" /></xsl:call-template></h3>
														</td>
													</tr>
													<tr>
														<td colspan="3" class="progress">
															<div class="textbar">
																<div class="percent" style="width:{arrived/points1percent}%;"></div>
																<div class="num" title="{arrived/points1percent}%">Перевес (<xsl:value-of select="arrived/points1percent" />%)</div>
															</div>
														</td>
													</tr>
													<tr>
														<td class="side">
															<span class="num"><xsl:value-of select="format-number(arrived/points1, '#,###,###')" /></span>
															<xsl:if test="arrived/points12 > 0">
																<div class="handicap"><div><span>
																	+<xsl:value-of select="format-number(arrived/points12, '#,###,###')" />
																	<i class="question-icon" tooltip="1" title="Фора||Преимущество притесненной стороны, у&#160;которой меньше территорий"></i>
																</span></div></div>
															</xsl:if>
														</td>
														<td class="vs"><div class="icon vs-icon"></div></td>
														<td class="side">
															<span class="num"><xsl:value-of select="format-number(arrived/points1enemy, '#,###,###')" /></span>
															<xsl:if test="arrived/points1enemy2 > 0">
																<div class="handicap"><div><span>
																	+<xsl:value-of select="format-number(arrived/points1enemy2, '#,###,###')" />
																	<i class="question-icon" tooltip="1" title="Фора||Преимущество притесненной стороны, у&#160;которой меньше территорий"></i>
																</span></div></div>
															</xsl:if>
														</td>
													</tr>
												</table>

                                                <xsl:if test="day > 4">
                                                    <h3>Групповые бои</h3>
                                                    <div class="hint" align="center">Проводятся в пятницу <a href="/alley/">в закоулках</a><br />каждый час с 9:00 до 24:00</div>
													<div class="hint" align="center">1 групповой бой = <xsl:value-of select="format-number(points2, '#,###,###')" /> очков</div>
                                                    
													
													<table class="council-battle-advantage">
														<tr>
															<td><h3><i class="arrived"></i>Очков у&#160;понаехавших</h3></td>
															<td class="vs"></td>
															<td><h3><i class="{arrived/enemy}"></i>Очков у&#160;<xsl:call-template name="enemy-name">
                                                                <xsl:with-param name="enemy" select="arrived/enemy" />
                                                                <xsl:with-param name="npctype" select="arrived/enemy_npc" />
                                                                <xsl:with-param name="form" select="2" /></xsl:call-template></h3>
															</td>
														</tr>
														<tr>
															<td colspan="3" class="progress">
																<div class="textbar">
																	<div class="percent" style="width:{arrived/points2percent}%;"></div>
																	<div class="num" title="{arrived/points2percent}%">Перевес (<xsl:value-of select="arrived/points2percent" />%)</div>
																</div>
															</td>
														</tr>
														<tr>
															<td class="side">
																<span class="num"><xsl:value-of select="format-number(arrived/points2, '#,###,###')" /></span>
																<xsl:if test="arrived/points22 > 0">
																	<div class="handicap"><div><span>
																		+<xsl:value-of select="format-number(arrived/points22, '#,###,###')" />
																		<i class="question-icon" tooltip="1" title="Фора||Преимущество притесненной стороны, у&#160;которой меньше территорий"></i>
																	</span></div></div>
																</xsl:if>
															</td>
															<td class="vs"><div class="icon vs-icon"></div></td>
															<td class="side">
																<span class="num"><xsl:value-of select="format-number(arrived/points2enemy, '#,###,###')" /></span>
																<xsl:if test="arrived/points2enemy2 > 0">
																	<div class="handicap"><div><span>
																		+<xsl:value-of select="format-number(arrived/points2enemy2, '#,###,###')" />
																		<i class="question-icon" tooltip="1" title="Фора||Преимущество притесненной стороны, у&#160;которой меньше территорий"></i>
																	</span></div></div>
																</xsl:if>
															</td>
														</tr>
													</table>
													
													<!--
													<table class="council-battle-stats">
                                                        <tr>
                                                            <td class="side">
                                                                <h3><i class="arrived"></i>Очков у&#160;понаехавших</h3>
                                                                <span class="num"><xsl:value-of select="format-number(arrived/points2, '#,###,###')" /></span>
																<xsl:if test="arrived/points22 > 0">
																	<div class="handicap"><div><span>
																		+<xsl:value-of select="format-number(arrived/points22, '#,###,###')" />
																		<i class="question-icon" tooltip="1" title="Фора||Преимущество притесненной стороны, у&#160;которой меньше территорий"></i>
																	</span></div></div>
																</xsl:if>
                                                            </td>
                                                            <td class="vs"><div class="icon vs-icon"></div></td>
                                                            <td class="side">
                                                                <h3><i class="{arrived/enemy}"></i>Очков у&#160;<xsl:call-template name="enemy-name">
                                                                    <xsl:with-param name="enemy" select="arrived/enemy" />
                                                                    <xsl:with-param name="npctype" select="arrived/enemy_npc" />
                                                                    <xsl:with-param name="form" select="2" /></xsl:call-template></h3>
                                                                <span class="num"><xsl:value-of select="format-number(arrived/points2enemy, '#,###,###')" /></span>
																<xsl:if test="arrived/points2enemy2 > 0">
																	<div class="handicap"><div><span>
																		+<xsl:value-of select="format-number(arrived/points2enemy2, '#,###,###')" />
																		<i class="question-icon" tooltip="1" title="Фора||Преимущество притесненной стороны, у&#160;которой меньше территорий"></i>
																	</span></div></div>
																</xsl:if>
                                                            </td>
                                                        </tr>
														<tr>
															<td colspan="3" class="progress">
																<div class="textbar">
																	<div class="percent" style="width:{arrived/points2percent}%;"></div>
																	<div class="num" title="{arrived/points2percent}%">Перевес (<xsl:value-of select="arrived/points2percent" />%)</div>
																</div>
															</td>
														</tr>
                                                    </table>
													-->
													
                                                </xsl:if>

                                                <h3>Общий счет</h3>
                                                <div class="hint" align="center">Сумма очков за дуэли и групповые бои.<br />Исход после окончания групповых боев</div>
                                                <table class="council-battle-stats">
                                                    <tr>
                                                        <td class="side">
                                                            <h3><i class="arrived"></i>Очков у&#160;понаехавших</h3>
                                                            <span class="num"><xsl:value-of select="format-number(arrived/resultpoints, '#,###,###')" /></span>
                                                        </td>
                                                        <td class="vs"><div class="icon vs-icon"></div></td>
                                                        <td class="side">
                                                            <h3><i class="{arrived/enemy}"></i>Очков у&#160;<xsl:call-template name="enemy-name">
                                                                <xsl:with-param name="enemy" select="arrived/enemy" />
                                                                <xsl:with-param name="npctype" select="arrived/enemy_npc" />
                                                                <xsl:with-param name="form" select="2" /></xsl:call-template></h3>
                                                            <span class="num"><xsl:value-of select="format-number(arrived/resultpoints_enemy, '#,###,###')" /></span>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>

                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </xsl:if>

                    <xsl:if test="day > 5">
                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>Результат</h3>
                                <div class="council-battle">
                                    <p>
                                        <xsl:choose>
                                            <xsl:when test="sovet_results_calculated = 0">
												Идет обработка результатов.
											</xsl:when>
                                            <xsl:otherwise>
                                                <i class="resident"></i><b>Коренные</b> <xsl:choose>
                                                    <xsl:when test="resident/result = 1"> захватили </xsl:when>
                                                    <xsl:otherwise> не смогли захватить </xsl:otherwise>
                                                    </xsl:choose> район <b><xsl:value-of select="resident/station" /></b>.<br />
                                                <i class="arrived"></i><b>Понаехавшие</b> <xsl:choose>
                                                    <xsl:when test="arrived/result = 1"> захватили </xsl:when>
                                                    <xsl:otherwise> не смогли захватить </xsl:otherwise>
                                                    </xsl:choose> район <b><xsl:value-of select="arrived/station" /></b>.
                                            </xsl:otherwise>
                                        </xsl:choose>
                                    </p>
                                </div>
                                <!--h3>Результаты прошлых недель</h3-->
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </xsl:if>

                </div>
            </div>

        </div>
    </xsl:template>

</xsl:stylesheet>