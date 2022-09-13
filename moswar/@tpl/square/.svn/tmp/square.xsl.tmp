<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
            <div class="heading clear">
                <h2>
                <span class="square"></span>
                </h2>
            </div>
            <div id="content" class="square">

                <table class="buttons">
                <tr>
                    <td>
                    <div class="button" id="square-shop-button">
                        <a class="f" href="/shop/">
                        <i class="rl"></i>
                        <i class="bl"></i>
                        <i class="brc"></i>
                        <div class="c">Торговый центр</div>
                        </a>
                    </div>
                    </td>
                    <td>
                    <div class="button" id="square-shaurburgers-button">
                        <a class="f" href="/shaurburgers/">
                        <i class="rl"></i>
                        <i class="bl"></i>
                        <i class="brc"></i>
                        <div class="c">Шаурбургерс</div>
                        </a>
                    </div>
                    </td>
                    <td>
                    <div class="button" id="square-nightclub-button">
                        <a class="f" href="/nightclub/">
                        <i class="rl"></i>
                        <i class="bl"></i>
                        <i class="brc"></i>
                        <div class="c">Клуб</div>
                        </a>
                    </div>
                    </td>
                    <td>
                    <div class="button" id="square-police-button">
                        <a class="f" href="/police/">
                        <i class="rl"></i>
                        <i class="bl"></i>
                        <i class="brc"></i>
                        <div class="c">Милиция</div>
                        </a>
                    </div>
                    </td>
                    <td>
                    <div class="button" id="square-metro-button">
                        <a class="f" href="/metro/">
                        <i class="rl"></i>
                        <i class="bl"></i>
                        <i class="brc"></i>
                        <div class="c">Метро</div>
                        </a>
                    </div>
                    </td>
                    <td>
                    <div class="button" id="square-factory-button">
                        <a class="f"  href="/factory/">
                        <i class="rl"></i>
                        <i class="bl"></i>
                        <i class="brc"></i>
                        <div class="c">Завод</div>
                        </a>
                    </div>
                    </td>
                </tr>
                </table>

                <div class="welcome">
                    <img style="bottom:0; left:267px; width:112px; height:106px; z-index:9;" src="/@/images/loc/square-ctulhu.png" />
                    <!-- <img style="bottom:0; left:258px; z-index:5; width:114px; height:160px;" src="/@/images/loc/square-firtree.png" /> -->
                    <a href="/shop/"><i id="square-shop-pic" title="Торговый центр"></i></a>
                    <a href="/shaurburgers/"><i id="square-shaurburgers-pic" title="Шаурбургерс"></i></a>
                    <a href="/nightclub/"><i id="square-nightclub-pic" title="Клуб"></i></a>
                    <a href="/police/"><i id="square-police-pic" title="Милиция"></i></a>
                    <a href="/metro/"><i id="square-metro-pic" title="Метро"></i></a>
                    <a href="/factory/"><i id="square-factory-pic" title="Завод"></i></a>
                </div>

                <h3 class="curves clear">
                    <table class="buttons">
                        <tr>
                            <td width="33%">
                                <div class="button" id="square-factory-button">
                                    <a class="f" href="/tverskaya/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">&#8592; Тверская</div>
                                    </a>
                                </div>
                            </td>
                            <td width="34%"></td>
                            <td width="33%">
                                <div class="button" id="square-factory-button">
                                    <a class="f" href="/arbat/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">Арбат &#8594;</div>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </h3>

                <div class="square-coolest">
                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">

                            <table>
                                <tr>
                                    <td style="width:50%; padding:0 5px 0 0;">
                                        <h3>Самый крутой игрок</h3>
                                        <div class="square-coolest-player">
                                            <p>Перед вами человек-пароход, гроза закоулков и зубодробилка во всех войнах. </p>

                                            <div class="user-card clear">
                                                <img src="{best/avatar}" class="avatar" />
                                                <xsl:call-template name="playerlink"><xsl:with-param name="player" select="best" /></xsl:call-template>
                                                <!--p class="slogan"><b>Крутость: </b><xsl:value-of select="best/statsum2" /></p-->
                                                <xsl:if test="best/slogan != ''"><p class="slogan"><b>Девиз: </b><xsl:value-of select="best/slogan" /></p></xsl:if>
                                                <p class="slogan"><b>Был самым крутым: </b><xsl:value-of select="best/toptime" /></p>
                                            </div>

                                            <!--p>За убийство самого крутого можно получить <span class="expa"><i></i>тройной опыт</span>.</p-->
                                            <p class="hint">Самым крутым является игрок с наибольшим количеством статов с учетом одежды, подарков, регалий, допингов и рейтингов. Данные очень стараются обновляться раз в 15 минут.</p>
                                        </div>

                                    </td>
                                    <td style="width:50%; padding:0 0 0 5px;">

                                        <h3>Самые крутые по уровням</h3>
                                        <div class="square-coolest-levels">

                                            <p>Эти люди — гордость столицы. На них молятся, их боятся и уважают.<!-- За убийство крутых игроков можно получить <span class="expa"><i></i>двойной опыт</span>.--></p>

                                            <table class="list">
                                                <tr>
                                                    <th class="level"></th>
                                                    <th>Игрок</th>
                                                    <th class="stats">Крутость</th>
                                                </tr>
                                                <xsl:for-each select="top/element">
                                                    <tr>
                                                        <td class="level"><xsl:value-of select="level" />.</td>
                                                        <td>
                                                            <xsl:call-template name="playerlink"><xsl:with-param name="player" select="current()" /></xsl:call-template>
                                                        </td>
                                                        <td class="stats"><xsl:value-of select="format-number(statsum2, '###,###')" /></td>
                                                    </tr>
                                                </xsl:for-each>
                                            </table>

                                        </div>

                                    </td>
                                </tr>
                            </table>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>
                </div>

                <script type="text/javascript">
                    $("#square-shop-button").bind("mouseover",function(){ $("#square-shop-pic").addClass("hover"); });
                    $("#square-shop-button").bind("mouseout",function(){ $("#square-shop-pic").removeClass("hover"); });
                    $("#square-shaurburgers-button").bind("mouseover",function(){ $("#square-shaurburgers-pic").addClass("hover"); });
                    $("#square-shaurburgers-button").bind("mouseout",function(){ $("#square-shaurburgers-pic").removeClass("hover"); });
                    $("#square-nightclub-button").bind("mouseover",function(){ $("#square-nightclub-pic").addClass("hover"); });
                    $("#square-nightclub-button").bind("mouseout",function(){ $("#square-nightclub-pic").removeClass("hover"); });
                    $("#square-police-button").bind("mouseover",function(){ $("#square-police-pic").addClass("hover"); });
                    $("#square-police-button").bind("mouseout",function(){ $("#square-police-pic").removeClass("hover"); });
                    $("#square-metro-button").bind("mouseover",function(){ $("#square-metro-pic").addClass("hover"); });
                    $("#square-metro-button").bind("mouseout",function(){ $("#square-metro-pic").removeClass("hover"); });
                    $("#square-factory-button").bind("mouseover",function(){ $("#square-factory-pic").addClass("hover"); });
                    $("#square-factory-button").bind("mouseout",function(){ $("#square-factory-pic").removeClass("hover"); });
                </script>

            </div>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>