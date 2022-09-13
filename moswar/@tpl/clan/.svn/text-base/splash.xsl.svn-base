<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    <span class="clan"></span>
                </h2></div>
                <div id="content" class="clan">

                    <div class="welcome">
                        <i class="emblem">
                            <a href="/rating/clans/"><img style="margin:8px 0 2px 0" src="/@/images/ico/star.png" /><br />Рейтинг кланов</a>
                        </i>
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="text">

                                <xsl:choose>
                                    <xsl:when test="player/level &lt; 4">
                                        <p>Ты — одиночка. Никто за тебя не отомстит, никто тебе не поможет.
                                        <br />Приходи, когда дорастешь до 6-го уровня.</p>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <p>Ты — одиночка. Никто за тебя не отомстит, никто тебе не поможет.
                                        <br />Найди себе семью или построй свой синдикат.</p>
                                        <div style="text-align:center;">
                                            <div class="button">
                                                <a class="f" href="/rating/clans/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Рейтинг кланов</div>
                                                </a>
                                            </div>
                                            &#160;
                                            <xsl:choose>
                                                <xsl:when test="player/clan > 0">
                                                    <div class="button">
                                                        <a class="f" href="/clan/profile/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Перейти к клану</div>
                                                        </a>
                                                    </div>
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <div class="button">
                                                        <a class="f" href="/clan/register/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Основать свой клан</div>
                                                        </a>
                                                    </div>
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </div>
                                    </xsl:otherwise>
                                </xsl:choose>

                                <p>Пригласи 30 друзей и получи бонусную справку на бесплатную регистрацию клана<br />
                                <span class="hint" style="font-size:90%; color:#666;">Друзья должны достигнуть 3-го левела</span></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</xsl:template>

</xsl:stylesheet>
