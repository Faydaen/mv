<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/price.xsl" />
    <xsl:include href="common/item.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    <span class="factory"></span>
                </h2></div>
                <div id="content" class="factory">

                    <div class="factory-mf-item">
					
						<div class="welcome">
	                        <div class="block-rounded">
	                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
	                            <div class="text">
	                                
	                            </div>
	                        </div>
							<div class="goback">
							    <span class="arrow">&#9668;</span>
								<a href="/factory/mf/">Отойти от аппарата</a>
							</div>
	                    </div>
                    
                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear" align="center">
                                <h3>Модификация предмета</h3>
                                <table class="progressbar" align="center">
                                    <tr>
                                        <td style="width:60%;">
                                            <ul class="stats">
                                                <li class="stat">
                                                    <div class="label">
                                                        <b>Уровень мф.</b><span class="num">[<xsl:value-of select="current/mf" />/<xsl:value-of select="maxlevel" />]</span>
                                                    </div>
                                                    <div class="bar"><div><div style="width:{percentlevel}%;" class="percent"></div></div></div>
                                                </li>
                                            </ul>
                                        </td>
                                        <td style="width:40%; text-align:left;">
                                            <xsl:if test="current/mf &lt; /data/maxlevel">
                                                <form action="/factory/mf-item/" method="post" align="center">
                                                    <input type="hidden" name="inventory" value="{current/id}" />
													<xsl:choose>
														<xsl:when test="using_cert_21 = 1">
															<img src="/@/images/obj/item19.png" align="left" /><span class="hint">Создать 21-ую модификацию, используя супер-инструменты.</span><br />
															<button class="button" type="submit"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Модифицировать
															</div></span></button>
														</xsl:when>
														<xsl:otherwise>
															<button class="button" type="submit"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Модифицировать —
																<span class="ruda"><xsl:value-of select="mfprice" /><i></i></span> или <span class="med"><xsl:value-of select="mfprice" /><i></i></span>
															</div></span></button>
														</xsl:otherwise>
													</xsl:choose>
													<xsl:if test="passatiji = 1">
														<div class="hint passatiji">
															<input id="factory-mf-passatiji-use" type="checkbox" name="passatiji" />
															<label for="factory-mf-passatiji-use"><img align="right" src="/@/images/obj/item9.png" />Хочу использовать пассатижи для наиболее качественной модификации</label>
														</div>
													</xsl:if>
                                                </form>
                                            </xsl:if>
                                            <xsl:if test="kupon = 1">
                                                <div class="hint">
													<b class="red">Скидка</b> при каждой модификации с использованием сертификата составляет <span class="ruda">1<i></i></span> 
												</div>
                                            </xsl:if>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>

                        <ul class="objects">
                            <li class="object object-current">
                                <h2><xsl:value-of select="current/name" /> [<xsl:value-of select="current/mf" />] <span class="hint">— сейчас</span></h2>
                                <div class="data">
                                    <div class="text">
                                        <h4>Описание</h4>
                                        <xsl:value-of select="current/info" />
                                    </div>
                                    <div class="characteristics">
<!--xsl:if test="count(current/effects/element) > 0">
<h4>Воздействия</h4>
<xsl:for-each select="current/effects/element">
    <xsl:choose>
        <xsl:when test="value != 0">
            <xsl:value-of select="param" />:
            <xsl:if test="value > 0 and value != '' and noplus = 0">+</xsl:if>
            <xsl:choose>
                <xsl:when test="../../type = 'tech' and position() = 1"><xsl:value-of select="value" />%</xsl:when>
                <xsl:when test="value &lt; 1 and value > -1"><xsl:value-of select="value * 1000" />%</xsl:when>
                <xsl:otherwise><xsl:value-of select="value" /></xsl:otherwise>
            </xsl:choose>
            <xsl:if test="current() != last ()">
                <br />
            </xsl:if>
        </xsl:when>
        <xsl:when test="param != ''">
            <xsl:value-of select="param" />
        </xsl:when>
    </xsl:choose>
</xsl:for-each>
</xsl:if-->
                                        <h4 style="display:inline;">Воздействия</h4>
                                        <xsl:call-template name="item-params"><xsl:with-param name="item" select="current" /></xsl:call-template>
                                        <xsl:if test="current/level != '' and current/level > 0">
                                            <h4>Требования</h4>
                                            Уровень: <xsl:value-of select="current/level" /><br />
                                        </xsl:if>
                                        <h4>Реальная стоимость</h4>
                                        Покупка: <xsl:call-template name="showprice">
                                            <xsl:with-param name="money" select="current/money" />
                                            <xsl:with-param name="ore" select="current/ore" />
                                            <xsl:with-param name="honey" select="current/honey" />
                                        </xsl:call-template><br />
                                        Продажа: <xsl:call-template name="showprice">
                                            <xsl:with-param name="nohoney" select="1" />
                                            <xsl:with-param name="money" select="current/sell/money" />
                                            <xsl:with-param name="ore" select="current/sell/ore" />
                                            <xsl:with-param name="honey" select="current/sell/honey" />
                                        </xsl:call-template><br />
                                    </div>
                                    <i class="thumb"><img src="/@/images/obj/{current/image}" alt="" title="" /></i>
                                </div>
                            </li>
                            <xsl:if test="current/mf &lt; /data/maxlevel">
                                <li class="object">
                                    <h2><xsl:value-of select="next/name" /> [<xsl:value-of select="next/mf" />] <span class="hint">— после модификации</span></h2>
                                    <div class="data">
                                        <div class="text">
                                            <h4>Описание</h4>
                                            <xsl:value-of select="next/info" />
                                        </div>
                                        <div class="characteristics">
    <!--xsl:if test="count(next/effects/element) > 0">
        <h4>Воздействия</h4>
        <xsl:for-each select="next/effects/element">
            <xsl:choose>
                <xsl:when test="value != 0">
                    <xsl:value-of select="param" />:
                    <xsl:if test="value > 0 and value != '' and noplus = 0">+</xsl:if>
                    <xsl:choose>
                        <xsl:when test="../../type = 'tech' and position() = 1"><xsl:value-of select="value" />%</xsl:when>
                        <xsl:when test="value &lt; 1 and value > -1"><xsl:value-of select="value * 1000" />%</xsl:when>
                        <xsl:otherwise><xsl:value-of select="value" /></xsl:otherwise>
                    </xsl:choose>
                    <xsl:if test="value2 != 0">
                        (до <xsl:if test="value2 > 0 and value2 != ''">+</xsl:if>
                        <xsl:choose>
                            <xsl:when test="value2 &lt; 1 and value2 > -1"><xsl:value-of select="value2 * 1000" />%</xsl:when>
                            <xsl:otherwise><xsl:value-of select="value2" /></xsl:otherwise>
                        </xsl:choose>)
                    </xsl:if>
                    <xsl:if test="current() != last ()">
                        <br />
                    </xsl:if>
                </xsl:when>
                <xsl:when test="param != ''">
                    <xsl:value-of select="param" />
                </xsl:when>
            </xsl:choose>
        </xsl:for-each>
    </xsl:if-->
                                            <h4 style="display:inline;">Воздействия</h4>
                                            <xsl:call-template name="item-params"><xsl:with-param name="item" select="next" /></xsl:call-template>
                                            <xsl:if test="next/level != '' and next/level > 0">
                                                <h4>Требования</h4>
                                                Уровень: <xsl:value-of select="next/level" /><br />
                                            </xsl:if>
                                            <h4>Реальная стоимость</h4>
                                            Покупка: <xsl:call-template name="showprice">
                                                <xsl:with-param name="money" select="next/money" />
                                                <xsl:with-param name="ore" select="next/ore" />
                                                <xsl:with-param name="honey" select="next/honey" />
                                            </xsl:call-template><br />
                                            Продажа: <xsl:call-template name="showprice">
                                                <xsl:with-param name="nohoney" select="1" />
                                                <xsl:with-param name="money" select="next/sell/money" />
                                                <xsl:with-param name="ore" select="next/sell/ore" />
                                                <xsl:with-param name="honey" select="next/sell/honey" />
                                            </xsl:call-template><br />
                                        </div>
                                        <i class="thumb"><img src="/@/images/obj/{next/image}" alt="" title="" /></i>
                                    </div>
                                </li>
                            </xsl:if>
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>