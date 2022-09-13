<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

	<xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/item.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Клановый склад
                </h2></div>
                <div id="content" class="clan">

                    <div class="clan-store-about">

                        <ul class="objects">
                            <li class="object object-current">
                                <div class="data">
                                    <div class="text" style="width:100%">
                                        Закон сохранения материи — это, когда на склад поступает товара больше, чем уходит. Забрать товар со склада может любой кланер, а закупить может только глава из специального отдела в Торговом центре. В этом отделе продаются специфичные предметы, которые не представлены на полках обычных магазинов.
                                    </div>
                                    <div class="characteristics">
                                        <b>Вместимость слотов: <xsl:value-of select="capacity" /></b>
                                    </div>
                                    <xsl:if test="/data/money = 1 and capacity > 0">
                                        <form action="/clan/profile/warehouse/upgrade/" method="post">
                                            <input type="hidden" name="upgrade" value="1" />
                                            <div class="actions">
                                                <button class="button" type="submit"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                <div class="c">Увеличить на единицу — <span class="tugriki">10,000<i></i></span><span class="ruda">100<i></i></span>(или <span class="med">100<i></i></span>)
                                                </div></span></button>
												<div class="hint" style="font-size:90%; margin:5px 0 -2px 0;">Улучшения склада не могут быть разрушены<br />при поражении в войне.</div>
                                            </div>
                                        </form>
                                    </xsl:if>
                                    <i class="thumb"><img src="/@/images/obj/clan5.png" alt="" title="" /></i>
                                </div>
                            </li>
                        </ul>

                    </div>

                    <xsl:choose>
                        <xsl:when test="capacity > 0">
                            <table class="clan-store">
                                <tr>
                                    <td class="store-cell" style="width:50%; padding:0 5px 0 0;">
                                        <div style="width:312px;float:left;">
                                            <dl id="store-accordion" class="vtabs">
                                                <dt class="selected active"><div><div>Склад (<xsl:value-of select="amount" />/<xsl:value-of select="capacity" />)</div></div></dt>
                                                <dd>
                                                    <div class="object-thumbs">
                                                        <xsl:choose>
                                                            <xsl:when test="count(inventory/element) > 0">
                                                                <xsl:for-each select="inventory/element">
                                                                    <xsl:choose>
                                                                        <xsl:when test="code != ''">
                                                                            <div class="object-thumb">
																				<div class="padding">
	                                                                                <img src="/@/images/obj/{image}" title="{name}||{info}|||" tooltip="1" />
	                                                                                <xsl:if test="stackable = 1">
	                                                                                    <div class="count">#<xsl:value-of select="durability" /></div>
	                                                                                </xsl:if>
	                                                                                <div class="mf">*</div>
	                                                                                <div class="action" onclick="clanWarehouseTake({id},'{code}');"><span>забрать</span></div>
																				</div>
                                                                            </div>
                                                                        </xsl:when>
                                                                        <xsl:otherwise>
                                                                            <img src="/@/images/ico/gift.png" />
                                                                        </xsl:otherwise>
                                                                    </xsl:choose>
                                                                </xsl:for-each>
                                                            </xsl:when>
                                                            <xsl:otherwise>

                                                            </xsl:otherwise>
                                                        </xsl:choose>
                                                    </div>
                                                    <div class="hint">
                                                        Товары на склад закупает Глава из <a href="/shop/section/clan/">торгового центра</a>.
                                                        Пополните казну и попросите его провести закупки.
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>
                                    </td>

                                    <td class="store-cell" style="width:50%; padding:0 0 0 5px;">
                                        <div style="width:312px; float:right;">
                                            <dl id="store-accordion" class="vtabs">
                                                <dt class="selected active"><div><div>Моё, взятое со склада (Инвентарь: <xsl:value-of select="/data/player/amount" />/<xsl:value-of select="/data/player/capacity" />)</div></div></dt>
                                                <dd>
                                                    <div class="object-thumbs">
                                                        <xsl:choose>
                                                            <xsl:when test="count(inventory2/element) > 0">
                                                                <xsl:for-each select="inventory2/element">
                                                                    <xsl:choose>
                                                                        <xsl:when test="code != ''">
                                                                            <div class="object-thumb">
																				<div class="padding">
                                                                                    <img src="/@/images/obj/{image}" title="{name}||{info}|||" tooltip="1" />
	                                                                                <xsl:if test="stackable = 1">
	                                                                                    <div class="count">#<xsl:value-of select="durability" /></div>
	                                                                                </xsl:if>
	                                                                                <div class="mf">*</div>
	                                                                                <div class="action" onclick="clanWarehousePut({id},'{code}');"><span>вернуть</span></div>
																				</div>
                                                                            </div>
                                                                        </xsl:when>
                                                                        <xsl:otherwise>
                                                                            <img src="/@/images/ico/gift.png" />
                                                                        </xsl:otherwise>
                                                                    </xsl:choose>
                                                                </xsl:for-each>
                                                            </xsl:when>
                                                            <xsl:otherwise>

                                                            </xsl:otherwise>
                                                        </xsl:choose>
                                                    </div>
                                                    <div class="hint">
                                                        Помните, что вы не один в клане.<br />Верните на склад, если взяли что-то лишнее.
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </xsl:when>
                        <xsl:otherwise>
                            <div class="block-bordered">
                                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                <div class="center clear">
                                    <h3>На этом месте когда-нибудь будет построен склад</h3>
                                    <div class="clan-store-logs phone">
                                        <p>У Вашего клана еще нет своего склада. Но ваш глава может купить его в <a href="/shop/section/clan/">торговом центре</a>.</p>
                                    </div>
                                </div>
                                <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                            </div>
                        </xsl:otherwise>
                    </xsl:choose>

                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3>Последние посетители склада</h3>
                            <div class="clan-store-logs phone">
                                <p>К сожалению или счастью, сторож склада страдает бессонницей, и записывает всех, кто приходит на склад и отоваривается.</p>
                                <table class="messages-list">
                                    <xsl:choose>
                                        <xsl:when test="count(log/element) > 0">
                                            <xsl:for-each select="log/element">
                                                <tr>
                                                    <td class="date">
                                                        <xsl:value-of select="dt" />
                                                    </td>
                                                    <td class="text">
                                                        <xsl:call-template name="playerlink">
                                                            <xsl:with-param name="player" select="params/p" />
                                                        </xsl:call-template> &#0160; <xsl:choose>
                                                            <xsl:when test="action = 'take'">взял со склада <b><xsl:value-of select="params/i" /></b>.</xsl:when>
                                                            <xsl:when test="action = 'put'">вернул на склад <b><xsl:value-of select="params/i" /></b>.</xsl:when>
                                                        </xsl:choose>
                                                    </td>
                                                    <td class="actions">
                                                        <!--span class="button">
                                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                <div class="c">Написать</div>
                                                            </span>
                                                        </span-->
                                                    </td>
                                                </tr>
                                            </xsl:for-each>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <p>На складе тихо и спокойно. И коробки на полках покрыты толстым слоем пыли.</p>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </table>

                                <p>Попросить у сторожа <a href="/clan/profile/logs/">амбарную книгу</a> и углубиться в чтение.</p>
                            </div>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                </div>
            </div>
        </div>
	</xsl:template>

</xsl:stylesheet>