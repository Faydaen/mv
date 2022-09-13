<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/clan-error.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    <span class="clan"></span>
                </h2></div>
                <div id="content" class="clan">

                    <div class="welcome">
                        <i class="emblem">
                            <xsl:attribute name="style">background:url(http://img.moswar.ru/@images/clan/clan_<xsl:value-of select="clan/id" />_logo.png);</xsl:attribute>
                        </i>
                    </div>

                    <xsl:if test="count(result) > 0">
                        <div class="report">
                            <xsl:call-template name="error">
                                <xsl:with-param name="result" select="result" />
                            </xsl:call-template>
                        </div>
                    </xsl:if>

                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <div class="clan-members">
                                <h3>Кланеры (<xsl:value-of select="count(clan/players/element)" />)</h3>

                                <table class="list-clans clan-members-table">
                                    <tr>
                                        <th class="name">Имя</th>
                                        <th class="position">Комментарий</th>
                                        <xsl:if test="/data/people = 1">
                                            <th class="date">Онлайн</th>
                                        </xsl:if>
                                        <th class="actions"></th>
                                    </tr>
                                    <xsl:for-each select="clan/players/element">
                                        <tr>
                                            <td class="name">
                                                <i class="{status}"></i>
                                                <xsl:call-template name="playerlink">
                                                    <xsl:with-param name="player" select="current()" />
                                                </xsl:call-template>
                                            </td>
                                            <td class="position">
                                                <xsl:choose>
                                                    <xsl:when test="/data/clan/founder = /data/player/id or /data/people = 1">
                                                        <span class="dashedlink" onclick="ClanerPositionFormShow(this);"><xsl:choose><xsl:when test="clan_title != ''"><xsl:value-of select="clan_title" /></xsl:when><xsl:otherwise><em>должность не указана</em></xsl:otherwise></xsl:choose></span>
                                                        <form style="display:none;" action="/clan/profile/" method="post">
                                                            <input type="hidden" name="action" value="set_clan_title" />
                                                            <input type="hidden" name="player" value="{id}" />
                                                            <input type="text" name="title" />
                                                            <div>
                                                                <button class="button" type="submit" onclick="">
                                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                        <div class="c">Сохранить</div>
                                                                    </span>
                                                                </button>
                                                                <button class="button" onclick="ClanerPositionFormShow(this); return false;">
                                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                        <div class="c">Отмена</div>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        <xsl:choose><xsl:when test="clan_title != ''"><xsl:value-of select="clan_title" /></xsl:when><xsl:otherwise><em>должность не указана</em></xsl:otherwise></xsl:choose>
                                                    </xsl:otherwise>
                                                </xsl:choose>
                                            </td>
                                            <xsl:if test="/data/people = 1">
                                                <td class="date">
                                                    <xsl:value-of select="current()/lastactivitytime" />
                                                    <xsl:if test="accesslevel = -1">&#0160;<em>(заблокирован)</em></xsl:if>
                                                    <xsl:if test="accesslevel = -2">&#0160;<em>(заморожен)</em></xsl:if>
                                                </td>
                                            </xsl:if>
                                            <td class="actions">
                                                <xsl:if test="/data/atwar = 0">
                                                    <xsl:if test="/data/people = 1 and id != /data/clan/founder and id != /data/player/id">
                                                        <button class="button" onclick="clanDrop({id});">
                                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                <div class="c">Исключить</div>
                                                            </span>
                                                        </button>
                                                    </xsl:if>
                                                </xsl:if>
                                            </td>
                                        </tr>
                                    </xsl:for-each>
                                </table>
                                <script type="text/javascript">
                                    function ClanerPositionFormShow(obj){
                                        var td = $(obj).parents('td.position:first');
                                        var form = td.find('form');
                                        if(form.is(':visible')){
                                            form.hide();
                                            td.find('span.dashedlink').show();
                                        } else {
                                            form.show();
                                            form.find('input[name=title]').val(td.find('span.dashedlink').text());
                                            td.find('span.dashedlink').hide();
                                        }
                                        return false;
                                    }
                                </script>
                                <p>Принимать и исключать людей из клана могут Глава, Заместитель главы и Кадровик.</p>
                                <xsl:if test="atwar = 1">
                                    <p>Вы не можете принимать и исключать игроков из клана во время войны.</p>
                                </xsl:if>
                            </div>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3>Структура</h3>
							<div class="clan-members">
								<p>Главу клана может сменить исключительно сам глава. Сменить главу при его отсутствии нельзя ни при каких обстоятельствах, и даже Администрация не может этого сделать. Даже через год. Точно также как предмет одного игрока нельзя отдать другому.</p>
							</div>
                            <form class="clan-positions" action="/clan/profile/" method="post">
                                <input type="hidden" name="action" value="set_clan_roles" />
                                <table class="forms">
                                    <tr>
                                        <td class="label">Глава:</td>
                                        <td class="claner">
                                            <xsl:choose>
                                                <xsl:when test="founder = 1">
                                                    <select name="founder" onchange="clanTeamCalcCost();">
                                                        <xsl:for-each select="clan/players/element">
                                                            <option value="{id}">
                                                                <xsl:if test="clan_status = 'founder'">
                                                                    <xsl:attribute name="selected">selected</xsl:attribute>
                                                                </xsl:if>
                                                                <xsl:value-of select="nickname" /> [<xsl:value-of select="level" />]
                                                            </option>
                                                        </xsl:for-each>
                                                    </select>
                                                </xsl:when>
                                                <xsl:when test="founder = 0">
                                                    <a href="/player/{cur/founder/id}/"><xsl:value-of select="cur/founder/nickname" /></a> [<xsl:value-of select="cur/founder/level" />]
                                                </xsl:when>
                                            </xsl:choose>
                                        </td>
                                        <td class="description">
                                            Обладает всеми правами и носит корону клана
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Заместитель:</td>
                                        <td class="claner">
                                            <xsl:choose>
                                                <xsl:when test="founder = 1">
                                                    <select name="adviser" onchange="clanTeamCalcCost();">
                                                        <option value="0"> - выберите кланера - </option>
                                                        <xsl:for-each select="clan/players/element">
                                                            <xsl:if test="clan_status = 'accepted' or clan_status = 'adviser'">
                                                                <option value="{id}">
                                                                    <xsl:if test="clan_status = 'adviser'">
                                                                        <xsl:attribute name="selected">selected</xsl:attribute>
                                                                    </xsl:if>
                                                                    <xsl:value-of select="nickname" /> [<xsl:value-of select="level" />]
                                                                </option>
                                                            </xsl:if>
                                                        </xsl:for-each>
                                                    </select>
                                                </xsl:when>
                                                <xsl:when test="founder = 0 and cur/adviser/id != 0">
                                                    <a href="/player/{cur/adviser/id}/"><xsl:value-of select="cur/adviser/nickname" /></a> [<xsl:value-of select="cur/adviser/level" />]
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <i>не назначен</i>
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </td>
                                        <td class="description">
                                            Совмещает должности Казначей, Дипломат, Кадровик и Модератор
                                        </td>
                                        <td>
                                            <xsl:if test="cur/adviser/id = player/id">
                                                <span class="button" onclick="clanInternalAction('canceltitle', '');">
                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Отказаться — <span class="tugriki">5,000<i></i></span></div>
                                                    </span>
                                                </span>
                                            </xsl:if>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Казначей:</td>
                                        <td class="claner">
                                            <xsl:choose>
                                                <xsl:when test="founder = 1">
                                                    <select name="money" onchange="clanTeamCalcCost();">
                                                        <option value="0"> - выберите кланера - </option>
                                                        <xsl:for-each select="clan/players/element">
                                                            <xsl:if test="clan_status = 'accepted' or clan_status = 'money'">
                                                                <option value="{id}">
                                                                    <xsl:if test="clan_status = 'money'">
                                                                        <xsl:attribute name="selected">selected</xsl:attribute>
                                                                    </xsl:if>
                                                                    <xsl:value-of select="nickname" /> [<xsl:value-of select="level" />]
                                                                </option>
                                                            </xsl:if>
                                                        </xsl:for-each>
                                                    </select>
                                                </xsl:when>
                                                <xsl:when test="founder = 0 and cur/money/id != 0">
                                                    <a href="/player/{cur/money/id}/"><xsl:value-of select="cur/money/nickname" /></a> [<xsl:value-of select="cur/money/level" />]
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <i>не назначен</i>
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </td>
                                        <td class="description">
                                            Может распоряжаться казной клана: покупать вещи и усиления
                                        </td>
                                        <td>
                                            <xsl:if test="cur/money/id = player/id">
                                                <span class="button" onclick="clanInternalAction('canceltitle', '');">
                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Отказаться — <span class="tugriki">5,000<i></i></span></div>
                                                    </span>
                                                </span>
                                            </xsl:if>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Дипломат:</td>
                                        <td class="claner">
                                            <xsl:choose>
                                                <xsl:when test="founder = 1">
                                                    <select name="diplomat" onchange="clanTeamCalcCost();">
                                                        <option value="0"> - выберите кланера - </option>
                                                        <xsl:for-each select="clan/players/element">
                                                            <xsl:if test="clan_status = 'accepted' or clan_status = 'diplomat'">
                                                                <option value="{id}">
                                                                    <xsl:if test="clan_status = 'diplomat'">
                                                                        <xsl:attribute name="selected">selected</xsl:attribute>
                                                                    </xsl:if>
                                                                    <xsl:value-of select="nickname" /> [<xsl:value-of select="level" />]
                                                                </option>
                                                            </xsl:if>
                                                        </xsl:for-each>
                                                    </select>
                                                </xsl:when>
                                                <xsl:when test="founder = 0 and cur/diplomat/id != 0">
                                                    <a href="/player/{cur/diplomat/id}/"><xsl:value-of select="cur/diplomat/nickname" /></a> [<xsl:value-of select="cur/diplomat/level" />]
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <i>не назначен</i>
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </td>
                                        <td class="description">
                                            Может заключать и расторгать союзы, объявлять войны
                                        </td>
                                        <td>
                                            <xsl:if test="cur/diplomat/id = player/id">
                                                <span class="button" onclick="clanInternalAction('canceltitle', '');">
                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Отказаться — <span class="tugriki">5,000<i></i></span></div>
                                                    </span>
                                                </span>
                                            </xsl:if>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Кадровик:</td>
                                        <td class="claner">
                                            <xsl:choose>
                                                <xsl:when test="founder = 1">
                                                    <select name="people" onchange="clanTeamCalcCost();">
                                                        <option value="0"> - выберите кланера - </option>
                                                        <xsl:for-each select="clan/players/element">
                                                            <xsl:if test="clan_status = 'accepted' or clan_status = 'people'">
                                                                <option value="{id}">
                                                                    <xsl:if test="clan_status = 'people'">
                                                                        <xsl:attribute name="selected">selected</xsl:attribute>
                                                                    </xsl:if>
                                                                    <xsl:value-of select="nickname" /> [<xsl:value-of select="level" />]
                                                                </option>
                                                            </xsl:if>
                                                        </xsl:for-each>
                                                    </select>
                                                </xsl:when>
                                                <xsl:when test="founder = 0 and cur/people/id != 0">
                                                    <a href="/player/{cur/people/id}/"><xsl:value-of select="cur/people/nickname" /></a> [<xsl:value-of select="cur/people/level" />]
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <i>не назначен</i>
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </td>
                                        <td class="description">
                                            Может принимать и исключать людей из клана
                                        </td>
                                        <td>
                                            <xsl:if test="cur/people/id = player/id">
                                                <span class="button" onclick="clanInternalAction('canceltitle', '');">
                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Отказаться — <span class="tugriki">5,000<i></i></span></div>
                                                    </span>
                                                </span>
                                            </xsl:if>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Модератор:</td>
                                        <td class="claner">
                                            <xsl:choose>
                                                <xsl:when test="founder = 1">
                                                    <select name="forum" onchange="clanTeamCalcCost();">
                                                        <option value="0"> - выберите кланера - </option>
                                                        <xsl:for-each select="clan/players/element">
                                                            <xsl:if test="clan_status = 'accepted' or clan_status = 'forum'">
                                                                <option value="{id}">
                                                                    <xsl:if test="clan_status = 'forum'">
                                                                        <xsl:attribute name="selected">selected</xsl:attribute>
                                                                    </xsl:if>
                                                                    <xsl:value-of select="nickname" /> [<xsl:value-of select="level" />]
                                                                </option>
                                                            </xsl:if>
                                                        </xsl:for-each>
                                                    </select>
                                                </xsl:when>
                                                <xsl:when test="founder = 0 and cur/forum/id != 0">
                                                    <a href="/player/{cur/forum/id}/"><xsl:value-of select="cur/forum/nickname" /></a> [<xsl:value-of select="cur/forum/level" />]
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <i>не назначен</i>
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </td>
                                        <td class="description">
                                            Имеет права модерирования кланового форума
                                        </td>
                                        <td>
                                            <xsl:if test="cur/forum/id = player/id">
                                                <span class="button" onclick="clanInternalAction('canceltitle', '');">
                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Отказаться — <span class="tugriki">5,000<i></i></span></div>
                                                    </span>
                                                </span>
                                            </xsl:if>
                                        </td>
                                    </tr>
                                    <xsl:if test="founder = 1">
                                        <tr>
                                            <td class="label"></td>
                                            <td class="claner">
                                                <button class="button" type="submit" id="roles-submit">
                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Сохранить<span id="button-price" style="display:none;"> — <span class="tugriki" id="cur-tugriks">0<i></i></span></span></div>
                                                    </span>
                                                </button>
                                            </td>
                                            <td class="description" style="vertical-align:middle;">
                                                <span id="no-money" style="display:none;" class="error">В казне клана не хватает монет.</span>
                                            </td>
                                        </tr>
                                    </xsl:if>
                                </table>
                                <p>
                                    Стоимость одного назначения (снятия с должности) — <span class="tugriki">5,000<i></i></span><br />
                                    Смена главы клана — <span class="tugriki">50,000<i></i></span><br />
                                    <b>Внимание!</b> Один человек может занимать только одну должность одновременно.
                                </p>
                                <xsl:if test="founder = 1">
                                    <!--p class="total">
                                        <b>Текущая стоимость кадроввых перестановок: </b><span class="tugriki" id="cur-tugriks">0<i></i></span>
                                    </p-->
                                    <script type="text/javascript">
                                        var curFounderId = <xsl:value-of select="cur/founder/id" />;
                                        var curAdviserId = <xsl:value-of select="cur/adviser/id" />;
                                        var curDiplomatId = <xsl:value-of select="cur/diplomat/id" />;
                                        var curPeopleId = <xsl:value-of select="cur/people/id" />;
                                        var curMoneyId = <xsl:value-of select="cur/money/id" />;
                                        var curForumId = <xsl:value-of select="cur/forum/id" />;
                                        var clanMoney = <xsl:value-of select="clan/money" />;
                                        clanTeamCalcCost();
                                    </script>
                                </xsl:if>
                            </form>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3>Штаб</h3>
                            <div class="clan-headquarters">

                                <p>Вместимость обычного кланового штаба — 20 человек. Но бригада мастеров всегда готова подвинуть стенку и расширить его вместимость.</p>

                                <p class="total">
                                    <b>Текущая вместимость вашего штаба: </b><xsl:value-of select="clan/maxpeople" />
                                </p>

                                <xsl:if test="/data/money = 1">
                                    <form action="/clan/profile/" method="post">
                                        <input type="hidden" name="action" value="expand_office" />
                                        <p class="pay">
                                            <button class="button" type="submit">
                                                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Увеличить на одно место — <span class="tugriki"><xsl:value-of select="format-number(clan/morepeopleprice/money, '###,###')" /><i></i></span> + <span class="ruda"><xsl:value-of select="format-number(clan/morepeopleprice/ore, '###,###')" /><i></i></span> (или <span class="med"><xsl:value-of select="format-number(clan/morepeopleprice/ore, '###,###')" /><i></i></span>)</div>
                                                </span>
                                            </button><br />
                                            Оплата берется из казны клана
                                        </p>
                                    </form>
                                </xsl:if>
                            </div>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                </div>
            </div>
        </div>
	</xsl:template>

</xsl:stylesheet>