<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/clanlink.xsl" />
    <xsl:include href="common/clan-error.xsl" />
    <xsl:include href="common/price.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    <span class="clan"></span>
                </h2></div>
                <div id="content" class="clan">

                    <xsl:if test="count(result) > 0">
                        <xsl:call-template name="error">
                            <xsl:with-param name="result" select="result" />
                        </xsl:call-template>
                    </xsl:if>

                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <div class="flag">
                                <img width="99" height="99" class="emblem">
                                    <xsl:attribute name="src">http://img.moswar.ru/@images/clan/clan_<xsl:value-of select="clan/id" />_logo.png</xsl:attribute>
                                </img>
								<div class="prestige-info">
									<b><xsl:value-of select="clan/rank" /> [<xsl:value-of select="clan/level" />]</b><br />
									<img src="/@/images/obj/clansign{clan/level}.png" title="{clan/rank}" alt="{clan/rank}" />
								</div>
                            </div>
                            <div class="clan-info">
                                <table class="forms">
                                    <tr>
                                        <td class="label">Название:</td>
                                        <td class="input">
                                            <xsl:call-template name="clanlink">
                                                <xsl:with-param name="clan" select="clan" />
                                            </xsl:call-template>
                                        </td>
                                    </tr>
                                    <xsl:if test="clan/slogan != ''">
                                        <tr>
                                            <td class="label">Девиз:</td>
                                            <td class="input"><xsl:value-of select="clan/slogan" /></td>
                                        </tr>
                                    </xsl:if>
                                    <xsl:if test="clan/site != ''">
                                        <tr>
                                            <td class="label">Сайт:</td>
                                            <td class="input"><noindex><a href="http://{clan/site}" target="_blank" rel="nofollow"><xsl:value-of select="clan/site"/></a></noindex></td>
                                        </tr>
                                    </xsl:if>
                                    <tr>
                                        <td class="label">Рейтинг:</td>
                                        <td class="input">№<xsl:value-of select="clan/rating" /></td>
                                    </tr>
                                    <tr>
                                        <td class="label">Казна:</td>
                                        <td class="input">
                                            <span class="tugriki"><xsl:value-of select="format-number(clan/money, '###,###,###')" /><i></i></span>
                                            <span class="ruda"><xsl:value-of select="format-number(clan/ore, '###,###')" /><i></i></span>
                                            <span class="med"><xsl:value-of select="format-number(clan/honey, '###,###')" /><i></i></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Глава:</td>
                                        <td class="input">
                                            <xsl:call-template name="playerlink">
                                                <xsl:with-param name="player" select="clan/founder" />
                                            </xsl:call-template>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Кланеры:</td>
                                        <td class="input">
                                            <xsl:value-of select="count(clan/players/element)" /> (макс: <xsl:value-of select="clan/maxpeople" />)
                                            <a href="javascript:void(0);" onclick="$('#players').toggle();">список</a>
                                            <div id="players" style="display: none;">
                                                <xsl:for-each select="clan/players/element">
                                                    <xsl:sort order="descending" select="level" data-type="number"/>
                                                    <xsl:sort order="ascending" select="nickname" />
                                                    <xsl:call-template name="playerlink">
                                                        <xsl:with-param name="player" select="current()" />
                                                    </xsl:call-template>
                                                    <xsl:if test="clan_title != ''"> - <xsl:value-of select="clan_title" /></xsl:if>
                                                    <br />
                                                </xsl:for-each>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Атака:</td>
                                        <td class="input">
                                            <b><xsl:value-of select="clan/attack" /></b>&#0160;<xsl:if test="clan/attack > 0">(клан может объявлять войну)</xsl:if>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Защита:</td>
                                        <td class="input">
                                            <b><xsl:value-of select="clan/defence" /></b>&#0160;<xsl:if test="clan/defence > 0">(клан может заключать союзы)</xsl:if>
                                        </td>
                                    </tr>
                                    <xsl:if test="clan/wpt != ''">
                                        <tr>
                                            <td class="label">Время ненападения:</td>
                                            <td class="input">
                                                <xsl:value-of select="clan/wpt" />
                                            </td>
                                        </tr>
                                    </xsl:if>
                                    <tr>
                                        <td class="label">Дипломатия:</td>
                                        <td class="input">
                                            <xsl:choose>
                                                <xsl:when test="count(clan/diplomacy/element) = 0">
                                                    Клан порочных связей не имеет.
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
                                                                        <span class="friend"> - союз</span>
                                                                    </xsl:when>
                                                                    <xsl:when test="type = 'war' and (state = 'paused' or state = 'step1' or state='step2')">
																		<xsl:choose>
																			<xsl:when test="parent_diplomacy = 0"><span class="enemy"> - <a href="/clan/warstats/{dip_id}/">война</a> до <xsl:value-of select="dt2" /></span></xsl:when>
																			<xsl:otherwise><span class="enemy"> - <a href="/clan/warstats/{dip_id}/">союзная война</a></span></xsl:otherwise>
																		</xsl:choose>
                                                                        <xsl:choose>
                                                                            <xsl:when test="state = 'paused'"> (<a href="/faq/war/#paused">подготовка к войне</a>)</xsl:when>
                                                                            <xsl:when test="state = 'step1'"> (<a href="/faq/war/#step1">первый этап</a>)</xsl:when>
                                                                            <xsl:when test="state = 'step2'"> (<a href="/faq/war/#step2">второй этап</a>)</xsl:when>
                                                                        </xsl:choose>
                                                                    </xsl:when>
                                                                </xsl:choose>
                                                            </li>
                                                        </xsl:for-each>
                                                    </ul>
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </td>
                                    </tr>
									<xsl:if test="count(clan/wars/element) > 0">
										<tr>
											<td class="label">Последние войны:</td>
											<td class="input">
														<ul class="list-users">
															<xsl:for-each select="clan/wars/element">
																<li>
																	<xsl:call-template name="clanlink">
																		<xsl:with-param name="clan" select="current()" />
																	</xsl:call-template>
																	-
																		<a href="/clan/warstats/{dip_id}/">
																			<xsl:choose>
																				<xsl:when test="result = 'win'">победа</xsl:when>
																				<xsl:when test="result = 'lose'">поражение</xsl:when>
																				<xsl:when test="result = 'draw'">ничья</xsl:when>
																			</xsl:choose>
																		</a>&#160;<xsl:value-of select="dt2" />
																</li>
															</xsl:for-each>
														</ul>
											</td>
										</tr>
									</xsl:if>
                                </table>
                                <xsl:choose>
                                    <xsl:when test="player/clan = clan/id and player/clan_status = 'recruit'">
                                        <div class="button">
                                            <a class="f" href="#" onclick="clanDiplomacyExt({clan/id}, 'apply_cancel');"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                <div class="c">Отменить заявку на вступление</div>
                                            </a>
                                        </div>
                                    </xsl:when>
                                    <xsl:when test="player/clan = clan/id">
                                        <div class="button">
                                            <a class="f" href="/clan/profile/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                <div class="c">Перейти к клану</div>
                                            </a>
                                        </div>
                                        <div class="button">
                                            <a class="f" href="/forum/{clan/forum}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                <div class="c">Форум клана</div>
                                            </a>
                                        </div>
                                    </xsl:when>
                                    
                                    <xsl:when test="player/clan != clan/id and player/clan != 0 and player/fraction = clan/fraction and /data/diplomat = 1">
                                        <xsl:choose>
                                            <xsl:when test="clan/mydiplomacy/type = 'union' and clan/mydiplomacy/state = 'proposal' and clan/mydiplomacy/clan1 = player/clan">
                                                <div class="button">
                                                    <a class="f" href="#" onclick="clanDiplomacyExt({clan/id}, 'union_propose_cancel');"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Отозвать предложение заключить союз</div>
                                                    </a>
                                                </div>
                                            </xsl:when>
                                            <xsl:when test="clan/mydiplomacy/type = 'union' and clan/mydiplomacy/state = 'accepted'">
                                                <p><b>Вы находитесь в союзе с этим кланом</b>. Самое время на кого-нибудь совместно напасть.</p>
                                                <p>Узнать больше о порочных связях Вашего клана можно в разделе
                                                <a href="/clan/profile/diplomacy/">Дипломатия</a>.</p>
                                            </xsl:when>
                                            <xsl:when test="clan/mydiplomacy/type = 'union' and clan/mydiplomacy/state = 'proposal' and clan/mydiplomacy/clan1 != player/clan">
                                                <p><b>Этот клан предложил вам заключить союз</b>. Принять или отклонить предложение можно в разделе
                                                <a href="/clan/profile/diplomacy/">Дипломатия</a>.</p>
                                            </xsl:when>
                                            <xsl:when test="myclan/war = 1">
                                                <p><b>Ваш клан находится в состоянии войны</b>. Вы не можете заключать союзы до окончания боевых действий.</p>
                                            </xsl:when>
                                            <xsl:when test="myclan/defence = 0">
                                                <p><b>Ваш клан не может заключать союзы</b>. Чтобы получить возможность заключения союзов, необходимо увеличть защиту клана до 1.
                                                Чтобы увеличить защиту клана до 1, нужно купить в магазине в клановом отделе знак СТОП.</p>
                                            </xsl:when>
                                            <xsl:when test="clan/defence = 0">
                                                <p>Этот клан не может заключать союзы.</p>
                                            </xsl:when>
                                            <xsl:when test="myclan/unions = 2">
                                                <p><b>Вы не можете заключить еще один союз</b>. Вы уже заключили два союза.</p>
                                            </xsl:when>
                                            <xsl:when test="clan/unions = 2">
                                                <p><b>Этот клан не может заключить с вами союз</b>. Он уже заключил два союза.</p>
                                            </xsl:when>
                                            <xsl:otherwise>
                                                <div class="button">
                                                    <a class="f" href="#" onclick="clanDiplomacyExt({clan/id}, 'union_propose');"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Предложить союз - <span class="tugriki"><i></i></span>
                                                            <span class="ruda"><xsl:value-of select="number(myclan/unions)+1" />00<i></i></span> или <span class="med"><xsl:value-of select="number(myclan/unions)+1" />00<i></i></span></div>
                                                    </a>
                                                </div>
                                                <xsl:if test="clan/war = 1">
                                                    <p><b>Клан находится в состоянии войны</b>. Глава клана не сможет принять Ваше предложение до окончания боевых действий.</p>
                                                </xsl:if>
                                                <p><b>Внимание!</b> Плата за предложение заключить союз взымается в фонд города, а не главе клана.
                                                При отклонении Вашего предложения стоимость заявки <u>НЕ возвращается</u>.
                                                Поэтому перед предложением обговорите заключение союза с главой этого клана.</p>
                                                <p>Одновременно можно заключить не более двух союзов.</p>
                                            </xsl:otherwise>
                                        </xsl:choose>
                                    </xsl:when>
                                    
                                    <xsl:when test="player/clan != clan/id and player/clan != 0 and player/fraction != clan/fraction">
                                        <xsl:choose>
                                            <xsl:when test="clan/mydiplomacy/type = 'war' and (clan/mydiplomacy/state = 'paused' or clan/mydiplomacy/state = 'step1' or clan/mydiplomacy/state = 'step2')">
                                                <p><b>Вы ведете ожесточенные боевые действия с этим кланом</b>. Текущий этап войны: <xsl:choose>
                                                    <xsl:when test="clan/mydiplomacy/state = 'paused'"><a href="/faq/war/#paused">24 часа на подготовку к войне</a></xsl:when>
                                                    <xsl:when test="clan/mydiplomacy/state = 'step1'"><a href="/faq/war/#step1">первый этап</a></xsl:when>
                                                    <xsl:when test="clan/mydiplomacy/state = 'step2'"><a href="/faq/war/#step2">второй этап</a></xsl:when>
                                                </xsl:choose>.</p>
                                                <p>Узнать больше о похождениях Вашего клана можно в разделе <a href="/clan/profile/diplomacy/">Дипломатия</a>.</p>
                                            </xsl:when>
                                            <xsl:when test="myclan/war = 1">
                                                <p><b>Ваш клан находится в состоянии войны</b>. Вы не можете развязать еще одну войну до окончания боевых действий.</p>
                                                <p>Узнать больше о похождениях Вашего клана можно в разделе <a href="/clan/profile/diplomacy/">Дипломатия</a>.</p>
                                            </xsl:when>
                                            <xsl:when test="myclan/attack = 0">
                                                <p><b>Ваш клан не может объявлять войну</b>. Чтобы получить возможность объявления войны, необходимо увеличть атаку клана до 1.
                                                Чтобы увеличить атаку клана до 1, нужно купить в магазине, в <a href="/shop/section/clan/">клановом отделе</a>, <b>Шкетов</b>.</p>
                                            </xsl:when>
                                            <xsl:otherwise>
												<xsl:if test="count(clan/wartimeout) > 0 and clan/war = 0 and clan/state != 'war'">
													<xsl:if test="clan/defencedt">
														<p>На этот клан можно будет напасть <b><xsl:value-of select="clan/defencedt" /></b>.</p>
													</xsl:if>
													<xsl:if test="clan/attackdt">
														<p>Этот клан сможет напасть <b><xsl:value-of select="clan/attackdt" /></b>.</p>
													</xsl:if>
												</xsl:if>
                                                <xsl:choose>
                                                    <xsl:when test="clan/war = 0">
                                                        <xsl:choose>
                                                            <xsl:when test="clan/wartimeout = 1">
                                                                <p><b>Сейчас нельзя напасть на этот клан</b>. Клан отдыхает после предыдущей войны.</p>
                                                            </xsl:when>
                                                            <xsl:when test="clan/wartimeout = 3">
                                                                <p><b>Сейчас нельзя напасть на этот клан</b>. Клан отдыхает после предыдущей войны с Вашим кланом. Повторная война
                                                                с этим кланом возможна только через 4 дня после завершения предыдущей.</p>
                                                            </xsl:when>
                                                            <xsl:when test="clan/wartimeout = 2">
                                                                <p><b>Сейчас нельзя напасть на этот клан</b>. Клан еще не успел окрепнуть после создания.</p>
                                                            </xsl:when>
															<xsl:when test="myclan/can_attack = 0">
																<p><b>Сейчас ваш клан не может напасть на этот клан</b>. Ваш клан отдыхает после предыдущей войны.</p>
															</xsl:when>
                                                            <xsl:when test="/data/diplomat = 1">
                                                                <div class="button">
                                                                    <a class="f" href="#" onclick="clanDiplomacyExt({clan/id}, 'attack');"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                        <div class="c">Объявить войну (10% казны противника) -
                                                                            <span class="tugriki"><xsl:value-of select="round(clan/money div 10)" /><i></i></span>
                                                                            <span class="ruda"><xsl:value-of select="round(clan/ore div 10)" /><i></i></span>
                                                                            <span class="med"><xsl:value-of select="round(clan/honey div 10)" /><i></i></span></div>
                                                                    </a>
                                                                </div>
                                                                <p>В случае победы вы получите 30% от казны противника (сумма рассчитывается на момент объявления войны).</p>
                                                            </xsl:when>
                                                        </xsl:choose>
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        <p><b>Клан уже находится в состоянии войны</b>. Вы не можете напасть на него до окончания боевых действий.</p>
                                                    </xsl:otherwise>
                                                </xsl:choose>
                                            </xsl:otherwise>
                                        </xsl:choose>
                                    </xsl:when>

									<xsl:when test="player/clan_status = 'recruit'">
                                        <p>Вы уже подали заявку на вступление в <a href="/clan/{player/clan}/">другой клан</a>. Если вы хотите вступить в этот клан, то отмените сначала предыдущую заявку.</p>
                                    </xsl:when>
                                    
                                    <xsl:when test="player/clan = 0">
                                        <div class="button">
                                            <a class="f" href="#" onclick="clanDiplomacyExt({clan/id}, 'apply');"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                <div class="c">Подать заявку на вступление <xsl:call-template name="showprice"><xsl:with-param name="ore" select="'5'" /></xsl:call-template></div>
                                            </a>
                                        </div>
                                        <xsl:if test="clan/war = 1">
                                            <p><b>Клан находится в состоянии войны</b>. Глава клана не сможет одобрить Вашу заявку до окончания боевых действий.</p>
                                        </xsl:if>
                                        <p><b>Внимание!</b> Плата за подачу заявки на вступление взымается в фонд города, а не главе клана.
                                        При отклонении Вашей заявки главой клана вступительный взнос <u>НЕ возвращается</u>.
                                        Поэтому перед подачей заявки обговорите свое вступление в клан с его главой.</p>
                                    </xsl:when>
                                </xsl:choose>
                            </div>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                    <xsl:if test="clan/info != ''">
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <h3>Легенда</h3>
                            <div class="clan-legend">
                                <xsl:value-of select="clan/info" disable-output-escaping="yes" />
                            </div>
                        </div>
                    </xsl:if>
                </div>
            </div>
        </div>
	</xsl:template>
</xsl:stylesheet>
