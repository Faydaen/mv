<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>Персональный тренер</h2></div>
                <div id="content" class="trainer-personal">

                    <div class="welcome">
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="text">
                                <xsl:choose>
                                    <xsl:when test="player/level > 4">
                                        <p>Личный тренер или фитнесс-инструкторша помогут стать сильнее сверстников<br />и раскроют секреты мастеров спорта.</p>

                                        <form action="/trainer/activate-vip/" method="post">
                                            <input type="hidden" name="player" value="{player/id}" />
                                            <div class="prolong">
												<xsl:choose>
	                                                <xsl:when test="vip/active = 1">
	                                                    <p align="center">Тренер нанят до: <span class="dashedlink" onclick="$('#trainer-personal-prolong').toggle('fast');"><xsl:value-of select="vip/dt" /></span></p>
		                                                <p align="center" style="display:none;" id="trainer-personal-prolong">
		                                                    <button class="button" type="submit">
		                                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
		                                                            <div class="c">Нанять ещё на 14 дней — <span class="ruda">14<i></i></span> (<span class="med">14<i></i></span>)</div>
		                                                        </span>
		                                                    </button>
		                                                </p>
	                                                </xsl:when>
													<xsl:otherwise>
		                                                <p align="center">
		                                                    <button class="button" type="submit">
		                                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
		                                                            <div class="c">Нанять на 14 дней — <span class="ruda">14<i></i></span> (<span class="med">14<i></i></span>)</div>
		                                                        </span>
		                                                    </button>
		                                                </p>
													</xsl:otherwise>
												</xsl:choose>
                                            </div>
                                        </form>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        Персональные инструкторы по фитнесу работают только с теми, кто доказал свою тягу
                                        к достижениям, прокачавшись до 5-го уровня.
                                    </xsl:otherwise>
                                </xsl:choose>
                            </div>
                        </div>
						<div class="goback">
						    <span class="arrow">&#9668;</span>
							<a href="/trainer/">Выйти из VIP-зала</a>
						</div>
                    </div>

                        <!--div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>Закрыто до полудня</h3>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div-->

                    <xsl:if test="vip/active = 1 and player/level > 4">
                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>Анаболики</h3>
                                <form class="trainer-personal-anabolics clear" action="/trainer/buy-anabolics/" method="post">
                                    <input type="hidden" name="player" value="{player/id}" />
                                    <div style="float:left; width:45%;">
                                    <p><img src="/@/images/obj/anabolics.png" align="left" />Тренажеры, штанги и шейпинги – это все для провинциалов. Настоящие столичники выбирают анаболики, стероиды и пластические операции. Это и есть настоящий личностный рост, основанный на научном интеллекте, а не тупом тягании металла.</p>
                                    </div>
                                    <div style="float:right; width:50%;">
                                    <p>
                                    После медицинского обследования, лаборатория фитнесс-центра изготовит подходящие для вас <span class="anabolic"><i></i>анаболики</span>, используя биологически-активные <span class="petric"><i></i>нано-петрики</span>, которые можно получить <a href="/factory/">на заводе</a>.
                                    </p>
                                    <p class="total">
                                        Сейчас у вас: <span class="petric"><xsl:value-of select="player/petriks" /><i></i></span> и 
										<span class="anabolic"><span id="trainer-anabolics-total"><xsl:value-of select="format-number(player/anabolics, '###,###')" /></span><i></i></span>
                                    </p>

                                        <div align="center">
                                            Кол-во: <span class="anabolic"><input id="trainer-personal-anabolics-number" name="count" type="text" size="3" maxlength="4" value="1" /> × 10 = <span id="count-span">10</span><i></i></span>
                                            <button class="button" type="submit">
                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">
                                                        Изготовить – <span class="petric"><span id="trainer-personal-anabolics-petric">1</span><i></i></span> (<span class="med"><span id="trainer-personal-anabolics-med">1</span><i></i></span>)
                                                    </div>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>

                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>План тренировок</h3>

                                <xsl:if test="leveldown = 1">
                                    <p><b><center>Вы на столько круты, что тренера не успевают за Вами прокачиваться. Пока на Вашем уровне не
                                    наберется как минимум 150 игроков, вы можете работать только с тренерами предыдущего уровня.</center></b></p>
                                </xsl:if>

                                <form id="calculator" class="trainer-personal-calculator" action="/trainer/start-vip-training/" method="post">
                                    <input type="hidden" name="player" value="{player/id}" />
                                    <p>Персональный тренер составит для вас персональный план тренировок и правильную диету.
                                        Работая по этому плану, вы сможете добиться превосходных результатов. Укажите, что вы хотите нарастить:</p>
                                    <table class="forms">
                                        <tr>
                                            <th></th>
                                            <th>Ваши статы</th>
                                            <th>Затраты тренировок</th>
                                            <th>Норма на уровне</th>
                                            <th>Ваше преимущество</th>
                                        </tr>
                                        <tr rel="health">
                                            <td class="label">Здоровье:</td>
                                            <td class="my"><span class="number">0</span> + <b><i class="minus-icon"></i><input type="text" value="0" size="1" maxlength="2" name="health" /><i class="plus-icon"></i></b></td>
                                            <td class="cost"><span class="anabolic"><span class="number">0</span><i></i></span></td>
                                            <td class="average"><span class="number"></span></td>
                                            <td class="advantage"><span class="stars"><span class="percent"></span></span></td>
                                        </tr>
                                        <tr rel="strength">
                                            <td class="label">Сила:</td>
                                            <td class="my"><span class="number">0</span> + <b><i class="minus-icon"></i><input type="text" value="0" size="1" maxlength="2" name="strength" /><i class="plus-icon"></i></b></td>
                                            <td class="cost"><span class="anabolic"><span class="number">0</span><i></i></span></td>
                                            <td class="average"><span class="number"></span></td>
                                            <td class="advantage"><span class="stars"><span class="percent"></span></span></td>
                                        </tr>
                                        <tr rel="dexterity">
                                            <td class="label">Ловкость:</td>
                                            <td class="my"><span class="number">0</span> + <b><i class="minus-icon"></i><input type="text" value="0" size="1" maxlength="2" name="dexterity" /><i class="plus-icon"></i></b></td>
                                            <td class="cost"><span class="anabolic"><span class="number">0</span><i></i></span></td>
                                            <td class="average"><span class="number"></span></td>
                                            <td class="advantage"><span class="stars"><span class="percent"></span></span></td>
                                        </tr>
                                        <tr rel="resistance">
                                            <td class="label">Выносливость:</td>
                                            <td class="my"><span class="number">0</span> + <b><i class="minus-icon"></i><input type="text" value="0" size="1" maxlength="2" name="resistance" /><i class="plus-icon"></i></b></td>
                                            <td class="cost"><span class="anabolic"><span class="number">0</span><i></i></span></td>
                                            <td class="average"><span class="number"></span></td>
                                            <td class="advantage"><span class="stars"><span class="percent"></span></span></td>
                                        </tr>
                                        <tr rel="intuition">
                                            <td class="label">Хитрость:</td>
                                            <td class="my"><span class="number">0</span> + <b><i class="minus-icon"></i><input type="text" value="0" size="1" maxlength="2" name="intuition" /><i class="plus-icon"></i></b></td>
                                            <td class="cost"><span class="anabolic"><span class="number">0</span><i></i></span></td>
                                            <td class="average"><span class="number"></span></td>
                                            <td class="advantage"><span class="stars"><span class="percent"></span></span></td>
                                        </tr>
                                        <tr rel="attention">
                                            <td class="label">Внимательность:</td>
                                            <td class="my"><span class="number">0</span> + <b><i class="minus-icon"></i><input type="text" value="0" size="1" maxlength="2" name="attention" /><i class="plus-icon"></i></b></td>
                                            <td class="cost"><span class="anabolic"><span class="number">0</span><i></i></span></td>
                                            <td class="average"><span class="number"></span></td>
                                            <td class="advantage"><span class="stars"><span class="percent"></span></span></td>
                                        </tr>
                                        <tr rel="charism">
                                            <td class="label">Харизма:</td>
                                            <td class="my"><span class="number">0</span> + <b><i class="minus-icon"></i><input type="text" value="0" size="1" maxlength="2" name="charism" /><i class="plus-icon"></i></b></td>
                                            <td class="cost"><span class="anabolic"><span class="number">0</span><i></i></span></td>
                                            <td class="average"><span class="number"></span></td>
                                            <td class="advantage"><span class="stars"><span class="percent"></span></span></td>
                                        </tr>
                                        <tr rel="total" class="total">
                                            <td class="label">Итого:</td>
											<td class="my" colspan="4">
												<b>+<span class="number">0</span> статов</b><br />
												<div class="hint">После этой тренировки (и перед следующей) должно будет пройти не менее: <span class="time">0</span> минут</div>
											</td>
                                        </tr>
                                    </table>

                                    <xsl:choose>
                                        <xsl:when test="trainingprocess = 1">
                                            <div id="trainer_vip_1">
                                                <table class="process">
                                                    <tr>
                                                        <td class="label">Отдых после тренировок:</td>
                                                        <td class="progress">
                                                            <div class="exp">
                                                                <div class="bar"><div><div class="percent" style="width:{trainingprocesspercent}%;" id="trainingprocessbar"></div></div></div>
                                                            </div>
                                                        </td>
                                                        <td class="value" timer="{trainingprocesstimeleft}" timer2="{trainingprocesstimetotal}" id="trainingprocess"><xsl:value-of select="trainingprocesstimeleft2" /></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div id="trainer_vip_2" style="display:none;">
                                                <p class="holders">
                                                    Тренировка успешно завершена.
                                                </p>
                                            </div>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <div align="center">
												<div id="trainer-anabolics-deficit" style="display:none;">
													<p class="error">Для такой интенсивной тренировки у вас недостаточно анаболиков.</p>
													<p style="font-weight:bold;">
														<input type="checkbox" name="autodeficit" id="trainer-anabolics-deficit-checkbox" />
														<label for="trainer-anabolics-deficit-checkbox">Автоматически произвести недостающие<span class="anabolic"><i></i>анаболики</span><br />
														из <span class="petric"><i></i>нано-петриков</span> (<span class="med"><i></i>мёда</span>)</label>
													</p>
												</div>
                                                <div id="trainer-anabolics-deficit2" style="display:none;">
													<p class="error">У вас недостаточно анаболиков для такого повышения характеристик. А имеющихся у вас
                                                    <span class="med"><i></i>мёда</span> и <span class="petric"><i></i>нано-петриков</span> не хватает,
                                                    чтобы купить недостающее количество.</p>
												</div>
                                                <button class="button" type="submit" onclick="$('#bigbattle-hint').toggle();">
                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">
                                                            Начать тренировки — <span class="anabolic"><span id="stats_upgrade_cost">20</span><i></i></span>
                                                        </div>
                                                    </span>
                                                </button>
                                            </div>
                                            <p>Во время тренировок вы можете продолжать свою обычную деятельность, ведь залог успеха — это правильные витамины, а не изнурительные физические нагрузки.</p>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </form>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                        <script type="text/javascript">
                            var stats_my = [<xsl:value-of select="mystats" />]; /* мои статы */
                            var stats_average = [<xsl:value-of select="avgstats" />]; /* средние статы на уровне */
                            var myAnabolics = <xsl:value-of select="player/anabolics" />;
                            var myAnabolics2 = <xsl:value-of select="anabolics2" />;

                            area = "trainer_vip";

                            $("document").ready(function()
                            {
                                trainerAnabolicsPrepareInit();
                                trainerCalculatorInit();
                            });
                        </script>
                    </xsl:if>
                </div>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>