<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="sovet/menu1.xsl" />
    <xsl:include href="sovet/enemyname.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Холл Совета
                </h2></div>
                <div id="content" class="council">

                    <xsl:if test="player/level > 2">
                        <xsl:call-template name="menu1">
                            <xsl:with-param name="page" select="'/'" />
                            <xsl:with-param name="council" select="council" />
                        </xsl:call-template>
                    </xsl:if>

                    <div class="welcome">
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="text">
                                <xsl:choose>
                                    <xsl:when test="player/level > 2">
                                        <p>Недвижимость и земля всегда в цене, особенно если они расположены в самом нерезиновом городе
                                        этой страны. Поэтому главная цель каждого жителя столицы — захват и контроль территорий.</p>
                                        <h3 style="margin:8px 0 0 0;"><span class="dashedlink" onclick="$('#council-welcome-description').toggle();">Подробнее о противостоянии</span></h3>
                                        <div id="council-welcome-description" style="display:none; margin-top:10px;">
                                            <p>Это — <b>глобальное противостояние</b>. Наша сторона сражается за Москву, за светлое и радостное будущее и мир во всем Мире.</p>
                                            <p><b>Как это происходит?</b>&#160;<a href="/sovet/map/">Карта города</a> состоит из 16 районов. Каждую неделю происходит битва за район. Подробнее об <a href="#etap">этапах войны</a>.</p>
                                            <p><b>Какова моя роль?</b> Воевать, голосовать, планировать, воодушевлять других и координировать сторону в противостоянии.</p>
                                            <p><b>Бонусы.</b> За активное участие и победу стороны - игроки получают бонусы. Кроме того, совет стороны имеет мощный тактический прием - активация усилений. Грамотное использование этой характеристики может помочь вам выиграть не только в противостоянии, но и в обычных боях.</p>
                                            <p><b>Что мне делать?</b> Следи за этапами войны, принимай участие во всех этапах, зарабатывай бонусы и получай усиления.</p>
                                        </div>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <p>Совет — это координационный центр в битве за контроль над столицей. Новичкам тут не место.<br />
                                        Приходи, когда достигнешь 3-го уровня.</p>
                                    </xsl:otherwise>
                                </xsl:choose>
                            </div>
                        </div>
                    </div>

                    <xsl:if test="player/level > 2">

                        <div class="block-rounded council-differentiation">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="council-phases">
                                <table class="title">
                                    <tr>
                                        <td width="30%"></td>
                                        <td width="40%"><h3>Этапы захвата района</h3></td>
                                        <td width="30%"><div class="hint">Смотрите <a href="/sovet/map/">карту города</a>.</div></td>
                                    </tr>
                                </table>
                                <a name="etap"></a>

								<table class="council-phases-table">
                                    <tr>
                                        <td width="33%">
                                            <xsl:choose>
                                                <xsl:when test="day = 1"><xsl:attribute name="class">today</xsl:attribute></xsl:when>
                                                <xsl:when test="day > 1"><xsl:attribute name="class">past</xsl:attribute></xsl:when>
                                            </xsl:choose>
                                            <b><xsl:if test="day = 1">[Сегодня] </xsl:if>ПН: день выбора советников</b>
                                            <br /><a href="#election">Предложите своих кандидатов</a> в Совет.
                                        </td>
                                        <td width="33%">
                                            <xsl:choose>
                                                <xsl:when test="day = 2"><xsl:attribute name="class">today</xsl:attribute></xsl:when>
                                                <xsl:when test="day > 2"><xsl:attribute name="class">past</xsl:attribute></xsl:when>
                                            </xsl:choose>
                                            <b><xsl:if test="day = 2">[Сегодня] </xsl:if>ВТ: день выбора района для атаки</b><br />
                                            <a href="/sovet/map/#stationschoose">Выберите район</a>, который Вы бы хотели атаковать. Атакован будет тот район,
                                            который наберет больше всего монет в поддержку.
                                            <xsl:if test="council = 'accepted' or council = 'founder'">
                                                <br />
                                                Если Вы член совета, то пришло время <a href="/sovet/council/#chairmanvoting">выбрать главу совета</a>.
                                            </xsl:if>
                                        </td>
                                        <td width="33%">
                                            <xsl:choose>
                                                <xsl:when test="day = 3"><xsl:attribute name="class">today</xsl:attribute></xsl:when>
                                                <xsl:when test="day > 3"><xsl:attribute name="class">past</xsl:attribute></xsl:when>
                                            </xsl:choose>
                                            <b><xsl:if test="day = 3">[Сегодня] </xsl:if>СР: день подготовки к атаке</b><br />
                                            Тренируйтесь, запасайтесь боеприпасами, готовьте себя морально к ожесточенной битве.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="33%">
                                            <xsl:choose>
                                                <xsl:when test="day = 4"><xsl:attribute name="class">today</xsl:attribute></xsl:when>
                                                <xsl:when test="day > 4"><xsl:attribute name="class">past</xsl:attribute></xsl:when>
                                            </xsl:choose>
                                            <b><xsl:if test="day = 4">[Сегодня] </xsl:if>ЧТ: день дуэлей</b><br />
                                            Отправляйтесь в <a href="/alley/">закоулки</a> и одержите как можно больше побед в дуэлях с противником.
                                        </td>
                                        <td width="33%">
                                            <xsl:choose>
                                                <xsl:when test="day = 5"><xsl:attribute name="class">today</xsl:attribute></xsl:when>
                                                <xsl:when test="day > 5"><xsl:attribute name="class">past</xsl:attribute></xsl:when>
                                            </xsl:choose>
                                            <b><xsl:if test="day = 5">[Сегодня] </xsl:if>ПТ: день «стенок»</b><br />
                                            Бейте врага в <a href="/alley/">групповых драках</a>. Сегодняшние победы важнее вчерашних дуэлей.
                                        </td>
                                        <td width="33%">
                                            <xsl:choose>
                                                <xsl:when test="day = 6 or day = 7"><xsl:attribute name="class">today</xsl:attribute></xsl:when>
                                            </xsl:choose>
                                            <b><xsl:if test="day = 6 or day = 7">[Сегодня] </xsl:if>Выходные</b><br />
                                            Наслаждайтесь победой и полученными бонусами или же готовьтесь отомстить на следующей неделе.
                                        </td>
                                    </tr>
                                </table>

                                <div class="activity">
                                    <table class="collectbar">
                                        <tr>
                                            <td>
                                                <div class="objects">
													<xsl:if test="show_progressbar = 0 and count(weekly_reward/element) = 0">
														<xsl:attribute name="style">width:83%</xsl:attribute>
													</xsl:if>
                                                    <span class="object bonus1"><img src="/@/images/obj/lamp.png"  tooltip="1" title="Бонус за 1 балл||Голосование за совет дает +1 балл|||Бонус: 5 опыта"/></span>
                                                    <span class="object bonus2"><img src="/@/images/obj/ruda.png"  tooltip="1" title="Бонус за 2 балла||Голосование за район дает +1 балл|||Бонус: 3 руды"/></span>
                                                    <span class="object bonus3"><img src="/@/images/obj/drugs40.png"  tooltip="1" title="Бонус за 3 балла||Добровольный взнос в казну совета дает +1 балл|||Бонус: Коробка конфет"/></span>
                                                    <span class="object bonus4"><img src="/@/images/obj/anabolics.png" tooltip="1" title="Бонус за 4 балла||Проведение 10 одиночных боев с врагом в четверг дает +1 балл|||Бонус: 100 анаболиков"/></span>
                                                    <span class="object bonus5"><img src="/@/images/obj/drugs89.png"  tooltip="1" title="Бонус за 5 баллов||Получение бонуса за первую победу в групповых боях с врагом в пятницу дает +1 балл|||Бонус: Вкусный пельмень. +1 к случайной характеристике персонажа"/></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <xsl:if test="show_progressbar = 1 or count(weekly_reward/element) > 0">
											<tr>
												<td class="progress">
													<xsl:if test="show_progressbar = 1">
														<div class="textbar">
															<div class="percent" id="" style="width:{points1percent}%;"></div>
															<div class="num">Твоя гражданская активность: <b><xsl:value-of select="points1" /></b> из <b>5</b></div>
														</div>
													</xsl:if>
												</td>
												<td class="actions">
													<script>
														var weekly_reward = <xsl:value-of select="weekly_reward" disable-output-escaping="yes" />;
													</script>
													<button class="button" type="button">
														<xsl:attribute name="onclick">
															 showAlertSelectItem('Возьми своё', 'Вы очень старались и теперь, вам положена награда', 'Готово', weekly_reward, 'reward', '/sovet/', {"action": "get_weekly_reward"});
														</xsl:attribute>
														<xsl:if test="/data/day &lt; 6 or (/data/day = 6 and /data/hour &lt; 1) or bonus_prev_week = 1">
															<xsl:attribute name="class">button disabled</xsl:attribute>
															<xsl:attribute name="disabled">disabled</xsl:attribute>
														</xsl:if>
														<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">
																Получить награду
															</div>
														</span>
													</button>
													<xsl:if test="bonus_prev_week = 1">
														<br />
														<button class="button" type="button" style="margin-top:5px;">
															<xsl:attribute name="onclick">
																 showAlertSelectItem('Возьми своё', 'Вы очень старались и теперь, вам положена награда', 'Готово', weekly_reward, 'reward', '/sovet/', {"action": "get_weekly_reward"});
															</xsl:attribute>
															<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																<div class="c">
																	Награда за прошлую неделю
																</div>
															</span>
														</button>
													</xsl:if>
												</td>
											</tr>
										</xsl:if>
                                        <tr>
                                            <td>
                                                <div class="hint" style="text-align:center;">
                                                    Принимай активное участие в захвате столицы и забирай награду в конце недели
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <xsl:if test="day = 1 or (day = 2 and sovet_members_selected = 0)">
                            <a name="election"></a>
                            <div class="block-bordered block-bordered-attention">
                                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                <div class="center clear">
                                    <div style="float:left; width:47%;">
                                        <h3 style="color:red;">Сегодня выборы в совет</h3>
                                        <form class="council-election" action="/sovet/vote-sovet/" method="post">
                                            <input type="hidden" name="player" value="{player/id}" />
                                            <p>Выборы проходят раз в неделю в понедельник <nobr><b>c 0:30 до 24:00</b></nobr>. В Совет проходят по 20 кандидатов
                                            с каждой стороны, собравшие наибольший фонд поддержки.</p>

                                            <xsl:choose>
                                                <xsl:when test="day = 2 and sovet_members_selected = 0">
                                                    <p class="holders">Избирательная комиссия ведет подсчет голосов и готовится к
                                                        объявлению членов Совета нового созыва.</p>
                                                </xsl:when>
												<xsl:when test="sovet/is_available = 0">
                                                    <p class="holders">Избирательная комиссия готовится к приему голосов за кандидатов.</p>
                                                </xsl:when>
                                                <xsl:when test="player/level > 4">
                                                    <table class="forms">
                                                        <tr>
                                                            <td class="label">Имя кандидата</td>
                                                            <td class="input">
                                                                <input type="text" maxlength="20" name="nickname" id="sovet-vote-nickname" />
                                                                <xsl:if test="player/level > 8">
                                                                    <div class="hint"><span class="dashedlink" onclick="$('#sovet-vote-nickname').val('{player/nickname}');">Вписать себя</span></div>
                                                                </xsl:if>
                                                                <div class="hint">баллотироваться в Совет можно только с 9-го уровня</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">Поддержка кандидата</td>
                                                            <td class="input">
                                                                <span class="tugriki"><input type="text" size="6" maxlength="9" name="money" /><i></i></span>
                                                                <div class="hint">минимум 100 монет (50% фонда поддержки, собранного кандидатами, пойдет в казну Совета)</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label"></td>
                                                            <td class="input">
                                                                <button class="button" type="submit">
                                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                        <div class="c">
                                                                            Голосовать
                                                                        </div>
                                                                    </span>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <p class="holders">Участвовать в голосовании можно с 5-го уровня</p>
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </form>
                                    </div>
                                    <div style="float:right; width:49%;">
                                        <h3>Лидеры голосования</h3>
                                        <div class="council-election">
                                            <table class="list">
                                                <tr>
                                                    <th class="num">№</th>
                                                    <th>Имя</th>
                                                    <th class="value">Фонд</th>
                                                </tr>
                                                <xsl:choose>
                                                    <xsl:when test="sovetvotes/leaders = ''">
                                                        <tr>
                                                            <td colspan="3" style="text-align:center;">Кандидатов нет. Стань первым!</td>
                                                        </tr>
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        <xsl:value-of select="sovetvotes/leaders" disable-output-escaping="yes" />
                                                    </xsl:otherwise>
                                                </xsl:choose>
                                                <xsl:if test="sovetvotes/me = 1 and player/sovetvotes > 0">
                                                    <tr>
                                                        <td class="num"></td>
                                                        <td><xsl:call-template name="playerlink"><xsl:with-param name="player" select="player" /></xsl:call-template></td>
                                                        <td class="value"><span class="tugriki"><xsl:value-of select="format-number(player/sovetvotes, '###,###,###')" /><i></i></span></td>
                                                    </tr>
                                                </xsl:if>
                                            </table>

                                            <p class="hint">Список лидирующих кандидатов обновляется раз в 15 минут.</p>

                                            <p class="borderdata">
                                                Всего кандидатов: <xsl:value-of select="sovetvotes/total" /><br />
                                                Общий фонд поддержки: <span class="tugriki"><xsl:value-of select="format-number(sovetvotes/money, '###,###,###')" /><i></i></span>
                                            </p>

                                        </div>
                                    </div>
                                </div>
                                <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                            </div>
                        </xsl:if>

                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>Обращения председателей советов</h3>
                                <div style="float:left; width:47%;">
                                    <div class="council-speach">
                                        <xsl:if test="lozung != ''">
                                            <div class="user-card clear" >
                                                <img src="{lozung/our/player/avatar}" class="avatar" />
                                                <xsl:call-template name="playerlink"><xsl:with-param name="player" select="lozung/our/player" /></xsl:call-template>
                                                <br />
                                                Обращение главы Совета <nobr><xsl:choose>
                                                    <xsl:when test="lozung/our/player/fraction = 'resident'"><b>Коренных</b></xsl:when>
                                                    <xsl:otherwise><b>Понаехавших</b></xsl:otherwise>
                                                </xsl:choose></nobr> к&#0160;своим сторонникам
                                                <!--div class="hint">18.06.2010 15:45</div-->
                                            </div>

                                            <p id="council-speach-text1">
                                                <xsl:value-of select="lozung/our/text" disable-output-escaping="yes" />
                                            </p>
                                        </xsl:if>

                                        <div align="center"><b class="dashedlink" onclick="$('#sostav-our').toggle();">Состав совета <xsl:choose>
                                                    <xsl:when test="sostav/our/element[1]/fraction = 'resident'">Коренных</xsl:when>
                                                    <xsl:otherwise>Понаехавших</xsl:otherwise>
                                                </xsl:choose></b></div>
                                        <div id="sostav-our" style="display:none;">
                                            <ul class="list-users">
                                                <xsl:for-each select="sostav/our/element">
                                                    <xsl:if test="current()/status != 'founder'">
                                                        <li>
                                                            <xsl:call-template name="playerlink"><xsl:with-param name="player" select="current()" /></xsl:call-template>
                                                        </li>
                                                    </xsl:if>
                                                </xsl:for-each>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div style="float:right; width:49%;">
                                    <div class="council-speach">
                                        <xsl:if test="lozung != ''">
                                            <div class="user-card clear" >
                                                <img src="{lozung/enemy/player/avatar}" class="avatar" />
                                                <xsl:call-template name="playerlink"><xsl:with-param name="player" select="lozung/enemy/player" /></xsl:call-template><br />
                                                Обращение главы Совета <nobr><xsl:choose>
                                                    <xsl:when test="lozung/enemy/player/fraction = 'resident'"><b>Коренных</b></xsl:when>
                                                    <xsl:otherwise><b>Понаехавших</b></xsl:otherwise>
                                                </xsl:choose></nobr> к&#0160;своим противникам
                                                <!--div class="hint">18.06.2010 15:45</div-->
                                            </div>
                                            <p id="council-speach-text2">
                                                <xsl:value-of select="lozung/enemy/text" disable-output-escaping="yes" />
                                            </p>
                                        </xsl:if>

                                        <div align="center"><b class="dashedlink" onclick="$('#sostav-enemy').toggle();">Состав совета <xsl:choose>
                                                    <xsl:when test="sostav/enemy/element[1]/fraction = 'resident'">Коренных</xsl:when>
                                                    <xsl:otherwise>Понаехавших</xsl:otherwise>
                                                </xsl:choose></b></div>
                                        <div id="sostav-enemy" style="display:none;">
                                            <ul class="list-users">
                                                <xsl:for-each select="sostav/enemy/element">
                                                    <xsl:if test="current()/status != 'founder'">
                                                        <li>
                                                        <xsl:call-template name="playerlink"><xsl:with-param name="player" select="current()" /></xsl:call-template>
                                                        </li>
                                                    </xsl:if>
                                                </xsl:for-each>
                                            </ul>
                                        </div>

                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                sovetAutoHideLozung(1);
                                                sovetAutoHideLozung(2);
                                            })
                                        </script>

                                    </div>
                                </div>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>

                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <div style="float:left; width:47%;">
                                    <h3>Казна Совета</h3>
                                    <form class="council-kazna" method="post" action="/sovet/give-money/">
                                        <input type="hidden" name="player" value="{player/id}" />
                                        <p>
                                            Деньги нужны всем. Совету они нужны для покупки бонусов своей стороне.
                                            <span class="dashedlink" onclick="$('#council-kazna-hint').toggle('fast')">Подробнее</span>
                                        </p>
                                        <p id="council-kazna-hint" style="display:none;">Казна совета складывается из фонда поддержки всех кандидатов на выборах в совет,
                                        взносов при выборе района для атаки и добровольных пожертвований горожан.</p>


                                        <p class="borderdata">
                                            Сейчас в казне: <span class="tugriki"><xsl:value-of select="format-number(kazna/total, '###,###,###')" /><i></i></span>
                                        </p>

                                        <xsl:choose>
                                            <xsl:when test="kazna/allowdep = 1">
                                                <table class="forms">
                                                    <tr>
                                                        <td class="label">Добровольный взнос</td>
                                                        <td class="input">
                                                            <span class="tugriki"><input type="text" name="money" size="8" maxlength="9" /><i></i></span>
                                                            <div class="hint">минимум 100 монет</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="label"></td>
                                                        <td class="input">
                                                            <button class="button" type="submit">
                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">
                                                                        Внести
                                                                    </div>
                                                                </span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </xsl:when>
                                            <xsl:otherwise>
                                                <p class="holders">Вы сможете сделать следующий вклад в казну Совета
                                                после <xsl:value-of select="kazna/depdt" />.</p>
                                            </xsl:otherwise>
                                        </xsl:choose>

                                    </form>
                                </div>
                                <div style="float:right; width:49%;">
                                    <h3>Крепкая опора</h3>
                                    <div class="council-kazna">
                                        <p>Уже давно не секрет, войну в Японии выиграла техника и поставщики нефти и ресурсов.
                                        Ниже представлены люди, которые внесли большой вклад для победы и укрепления сил своей стороны.</p>
                                        <table class="list">
                                            <tr>
                                                <th class="num">№</th>
                                                <th>Имя</th>
                                                <th class="value">Внесено</th>
                                            </tr>
                                            <xsl:choose>
                                                <xsl:when test="kazna/sponsors = ''">
                                                    <tr>
                                                        <td colspan="3" style="text-align:center;">Меценатов нет. Стань первым!</td>
                                                    </tr>
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <xsl:value-of select="kazna/sponsors" disable-output-escaping="yes" />
                                                </xsl:otherwise>
                                            </xsl:choose>
                                            <xsl:if test="kazna/me = 1">
                                                <tr>
                                                    <td class="num"></td>
                                                    <td><xsl:call-template name="playerlink"><xsl:with-param name="player" select="player" /></xsl:call-template></td>
                                                    <td class="value"><span class="tugriki"><xsl:value-of select="format-number(player/sovetmoney, '###,###,###')" /><i></i></span></td>
                                                </tr>
                                            </xsl:if>
                                        </table>

                                        <p class="hint">Список меценатов обновляется раз в 15 минут.</p>

                                    </div>
                                </div>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>

                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>Усиления сторон</h3>
                                <div class="council-affects">
                                    <p>Члены совета могут покупать специальные усиления, которые влияют на всех игроков нашей стороны. Усиления стоят достаточно дорого,
                                    поэтому должны использоваться с умом.</p>
                                    <xsl:choose>
                                        <xsl:when test="count(boosts) > 0">
                                            <div class="borderdata">
                                                <h3>Активные усиления</h3>
                                                <div align="center">
                                                    <xsl:for-each select="boosts/element">
                                                        <span class="object-thumb">
                                                            <div class="padding">
                                                                <img src="/@/images/obj/perks/{image}" tooltip="1" title="{name}||{info}|||{special1name}: {special1before}{special1}{special1after}" />
                                                                <div class="time" timer="{timeleft2}"><xsl:value-of select="timeleft" /></div>
                                                            </div>
                                                        </span>
                                                    </xsl:for-each>
                                                    <br clear="all" />
                                                </div>
                                            </div>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <p align="center"><em>В данный момент нет активных усилений.</em></p>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </div>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>

                    </xsl:if>

                </div>
            </div>

        </div>
    </xsl:template>

</xsl:stylesheet>
