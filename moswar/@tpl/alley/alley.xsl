<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/price.xsl" />
    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/stats.xsl" />
    <xsl:include href="sovet/enemyname.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    <span class="alley"></span>
                </h2></div>
                <div id="content" class="alley">

                    <div class="welcome">
						<!--
						<div style="background:#d30000; position:absolute; top:220px; left:275px; padding:5px 8px; line-height:1.2; font-size:11px; text-align:center; -moz-border-radius:8px; border-radius:8px;">
							Ежедневно<br />
							групповые бои<br />
							<a href="/alley/#groupfight" style="color:#fff;">Стенка на стенку</a>
							<div style="color:#d30000; position:relative; font-size:200%; margin:0 0 -1.1em 0;">&#9660;</div>
						</div>
						-->
						<xsl:if test="player/level > 4">
							<xsl:if test="bankfight/state = 'created'">
								<div style="background:#155a41; position:absolute; width:150px; top:160px; right:0; padding:8px; line-height:1.2; height:64px; font-size:11px; -moz-border-radius:8px 0 0 0; border-radius:8px 0 0 0;">
									<a href="/bank/" style="color:#fff;"><img src="/@/images/pers/man108_thumb.png" style="margin-right:10px; " align="left" />
									А в это время готовится ограбление банка</a> &#9658;
								</div>
							</xsl:if>
						</xsl:if>
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="text">
                                Забредая в глухие закоулки, вы забываете, что находитесь в столице.<br />Однако это лучшее место для заработка и применения ваших боевых навыков.
                            </div>
                        </div>
                    </div>

                    <xsl:if test="count(result/result) > 0 and count(result/action) > 0 and count(result/type) > 0">
                        <xsl:call-template name="error">
                            <xsl:with-param name="result" select="result" />
                        </xsl:call-template>
                    </xsl:if>

                    <table>
                        <tr>
                            <td style="width:50%; padding:0 5px 0 0;">
                               <div class="block-bordered">
                                    <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                    <div class="center clear">
                                        <h3>Грабить соперников</h3>
										<xsl:if test="player2/werewolf = 1">
											<ul class="tabs">
												<li id="alley-search-myself-tab" class="current" onclick="showAlleySearchTab()"><i class="{player/fraction}"></i>Собой</li><li id="alley-search-werewolf-tab" onclick="showAlleySearchTab('werewolf')"><i class="npc-werewolf"></i>Оборотнем</li>
											</ul>
										</xsl:if>
										<div id="alley-search-myself">
	                                        <form class="search-alley" action="/alley/search/type/" method="post" id="searchForm">
                                                <xsl:if test="search_type = 'type' and search_error != ''">
                                                    <xsl:call-template name="search-error"><xsl:with-param name="error" select="search_error" /></xsl:call-template>
                                                </xsl:if>
												<input type="hidden" name="werewolf" value="0" />
	                                            <xsl:if test="player/lastfight > unixtime">
	                                                <p class="timer">Отдохните после драки:
	                                                <xsl:element name="span">
	                                                    <xsl:attribute name="class">timer</xsl:attribute>
	                                                    <xsl:attribute name="timer"><xsl:value-of select="player/lastfight - unixtime" /></xsl:attribute>
	                                                </xsl:element></p>
	                                            </xsl:if>
	                                            <div class="opponent">
	                                                <select name="type">
	                                                    <xsl:element name="option">
	                                                        <xsl:attribute name="value">equal</xsl:attribute>
	                                                        <xsl:if test="search_type = 'type' and type = 'equal'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
	                                                        Искать равных
	                                                    </xsl:element>
	                                                    <xsl:element name="option">
	                                                        <xsl:attribute name="value">strong</xsl:attribute>
	                                                        <xsl:if test="search_type = 'type' and type = 'strong'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
	                                                        Искать сильных
	                                                    </xsl:element>
	                                                    <xsl:element name="option">
	                                                        <xsl:attribute name="value">weak</xsl:attribute>
	                                                        <xsl:if test="search_type = 'type' and type = 'weak'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
	                                                        Искать слабых
	                                                    </xsl:element>
	                                                    <xsl:element name="option">
	                                                        <xsl:attribute name="value">enemy</xsl:attribute>
	                                                        <xsl:if test="search_type = 'type' and type = 'enemy'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
	                                                        Из списка врагов
	                                                    </xsl:element>
	                                                    <xsl:element name="option">
	                                                        <xsl:attribute name="value">victim</xsl:attribute>
	                                                        <xsl:if test="search_type = 'type' and type = 'victim'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
	                                                        Из списка жертв
	                                                    </xsl:element>
	                                                </select>
	                                            </div>
	                                            <div class="button" onclick="$('#searchForm p.error').html('Поиск...'); $('#searchForm').trigger('submit');">
	                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
	                                                    <div class="c">Искать соперника
	                                                    <xsl:if test="player/level > 1">
	                                                    —
	                                                    <xsl:call-template name="showprice">
	                                                        <xsl:with-param name="money" select="1" />
	                                                    </xsl:call-template>
	                                                    </xsl:if>
	                                                    </div>
	                                                </span>
	                                            </div>
	                                        </form>
	                                        <form class="search-name" action="/alley/search/nick/" method="post" id="searchNameForm">
												<xsl:if test="search_type = 'nick' and search_error != ''">
                                                    <xsl:call-template name="search-error"><xsl:with-param name="error" select="search_error" /></xsl:call-template>
                                                </xsl:if>
                                                <input type="hidden" name="werewolf" value="0" />
	                                            <div class="opponent">
	                                                По имени: <input type="text" name="nick" size="16" maxlength="16" />
												</div>
												<div class="button"  onclick="$('#searchNameForm').trigger('submit');">
													<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div class="c">Напасть — <span class="tugriki">1<i></i></span></div>
													</span>
												</div>
	                                        </form>

	                                        <form class="search-detailed" action="/alley/search/level/" method="post" id="searchLevelForm">
												<xsl:if test="search_type = 'level' and search_error != ''">
                                                    <xsl:call-template name="search-error"><xsl:with-param name="error" select="search_error" /></xsl:call-template>
                                                </xsl:if>
                                                <input type="hidden" name="werewolf" value="0" />
												<h3>Поиск по приметам
		                                            <div style="font-size:90%; font-weight:normal;">(только для <a href="/stash/#major">мажоров</a>)</div>
		                                        </h3>

	                                            <div class="level">
	                                                Уровень:
	                                                <input type="text" size="2" maxlength="2" name="minlevel" value="{minlevel}" /> —
	                                                <input type="text" size="2" maxlength="2" name="maxlevel" value="{maxlevel}" />
	                                            </div>
	                                        <xsl:choose>
	                                            <xsl:when test="player/playboy = 0">
	                                                <p class="brown">Вы не мажор, но <a href="/stash/">можете им стать</a>.</p>
	                                            </xsl:when>
	                                            <xsl:otherwise>
	                                                <div class="button" onclick="$('#searchLevelForm').trigger('submit');">
	                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
	                                                        <div class="c">Искать противника — <span class="tugriki">1<i></i></span></div>
	                                                    </span>
	                                                </div>
	                                            </xsl:otherwise>
	                                        </xsl:choose>
	                                        </form>
										</div>

										<xsl:if test="player2/werewolf = 1">
											<div id="alley-search-werewolf" style="display:none;">
												<form class="search-alley" action="/alley/search/type/" method="post" id="searchFormWerewolf">
													<xsl:if test="search_type = 'type' and search_error != ''">
                                                        <xsl:call-template name="search-error"><xsl:with-param name="error" select="search_error" /></xsl:call-template>
                                                    </xsl:if>
                                                    <input type="hidden" name="werewolf" value="1" />
													<xsl:if test="player/lastfight > unixtime">
														<p class="timer">Отдохните после драки:
														<xsl:element name="span">
															<xsl:attribute name="class">timer</xsl:attribute>
															<xsl:attribute name="timer"><xsl:value-of select="player/lastfight - unixtime" /></xsl:attribute>
														</xsl:element></p>
													</xsl:if>
													<div class="opponent" style="position:relative;">
														<a href="/police/werewolf/"><img src="/@/images/pers/npc2_thumb.png" align="left" style="position:absolute; left:-4px; top:-2px;" /></a>
														<select name="type">
															<xsl:element name="option">
																<xsl:attribute name="value">equal</xsl:attribute>
																<xsl:if test="search_type = 'type' and type = 'equal'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
																Искать равных
															</xsl:element>
															<xsl:element name="option">
																<xsl:attribute name="value">strong</xsl:attribute>
																<xsl:if test="search_type = 'type' and type = 'strong'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
																Искать сильных
															</xsl:element>
															<xsl:element name="option">
																<xsl:attribute name="value">weak</xsl:attribute>
																<xsl:if test="search_type = 'type' and type = 'weak'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
																Искать слабых
															</xsl:element>
															<xsl:element name="option">
																<xsl:attribute name="value">enemy</xsl:attribute>
																<xsl:if test="search_type = 'type' and type = 'enemy'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
																Из списка врагов
															</xsl:element>
															<xsl:element name="option">
																<xsl:attribute name="value">victim</xsl:attribute>
																<xsl:if test="search_type = 'type' and type = 'victim'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
																Из списка жертв
															</xsl:element>
														</select>
													</div>
													<div class="button" onclick="$('#searchForm p.error').html('Поиск...'); $('#searchFormWerewolf').trigger('submit');">
														<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">Искать соперника
															<xsl:if test="player/level > 1">
															—
															<xsl:call-template name="showprice">
																<xsl:with-param name="money" select="1" />
															</xsl:call-template>
															</xsl:if>
															</div>
														</span>
													</div>
												</form>
												<form class="search-name" action="/alley/search/nick/" method="post" id="searchNameFormWerewolf">
													<xsl:if test="search_type = 'nick' and search_error != ''">
                                                        <xsl:call-template name="search-error"><xsl:with-param name="error" select="search_error" /></xsl:call-template>
                                                    </xsl:if>
                                                    <input type="hidden" name="werewolf" value="1" />
													<div class="opponent">
														По имени: <input type="text" name="nick" size="16" maxlength="16" />
													</div>
													<div class="button"  onclick="$('#searchNameFormWerewolf').trigger('submit');">
														<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">Напасть — <span class="tugriki">1<i></i></span></div>
														</span>
													</div>
												</form>

												<form class="search-detailed" action="/alley/search/level/" method="post" id="searchLevelFormWerewolf">
													<xsl:if test="search_type = 'level' and search_error != ''">
                                                        <xsl:call-template name="search-error"><xsl:with-param name="error" select="search_error" /></xsl:call-template>
                                                    </xsl:if>
                                                    <input type="hidden" name="werewolf" value="1" />
													<h3>Поиск по приметам
														<div style="font-size:90%; font-weight:normal;">(только для <a href="/stash/#major">мажоров</a>)</div>
													</h3>

													<div class="level">
														Уровень:
														<input type="text" size="2" maxlength="2" name="minlevel" value="{werewolf_minlevel}" /> —
														<input type="text" size="2" maxlength="2" name="maxlevel" value="{werewolf_maxlevel}" />
													</div>
												<xsl:choose>
													<xsl:when test="player/playboy = 0">
														<p class="brown">Вы не мажор, но <a href="/stash/">можете им стать</a>.</p>
													</xsl:when>
													<xsl:otherwise>
														<div class="button" onclick="$('#searchLevelFormWerewolf').trigger('submit');">
															<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																<div class="c">Искать противника — <span class="tugriki">1<i></i></span></div>
															</span>
														</div>
													</xsl:otherwise>
												</xsl:choose>
												</form>
											</div>
											<script type="text/javascript">
												<![CDATA[
												var alleySearchWerewolf = getCookie("alleysearchtab");
												/* if the first time */
												if( null == alleySearchWerewolf ) {
													alleySearchWerewolf == "werewolf";
												}
												$(document).ready( function(){
													showAlleySearchTab(alleySearchWerewolf);
												});
												]]>
											</script>
										</xsl:if>
										
										<xsl:if test="player/level >= 10">
											<div class="search-neftebarrel clear">
												<div class="link">
													<span class="dashedlink" onclick="$('#search-neftebarrel-bar').toggle();">По уши в нефти</span>
												</div>
												<div id="search-neftebarrel-bar" style="display:none;">
													<div class="barrel-bar">
														<div class="percent" style="height:{neft_procent}%;"></div>
														<span class="num"><xsl:value-of select="neft_procent" />%</span>
													</div>
													<p>Нефть — ядовитое вещество. Вы можете награбить одну бочку в день:</p>
													<p class="hint">И не забудьте прогуляться по&#160;<a href="/neft/">нефтепроводу</a></p>
												</div>
											</div>
										</xsl:if>

										<xsl:if test="day = 4 and npc_type = 0">
                                            <div class="hrline" style="margin-bottom:0;"></div>
                                            <div class="search-alley">
                                                <p>Для захвата вражеского района «<a href="/sovet/map/"><xsl:value-of select="sovetmetroname" /></a>»,
                                                Вам необходимо одержать как можно больше побед над противником.</p>

                                                <div class="timeleft" style="top:auto; bottom:0;" timer="{sovetdaytimer}"><xsl:value-of select="sovetdaytimer2" /></div>

                                                <table class="collectbar">
													<tr>
														<td class="stars">
															<span style="cursor:pointer;" class="icon icon-star-empty">
                                                                <xsl:if test="sovetpoints2star1 = 1"><xsl:attribute name="class">icon icon-star-filled</xsl:attribute></xsl:if>
                                                            </span><span style="cursor:pointer;" class="icon icon-star-empty">
                                                                <xsl:if test="sovetpoints2star2 = 1"><xsl:attribute name="class">icon icon-star-filled</xsl:attribute></xsl:if>
                                                            </span><span style="cursor:pointer;" class="icon icon-star-empty">
                                                                <xsl:if test="sovetpoints2star3 = 1"><xsl:attribute name="class">icon icon-star-filled</xsl:attribute></xsl:if>
                                                            </span>
														</td>
														<td class="progress">
															<div class="textbar">
																<div class="percent" style="width:{sovetpoints2percent}%;"></div>
																<div class="num">Твоих побед: <b><xsl:value-of select="sovetpoints2" /></b> из <b><xsl:value-of select="sovetpoints2next" /></b></div>
															</div>
														</td>
														<td class="actions">
                                                            <button class="button" onclick="alleySovetTakeDayPrize();return false;">
                                                                <xsl:if test="sovetcantakedayprize = 0">
                                                                    <xsl:attribute name="class">button disabled</xsl:attribute>
                                                                    <xsl:attribute name="disabled">disabled</xsl:attribute>
                                                                </xsl:if>
                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">
                                                                        Бонус
                                                                    </div>
                                                                </span>
                                                            </button>
														</td>
													</tr>
												</table>
                                                <p class="hint" style="margin:3px 0 0 0; text-align:center">
                                                    <a href="/sovet/warstats/">Статистика захвата</a>
                                                </p>
                                            </div>
                                        </xsl:if>

                                    </div>
                                    <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                </div>

                                <xsl:if test="day = 4 and npc_type > 0">
                                    <div class="block-bordered">
                                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                        <div class="center clear">
                                            <h3>Поиск <xsl:choose>
                                                <xsl:when test="npc_type = 3">риэлторш</xsl:when>
                                                <xsl:when test="npc_type = 4">рейдеров</xsl:when>
                                                <xsl:when test="npc_type = 5">взяточников</xsl:when>
                                            </xsl:choose></h3>

                                            <form class="alley-fractionswar-search" action="/alley/search/npc/" method="post" id="searchNpcForm">
												<xsl:if test="search_type = 'npc' and search_error != ''">
	                                                <xsl:call-template name="search-error"><xsl:with-param name="error" select="search_error" /></xsl:call-template>
	                                            </xsl:if>

                                                <div class="clear">
													<p><img src="/@/images/pers/{npc_avatar}_thumb.png" align="left" title="{npc_name}" alt="{npc_name}" style="margin-top:-5px; margin-bottom:0;" />
														<xsl:choose>
	                                                        <xsl:when test="npc_type = 3">
																<b>Риэлторши</b>, несмотря на широкую улыбку, запугали всех жителей столицы. Одно неверное движение
																и они повесят на тебя ипотеку. Пришла пора показать им кузькину мать, и согнать их
																с&#160;<a href="/sovet/map/">насиженных территорий</a>.
															</xsl:when>
	                                                        <xsl:when test="npc_type = 4">
																<b>Рейдеры</b> контролируют не только многие аспекты жизни нерезиновой столицы этой страны,
																но и <a href="/sovet/map/">район</a>, который вы решили захватить.
															</xsl:when>
	                                                        <xsl:when test="npc_type = 5">
																<b>Взяточники</b> контролируют не только многие аспекты жизни нерезиновой столицы этой страны,
																но и <a href="/sovet/map/">район</a>, который вы решили захватить.
															</xsl:when>
	                                                    </xsl:choose>
													</p>
												</div>

												<div class="timeleft" timer="{sovetdaytimer}"><xsl:value-of select="sovetdaytimer2" /></div>

												<table class="collectbar"  style="margin-top:5px;">
													<tr>
														<td class="stars">
															<span style="cursor:pointer;" class="icon icon-star-empty">
                                                                <xsl:if test="sovetpoints2star1 = 1"><xsl:attribute name="class">icon icon-star-filled</xsl:attribute></xsl:if>
                                                            </span><span style="cursor:pointer;" class="icon icon-star-empty">
                                                                <xsl:if test="sovetpoints2star2 = 1"><xsl:attribute name="class">icon icon-star-filled</xsl:attribute></xsl:if>
                                                            </span><span style="cursor:pointer;" class="icon icon-star-empty">
                                                                <xsl:if test="sovetpoints2star3 = 1"><xsl:attribute name="class">icon icon-star-filled</xsl:attribute></xsl:if>
                                                            </span>
														</td>
														<td class="progress">
															<div class="textbar">
																<div class="percent" style="width:{sovetpoints2percent}%;"></div>
																<div class="num">Твоих побед: <b><xsl:value-of select="sovetpoints2" /></b> из <b><xsl:value-of select="sovetpoints2next" /></b></div>
															</div>
														</td>
														<td class="actions">
                                                            <button class="button" onclick="alleySovetTakeDayPrize();return false;" type="button">
                                                                <xsl:if test="sovetcantakedayprize = 0">
                                                                    <xsl:attribute name="class">button disabled</xsl:attribute>
                                                                    <xsl:attribute name="disabled">disabled</xsl:attribute>
                                                                </xsl:if>
                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">
                                                                        Бонус
                                                                    </div>
                                                                </span>
                                                            </button>
														</td>
													</tr>
												</table>

												<p class="hint" align="center" style="margin-top:3px;">
													Всего очков у игроков: <a href="/sovet/warstats/"><xsl:value-of select="format-number(npc_wins, '###,###')" /></a>
												</p>

                                                <xsl:if test="player/lastfight > unixtime">
                                                    <p class="borderdata">Отдохните после драки:
                                                    <xsl:element name="span">
                                                        <xsl:attribute name="class">timer</xsl:attribute>
                                                        <xsl:attribute name="timer"><xsl:value-of select="player/lastfight - unixtime" /></xsl:attribute>
                                                    </xsl:element></p>
                                                </xsl:if>

	                                            <div align="center">
													<div class="button" onclick="$('#searchNpcForm p.error').html('Поиск...'); $('#searchNpcForm').trigger('submit');">
	                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
	                                                        <div class="c">Искать соперника
	                                                            <xsl:if test="player/level > 1"> — <span class="tugriki">1<i></i></span></xsl:if>
	                                                        </div>
	                                                    </span>
	                                                </div>
                                                </div>
                                            </form>
                                        </div>
                                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                    </div>
                                </xsl:if>

								<a name="patrol"></a>
                                <div class="block-bordered">
                                    <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                    <div class="center clear">
                                        <h3>Народная дружина</h3>
                                        <form class="patrol" action="/alley/" method="post" id="patrolForm">
                                            <input type="hidden" name="action" value="patrol" />

											<xsl:choose>
                                                <xsl:when test="player/level > 2">
                                                    <p>Вы — доблестный защитник, следящий за порядком. Городу нужны такие люди.
													Купив у бабки детский свисток, документы и форму омоновца, вы отправляетесь патрулировать <nobr><i class="{player/fraction}"></i><a href="/sovet/map/">свои районы</a></nobr> и вершить правосудие.</p>
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <p><img src="/@/images/obj/symbol12.png" align="left" style="margin-top:-15px;" />Вы — доблестный защитник, следящий за порядком. Городу нужны такие люди.
													Купив у бабки детский свисток, документы и форму омоновца, Вы отправляетесь патрулировать улицы и вершить правосудие.</p>
                                                </xsl:otherwise>
                                            </xsl:choose>

											<xsl:if test="svistok = 1">
												<p style="text-align:left; margin:10px 0;">
													<img src="/@/images/obj/item12.png" align="left" style="margin-top:-10px" tooltip="1" title="Полицейский свисток||Легендарный свисток дяди Стёпы, грозы уличных хулиганов. Наконец-то от вас будет толк в патрулировании! Увеличивает доход от патруля на 30%." />
													Заполучив столь раритетный свисток, вы несомненно сможете поймать больше хулиганов и получить больше монет.
												</p>
											 </xsl:if>

                                            <xsl:if test="player/state = 'patrol'">
                                                <script type="text/javascript">
                                                    area = 'alley';
                                                </script>
                                                <table class="process">
                                                    <tr>
                                                        <td class="label">Патрулирование:</td>
                                                        <td class="progress">
                                                            <div class="exp">
                                                                <div class="bar"><div><div class="percent" style="width:{patrolpercent}%;" id="patrolbar"></div></div></div>
                                                            </div>
                                                        </td>
                                                        <td class="value" timer="{timer}" timer2="{patroltimetotal}" id="patrol" intitle="1"><xsl:value-of select="patroltimeleft2" /></td>
                                                    </tr>
                                                </table>

                                                <div style="margin:5px 0;" id="leave-patrol-button">
                                                    <span class="button" onclick="alleyPatrolLeave();">
                                                        <span class="f">
                                                            <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Улизнуть с патрулирования</div>
                                                        </span>
                                                    </span>
                                                    <p>При побеге с&#160;рабочего места вы&#160;не&#160;получите оплаты за&#160;отработанное время.</p>
                                                </div>

                                                <xsl:if test="desert/state = 'begin'">
                                                    <p>Ваши действия привлекли уличного мага Девида Блейна.
                                                        <div class="button">
                                                            <a class="f" href="/desert/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                <div class="c">Далее</div>
                                                            </a>
                                                        </div>
                                                    </p>
                                                </xsl:if>

                                            </xsl:if>

                                            <xsl:if test="patrol_available > 0 and player/state != 'patrol'">
                                                <xsl:if test="player/level > 2">
                                                    <div class="regions-choose">
                                                        <h3>Выберите район</h3>
                                                        <ul>
                                                            <xsl:for-each select="counter/element">
                                                                <li>
																	<xsl:if test="/data/metro/element[number(current())]/fraction != /data/player/fraction"><i class="icon-locked"></i></xsl:if>
                                                                    <i class="icon region{current()}" tooltip="1">
                                                                        <xsl:attribute name="title">
                                                                            <xsl:value-of select="/data/metro/element[number(current())]/name" />||<xsl:value-of select="/data/metro/element[number(current())]/info" />|||Принадлежит: <xsl:call-template name="enemy-name">
                                                                                <xsl:with-param name="enemy" select="/data/metro/element[number(current())]/fraction" /><xsl:with-param name="form" select="3" /></xsl:call-template>
                                                                                <xsl:if test="/data/metro/element[number(current())]/bonus != ''">
                                                                                    |Шанс получить: <xsl:value-of select="/data/metro/element[number(current())]/bonus" />
                                                                                </xsl:if>
                                                                        </xsl:attribute>
                                                                    </i>
                                                                    <div class="name"><b><xsl:value-of select="/data/metro/element[number(current())]/name" /></b></div>
                                                                </li>
                                                            </xsl:for-each>
                                                        </ul>
                                                        <i class="arrow-left" id="region-choose-arrow-left"></i>
                                                        <i class="arrow-right" id="region-choose-arrow-right"></i>
                                                    </div>
                                                    <script type="text/javascript">
                                                        $(document).ready(function() {
                                                            alleyInitCarousel(<xsl:value-of select="startmetro" />);
                                                        });
                                                    </script>
                                                </xsl:if>
												<input type="hidden" id="regions-choose-id" name="region" value="{startmetro}" />
												
                                                <div class="time">
                                                    Время:
                                                    <select name="time">
                                                        <xsl:for-each select="patrol_times/element">
                                                            <option value="{time}"><xsl:value-of select="time" /> минут</option>
                                                        </xsl:for-each>
                                                    </select>
                                                </div>
                                                <button id="alley-patrol-button" class="button" type="button" onclick="$('#patrolForm').trigger('submit');">
                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Патрулировать<xsl:if test="player/level > 1"> — <span class="tugriki">10<i></i></span></xsl:if></div>
                                                    </span>
                                                </button>
                                            </xsl:if>
                                            <xsl:choose>
                                                <xsl:when test="patrol_available > 0">
                                                    <p class="timeleft">Осталось времени на сегодня: <xsl:value-of select="patrol_available" /> минут</p>
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <p class="timeleft">На сегодня Вы уже истратили все время патрулирования.</p>
                                                </xsl:otherwise>
                                            </xsl:choose>
                                            <p class="major">Мажоры, привыкшие к бессонным ночным гулянкам, могут патрулировать вдвое больше. <a href="/stash/#major">Стать мажором</a>.</p>
                                        </form>
                                    </div>
                                    <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                </div>

                            </td>
                            <td style="width:50%; padding:0 0 0 5px;">

								<xsl:if test="clanwar/state != ''">
									<div class="block-bordered">
										<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
										<div class="center clear">
										<div class="groupfight-image"></div>
                                            <h3>Война</h3>
                                            <div class="alley-flag">
												<!--
												<p>
													<img src="/@/images/ico/clanfight.png" align="left" style="margin:-20px 10px 2px 0" />
												</p>
												-->
                                                <p class="holders">
                                                    <xsl:choose>
                                                        <xsl:when test="clanwar/id = 0">Запись на битву начнется в <xsl:value-of select="clanwar/nearesthour" />:45.</xsl:when>
                                                        <xsl:when test="clanwar/state = 'created'">Запись на битву началась.</xsl:when>
                                                        <xsl:when test="clanwar/state = 'started'">
                                                            <a href="/fight/{clanwar/id}/" class="now">Бой идет в данный момент</a>
                                                        </xsl:when>
                                                    </xsl:choose>
                                                </p>
                                                <xsl:if test="clanwar/id > 0">
                                                    <p class="team">
                                                        <b><i class="{clanwar/left/code}"></i><xsl:value-of select="clanwar/left/name" /> (<xsl:value-of select="clanwar/left/count" />/<xsl:value-of select="clanwar/left/max" />): </b>
                                                        <xsl:for-each select="clanwar/left/players/element">
                                                            <xsl:call-template name="playerlink">
                                                                <xsl:with-param name="player" select="current()" />
                                                            </xsl:call-template>
                                                            <xsl:if test="position() != count(/data/clanwar/left/players/element)">, </xsl:if>
                                                        </xsl:for-each>
                                                    </p>
                                                    <p class="team">
                                                        <b><i class="{clanwar/right/code}"></i><xsl:value-of select="clanwar/right/name" /> (<xsl:value-of select="clanwar/right/count" />/<xsl:value-of select="clanwar/right/max" />): </b>
                                                        <xsl:for-each select="clanwar/right/players/element">
                                                            <xsl:call-template name="playerlink">
                                                                <xsl:with-param name="player" select="current()" />
                                                            </xsl:call-template>
                                                            <xsl:if test="position() != count(/data/clanwar/right/players/element)">, </xsl:if>
                                                        </xsl:for-each>
                                                    </p>
                                                </xsl:if>
                                                <xsl:if test="clanwar/state = 'started'">
                                                    <div align="center">
                                                        <div class="button" onclick="groupFightForceJoin({clanwar/id});"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Вмешаться в бой</div></span>
                                                        </div>
                                                    </div>
                                                </xsl:if>

                                                <xsl:if test="clanwar/state = 'created' and clanwar/me = 0">
                                                    <form style="text-align:center" action="/fight/" method="post" id="flag-form">
                                                        <input type="hidden" name="action" value="join fight" />
                                                        <input type="hidden" name="fight" value="{clanwar/id}" />
                                                        <button class="button" type="submit">
                                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                <div class="c">
                                                                    Буду участвовать в битве
                                                                </div>
                                                            </span>
                                                        </button>
                                                    </form>
                                                </xsl:if>
											</div>
										</div>
										<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
									</div>
								</xsl:if>

								<xsl:if test="metrofightblock = 1">
									<div class="block-bordered">
										<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
										<div class="center clear">
                                            <h3>Битва за столицу</h3>
                                            <div class="alley-flag">
                                                <p>
                                                    Сражения за районы проходят
                                                    <nobr><b>1-2 раза в час</b></nobr> в формате <nobr>20 на 20</nobr>.
                                                    <span class="dashedlink" onclick="$('#alley-metrofight-hint').toggle();">Подробнее</span>
                                                </p>
                                                <p id="alley-metrofight-hint" style="display:none;">
                                                    В 20 минут <i class="resident"></i><b>Коренные</b> сражаются либо
                                                    <nobr>с <i class="arrived"></i><b>Понаехавшими</b></nobr>, либо с местными жителями, а в
                                                    40 минут тем же самым занимаются <i class="arrived"></i><b>Понаехавшие</b>.<br />
                                                    С кем необходимо сражаться, зависит от выбранного для атаки района.<br />
                                                    Записаться может по 40 человек с каждой стороны, а в бой попадет по 20. Еще по 40 человек с
                                                    каждой стороны сможет вмешаться.<br />
                                                    Каждый игрок сможет за день участвовать максимум в 10 боях.
                                                </p>
                                                <a name="groupfight"></a>
                                                <xsl:choose>
													<xsl:when test="metrofight = 1"><p class="holders">Бои начинаются после 9 часов утра</p></xsl:when>
													<xsl:when test="count(metrofights/element) = 0"><p class="holders">Бои завершены</p></xsl:when>
                                                </xsl:choose>
												<xsl:for-each select="metrofights/element">
													<xsl:if test="nearesthour != 0 and nearestminute != 0">
														<div class="sides"><b><i class="{attacker}"></i><xsl:value-of select="attacker_name" /> vs <i class="{enemy}"></i><xsl:value-of select="enemy_name" /></b></div>
														<div class="grouping">
															<xsl:choose>
																<xsl:when test="id = 0">
																	<h4>Запись на cледующую битву начнется в <xsl:value-of select="nearesthour" />:<xsl:value-of select="nearestminute - 10" /></h4>
																</xsl:when>
																<xsl:otherwise>
																	<xsl:choose>
																		<xsl:when test="state = 'created'">
																			<h4>Запись на битву началась</h4>
																		</xsl:when>
																		<xsl:when test="state = 'started'">
																			<h4><a href="/fight/{id}/" class="now">Бой идет в данный момент</a></h4>
																		</xsl:when>
																	</xsl:choose>

																	<xsl:if test="state = 'started' and /data/allowmetro = 1">
																		<div class="button-place">
																			<div class="button" onclick="groupFightForceJoin({id});"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																				<div class="c">Вмешаться в бой</div></span>
																			</div>
																		</div>
																	</xsl:if>
																	<xsl:if test="state = 'created' and me = 0 and /data/allowmetro = 1">
																		<form style="text-align:center; margin-bottom:5px;" action="/fight/" method="post" id="levelfight-form">
																			<input type="hidden" name="action" value="join fight" />
																			<input type="hidden" name="fight" value="{id}" />
																			<button class="button" type="submit">
																				<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																					<div class="c">
																						Записаться на бой в <xsl:value-of select="nearesthour" />:<xsl:value-of select="nearestminute" />
																					</div>
																				</span>
																			</button>
																		</form>
																	</xsl:if>

																	<div class="list-link"><span class="dashedlink" onclick="$(this).parents(':first').next('div').toggle();">Список записавшихся</span></div>
																	<div class="list" style="display: none;">
																		<p class="team">
																			<b><i class="{left/code}"></i><xsl:value-of select="left/name" /> (<xsl:value-of select="left/count" />/<xsl:value-of select="left/max" />): </b>
																			<xsl:for-each select="left/players/element">
																				<xsl:call-template name="playerlink">
																					<xsl:with-param name="player" select="current()" />
																				</xsl:call-template>
																				<xsl:if test="position() != count(../element)">, </xsl:if>
																			</xsl:for-each>
																		</p>
																		<xsl:choose>
																			<xsl:when test="enemy = 'npc'">
																				<p class="team"><i class="npc"></i><b><xsl:choose>
																						<xsl:when test="npc_type = 3">Риэлторши</xsl:when>
																						<xsl:when test="npc_type = 4">Рейдеры</xsl:when>
																						<xsl:when test="npc_type = 5">Взяточники</xsl:when>
																					</xsl:choose> (<xsl:value-of select="left/count" />/<xsl:value-of select="left/max" />)</b>
																				</p>
																			</xsl:when>
																			<xsl:otherwise>
																				<p class="team">
																					<b><i class="{right/code}"></i><xsl:value-of select="right/name" /> (<xsl:value-of select="right/count" />/<xsl:value-of select="right/max" />): </b>
																					<xsl:for-each select="right/players/element">
																						<xsl:call-template name="playerlink">
																							<xsl:with-param name="player" select="current()" />
																						</xsl:call-template>
																						<xsl:if test="position() != count(../element)">, </xsl:if>
																					</xsl:for-each>
																				</p>
																			</xsl:otherwise>
																		</xsl:choose>
																	</div>
																</xsl:otherwise>
															</xsl:choose>
														</div>
													</xsl:if>
												</xsl:for-each>
                                                <xsl:if test="allowmetro = 0">
                                                    <p class="holders">Вы уже участвовали в 10 боях сегодня.</p>
                                                </xsl:if>

                                                <div class="timeleft" timer="{sovetdaytimer}"><xsl:value-of select="sovetdaytimer2" /></div>

                                                <table class="collectbar">
													<tr>
														<td class="stars">
															<span style="cursor:pointer;" class="icon icon-star-empty">
                                                                <xsl:if test="sovetpoints3star1 = 1"><xsl:attribute name="class">icon icon-star-filled</xsl:attribute></xsl:if>
                                                            </span><span style="cursor:pointer;" class="icon icon-star-empty">
                                                                <xsl:if test="sovetpoints3star2 = 1"><xsl:attribute name="class">icon icon-star-filled</xsl:attribute></xsl:if>
                                                            </span><span style="cursor:pointer;" class="icon icon-star-empty">
                                                                <xsl:if test="sovetpoints3star3 = 1"><xsl:attribute name="class">icon icon-star-filled</xsl:attribute></xsl:if>
                                                            </span>
														</td>
														<td class="progress">
															<div class="textbar">
																<div class="percent" style="width:{sovetpoints3percent}%;"></div>
																<div class="num">Твоих побед: <b><xsl:value-of select="sovetpoints3" /></b> из <b><xsl:value-of select="sovetpoints3next" /></b></div>
															</div>
														</td>
														<td class="actions">
                                                            <button class="button" onclick="alleySovetTakeDayPrize();return false;">
                                                                <xsl:if test="sovetcantakedayprize = 0">
                                                                    <xsl:attribute name="class">button disabled</xsl:attribute>
                                                                    <xsl:attribute name="disabled">disabled</xsl:attribute>
                                                                </xsl:if>
                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">
                                                                        Бонус
                                                                    </div>
                                                                </span>
                                                            </button>
														</td>
													</tr>
												</table>
                                                <p class="hint" style="margin:3px 0 0 0; text-align:center">
                                                    <a href="/sovet/warstats/">Статистика захвата</a>
                                                </p>
                                            </div>
										</div>
										<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
									</div>
								</xsl:if>

                                <div class="block-bordered">
                                    <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                    <div class="center clear">
                                        <h3>Стенка на стенку</h3>
                                        <div class="alley-flag">
                                            <p>
                                                Ежедневно коренные и понаехавшие выясняют между собой отношения в боях стенкой на стенку.
                                                Сражения проходят <b>каждый&#0160;час</b> в формате <nobr>15 на 15</nobr> среди участников <b>своего уровня</b>.
                                                <span class="dashedlink" onclick="$('#alley-groupfight-hint').toggle();">Подробнее</span>
                                            </p>
                                            <p id="alley-groupfight-hint" style="display:none;">
                                                Запись на бой начинается за 15 минут до начала битвы.<br />
                                                Записаться могут по 30 бойцов с каждой стороны, но в бой попадают только по 15 сильнейших участников с каждой стороны.
                                                А тем, кто не попал, вступительный взнос будет возвращен.<br /><br />
                                                Максимальный призовой фонд:&#0160;
                                                <xsl:if test="levelfight/prize/m > 0"><span class="tugriki"><xsl:value-of select="levelfight/prize/m" /><i></i></span></xsl:if> <xsl:if test="levelfight/prize/o > 0"><span class="ruda"><xsl:value-of select="levelfight/prize/o" /><i></i></span></xsl:if>.
                                                <br />Если в бою участвует менее 15 человек, то призовой фонд уменьшается пропорционально.
                                            </p>
											<a name="groupfight"></a>

											<xsl:choose>
												<xsl:when test="levelfight/id = 0">
													<p class="holders">Запись на cледующую битву начнется в <xsl:value-of select="levelfight/nearesthour - 1" />:45.</p>
													<div class="hint" style="text-align: center; margin-top: -5px;">Можно надраться и трезвым остаться!</div>
												</xsl:when>
												<xsl:when test="levelfight/state = 'created'">
													<p class="holders">Запись на битву началась.<br />Максимальный призовой фонд:&#0160;
													<xsl:if test="levelfight/prize/m > 0"><span class="tugriki"><xsl:value-of select="levelfight/prize/m" /><i></i></span></xsl:if> <xsl:if test="levelfight/prize/o > 0"><span class="ruda"><xsl:value-of select="levelfight/prize/o" /><i></i></span></xsl:if>.</p>
												</xsl:when>
												<xsl:when test="levelfight/state = 'started'">
													<p class="holders"><a href="/fight/{levelfight/id}/" class="now">Бой идет в данный момент</a></p>
												</xsl:when>
											</xsl:choose>

                                            <xsl:if test="levelfight/id > 0">
                                                <p class="team">
                                                    <b><i class="{levelfight/left/code}"></i><xsl:value-of select="levelfight/left/name" /> (<xsl:value-of select="levelfight/left/count" /><!--скрыто-->/<xsl:value-of select="levelfight/left/max" />): </b>
                                                    <xsl:for-each select="levelfight/left/players/element">
                                                        <xsl:call-template name="playerlink">
                                                            <xsl:with-param name="player" select="current()" />
                                                        </xsl:call-template>
                                                        <xsl:if test="position() != count(/data/levelfight/left/players/element)">, </xsl:if>
                                                    </xsl:for-each>
                                                </p>
                                                <p class="team">
                                                    <b><i class="{levelfight/right/code}"></i><xsl:value-of select="levelfight/right/name" /> (<xsl:value-of select="levelfight/right/count" /><!--скрыто-->/<xsl:value-of select="levelfight/right/max" />): </b>
													<xsl:for-each select="levelfight/right/players/element">
                                                        <xsl:call-template name="playerlink">
                                                            <xsl:with-param name="player" select="current()" />
                                                        </xsl:call-template>
                                                        <xsl:if test="position() != count(/data/levelfight/right/players/element)">, </xsl:if>
                                                    </xsl:for-each>
                                                </p>
                                            </xsl:if>
                                            <xsl:if test="levelfight/state = 'started'">
                                                <div align="center">
                                                    <div class="button" onclick="groupFightForceJoin({levelfight/id});"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Вмешаться в бой</div></span>
                                                    </div>
                                                </div>
                                            </xsl:if>
                                            <xsl:if test="levelfight/state = 'created' and levelfight/me = 0">
                                                <form style="text-align:center" action="/fight/" method="post" id="levelfight-form">
                                                    <input type="hidden" name="action" value="join fight" />
                                                    <input type="hidden" name="fight" value="{levelfight/id}" />
                                                    <button class="button" type="submit">
                                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">
                                                                Записаться на бой в <xsl:value-of select="levelfight/nearesthour" />:00 — <xsl:if test="levelfight/price/m > 0"><span class="tugriki"><xsl:value-of select="levelfight/price/m" /><i></i></span></xsl:if> <xsl:if test="levelfight/price/o > 0"><span class="ruda"><xsl:value-of select="levelfight/price/o" /><i></i></span></xsl:if>
                                                            </div>
                                                        </span>
                                                    </button>
                                                </form>
                                            </xsl:if>
                                        </div>
                                    </div>
                                    <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                </div>
								
                                <div class="block-bordered">
                                    <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                    <div class="center clear">
                                        <h3>Битва за Флаг</h3>
                                        <div class="alley-flag">
                                            <p><img src="/@/images/obj/flag.png" align="left" style="margin-top:-20px" />У одного из жителей столицы есть флаг, который делает более удачливым в боях своего владельца
                                            и всех его сторонников. Для того, чтобы завладеть флагом, необходимо убить хранителя в ежедневной
                                            <a href="/faq/flag/">Битве за Флаг</a>, которая  начинается в 21:30. Запись на бой начинается за 15 минут до его начала.</p>
                                            <p class="holders">
                                                Сейчас флагом владеют <b><i class="{flag/fraction}"></i><xsl:choose><xsl:when test="flag/fraction = 'arrived'">понаехавшие</xsl:when><xsl:when test="flag/fraction = 'resident'">коренные</xsl:when></xsl:choose></b>.<br />
                                                <xsl:choose>
                                                    <xsl:when test="flag/id = 0">Запись на битву начнется в 21:15.</xsl:when>
                                                    <xsl:when test="flag/state = 'created'">Запись на битву началась.</xsl:when>
                                                    <xsl:when test="flag/state = 'started'">
                                                        <a href="/fight/{flag/id}/" class="now">Бой идет в данный момент</a>
                                                    </xsl:when>
                                                </xsl:choose>
                                            </p>
                                            <xsl:if test="flag/id > 0">
                                                <p class="team">
                                                    <b><i class="{flag/left/code}"></i><xsl:value-of select="flag/left/name" /> (<xsl:value-of select="flag/left/count" />/<xsl:value-of select="flag/left/max" />): </b>
                                                    <xsl:for-each select="flag/left/players/element">
                                                        <xsl:call-template name="playerlink">
                                                            <xsl:with-param name="player" select="current()" />
                                                        </xsl:call-template>
                                                        <xsl:if test="position() != count(/data/flag/left/players/element)">, </xsl:if>
                                                    </xsl:for-each>
                                                </p>
                                                <p class="team">
                                                    <b><i class="{flag/right/code}"></i><xsl:value-of select="flag/right/name" /> (<xsl:value-of select="flag/right/count" />/<xsl:value-of select="flag/right/max" />): </b>
                                                    <xsl:for-each select="flag/right/players/element">
                                                        <xsl:call-template name="playerlink">
                                                            <xsl:with-param name="player" select="current()" />
                                                        </xsl:call-template>
                                                        <xsl:if test="position() != count(/data/flag/right/players/element)">, </xsl:if>
                                                    </xsl:for-each>
                                                </p>
                                            </xsl:if>
                                            <xsl:if test="flag/state = 'started'">
                                                <div align="center">
                                                    <div class="button" onclick="groupFightForceJoin({flag/id});"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Вмешаться в бой</div></span>
                                                    </div>
                                                </div>
                                            </xsl:if>

                                            <xsl:if test="flag/state = 'created' and flag/me = 0">
                                                <form style="text-align:center" action="/fight/" method="post" id="flag-form">
                                                    <input type="hidden" name="action" value="join fight" />
                                                    <input type="hidden" name="fight" value="{flag/id}" />
                                                    <button class="button" type="submit">
                                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">
                                                                Буду участвовать в битве
                                                            </div>
                                                        </span>
                                                    </button>
                                                </form>
                                            </xsl:if>

                                            <xsl:if test="count(lastflagfights/element) > 0">
                                                <p style="margin-bottom:0; text-align:center">
                                                    Последние бои за флаг:
                                                    <xsl:for-each select="lastflagfights/element">
														<!-- <i class="{fraction}"></i> -->
                                                        <a href="/fight/{id}/"><i class="icon icon-flag">
															<xsl:attribute name="title"><xsl:value-of select="dt" /></xsl:attribute>
														</i></a>
                                                        <xsl:if test="position() != last()">&#0160;</xsl:if>
                                                    </xsl:for-each>
                                                </p>
                                            </xsl:if>
                                        </div>
                                    </div>
                                    <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                </div>
								
                                <div class="block-bordered">
                                    <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                    <div class="center clear">
                                        <h3>Хаотичный бой</h3>
                                        <div class="alley-flag">
                                            <p>
                                                Во все времена на Руси во время праздников устраивали кулачные бои. Но так как все были пьяные,
                                                то били первого попавшегося под руку. Вот и у нас в хаотичных боях участники делятся на две
                                                команды случайным образом. <span class="dashedlink" onclick="$('#alley-chaoticfight-hint').toggle();">Правила</span>
                                            </p>
                                            <p id="alley-chaoticfight-hint" style="display:none;">
                                                Сражения проходят <b>каждые 15 минут</b> в формате <nobr>10 на 10</nobr> среди участников <b>своего уровня</b>.<br />
                                                Записаться могут 20 бойцов, которые будут случайно поделены на 2 команды,
                                                независимо от того, понаехавшие они или коренные.<br />
                                                Если за 15 минут в бой запишется менее 10 человек, то бой отменяется.
                                            </p>
											<a name="chaoticfight"></a>
                                            <p class="holders">
                                                <xsl:choose>
                                                    <xsl:when test="chaoticfight/id = 0">Запись на cледующую битву начнется в самое ближайшее время.</xsl:when>
                                                    <xsl:when test="chaoticfight/state = 'started'">
                                                        <a href="/fight/{chaoticfight/id}/" class="now">Бой идет в данный момент</a>
                                                    </xsl:when>
                                                    <xsl:otherwise>Запись на битву началась!</xsl:otherwise>
                                                </xsl:choose>
                                            </p>
                                            <xsl:if test="chaoticfight/id > 0">
                                                <p class="team">
                                                    <b><xsl:value-of select="chaoticfight/left/name" /> (<xsl:value-of select="chaoticfight/left/count" />/<xsl:value-of select="chaoticfight/left/max" />): </b>
                                                    <xsl:for-each select="chaoticfight/left/players/element">
                                                        <xsl:call-template name="playerlink">
                                                            <xsl:with-param name="player" select="current()" />
                                                        </xsl:call-template>
                                                        <xsl:if test="position() != count(/data/chaoticfight/left/players/element)">, </xsl:if>
                                                    </xsl:for-each>
                                                </p>
                                            </xsl:if>
                                            <xsl:if test="chaoticfight/state = 'started'">
                                                <div align="center">
                                                    <div class="button" onclick="groupFightForceJoin({chaoticfight/id});"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Вмешаться в бой</div></span>
                                                    </div>
                                                </div>
                                            </xsl:if>
                                            <xsl:if test="chaoticfight/state = 'created' and chaoticfight/me = 0 and allowchaotic = 1">
                                                <form style="text-align:center" action="/fight/" method="post" id="chaoticfight-form">
                                                    <input type="hidden" name="action" value="join fight" />
                                                    <input type="hidden" name="fight" value="{chaoticfight/id}" />
													<input type="hidden" name="price" id="chaoticPrice" value="" />
													<h3>Записаться на бой</h3>
													<xsl:if test="chaoticfight/price/m">
														<button class="button" type="submit" onclick="$('#chaoticPrice').val('money');">
															<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																<div class="c">
																	<span class="tugriki"><xsl:value-of select="chaoticfight/price/m" /><i></i></span>
																</div>
															</span>
														</button>&#160;
													</xsl:if>
													<xsl:if test="chaoticfight/price/zub">
														&#160;<button class="button" type="submit" onclick="$('#chaoticPrice').val('zub');">
															<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																<div class="c">
																	<span class="tooth-white"><xsl:value-of select="chaoticfight/price/zub" /><i></i></span>
																</div>
															</span>
														</button>&#160;
													</xsl:if>
													<xsl:if test="chaoticfight/price/huntbadge">
														&#160;<button class="button" type="submit" onclick="$('#chaoticPrice').val('huntbadge');">
															<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																<div class="c">
																	<span class="badge"><xsl:value-of select="chaoticfight/price/huntbadge" /><i></i></span>
																</div>
															</span>
														</button>&#160;
													</xsl:if>
                                                </form>
                                            </xsl:if>
                                            <xsl:if test="chaoticfight/me = 1">
                                                <script type="javascript">
                                                    groupFightTryRedirect();
                                                </script>
                                            </xsl:if>
                                        </div>
                                    </div>
                                    <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                </div>
								
								<xsl:if test="player/accesslevel > 0">
									<div class="block-bordered">
										<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
										<div class="center clear">
                                            <h3>Тестовый бой</h3>
                                            <div class="alley-flag">
                                                <xsl:choose>
                                                    <xsl:when test="testgroupfight/state = 'created'">
                                                        <xsl:if test="testgroupfight/me = 0">
                                                            <form style="text-align:center" action="/fight/" method="post" id="flag-form">
                                                                <input type="hidden" name="action" value="join_test_fight" />
                                                                <button class="button" type="submit">
                                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                        <div class="c">
                                                                            Вступить в тестовый бой
                                                                        </div>
                                                                    </span>
                                                                </button>
                                                            </form>
                                                        </xsl:if>
                                                        <form style="text-align:center" action="/fight/" method="post" id="flag-form">
                                                            <input type="hidden" name="action" value="start_test_fight" />
                                                            <button class="button" type="submit">
                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">
                                                                        Запустить тестовый бой
                                                                    </div>
                                                                </span>
                                                            </button>
                                                        </form>
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        <form style="text-align:center" action="/fight/" method="post" id="flag-form">
                                                            <input type="hidden" name="action" value="create_test_fight" />
                                                            <button class="button" type="submit">
                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">
                                                                        Создать тестовый бой
                                                                    </div>
                                                                </span>
                                                            </button>
                                                        </form>
                                                    </xsl:otherwise>
                                                </xsl:choose>
                                            </div>
										</div>
										<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
									</div>
								</xsl:if>

                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>

		<!--
        <div class="alert alert-thimble" id="naperstki">
            <xsl:if test="naperstki != 1 and naperstki != 2 and naperstki != 3">
                <xsl:attribute name="style">display:none;</xsl:attribute>
            </xsl:if>
            <div class="padding clear">
                <h2 id="alert-title">Наперстки</h2>
                <div class="data">
                    <div id="alert-text">

                        <div id="naperstki-step1">
                            <xsl:if test="naperstki != 1 and naperstki != 3">
                                <xsl:attribute name="style">display:none;</xsl:attribute>
                            </xsl:if>
							<p>
								<img src="/@/images/pers/man100.png" align="left" style="margin:0;" />
								Вы отправились в патруль и в одной из подворотен наткнулись на уличного наперсточника <b>Моню Шаца</b>.
								Сыграйте с ним и попытайте <span class="ruda"><i></i>счастье</span>, если у вас есть <span class="tugriki"><i></i>наличность</span>.
							</p>
                        </div>

						<div id="naperstki-step2">
                            <xsl:if test="naperstki != 2">
                                <xsl:attribute name="style">display:none;</xsl:attribute>
                            </xsl:if>

							<div align="center">
								<div id="naperstki-step2-cells3">
									<xsl:if test="naperstki != 2 or naperstkidata/c != 3">
										<xsl:attribute name="style">display:none;</xsl:attribute>
									</xsl:if>
									<p>Угадай <i>с одного раза</i>, где скрыта <span class="ruda">1<i></i></span>, и получи ее.</p>
								</div>

								<div id="naperstki-step2-cells9">
									<xsl:if test="naperstki != 2 or naperstkidata/c != 9">
										<xsl:attribute name="style">display:none;</xsl:attribute>
									</xsl:if>
									<p>Под девятью наперстками скрыто <span class="ruda">6<i></i></span>.<br />Выбери 3 наперстка, и получи <span class="ruda">отгаданное<i></i></span>.</p>
								</div>

								<p class="thimbles">
									<xsl:for-each select="naperstkidata/d/element">
										<xsl:choose>
											<xsl:when test="current() = '0'">
												<i id="thimble{position() - 1}" class="icon thimble-closed-active" onclick="alleyNaperstkiGuess({position() - 1});"></i>
											</xsl:when>
											<xsl:when test="current() = '1'"><i id="thimble{position() - 1}" class="icon thimble-closed"></i></xsl:when>
											<xsl:when test="current() = '2'"><i id="thimble{position() - 1}" class="icon thimble-guessed"></i></xsl:when>
											<xsl:when test="current() = '3'"><i id="thimble{position() - 1}" class="icon thimble-empty"></i></xsl:when>
										</xsl:choose>
										<xsl:if test="(position() = 3 or position() = 6) and /data/naperstkidata/c = 9"><br /></xsl:if>
									</xsl:for-each>
								</p>

								<p class="results">
									Осталось попыток: <span id="naperstki-left"><xsl:value-of select="naperstkidata/left" /></span><br />
									Угадано: <span class="ruda" id="naperstki-ruda"><xsl:value-of select="naperstkidata/r" /><i></i></span>
								</p>
							</div>
                        </div>

                        <div id="naperstki-step3">
                            <xsl:if test="naperstki != 1 and naperstki != 3">
                                <xsl:attribute name="style">display:none;</xsl:attribute>
                            </xsl:if>
                            <div align="center">
                                <p>
                                    <button class="button" style="margin:5px" onclick="alleyNaperstkiPlay(3);">
                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                            <div class="c">Три наперстка — <span class="tugriki">500<i></i></span></div>
                                        </span>
                                    </button>
                                    &#0160;
                                    <button class="button" style="margin:5px" onclick="alleyNaperstkiPlay(9);">
                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                            <div class="c">Девять наперстков — <span class="tugriki">1,500<i></i></span></div>
                                        </span>
                                    </button>
                                </p>
                                <p>
                                    <button class="button" onclick="alleyNaperstkiLeave();">
                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                            <div class="c">Патрулировать дальше</div>
                                        </span>
                                    </button>
                                </p>
                            </div>
                        </div>

                        <div class="actions"></div>

                    </div>
                </div>
            </div>
        </div>
		-->

    </xsl:template>

    <xsl:template name="error">
		<xsl:param name="error" />
		<xsl:param name="type" />
		<xsl:param name="params" />
		<xsl:param name="action" />
		<xsl:param name="result" />

        <xsl:choose>
            <!-- errors -->
			<xsl:when test="$result/result = 0 and $result/type = 'alley' and $result/action = 'leave patrol' and $result/error = 'you are not in patrol'"><p class="error" align="center">Вы сейчас не патрулируете.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'alley' and $result/action = 'patrol' and $result/error = 'player is busy'"><p class="error" align="center">Вы сейчас заняты и не можете начать патрулирование.</p></xsl:when>
            <xsl:when test="$result/result = 0 and $result/type = 'alley' and $result/action = 'patrol' and $result/error = 'no money'"><p class="error" align="center">У вас не хватает денег на свисток. А без свистка от Вас толку мало.</p></xsl:when>
			<!-- successes -->
			<xsl:when test="$result/result = 1 and $result/type = 'alley' and $result/action = 'patrol'"><p class="success" align="center">Вы начали патрулирование.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'alley' and $result/action = 'leave patrol'"><p class="success" align="center">Вы бросили патрулирование и пошли своей дорогой.</p></xsl:when>
            <xsl:when test="$result/result = 1 and $result/type = 'fight' and $result/action = 'join fight'"><p class="success" align="center">Ваша заявка на участие в бою принята.</p></xsl:when>
        </xsl:choose>

    </xsl:template>

    <xsl:template name="search-error">
        <xsl:param name="error" />

        <p class="error">
            <xsl:choose>
                <xsl:when test="$error = 'low_hp'">
                    Вы слишком слабы. Либо посидите на лавочке, либо <a href="/home/">сходите домой и подлечитесь</a>.
                </xsl:when>
                <xsl:when test="$error = 'no_money'">
                    Без денег много не навоюешь! Самое время <a href="/shaurburgers/">идти на работу</a>.
                </xsl:when>
                <xsl:when test="$error = 'no_players'">
                    Вы искали, но смогли найти только рваное чучело.
                </xsl:when>
                <xsl:when test="$error = 'not_free'">
                    Вы заняты работой и не можете сейчас искать противников.
                </xsl:when>
                <xsl:when test="$error = 'too_fast'">
                    Вы слишком много деретесь, отдохните немного.
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="$error" />
                </xsl:otherwise>
            </xsl:choose>
        </p>
    </xsl:template>

</xsl:stylesheet>