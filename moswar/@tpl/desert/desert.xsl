<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>Пустыня</h2></div>
                <div id="content" class="desert">

                    <div class="welcome">
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="text">
                                <xsl:choose>
                                    <xsl:when test="desert/state = 'begin'">
                                        <p>Патрулируя улицы и наслаждаясь неспешной прогулкой, вы слишком увлеклись мыслями о смысле жизни и не заметили,
                                        как наткнулись на уличного мага Девида Блейна. Секундой позже вы почувствовали тепло и ощущение полета…</p>

                                        <p>Оглядевшись, вы поняли, что не узнаете привалившей улицы, покрытой километрами песка и палящим белым солнцем.
                                        Обладая сверх-дедуктивными способностями, вы догадались, что снова очутились в пустыне и вам выпал шанс осуществить вашу детскую мечту: стать лесным эльфом и...</p>

                                        <div style="text-align:center">
                                            <div class="button" onclick="document.location.href='/desert/rob/';">
                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Грабить караваны!</div>
                                                </span>
                                            </div>
                                        </div>
                                    </xsl:when>
                                    <xsl:when test="desert/state = 'fail'">
                                        <p>К сожалению, верблюды вас перехитрили, и вы не смогли ограбить караван.</p>
                                        <div style="text-align:center">
                                            <div class="button" onclick="document.location.href='/alley/';">
                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Вернуться</div>
                                                </span>
                                            </div>
                                        </div>
                                    </xsl:when>
                                    <xsl:when test="desert/state = 'success'">
                                        <p>С криками “Махмуд, поджигай!” вы набросились на верблюдов и заработали <span class="tugriki"><xsl:value-of select="desert/money" /><i></i></span>.</p>
                                        <div style="text-align:center">
                                            <div class="button" onclick="document.location.href='/alley/';">
                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Вернуться</div>
                                                </span>
                                            </div>
                                        </div>
                                    </xsl:when>
                                </xsl:choose>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>