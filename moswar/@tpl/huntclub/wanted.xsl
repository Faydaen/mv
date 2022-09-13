<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/paginator.xsl" />

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
                            </div>
                        </div>
						<div class="goback">
							<span class="arrow">◄</span><a href="/huntclub/">Выйти в холл</a>
						</div>
                    </div>

                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3>Внимание, розыск!</h3>
                            <div class="hunting-wanted">
								<!--div class="hunting-wanted-random">
									Устав искать лакомую дичь, вы решили наброситься на первого попавшегося
									<div style="margin:5px 0 0 0;">
										<div class="button">
											<a class="f" href="#" onclick="alleyAttack(0);return false;"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Мне повезёт</div>
											</a>
										</div>
									</div>
								</div-->
								
								<p class="hint" style="margin-top:5px;">Каждый охотник видит только свой список жертв, в диапазоне [-1,+2] уровень. Помимо денежной награды за каждое заказное убийство охотники получают <span class="badge">1, 3, 5 или 7<i></i></span> — в зависимости от уровня противника. Также есть шанс отнять в бою <span class="mobila">Мобилу<i></i></span> жертвы.<br/><span class="badge">Жетоны</span> и <span class="mobila">Мобилы</span> принимаются в магазине &#0171;<a href="/berezka/">Березка</a>&#0187;.
                                    Беритесь за оружие и вперед!
                                </p>

                                <table class="list">
                                    <tr>
                                        <th colspan="6" class="options">
                                            <form>
												<xsl:if test="werewolf_can = 1">
													<div class="executor-choose">
													<xsl:choose>
														<xsl:when test="werewolf = 1">
															<input name="executor" type="radio" id="hunting-wanted-self" onclick="document.location.href=document.location.href.replace('werewolf/','');" /><label for="hunting-wanted-self">Показывать жертв для себя</label><br />
															<input name="executor" type="radio" checked="checked" id="hunting-wanted-werewolf" /><label for="hunting-wanted-werewolf">Показывать жертв для <i class="npc-werewolf" title="Оборотень"></i><b>оборотня [<xsl:value-of select="werewolf_level" />]</b></label>
														</xsl:when>
														<xsl:otherwise>
															<input name="executor" type="radio" checked="checked" id="hunting-wanted-self" /><label for="hunting-wanted-self">Показывать жертв для себя</label><br />
															<input name="executor" type="radio" id="hunting-wanted-werewolf" onclick="document.location.href=document.location.href.replace('werewolf/','') + 'werewolf/';" /><label for="hunting-wanted-werewolf">Показывать жертв для <i class="npc-werewolf" title="Оборотень"></i><b>оборотня[<xsl:value-of select="werewolf_level" />]</b></label>
														</xsl:otherwise>
													</xsl:choose>
													</div>
												</xsl:if>
                                                <xsl:choose>
                                                    <xsl:when test="levelfilter = 1">
                                                        <input type="checkbox" checked="checked" id="hunting-wanted-showmyvictims" onclick="document.location.href=document.location.href.replace(/level\/[a-z]+\//, '') + 'level/all/';" /><label for="hunting-wanted-showmyvictims">Показывать жертв только равного уровня</label>
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        <input type="checkbox" id="hunting-wanted-showmyvictims" onclick="document.location.href=document.location.href.replace(/level\/[a-z]+\//, '') + 'level/my/';" /><label for="hunting-wanted-showmyvictims">Показывать жертв только равного уровня</label>
                                                    </xsl:otherwise>
                                                </xsl:choose>

                                            </form>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Имя</th>
                                        <th>Причина</th>
                                        <th class="value{cursort_award}"><a href="#" onclick="document.location.href=document.location.href.replace(/sort\/[a-z]+\//, '') + 'sort/award/';return false;">Награда</a><xsl:if test="cursort_award != ''"> &#9660;</xsl:if></th>
                                        <th class="date{cursort_dt}"><a href="#" onclick="document.location.href=document.location.href.replace(/sort\/[a-z]+\//, '') + 'sort/dt/';return false;">Добавлен</a><xsl:if test="cursort_dt != ''"> &#9660;</xsl:if></th>
                                        <th class="action"></th>
                                        <!--&#9660;  &#9650; -->
                                    </tr>
                                    <xsl:choose>
                                        <xsl:when test="count(wanted/element) > 0">
                                            <xsl:for-each select="wanted/element">
                                                <tr>
                                                    <td class="name"><xsl:call-template name="playerlink"><xsl:with-param name="player" select="current()" /></xsl:call-template></td>
                                                    <td id="comment{hunt}">
                                                        <xsl:value-of select="comment" />
                                                        <xsl:if test="/data/censor = 1 and comment != ''">
                                                            <div><span class="dashedlink" onclick="huntclubClearComment({hunt});">очистить комментарий</span></div>
                                                        </xsl:if>
                                                    </td>
                                                    <td class="value">
                                                        <span class="tugriki"><xsl:value-of select="format-number(award, '###,###,###')" /><i></i></span>
                                                        <xsl:if test="xmoney = 2"><br />Удвоенный грабеж</xsl:if>
                                                    </td>
                                                    <td class="date"><xsl:value-of select="dt" /></td>
                                                    <td class="action">
                                                        <xsl:choose>
                                                            <xsl:when test="state = 1">
                                                                <div class="button">
                                                                    <a class="f" href="#" onclick="alleyAttack({id});return false;"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                        <div class="c">Атаковать</div>
                                                                    </a>
                                                                </div>
                                                            </xsl:when>
                                                            <xsl:otherwise><div class="wait">заказ в обработке</div></xsl:otherwise>
                                                        </xsl:choose>
                                                    </td>
                                                </tr>
                                            </xsl:for-each>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <tr>
                                                <td style="text-align:center;" colspan="5">Подходящих для вас заказов нет.</td>
                                            </tr>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </table>

                                <xsl:call-template name="paginator">
                                    <xsl:with-param name="pages" select="pages" />
                                    <xsl:with-param name="page" select="page" />
                                    <xsl:with-param name="link" select="concat('/huntclub/wanted', link, '/page/')" />
                                </xsl:call-template>

                            </div>

                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                </div>
            </div>

        </div>
    </xsl:template>

</xsl:stylesheet>