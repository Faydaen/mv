<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="sovet/menu1.xsl" />
    <xsl:include href="sovet/menu2.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Кабинет главы Совета
                </h2></div>
                <div id="content" class="council">

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
                        <xsl:with-param name="page" select="'glava'" />
                        <xsl:with-param name="council" select="council" />
                    </xsl:call-template>

                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3>Обращение к своим</h3>
                            <form class="council-speach" action="/sovet/glava-text/fraction/" method="post">
                                <textarea name="fraction"><xsl:value-of select="textfraction" /></textarea>
                                <div align="center">
                                    <button class="button" type="submit">
                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                            <div class="c">Сохранить</div>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>
                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3>Обращение к противникам</h3>
                            <form class="council-speach" action="/sovet/glava-text/enemy/" method="post">
                                <textarea name="enemy"><xsl:value-of select="textenemy" /></textarea>
                                <div align="center">
                                    <button class="button" type="submit">
                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                            <div class="c">Сохранить</div>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>
                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3>Обращение к членам совета</h3>
                            <form class="council-speach" action="/sovet/glava-text/sovet/" method="post">
                                <textarea name="sovet"><xsl:value-of select="textsovet" /></textarea>
                                <div align="center">
                                    <button class="button" type="submit">
                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                            <div class="c">Сохранить</div>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                </div>
            </div>

        </div>
    </xsl:template>

</xsl:stylesheet>