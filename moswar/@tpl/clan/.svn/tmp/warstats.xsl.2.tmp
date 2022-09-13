<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

	<xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/clanlink.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Война
                </h2></div>
                <div id="content" class="clan">

                    <table class="clan-warstat-buttons">
                        <tr>
                            <td>
                                <button class="button" id="menu_begin">
                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">Начало</div>
                                    </span>
                                </button>
                            </td>
                            <td>
                                <button id="menu_step1">
									<xsl:choose>
										<xsl:when test="war/state = 'step1' or war/state = 'step2' or war/state = 'finished'">
											<xsl:attribute name="class">button</xsl:attribute>
										</xsl:when>
										<xsl:otherwise>
											<xsl:attribute name="class">button disabled</xsl:attribute>
										</xsl:otherwise>
									</xsl:choose>
                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">I этап</div>
                                    </span>
                                </button>
                            </td>
                            <td>
                                <button id="menu_step2">
									<xsl:choose>
										<xsl:when test="war/state = 'step2' or war/state = 'finished'">
											<xsl:attribute name="class">button</xsl:attribute>
										</xsl:when>
										<xsl:otherwise>
											<xsl:attribute name="class">button disabled</xsl:attribute>
										</xsl:otherwise>
									</xsl:choose>
                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">II этап</div>
                                    </span>
                                </button>
                            </td>
                            <td>
                                <button id="menu_result">
									<xsl:choose>
										<xsl:when test="war/state = 'finished'">
											<xsl:attribute name="class">button</xsl:attribute>
										</xsl:when>
										<xsl:otherwise>
											<xsl:attribute name="class">button disabled</xsl:attribute>
										</xsl:otherwise>
									</xsl:choose>
                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">Исход</div>
                                    </span>
                                </button>
                            </td>
                        </tr>
                    </table>

					<script>
						<xsl:choose>
							<xsl:when test="war/state = 'step1'">
								var state = 'step1';
							</xsl:when>
							<xsl:when test="war/state = 'step2'">
								var state = 'step2';
							</xsl:when>
							<xsl:when test="war/state = 'finished'">
								var state = 'result';
							</xsl:when>
							<xsl:otherwise>
								var state = 'begin';
							</xsl:otherwise>
						</xsl:choose>
						<![CDATA[
							if (document.location.hash != '' && $('#menu_' + document.location.hash.replace('#', '')).hasClass('disabled') == false) {
								state = document.location.hash.replace('#', '');
							}
							function switchState(state) {
								if ($('#menu_' + state).hasClass('disabled')) {
									return;
								}
								$("div[rel='block_begin'], div[rel='block_step1'], div[rel='block_step2'], div[rel='block_result']").hide();
								$("div[rel='block_" + state + "']").show();
								$("#menu_begin, #menu_step1, #menu_step2, #menu_result").removeClass('button-current');
								$("#menu_" + state).addClass('button-current');
							}
							$("#menu_begin, #menu_step1, #menu_step2, #menu_result").click(function(){switchState($(this).attr('id').replace('menu_', ''));});
						]]>
						$(document).ready(function(){
							switchState(state);
							<xsl:if test="war/state = 'step1'">
								clanShowWarUserLogs(1);
								clanShowWarUserLogs(2);
							</xsl:if>
						});
					</script>

                    
					<div class="welcome welcome-begin" rel="block_begin" style="display: none;"></div>
					<div class="block-bordered" rel="block_begin" style="display: none;">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3>Начало</h3>
                            <div class="clan-warstat">
                                <p>Солнце вращалось вокруг столицы, а галактика улыбалась своей звездной улыбкой, когда клан <xsl:call-template name="clanlink2">
                                    <xsl:with-param name="clan" select="left" /></xsl:call-template> объявил войну
                                    клану <xsl:call-template name="clanlink2"><xsl:with-param name="clan" select="right" /></xsl:call-template>
                                </p>
                                <p>В случае <b>победы</b> клан <xsl:call-template name="clanlink2"><xsl:with-param name="clan" select="left" /></xsl:call-template>
                                разрушит вражеское имущество и получит из казны клана <xsl:call-template name="clanlink2"><xsl:with-param name="clan" select="right" /></xsl:call-template>&#160;<nobr><span class="tugriki"><xsl:value-of select="format-number(left/profit/money, '###,###,###')" /><i></i></span>
                                    <span class="ruda"><xsl:value-of select="format-number(left/profit/ore, '###,###')" /><i></i></span>
                                    <span class="med"><xsl:value-of select="format-number(left/profit/honey, '###,###')" /><i></i></span>
                                    </nobr>
                                </p>
								<p>В случае <b>победы</b> клан <xsl:call-template name="clanlink2"><xsl:with-param name="clan" select="right" /></xsl:call-template>
                                получит из казны клана <xsl:call-template name="clanlink2"><xsl:with-param name="clan" select="left" /></xsl:call-template>&#160;<nobr><span class="tugriki"><xsl:value-of select="format-number(left/risks/money, '###,###,###')" /><i></i></span>
                                    <span class="ruda"><xsl:value-of select="format-number(left/risks/ore, '###,###')" /><i></i></span>
                                    <span class="med"><xsl:value-of select="format-number(left/risks/honey, '###,###')" /><i></i></span>
                                    </nobr>
                                </p>
                            </div>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                    <xsl:if test="war/state = 'step1' or war/state = 'step2' or war/state = 'finished'">
						<div class="welcome welcome-step1" rel="block_step1" style="display: none;"></div>
                        <div class="block-bordered" rel="block_step1" style="display: none;">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>I этап — Выбиваем зубы</h3>
                                <div class="clan-warstat">
                                    <p>Каждый человек в клане любит вкусно покушать и значит, что у каждого есть зубы. Задача противников выбить по 3 зуба у каждого кланера. Кто раньше выбьет — тот победитель первого этапа.
                                    <a href="/faq/war/#step1">Узнать подробнее о 1-м этапе войны</a></p>

                                    <table class="list" id="clan-warstat1-table">
                                        <tr>
                                            <th style="min-width:180px;">Текущий счет</th>
                                            <th style="text-align:center; width:50%;">
                                                <xsl:if test="stats1/wewin = 1"><xsl:attribute name="class">winning</xsl:attribute></xsl:if>
                                                Выбито зубов кланом<br /><xsl:call-template name="clanlink2"><xsl:with-param name="clan" select="left" /></xsl:call-template>
                                                <p class="num"><xsl:value-of select="stats1/enemieskilled" />/<xsl:value-of select="stats1/enemiestotalkills" /></p>
                                            </th>
                                            <th style="text-align:center; width:50%;">
                                                <xsl:if test="stats1/wewin = 0"><xsl:attribute name="class">winning</xsl:attribute></xsl:if>
                                                Выбито зубов кланом<br />
                                                <xsl:call-template name="clanlink2"><xsl:with-param name="clan" select="right" /></xsl:call-template>
                                                <p class="num"><xsl:value-of select="stats1/alliaskilled" />/<xsl:value-of select="stats1/alliastotalkills" /></p>
                                            </th>
                                        </tr>
                                        <xsl:for-each select="left/players/element">
                                            <tr class="user-logs" rel="clan1">
                                                <td>
                                                    <xsl:call-template name="playerlink"><xsl:with-param name="player" select="player" /></xsl:call-template>
                                                </td>
                                                <td>
                                                    <xsl:for-each select="zub/element">
														<xsl:choose>
															<xsl:when test="dl != ''">
																<a href="/alley/fight/{dl}/{sk}/"><i class="{class}" title="Зуб персонажа {name}"></i></a>
															</xsl:when>
															<xsl:otherwise>
																<i class="{class}" title="Зуб персонажа {name}"></i>
															</xsl:otherwise>
														</xsl:choose>
                                                    </xsl:for-each>
                                                </td>
                                                <td>
                                                    <xsl:choose>
                                                        <xsl:when test="count(myzub/element) > 0">
                                                            <xsl:for-each select="myzub/element">
                                                                <xsl:choose>
                                                                    <xsl:when test="dl != '' and dl > 0">
                                                                        <a href="/alley/fight/{dl}/{sk}/"><i class="{class}" title="Зуб персонажа {../../player/nm}"></i></a>
                                                                    </xsl:when>
                                                                    <xsl:otherwise>
                                                                        <i class="{class}" title="Зуб персонажа {../../player/nm}"></i>
                                                                    </xsl:otherwise>
                                                                </xsl:choose>
                                                            </xsl:for-each>
                                                        </xsl:when>
                                                        <xsl:when test="accesslevel = -1 or al = -1"><i>заблокирован</i></xsl:when>
                                                        <xsl:when test="accesslevel &lt; 0 or al &lt; 0"><i>заморожен</i></xsl:when>
                                                        <xsl:when test="u = 1"><i>не важно</i></xsl:when>
                                                        <xsl:otherwise><i>без потерь</i></xsl:otherwise>
                                                    </xsl:choose>
                                                </td>
                                            </tr>
                                        </xsl:for-each>
										<xsl:for-each select="right/players/element">
                                            <tr class="user-logs" rel="clan2">
                                                <td>
                                                    <xsl:call-template name="playerlink"><xsl:with-param name="player" select="player" /></xsl:call-template>
                                                </td>
                                                <td>
                                                    <xsl:choose>
                                                        <!--xsl:when test="accesslevel = -1"><i>заблокирован</i></xsl:when>
                                                        <xsl:when test="accesslevel = -2"><i>заморожен</i></xsl:when-->
                                                        <xsl:when test="count(myzub/element) > 0">
                                                            <xsl:for-each select="myzub/element">
                                                                <xsl:choose>
                                                                    <xsl:when test="dl != '' and dl > 0">
                                                                        <a href="/alley/fight/{dl}/{sk}/"><i class="{class}" title="Зуб персонажа {../../player/nm}"></i></a>
                                                                    </xsl:when>
                                                                    <xsl:otherwise>
                                                                        <i class="{class}" title="Зуб персонажа {../../player/nm}"></i>
                                                                    </xsl:otherwise>
                                                                </xsl:choose>
                                                            </xsl:for-each>
                                                        </xsl:when>
                                                        <xsl:when test="accesslevel = -1 or al = -1"><i>заблокирован</i></xsl:when>
                                                        <xsl:when test="accesslevel &lt; 0 or al &lt; 0"><i>заморожен</i></xsl:when>
                                                        <xsl:when test="u = 1"><i>не важно</i></xsl:when>
                                                        <xsl:otherwise><i>без потерь</i></xsl:otherwise>
                                                    </xsl:choose>
                                                </td>
												<td>
                                                    <xsl:for-each select="zub/element">																												<xsl:choose>
														<xsl:when test="dl != ''">
																<a href="/alley/fight/{dl}/{sk}/"><i class="{class}" title="Зуб персонажа {name}"></i></a>
															</xsl:when>
															<xsl:otherwise>
																<i class="{class}" title="Зуб персонажа {name}"></i>
															</xsl:otherwise>
														</xsl:choose>
                                                    </xsl:for-each>
                                                </td>
                                            </tr>
                                        </xsl:for-each>
                                    </table>
                                    <p><span class="dashedlink" onclick="clanShowWarUserLogs(1);">Детальная статистика по атакующему клану</span></p>
									<p><span class="dashedlink" onclick="clanShowWarUserLogs(2);">Детальная статистика по защищающемуся клану</span></p>

                                    <xsl:if test="0 and count(right/kill/element) > 0 and war/state = 'step1'">
                                        <p><b>Осталось выбить зубов:</b>&#0160;<xsl:value-of select="number(stats1/enemiestotalkills)-number(stats1/enemieskilled)" />&#0160;<span class="dashedlink" onclick="$('#clan-warstat1-remains').toggle();">список жертв</span>
                                            <span id="clan-warstat1-remains" style="display:none;"><br />
                                                <xsl:for-each select="right/kill/element">
                                                    <xsl:call-template name="playerlink"><xsl:with-param name="player" select="player" /></xsl:call-template><br />
                                                </xsl:for-each>
                                            </span>
                                        </p>
                                    </xsl:if>

                                    <!--p><b>Дата истечения I этапа:</b> 18.12.2010 16:00</p-->
                                    <xsl:if test="(war/state = 'step2' or war/state = 'finished') and war/data/st1 > 0">
                                        <p class="finished">Первый этап завершен победой клана <xsl:if test="war/data/st1 = left/id"><xsl:call-template name="clanlink2">
                                            <xsl:with-param name="clan" select="left" /></xsl:call-template></xsl:if><xsl:if test="war/data/st1 = right/id">
                                            <xsl:call-template name="clanlink2"><xsl:with-param name="clan" select="right" /></xsl:call-template></xsl:if></p>
                                    </xsl:if>
									<xsl:if test="(war/state = 'step2' or war/state = 'finished') and war/data/st1 = 0">
                                        <p class="finished">Первый этап завершился ничьей</p>
                                    </xsl:if>
                                </div>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </xsl:if>
                    
                    <xsl:if test="war/state = 'step2' or war/state = 'finished'">
					
						<div class="welcome welcome-step2" rel="block_step2" style="display: none;"></div>
                        <div class="block-bordered" rel="block_step2" style="display: none;">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>II этап — Стенка на стенку</h3>
                                <div class="clan-warstat">
                                    <p>Бои проходят <span class="fight-time">каждые 3 часа</span> за исключением <span class="pacifism-time">времени пацифизма</span> каждого из кланов.</p>

                                    <table class="fight-time-table">
                                        <tr>
                                            <xsl:value-of select="timetable" disable-output-escaping="yes" />
                                        </tr>
                                    </table>
                                    <div class="total">
                                        <table class="score">
                                            <tr>
                                                <td class="side1">
                                                    <xsl:call-template name="clanlink2"><xsl:with-param name="clan" select="left" /></xsl:call-template>
                                                </td>
                                                <td class="num"><xsl:value-of select="stats2/wins" />:<xsl:value-of select="stats2/fails" /></td>
                                                <td class="side2">
                                                    <xsl:call-template name="clanlink2"><xsl:with-param name="clan" select="right" /></xsl:call-template>
                                                </td>
                                            </tr>
                                        </table>
                                        <!--Следующий бой состоится через: <b>2:59:16</b><br />-->
                                        <span class="hint">Запись на битву состоится за 15 минут до начала боя <a href="/alley/">в закоулках</a>.</span>
                                    </div>
									<xsl:if test="count(fightlogs/element) > 0">
										<p><span class="dashedlink" onclick="$('#fightlogs').toggle();">Прошедшие бои</span></p>

										<ul id="fightlogs" style="display: none;">
											<xsl:for-each select="fightlogs/element">
												<li><a href="/fight/{id}/"><xsl:value-of select="dt" /></a> -
													<xsl:choose>
														<xsl:when test="state != 'finished'"><i>идет в данный момент</i></xsl:when>
														<xsl:when test="winner = 1"><xsl:call-template name="clanlink"><xsl:with-param name="clan" select="/data/left" /></xsl:call-template></xsl:when>
														<xsl:when test="winner = 2"><xsl:call-template name="clanlink"><xsl:with-param name="clan" select="/data/right" /></xsl:call-template></xsl:when>
														<xsl:otherwise><i>ничья</i></xsl:otherwise>
													</xsl:choose>
												</li>
											</xsl:for-each>
										</ul>
									</xsl:if>
                                    <p><b>Дата истечения II этапа:</b>&#0160;<xsl:value-of select="war/dt2" /><br />
                                        <!--Для досрочной победы клану <xsl:call-template name="clanlink2">
                                            <xsl:with-param name="clan" select="right" /></xsl:call-template> достаточно выйграть <b>3</b> битвы-->
                                    </p>
                                </div>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </xsl:if>

                    <xsl:if test="war/state = 'finished'">
					
						<div class="welcome welcome-finished" rel="block_result" style="display: none;"></div>
                        <div class="block-bordered" rel="block_result" style="display: none;">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>Исход</h3>
                                <div class="clan-warstat" align="center">
                                    <xsl:choose>
                                        <xsl:when test="winner/id = left/id or winner/id = right/id">
                                            <h1 style="margin:5px 0;">Победитель&#160;<xsl:call-template name="clanlink2"><xsl:with-param name="clan" select="winner" /></xsl:call-template></h1>
                                            <p>
                                                Клан <xsl:call-template name="clanlink2"><xsl:with-param name="clan" select="winner" /></xsl:call-template> одержал победу
                                                над кланом <xsl:call-template name="clanlink2"> <xsl:with-param name="clan" select="looser" /></xsl:call-template>
												<xsl:if test="count(results/profit)">
													и захватил
													<nobr>
													<span class="tugriki"><xsl:value-of select="format-number(results/profit/money, '###,###,###')" /><i></i></span>
													<span class="ruda"><xsl:value-of select="format-number(results/profit/ore, '###,###,###')" /><i></i></span>
													<span class="med"><xsl:value-of select="format-number(results/profit/honey, '###,###,###')" /><i></i></span>
													</nobr>
												</xsl:if>
												<xsl:if test="results/dstr/name != ''">
													, а также разрушил ему улучшение
														<xsl:value-of select="results/dstr/name" />, 70% стоимости которого также перешли победителю <nobr>
															<span class="tugriki"><xsl:value-of select="results/dstr/money" /><i></i></span>
															<span class="ruda"><xsl:value-of select="results/dstr/ore" /><i></i></span>
															<span class="med"><xsl:value-of select="results/dstr/honey" /><i></i></span>
														</nobr>
												</xsl:if>
											</p>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <h1 style="margin:5px 0;">Ничья</h1>
                                            <p>
                                                Ожесточенная война между кланами <xsl:call-template name="clanlink2"><xsl:with-param name="clan" select="left" /></xsl:call-template> и
                                                <xsl:call-template name="clanlink2"> <xsl:with-param name="clan" select="right" /></xsl:call-template> окончилась дружной попойкой
                                                в местном пивном баре. <!--(30.01.2010 15:48)-->
                                            </p>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                    <p>
                                        <b>Победитель получил:</b>
                                        <nobr>
                                        <span class="tugriki"><xsl:value-of select="results/profit/money" /><i></i></span>
                                        <span class="ruda"><xsl:value-of select="results/profit/ore" /><i></i></span>
                                        <span class="med"><xsl:value-of select="results/profit/honey" /><i></i></span>
                                        </nobr>
                                    </p>
                                    <xsl:if test="results/dstr/name != ''">
                                        <p>
                                            <b>У проигравшего разрушено улучшение:</b>
                                            <xsl:value-of select="results/dstr/name" />, 70% стоимости которого также перешли победителю <nobr>
                                                <span class="tugriki"><xsl:value-of select="results/dstr/money" /><i></i></span>
                                                <span class="ruda"><xsl:value-of select="results/dstr/ore" /><i></i></span>
                                                <span class="med"><xsl:value-of select="results/dstr/honey" /><i></i></span>
                                            </nobr>
                                        </p>
                                    </xsl:if>
                                </div>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </xsl:if>

                </div>
            </div>
        </div>
	</xsl:template>

    <xsl:template name="clanlink2">
        <xsl:param name="clan" />
        <span class="clan-name">
            <xsl:choose>
                <xsl:when test="$clan/fr = 'arrived'"><i class="arrived" title="Понаехавший"></i></xsl:when>
                <xsl:when test="$clan/fr = 'resident'"><i class="resident" title="Коренной"></i></xsl:when>
            </xsl:choose>
            <img src="/@images/clan/clan_{$clan/id}_ico.png" class="clan-icon" title="{$clan/nm}" />
            <a href="/clan/{$clan/id}/"><xsl:value-of select="$clan/nm" /></a>
        </span>
    </xsl:template>

</xsl:stylesheet>