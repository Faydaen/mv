<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
            <div class="heading clear">
                <h2>
                <span class="metro"></span>
                </h2>
            </div>
            <div id="content" class="metro">
                <div class="welcome">
                    <div class="block-rounded">
                        <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>

                        <div class="text clear" id="welcome-rat" style="display:{welcome_rat_display};">
                            <img src="/@/images/pers/npc1_thumb.png" align="right" />
                            <xsl:choose>
                                <xsl:when test="player/state = 'metro_rat_search'">
                                    <a name="rat"></a>
                                    Долго бродив по темным тоннелям, вы наконец-то напали на след монстра. Пройдя по свежим
                                    отпечаткам когтистых лап, вы настигли голодную <b>Крысомаху [<span id="ratlevel"><xsl:value-of select="ratlevel" /></span>]</b>.
                                </xsl:when>
                                <xsl:otherwise>
                                    В поте лица вы трудились в метро и внезапно поняли, <br />
                                    что фонарный свет и громкое лязганье инструментов усиливаемое отголосками эхо,<br />
                                    привлекли внимание голодной <b>Крысомахи [<span id="ratlevel"><xsl:value-of select="ratlevel" /></span>]</b>.
                                </xsl:otherwise>
                            </xsl:choose>
                            <p>
                                <button class="button" onclick="metroAttackRat({player/id});">
                                    <span class="f">
                                        <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">Напасть на монстра</div>
                                    </span>
                                </button>
                                &#0160;
                                <button class="button" onclick="metroLeave2();">
                                    <span class="f">
                                        <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">Мужественно убежать</div>
                                    </span>
                                </button>
                            </p>
                        </div>

                        <div class="text" id="welcome-no-rat" style="display:{welcome_no_rat_display};">
                            <xsl:choose>
                                <xsl:when test="player/level &lt; 5">
                                    Город растет ежедневно и скоро поглотит всю область.<br />Поэтому мэрия требует, чтобы строились все новые и новые ветки метро.
                                    <br /><br />
                                    — Мал еще. Работа в туннеле не для слабаков! Докачайся до 5-го уровня и приходи.
                                </xsl:when>
                                <xsl:otherwise>
                                    Город растет ежедневно и скоро поглотит всю область.<br />Поэтому мэрия требует, чтобы строились все новые и новые ветки метро.
                                    <br /><br />
                                    — Такие добровольцы нам всегда нужны. Бери кирку и приходи творить великое дело своими руками. Найдешь золото, нефть или что-то еще — оно твое.
                                </xsl:otherwise>
                            </xsl:choose>
                        </div>
                    </div>
                </div>

                <xsl:if test="result != ''">
                    <div class="report">
                        <xsl:choose>
                            <xsl:when test="result = 1 and action = 'dig' and state = 'success'">
								<div class="success">
									Раскопка была успешной, вы нашли <xsl:choose><xsl:when test="perk_digger = 1">
										<span class="ruda"><i></i>2</span> благодаря усилению, включенному в Совете.</xsl:when><xsl:otherwise>
											<span class="ruda"><i></i>1</span>.
										</xsl:otherwise>
									</xsl:choose>
								</div>
							</xsl:when>
                            <xsl:when test="result = 0 and action = 'dig' and state = 'fail'">
								<div class="error">Вы копали до седьмого пота, но вы ошиблись — кто-то уже побывал здесь до вас.</div>
							</xsl:when>
                        </xsl:choose>
                    </div>
                </xsl:if>

                <xsl:if test="player/level &gt;= 5 and rat &lt;= 0">
                    <table id="content-no-rat">
                    <tr>
                        <td style="width:50%; padding:0 5px 0 0;">

                            <div class="block-bordered">
                                <ins class="t l">
                                <ins></ins>
                                </ins>
                                <ins class="t r">
                                <ins></ins>
                                </ins>
                                <div class="center clear">
                                <h3>Новая ветка</h3>
                                <div class="metro-branch">
                                    <p>Строительство новой ветки — это добровольный адский труд без малейшей оплаты. Однако, только здесь вы сможете найти руду, которая стала ценна после кризиса.</p>
                                    <xsl:if test="metro_message != ''">
                                        <p class="error">
                                            <xsl:choose>
                                                <xsl:when test="metro_message = 'no_pick'">
                                                    Без кирки от вас нет пользы. Вы можете <a href="/shop/">купить ее в магазине</a>.
                                                </xsl:when>
                                                <xsl:when test="metro_message = 'dig_success'">
                                                    Раскопка была успешной, вы нашли <span class="ruda"><i></i>1</span>.
                                                </xsl:when>
                                                <xsl:when test="metro_message = 'dig_fail'">
                                                    Вы копали до седьмого пота, но вы ошиблись — кто-то уже побывал здесь до вас.
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <xsl:value-of select="metro_message" />
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </p>
                                    </xsl:if>
                                    <xsl:choose>
                                        <xsl:when test="player/level &lt; 5">
                                            <p class="error">Работа в туннеле не для слабаков! Докачася до 5-го уровня и приходи.</p>
                                        </xsl:when>
                                        <xsl:when test="player/state = 'metro' and metrodigtimeleft > 0">
                                            <div id="kopaem">
                                                <table class="process">
                                                    <tr>
                                                        <td class="label">Раскопки:</td>
                                                        <td class="progress">
                                                            <div class="exp">
                                                                <div class="bar"><div><div class="percent" style="width:{metrodigpercent}%;" id="metrodigbar"></div></div></div>
                                                            </div>
                                                        </td>
                                                        <td class="value" timer="{metrodigtimeleft}" timer2="{metrodigtimetotal}" id="metrodig" intitle="1"><xsl:value-of select="metrodigtimeleft2" /></td>
                                                    </tr>
                                                </table>

                                                <button class="button" onclick="metroLeave();">
                                                    <span class="f">
                                                        <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Выбраться наружу</div>
                                                    </span>
                                                </button>
                                            </div>
                                            <div id="vykopali" style="display:none;">
                                                <p>Шанс найти руду в этом месте: <b id="ore_chance"></b>.</p>
                                                <div align="center">
                                                    <button class="button" onclick="metroWork();"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Искать дальше</div>
                                                        </span>
                                                    </button>
                                                    &#0160;
                                                    <button class="button" onclick="metroDig();"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Копать здесь</div>
                                                        </span>
                                                    </button>
                                                </div>
                                                <p style="text-align:center;margin-top:5px;">
                                                    <button class="button" onclick="metroLeave();">
                                                        <span class="f">
                                                            <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Выбраться наружу</div>
                                                        </span>
                                                    </button>
                                                </p>
                                            </div>
                                            <script type="text/javascript">
                                                area = 'metro';
                                            </script>
                                        </xsl:when>
                                        <xsl:when test="player/state = 'metro_done' or metrodigtimeleft &lt; 1">
                                            <p>Шанс найти руду в этом месте: <b><xsl:value-of select="metroorechance" />%</b>.</p>
                                            <div align="center">
                                                <button class="button" onclick="metroWork();"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Искать дальше</div>
                                                    </span>
                                                </button>
                                                &#0160;
                                                <button class="button" onclick="metroDig();"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Копать здесь</div>
                                                    </span>
                                                </button>
                                            </div>
                                            <p style="text-align:center; margin-top:5px;">
                                                <button class="button" onclick="metroLeave();">
                                                    <span class="f">
                                                        <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Выбраться наружу</div>
                                                    </span>
                                                </button>
                                            </p>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <div class="button" onclick='metroWork();'><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Спуститься в туннель</div>
                                                </span>
                                            </div>
                                            <p class="hint">Перед спуском в&#160;тоннель
                                                <a href="/shop/section/other/">купите в&#160;магазине</a> кирку и&#160;принадлежности
                                            </p>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </div>
                                </div>
                                <ins class="b l">
                                <ins></ins>
                                </ins>
                                <ins class="b r">
                                <ins></ins>
                                </ins>
                            </div>

                            <div class="block-bordered">
                                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                <div class="center clear">
                                <a name="rats"></a>
                                <h3>Крысомахи</h3>
                                <div class="metro-branch">
                                    <img src="/@/images/pers/npc1_thumb.png" align="right" title="Крысомаха" alt="Крысомаха" />
                                    <p>Говорят, что Крысомахи — это мутировавшие копатели метро, не вылезавшие из него несколько лет. Видимо,
                                    мутация происходит из-за постоянного нахождения под действием потоков разумных нано-частиц, излучаемых
                                    залежами руды и других полезных (и не очень) ископаемых.</p>
                                    <xsl:choose>
                                        <xsl:when test="player/level &lt; 5">
                                            <p class="error">Крысомахи — очень опасные твари! Чтобы на них охотиться, необходимо
                                            достичь 5-го уровня.</p>
                                        </xsl:when>
                                        <xsl:when test="player/state = 'metro_rat_search' and ratsearchtimeleft > 0">
                                            <div id="ratsearch">
                                                <table class="process">
                                                    <tr>
                                                        <td class="label">Поиск:</td>
                                                        <td class="progress">
                                                            <div class="exp">
                                                                <div class="bar"><div><div class="percent" style="width:{ratsearchpercent}%;" id="ratsearchbar"></div></div></div>
                                                            </div>
                                                        </td>
                                                        <td class="value" timer="{ratsearchtimeleft}" timer2="{ratsearchtimetotal}" id="ratsearch" intitle="1"><xsl:value-of select="ratsearchtimeleft2" /></td>
                                                    </tr>
                                                </table>

                                                <button class="button" onclick="metroLeave2();">
                                                    <span class="f">
                                                        <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Выбраться наружу</div>
                                                    </span>
                                                </button>
                                            </div>
                                            <div id="ratnotfound" style="display:none;">
                                                <div class="holders">
                                                    <p>Вы долго бродили по темным коридорам, но так и не смогли выйти на след Крысомахи.</p>

                                                    <button class="button" onclick="metroSearchRat({player/id});">
                                                        <span class="f">
                                                            <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Искать дальше</div>
                                                        </span>
                                                    </button>
                                                    &#0160;
                                                    <button class="button" onclick="metroLeave2();">
                                                        <span class="f">
                                                            <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Выбраться наружу</div>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                area = 'metro_rat';
                                            </script>
                                        </xsl:when>
                                        <xsl:when test="player/state = 'metro_rat_search' or ratsearchtimeleft &lt; 1">
                                            <div class="holders">
                                                <p>Вы долго бродили по темным коридорам, но так и не смогли выйти на след Крысомахи.</p>

                                                <button class="button" onclick="metroSearchRat({player/id});">
                                                    <span class="f">
                                                        <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Искать дальше</div>
                                                    </span>
                                                </button>
                                                &#0160;
                                                <button class="button" onclick="metroLeave2();">
                                                    <span class="f">
                                                        <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Выбраться наружу</div>
                                                    </span>
                                                </button>
                                            </div>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <p>
                                                <div class="button" onclick="metroSearchRat({player/id});">
                                                    <span class="f">
                                                        <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Попытаться выследить Крысомаху</div>
                                                    </span>
                                                </div>
                                            </p>
                                            <p class="hint">Шанс напасть на след Крысомахи — около 30%.</p>
                                            <p class="hint">Перед поиском крыс обязательно
                                                <a href="/shop/section/pharmacy/">покушайте и наберитесь сил</a>.
                                            </p>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </div>
                                </div>
                                <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                            </div>
                        </td>
                        <td style="width:50%; padding:0 0 0 5px;">

                            <div class="block-bordered">
                                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                <div class="center clear">
                                <h3>Наперсточник</h3>
                                <div class="metro-thimble">
                                    <img src="/@/images/pers/man100_thumb.png" align="right" title="Моня Шац" alt="Моня Шац" />
                                    <p>После окончания математического института Моня Шац мог бы стать великим ученым. Однако вместо кафедры Теории Вероятности он пошел на улицу дурить всех своими наперстками. Он настолько полюбил свое ремесло, что даже на свои похороны заказал три гроба.</p>
                                    <p>Попытайте удачу, и, если вам повезет, вы сможете выиграть у Мони немного руды, не пачкаясь в темном тоннеле.</p>
                                    <p class="holders">
                                        Встреч с Моней на сегодня: <xsl:value-of select="monya_left" />
                                    </p>
                                    <div class="button" style="margin:5px">
                                        <a href="/thimble/start/" class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                            <div class="c">Начать играть<xsl:if test="monya_bilet = 1"> — 1 билетик</xsl:if></div>
                                        </a>
                                    </div>
									<p class="hint">Если вы хотите провести с Моней более чем три встречи в день, приобретите специальный билетик в <a href="/berezka/">Березке</a>.</p>
									<p class="hint">Если вам нужна дополнительная руда, то в <a href="/berezka/">Березке</a> вы можете приобрести сертификаты для гарантированного обмена <span class="ruda">руды<i></i></span> в банке.</p>
                                </div>
                                </div>
                                <ins class="b l">
                                <ins></ins>
                                </ins>
                                <ins class="b r">
                                <ins></ins>
                                </ins>
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