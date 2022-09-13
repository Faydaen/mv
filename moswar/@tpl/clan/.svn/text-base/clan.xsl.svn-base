<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
	
    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/clan-error.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    <span class="clan"></span>
                </h2></div>
                <div id="content" class="clan">
                    <xsl:choose>
                        <xsl:when test="player/clan > 0">
                            <div class="welcome">
                                <i class="emblem">
                                    <xsl:attribute name="style">background:url(http://img.moswar.ru/@images/clan/clan_<xsl:value-of select="clan/id" />_logo.png);</xsl:attribute>
                                </i>
                            </div>
                            <div class="block-rounded clan-slots-place">
                                <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>

                                <table>
                                    <tr>
										<td style="width:29%; padding:0; vertical-align:top; text-align:center;">
											<h3>Престиж клана</h3>
											<div class="clan-prestige">
												<table>
													<tr>
														<td style="padding:0;">
															<img src="/@/images/obj/clansign{clan/level}.png" title="{clan/rank}" alt="{clan/rank}" />
														</td>
														<td style="width:100%;">
															<div class="label">
																<span class="num"><xsl:value-of select="clan/points" />/<xsl:value-of select="clan/points_next" /></span>
																Баллы
															</div>
															<div class="exp">
																<div class="bar"><div><div class="percent" style="width:{clan/points_percent}%;"></div></div></div>
															</div>
															<div style="text-align:center;"><b style="color:#003399;"><xsl:value-of select="clan/rank" /> [<xsl:value-of select="clan/level" />]</b></div>
														</td>
													</tr>
												</table>
												<div class="hint"><span class="dashedlink" onclick="$('#clan-prestige-description').toggle('fast');">Подробнее о престиже</span></div>
											</div>
										</td>
                                        <td style="width:71%; padding:0 0px 0 0; vertical-align:top;">
                                            <div class="clan-slots">
                                                <h3>Клановое оснащение</h3>
                                                <xsl:for-each select="inventory/element"><xsl:choose>
                                                        <xsl:when test="name != ''">
                                                            <xsl:choose>
                                                                <xsl:when test="type = 'home_safe'"><a href=""><img src="/@/images/obj/{image}" title="{name}||{info}|||{param}: {value}|{param_period}: {value_period}" tooltip="1" style="background: url(/@/images/ico/gift.png);" /></a></xsl:when>
                                                                <xsl:when test="code = 'clan_warehouse'"><a href="/clan/profile/warehouse/"><img src="/@/images/obj/{image}" title="{name}||{info}|||Вместимость: {itemlevel}" tooltip="1" style="background: url(/@/images/ico/gift.png);" /></a></xsl:when>
                                                                <xsl:when test="code = 'clan_pacifistcert'"><a href="/clan/profile/upgrade/clan_pacifistcert/"><img src="/@/images/obj/{image}" title="{name}||{info}|||Часов ненападения: {itemlevel}" tooltip="1" style="background: url(/@/images/ico/gift.png);" /></a></xsl:when>
                                                                <xsl:when test="code = 'clan_defence'"><a href="/clan/profile/upgrade/clan_defence/"><img src="/@/images/obj/{image}" title="{name}||{info}|||Защита: +{itemlevel}" tooltip="1" style="background: url(/@/images/ico/gift.png);" /></a></xsl:when>
                                                                <xsl:when test="code = 'clan_attack'"><a href="/clan/profile/upgrade/clan_attack/"><img src="/@/images/obj/{image}" title="{name}||{info}|||Атака: +{itemlevel}" tooltip="1" style="background: url(/@/images/ico/gift.png);" /></a></xsl:when>
                                                                <xsl:otherwise><img src="/@/images/obj/{image}" title="{name}||{info}|||{param}: +{value}" tooltip="1" style="background: url(/@/images/ico/gift.png);" /></xsl:otherwise>
                                                            </xsl:choose>
                                                        </xsl:when>
                                                        <xsl:otherwise><img src="/@/images/ico/gift.png" /></xsl:otherwise>
                                                    </xsl:choose></xsl:for-each>
                                                <div class="hint">
                                                    Глава клана может улучшить оснащение в <a href="/shop/section/clan/">торговом центре</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
								<div class="clan-prestige-description clear" style="display:none;" id="clan-prestige-description">
									<h3>Подробнее о престиже</h3>
									<div style="float:right; width:36%;">
										<b>Получение баллов престижа:</b><br />
										Нападение на другой клан: <span class="green">+1 балл</span><br />
										Победа в войне: <span class="green">+2 балла</span><br />
										Капитуляция: <span class="red">-3 балла</span><br />
										Каждые 3 недели: <span class="red">-1 балл</span>
									</div>
									<div style="float:left; width:55%;">
										Престиж — это показатель крутости клана. Чем больше престиж, тем выше <a href="/rating/clans/">клан в рейтинге</a>. 
										С каждым новым званием престижа у клана открывается больше возможностей <a href="/shop/section/clan/">в оснащении</a>.
										Однако если не поддерживать престиж, можно откатиться назад, так как каждые три недели он падает на -1 балл.
									</div>
								</div>
                            </div>
							
							<table class="buttons">
								<tr>
									<td>
										<div class="button button-current">
											<a class="f" href="/clan/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Обзор</div>
											</a>
										</div>
									</td>
									<td>
										<div class="button">
											<a class="f" href="/forum/{clan/forum}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Форум <xsl:if test="forum_new_topics > 0">&#0160; (<xsl:value-of select="forum_new_topics" />)</xsl:if></div>
											</a>
										</div>
									</td>
									<td>
										<div class="button">
											<a class="f" href="/chat/" onclick="setCookie('chat_room', 'clan');" target="_top"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Клан-чат</div>
											</a>
										</div>
									</td>
									<td>
										<div class="button">
											<a class="f" href="/clan/profile/warehouse/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Склад</div>
											</a>
										</div>
									</td>
									<td>
										<div class="button">
											<a class="f" href="/clan/profile/logs/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Логи</div>
											</a>
										</div>
									</td>
									<td>
										<div class="button">
											<a class="f" href="/clan/{clan/id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Страница клана</div>
											</a>
										</div>
									</td>
								</tr>
							</table>

                            <xsl:if test="count(result) > 0">
                                <div class="report">
                                    <xsl:call-template name="error">
                                        <xsl:with-param name="result" select="result" />
                                    </xsl:call-template>
                                </div>
                            </xsl:if>

                            <table>
                                <tr>
                                    <td style="width:50%; padding:0 5px 0 0;">

                                        <div class="block-bordered">
                                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                            <div class="center clear">
                                                <h3>Казна клана</h3>
                                                <div class="clan-kazna">
                                                    <p class="total">
                                                        <b>Сейчас:</b>&#0160;<span class="tugriki"><xsl:value-of select="format-number(clan/money, '###,###,###')" /><i></i></span>
                                                        <span class="ruda"><xsl:value-of select="format-number(clan/ore, '###,###')" /><i></i></span>
                                                        <span class="med"><xsl:value-of select="format-number(clan/honey, '###,###')" /><i></i></span>
                                                        <xsl:if test="clan/rmoney &gt; 0 or clan/rhoney &gt; 0 or clan/rore &gt; 0">
                                                            <br />
                                                            <b style="color:#cd9d60; font-weight:normal;">Заморожено на время войны:</b><br /><span class="tugriki"><xsl:value-of select="format-number(clan/rmoney, '###,###,###')" /><i></i></span>
                                                            <span class="ruda"><xsl:value-of select="format-number(clan/rore, '###,###')" /><i></i></span>
                                                            <span class="med"><xsl:value-of select="format-number(clan/rhoney, '###,###')" /><i></i></span>
                                                        </xsl:if>
                                                    </p>

                                                    <xsl:choose>
                                                        <xsl:when test="allowdep = 1">
                                                            <form action="/clan/profile/" method="post" align="center">
                                                                <!--h3>Вложить в казну</h3 -->
                                                                <input type="hidden" name="action" value="deposit" />
                                                                <table>
                                                                    <tr>
                                                                        <td>
                                                                            <span class="tugriki">Монет<i></i></span>:<br />
                                                                            <input type="text" size="7" name="money" value="0" />
                                                                        </td>
                                                                        <td>
                                                                            <span class="ruda">Руды<i></i></span>:<br />
                                                                            <input type="text" size="7" name="ore" value="0" />
                                                                        </td>
                                                                        <td>
                                                                            <span class="med">Меда<i></i></span>:<br />
                                                                            <input type="text" size="7" name="honey" value="0" />
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <button  class="button" rel="freeze" type="submit">
                                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                        <div class="c">Сделать вклад</div>
                                                                    </span>
                                                                </button>
                                                            </form>
                                                        </xsl:when>
                                                        <xsl:otherwise>
                                                            <p>Вы сможете сделать следующий вклад в казну клана после <xsl:value-of select="depdt" />.</p>
                                                        </xsl:otherwise>
                                                    </xsl:choose>

                                                </div>
                                            </div>
                                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                        </div>

                                        <div class="block-bordered">
                                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                            <div class="center clear">
                                                <h3>Дипломатия</h3>
                                                <div class="clan-diplomacy">
                                                    <p>Кланы могут заключать между собой союзы и вести войны. <span class="dashedlink" onclick="$('#clan-diplomacy-hint').toggle('fast');">Подробнее</span></p>
                                                    <div id="clan-diplomacy-hint" style="display:none;">
                                                        <p>Союзные кланы помогают друг другу на войне. Одновременно можно иметь 2-х союзников и объявить войну одному клану. <a href="/forum/topic/812/">Детали</a></p>
                                                        <xsl:if test="clan/founder = player/id">
                                                            <p>Для заключения союза или объявления войны глава клана должен зайти на страницу выбранного клана и нажать соответствующую кнопку. <a href="/rating/clans/">Список кланов</a></p>
                                                        </xsl:if>
                                                    </div>

                                                    <xsl:choose>
                                                        <xsl:when test="count(clan/diplomacy/element) = 0">
                                                            <p class="empty">В данный момент у клана нет никаких дипломатических отношений</p>
                                                        </xsl:when>
                                                        <xsl:otherwise>
                                                            <ul class="list-users">
                                                                <xsl:for-each select="clan/diplomacy/element">
                                                                    <li>

                                                                        <span class="clan-name">
                                                                            <xsl:choose>
                                                                                <xsl:when test="fraction = 'arrived'"><i class="arrived" title="Понаехавший"></i></xsl:when>
                                                                                <xsl:when test="fraction = 'resident'"><i class="resident" title="Коренной"></i></xsl:when>
                                                                            </xsl:choose>
                                                                            <img src="/@images/clan/clan_{id}_ico.png" class="clan-icon" title="{name}" />
                                                                            <a href="/clan/{id}/"><xsl:value-of select="name" /></a>
                                                                        </span>

                                                                        <xsl:choose>
                                                                            <xsl:when test="type = 'union' and state='accepted'">
                                                                                <span class="friend"> — союз</span>
                                                                            </xsl:when>
                                                                            <xsl:when test="type = 'union' and state='proposal'">
                                                                                <xsl:choose>
                                                                                    <xsl:when test="clan1 = /data/clan/id">
                                                                                        <span class="friend"> — мы предложили союз, ждем ответ</span>
                                                                                    </xsl:when>
                                                                                    <xsl:otherwise>
                                                                                        <span class="friend"> — нам предложили союз</span>
                                                                                    </xsl:otherwise>
                                                                                </xsl:choose>
                                                                            </xsl:when>
                                                                            <xsl:when test="type = 'war' and (state='paused' or state='step1' or state='step2')">
                                                                                <span class="enemy"> — война до <xsl:value-of select="dt2" /></span>
                                                                            </xsl:when>
                                                                            <xsl:when test="type = 'war' and state = 'proposal'">
                                                                                <span class="enemy"> — предложение присоединиться к войне</span>
                                                                            </xsl:when>
                                                                        </xsl:choose>
                                                                    </li>
                                                                </xsl:for-each>
                                                            </ul>
                                                            <xsl:if test="war/atwar = 1">
                                                                <div class="clan-diplomacy-warstat">
                                                                    <h3><a href="/clan/profile/warstats/">Статистика войны</a></h3>
                                                                    <xsl:if test="war/state = 'step1'">
                                                                        <table class="clan-diplomacy-warstat-table">
                                                                            <tr>
                                                                                <td><xsl:if test="war/wewin = 1"><xsl:attribute name="class">bold</xsl:attribute></xsl:if>Убито врагов:<br /><xsl:value-of select="war/enemieskilled" />/<xsl:value-of select="war/enemiestotalkills" /></td>
                                                                                <td><xsl:if test="war/wewin = 0"><xsl:attribute name="class">bold</xsl:attribute></xsl:if>Победы врага:<br /><xsl:value-of select="war/alliaskilled" />/<xsl:value-of select="war/alliastotalkills" /></td>
                                                                            </tr>
                                                                        </table>
                                                                    </xsl:if>
                                                                    <xsl:if test="war/state = 'step2'">
                                                                        <table class="clan-diplomacy-warstat-table">
                                                                            <tr>
                                                                                <td><xsl:if test="war/wewin = 1"><xsl:attribute name="class">bold</xsl:attribute></xsl:if>Наши победы:<br /><xsl:value-of select="war/wins" /></td>
                                                                                <td><xsl:if test="war/wewin = 0"><xsl:attribute name="class">bold</xsl:attribute></xsl:if>Победы врага:<br /><xsl:value-of select="war/fails" /></td>
                                                                            </tr>
                                                                        </table>
                                                                    </xsl:if>
                                                                </div>
                                                            </xsl:if>
                                                        </xsl:otherwise>
                                                    </xsl:choose>

													<xsl:if test="war/atwar = 0">
														<p>На ваш клан можно будет напасть <b><xsl:value-of select="clan/defencedt" /></b>.<br />
														Ваш клан сможет напасть <b><xsl:value-of select="clan/attackdt" /></b>.</p>
													</xsl:if>

                                                    <p style="text-align:center;">
                                                        <button class="button" onclick="document.location.href='/clan/profile/diplomacy/';">
                                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                <div class="c">Управление дипломатией</div>
                                                            </span>
                                                        </button>
                                                    </p>

                                                </div>
                                            </div>
                                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                        </div>

										<div class="block-bordered">
                                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                            <div class="center clear">
                                                <h3>Отдых</h3>
                                                <div class="clan-diplomacy">
													<p>Если ваш клан устал от войн, можно взять недельный отпуск, во время которого вы сами и на вас нельзя будет напасть. Однако, отдых — это признак слабости, и ваш клан потеряет 1 уровень Престижа. К тому же, во время отдыха не работают клановые усиления.</p>
													<xsl:choose>
														<xsl:when test="clan/state = 'rest'">
															<p>Ваш клан отдыхает от войн до <xsl:value-of select="resttime" />.</p>
															<table class="process">
                                                                <tr>
                                                                    <td class="label">Отдых:</td>
                                                                    <td class="progress">
                                                                        <div class="exp">
                                                                            <div class="bar"><div><div class="percent" style="width:{restpercent}%;" id="restbar" reverse="1"></div></div></div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="value" timer="{resttimeleft}" timer2="{resttimetotal}" id="rest"><xsl:value-of select="resttimeleft2" /></td>
                                                                </tr>
                                                            </table>
														</xsl:when>
														<xsl:when test="diplomat = 1">
															<div align="center">
																<div class="button" onclick="clanTakeRest();">
																	<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																		<div class="c">Взять недельный отдых</div>
																	</span>
																</div>
															</div>
														</xsl:when>
													</xsl:choose>
                                                </div>
                                            </div>
                                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                        </div>

                                        <xsl:if test="adviser = 1">
                                            <div class="block-bordered">
                                                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                                <div class="center clear">
                                                    <h3>Описание клана
                                                        <div style="font-size:90%; font-weight:normal;">(только для главы)</div>
                                                    </h3>
                                                    <div class="clan-settings">
                                                        <form method="post" name="infoForm" id="infoForm" enctype="multipart/form-data">
															<xsl:choose>
																<xsl:when test="DEV_SERVER = 1"><xsl:attribute name="action">/clan/profile/</xsl:attribute></xsl:when>
																<xsl:otherwise><xsl:attribute name="action">http://img.moswar.ru/clan/profile/</xsl:attribute></xsl:otherwise>
															</xsl:choose>
                                                            <input type="hidden" name="action" value="change_info" />
                                                            <table class="forms">
                                                                <tr>
                                                                    <td class="label">Девиз:</td>
                                                                    <td class="input"><input type="text" name="slogan" size="30" value="{clan/slogan}" style="width:100%;" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="label">Сайт:</td>
                                                                    <td class="input"><input type="text" name="site" size="30" value="{clan/site}" style="width:100%;" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" align="left"><div style="font-size:90%; font-weight:normal;"><input type="checkbox" name="changename" onchange="$('#nameTr').toggle();" id="change_name" /><label for="change_name">Я хочу изменить название — <span class="tugriki"><xsl:value-of select="format-number(cost_change_name/money, '###,###,###')" /><i></i></span><span class="med"><xsl:value-of select="format-number(cost_change_name/honey, '###,###,###')" /><i></i></span></label></div></td>
                                                                </tr>
																<tr id="nameTr" style="display: none;">
                                                                    <td class="label">Название:</td>
                                                                    <td class="input"><input type="text" name="name" size="30" value="{clan/name}" style="width:100%;" /></td>
                                                                </tr>
																<tr>
																	<td colspan="2" align="left"><div style="font-size:90%; font-weight:normal;"><input type="checkbox" name="changegraphic" onchange="$('#icoTr').toggle();$('#logoTr').toggle();" id="change_icologo" /><label for="change_icologo">Я хочу изменить символику — <span class="tugriki"><xsl:value-of select="format-number(cost_change_graphic/money, '###,###,###')" /><i></i></span><span class="med"><xsl:value-of select="format-number(cost_change_graphic/honey, '###,###,###')" /><i></i></span></label></div></td>
																</tr>
																<tr id="icoTr" style="display: none;">
                                                                    <td class="label">Иконка:</td>
                                                                    <td class="input"><input type="file" id="icofield" name="ico" /></td>
                                                                </tr>
																<tr id="logoTr" style="display: none;">
                                                                    <td class="label">Логотип:</td>
                                                                    <td class="input"><input type="file" id="logofield" name="logo" /></td>
                                                                </tr>
                                                            </table>
                                                            <textarea name="info"><xsl:value-of select="clan/info" /></textarea>
                                                            <div class="button" onclick="$('#infoForm').trigger('submit');">
                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">Редактировать клановую информацию</div>
                                                                </span>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                            </div>
                                        </xsl:if>
                                    </td>
                                    <td style="width:50%; padding:0 0 0 5px;">

                                        <div class="block-bordered">
                                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                            <div class="center clear">
                                                <h3>Рупор</h3>
                                                <form method="post" class="clan-rupor" id="massForm" name="massForm" action="/clan/profile/">
                                                    <input type="hidden" name="action" value="clan_message" />
                                                    Напишите сообщение для всех кланеров
                                                    <textarea name="text"></textarea>
                                                    <div class="button" onclick="$('#massForm').trigger('submit');"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Написать всем</div></span></div>
                                                </form>
                                            </div>
                                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                        </div>

										<div class="block-bordered">
											<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
											<div class="center clear">
												<h3>Прилив бодрости</h3>
												<div class="clan-affects">
													<p>Пламенная поддержка руководства временно придаст сил всем кланерам в борьбе с любым соперником. Главное, не забывайте пополнять казну.</p>
													
													<xsl:if test="banzai = 1">
                                                        <div class="now">
                                                            <h3>Текущее усиление</h3>
                                                            <table class="process">
                                                                <tr>
                                                                    <td class="label">Бодрость:</td>
                                                                    <td class="progress">
                                                                        <div class="exp">
                                                                            <div class="bar"><div><div class="percent" style="width:{banzaipercent}%;" id="banzaibar" reverse="1"></div></div></div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="value" timer="{banzaitimeleft}" timer2="{banzaitimetotal}" id="banzai"><xsl:value-of select="banzaitimeleft2" /></td>
                                                                </tr>
                                                            </table>
                                                            <xsl:for-each select="boosts/element">
                                                                <xsl:choose>
                                                                    <xsl:when test="code = 'ratingaccur'">Рейтинг точности</xsl:when>
                                                                    <xsl:when test="code = 'ratingdamage'">Рейтинг урона</xsl:when>
                                                                    <xsl:when test="code = 'ratingcrit'">Рейтинг критических ударов</xsl:when>
                                                                    <xsl:when test="code = 'ratingdodge'">Рейтинг уворота</xsl:when>
                                                                    <xsl:when test="code = 'ratingresist'">Рейтинг защиты</xsl:when>
                                                                    <xsl:when test="code = 'ratinganticrit'">Рейтинг защиты от крит. ударов</xsl:when>
                                                                </xsl:choose>: +<xsl:value-of select="value" />
                                                                <xsl:if test="position() != last()"><br /></xsl:if>
                                                            </xsl:for-each>
                                                        </div>
                                                    </xsl:if>

                                                    <xsl:if test="money = 1">
                                                        <div align="center">
															<div class="button">
																<a href="/clan/profile/banzai/" class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																	<div class="c">Придать бодрости кланерам</div>
																</a>
															</div>
                                                        </div>
                                                    </xsl:if>
												</div>
											</div>
											<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
										</div>

                                        <div class="block-bordered">
                                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                            <div class="center clear">
                                                <div class="clan-members">
                                                    <h3>Кланеры (<xsl:value-of select="count(clan/players/element)" />)</h3>
                                                    <ul class="list-users">
                                                        <xsl:for-each select="clan/players/element">
                                                            <xsl:if test="accesslevel >= 0">
                                                                <li>
                                                                    <!--xsl:if test="id != /data/clan/founder and /data/myclan/war = 0 and /data/people = 1">
                                                                        <a class="refuse" href="#" onclick="clanDrop({id});">исключить</a>
                                                                    </xsl:if-->
                                                                    <i class="{status}"></i>
                                                                    <!--<span class="user"><i title="{fractionTitle}" class="{fraction}"></i><a href="/player/{id}/"><xsl:value-of select="nickname" /></a><span class="level">[<xsl:value-of select="level" />]</span></span>-->
                                                                    <xsl:call-template name="playerlink">
                                                                        <xsl:with-param name="player" select="current()" />
                                                                    </xsl:call-template>
                                                                </li>
                                                            </xsl:if>
                                                        </xsl:for-each>
                                                    </ul>

                                                    <p align="center">
                                                        <button class="button" onclick="document.location.href='/clan/profile/team/';">
                                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                <div class="c">
                                                                    <xsl:choose>
                                                                        <xsl:when test="/data/people = 1">Редактировать состав</xsl:when>
                                                                        <xsl:otherwise>Подробнее</xsl:otherwise>
                                                                    </xsl:choose>
                                                                </div>
                                                            </span>
                                                        </button>
                                                    </p>

                                                </div>

                                                <div class="clan-recruits">
                                                    <h3>Кандидаты в клан (<xsl:value-of select="count(clan/recruits/element)" />)</h3>
                                                    <ul class="list-users">
                                                        <xsl:for-each select="clan/recruits/element">
                                                            <li>
                                                                <xsl:if test="/data/people = 1">
                                                                    <a class="refuse"  href="#" onclick="clanRefuse({id});">отказ</a>
                                                                    <xsl:if test="/data/war/atwar = 0">
                                                                        <a class="accept"  href="#" onclick="clanAccept({id});">принять</a>
                                                                    </xsl:if>
                                                                </xsl:if>
                                                                <i class="{status}"></i>
                                                                <!--<span class="user"><i title="{fractionTitle}" class="{fraction}"></i><a href="/player/{id}/"><xsl:value-of select="nickname" /></a><span class="level">[<xsl:value-of select="level" />]</span></span>-->
                                                                <xsl:call-template name="playerlink">
                                                                    <xsl:with-param name="player" select="current()" />
                                                                </xsl:call-template>
                                                            </li>
                                                        </xsl:for-each>
                                                        <xsl:if test="count(clan/recruits/element) = 0">
                                                            <li><center><i class="text-align: center;">Нет желающих.</i></center></li>
                                                        </xsl:if>
                                                    </ul>
                                                </div>
                                            </div>

                                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                        </div>

                                        <xsl:if test="clan/id = player/clan">
                                            <div class="block-bordered">
                                                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                                <div class="center clear">
                                                    <h3>Свет погас</h3>
                                                    <div class="clan-leave">
                                                        <xsl:choose>
                                                            <xsl:when test="clan/founder = player/id">
                                                                <xsl:choose>
                                                                    <xsl:when test="war/atwar = 1">
                                                                        <p>Вы не можете расформировать клан во время войны.</p>
                                                                    </xsl:when>
                                                                    <xsl:otherwise>
                                                                        <div class="button" onclick="clanDissolve();">
                                                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                                <div class="c">Распустить клан</div>
                                                                            </span>
                                                                        </div>
                                                                    </xsl:otherwise>
                                                                </xsl:choose>
                                                            </xsl:when>
                                                            <xsl:otherwise>
                                                                <xsl:choose>
                                                                    <xsl:when test="war/atwar = 1">
                                                                        <p>Вы не можете покинуть клан во время войны.</p>
                                                                    </xsl:when>
                                                                    <xsl:otherwise>
                                                                        <div class="button" onclick="clanLeave();">
                                                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                                <div class="c">Покинуть клан</div>
                                                                            </span>
                                                                        </div>
                                                                    </xsl:otherwise>
                                                                </xsl:choose>
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
                        </xsl:when>

                        <xsl:when test="player/clan = 0">
                            <div class="welcome">
                                <i class="emblem">
                                    <a href="/clan/list/"><img style="margin:8px 0 2px 0" src="/@/images/ico/star.png" /><br />Рейтинг кланов</a>
                                </i>
                                <div class="block-rounded">
                                    <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                                    <div class="text">
                                        <p>Ты — одиночка. Никто за тебя не отомстит, никто тебе не поможет.<br />Найди себе семью или построй свой синдикат.</p>
                                        <div style="text-align:center;">
                                            <div class="button">
                                                <a class="f" href="/clan/list/new/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Список новых кланов</div>
                                                </a>
                                            </div>
                                            &#160;
                                            <div class="button" onclick="$('#clan-create-form').toggle('fast');">
                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Основать свой клан</div>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="block-bordered" id="clan-create-form" style="display:none;">
                                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                <div class="center clear">
                                    <form class="clan-registration" action="/clan/register/" method="post" id="registerForm" name="registerForm">
                                    <h3>Заявка на регистрацию клана</h3>
                                    <xsl:choose>
                                        <xsl:when test="message = 'no_money'">
                                            <p class="error">У вас не хватает денег для создания клана.</p>
                                        </xsl:when>
                                    </xsl:choose>
                                    <table class="forms">
                                        <tr>
                                            <td class="label">Придумайте название:</td>
                                            <td class="input"><input class="name" type="text" name="name" />
                                            <xsl:choose>
                                                <xsl:when test="name-error = 'bad_length'">
                                                    <p class="error">Название должно быть от 5 до 25 символов.</p>
                                                </xsl:when>
                                            </xsl:choose>
                                            <div class="hint">Может состоять из латинских символов, цифр, пробела или дефиса.</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label">Значок клана (28&#0215;16px):</td>
                                            <td class="input"><input type="file" name="ico" /></td>
                                        </tr>
                                        <tr>
                                            <td class="label">Герб клана (99&#0215;99px):</td>
                                            <td class="input"><input type="file" name="logo" /></td>
                                        </tr>
                                        <tr>
                                            <td class="label">Сайт:</td>
                                            <td class="input"><input class="name" type="text" name="site" />
                                                <div class="hint">Если есть</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label">Девиз:</td>
                                            <td class="input"><input class="name" type="text" name="slogan" style="width: 100%;" />
                                                <div class="hint">Не длиннее 80 символов</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label">Описание клана:</td>
                                            <td class="input"><textarea name="info"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td class="label"></td>
                                            <td class="input">
                                                <div class="hint"><b>Внимание!</b> Клан будет иметь сторону, как у основателя: <i class="{player/fraction}"></i><b><xsl:value-of select="layer/fractionTitle" /></b></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label"></td>
                                            <td class="input">
                                                <button class="button" onclick="$('#registerForm').trigger('submit');">
                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Подать заявку - <span class="tugriki">5000<i></i></span> + (<span class="ruda">200<i></i></span> или <span class="med">200<i></i></span>)</div>
                                                    </span>
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                    </form>
                                </div>
                                <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                            </div>
                        </xsl:when>
                    </xsl:choose>
                </div>
            </div>
        </div>
	</xsl:template>
</xsl:stylesheet>
