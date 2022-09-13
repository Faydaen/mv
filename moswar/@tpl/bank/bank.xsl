<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Банк
                </h2></div>
                <div id="content" class="bank">

                    <div class="welcome">
                        <div class="amount" title="Общая сумма денег в банке на данный момент">
                            <xsl:value-of select="format-number(bank/total, '###,###,###,###')" />
                        </div>
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="text">
                                <xsl:choose>
                                    <xsl:when test="player/level > 4">
                                        — Бонджорно, дорогие клиенты. Наш банк по праву считается самым стабильным и надежным.<br />
                                        Это одно из лучших мест, где вы можете сохранить свои накопления,<br />
                                        достаточно поставить всего лишь одну подпись.
                                    </xsl:when>
                                    <xsl:otherwise>
                                        Банк доступен с 5-го левела.
                                    </xsl:otherwise>
                                </xsl:choose>
                            </div>
                        </div>
                    </div>

                    <xsl:if test="player/level > 4">
                        <table>
                            <tr>
                                <td style="width:50%; padding:0 5px 0 0;">
                                    <div class="block-bordered">
                                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                        <div class="center clear">
                                            <h3>Вклады</h3>
                                            <div class="bank-deposit">
                                                <p>Все жители столицы могут положить свои деньги в банк, но для этого необходимо завести банковскую ячейку.</p>
                                                <form action="/bank/activate/" method="post">
                                                    <input type="hidden" name="player" value="{player/id}" />
                                                    <xsl:choose>
                                                        <xsl:when test="bank/active = 1">
                                                            <p align="center">Ваша ячейка открыта до: <span class="dashedlink" onclick="$('#bank-deposit-cell-prolong').toggle('fast');"><xsl:value-of select="bank/dt" /></span></p>
                                                            <p align="center" style="display:none;" id="bank-deposit-cell-prolong">
                                                                <button class="button" type="submit">
                                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                        <div class="c">Продлить ячейку на 14 дней — <span class="ruda">14<i></i></span> (<span class="med">14<i></i></span>)</div>
                                                                    </span>
                                                                </button>
                                                            </p>
                                                        </xsl:when>
                                                        <xsl:otherwise>
                                                            <div>
                                                                <p align="center">
                                                                    <button class="button" type="submit">
                                                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                            <div class="c">Завести ячейку на 14 дней — <span class="ruda">14<i></i></span> (<span class="med">14<i></i></span>)</div>
                                                                        </span>
                                                                    </button>
                                                                </p>
                                                                <p><img src="/@/images/obj/symbol4.png" align="left" />После заведения ячейки вы сможете положить <b>50%</b> своих накоплений на <b>24 часа</b>, затем забрать их самостоятельно.
                                                                Процентная ставка 365% годовых.</p>
                                                            </div>
                                                        </xsl:otherwise>
                                                    </xsl:choose>
                                                </form>

                                                <xsl:if test="bank/active = 1 or bank/mymoney > 0">
                                                    <div>
                                                        <xsl:if test="bank/active = 1">
                                                            <p>Вы можете положить <b>50%</b> своих накоплений на <b>24 часа</b>,
                                                            затем забрать их самостоятельно. Процентная ставка 365% годовых.
                                                            Проценты начисляются ежедневно примерно в 0:30 ночи.</p>
                                                        </xsl:if>

                                                        <xsl:choose>
                                                            <xsl:when test="bank/mymoney > 0">
                                                                <div>
                                                                    <div class="now">
                                                                        Сейчас на счету: <span class="tugriki"><xsl:value-of select="format-number(bank/mymoney, '###,###,###')" /><i></i></span>
                                                                        <br />Можно забрать: <xsl:value-of select="bank/mydt" /><br />
                                                                        <xsl:if test="bank/cantake = 1">
                                                                            <form action="/bank/take/" method="post">
                                                                                <input type="hidden" name="player" value="{player/id}" />
                                                                                <p align="center">
                                                                                    <button class="button" type="submit">
                                                                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                                            <div class="c">Забрать <span class="tugriki"><xsl:value-of select="format-number(bank/mymoney, '###,###,###')" /><i></i></span></div>
                                                                                        </span>
                                                                                    </button>
                                                                                </p>
                                                                            </form>
                                                                        </xsl:if>
                                                                    </div>
                                                                </div>
                                                            </xsl:when>
                                                            <xsl:when test="bank/active = 1">
                                                                <form action="/bank/put/" method="post">
                                                                    <input type="hidden" name="player" value="{player/id}" />
                                                                    <p align="center">
                                                                        <button class="button" type="submit">
                                                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                                <div class="c">Сделать вклад на сумму <span class="tugriki"><xsl:value-of select="format-number(bank/newmoney, '###,###,###')" /><i></i></span></div>
                                                                            </span>
                                                                        </button>
                                                                    </p>
                                                                </form>
                                                            </xsl:when>
                                                        </xsl:choose>
                                                    </div>
                                                </xsl:if>

                                                <p align="center"><span class="dashedlink" onclick="$('#bank-deposit-robbery').toggle('fast');">Риски и половник дёгтя</span></p>
                                                <p id="bank-deposit-robbery" style="display:none;">
                                                    Несмотря на охрану, в наш криминальный век находится немало желающих ограбить банк.
                                                    В результате каждого удачного ограбления со счета может быть <b>списано 10%</b>.
                                                    В день может быть <b>не больше трех</b> попыток ограблений.
                                                    <br /><br />Если после очередного ограбления на Вашем счету останется менее <span class="tugriki">50<i></i></span>, то он будет закрыт.
                                                </p>
                                            </div>
                                        </div>
                                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                    </div>

                                    <div class="block-bordered">
                                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                        <div class="center clear">
                                            <h3>Покупка драгоценных металлов</h3>
                                            <div class="bank-robbery">
                                                <p>При наличии специального сертификата, покупаемого в <a href="/berezka/">Березке</a>,
                                                    вы можете обменять монеты на руду по фиксированному курсу:
                                                    <span class="ruda">1<i></i></span> = <span class="tugriki">750<i></i></span>
                                                </p>

                                                <form action="/bank/buy-ore/" method="post">
                                                    <span class="ruda">Хочу руды: <input type="text" name="ore" size="4" maxlength="4" value="0" onkeyup="bankUpdateRudaMoneySum(this.value)" /><i></i></span>
                                                    = <span class="tugriki" id="tugriks">0<i></i></span>
                                                    <div align="center" style="padding:5px;">
                                                        <button class="button" type="submit">
                                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                <div class="c">Обменять — 1 сертификат</div>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                    </div>

                                </td>
                                <td style="width:50%; padding:0 0 0 5px;">

                                    <div class="block-bordered">
                                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                        <div class="center clear">
                                            <h3>Руки вверх</h3>
                                            <div class="bank-robbery">
                                                
                                                <p><img src="/@/images/pers/man107_thumb.png" align="right" title="Охранник банка" alt="Охранник банка" />
												Один из охранников банковского хранилища очень любит делать жене дорогие подарки.
                                                Во время смены караула (<b>10:00</b>, <b>16:00</b>, <b>20:00</b>) он готов пропустить <b>20 грабителей</b> через бронированную дверь за небольшое вознаграждение.
                                                Чем больше Ваша взятка, тем больше шансов пойти на дело.</p>
                                                <div class="details">
                                                    Предстоящее ограбление в <xsl:value-of select="fight/nearesthour" />:00<br />
                                                    <xsl:if test="fight/state = 'created'">
                                                        Общая сумма взяток: <span class="tugriki"><xsl:value-of select="fight/totalbribes" /><i></i></span><br />
                                                        Взяточников: <xsl:value-of select="fight/robbers" />/20<br />
                                                        <xsl:if test="me = 1">
                                                            Ваша сумма: <span class="tugriki"><xsl:value-of select="fight/mybribe" /><i></i></span>
                                                        </xsl:if>
                                                    </xsl:if>
                                                </div>
                                                <xsl:choose>
                                                    <xsl:when test="fight/state = 'created' and fight/me = 0">
                                                        <form action="/fight/" method="post">
                                                            <input type="hidden" name="action" value="join fight" />
                                                            <input type="hidden" name="fight" value="{fight/id}" />
                                                            <span class="tugriki">Сумма: <input type="text" name="money" size="6" maxlength="6" /><i></i></span>
                                                            <button class="button" type="submit">
                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">Дать взятку</div>
                                                                    <!-- <div class="c">Добавить взятку</div> -->
                                                                </span>
                                                            </button>
                                                            <p>Минимальный размер взятки на Вашем уровне — <span class="tugriki"><xsl:value-of select="fight/minbribe" /><i></i></span></p>
                                                        </form>
                                                        <p class="hint">Взятка не возвращается, даже если вы не вошли в число грабителей</p>
                                                    </xsl:when>
                                                    <xsl:when test="fight/state = 'started'">
                                                        <p class="holders">
                                                            <a href="/fight/{fight/id}/" class="now">Бой идет в данный момент</a>
                                                        </p>
                                                    </xsl:when>
                                                </xsl:choose>
                                                <p align="center"><span class="dashedlink" onclick="$('#bank-robbery-details').toggle('fast');">Как это работает?</span></p>
                                                <p id="bank-robbery-details" style="display:none;">
                                                    Банк грабится игроками 3 раза в день: в 10, 16 и 20 часов.<br />
                                                    За 15 минут до ограбления появляется возможность записаться в бой.<br />
                                                    Чтобы записаться в бой, необходимо дать охраннику банка взятку.<br />
                                                    Игроки не видят, кто какую взятку дал охраннику, но видят количество давших взятки и их общий объем.<br />
                                                    В бой попадают 20 жителей из тех, кто дал наибольшие взятки (чем больше Ваша взятка, тем больше вероятность попасть в бой).<br />
                                                    Если вы не попадете в бой, то взятка вам возвращена не будет.<br />
                                                    Деньги при успешном ограблении банка получают все участники ограбления, независимо от того,
                                                    остались они в живых или нет.
                                                </p>
                                            </div>
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