<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
            <div class="heading clear">
                <h2>
                <span class="factory"></span>
                </h2>
            </div>
            <div id="content" class="factory">
                <div class="welcome">
                    <div class="block-rounded">
                        <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                        <div class="text">
                            <xsl:choose>
                                <xsl:when test="player/level > 4 or player/factory = 1">
									После расплаты с долгами «Завод Уникальных Модификаций» потихоньку начал налаживать производство и быстро нашел своих клиентов. Ведь в современном мире тебе не обойтись без нано-технологий, мастерских и химических лабораторий. Это и есть ЗУМ-ЗУМ.
                                </xsl:when>
                                <xsl:otherwise>
                                    <center>Вы не можете пройти на завод. Приходите на 5-ом уровне.</center>
                                </xsl:otherwise>
                            </xsl:choose>
                        </div>
                    </div>
                </div>
                <xsl:if test="player/level >= 5">
                    <table>
                        <tr>
                            <td style="width:50%; padding:0 5px 0 0;">
                                

                                <xsl:if test="player/level > 4">
                                    <div class="block-bordered">
                                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                        <div class="center clear">
                                            <h3>Нано-цех</h3>
                                            <form class="factory-nanoptric" method="post" action="/factory/start-petriks/">
                                                <input type="hidden" name="player" value="{player/id}" />
                                                <p>
                                                    Однажды, великий ученый П. искал формулу беспроигрышной игры в казино, но в результате исследований он получил активные молекулы <span class="petric">нано-петрики<i></i></span>.
                                                    <span class="dashedlink" onclick="$('#factory-nanoptric-description').toggle();">Подробнее</span>
                                                </p>
                                                <p id="factory-nanoptric-description" style="display:none;">
                                                    Сейчас эти молекулы применяются во множестве областей.<br />
                                                    Высокотехничное заводское оборудование позволяет получать нано-петрики в процессе обогащения руды.
                                                    Но это занимает некоторое время.
                                                </p>

                                                <p class="total">
                                                    У вас в наличии: <span class="petric"><xsl:value-of select="player/petriks" /><i></i></span>
                                                </p>

                                                <xsl:choose>
                                                    <xsl:when test="petriksprocess = 1">
                                                        <script type="text/javascript">
                                                            area = "factory_petrik";
                                                        </script>
                                                        <div id="factory_petrik_1">
                                                            <table class="process">
                                                                <tr>
                                                                    <td class="label">Переработка:</td>
                                                                    <td class="progress">
                                                                        <div class="exp">
                                                                            <div class="bar"><div><div class="percent" style="width:{petriksprocesspercent}%;" id="petriksprocessbar"></div></div></div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="value" timer="{petriksprocesstimeleft}" timer2="{petriksprocesstimetotal}" id="petriksprocess"><xsl:value-of select="petriksprocesstimeleft2" /></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div id="factory_petrik_2" style="display:none;">
                                                            <p class="holders">
                                                                <span class="petric"><xsl:value-of select="petriks_doing" /><i></i></span> успешно произведены.
                                                            </p>
                                                        </div>
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        <p style="text-align:center;">
															<xsl:choose>
																<xsl:when test="count(items/instant/id) = 1">
																	Вы можете моментально переработать <span class="petric">
																<xsl:choose>
																	<xsl:when test="count(items/double/id) = 1">
																		<xsl:value-of select="petriks*2" />
																	</xsl:when>
																	<xsl:otherwise>
																		<xsl:value-of select="petriks" />
																	</xsl:otherwise>
																</xsl:choose>
																<i></i></span>, используя ускоритель варки.
																</xsl:when>
																<xsl:otherwise>
																	Для производства <span class="petric">
																	<xsl:choose>
																		<xsl:when test="count(items/double/id) = 1">
																			<xsl:value-of select="petriks*2" />
																		</xsl:when>
																		<xsl:otherwise>
																			<xsl:value-of select="petriks" />
																		</xsl:otherwise>
																	</xsl:choose>
																	<i></i></span> требуется 1 час.
																</xsl:otherwise>
															</xsl:choose>
                                                            <br />
                                                            <button class="button" type="submit" style="margin-top:5px;">
                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">
                                                                        <xsl:choose>
																			<xsl:when test="count(items/instant/id) = 1">
																				Сделать моментально
																			</xsl:when>
																			<xsl:otherwise>
																				Начать переработку
																			</xsl:otherwise>
																		</xsl:choose>
																		 — <span class="ruda"><xsl:value-of select="petriks_orecost" /><i></i></span> + <span class="tugriki">500<i></i></span>
                                                                    </div>
                                                                </span>
                                                            </button>
                                                        </p>
                                                    </xsl:otherwise>
                                                </xsl:choose>

                                            </form>
                                        </div>
                                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                    </div>
                                </xsl:if>
                            </td>

                            <td style="width:50%; padding:0 0 0 5px;">
                                <!--div class="block-bordered">
                                    <ins class="t l">
                                    <ins></ins>
                                    </ins>
                                    <ins class="t r">
                                    <ins></ins>
                                    </ins>
                                    <div class="center clear">
                                    <h3>Сборы</h3>
                                    <div class="factory-statistics">
                                        <p class="total">
                                            <b>Собрано:</b>&#0160;<span class="tugriki"><xsl:value-of select="format-number(total/money, '###,###,###')" /><i></i></span>
                                            <span class="ruda"><xsl:value-of select="format-number(total/ore, '###,###,###')" /><i></i></span>
                                            <span class="med"><xsl:value-of select="format-number(total/honey, '###,###,###')" /><i></i></span>
                                        </p>
                                        <p class="investors">
                                        <b>Основные вкладчики:</b>
                                        <br />
                                        <xsl:for-each select="investors/element">
                                            <span class="user">
                                                <i title="{fractionTitle}" class="{fraction}"></i>
                                                <xsl:if test="clan_id > 0 and clan_name != ''">
                                                    <a href="/clan/{clan_id}/"><img src="/@images/clan/clan_{clan_id}_ico.png" class="clan-icon" title="{clan_name}" /></a>
                                                </xsl:if>
                                                <a href="/player/{player}/"><xsl:value-of select="nickname" /></a>
                                                <span class="level">[<xsl:value-of select="level" />]</span>
                                            </span>:
                                            <span class="tugriki"><xsl:value-of select="format-number(money, '###,###,###')" /><i></i></span>
                                            <span class="ruda"><xsl:value-of select="format-number(ore, '###,###')" /><i></i></span>
                                            <span class="med"><xsl:value-of select="format-number(honey, '###,###')" /><i></i></span>
                                            <br />
                                        </xsl:for-each>
                                        </p>
                                    </div>
                                    </div>
                                    <ins class="b l">
                                    <ins></ins>
                                    </ins>
                                    <ins class="b r">
                                    <ins></ins>
                                    </ins>
                                </div-->

                               
                                    <div class="block-bordered">
                                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                        <div class="center clear">
                                            <h3>Мастерская</h3>
											 <form class="factory-mf-enterance">
												<p><img src="/@/images/obj/item8.png" align="right" style="margin:0;" />
													Доступ в цех по улучшению вооружений только по спец-пропускам. За дверью слышен гул крупногабаритной современной техники.
												</p>
                                                <xsl:choose>
                                                    <xsl:when test="player/level > 5">
														<div align="center">
	                                                        <div class="button">
	                                                            <a href="/factory/mf/" class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
	                                                                <div class="c">
	                                                                    Войти в мастерскую
	                                                                </div>
	                                                            </a>
	                                                        </div>
                                                        </div>
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        <div class="hint">Вход в мастерскую доступен только с 6-го левела.</div>
                                                    </xsl:otherwise>
                                                </xsl:choose>
                                            </form>
                                        </div>
                                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                    </div>
                                
                                
                                
                                    <div class="block-bordered">
                                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                        <div class="center clear">
                                            <h3>Фармацевтический-цех</h3>
                                            <form class="factory-pharma-enterance">
												<p>	Цех закрыт и запечатан. Открыть его в данный момент не представляется возможным.
													Ходят слухи, что там разрабатывали смертельные вирусы и препараты по заказу Министерства Обороны.
												</p>
                                                <xsl:choose>
                                                    <xsl:when test="player/level > 6">
														<div align="center">
	                                                        <div class="button">
	                                                            <a href="/factory/farma/" class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
	                                                                <div class="c">
	                                                                    Войти в фарма-цех
	                                                                </div>
	                                                            </a>
	                                                        </div>
                                                        </div>
														<!-- можно сделать нападение песра типа охранника банка, если лоулевел попытается войти без пропуска  -->
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        <div class="hint">Фарма-цех доступен только с 7-го левела.</div>
                                                    </xsl:otherwise>
                                                </xsl:choose>
                                            </form>
                                        </div>
                                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                    </div>
                                
                            </td>
                        </tr>
                    </table>
                </xsl:if>

            </div>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>