<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/item.xsl" />
    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="sovet/menu1.xsl" />
    <xsl:include href="sovet/menu2.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Магазин усилений Совета
                </h2></div>
                <div id="content" class="shop council">

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
                        <xsl:with-param name="page" select="'boosts'" />
                        <xsl:with-param name="council" select="council" />
                    </xsl:call-template>

                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3>Усиление всех сторонников</h3>
                            <div class="council-affects">
                                <div style="float:left; width:45%;">
                                    <p>
                                        Грамотно управляя усилением своей стороны, можно влиять на исход множества дуэлей между противниками.
                                        Таким образом, правильнее всего включать усиления в четверг и пятницу, во время драк с противником.
                                    </p>
                                </div>
                                <div style="float:right; width:45%;">
                                    <p>
                                        Предложить купить усиление может любой из членов совета. После этого будет запущено голосование.
                                        Как только <xsl:value-of select="boostvotes" /> советников одобрят покупку, она будет совершена.
                                        Если же <xsl:value-of select="boostvotes" /> советников выскажутся против, то усиление куплено не будет.
                                    </p>
                                    <p class="borderdata">
                                        Казна совета: <span class="tugriki"><xsl:value-of select="format-number(kazna, '###,###,###,###')" /><i></i></span><br />
                                        <xsl:if test="kazna2 > 0">
                                            Зарезервировано на время голосования: <span class="tugriki"><xsl:value-of select="format-number(kazna2, '###,###,###')" /><i></i></span>
                                        </xsl:if>
                                    </p>
                                </div>
                            </div>

                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                    <xsl:if test="count(votes) > 0">
                        <div class="block-bordered block-bordered-attention">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>Члены совета предлагают усилиться</h3>
                                <div class="council-affects-offer">
                                    <ul class="objects">
                                        <xsl:for-each select="votes/element">
                                            <a name="vote{id}"></a>
                                            <li class="object" style="font-size:100%;">
                                                <h2><xsl:value-of select="name" /></h2>
                                                <div class="data">
                                                    <div class="text">
                                                        <h4>Описание</h4>
                                                        <xsl:value-of select="info" />
                                                    </div>
                                                    <div class="characteristics">
                                                        <h4 style="display:inline;">Воздействия</h4>
                                                        <xsl:call-template name="item-params"><xsl:with-param name="item" select="current()" /></xsl:call-template>
                                                    </div>
                                                    <i class="thumb"><img src="/@/images/obj/perks/{image}" alt="" title="" /></i>
                                                    <div class="actions">
                                                        <p>
                                                            Советник <xsl:call-template name="playerlink"><xsl:with-param name="player" select="player" /></xsl:call-template>
                                                            предложил воспользоваться этим усилением<br />
                                                            Для принятия или отказа необходимо набрать <xsl:value-of select="/data/boostvotes" /> голосов 
                                                            <span class="time" timer="{timeleft2}"><xsl:value-of select="timeleft" /></span><br />
															<xsl:if test="params/x = 2">Внимание! Эффект и цена удвоены</xsl:if>
                                                        </p>

                                                        <p>Поддержали:
															<xsl:for-each select="voted/yes/element">
																<xsl:call-template name="playerlink"><xsl:with-param name="player" select="current()" /></xsl:call-template>
																<xsl:if test="position() != last()">, </xsl:if>
															</xsl:for-each>
														<br />Против:
															<xsl:choose>
																<xsl:when test="count(voted/no/element) = 0">
																	<em>нет</em>
																</xsl:when>
																<xsl:otherwise>
																	<xsl:for-each select="voted/no/element">
																		<xsl:call-template name="playerlink"><xsl:with-param name="player" select="current()" /></xsl:call-template>
																		<xsl:if test="position() != last()">, </xsl:if>
																	</xsl:for-each>
																</xsl:otherwise>
															</xsl:choose>
														</p>

														<xsl:if test="voted/me = 0">
															<form method="post" action="/sovet/vote-boost/" style="display:inline;">
																<input type="hidden" name="boost" value="{id}" />
																<input type="hidden" name="vote" value="yes" />
																<button type="submit" class="button" rel="buy">
																	<span class="f" onclick=""><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																		<div class="c">Поддерживаю (<xsl:value-of select="count(voted/yes/element)" />)</div>
																	</span>
																</button>
															</form>
															&#0160;
															<form method="post" action="/sovet/vote-boost/" style="display:inline;">
																<input type="hidden" name="boost" value="{id}" />
																<input type="hidden" name="vote" value="no" />
																<button type="submit" class="button" rel="buy">
																	<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																		<div class="c">Против (<xsl:value-of select="count(voted/no/element)" />)</div>
																	</span>
																</button>
															</form>
                                                        </xsl:if>
                                                    </div>
                                                </div>
                                            </li>
                                        </xsl:for-each>
                                    </ul>
                                </div>

                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </xsl:if>

                    <ul class="objects">
                        <xsl:for-each select="boosts/element">
                            <li class="object">
                                <h2><xsl:value-of select="name" /></h2>
                                <div class="data">
                                    <div class="text">
                                        <h4>Описание</h4>
                                        <xsl:value-of select="info" />
                                    </div>
                                    <div class="characteristics" id="chars-{id}">
                                        <h4 style="display:inline;">Воздействия</h4>
                                        <xsl:call-template name="item-params"><xsl:with-param name="item" select="current()" /></xsl:call-template>
                                    </div>
                                    <i class="thumb"><img src="/@/images/obj/perks/{image}" alt="{name}" title="{name}" /></i>
                                    <div class="actions">
                                        <form action="/sovet/buy-boost/" method="post">
											<span class="option"><input type="checkbox" name="x2" id="x2-{id}" onclick="sovetBoostsX2(this, {id}, {special1});" /> <label for="x2-{id}">Удвоить шанс и цену</label></span>
                                            <input type="hidden" name="boost" value="{id}" />
                                            <button type="submit" class="button" rel="buy">
                                                <xsl:if test="/data/kazna &lt; money or disabled = 1">
                                                    <xsl:attribute name="disabled">disabled</xsl:attribute>
                                                    <xsl:attribute name="class">button disabled</xsl:attribute>
                                                </xsl:if>
                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                <div class="c">Предложить — <span class="tugriki" id="price-{id}"><xsl:value-of select="format-number(money, '###,###,###')" /><i></i></span></div>
                                            </span></button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </xsl:for-each>
                    </ul>

                </div>
            </div>

        </div>
    </xsl:template>

</xsl:stylesheet>