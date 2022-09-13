<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/clanlink.xsl" />
    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="sovet/menu1.xsl" />
    <xsl:include href="sovet/menu2.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Зал членов Совета
                </h2></div>
                <div id="content" class="council">

                    <xsl:call-template name="menu1">
                        <xsl:with-param name="page" select="'council'" />
                        <xsl:with-param name="council" select="council" />
                    </xsl:call-template>

                    <div class="welcome">
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="text">
                                Задача совета — принимать решения и управлять ходом боевых действий.<br />
                                Члены совета — это бравые генералы и проницательные стратеги.
                                От пламенного обращения Председателя совета к народу зависит, кто захватит столицу.
                            </div>
                        </div>
                    </div>

                    <xsl:call-template name="menu2">
                        <xsl:with-param name="page" select="'council'" />
                        <xsl:with-param name="council" select="council" />
                    </xsl:call-template>

                    <xsl:if test="day = 2">
                        <a name="chairmanvoting"></a>
                        <div class="block-bordered block-bordered-attention">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3 style="color:red;">Выборы председателя совета <xsl:choose>
                                    <xsl:when test="player/fraction = 'resident'"><i class="resident"></i>Коренных</xsl:when>
                                    <xsl:otherwise><i class="arrived"></i>Понаехавших</xsl:otherwise>
                                </xsl:choose></h3>
                                <form class="council-election" method="post" action="/sovet/vote-sovet-glava/">
                                    <p>
                                        Сегодня вторник, а это значит, что пришло время выбрать главу Совета.
                                        Проголосуйте за одного из двадцати выбранных членов Совета, кто подходит на пост главы.
                                        Если окажется, что количество голосов равное, главой будет выбран наикрутейший на момент завершения голосования.
                                    </p>
									<xsl:choose>
										<xsl:when test="voted = 0">
											<ul class="list-users clear">
												<xsl:for-each select="sovet/element">
													<li>
														<input type="radio" name="player" id="glava_{id}" value="{id}">
                                                            <xsl:if test="/data/hour &lt; 1"><xsl:attribute name="disabled" value="disabled" /></xsl:if>
                                                        </input>
														<label for="glava_{id}"><xsl:call-template name="playerlink"><xsl:with-param name="player" select="current()" /></xsl:call-template></label>
													</li>
												</xsl:for-each>
											</ul>
                                            <xsl:choose>
                                                <xsl:when test="/data/hour > 0">
                                                    <div align="center">
                                                        <button class="button" type="submit"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Голосовать</div>
                                                        </span></button>
                                                    </div>
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <p class="holders">Голосование начнется в 1:00.</p>
                                                </xsl:otherwise>
                                            </xsl:choose>
										</xsl:when>
										<xsl:otherwise>
											<p class="holders">Вы уже сделали свой выбор, ждите результатов голосования.</p>
										</xsl:otherwise>
									</xsl:choose>
                                </form>

                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </xsl:if>

                    <!--
                    <a name="stationchoose"></a>
                    <div class="block-bordered block-bordered-attention">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3 style="color:red;">Выборы станции для атаки</h3>
                            <form class="council-stationchoose">
                                <div style="float:left; width:45%;">
                                    <p>
                                        Вчера ваши сторонники преголосовали, какую станцию атаковать.
                                        И <b>сегодня до 20:00</b> совет должен принять окончательное решение
                                        в зависимости от тактики или стоимости атаки конкретной станции.
                                        <span class="dashedlink" onclick="$('#council-members-stationchoose-description').toggle();">Подробнее</span>
                                    </p>
                                    <p id="council-members-stationchoose-description" style="display:none;">
                                        При равенстве голосов будет выбрана станция собравшая больший взнос.
                                        Если ваш и совет противников выбрали одну и ту же станцию, право атаки перейдет к тем,
                                        кто собрал больший взнос на эту станцию.
                                    </p>
                                </div>
                                <div style="float:right; width:45%;">
                                    <p>
                                        Чем ближе станция к центру, тем дороже будет стоимость атаки.
                                        Учтите, что на момент окончания голосования в казне должно быть достаточно денег для атаки.
                                    </p>
                                    <p class="borderdata">
                                        Казна совета: <span class="tugriki">12239<i></i></span>
                                    </p>
                                </div>

                                <table class="list">
                                    <tr>

                                    <th class="num"></th>
                                    <th>Название</th>
                                    <th class="value">Взносов собрано</th>
                                    <th class="value">Стоимость атаки</th>
                                    </tr>
                                    <tr>

                                    <td class="num"><input type="radio" name="" id="station1" /></td>
                                    <td class="name"><label for="station1">Маяковская</label></td>
                                    <td class="value"><span class="tugriki">34342<i></i></span></td>
                                    <td class="value"><span class="tugriki">1,500,000<i></i></span></td>
                                    </tr>
                                    <tr>
                                    <td class="num"><input type="radio" name="" id="station2" /></td>
                                    <td class="name"><label for="station2">Пушкинская/Тверская/Чеховская</label></td>
                                    <td class="value"><span class="tugriki">5734<i></i></span></td>
                                    <td class="value"><span class="tugriki">1,500,000<i></i></span></td>
                                    </tr>
                                    <tr>
                                    <td class="num"><input type="radio" name="" id="station3" /></td>
                                    <td class="name"><label for="station3">Беговая</label></td>
                                    <td class="value"><span class="tugriki">1575<i></i></span></td>
                                    <td class="value"><span class="tugriki">600,000<i></i></span></td>
                                    </tr>
                                </table>

                                <p align="center">
                                    <button class="button" type="submit">
                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                            <div class="c">
                                                Голосовать
                                            </div>
                                        </span>
                                    </button>
                                </p>

                            </form>

                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>
                    -->

                    <table>
                        <tr>
                            <td style="width:50%; padding:0 5px 0 0;">

                                <xsl:if test="lozung != ''">
                                    <div class="block-bordered">
                                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                        <div class="center clear">
                                            <h3>Обращения к членам совета</h3>
                                            <div class="council-speach">
                                                <div class="user-card clear">
                                                    <img src="{lozung/player/avatar}" class="avatar" />
                                                    <xsl:call-template name="playerlink"><xsl:with-param name="player" select="lozung/player" /></xsl:call-template>
                                                    <br />Обращение председателя <xsl:choose>
                                                        <xsl:when test="player/fraction = 'resident'">коренных</xsl:when>
                                                        <xsl:otherwise>понаехавших</xsl:otherwise>
                                                    </xsl:choose> к членам совета
                                                </div>
                                                <p id="council-speach-text">
                                                    <xsl:value-of select="lozung/text" disable-output-escaping="yes" />
                                                </p>

                                                <script type="text/javascript">
                                                    $(document).ready(function(){
                                                        sovetAutoHideLozung("");
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                    </div>
                                </xsl:if>

                                <div class="block-bordered">
                                    <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                    <div class="center clear">
                                        <h3>Рупор</h3>
                                        <form class="council-rupor" method="post" action="/sovet/rupor/">
                                            Напишите сообщение для всех членов Совета
                                            <textarea name="text"></textarea>
                                            <button class="button" type="submit"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Написать всем</div></span></button>
                                        </form>
                                    </div>
                                    <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                </div>

                            </td>
                            <td style="width:50%; padding:0 0 0 5px;">
                                <div class="block-bordered">
                                    <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                    <div class="center clear">
                                        <h3>Усиление стороны</h3>
                                        <div class="council-affects">
                                            <p>Любой из членов сельсовета может активировать усиление для своей стороны.
                                            Лучше всего это делать в четверг и пятницу, во время дуэлей и «стенок» между сторонами. Чем сильнее усиление, тем дороже оно стоит.</p>

                                            <xsl:if test="count(boosts) > 0">
                                                <div class="borderdata">
                                                    <h3>Текущие усиления</h3>
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
                                            </xsl:if>
                                            <xsl:if test="count(votes) > 0">
                                                <div class="borderdata">
                                                    <h3>Проголосуйте за усиление</h3>
                                                    <div align="center">
                                                        <xsl:for-each select="votes/element">
                                                            <span class="object-thumb">
																<div class="padding">
																	<a href="/sovet/boosts/#vote{id}"><img src="/@/images/obj/perks/{image}" tooltip="1" title="{name}||{info}|||{special1name}: {special1before}{special1}{special1after}" /></a>
																	<!-- <div class="time"><xsl:value-of select="timeleft" /></div> -->
																</div>
                                                            </span>
                                                        </xsl:for-each>
                                                        <br clear="all" />
                                                    </div>
                                                </div>
                                            </xsl:if>
                                            <div style="text-align:center;">
                                                <div class="button"><a class="f" href="/sovet/boosts/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Предложить усиления</div>
                                                </a></div>
                                            </div>

                                        </div>
                                    </div>
                                    <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                </div>
								
			                    <div class="block-bordered block-bordered-attention">
			                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
			                        <div class="center clear">
			                            <h3>Покинуть совет</h3>
			                            <div class="council-leave">
			                                <span class="dashedlink" onclick="$('#exit-button').toggle();">Да, я хочу выйти из состава совета сейчас</span>
			                                <div id="exit-button" style="display:none;">
			                                    <form class="council-election" method="post" action="/sovet/exit/">
													<input type="hidden" name="action" value="exit" />
			                                        <button class="button" type="submit"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
			                                            <div class="c"><span class="red">Покинуть совет</span></div>
			                                        </span></button>
			                                    </form>
			                                    <xsl:if test="council = 'founder'">
			                                        <p>После Вашего ухода главой Совета автоматически будет назначен самый сильный из
			                                        оставшихся в Совете игроков.</p>
			                                    </xsl:if>
			                                </div>
			                            </div>
			                        </div>
			                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
			                    </div>

                            </td>
                        </tr>
                    </table>

                </div>
            </div>

        </div>
    </xsl:template>

</xsl:stylesheet>
