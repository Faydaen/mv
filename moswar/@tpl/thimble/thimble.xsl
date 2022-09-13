<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2><span class="thimble"></span></h2></div>
                <div id="content" class="thimble clear">

                    <div class="welcome">
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <img class="avatar-back-5" src="/@/images/pers/man100.png" />
                            <div class="say">
                                — Кручу-верчу, запутать хочу! Кто смотрит внимательно, угадает обязательно!
                            </div>
                        </div>
                    </div>

                    <div class="thimble-choose">
                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">

                                <xsl:if test="naperstki = 1">
                                    <p>
                                        Уличный наперсточник <b>Моня Шац</b> порой не прочь подурить честных игроков.
                                        Сыграйте с ним и попытайте <span class="ruda"><i></i>счастье</span>,
                                        если конечно у вас есть <span class="tugriki"><i></i>наличность</span>.
                                    </p>
                                </xsl:if>

                                <xsl:if test="naperstki != 1">
                                    <div align="center">
                                        <xsl:if test="naperstkidata/c = 2">
                                            <p>Угадай <i>с одного раза</i>, где скрыта <span class="ruda">1<i></i></span>, и получи ее.</p>
                                        </xsl:if>

                                        <xsl:if test="naperstkidata/c = 9">
                                            <p>Под девятью наперстками скрыто <span class="ruda">6<i></i></span>.<br />Выбери 3 наперстка, и получи <span class="ruda">отгаданное<i></i></span>.</p>
                                        </xsl:if>

                                        <p class="thimbles">
                                            <xsl:for-each select="naperstkidata/d/element">
                                                <xsl:choose>
                                                    <xsl:when test="current() = '0'">
                                                        <i id="thimble{position() - 1}" class="icon thimble-closed-active" onclick="document.location.href='/thimble/guess/' + {position() - 1} + '/';"></i>
                                                    </xsl:when>
                                                    <xsl:when test="current() = '1'"><i id="thimble{position() - 1}" class="icon thimble-closed"></i></xsl:when>
                                                    <xsl:when test="current() = '2'"><i id="thimble{position() - 1}" class="icon thimble-guessed"></i></xsl:when>
                                                    <xsl:when test="current() = '3'"><i id="thimble{position() - 1}" class="icon thimble-empty"></i></xsl:when>
                                                </xsl:choose>
                                                <xsl:if test="(position() = 3 or position() = 6) and /data/naperstkidata/c = 9"><br /></xsl:if>
                                            </xsl:for-each>
                                        </p>

                                        <p class="results">
                                            Осталось попыток: <span id="naperstki-left"><xsl:value-of select="naperstkidata/left" /></span><br />
                                            Угадано: <span class="ruda" id="naperstki-ruda"><xsl:value-of select="naperstkidata/r" /><i></i></span>
                                        </p>
										<br/>
										<p class="hint">Для того, чтобы сыграть — нажми на один из напёрстков!</p>
                                    </div>
                                </xsl:if>

                                <xsl:if test="naperstki != 2">
                                    <div align="center" style="margin-bottom:5px">
                                        <p>
                                            <div class="button" style="margin:5px">
                                                <a href="/thimble/play/2/" class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Два наперстка — <span class="tugriki">500<i></i></span></div>
                                                </a>
                                            </div>
                                            &#0160;
                                            <div class="button" style="margin:5px">
                                                <a href="/thimble/play/9/" class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Девять наперстков — <span class="tugriki">1,500<i></i></span></div>
                                                </a>
                                            </div>
                                        </p>
                                        <p>
                                            <div class="button">
                                                <a href="/thimble/leave/" class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Я наигрался, хватит</div>
                                                </a>
                                            </div>
                                        </p>
                                    </div>
                                </xsl:if>
                            </div>
							<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>