<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template name="adminpanel" match="/data">
        <div class="pers-text">
				<div class="block-rounded" style="background:#ffccc2; position: relative; z-index: 2;">
					<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
					<div class="center clear pers-admin">
						<h3><span class="dashedlink" style="color:red; border-color:red;" onclick="$('#pers-admin-block').toggle();">Админка персонажа</span></h3>

						<div id="pers-admin-block" style="display:none;">
							<div style="width:50%; float:left;">
								<xsl:if test="self/access/player_view_lastactivity = 1">
									<b>Был тут: </b>
									<xsl:value-of select="player/lastactivitytime" /><br />
								</xsl:if>

								<xsl:if test="self/access/ipban = 1">
									<b>IP-адрес: </b>
									<xsl:value-of select="player/ip" /><br />
								</xsl:if>

								<xsl:if test="self/access/player_mute_forum = 1">
									<b>Молчанка на форуме: </b>
									<xsl:choose>
										<xsl:when test="player/mute_forum > servertime">
											до <xsl:value-of select="player/mute_forum2" />&#160;
										</xsl:when>
										<xsl:otherwise>
											<i>нет</i>
										</xsl:otherwise>
									</xsl:choose><br />
								</xsl:if>

								<xsl:if test="self/access/player_mute_phone = 1">
									<b>Молчанка в ПМ: </b>
									<xsl:choose>
										<xsl:when test="player/mute_phone > servertime">
											до <xsl:value-of select="player/mute_phone2" />
										</xsl:when>
										<xsl:otherwise>
											<i>нет</i>
										</xsl:otherwise>
									</xsl:choose><br />
								</xsl:if>

								<xsl:if test="self/access/player_mute_chat = 1">
									<b>Молчанка в чате: </b>
									<xsl:choose>
										<xsl:when test="player/mute_chat > servertime">
											до <xsl:value-of select="player/mute_chat2" />
										</xsl:when>
										<xsl:otherwise>
											<i>нет</i>
										</xsl:otherwise>
									</xsl:choose><br />
								</xsl:if>

								<xsl:if test="self/access/player_view_state = 1">
									<b>Занятость: </b>
									<xsl:choose>
										<xsl:when test="player/state = 'metro'"><i>метро до <xsl:value-of select="player/timer2" /></i></xsl:when>
										<xsl:when test="player/state = 'patrol'"><i>патруль до <xsl:value-of select="player/timer2" /></i></xsl:when>
										<xsl:when test="player/state = 'macdonalds'"><i>шаурбургерс до <xsl:value-of select="player/timer2" /></i></xsl:when>
										<xsl:when test="player/state = 'police'"><i>милиция до <xsl:value-of select="player/timer2" /></i></xsl:when>
										<xsl:otherwise>
											<i>свободен</i>
										</xsl:otherwise>
									</xsl:choose><br />
								</xsl:if>

								<xsl:if test="self/access/forum_checking_avatar = 1">
									<b>Аватар на форуме: </b><br/>
									<xsl:choose>
										<xsl:when test="player/forum_avatar = 0"><img><xsl:attribute name="src">/@/images/pers/<xsl:value-of select="substring-before(player/avatar,'.png')" />_thumb.png</xsl:attribute></img></xsl:when>
										<xsl:otherwise>
											<img src="/@images/{player/forum_avatar_src}" />
											<xsl:if test="player/forum_avatar_checked = 0"><br /><b>не проверен</b></xsl:if>
										</xsl:otherwise>
									</xsl:choose>
								</xsl:if>

							</div>

							<div style="width:49%; float:left;">

								<form action="/player/admin/" method="post" id="admin-form">
									<input type="hidden" name="adminaction" value="1" />
									<input type="hidden" name="player" value="{player/id}" />
									<table>
										<tr>
											<td style="padding:0 0 5px 0;">
												<select name="action" onchange="adminFormActionOnChange(this);">
													<option value="">- Выберите действие-</option>
													<xsl:if test="self/access/forum_checking_avatar = 1">
														<option value="+ Разрешить аватар">+ Разрешить аватар</option>
														<option value="- Отклонить аватар">- Отклонить аватар</option>
													</xsl:if>
													<xsl:if test="self/access/player_block = 1">
														<option value="+ Заблокировать">+ Заблокировать</option>
													</xsl:if>
													<xsl:if test="self/access/player_unblock = 1">
														<option value="- Разблокировать">- Разблокировать</option>
													</xsl:if>
													<xsl:if test="self/access/player_mute_forum = 1">
														<option value="+ Молчанка на форуме">+ Молчанка на форуме</option>
														<option value="- Молчанка на форуме">- Молчанка на форуме</option>
													</xsl:if>
													<xsl:if test="self/access/player_mute_phone = 1">
														<option value="+ Молчанка ЛС">+ Молчанка ЛС</option>
														<option value="- Молчанка ЛС">- Молчанка ЛС</option>
													</xsl:if>
													<xsl:if test="self/access/player_mute_chat = 1">
														<option value="+ Молчанка в чате">+ Молчанка в чате</option>
														<option value="- Молчанка в чате">- Молчанка в чате</option>
													</xsl:if>
													<xsl:if test="self/access/player_jail = 1">
														<option value="+ В тюрьму">+ В тюрьму</option>
														<option value="- В тюрьму">- В тюрьму</option>
													</xsl:if>
													<xsl:if test="self/access/clan_setfounder = 1">
														<option value="+ Сделать главой клана">+ Сделать главой клана</option>
													</xsl:if>
													<xsl:if test="self/access/clan_kick = 1">
														<option value="- Исключить из клана">- Исключить из клана</option>
													</xsl:if>
													<xsl:if test="self/access/player_flag = 1">
														<option value="+ Передать флаг">+ Передать флаг</option>
													</xsl:if>
													<xsl:if test="self/access/rating = 1">
														<option value="+ Пересчитать рейтинг">+ Пересчитать рейтинг</option>
														<option value="+ Показывать в рейтинге">+ Показывать в рейтинге</option>
														<option value="- Показывать в рейтинге">- Показывать в рейтинге</option>
													</xsl:if>
													<xsl:if test="self/access/player_clear_info = 1">
														<option value="- Очистить информацию">- Очистить информацию</option>
														<option value="- Очистить кличку питомца">- Очистить кличку питомца</option>
													</xsl:if>
													<xsl:if test="self/access/ipban = 1">
														<option value="+ Забанить IP-адрес">+ Забанить IP-адрес</option>
													</xsl:if>
													<xsl:if test="self/access/give_cert_changenickname = 1">
														<option value="+ Передать сертификат на смену ника">+ Передать сертификат на смену ника</option>
													</xsl:if>
													<xsl:if test="self/access/marry = 1">
														<option value="+ Брак">+ Брак</option>
														<option value="- Брак">- Брак</option>
														<option value="+ Свадебный бой">+ Свадебный бой</option>
													</xsl:if>
													<option value="+ Пересчитать статы">+ Пересчитать статы</option>
													<option value="+ Комментарий">+ Комментарий</option>
												</select>
											</td>
										</tr>
										<tr>
											<td style="padding:0 0 5px 0;">
												Период:<br />
											<input type="text" name="period" id="admin-form-period" size="20" /> (12h - 12 часов, 1d - 1 день)</td>
										</tr>
										<xsl:if test="self/access/player_block = 1">
											<tr rel="+ Заблокировать" style="display:none;">
												<td>
													Причина:<br />
													<select name="unbancost">
														<xsl:for-each select="admin_panel/blockreasons/element">
															<option value="{honey}"><xsl:value-of select="text" /> - <xsl:value-of select="honey" /> меда</option>
														</xsl:for-each>
													</select>
												</td>
											</tr>
										</xsl:if>
										<tr>
											<td style="padding:0 0 5px 0;">
												Причина:<br />
												<textarea name="text" rows="2" cols="30" style="width:100%;"></textarea>
											</td>
										</tr>
									</table>
									<button  class="button" type="submit">
										<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Применить</div>
										</span>
									</button>
								</form>

							</div>
						</div>

						<xsl:if test="self/access/player_view_history = 1">
							<h3><span class="dashedlink" style="color:red; border-color:red;" onclick="loadPlayerComments({player/id}, 0);$('#pers-admin2-block').toggle();">Досье</span></h3>
						</xsl:if>
						<xsl:if test="self/access/player_view_duels = 1">
							<h3><span class="dashedlink" style="color:red; border-color:red;" onclick="loadPlayerDuels({player/id}, 0);$('#pers-admin2-block').toggle();">Дуэли</span></h3>
						</xsl:if>
						<xsl:if test="self/access/player_view_messages = 1">
							<h3><span class="dashedlink" style="color:red; border-color:red;" onclick="loadPlayerMessages({player/id}, 0);$('#pers-admin2-block').toggle();">Сообщения</span></h3>
						</xsl:if>
						<div id="pers-admin2-block" style="display:none;"></div>
					</div>
				</div>
			</div>
    </xsl:template>
</xsl:stylesheet>