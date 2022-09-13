<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />

    <xsl:template match="/data">
		<div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Охотничий клуб
                </h2></div>
                <div id="content" class="hunting">

                    <div class="welcome">
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="text">
                                — Здесь, в клубе любителей пострелять, мы развлекаемся охотой. Охотой за головами.<br />
                                Ты можешь либо заказать человека, либо сам принять заказ и получить награду за убийство.
                                <xsl:if test="player/level = 1">
                                    <p>Вход в клуб возможен только со 2-го уровня.</p>
                                </xsl:if>
                            </div>
                        </div>
						<div class="goback">
							<span class="arrow">◄</span><a href="/arbat/">Выйти на Арбат</a>
						</div>
                    </div>

                    <xsl:if test="player/level > 1">
                        <table>
                            <tr>
                                <td style="width:50%; padding:0 5px 0 0;">
                                    <div class="block-bordered">
                                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                        <div class="center clear">
                                            <h3>Справедливая месть</h3>
                                            <div class="hunting-order">
                                                <p>Если вас кто-то обидел, приготовил горький кофе, оштрафовал на МКАДе или просто кругом одни балбесы,
                                                Вы можете отомстить за себя. Специально обученные мстители помогут наказать обидчика.</p>
                                                <xsl:choose>
                                                    <xsl:when test="orders_done &lt; 10">
                                                        <p align="center">
                                                            <b>Имя жертвы:</b>&#0160;<input type="text" id="nickname2" value="{revenge}" size="14" maxlength="20" />&#0160;<button class="button" onclick="huntclubShowForm();">
                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">Заказать</div>
                                                                </span>
                                                            </button>
                                                        </p>
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        <p>Можно делать не более 10 заказов за 24 часа.</p>
                                                    </xsl:otherwise>
                                                </xsl:choose>
                                                
                                                <p class="holders">
                                                    <xsl:if test="myzakaz > 0">
                                                        <a href="/huntclub/my/">Мои текущие заказы</a> (<xsl:value-of select="myzakaz" />)
                                                    </xsl:if>
                                                    <xsl:if test="myzakaz2 != myzakaz">
                                                        <xsl:if test="myzakaz > 0"><br /></xsl:if>
                                                        <a href="/huntclub/my/">История заказов</a> (<xsl:value-of select="myzakaz2" />)
                                                    </xsl:if>
                                                    <xsl:if test="myzakaz2 != myzakaz or myzakaz > 0"><br /></xsl:if>
                                                    Можно сделать заказов: <xsl:value-of select="10 - number(orders_done)" />
                                                </p>
                                                <xsl:if test="mezakaz > 0">
                                                    <p class="error-markered">
                                                        <a href="/huntclub/me/">На вас активных заказов</a>: <xsl:value-of select="mezakaz" />
                                                        <xsl:if test="mezakaz2 != mezakaz">
                                                            <br /><a href="/huntclub/me/">История заказов</a> (<xsl:value-of select="mezakaz2" />)
                                                        </xsl:if>
                                                    </p>
                                                </xsl:if>
                                                <p class="hint">1 заказ — это 3 нападения. Можно сделать не более 10 заказов за 24 часа.
                                                Ежедневно первый заказ на новую жертву — <b>бесплатно</b>. Если жертва уже заказана кем-то еще — цена заказа растёт. Подробное описание и ответы на вопросы читайте
                                                в <a href="/faq/huntingclub/">специальном разделе</a>.</p>
                                            </div>
                                        </div>
                                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                    </div>
                                </td>
                                <td style="width:50%; padding:0 0 0 5px;">
                                    <div class="block-bordered">
                                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                        <div class="center clear">
                                            <h3>Охотники за головами</h3>
                                            <form id="hunter-activate" class="hunting-join" action="/huntclub/activate/" method="post">
                                                <input type="hidden" name="player" value="{player/id}" />
												<img src="/@/images/obj/symbol2.png" align="right" style="margin:-2px 0 0 12px;" />
                                                <p>Мир жесток и несправедлив. И на этом можно неплохо заработать. Вступай в наш клуб охотников за головами!</p>
                                                <xsl:choose>
                                                    <xsl:when test="hunter = 1">
                                                        <div class="prolong" align="center">
                                                            <p align="center">Вы член клуба до: <span class="dashedlink" onclick="$('#trainer-personal-prolong').toggle('fast');"><xsl:value-of select="huntdt" /></span></p>
                                                            <p align="center" style="display:none;" id="trainer-personal-prolong">
                                                                <button class="button" type="submit">
                                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                        <div class="c">Продлить на 14 дней — <span class="ruda">14<i></i></span> (<span class="med">14<i></i></span>)</div>
                                                                    </span>
                                                                </button>
                                                            </p>

                                                            <table class="process">
                                                                <tr>
                                                                    <td class="label">Ранговые убийства:</td>
                                                                    <td class="progress">
                                                                        <div class="exp">
                                                                            <div class="bar"><div><div class="percent" style="width:{prof/percent}%;"></div></div></div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="value">
                                                                        <xsl:value-of select="prof/value" />/<xsl:value-of select="prof/nextlevel" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <p style="text-align:center;"><b style="color:#003399;">Звание: <xsl:value-of select="prof/name" /></b></p>

                                                            <p class="holders">
                                                                Можно выполнить заказов: <xsl:value-of select="10 - number(mycomplete) + prof/i" />
                                                            </p>
                                                        </div>
                                                    </xsl:when>
                                                    <xsl:when test="hunter = 0 and player/level > 2">
                                                        <p align="center">
                                                            <button class="button" type="submit">
                                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">Вступить на 14 дней — <span class="ruda">14<i></i></span> (<span class="med">14<i></i></span>)</div>
                                                                </span>
                                                            </button>
                                                        </p>
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        <p>Вступить в Охотничий клуб можно только с 3-го уровня.</p>
                                                    </xsl:otherwise>
                                                </xsl:choose>
                                            </form>

                                            <xsl:if test="hunter = 1">
                                                <h3><a href="/huntclub/wanted/">Внимание, розыск!</a></h3>
                                                <div class="hunting-wanted">
                                                    <p class="hint">Помимо денежной награды за каждое заказное убийство охотники получают <b>жетоны</b>, которые принимаются в магазине &#0171;<a href="/berezka/">Березка</a>&#0187;.
                                                        Беритесь за оружие и вперед!
                                                    </p>
                                                    <xsl:if test="count(wanted/element) > 0">
                                                        <table class="list">
                                                            <tr>
                                                                <th>Имя</th>
                                                                <th class="value">Награда</th>
                                                            </tr>
                                                            <xsl:for-each select="wanted/element">
                                                                <tr>
                                                                    <td><xsl:call-template name="playerlink"><xsl:with-param name="player" select="current()" /></xsl:call-template></td>
                                                                    <td class="value"><span class="tugriki"><xsl:value-of select="format-number(award, '###,###,###')" /><i></i></span></td>
                                                                </tr>
                                                            </xsl:for-each>
                                                        </table>
                                                    </xsl:if>
                                                    <div align="center">
                                                        <p>
                                                            <div class="button">
                                                                <a href="/huntclub/wanted/" class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                    <div class="c">Весь список жертв</div>
                                                                </a>
                                                            </div>
                                                        </p>
                                                    </div>
                                                </div>

                                                <!--h3><a href="/rating/hunters/">Лучшие охотники</a></h3-->

                                                <!--div class="hunting-hunters">
                                                    <table class="list">
                                                    <tr>
                                                    <th>Имя</th>
                                                    <th class="value">Засечек</th>
                                                    </tr>
                                                    <tr>
                                                    <td><span class="user"><i title="Понаехавший" class="arrived"></i><a href="/player/237136/">Soltek</a><span class="level">[7]</span></span></td>
                                                    <td class="value"><b>149</b></td>
                                                    </tr>
                                                    <tr>
                                                    <td><span class="user"><i title="Коренной" class="resident"></i><a href="/player/189068/">Воспитатель</a><span class="level">[7]</span></span></td>
                                                    <td class="value"><b>117</b></td>
                                                    </tr>
                                                    <tr>
                                                    <td><span class="user"><i title="Коренной" class="resident"></i><a href="/player/227965/">nskwar</a><span class="level">[7]</span></span></td>
                                                    <td class="value"><b>91</b></td>
                                                    </tr>
                                                    </table>
                                                </div-->
                                            </xsl:if>

                                        </div>
                                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </xsl:if>

                    <div id="hunting-order-form" class="alert" style="display:none;">
                        <div class="padding">
                            <h2 id="alert-title">Лист заказа</h2>
                            <div class="data clear">
                                <div id="alert-text">
                                    <form action="/huntclub/zakaz/" method="post" id="hunt-form">
                                        <input type="hidden" name="player" value="{player/id}" />
                                        <table class="forms">
                                            <tr>
                                                <td class="label">Имя жертвы</td>
                                                <td class="input">
                                                    <input type="text" name="nickname" id="nickname" size="16" maxlength="16" />&#0160;<button class="button" type="button" id="form-submit" onclick="huntclubCheckForm2();">
                                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Проверить</div>
                                                        </span></button>
                                                    <div class="error" id="nickname-error"></div>
                                                    <div class="success" id="nickname-ok">Игрок может быть заказан</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">Комментарий</td>
                                                <td class="input"><input type="text" name="comment" id="comment" size="20" style="width:100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="label">Дополнительная награда</td>
                                                <td class="input">
                                                    <input type="text" name="award" id="award" size="5" value="0" onkeyup="huntclubAwardKeyUp()" /><span class="tugriki"><i></i></span>
                                                    <div class="error" id="award-error"></div>
                                                    <div class="hint">Чтобы заказ не остался незамеченным, вы можете назначить дополнительный стимул для охотников.</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label"></td>
                                                <td class="input">
                                                    <input type="checkbox" name="vip" id="hunting-order-form-grand" onclick="huntclubVipCheck()" />
                                                    <label for="hunting-order-form-grand">Удвоенный грабеж</label>
                                                    <div class="error" id="vip-error"></div>
                                                    <div class="hint">При убийстве с игрока будет выбито в 2 раза больше монет.</div>
                                                </td>
                                            </tr>
                                            <xsl:if test="player/playboy = 1">
                                                <tr>
                                                    <td class="label"></td>
                                                    <td class="input">
                                                        <input type="checkbox" name="private" id="hunting-order-form-private" onclick="huntclubPrivateCheck()" />
                                                        <label for="hunting-order-form-private">Приватный заказ</label>
                                                        <div class="error" id="private-error"></div>
                                                        <div class="hint">Жертва не получит возможность узнать, кто её заказал.</div>
                                                    </td>
                                                </tr>
                                            </xsl:if>
                                        </table>
                                        <p align="center">
                                            <button class="button" type="button" id="form-submit" onclick="huntclubCheckForm();">
                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">
                                                        Сделать заказ на нападения —
                                                        <span class="tugriki"><span id="hunting-order-form-cost-tugriki">0</span><i></i></span>
                                                        <span id="hunting-order-form-cost-grand" style="display:none;"> + <span class="ruda">5<i></i></span> (<span class="med">5<i></i></span>)</span>
                                                        <span id="hunting-order-form-cost-private" style="display:none;"> + <span class="med">5<i></i></span></span>
                                                    </div>
                                                </span>
                                            </button>
                                            <div class="error" id="money-error" style="text-align:center;"></div>
                                        </p>
                                        <p>
                                            После трех нападений заказ считается выполненным. Исход нападения - не важен. <br />За каждое удачное нападение, охотник получит треть от стоимости заказа. За невыполненные заказы деньги не возвращаются.<br />
                                            Заказ будут исполнять охотники [–2...+1] от уровня жертвы.<br />
                                        </p>
                                        <p style="text-align:center;">
                                            <button class="button" type="button" style="submit" id="form-cancel" onclick="huntclubCancel();">
                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Я передумал</div>
                                                </span>
                                            </button>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <xsl:if test="player/playboy = 0">
                        <input type="checkbox" name="private" id="hunting-order-form-private" style="display:none;" />
                    </xsl:if>
                    <script type="text/javascript">
                        myMoney = <xsl:value-of select="player/money" />;
                        myZakaz = <xsl:value-of select="myzakaz" />;
                        myOre = <xsl:value-of select="player/ore" />;
                        myHoney = <xsl:value-of select="player/honey" />;
                        myLevel = <xsl:value-of select="player/level" />;
                        <xsl:if test="revenge != ''">
                            huntclubShowForm();
                        </xsl:if>
                    </script>
                    
                </div>
            </div>

        </div>
    </xsl:template>

</xsl:stylesheet>