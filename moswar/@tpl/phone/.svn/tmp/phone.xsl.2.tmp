<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/npclink.xsl" />
    <xsl:include href="common/clanlink.xsl" />
    <xsl:include href="common/price.xsl" />
    <xsl:include href="common/paginator.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    <span class="phone"></span>
                </h2></div>
                <div id="content" class="phone">
                    <div class="welcome">
                    </div>

                    <table class="buttons">
                        <tr>
                            <td>
                                <xsl:element name="div">
                                    <xsl:choose>
                                        <xsl:when test="mode = 'messages'">
                                            <xsl:attribute name="class">button button-current</xsl:attribute>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:attribute name="class">button</xsl:attribute>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                    <a class="f" href="/phone/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">Сообщения</div>
                                    </a>
                                </xsl:element>
                            </td>
                            <td>
                                <xsl:element name="div">
                                    <xsl:choose>
                                        <xsl:when test="mode = 'logs'">
                                            <xsl:attribute name="class">button button-current</xsl:attribute>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:attribute name="class">button</xsl:attribute>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                    <a class="f" href="/phone/logs/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">Логи</div>
                                    </a>
                                </xsl:element>
                            </td>
                            <td>
                                <xsl:element name="div">
                                    <xsl:choose>
                                        <xsl:when test="mode = 'duels'">
                                            <xsl:attribute name="class">button button-current</xsl:attribute>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:attribute name="class">button</xsl:attribute>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                    <a class="f" href="/phone/duels/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">Дуэли</div>
                                    </a>
                                </xsl:element>
                            </td>
                            <td>
                                <xsl:element name="div">
                                    <xsl:choose>
                                        <xsl:when test="mode = 'contacts'">
                                            <xsl:attribute name="class">button button-current</xsl:attribute>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:attribute name="class">button</xsl:attribute>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                    <a class="f" href="/phone/contacts/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">Контакты</div>
                                    </a>
                                </xsl:element>
                            </td>
                            <td>
                                <div class="button disabled">
                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                        <div class="c">Квесты</div>
                                    </span>
                                </div>
                            </td>

                        </tr>
                    </table>

                    <!--xsl:if test="count(result/result) > 0 and count(result/action) > 0 and count(result/type) > 0">
                        <xsl:call-template name="error">
                            <xsl:with-param name="result" select="result" />
                        </xsl:call-template>
                    </xsl:if-->

                    <xsl:choose>
                        <xsl:when test="mode = 'messages'">
                            <xsl:call-template name="messages" />
                        </xsl:when>
                        <xsl:when test="mode = 'contacts'">
                            <xsl:call-template name="contacts" />
                        </xsl:when>
                        <xsl:when test="mode = 'logs'">
                            <xsl:call-template name="logs" />
                        </xsl:when>
                        <xsl:when test="mode = 'duels'">
                            <xsl:call-template name="logs_duels" />
                        </xsl:when>
                    </xsl:choose>

                </div>
            </div>
        </div>
    </xsl:template>

	<xsl:template name="messages">
		<xsl:if test="result != ''">
			<div class="report">
				<xsl:choose>
					<xsl:when test="result = 1 and action = 'delete'"><div class="success">Сообщение удалено.</div></xsl:when>
					<xsl:when test="result = 1 and action = 'send'"><span class="success">Сообщение успешно отправлено.</span></xsl:when>
					<xsl:when test="result = 1 and action = 'deleteall'"><span class="success">Все сообщения удалены.</span></xsl:when>
					<xsl:when test="result = 1 and action = 'complain'"><span class="success">Жалоба на письмо отправлена модераторам.</span></xsl:when>
					<xsl:when test="result = 0 and error = 'no_player'"><span class="error">Персонажа с таким именем не существует.</span></xsl:when>
                    <xsl:when test="result = 0 and error = 'player_blocked'"><span class="error">Персонаж заблокирован. Нельзя отправлять сообщения заблокированным персонажам.</span></xsl:when>
					<xsl:when test="result = 0 and error = 'no_text'"><span class="error">Не указан текст сообщения.</span></xsl:when>
				</xsl:choose>
			</div>
		</xsl:if>
        <div class="messages">
            <xsl:choose>
                <xsl:when test="player/mute_phone > servertime">
                    <p class="error" align="center">Вы наказаны и не можете пользоваться личными сообщениями до <b><xsl:value-of select="php:function('date', 'd.m.Y H:i:s', string(player/mute_phone))" /></b>.</p>
                </xsl:when>
                <xsl:otherwise>
                    <form class="messages-add" action="/phone/messages/send/" method="post" name="messageForm" id="messageForm">
						<input type="hidden" name="maxTextSize" value="{maxtextsize}" />
                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <a name="add"></a>
                                <h3>Написать сообщение</h3>
                                <xsl:choose>
                                    <xsl:when test="player/level > 1 and timeout1 = 0">
                                        <table class="forms">
                                            <tr>
                                                <td class="label">Кому:</td>
                                                <td class="input"><input class="name" type="text" value="{nickname}" name="name" id="name" /></td>
                                            </tr>
                                            <tr>
                                                <td class="label">Текст сообщения:</td>
                                                <td class="input"><textarea name="text" id="text" style="height: 100px;"><xsl:value-of select="text" /></textarea><br />
												<small>Осталось символов: <span rel="currentTextSize"><xsl:value-of select="maxtextsize" /></span></small></td>
                                            </tr>
                                            <tr>
                                                <td class="label"></td>
                                                <td class="input">
                                                    <button class="button" onclick="$('#messageForm').trigger('submit');">
                                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Написать</div>
                                                        </span>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </xsl:when>
                                    <xsl:when test="timeout1 = 1">
                                        <p class="green">
                                            <h3>До 7-го уровня вы не можете отправлять личные сообщения чаще, чем раз в минуту.</h3>
                                        </p>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <p class="green">
                                            <h3>Отправлять сообщения можно со 2-го уровня.</h3>
                                        </p>
                                    </xsl:otherwise>
                                </xsl:choose>

                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </form>
                </xsl:otherwise>
            </xsl:choose>

            <div class="block-rounded">
                <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                <a name="messages"></a>
                <h3>
                    <xsl:choose>
                        <xsl:when test="submode = 'inbox'">
							Входящие
						</xsl:when>
                        <xsl:otherwise>
							<a href="/phone/messages/inbox/">Входящие</a>
                        </xsl:otherwise>
					</xsl:choose>
					<xsl:if test="clan_exists = 1">&#0160;/&#0160;
						<xsl:choose>
							<xsl:when test="submode = 'clan'">
								Клановые
							</xsl:when>
							<xsl:otherwise>
								<a href="/phone/messages/clan/">Клановые</a>
							</xsl:otherwise>
						</xsl:choose>
					</xsl:if>
					<xsl:if test="sovet_exists = 1">&#0160;/&#0160;
						<xsl:choose>
							<xsl:when test="submode = 'sovet'">
								Совета
							</xsl:when>
							<xsl:otherwise>
								<a href="/phone/messages/sovet/">Совета</a>
							</xsl:otherwise>
						</xsl:choose>
					</xsl:if>
					&#0160;/&#0160;
                    <xsl:choose>
                        <xsl:when test="submode = 'outbox'">
							Исходящие
						</xsl:when>
                        <xsl:otherwise>
							<a href="/phone/messages/outbox/">Исходящие</a>
                        </xsl:otherwise>
					</xsl:choose>
                    <xsl:if test="count(messages/element) > 0"><br /><a href="#" onclick="phoneDeleteMessages('{submode}');">Удалить все</a></xsl:if>
                </h3>
                <xsl:if test="count(messages/element) > 0">
				
				    <table class="messages-list">
                        <xsl:for-each select="messages/element">
                            <xsl:element name="tr">
                                <xsl:if test="read = 0">
                                    <xsl:attribute name="class">new</xsl:attribute>
                                </xsl:if>
                                <td class="date"><xsl:value-of select="datetime" /></td>
                                <xsl:choose>
                                    <xsl:when test="type = 'message'">
                                        <td class="text">
                                            <xsl:choose>
                                                <xsl:when test="/data/submode = 'outbox'">
                                                    Исходящее сообщение игроку
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    Входящее сообщение от игрока
                                                </xsl:otherwise>
                                            </xsl:choose>

                                            <i class="{status}"></i>
                                            <!--<span class="user"><i title="{fractionTitle}" class="{fraction}"></i><a href="/player/{player}/"><xsl:value-of select="nickname" /></a><span class="level">[<xsl:value-of select="level" />]</span></span>:-->
                                            <xsl:call-template name="playerlink">
                                                <xsl:with-param name="player" select="player" />
                                            </xsl:call-template>:
                                            <blockquote>
                                                <xsl:value-of select="text" disable-output-escaping="yes" />
                                            </blockquote>
                                        </td>
                                        <td class="actions">
                                            <xsl:call-template name="messagebutton" />
                                        </td>
                                    </xsl:when>
                                    <xsl:when test="type = 'system_notice'">
                                        <td class="text">
                                            <i>Уведомление</i>:
                                            <blockquote>
                                                <xsl:value-of select="text" disable-output-escaping="yes" />
                                            </blockquote>
                                        </td>
                                        <td class="actions">
                                            <xsl:call-template name="messagebutton" />
                                        </td>
                                    </xsl:when>
                                    <xsl:when test="type = 'clan_message'">
                                        <td class="text">
                                            Сообщение через клановый рупор <xsl:choose>
                                                <xsl:when test="playerdir = 1">от игрока</xsl:when>
                                                <xsl:otherwise>игроку</xsl:otherwise>
                                            </xsl:choose> <i class="{status}"></i>
                                            <xsl:call-template name="playerlink">
                                                <xsl:with-param name="player" select="player" />
                                            </xsl:call-template>:
                                            <blockquote>
                                                <xsl:value-of select="text" disable-output-escaping="yes" />
                                            </blockquote>
                                        </td>
                                        <td class="actions">
                                            <span class="button">
                                                <a class="f" href="/clan/profile/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Клан</div>
                                                </a>
                                            </span>
                                            <xsl:call-template name="messagebutton" />
                                        </td>
                                    </xsl:when>
                                    <xsl:when test="type = 'sovet_message'">
                                        <td class="text">
                                            Сообщение через рупор совета <xsl:choose>
                                                <xsl:when test="playerdir = 1">от игрока</xsl:when>
                                                <xsl:otherwise>игроку</xsl:otherwise>
                                            </xsl:choose> <i class="{status}"></i>
                                            <xsl:call-template name="playerlink">
                                                <xsl:with-param name="player" select="player" />
                                            </xsl:call-template>:
                                            <blockquote>
                                                <xsl:value-of select="text" disable-output-escaping="yes" />
                                            </blockquote>
                                        </td>
                                        <td class="actions">
                                            <span class="button">
                                                <a class="f" href="/sovet/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Совет</div>
                                                </a>
                                            </span>
                                            <xsl:call-template name="messagebutton" />
                                        </td>
                                    </xsl:when>
                                </xsl:choose>

                            </xsl:element>
                        </xsl:for-each>
                    </table>

                    <xsl:choose>
                        <xsl:when test="submode != ''">
                            <xsl:call-template name="paginator">
                                <xsl:with-param name="pages" select="pages" />
                                <xsl:with-param name="page" select="page" />
                                <xsl:with-param name="link" select="concat('/phone/messages/', submode, '/')" />
                            </xsl:call-template>
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:call-template name="paginator">
                                <xsl:with-param name="pages" select="pages" />
                                <xsl:with-param name="page" select="page" />
                                <xsl:with-param name="link" select="'/phone/messages/'" />
                            </xsl:call-template>
                        </xsl:otherwise>
                    </xsl:choose>
                </xsl:if>
            </div>
        </div>
	</xsl:template>

	<xsl:template name="contacts">
        <div class="contacts">
            <form class="contacts-add" id="contactForm" name="contactForm" action="/phone/contacts/add/" method="post">
                <div class="block-bordered">
                    <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                    <div class="center clear">
                        <h3>Добавить в контакты</h3>
                        <xsl:choose>
                            <xsl:when test="message = 'no_player'">
                                <div class="report"><p class="error">Игрока с таким ником нет.</p></div>
                            </xsl:when>
                            <xsl:when test="message = 'added'">
                                <div class="report"><p class="success">Контакт добавлен.</p></div>
                            </xsl:when>
                            <xsl:when test="message = 'exists'">
                                <div class="report"><p class="error">Контакт с таким именем уже существует.</p></div>
                            </xsl:when>
                            <xsl:when test="action = 'delete' and result/result = 1">
                                <div class="report"><p class="success">Игрок <xsl:value-of select="result/nickname" /> удален из контактов.</p></div>
                            </xsl:when>
                        </xsl:choose>
                        <table class="forms">
                            <tr>
                                <td class="label">Имя:</td>
                                <td class="input"><input class="name" type="text" name="name" value="{nickname}" /></td>
                            </tr>
                            <tr>
                                <td class="label">Примечание:</td>
                                <td class="input"><input class="comment" type="text" name="info" /></td>
                            </tr>

                            <tr>
                                <td class="label">Группа:</td>
                                <td class="input">
                                    <select name="type">
                                        <option value="victim">Жертвы</option>
                                        <option value="enemy">Враги</option>
                                        <option value="friend">Друзья</option>
                                        <option value="black">Черный список</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label"></td>
                                <td class="input">
                                    <button class="button" onclick="$('#contactForm').trigger('submit');">
                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                            <div class="c">Добавить в список</div>
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                </div>
            </form>

			<div class="block-rounded">
				<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
				<h3>
					<xsl:choose><xsl:when test="submode = 'victims'">Жертвы</xsl:when><xsl:otherwise><a href="/phone/contacts/victims/">Жертвы</a></xsl:otherwise></xsl:choose>&#0160;/&#0160;
					<xsl:choose><xsl:when test="submode = 'enemies'">Враги</xsl:when><xsl:otherwise><a href="/phone/contacts/enemies/">Враги</a></xsl:otherwise></xsl:choose>&#0160;/&#0160;
					<xsl:choose><xsl:when test="submode = 'friends'">Друзья</xsl:when><xsl:otherwise><a href="/phone/contacts/friends/">Друзья</a></xsl:otherwise></xsl:choose>&#0160;/&#0160;
					<xsl:choose><xsl:when test="submode = 'blacks'">Чёрный список</xsl:when><xsl:otherwise><a href="/phone/contacts/blacks/">Чёрный список</a></xsl:otherwise></xsl:choose>&#0160;/&#0160;
					<xsl:choose><xsl:when test="submode = 'referers'">Ученики</xsl:when><xsl:otherwise><a href="/phone/contacts/referers/">Ученики</a></xsl:otherwise></xsl:choose>
				</h3>
                <div align="center">
                    <xsl:choose>
                        <xsl:when test="submode = 'victims'">Жертвы — это игроки, кого вы часто грабите.</xsl:when>
                        <xsl:when test="submode = 'enemies'">Враги — это игроки, с которыми вы воюете.</xsl:when>
                        <xsl:when test="submode = 'friends'">Друзья — это игроки, с которыми вы часто общаетесь в игре.</xsl:when>
                        <xsl:when test="submode = 'blacks'">Чёрный список — это игроки, от которых вы <b>не</b> получаете сообщения 
                            (и подарки при включении специальной галочки в <a href="/settings/#privacy">настройках</a>).</xsl:when>
                        <xsl:when test="submode = 'referers'">Ученики — это игроки, которых вы пригласили в игру.</xsl:when>
                    </xsl:choose>
                </div>
				<xsl:if test="count(contacts/element) != 0">
					<table class="list-users">
						<xsl:for-each select="contacts/element">
							<xsl:call-template name="contact" />
						</xsl:for-each>
					</table>
					<xsl:call-template name="paginator">
						<xsl:with-param name="pages" select="pages" />
						<xsl:with-param name="page" select="page" />
						<xsl:with-param name="link" select="concat('/phone/contacts/', submode, '/')" />
					</xsl:call-template>

				</xsl:if>
			</div>

<!--
            <xsl:if test="count(victims/element) > 0">
                <div class="block-rounded">
                    <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                    <h3>Жертвы (<xsl:value-of select="count(victims/element)" />)</h3>
                    <table class="list-users">
                        <xsl:for-each select="victims/element">
                            <xsl:call-template name="contact" />
                        </xsl:for-each>
                    </table>
                </div>
            </xsl:if>

            <xsl:if test="count(enemies/element) > 0">
                <div class="block-rounded">
                    <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                    <h3>Враги (<xsl:value-of select="count(enemies/element)" />)</h3>
                    <table class="list-users">
                        <xsl:for-each select="enemies/element">
                            <xsl:call-template name="contact" />
                        </xsl:for-each>
                    </table>
                </div>
            </xsl:if>

            <xsl:if test="count(friends/element) > 0">
                <div class="block-rounded">
                    <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                    <h3>Друзья (<xsl:value-of select="count(friends/element)" />)</h3>
                    <table class="list-users">
                        <xsl:for-each select="friends/element">
                            <xsl:call-template name="contact" />
                        </xsl:for-each>
                    </table>
                </div>
            </xsl:if>

            <xsl:if test="count(referers/element) > 0">
                <div class="block-rounded">
                    <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                    <h3>Ученики (<xsl:value-of select="count(referers/element)" />)</h3>
                    <table class="list-users">
                        <xsl:for-each select="referers/element">
                            <xsl:call-template name="contact" />
                        </xsl:for-each>
                    </table>
                </div>
            </xsl:if>

            <xsl:if test="count(blacks/element) > 0">
                <div class="block-rounded">
                    <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                    <h3>Черный список (<xsl:value-of select="count(blacks/element)" />)</h3>
                    <table class="list-users">
                        <xsl:for-each select="blacks/element">
                            <xsl:call-template name="contact" />
                        </xsl:for-each>
                    </table>
                </div>
            </xsl:if>
-->
        </div>
	</xsl:template>

	<xsl:template name="contact">
        <tr>
            <td>
                <i class="{status}"></i>
				<xsl:call-template name="playerlink">
					<xsl:with-param name="player" select="current()" />
				</xsl:call-template>
            </td>
            <td class="comment">
                <xsl:value-of select="info" />
            </td>
            <td class="actions">
                <span class="button">
                    <a class="f">
                        <xsl:choose>
                            <xsl:when test="type = 'referer'">
                                <xsl:attribute name="href">javascript:phoneConfirmDeleteContact('<xsl:value-of select="nickname" />','<xsl:value-of select="current()/id" />', 'referer');</xsl:attribute>
                            </xsl:when>
                            <xsl:otherwise>
                                <xsl:attribute name="href">javascript:phoneConfirmDeleteContact('<xsl:value-of select="nickname" />','<xsl:value-of select="current()/id" />', 'contact');</xsl:attribute>
                            </xsl:otherwise>
                        </xsl:choose>
                        <i class="rl"></i><i class="bl"></i><i class="brc"></i>
                        <div class="c">Удалить</div>
                    </a>
                </span>&#0160;
                <xsl:if test="type = 'victim' or type = 'enemy'">
                    <span class="button">
                        <a class="f" href="#" onclick="alleyAttack({current()/id});return false;"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                            <div class="c">Напасть</div>
                        </a>
                    </span>&#0160;
                </xsl:if>
                <xsl:if test="type = 'friend' or type = 'referer'">
                    <span class="button">
                        <a href="/phone/messages/send/{current()/id}/" class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                            <div class="c">Сообщение</div>
                        </a>
                    </span>&#0160;<span class="button">
                        <a class="f" href="/shop/section/gifts/present/{current()/id}/{current()/nickname}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                            <div class="c">Подарок</div>
                        </a>
                    </span>
                </xsl:if>
            </td>
        </tr>
	</xsl:template>

	<xsl:template name="logs">
        <div class="messages">
            <div class="block-rounded">
                <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                <a name="logs"></a>
                <h3>
                    <xsl:choose>
                        <xsl:when test="submode = 'all'">
                            <!--a href="/phone/logs/"-->Логи<!--/a> / Все логи (<xsl:value-of select="total" />)-->
                        </xsl:when>
                        <xsl:otherwise>
                             Логи <!--/ <a href="/phone/logs/all/">Все логи</a-->
                             <!--xsl:if test="count(logs/element) > 0"><br /><a href="#" onclick="phoneDeleteLogs();">Удалить все</a></xsl:if-->
                        </xsl:otherwise>
                    </xsl:choose>
                </h3>

				<div class="pagescroll pagescroll-dates" style="text-align: center; margin:5px 0;">
					<xsl:for-each select="dates/element">
						<xsl:choose>
							<xsl:when test="/data/dt = dt"><strong class="current"><xsl:value-of select="title" /></strong><![CDATA[ ]]></xsl:when>
							<xsl:otherwise><a href="/phone/logs/{dt}/"><xsl:value-of select="title" /></a><![CDATA[ ]]></xsl:otherwise>
						</xsl:choose>
					</xsl:for-each>
				</div>

                <xsl:choose>
                    <xsl:when test="count(logs/element) > 0">
						
					
                        <table class="messages-list">
                            <xsl:for-each select="logs/element">
                                <xsl:element name="tr">
                                    <xsl:if test="read = 0">
                                        <xsl:attribute name="class">new</xsl:attribute>
                                    </xsl:if>
                                    <td class="date"><xsl:value-of select="datetime" /></td>
                                    <xsl:choose>
										<!-- pyramid -->
										<xsl:when test="type = 'pyrb'">
                                            <td class="text">
												Вы купили <span class="pyramids"><xsl:value-of select="params/p" /><i></i></span> за <span class="tugriki"><xsl:value-of select="params/m" /><i></i></span>
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/pyramid/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Пирамида</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'pyrs'">
                                            <td class="text">
												Вы продали <span class="pyramids"><xsl:value-of select="params/p" /><i></i></span> за <span class="tugriki"><xsl:value-of select="params/m" /><i></i></span>
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/pyramid/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Пирамида</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'pyrf'">
                                            <td class="text">
												Вы воспользовались предсказаниями бабушек за
												<xsl:call-template name="showprice">
													<xsl:with-param name="money" select="params/m/m" />
													<xsl:with-param name="ore" select="params/m/o" />
													<xsl:with-param name="honey" select="params/m/h" />
													<xsl:with-param name="nohoney" select="1" />
												</xsl:call-template>.
												<xsl:choose>
													<xsl:when test="params/a = 'buy'">Бабушки посоветовали покупать.</xsl:when>
													<xsl:when test="params/a = 'sell'">Бабушки посоветовали продавать.</xsl:when>
												</xsl:choose>
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/pyramid/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Пирамида</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
										</xsl:when>
										<!-- nightclub -->
										<xsl:when test="type = 'ncsp'">
                                            <td class="text">
                                                Вы сфотографировались у Лёлика, потратив <xsl:if test="params/m > 0"><span class="tugriki"><xsl:value-of select="params/m" /><i></i></span></xsl:if>
                                                <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if>
                                                <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'ncrp'">
                                            <td class="text">
                                                Истек срок действия фото-фона от Лёлика.
                                            </td>
                                            <td class="actions">
												<span class="button">
													<a class="f" href="/nightclub/photo/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div class="c">Сфоткаться</div>
													</a>
												</span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<!-- werewolf -->
										<xsl:when test="type = 'wolf_begin'">
                                            <td class="text">
                                                Вы стали оборотнем <xsl:value-of select="params/l" />-го уровня на 1 час,&#160;<xsl:choose><xsl:when test="params/h > 0">потратив <span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:when><xsl:when test="params/item = 1">воспользовавшись погонами</xsl:when></xsl:choose>.
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'wolf_extension'">
                                            <td class="text">
                                                Вы продлили действие оборотня на 1 час, потратив <span class="med"><xsl:value-of select="params/h" /><i></i></span>.
                                                <xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'wolf_regeneration'">
                                            <td class="text">
                                                Вы прошли регенерацию и улучшили свои характеристики, потратив <span class="med"><xsl:value-of select="params/h" /><i></i></span>.
                                                <xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- clan -->
                                        <xsl:when test="type = 'clan_investition'">
                                            <td class="text">
                                                Казна клана увеличилась на
                                                <xsl:if test="params/money > 0"><span class="tugriki"><xsl:value-of select="params/money" /><i></i></span></xsl:if>
                                                <xsl:if test="params/ore > 0"><span class="ruda"><xsl:value-of select="params/ore" /><i></i></span></xsl:if>
                                                <xsl:if test="params/honey > 0"><span class="med"><xsl:value-of select="params/honey" /><i></i></span></xsl:if>
                                                <xsl:if test="params/m > 0"><span class="tugriki"><xsl:value-of select="params/m" /><i></i></span></xsl:if>
                                                <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if>
                                                <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>
                                                благодаря
                                                <xsl:call-template name="playerlink">
                                                    <xsl:with-param name="player" select="params/player" />
                                                </xsl:call-template>
                                                <xsl:if test="params/player/id = /data/player/id">
                                                    <xsl:if test="count(params/mbckp) > 0">
                                                        <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                    </xsl:if>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'clnrg'">
                                            <td class="text">
                                                Вы основали клан «<b><xsl:value-of select="params/n" /></b>».
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="clanbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'clnlv'">
                                            <td class="text">
                                                Игрок <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/p" /></xsl:call-template> покинул клан.
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="clanbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'clnlv2'">
                                            <td class="text">
                                                <xsl:choose>
                                                    <xsl:when test="params/t = 1">Вы покинули клан.</xsl:when>
                                                    <xsl:when test="params/t = 2">Вас исключили из клана.</xsl:when>
                                                    <xsl:when test="params/t = 3">Ваша заявка о вступлении в клан отклонена.</xsl:when>
                                                    <xsl:when test="params/t = 4">Ваша заявка о вступлении в клан одобрена.</xsl:when>
                                                    <xsl:when test="params/t = 5">Получена новая заявка о вступлении в клан.</xsl:when>
                                                </xsl:choose>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="clanbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'clnrgcrt'">
                                            <td class="text">
												Вы получили сертификат «Мой Клан» от Администрации за то, что 30 Ваших учеников достигли 3-го уровня.
                                                Этот сертификат позволяет зарегистрировать свой клан абсолютно бесплатно.
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="clanbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'clnrl'">
                                            <td class="text">
												Вас <xsl:choose>
                                                    <xsl:when test="params/t = 1">назначили на должность</xsl:when>
                                                    <xsl:when test="params/t = 0">сняли с должности</xsl:when>
                                                </xsl:choose>&#0160;<b><xsl:choose>
                                                    <xsl:when test="params/r = 'fr'">Глава клана</xsl:when>
                                                    <xsl:when test="params/r = 'ad'">Заместитель главы клана</xsl:when>
                                                    <xsl:when test="params/r = 'dp'">Дипломат</xsl:when>
                                                    <xsl:when test="params/r = 'mn'">Казначей</xsl:when>
                                                    <xsl:when test="params/r = 'fm'">Модератор</xsl:when>
                                                    <xsl:when test="params/r = 'pp'">Кадровик</xsl:when>
                                                </xsl:choose></b>.
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="clanbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- diplomacy -->
                                        <xsl:when test="type = 'we_union_propose' or type = 'they_union_propose' or type = 'we_cancel_union_propose' or type = 'they_cancel_union_propose' or type = 'we_union_decline' or type = 'they_union_decline' or type = 'we_union_accept' or type = 'they_union_accept' or type = 'we_union_cancel' or type = 'they_union_cancel' or type = 'we_attack' or type = 'we_attack_auto' or type = 'we_attack_proposal' or type = 'they_attack_proposal' or type = 'they_attack' or type = 'we_attack_accept' or type = 'we_attack_decline' or type = 'they_attack_accept' or type = 'they_attack_decline' or type = 'we_win' or type = 'they_win' or type = 'we_fail' or type = 'they_fail' or type = 'war_step1' or type = 'war_step2'">
                                            <td class="text">
                                                <xsl:choose>
                                                    <xsl:when test="type = 'we_union_propose'">
                                                        Ваш клан предложил союз клану <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template>.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'they_union_propose'">
                                                        Клан <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template> предложил союз Вашему клану.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'we_cancel_union_propose'">
                                                        Ваш клан отозвал предложение союза клану <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template>.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'they_cancel_union_propose'">
                                                        Клан <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template> отозвал предложение союза Вашему клану.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'we_union_decline'">
                                                        Ваш клан отказался заключить в союз с кланом <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template>.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'they_union_decline'">
                                                        Клан <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template> отказался заключить союз с Вашим кланом.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'we_union_accept'">
                                                        Ваш клан заключил союз с кланом <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template>.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'they_union_accept'">
                                                        Клан <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template> заключил союз с Вашим кланом.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'we_union_cancel'">
                                                        Ваш клан разорвал союз с кланом <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template>.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'they_union_cancel'">
                                                        Клан <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template> разорвал союз с Вашим кланом.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'we_attack'">
                                                        Ваш клан напал на клан <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template>.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'we_attack_auto'">
                                                        Ваш клан автоматически присоединился к войне с кланом <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template>.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'we_attack_proposal'">
                                                        Вашему клану предложено присоединиться к войне против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template>.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'they_attack_proposal'">
                                                        Вашему клану предложено присоединиться к войне против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template>.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'they_attack'">
                                                        Клан <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template> напал на ваш клан.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'we_attack_accept'">
                                                        Ваш клан присоединился к клану <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template> в войне.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'we_attack_decline'">
                                                        Ваш клан не поддержал клан <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template> в войне.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'they_attack_accept'">
                                                        Клан <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template> присоединился к Вашему клану в войне.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'they_attack_decline'">
                                                        Клан <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template> не поддержал ваш клан в войне.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'we_win'">
                                                        Ваш клан победил в войне клан <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template>.
                                                        <xsl:if test="params/moneymoves = 1"> Казна клана пополнилась на <xsl:call-template name="showprice"><xsl:with-param name="money" select="params/money" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="ore" select="params/ore" /></xsl:call-template>.</xsl:if>
                                                    </xsl:when>
                                                    <xsl:when test="type = 'they_win'">
                                                        Ваш союз победил в войне клан <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template>.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'we_fail'">
                                                        Ваш клан проиграл в войне клану <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template>.
                                                        <xsl:if test="params/moneymoves = 1"> Казна клана потеряла <xsl:call-template name="showprice"><xsl:with-param name="money" select="params/money" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="nohoney" select="1" /></xsl:call-template>.</xsl:if>
                                                    </xsl:when>
                                                    <xsl:when test="type = 'they_fail'">
                                                        Ваш союз проиграл в войне клану <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/clan" /></xsl:call-template>.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'war_step1'">
                                                        Война с кланом <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> перешла в <a href="/faq/war/#step1">первую фазу</a>.
                                                    </xsl:when>
                                                    <xsl:when test="type = 'war_step2'">
                                                        Война с кланом <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> перешла во <a href="/faq/war/#step2">вторую фазу</a>.
                                                    </xsl:when>
                                                </xsl:choose>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="dipbutton" />
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- pet -->
                                        <xsl:when test="type = 'admin_action'">
                                            <td class="text admin-action">
                                                Модератор <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/player" /></xsl:call-template>&#0160;
                                                <xsl:choose>
													<xsl:when test="params/action = '+marry'">
                                                        обвенчал вас с игроком <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/p2" /></xsl:call-template>
                                                    </xsl:when>
													<xsl:when test="params/action = '-marry'">
                                                        развел вас с игроком <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/p2" /></xsl:call-template>
                                                    </xsl:when>
													<xsl:when test="params/action = '+avatar'">
                                                        одобрил ваш аватар.
                                                    </xsl:when>
													<xsl:when test="params/action = '-avatar'">
                                                        отклонил ваш аватар.
                                                    </xsl:when>
                                                    <xsl:when test="params/action = '+block'">
                                                        заблокировал Вашего персонажа.
                                                    </xsl:when>
                                                    <xsl:when test="params/action = '-block'">
                                                        разблокировал Вашего персонажа.
                                                    </xsl:when>
                                                    <xsl:when test="params/action = '+jail'">
                                                        отправил Вашего персонажа в тюрьму на срок <xsl:value-of select="php:function('str_replace', 'h', ' ч', php:function('str_replace', 'd', ' д', string(params/period)))" />.
                                                    </xsl:when>
                                                    <xsl:when test="params/action = '-jail'">
                                                        выпустил Вашего персонажа из тюрьмы.
                                                    </xsl:when>
                                                    <xsl:when test="params/action = '+mute_forum'">
                                                        запретил вам общаться на форуме в течение <xsl:value-of select="php:function('str_replace', 'h', ' ч', php:function('str_replace', 'd', ' д', string(params/period)))" />.
                                                    </xsl:when>
                                                    <xsl:when test="params/action = '-mute_forum'">
                                                        отменил запрет на общение на форуме.
                                                    </xsl:when>
                                                    <xsl:when test="params/action = '+mute_phone'">
                                                        запретил вам отправлять личные сообщения в течение <xsl:value-of select="php:function('str_replace', 'h', ' ч', php:function('str_replace', 'd', ' д', string(params/period)))" />.
                                                    </xsl:when>
                                                    <xsl:when test="params/action = '-mute_phone'">
                                                        отменил запрет на отправку личных сообщений.
                                                    </xsl:when>
                                                    <xsl:when test="params/action = '+mute_chat'">
                                                        запретил вам общаться в чате в течение <xsl:value-of select="php:function('str_replace', 'h', ' ч', php:function('str_replace', 'd', ' д', string(params/period)))" />.
                                                    </xsl:when>
                                                    <xsl:when test="params/action = '-mute_chat'">
                                                        отменил запрет на общение в чате.
                                                    </xsl:when>
													<xsl:when test="params/action = '+photo'">
                                                        разрешил Вашу фотографию.
                                                    </xsl:when>
													<xsl:when test="params/action = '-photo'">
                                                        отклонил Вашу фотографию.
                                                    </xsl:when>
													<xsl:when test="params/action = '+give_cert_changenickname'">
                                                        передал вам сертификат на бесплатную смену ника.
                                                    </xsl:when>
                                                </xsl:choose>
                                                <xsl:if test="params/text != ''"> Причина: <xsl:value-of select="params/text" />.</xsl:if>
                                            </td>
                                            <td class="actions">
												<xsl:if test="count(params/photo) > 0">
													<span class="button">
														<a class="f" href="/photos/{/data/player/id}/{params/photo}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">Фото</div>
														</a>
													</span>
												</xsl:if>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'autospam1'">
                                            <td class="text">
                                                На вас наложен запрет на отправку сообщений и общение в чате на 2 часа.
                                            </td>
                                            <td class="actions">
                                                
                                            </td>
                                        </xsl:when>


										<!-- photo -->
										<xsl:when test="type = 'photo_rated'">
                                            <td class="text">
                                                Игрок <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/player" /></xsl:call-template> оценил Вашу фотографию на <b><xsl:value-of select="params/value" /></b>. Вы получили <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /></xsl:call-template>.
                                            </td>
                                            <td class="actions">
												<span class="button">
                                                    <a class="f" href="/photos/{/data/player/id}/#{params/photo}"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Фото</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'photo_rated_by_you'">
                                            <td class="text">
                                                Вы оценили фотографию игрока <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/player" /></xsl:call-template> на <b><xsl:value-of select="params/value" /></b>, потратив на это <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="honey" select="params/honey" /></xsl:call-template>.
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
												<span class="button">
                                                    <a class="f" href="/photos/{params/player/id}/#{params/photo}"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Фото</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'photo_top_by_you'">
                                            <td class="text">
                                                Вы поместили в десяточку фотографию игрока <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/player" /></xsl:call-template>, потратив на это <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="honey" select="params/honey" /></xsl:call-template>.
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
												<span class="button">
                                                    <a class="f" href="/photos/{params/player/id}/#{params/photo}"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Фото</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- pet -->
                                        <xsl:when test="type = 'pet_dead'">
                                            <td class="text">
                                                Ваш питомец <b><xsl:value-of select="params/pet/name" /></b> получил травму в бою и теперь ему нужен отдых.
                                            </td>
                                            <td class="actions">
												<span class="button">
                                                    <a class="f" href="/petarena/train/{params/pet/id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Инфо</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'pet_train'">
											<td class="text">
												Вы натренировали <b><xsl:value-of select="params/s" /></b> своего питомца <b><xsl:value-of select="params/pet/n" /></b> до <b><xsl:value-of select="params/n" /></b>. Тренировка обошлась в <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/p/m" /><xsl:with-param name="ore" select="params/p/o" /><xsl:with-param name="oil" select="params/p/n" /><xsl:with-param name="honey" select="params/p/h" /></xsl:call-template>
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
											</td>
											<td class="actions">
												<span class="button">
													<a class="f" href="/petarena/train/{params/pet/id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div class="c">Инфо</div>
													</a>
												</span>
												<xsl:call-template name="logbutton" />
											</td>
										</xsl:when>
										<xsl:when test="type = 'pet_restore'">
											<td class="text">
												Вы сняли усталость своего питомца <b><xsl:value-of select="params/pet/n" /></b> за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/p/m" /><xsl:with-param name="ore" select="params/p/o" /><xsl:with-param name="oil" select="params/p/n" /><xsl:with-param name="honey" select="params/p/h" /></xsl:call-template>
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
											</td>
											<td class="actions">
												<span class="button">
													<a class="f" href="/petarena/train/{params/pet/id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div class="c">Инфо</div>
													</a>
												</span>
												<xsl:call-template name="logbutton" />
											</td>
										</xsl:when>
										<xsl:when test="type = 'pet_respawn'">
											<td class="text">
												Вы <xsl:choose><xsl:when test="params/r = 1"><b>полностью вылечили</b></xsl:when><xsl:otherwise>полечили</xsl:otherwise></xsl:choose> своего питомца <b><xsl:value-of select="params/pet/n" disable-escape-output="yes" /></b> за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/p/m" /><xsl:with-param name="ore" select="params/p/o" /><xsl:with-param name="oil" select="params/p/n" /><xsl:with-param name="honey" select="params/p/h" /></xsl:call-template>
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
											</td>
											<td class="actions">
												<span class="button">
													<a class="f" href="/petarena/train/{params/pet/id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div class="c">Инфо</div>
													</a>
												</span>
												<xsl:call-template name="logbutton" />
											</td>
										</xsl:when>
										<!-- police -->
                                        <xsl:when test="type = 'nickname_changed'">
                                            <td class="text">
                                                Вы сменили имя с «<b><xsl:value-of select="params/on" /></b>» на «<b><xsl:value-of select="params/n" /></b>»
												<xsl:if test="params/cert = 1">&#0160;бесплатно с помощью сертификата</xsl:if>.
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'avatar_changed'">
                                            <td class="text">
												<xsl:choose>
													<xsl:when test="params/f = 1">
														Вы сменили фракцию и аватар.
													</xsl:when>
													<xsl:otherwise>
														Вы сменили аватар.
													</xsl:otherwise>
												</xsl:choose>
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'plcvzt1' or type = 'plcvzt2'">
                                            <td class="text">
                                                Вы заплатили взятку милиционеру в размере <xsl:choose>
                                                    <xsl:when test="type = 'plcvzt1'">
                                                        <span class="tugriki"><xsl:value-of select="params/m" /><i></i></span>. Теперь временно Вы не вызываете
                                                        интереса у бдительных стражей правопорядка.
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        <xsl:if test="params/o > 0">&#0160;<span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if>
                                                        <xsl:if test="params/h > 0">&#0160;<span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>,
                                                        чтобы выйти из тюрьмы.
                                                    </xsl:otherwise>
                                                </xsl:choose>
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions"></td>
                                        </xsl:when>
                                        <xsl:when test="type = 'plcrel'">
                                            <td class="text">
                                                Вы наладили связи с милицией до <xsl:value-of select="params/dt" />, потратив на это
                                                <xsl:if test="params/o > 0">&#0160;<span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if>
                                                <xsl:if test="params/h > 0">&#0160;<span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions"></td>
                                        </xsl:when>
                                        <!-- home -->
                                        <xsl:when test="type = 'trvmhl'">
                                            <td class="text">
                                                Вы вылечились от травм, потратив на это <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions"></td>
                                        </xsl:when>
                                        <!-- neft -->
                                        <xsl:when test="type = 'nftnow'">
                                            <td class="text">
                                                Вы потратили <span class="med"><xsl:value-of select="params/h" /><i></i></span>, чтобы
                                                быстренько подкрасться к очередному Взяточнику и мгновенно его атаковать.
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions"></td>
                                        </xsl:when>
                                        <!-- training -->
                                        <xsl:when test="type = 'trainer_stat'">
                                            <td class="text">
                                                Вы прокачали характеристику «<b><xsl:choose>
                                                    <xsl:when test="params/stat = 'health'">Здоровье</xsl:when>
                                                    <xsl:when test="params/stat = 'strength'">Сила</xsl:when>
                                                    <xsl:when test="params/stat = 'dexterity'">Ловкость</xsl:when>
                                                    <xsl:when test="params/stat = 'resistance'">Выносливость</xsl:when>
                                                    <xsl:when test="params/stat = 'attention'">Внимательность</xsl:when>
                                                    <xsl:when test="params/stat = 'intuition'">Хитрость</xsl:when>
                                                    <xsl:when test="params/stat = 'charism'">Харизма</xsl:when>
                                                    <xsl:when test="params/s = 'h'">Здоровье</xsl:when>
                                                    <xsl:when test="params/s = 's'">Сила</xsl:when>
                                                    <xsl:when test="params/s = 'd'">Ловкость</xsl:when>
                                                    <xsl:when test="params/s = 'r'">Выносливость</xsl:when>
                                                    <xsl:when test="params/s = 'a'">Внимательность</xsl:when>
                                                    <xsl:when test="params/s = 'i'">Хитрость</xsl:when>
                                                    <xsl:when test="params/s = 'c'">Харизма</xsl:when>
                                                </xsl:choose></b>» до <b><xsl:value-of select="params/value" /><xsl:value-of select="params/v" /></b> за <xsl:choose><xsl:when test="params/m > 0">
                                                    <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/m" /></xsl:call-template></xsl:when>
                                                    <xsl:otherwise><xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /></xsl:call-template></xsl:otherwise>
                                                </xsl:choose>.
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/trainer/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Тренажер</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<!-- collection -->
                                        <xsl:when test="type = 'col_item'">
                                            <td class="text">
												Вы получили новый экземпляр «<b><xsl:value-of select="params/i" /></b>» в свою коллекцию «<b><xsl:value-of select="params/c" /></b>».
												<xsl:if test="params/image"><div class="objects"><img src="/@/images/obj/collections/{params/image}.png" /></div></xsl:if>
                                            </td>
                                            <td class="actions">
												<span class="button">
                                                    <a class="f" href="/home/collections/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Коллекции</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'col_made'">
                                            <td class="text">
												Вы полностью собрали коллекцию «<b><xsl:value-of select="params/n" /></b>». Поздравляем!
                                            </td>
                                            <td class="actions">
												<span class="button">
                                                    <a class="f" href="/home/collections/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Коллекции</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'ioshi'">
                                            <td class="text">
												Вы сыграли с Дедушкой Йоши, заплатив за это <span class="med"><xsl:value-of select="params/h" /><i></i></span>.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<!-- referer -->
										<xsl:when test="type = 'stud_lvlup'">
                                            <td class="text">
                                                Ваш ученик <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/p" /></xsl:call-template> достиг нового уровня.
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- naperstki -->
										<xsl:when test="type = 'nprstnew'">
                                            <td class="text">
												Вы
												<xsl:if test="params/m > 0">
													заплатили <span class="tugriki"><xsl:value-of select="params/m" /><i></i></span> за <xsl:value-of select="params/g2 + params/g9" />&#160;<xsl:value-of select="word_games" /><xsl:choose>
														<xsl:when test="params/o > 0">&#160;и</xsl:when>
														<xsl:otherwise>, но</xsl:otherwise>
													</xsl:choose>
												</xsl:if>
												<xsl:choose>
												<xsl:when test="params/o > 0">
													выиграли у Мони Шаца <span class="ruda"><xsl:value-of select="params/o" /><i></i></span>
												</xsl:when>
												<xsl:otherwise>
													ничего не выиграли у Мони Шаца.
												</xsl:otherwise>
												</xsl:choose>
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'nprst'">
                                            <td class="text">
												Вы начали новую партию игры в наперстки с Моней Шацом, заплатив за это <span class="tugriki"><xsl:value-of select="params/m" /><i></i></span>.
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'nprst1'">
                                            <td class="text">
                                                Вы угадали, под каким наперстком хитрый Моня Шац спрятал <span class="ruda">1<i></i></span>.
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'monya'">
                                            <td class="text">
                                                Вы начали играть в наперстки с Моней Шацом.
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'monyat'">
                                            <td class="text">
                                                Вы начали играть в наперстки с Моней Шацом за 1 билетик.
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<!-- automobile -->
										<xsl:when test="type = 'automobile_upgrade_factory'">
                                            <td class="text">
                                                Вы начали строительство <b><xsl:value-of select="params/factory" /></b> за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="oil" select="params/oil" /></xsl:call-template>.
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/automobile/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Автозавод</div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'automobile_upgrade_car'">
                                            <td class="text">
                                                Вы установили <b><xsl:value-of select="params/part" /></b> на <b><xsl:value-of select="params/carname" /></b> за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="oil" select="params/oil" /></xsl:call-template>.
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/automobile/car/{params/carid}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c"><xsl:value-of select="params/carname" /></div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'automobile_ride'">
                                            <td class="text">
                                                Вы поехали <b><xsl:value-of select="params/dir" /></b>.
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/automobile/ride/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Поездки</div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'automobile_buy_part'">
                                            <td class="text">
                                                Вы купили
												<b>«<xsl:value-of select="params/name" />»</b> (<xsl:value-of select="format-number(params/count, '###,###,###')" /> шт.)
												за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="oil" select="params/oil" /></xsl:call-template>.
												<div class="objects"><img src="{params/image}" alt="{params/name}" title="{params/name}" /></div>
												<!--
												<span class="object-thumb">
													<img src="{params/image}" alt="{params/name}"  tooltip="1" title="{params/name}||Полезная вещь в строительстве автомобильных цехов." />
													<span class="count"><xsl:value-of select="format-number(params/count, '###,###,###')" /></span>
												</span>
												-->
												<!--
												<span title="{params/name}: {params/count}"><xsl:value-of select="format-number(params/count, '###,###,###')" />&#0160;<img src="{params/image}" alt="{params/name}" title="{params/name}" style="width: 16px; height: 16px;" /></span>
												за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="oil" select="params/oil" /></xsl:call-template>.
												-->
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/automobile/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Автозавод</div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'automobile_upgrade_garage'">
                                            <td class="text">
                                                Вы купили место в гараже за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="oil" select="params/oil" /></xsl:call-template>.

												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/home/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Гараж</div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'automobile_buy_parts'">
                                            <td class="text">
                                                Вы купили
												<xsl:for-each select="params/parts/element">
													<b>«<xsl:value-of select="name" />»</b> (<xsl:value-of select="format-number(count, '###,###,###')" /> шт.)
													<xsl:if test="position() != last()">, </xsl:if>
												</xsl:for-each>
												и начали строительство <b><xsl:value-of select="params/factory" /></b> 
												за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="oil" select="params/oil" /></xsl:call-template>.

												<div class="objects">
													<xsl:for-each select="params/parts/element">
														<img src="{image}" alt="{name}"  title="{name}" />
														<xsl:if test="position() != last()">&#0160;</xsl:if>
													</xsl:for-each>
												</div>

												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/automobile/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Автозавод</div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'automobile_finish_building'">
                                            <td class="text">
                                                Вы ускорили строительство <b><xsl:value-of select="params/factory" /></b> за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="oil" select="params/oil" /></xsl:call-template>.
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/automobile/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Автозавод</div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'automobile_upgrade_factory_end'">
                                            <td class="text">
                                                Строительство <b><xsl:value-of select="params/factory" /></b> завершено.
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/automobile/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Автозавод</div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'automobile_buy_number'">
                                            <td class="text">
                                                Вы купили номер <b><xsl:value-of select="params/number" /></b> для <b><xsl:value-of select="params/carname" /></b> за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="oil" select="params/oil" /></xsl:call-template>.
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/automobile/car/{params/carid}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c"><xsl:value-of select="params/carname" /></div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'automobile_change_number'">
                                            <td class="text">
                                                Вы установили номер <b><xsl:value-of select="params/number" /></b> на <b><xsl:value-of select="params/carname" /></b>.
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/automobile/car/{params/carid}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c"><xsl:value-of select="params/carname" /></div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'automobile_create_car'">
                                            <td class="text">
                                                Вы начали сборку <b><xsl:value-of select="params/carname" /></b> за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="oil" select="params/oil" /></xsl:call-template>.
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/automobile/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Автозавод</div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'automobile_sell_car'">
                                            <td class="text">
                                                Вы продали <b><xsl:value-of select="params/carname" /></b> за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="oil" select="params/oil" /></xsl:call-template>.
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/home/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Гараж</div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'automobile_create_car_end'">
                                            <td class="text">
                                                Завершена сборка <b><xsl:value-of select="params/carname" /></b>.
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/automobile/car/{params/carid}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c"><xsl:value-of select="params/carname" /></div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<xsl:when test="type = 'automobile_buy_petrol'">
                                            <td class="text">
                                                Вы заправили бак <b><xsl:value-of select="params/carname" /></b> за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="oil" select="params/oil" /></xsl:call-template>.
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/automobile/car/{params/carid}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c"><xsl:value-of select="params/carname" /></div>
                                                    </a>
                                                </span>
                                            </td>
										</xsl:when>
										<!-- casino -->
										<!--
										<xsl:when test="type = 'casino_kubovich_prize'">
                                            <td class="text">
                                                Вы выиграли у Кубовича «<b><xsl:value-of select="params/name" /></b>»<xsl:if test="params/amount > 1"> (<xsl:value-of select="params/amount" /> шт.)</xsl:if>.
												<xsl:if test="params/image"><div class="objects"><img src="{params/image}" width="32" /></div></xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/casino/kubovich/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Кубович</div>
                                                    </a>
                                                </span>
                                            </td>
                                        </xsl:when>
										-->
										<xsl:when test="type = 'casino_kubovich_prize'">
                                            <td class="text">
												<xsl:value-of select="params/text" disable-output-escaping="yes" />
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/casino/kubovich/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Кубович</div>
                                                    </a>
                                                </span>
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'casino_sportloto_get_ticket'">
                                            <td class="text">
												Вы купили билет «Спортлото».
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/casino/sportloto/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Спортлото</div>
                                                    </a>
                                                </span>
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'casino_sportloto_get_prize'">
                                            <td class="text">
												Вы получили выигрыш <span class="fishki"><xsl:value-of select="format-number(params/prize, '###,###,###')" /><i></i></span>.
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/casino/sportloto/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Спортлото</div>
                                                    </a>
                                                </span>
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'casino_exchange_ore'">
                                            <td class="text">
                                                Вы обменяли <span class="ruda"><xsl:value-of select="format-number(params/in, '###,###,###')" /><i></i></span> на <span class="fishki"><xsl:value-of select="format-number(params/out, '###,###,###')" /><i></i></span> в кассе казино.
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/casino/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Казино</div>
                                                    </a>
                                                </span>
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'casino_exchange_honey'">
                                            <td class="text">
                                                Вы обменяли <span class="med"><xsl:value-of select="format-number(params/in, '###,###,###')" /><i></i></span> на <span class="fishki"><xsl:value-of select="format-number(params/out, '###,###,###')" /><i></i></span> в кассе казино.
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/casino/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Казино</div>
                                                    </a>
                                                </span>
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'casino_exchange_chip'">
                                            <td class="text">
                                                Вы обменяли <span class="fishki"><xsl:value-of select="format-number(params/in, '###,###,###')" /><i></i></span> на <span class="ruda"><xsl:value-of select="format-number(params/out, '###,###,###')" /><i></i></span> в кассе казино.
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/casino/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Казино</div>
                                                    </a>
                                                </span>
                                            </td>
                                        </xsl:when>
					
					<!-- mesege -->
                                        <xsl:when test="type = 'messeg'">
					    <td class="text">
					    <b><font style="color:red"><xsl:value-of select="params/text" /></font></b>
					    </td>
                                        </xsl:when>

                                        <!-- shop -->
                                        <xsl:when test="type = 'item_bought'">
                                            <td class="text">
                                                Вы купили предмет «<b><xsl:value-of select="params/name" /></b>»<xsl:if test="params/amount > 1"> (<xsl:value-of select="params/amount" /> шт.)</xsl:if> за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /><xsl:with-param name="war_zub" select="params/war_zub" /><xsl:with-param name="war_goldenzub" select="params/war_goldenzub" /><xsl:with-param name="fight_star" select="params/fight_star" /><xsl:with-param name="huntclub_mobile" select="params/huntclub_mobile" /><xsl:with-param name="oil" select="params/oil" /><xsl:with-param name="huntclub_badge" select="params/huntclub_badge" /></xsl:call-template>.
												<xsl:if test="params/image"><div class="objects"><img src="/@/images/obj/{params/image}" /></div></xsl:if>
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/player/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Инвентарь</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'item_sold'">
                                            <td class="text">
                                                Вы продали предмет «<b><xsl:value-of select="params/name" /></b>» за <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /></xsl:call-template>.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/player/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Инвентарь</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- items: auto use, expire, drop -->
										<xsl:when test="type = 'item_used'">
                                            <td class="text">
												<xsl:choose>
													<xsl:when test="params/code = 'clan_malahoff'"></xsl:when>
													<xsl:when test="params/code = 'clan_embulance'"></xsl:when>
													<xsl:when test="params/code = 'clan_timemashine' or params/code = 'clan_krot' or params/code = 'clan_ksiva'">
														<xsl:choose>
															<xsl:when test="params/you = 'attacker'">
																Вы использовали предмет «<b><xsl:value-of select="params/name" /></b>» на игрока <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/player" /></xsl:call-template>.
															</xsl:when>
															<xsl:when test="params/you = 'defender'">
																Игрок <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/player" /></xsl:call-template> использовал на Вас предмет «<b><xsl:value-of select="params/name" /></b>».
															</xsl:when>
														</xsl:choose>
													</xsl:when>
                                                    <xsl:otherwise>Использован предмет «<b><xsl:value-of select="params/n" /></b>».</xsl:otherwise>
												</xsl:choose>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<xsl:when test="type = 'item_got'">
                                            <td class="text">
												<xsl:value-of select="params/text" disable-output-escaping="yes" />
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'item_autoused'">
                                            <td class="text">
												<xsl:choose>
													<!--xsl:when test="params/code = 'clan_malahoff'">Автоматически использована мазь Малахофф++.</xsl:when-->
													<xsl:when test="params/code = 'clan_embulance'">Вас увезли на Скорой.</xsl:when>
													<xsl:when test="count(params/text) = 1"><xsl:value-of select="params/text" disable-output-escaping="yes" /></xsl:when>
													<xsl:otherwise>Автоматически использован предмет «<b><xsl:value-of select="params/name" /></b>».</xsl:otherwise>
												</xsl:choose>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/player/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Инвентарь</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'item_expired'">
                                            <td class="text">
                                                У предмета «<b><xsl:value-of select="params/name" /></b>» истек срок годности.
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/player/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Инвентарь</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- mac -->
                                        <xsl:when test="type = 'macdonalds_endwork'">
                                            <td class="text">
                                                За смену в Шаурбургерсе вы получили <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /></xsl:call-template>
                                                <xsl:if test="params/exp > 0">
                                                    <span class="expa"><xsl:value-of select="params/exp" /><i></i></span>
                                                </xsl:if>
                                                .
												<xsl:if test="count(params/mbckp) > 0">
													<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
												</xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/shaurburgers/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Шаурбургерс</div>
                                                    </a>
                                                </span>
                                                <span class="button">
                                                    <a class="f" href="/player/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Профиль</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- patrol -->
                                        <xsl:when test="type = 'patrol_endwork'">
                                            <td class="text">
                                                <xsl:choose>
                                                    <xsl:when test="params/exp = 0 and params/money = 0">
                                                        Вы ничего не получили за патрулирование.
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        За патрулирование вы получили <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /></xsl:call-template>
                                                        <xsl:if test="params/exp > 0">
                                                            <span class="expa"><xsl:value-of select="params/exp" /><i></i></span>
                                                        </xsl:if>.
														<xsl:if test="count(params/mbckp) > 0">
															<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
														</xsl:if>
                                                    </xsl:otherwise>
                                                </xsl:choose>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/alley/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Закоулки</div>
                                                    </a>
                                                </span>
                                                <span class="button">
                                                    <a class="f" href="/player/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Профиль</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- podarki -->
                                        <xsl:when test="type = 'gift_gaven'">
                                            <td class="text">
                                                Вы подарили подарок «<b><xsl:value-of select="params/name" /></b>» игроку <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/player" /></xsl:call-template> стоимостью <xsl:call-template name="showprice"><xsl:with-param name="nohoney" select="1" /><xsl:with-param name="money" select="params/money" /><xsl:with-param name="ore" select="params/ore" /><xsl:with-param name="honey" select="params/honey" /></xsl:call-template>.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/player/{params/player/id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Профиль игрока</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'gift_taken'">
                                            <td class="text">
                                                Вы получили подарок «<b><xsl:value-of select="params/name" /></b>»
                                                <xsl:if test="params/player/id > 0"> от игрока <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/player" /></xsl:call-template></xsl:if>
                                                <xsl:if test="params/cmnt != ''"> с комментарием «<b><xsl:value-of select="params/cmnt" /></b>»</xsl:if>
                                                .
												<xsl:if test="params/image"><div class="objects"><img src="/@/images/obj/{params/image}" /></div></xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:if test="params/cmnt != ''">
													<span class="button">
														<a class="f" href="/player/giftcomplain/{params/id}/{/data/dt}{id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">Пожаловаться</div>
														</a>
													</span>
                                                    <span class="button">
                                                        <a class="f" href="/player/clearpresent/{params/id}/{/data/dt}{id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Очистить комментарий</div>
                                                        </a>
                                                    </span>
                                                </xsl:if>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'gift_approve'">
                                            <td class="text">
                                                Вы получили подарок «<b><xsl:value-of select="params/name" /></b>»
                                                <xsl:if test="params/player/id > 0"> от игрока <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/player" /></xsl:call-template></xsl:if>
                                                <xsl:if test="params/cmnt != ''"> с комментарием «<b><xsl:value-of select="params/cmnt" /></b>»</xsl:if>
                                                .
												<xsl:if test="params/image"><div class="objects"><img src="/@/images/obj/{params/image}" /></div></xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/player/giftaccept/{params/id}/{/data/dt}{id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Принять</div>
                                                    </a>
                                                </span>
                                                <span class="button">
                                                    <a class="f" href="/player/giftcancel/{params/id}/{/data/dt}{id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Отклонить</div>
                                                    </a>
                                                </span>
                                                <span class="button">
                                                    <a class="f" href="/player/giftcomplain/{params/id}/{/data/dt}{id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Пожаловаться</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- home -->
                                        <xsl:when test="type = 'trvm'">
                                            <td class="text">
                                                Из-за чрезмерного перенапряжения в постоянных боях вы получили травму на 12 часов.
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="homebutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'rbbt1'">
                                            <td class="text">
                                                Вы сняли с себя все эффекты от негативных подарков за <span class="med"><xsl:value-of select="params/h" /><i></i></span>.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="homebutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'rbbt2'">
                                            <td class="text">
                                                Вы купили защиту от негативных подарков на <xsl:value-of select="params/d" /> <xsl:choose>
                                                    <xsl:when test="params/d = 3">дня</xsl:when><xsl:otherwise>дней</xsl:otherwise>
                                                </xsl:choose> за <span class="med"><xsl:value-of select="params/h" /><i></i></span>.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="homebutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- level up -->
                                        <xsl:when test="type = 'level_up'">
                                            <td class="text">
                                                Поздравляем! Вы перешли на <xsl:value-of select="params/level" /> уровень.
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/player/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Профиль</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- korovan -->
                                        <xsl:when test="type = 'caravan_success'">
                                            <td class="text">
                                                Глупые верблюды поддались вам, и вы ограбили караван. Ваша добыча: <xsl:call-template name="showprice"><xsl:with-param name="money" select="params/money" /></xsl:call-template>.
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/alley/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Закоулки</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'caravan_fail'">
                                            <td class="text">
                                                Верблюды запутали вас в трех кактусах, и вы отстали от них. Добыча упущена!
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/alley/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Закоулки</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- metro -->
                                        <xsl:when test="type = 'metro_success'">
                                            <td class="text">
                                                Вы были упорны и потны, и за это судьба наградила вас подарком из метро в размере <xsl:call-template name="showprice"><xsl:with-param name="ore" select="params/ore" /></xsl:call-template>.
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/metro/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Метро</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'metro_fail'">
                                            <td class="text">
                                                Вы копали долго и усердно, но, увы, не там!
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/metro/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Метро</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- group fight -->
                                        <xsl:when test="type = 'groupfight'">
                                            <td class="text">
                                                <xsl:choose>
                                                    <xsl:when test="params/t = 'bank'">Вы участвовали в ограблении банка.</xsl:when>
                                                    <xsl:otherwise>Вы участвовали в групповом бою.</xsl:otherwise>
                                                </xsl:choose>&#0160;<xsl:choose>
                                                    <xsl:when test="params/w = 1">Ваша сторона победила.</xsl:when>
                                                    <xsl:when test="params/w = 2">Ваша сторона проиграла.</xsl:when>
                                                    <xsl:otherwise>Бой закончился в ничью.</xsl:otherwise>
                                                </xsl:choose> 
                                                <xsl:if test="params/t = 'flag'">
                                                    <xsl:choose>
                                                        <xsl:when test="params/f/r = 0 and /data/player/id = params/f/p/id"> Вы сохранили флаг.</xsl:when>
                                                        <xsl:when test="params/f/r = 0 and /data/player/fr = params/f/p/fr"> Ваши союзники сохранили флаг.</xsl:when>
                                                        <xsl:when test="params/f/r = 0 and /data/player/fr != params/f/p/fr"> Ваши враги сохранили флаг.</xsl:when>
                                                        <xsl:when test="params/f/r = 1 and /data/player/id = params/f/p/id"> Вы захватили флаг.</xsl:when>
                                                        <xsl:when test="params/f/r = 1 and /data/player/fr = params/f/p/fr"> Ваши союзники захватили флаг.</xsl:when>
                                                        <xsl:when test="params/f/r = 1 and /data/player/fr != params/f/p/fr"> Ваши враги захватили флаг.</xsl:when>
                                                    </xsl:choose> <xsl:if test="/data/player/id != params/f/p/id"> Сейчас флаг находится у <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/f/p" /></xsl:call-template>.</xsl:if>
                                                </xsl:if>
                                                <xsl:if test="params/xp > 0"><br />За бой вы получили <span class="expa"><xsl:value-of select="params/xp" /><i></i></span></xsl:if>
                                                <xsl:if test="params/as > 0"><br />За победу вы получили награду <span class="star"><xsl:value-of select="params/as" /><i></i></span></xsl:if>
                                                <xsl:if test="(params/t = 'level' or params/t = 'chaotic') and params/a = 1">
                                                    <br />Вы получили награду&#0160;
                                                    <xsl:if test="params/am > 0"><span class="tugriki"><xsl:value-of select="params/am" /><i></i></span></xsl:if>
                                                    <xsl:if test="params/ao > 0"><span class="ruda"><xsl:value-of select="params/ao" /><i></i></span></xsl:if>
                                                    <xsl:if test="params/an > 0"><span class="neft"><xsl:value-of select="params/an" /><i></i></span></xsl:if>
                                                    <xsl:if test="count(params/mbckp) > 0">
                                                        <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                    </xsl:if>
                                                </xsl:if>
                                                <xsl:if test="params/t = 'bank' and params/a = 1">
                                                    <br />Вы ограбили банк на <span class="tugriki"><xsl:value-of select="format-number(params/am, '###,###,###')" /><i></i></span>
                                                    <xsl:if test="count(params/mbckp) > 0">
                                                        <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                    </xsl:if>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/fight/{params/id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Лог боя</div>
                                                    </a>
                                                </span>
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'gfdpst'">
                                            <td class="text">
                                                <xsl:choose><xsl:when test="params/op = 'dpst'">Вы внесли </xsl:when><xsl:when test="params/op = 'rtn'">Вам вернулся взнос в размере </xsl:when></xsl:choose>
                                                <xsl:if test="params/m > 0">&#0160;<span class="tugriki"><xsl:value-of select="params/m" /><i></i></span></xsl:if>
                                                <xsl:if test="params/o > 0">&#0160;<span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if>
                                                <xsl:if test="params/h > 0">&#0160;<span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>
												<xsl:if test="params/zub > 0">&#0160;<span class="tooth-white"><xsl:value-of select="params/zub" /><i></i></span></xsl:if>
												<xsl:if test="params/badge > 0">&#0160;<span class="badge"><xsl:value-of select="params/badge" /><i></i></span></xsl:if>
                                                за участие в групповом бою.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'gfout'">
                                            <td class="text">
                                                Более сильные игроки оттеснили вас от эпицентра событий, вы не смогли принять участия в <xsl:choose>
                                                    <xsl:when test="params/t = 'flag'">битве за флаг</xsl:when>
                                                    <xsl:otherwise>групповом бою</xsl:otherwise>
                                                </xsl:choose>.
                                            </td>
                                            <td class="actions">
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'bfdpst'">
                                            <td class="text">
                                                Вы дали взятку охраннику банка в размере <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span>.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'gchfcnld'">
                                            <td class="text">
                                                Групповой хаотичный бой был отменен из-за того, что не набралось 10 человек. Вам возвращен ваш взнос
                                                за участие в бое — <xsl:if test="params/m > 0">&#0160;<span class="tugriki"><xsl:value-of select="params/m" /><i></i></span></xsl:if>
                                                <xsl:if test="params/o > 0">&#0160;<span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if>
                                                <xsl:if test="params/h > 0">&#0160;<span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>
												<xsl:if test="params/zub > 0">&#0160;<span class="tooth-white"><xsl:value-of select="params/zub" /><i></i></span></xsl:if>
												<xsl:if test="params/badge > 0">&#0160;<span class="badge"><xsl:value-of select="params/badge" /><i></i></span></xsl:if>
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                            </td>
                                        </xsl:when>
                                        <!-- stash -->
                                        <xsl:when test="type = 'honey'">
                                            <td class="text">
                                                Вы добыли <span class="med"><xsl:value-of select="params/h" /><i></i></span>.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'h2m' or type = 'honey2m'">
                                            <td class="text">
                                                Вы обменяли <span class="med"><xsl:value-of select="params/h" /><i></i></span> на <span class="tugriki"><xsl:value-of select="params/m" /><i></i></span>.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'mjr'">
                                            <td class="text">
                                                Вы оплатили свой привилегированный статус Мажора до <xsl:value-of select="params/dt" /> за <span class="med"><xsl:value-of select="params/h" /><i></i></span>.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                            </td>
                                        </xsl:when>
                                        <!-- police -->
										<xsl:when test="type = 'avatar_changed'">
                                            <td class="text">
												Вы изменили аватар за <span class="med"><xsl:value-of select="params/honey" /><i></i></span>
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
										<!-- unlock -->
										<xsl:when test="type = 'unlock'">
                                            <td class="text">
												Вы платно разблокировались за <span class="med"><xsl:value-of select="params/honey" /><i></i></span>
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">

                                            </td>
                                        </xsl:when>
                                        <!-- factory -->
                                        <xsl:when test="type = 'ptrk1'">
                                            <td class="text">
												Вы начали производство <xsl:if test="params/p2 > 0"><span class="petric"><xsl:value-of select="params/p2" /><i></i></span></xsl:if>нано-петриков на заводе, потратив на это
                                                    <span class="tugriki"><xsl:value-of select="params/m" /><i></i></span>&#0160;
                                                    <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if>&#0160;
                                                    <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>
												.
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'ptrk2'">
                                            <td class="text">
												<xsl:choose>
													<xsl:when test="params/i = 1">
														Воспользовавшись сертификатом, вы смогли моментально сварить <span class="petric"><xsl:value-of select="params/p2" /><i></i></span>нано-петриков. На это вы потратили <span class="tugriki"><xsl:value-of select="params/m" /><i></i></span>&#0160;<xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if>&#0160;<xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.
													</xsl:when>
													<xsl:otherwise>
														Производство <xsl:if test="params/p2 > 0"><span class="petric"><xsl:value-of select="params/p2" /><i></i></span></xsl:if>нано-петриков завершено.
													</xsl:otherwise>
												</xsl:choose>
												Итого у вас <span class="petric"><xsl:value-of select="params/p" /><i></i></span>
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'sklup'">
                                            <td class="text">
                                                <xsl:choose>
                                                    <xsl:when test="params/t = 'mf'">
                                                        Вы увеличили свой навык модификаций.<br />
                                                        Навык мф.: <xsl:value-of select="params/v" />. Звание: <xsl:value-of select="params/n" />
                                                    </xsl:when>
													<xsl:when test="params/t = 'grn'">
                                                        Вы увеличили свой навык подрывника.<br />
                                                        Навык подрываника.: <xsl:value-of select="params/v" />. Звание: <xsl:value-of select="params/n" />
                                                    </xsl:when>
                                                </xsl:choose>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="factorybutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'skllvl'">
                                            <td class="text">
                                                <xsl:choose>
                                                    <xsl:when test="params/t = 'mf'">
                                                        Поздравляем! Вы упорно трудились и получили новое звание: <xsl:value-of select="params/n" />.<br />
														Теперь ваши модификации станут еще удачливее.
                                                    </xsl:when>
													<xsl:when test="params/t = 'grn'">
                                                        Поздравляем! Вы упорно трудились и получили новое звание: <xsl:value-of select="params/n" />.<br />
														Теперь ваши броски станут еще удачливее.
                                                    </xsl:when>
                                                </xsl:choose>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="factorybutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'itmmf'">
                                            <td class="text">
                                                Вы провели <xsl:value-of select="params/i/mf" />-е улучшение предмета <xsl:value-of select="params/i/n" />:<br />
                                                    <xsl:choose>
                                                        <xsl:when test="params/i/t = 'tech'">Шанс использования</xsl:when>
                                                        <xsl:otherwise>
                                                            <xsl:choose>
                                                                <xsl:when test="params/mf/s = 'h'">Здоровье</xsl:when>
                                                                <xsl:when test="params/mf/s = 's'">Сила</xsl:when>
                                                                <xsl:when test="params/mf/s = 'd'">Ловкость</xsl:when>
                                                                <xsl:when test="params/mf/s = 'r'">Выносливость</xsl:when>
                                                                <xsl:when test="params/mf/s = 'i'">Хитрость</xsl:when>
                                                                <xsl:when test="params/mf/s = 'a'">Внимательность</xsl:when>
                                                                <xsl:when test="params/mf/s = 'c'">Харизма</xsl:when>
                                                            </xsl:choose>
                                                        </xsl:otherwise>
                                                    </xsl:choose>: +<xsl:value-of select="params/mf/ss" /> (+<xsl:value-of select="params/mf/sf" />),
                                                    <xsl:choose>
                                                        <xsl:when test="params/mf/r = 'rc'">Рейтинг критических ударов</xsl:when>
                                                        <xsl:when test="params/mf/r = 'rd'">Рейтинг уворота</xsl:when>
                                                        <xsl:when test="params/mf/r = 'rr'">Рейтинг защиты</xsl:when>
                                                        <xsl:when test="params/mf/r = 'rac'">Рейтинг защиты от критических ударов</xsl:when>
                                                        <xsl:when test="params/mf/r = 'rdm'">Рейтинг урона</xsl:when>
                                                        <xsl:when test="params/mf/r = 'ra'">Рейтинг точности</xsl:when>
                                                    </xsl:choose>: +<xsl:value-of select="params/mf/rr" /> (+<xsl:value-of select="params/mf/rf" />)
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="factorybutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'player_protect'">
                                            <td class="text">
                                                Вы успешно защитили своего персонажа.
                                            </td>
                                            <td class="actions">
                                                <span class="button">
                                                    <a class="f" href="/player/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Профиль</div>
                                                    </a>
                                                </span>
                                            </td>
                                        </xsl:when>
                                        <!-- trainer -->
                                        <xsl:when test="type = 'trnrvp'">
                                            <td class="text">
                                                Вы оплатили ВИП-абонемент в фитнесс-центре до <xsl:value-of select="params/dt" />.
                                                <xsl:if test="params/a > 0"><br />В качестве бонус вы получили <span class="anabolic">50<i></i></span>.</xsl:if>
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="fitnessvipbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'trnrbnbl'">
                                            <td class="text">
                                                <xsl:choose>
                                                    <xsl:when test="params/auto = 1">Автоматически куплены</xsl:when>
                                                    <xsl:otherwise>Вы купили</xsl:otherwise>
                                                </xsl:choose>&#0160;<span class="anabolic"><xsl:value-of select="params/a" /><i></i></span> за
                                                <xsl:if test="params/p > 0"><span class="petric"><xsl:value-of select="params/p" /><i></i></span></xsl:if>&#0160;
                                                    <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="fitnessvipbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'trnrsttr'">
                                            <td class="text">
                                                Вы начали тренироваться согласно программе, предусматривающей поедание
                                                <span class="anabolic"><xsl:value-of select="params/a" /><i></i></span>.
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="fitnessvipbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'trnrfntr'">
                                            <td class="text">
                                                <xsl:choose>
                                                    <xsl:when test="params/a > 0">
                                                        Вы усердно тренировались согласно персональной программе, предусматривающей поедание
                                                        <span class="anabolic"><xsl:value-of select="params/a" /><i></i></span>, и прокачали:
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        Вы отдохнули после усиленной тренировки и снова готовы к физическим нагрузкам.
                                                    </xsl:otherwise>
                                                </xsl:choose>
                                                <xsl:if test="count(params/s/h) > 0"><br />Здоровье: +<xsl:value-of select="params/s/h/c" /></xsl:if>
                                                <xsl:if test="count(params/s/s) > 0"><br />Сила: +<xsl:value-of select="params/s/s/c" /></xsl:if>
                                                <xsl:if test="count(params/s/d) > 0"><br />Ловкость: +<xsl:value-of select="params/s/d/c" /></xsl:if>
                                                <xsl:if test="count(params/s/r) > 0"><br />Выносливость: +<xsl:value-of select="params/s/r/c" /></xsl:if>
                                                <xsl:if test="count(params/s/i) > 0"><br />Хитрость: +<xsl:value-of select="params/s/i/c" /></xsl:if>
                                                <xsl:if test="count(params/s/a) > 0"><br />Внимательность: +<xsl:value-of select="params/s/a/c" /></xsl:if>
                                                <xsl:if test="count(params/s/c) > 0"><br />Харизма: +<xsl:value-of select="params/s/c/c" /></xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="fitnessvipbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- bank -->
                                        <xsl:when test="type = 'bnkactv'">
                                            <td class="text">
                                                Вы оплатили срок пользования банковской ячейкой до <xsl:value-of select="params/dt" />.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="bankbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'bnkpt'">
                                            <td class="text">
                                                Вы положили в свою банковскую ячейку <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span>.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="bankbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'bnkcl'">
                                            <td class="text">
                                                Ваш банковский счет закрыт, так как после последнего ограбления на нем осталось менее <span class="tugriki">50<i></i></span>.
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="bankbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'bnktk'">
                                            <td class="text">
                                                Вы забрали из своей банковской ячейки <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span>.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="bankbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'bnkm2o'">
                                            <td class="text">
                                                Вы купили в банке <span class="ruda"><xsl:value-of select="format-number(params/o, '###,###')" /><i></i></span> за
                                                <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span>, использовав при этом
                                                1 сертификат.
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="bankbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- -->
                                        <xsl:when test="type = 'addmn'">
                                            <td class="text">
                                                Вам начислено <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span>.
                                                <xsl:if test="string-length(params/i) != 0" ><br />Причина: <xsl:value-of select="params/i" />.</xsl:if>
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="bankbutton" />
                                            </td>
                                        </xsl:when>
										<!-- quiz_won -->
										<xsl:when test="type = 'quiz_won'">
                                            <td class="text">
												Поздравляем! Вы победили в викторине!
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="logbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- huntclub -->
										<xsl:when test="type = 'hntclbm'">
                                            <td class="text">
												Вы оплатили свое участие в Охотничьем клубе до <xsl:value-of select="params/dt" />, потратив на это
                                                <xsl:if test="params/o > 0">&#0160;<span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if>
                                                <xsl:if test="params/h > 0">&#0160;<span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="huntclubbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'hntclbz'">
                                            <td class="text">
												Вы заказали в Охотничьем клубе игрока <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/p" /></xsl:call-template>, потратив на это
                                                <xsl:if test="params/m > 0">&#0160;<span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span></xsl:if>
                                                <xsl:if test="params/o > 0">&#0160;<span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if>
                                                <xsl:if test="params/h > 0">&#0160;<span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="huntclubbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'hntclbz2'">
                                            <td class="text">
												Вас заказали в Охотничьем клубе.
                                            </td>
                                            <td class="actions">
										        <span class="button">
										            <a class="f" href="/huntclub/me/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										                <div class="c">Заказы</div>
										            </a>
										        </span>
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'hntclbf'">
                                            <td class="text">
												Вы откупились от заказа на вас в охотничьем клубе, потратив на это
                                                <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span>.
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="huntclubbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'hntclbo'">
                                            <td class="text">
												Вы открыли заказавшего вас в охотничьем клубе, потратив на это <span class="med"><xsl:value-of select="params/h" /><i></i></span>.
												<xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="huntclubbutton" />
                                            </td>
                                        </xsl:when>
                                        <!-- sovet -->
                                        <xsl:when test="type = 'svtmb1'">
                                            <td class="text">
                                                Вы были выбраны в качестве члена Совета.
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="sovetbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'svtsvtvt'">
                                            <td class="text">
                                                Вы проголосовали за игрока <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/p" /></xsl:call-template>
                                                на выборах в Совет, потратив на это <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span>
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="sovetbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'svtsvtvtglv'">
                                            <td class="text">
                                                Вы проголосовали за игрока <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/p" /></xsl:call-template>
                                                на выборах главы Совета
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="sovetbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'svtmtvt'">
                                            <td class="text">
                                                Вы проголосовали за <b><xsl:value-of select="params/n" /></b> район при выборе района для атаки,
                                                потратив на это <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span>
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="sovetbutton" />
                                            </td>
                                        </xsl:when>
                                        <xsl:when test="type = 'svtdpst'">
                                            <td class="text">
                                                Вы сделали добровольный взнос в казну Совета в размере
                                                <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span>
                                                <xsl:if test="count(params/mbckp) > 0">
                                                    <xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
                                                </xsl:if>
                                            </td>
                                            <td class="actions">
                                                <xsl:call-template name="sovetbutton" />
                                            </td>
                                        </xsl:when>

										<xsl:when test="type = 'stat_stimulator'">
                                            <td class="text">
                                                Вы съели вкусный пельмень и смогли увеличить вашу характеристику <b><xsl:value-of select="params/stat" /></b> до <b><xsl:value-of select="params/value" /></b>.
                                            </td>
                                            <td class="actions">
                                            </td>
                                        </xsl:when>
                                    </xsl:choose>
                                </xsl:element>
                            </xsl:for-each>
                        </table>

                                <xsl:call-template name="paginator">
                                    <xsl:with-param name="pages" select="pages" />
                                    <xsl:with-param name="page" select="page" />
                                    <xsl:with-param name="link" select="concat('/phone/logs/', dt, '/')" />
                                </xsl:call-template>
                       
                    </xsl:when>
                    <xsl:otherwise>
                        <p>Пока Ваше существование в Москве ничем особым не приметилось.</p>
                    </xsl:otherwise>
                </xsl:choose>
            </div>
        </div>
	</xsl:template>

    <xsl:template name="logs_duels">
        <div class="messages">
            <div class="block-rounded">
                <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                <a name="logs"></a>
                <h3>Дуэли</h3>

				<div class="pagescroll" style="text-align: center; margin:5px 0;">
					<xsl:for-each select="dates/element">
						<xsl:choose>
							<xsl:when test="/data/dt = dt"><strong class="current"><xsl:value-of select="title" /></strong><![CDATA[ ]]></xsl:when>
							<xsl:otherwise><a href="/phone/duels/{dt}/"><xsl:value-of select="title" /></a><![CDATA[ ]]></xsl:otherwise>
						</xsl:choose>
					</xsl:for-each>
				</div>

                <xsl:choose>
                    <xsl:when test="count(logs/element) > 0">
                        <table class="messages-list">
                            <xsl:for-each select="logs/element">
								<!-- Костыль чтобы не дублировать из клуба выполненный заказ. Нельзя его убирать, т.к. на этот лог завязано количество выполненных заказов -->
								<xsl:if test="type != 'fighthntclb'">
									<xsl:element name="tr">
										<xsl:if test="read = 0">
											<xsl:attribute name="class">new</xsl:attribute>
										</xsl:if>
										<td class="date"><xsl:value-of select="datetime" /></td>
										<xsl:choose>
											<!-- alley -->
											<xsl:when test="type = 'fight_attacked'">
												<td class="text">
													<xsl:choose>
														<xsl:when test="params/player/fraction = 'npc'">
															Вы вступили в схватку с <xsl:call-template name="npclink"><xsl:with-param name="player" select="params/player" /></xsl:call-template>
														</xsl:when>
														<xsl:otherwise>
															<xsl:if test="params/werewolf = 1"><i class="npc-werewolf" title="Оборотень"></i></xsl:if>
															Вы напали на игрока <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/player" /></xsl:call-template>
														</xsl:otherwise>
													</xsl:choose> <xsl:choose><xsl:when test="params/result = 'win'"> и одержали победу.</xsl:when><xsl:when test="params/result = 'loose'"> и потерпели поражение.</xsl:when><xsl:otherwise>, но никто не победил.</xsl:otherwise></xsl:choose>
													<xsl:if test="params/result = 'win' and (params/exp > 0 or params/profit > 0 or params/zub = 1 or (string-length(params/carpart) != 0 and count(params/carpart) != 0) )">
														<br/>Вы получили <xsl:choose>
															<xsl:when test="params/pft != ''">
																<xsl:if test="params/pft/m > 0">
																	<span class="tugriki" title="Монеты: {params/pft/m}"><xsl:value-of select="format-number(params/pft/m, '###,###,###')" /><i></i></span>
																</xsl:if>
																<xsl:if test="params/pft/o > 0">
																	<span class="ruda" title="Руда: {params/pft/o}"><xsl:value-of select="format-number(params/pft/o, '###,###,###')" /><i></i></span>
																</xsl:if>
																<xsl:if test="params/pft/n > 0">
																	<span class="neft" title="Нефть: {params/pft/n}"><xsl:value-of select="format-number(params/pft/n, '###,###,###')" /><i></i></span>
																</xsl:if>
																<xsl:if test="params/exp > 0">
																	<span class="expa"><xsl:value-of select="params/exp" /><i></i></span>
																</xsl:if>
															</xsl:when>
															<xsl:otherwise>
																<xsl:call-template name="showprice">
																	<xsl:with-param name="money" select="params/profit" />
																	<xsl:with-param name="exp" select="params/exp" />
																</xsl:call-template>
															</xsl:otherwise>
														</xsl:choose>
														<xsl:if test="string-length(params/carpart) != 0 and count(params/carpart) != 0">
															<span title="{params/carpart/n}: {params/carpart/c}"><xsl:value-of select="format-number(params/carpart/c, '###,###,###')" />&#0160;<img src="{params/carpart/i}" alt="{params/carpart/name}" title="{params/carpart/name}" style="width: 16px; height: 16px;" /></span>
														</xsl:if>
														.
														<xsl:if test="params/zub = 1"><br />Вы выбили игроку <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/player" /></xsl:call-template> зуб.</xsl:if>
														<xsl:if test="count(params/hnt) > 0">
															<br /><i class="hunting-kill"></i> За убийство заказанного в Охотничьем клубе игрока вы получили <span class="badge"><xsl:value-of select="params/hnt/b" /><i></i></span>
															<xsl:if test="params/hnt/a > 0">
																<span class="tugriki"><xsl:value-of select="params/hnt/a" /><i></i></span> награды
															</xsl:if>
															<xsl:if test="params/hnt/m = 1">
																и даже смогли отжать <span class="mobila"><i></i>мобилу</span>
															</xsl:if>.
														</xsl:if>
													</xsl:if>
													<xsl:if test="params/result = 'loose' and params/profit > 0">
														<br/>Вы потеряли <xsl:call-template name="showprice">
															<xsl:with-param name="money" select="params/profit" />
														</xsl:call-template>.
													</xsl:if>
													<xsl:if test="count(params/mbckp) > 0">
														<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
													</xsl:if>
												</td>
												<td class="actions">
													<xsl:if test="params/result = 'loose' and params/player/fraction != 'npc' and params/player/id > 0">
														<span class="button">
															<a class="f" href="/huntclub/revenge/{params/player/id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																<div class="c">Отомстить</div>
															</a>
														</span>
													</xsl:if>
													<span class="button">
														<a class="f" href="/alley/fight/{params/fight_id}/{params/secretkey}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">Лог боя</div>
														</a>
													</span>
													<xsl:call-template name="logbutton" />
												</td>
											</xsl:when>
											<xsl:when test="type = 'fighthntclb'">
												<td class="text">
													Вы <a href="/alley/fight/{params/dl}/{params/sk}/">выполнили</a> заказ Охотничьего клуба
													и получили в награду <span class="badge"><xsl:value-of select="params/b" /><i></i></span>
													<xsl:if test="params/a > 0">
														<span class="tugriki"><xsl:value-of select="params/a" /><i></i></span>
													</xsl:if>
													<xsl:if test="params/m = 1">
														и даже смогли отжать <span class="mobila"><i></i>мобилу</span>
													</xsl:if>.
													<xsl:if test="count(params/mbckp) > 0">
														<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
													</xsl:if>
												</td>
												<td class="actions">
													<xsl:call-template name="huntclubbutton" />
													<xsl:call-template name="logbutton" />
												</td>
											</xsl:when>
											<xsl:when test="type = 'fight_defended'">
												<td class="text">
													Игрок <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/player" /></xsl:call-template> напал на вас<xsl:choose><xsl:when test="params/result = 'win'"> и потерпел поражение.</xsl:when><xsl:when test="params/result = 'loose'"> и одержал победу.</xsl:when><xsl:otherwise>, но никто не победил.</xsl:otherwise></xsl:choose>
													<xsl:if test="params/result = 'win' and (params/exp > 0 or params/profit > 0)">
														<br/>Вы получили <xsl:call-template name="showprice">
															<xsl:with-param name="money" select="params/profit" />
															<xsl:with-param name="exp" select="params/exp" />
														</xsl:call-template>.
													</xsl:if>
													<xsl:if test="params/result = 'loose' and params/profit > 0">
														<br/>Вы потеряли <xsl:call-template name="showprice">
															<xsl:with-param name="money" select="params/profit" />
														</xsl:call-template>.
													</xsl:if>
													<xsl:if test="count(params/mbckp) > 0">
														<xsl:call-template name="showmoney"><xsl:with-param name="mbckp" select="params/mbckp" /></xsl:call-template>
													</xsl:if>
												</td>
												<td class="actions">
													<xsl:if test="params/result = 'loose' and params/player/fraction != 'npc' and params/player/id > 0">
														<span class="button">
															<a class="f" href="/huntclub/revenge/{params/player/id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																<div class="c">Отомстить</div>
															</a>
														</span>
													</xsl:if>
													<span class="button">
														<a class="f" href="/alley/fight/{params/fight_id}/{params/secretkey}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">Лог боя</div>
														</a>
													</span>
													<xsl:call-template name="logbutton" />
												</td>
											</xsl:when>
											<xsl:when test="type = 'clan_give_dkp'">
												<td class="text">
													Игрок <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/player" /></xsl:call-template> начислил вам <span class="plushki"><xsl:value-of select="params/dkp" /><i></i></span>. Причина: <strong><xsl:value-of select="params/reason" /></strong>.
												</td>
												<td class="actions">
													<span class="button">
														<a class="f" href="/clan/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">Клан</div>
														</a>
													</span>
												</td>
											</xsl:when>
										</xsl:choose>
									</xsl:element>
								</xsl:if>
                            </xsl:for-each>
                        </table>

                                <xsl:call-template name="paginator">
                                    <xsl:with-param name="pages" select="pages" />
                                    <xsl:with-param name="page" select="page" />
                                    <xsl:with-param name="link" select="concat('/phone/duels/', dt, '/')" />
                                </xsl:call-template>

                    </xsl:when>
                    <xsl:otherwise>
                        <p>Пока Ваше существование в Москве ничем особым не приметилось.</p>
                    </xsl:otherwise>
                </xsl:choose>
            </div>
        </div>
	</xsl:template>

	<xsl:template name="logbutton">
		<!--xsl:choose>
			<xsl:when test="/data/submode = 'all'">
				<span class="button">
					<a class="f" href="/phone/logs/restore/{id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
						<div class="c">Восстановить</div>
					</a>
				</span>
			</xsl:when>
			<xsl:otherwise>
				<span class="button">
					<a class="f" href="/phone/logs/delete/{id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
						<div class="c">Удалить</div>
					</a>
				</span>
			</xsl:otherwise>
		</xsl:choose-->
	</xsl:template>

    <xsl:template name="dipbutton">
        <span class="button">
            <a class="f" href="/clan/profile/diplomacy/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                <div class="c">Дипломатия</div>
            </a>
        </span>
    </xsl:template>

    <xsl:template name="homebutton">
        <span class="button">
            <a class="f" href="/home/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                <div class="c">Хата</div>
            </a>
        </span>
    </xsl:template>

    <xsl:template name="sovetbutton">
        <span class="button">
            <a class="f" href="/sovet/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                <div class="c">Совет</div>
            </a>
        </span>
    </xsl:template>

    <xsl:template name="fitnessvipbutton">
        <span class="button">
            <a class="f" href="/trainer/vip/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                <div class="c">Фитнесс</div>
            </a>
        </span>
    </xsl:template>

    <xsl:template name="factorybutton">
        <span class="button">
            <a class="f" href="/factory/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                <div class="c">Завод</div>
            </a>
        </span>
    </xsl:template>

    <xsl:template name="bankbutton">
        <span class="button">
            <a class="f" href="/bank/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                <div class="c">Банк</div>
            </a>
        </span>
    </xsl:template>

    <xsl:template name="clanbutton">
        <span class="button">
            <a class="f" href="/clan/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                <div class="c">Клан</div>
            </a>
        </span>
    </xsl:template>

    <xsl:template name="huntclubbutton">
        <span class="button">
            <a class="f" href="/huntclub/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                <div class="c">Охотничий клуб</div>
            </a>
        </span>
    </xsl:template>

	<xsl:template name="messagebutton">
		<xsl:choose>
			<xsl:when test="/data/submode = 'outbox' and type != 'system_notice'">
				<span class="button" onclick="$('#name').val('{player/nm}');$('#text').trigger('focus');">
					<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
						<div class="c">Еще</div>
					</span>
				</span>
			</xsl:when>
			<xsl:when test="type != 'system_notice'">
				<span class="button" onclick="$('#name').val('{player/	nm}');$('#text').trigger('focus');">
					<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
						<div class="c">Ответ</div>
					</span>
				</span>
				<span class="button" onclick="phoneComplainMessage({id});">
					<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
						<div class="c">Жалоба</div>
					</span>
				</span>
			</xsl:when>
		</xsl:choose>
		<span class="button">
			<a class="f" href="/phone/messages/delete/{id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
				<div class="c">Удалить</div>
			</a>
		</span>
	</xsl:template>

    <xsl:template name="showmoney">
        <xsl:param name="mbckp" />
		<xsl:if test="$mbckp/m > 0 or $mbckp/o > 0 or $mbckp/h > 0 or $mbckp/n">
			<br /><span class="grey">У вас осталось:
			<xsl:if test="$mbckp/m > 0">&#0160;<xsl:value-of select="format-number($mbckp/m, '###,###,###')" /> монет </xsl:if>
			<xsl:if test="$mbckp/o > 0">&#0160;<xsl:value-of select="format-number($mbckp/o, '###,###')" /> руды </xsl:if>
			<xsl:if test="$mbckp/h > 0">&#0160;<xsl:value-of select="format-number($mbckp/h, '###,###')" /> мёда </xsl:if>
            <xsl:if test="$mbckp/n > 0">&#0160;<xsl:value-of select="format-number($mbckp/n, '###,###')" /> нефти </xsl:if>
			</span>
		</xsl:if>
    </xsl:template>

</xsl:stylesheet>
