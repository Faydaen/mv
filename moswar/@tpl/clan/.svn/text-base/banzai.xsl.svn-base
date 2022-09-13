<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Банзай!
                </h2></div>
                <div id="content" class="clan">

                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3>Прилив бодрости</h3>
                            <form class="clan-affects" action="/clan/profile/banzai/" method="post">
                                <input type="hidden" name="player" value="{player/id}" />

                                <p>Бравые воины царя Александра Македонского славились пугающим бесстрашием и величайшей отвагой в бою.
                                А все благодаря правильному настрою на битву и заряду бодрости, который он передавал своему войску, произнося пламенные речи.
                                Вы тоже так можете. Придайте бодрости своим сокланерам.</p>

                                <xsl:if test="banzai = 1">
                                    <table class="process">
                                        <tr>
                                            <td class="label">Действие заряда бодрости:</td>
                                            <td class="progress">
                                                <div class="exp">
                                                    <div class="bar"><div><div class="percent" style="width:{banzaipercent}%;" id="banzaibar" reverse="1"></div></div></div>
                                                </div>
                                            </td>
                                            <td class="value" timer="{banzaitimeleft}" timer2="{banzaitimetotal}" id="banzai"><xsl:value-of select="banzaitimeleft2" /></td>
                                        </tr>
                                    </table>
                                </xsl:if>

                                <table class="forms">
                                    <tr>
                                        <td class="label">Рейтинг точности</td>
                                        <td class="slider"><div id="ratingaccur-slider"></div></td>
                                        <td class="input"><input type="text" value="0" name="boost[ratingaccur]" id="ratingaccur-input" maxlength="3" size="2" tabindex="1" /></td>
                                    </tr>
                                    <tr>
                                        <td class="label">Рейтинг урона</td>
                                        <td class="slider"><div id="ratingdamage-slider"></div></td>
                                        <td class="input"><input type="text" value="0" name="boost[ratingdamage]" id="ratingdamage-input" maxlength="3" size="2" tabindex="2" /></td>
                                    </tr>
                                    <tr>
                                        <td class="label">Рейтинг критических ударов</td>
                                        <td class="slider"><div id="ratingcrit-slider"></div></td>
                                        <td class="input"><input type="text" value="0" name="boost[ratingcrit]" id="ratingcrit-input" maxlength="3" size="2" tabindex="3" /></td>
                                    </tr>
                                    <tr>
                                        <td class="label">Рейтинг уворота</td>
                                        <td class="slider"><div id="ratingdodge-slider"></div></td>
                                        <td class="input"><input type="text" value="0" name="boost[ratingdodge]" id="ratingdodge-input" maxlength="3" size="2" tabindex="4" /></td>
                                    </tr>
                                    <tr>
                                        <td class="label">Рейтинг защиты</td>
                                        <td class="slider"><div id="ratingresist-slider"></div></td>
                                        <td class="input"><input type="text" value="0" name="boost[ratingresist]" id="ratingresist-input" maxlength="3" size="2" tabindex="5" /></td>
                                    </tr>
                                    <tr>
                                        <td class="label">Рейтинг защиты от крит. ударов</td>
                                        <td class="slider"><div id="ratinganticrit-slider"></div></td>
                                        <td class="input"><input type="text" value="0" name="boost[ratinganticrit]" id="ratinganticrit-input" maxlength="3" size="2" tabindex="6" /></td>
                                    </tr>
                                    <xsl:if test="banzai = 0">
                                        <tr>
                                            <td class="label">Время воздействия</td>
                                            <td colspan="2">
                                                <select id="clan-affects-time" name="hours" tabindex="7">
                                                    <option value="1">1 час</option>
                                                    <option value="2">2 часа</option>
                                                    <option value="3">3 часа</option>
                                                    <option value="4">4 часа</option>
                                                    <option value="5">5 часов</option>
                                                    <option value="6">6 часов</option>
                                                    <option value="7">7 часов</option>
                                                    <option value="8">8 часов</option>
                                                </select>
                                                <span class="hint">Прилив бодрости возможен раз в 8 часов и на срок до 8 часов.</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label"></td>
                                            <td colspan="2">

                                                <button class="button" type="submit" id="banzai-button">
                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Получить заряд бодрости — <span class="tugriki"><span id="clan-affects-cost">0</span><i></i></span></div>
                                                    </span>
                                                </button>
                                                <div class="hint">
													В среднем на 1 кланера приходится по <span class="tugriki"><span id="clan-affects-cost-member">0</span><i></i></span>.
                                                    <div id="clan-affects-hint-money">Убедитесь, что в казне клана достаточно денег.</div>
                                                </div>
                                            </td>
                                        </tr>
                                    </xsl:if>
                                    
                                </table>
                            </form>
                            <script type="text/javascript">
                            var clanAffectsNames = ["ratingaccur","ratingdamage","ratingcrit","ratingdodge","ratingresist","ratinganticrit"];
                            var clanAffectsValues = [<xsl:value-of select="curboosts" />];
                            var clanMoney = <xsl:value-of select="clan/money" />;
							var clanMembersNumber = <xsl:value-of select="clanpeople" />;

                            $(document).ready(function(){
                                clanAffectsInit()
                            });
                            </script>

                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                </div>
            </div>
        </div>
	</xsl:template>

</xsl:stylesheet>