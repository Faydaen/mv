<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <script type="text/javascript" src="/@/js/chat.js"></script>
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear">
                    <h2>Чат</h2>
                </div>
		
				<div id="content" class="chat">
					<table border="0" cellpadding="0" cellspacing="0">
					    <tr>
							<td>
								<div id="tabs">
									<form id="channel-buttons">
										<xsl:for-each select="channels/element">
											<xsl:element name="div">
												<xsl:attribute name="channel"><xsl:value-of select="name" /></xsl:attribute>
												<xsl:attribute name="class">tab</xsl:attribute>
												<label for="channel-{name}-tab">
													<input type="checkbox" name="channel-{name}-tab" id="channel-{name}-tab" onclick="chatClickTab('{name}');"><xsl:if test="name != 'quiz' and name != 'noobs'"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if></input><xsl:value-of select="title" />
												</label>
												<xsl:choose>
													<xsl:when test="name = 'clan'">
														<i class="icon chat-icon" title="to [clan]" onclick="chatAddTo('clan',true)"></i>
													</xsl:when>
									                <xsl:when test="name = 'fraction'">
									                    <i class="icon chat-icon" title="to [side]" onclick="chatAddTo('side',true)"></i>
									                </xsl:when>
													<xsl:when test="name = 'battle'">
									                    <i class="icon chat-icon" title="to [battle" onclick="chatAddTo('battle',true)"></i>
									                </xsl:when>
													<xsl:when test="name = 'quiz'">
														<i class="icon chat-icon" title="to [quiz]" onclick="chatAddTo('quiz',true)"></i>
													</xsl:when>
													<xsl:when test="name = 'noobs' and /data/player/level > 1">
														<i class="icon chat-icon" title="to [noobs]" onclick="chatAddTo('noobs',true)"></i>
													</xsl:when>
												</xsl:choose>
											</xsl:element>
											
										</xsl:for-each>
									</form>
							    </div>
							</td>
					    </tr>
					    <tr>
							<td>
								<div id="channels">
									<div id="channel" class="chat-channel">
										<div class="block-rounded"><i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
											<div id="messages" class="chat-messages">
												
											</div>
											<!--p>Чат временно отключен. Приносим извинения за доставленные неудобства.</p-->
										</div>
										<div id="users" class="chat-users">
											<!--<xsl:for-each select="players/element">
												<xsl:call-template name="playerlink">
													<xsl:with-param name="player" select="current()" />
												</xsl:call-template>
											</xsl:for-each>-->
										</div>
									</div>
								</div>
							</td>
					    </tr>
					    <tr>
							<td>
								<a style="float:right; font-size:90%; margin:3px 5px;" href="/licence/rules/#chat">Правила чата</a>
								<div id="input">
									<form action="" method="post" onsubmit="chatSend();return false;">
										<table>
											<tr>
												<td>
													<span id="input-private" style="display: none;">
														Кому: <input type="text" id="player_to" name="player_to" value="" size="15" />
													</span>
												</td>
												<td class="text-cell">
													<input type="text" id="text" name="text" value="" size="60" maxlength="256" />
												</td>
												<td class="submit-cell">
													<button class="button" type="submit"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Сказать</div></span></button>
												</td>
											</tr>
										</table>
									</form>
							   </div>
								<div class="smiles-place">
								    <i class="icon chat-smiles-icon" title="Вставить смайлик" onclick="$('#overtip-smiles').toggle();"></i>
									<div class="overtip" id="overtip-smiles" style="display:none;">
										<div class="help">
											<h2>Смайлики ;-)</h2>
											<div class="data">
												<div id="smiles" rel="text" alt="1">
													<xsl:for-each select="smiles/element">
														<img src="/@/images/smile/{current()}.gif" alt="{current()}" />
													</xsl:for-each>
												</div>
												<div class="actions">
													<div class="button" onclick="$('#overtip-smiles').hide();">
														<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">Отмена</div>
														</span>
													</div>
												</div>
												<i class="tail-bottom"></i>
											</div>
										</div>
									</div>
								</div>
								<i class="chat-clear-icon" title="Очистить чат" onclick="chatClear();"></i>
							</td>
					    </tr>
					</table>

					<script>
						var players = <xsl:value-of select="players" />;
						//var messages = <xsl:value-of select="messages" />;
						var messages = [];
						var mynickname = '<xsl:value-of select="player/nickname" />';
						var level = <xsl:value-of select="player/level" />;
						<xsl:choose>
							<xsl:when test="player/access/player_mute_chat">
								var can_mute = true;
							</xsl:when>
							<xsl:otherwise>
								var can_mute = false;
							</xsl:otherwise>
						</xsl:choose>

					<![CDATA[
					    var channels = new Array();
						var currentChannel, reloadMessages, reloadUsers;
						$(document).ready(function(){

							chatInit();

							reloadMessages = setInterval(function(){chatReloadMessages();}, 10000);
							reloadUsers = setInterval("chatReloadUsers();", 60000);

							drawPlayers(players);
							chatFilterMessages([],true);
						});
					]]>
					
					</script>

					<xsl:if test="player/access/player_mute_chat">
						<div class="block-rounded" style="background:#ffccc2; position: relative; z-index: 2; margin-top:10px;">
							<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
							<div class="center clear pers-admin">
								<h3><span class="dashedlink" style="color:red; border-color:red;" onclick="ShowAdmin();">Админка чата</span></h3>

								<div id="pers-admin-block" style="display:none;">
									<div style="width:100%; float:left;">

										<form id="admin-form" action="/player/" method="post">
											<input type="hidden" name="adminaction" value="1" />
											<input type="hidden" id="admin-player" name="player" value="" />
											<table>
												<tr>
													<td style="width:50%;">
														Ник:
													  <input type="text" name="player_nickname" id="admin-player-nickname" value="" disabled="disabled" /><br />
													  <div id="admin-result"></div>
													</td>
													<td style="padding:0 0 5px 0;">
														<select name="action" id="admin-action">
															<option value="">- Выберите действие-</option>
															<option value="+ Изолировать в чате">+ Изолировать в чате</option>
															<option value="- Изолировать в чате">- Изолировать в чате</option>
															<option value="+ Молчанка в чате">+ Молчанка в чате</option>
															<option value="- Молчанка в чате">- Молчанка в чате</option>
														</select>
													</td>
												</tr>
												<tr>
													<td></td>
													<td style="padding:0 0 5px 0;">
														Период:<br />
														<input type="text" name="period" id="admin-period" size="20" /> (12h - 12 часов, 1d - 1 день)</td>
												</tr>
												<tr>
													<td></td>
													<td style="padding:0 0 5px 0;">
														Причина:<br />
														<textarea name="text" rows="2" cols="30" id="admin-text" style="width:100%;"></textarea><br />
														<select id="reasons" multiple="multiple" size="4" onchange="reasonChecker();" style="width: 100%;">
															<option>Ненормативная лексика - 1h</option>
															<option>Завуалированный мат - 1h</option>
															<option>Создание конфликтных ситуаций, провокация - 30m</option>
															<option>Флуд - 30m</option>
															<option>Обсуждение наказаний и действий модератора - 30m</option>
															<option>Капс - 15m</option>
															<option>Распространение вредоносных ссылок - 24h</option>
															<option>Разжигание межнациональной розни - 24h</option>
															<option>Обсуждение тем сексуального характера - 6h</option>
														</select>
														<script>
															function reasonChecker() {
																var reasons = "", p = "";
																var m = 0, h = 0;
																$("#reasons option:selected").each(function(i) {
																	var v = $(this).text().match(/(.*)\s\-\s([0-9]+)(h|m)/i);
																	if (reasons.length > 0) {
																		reasons += ", ";
																	}
																	reasons += v[1];
																	if (v[3] == 'm') {
																		m += new Number(v[2]);
																	} else {
																		h += new Number(v[2]);
																	}
																});
																$('#admin-text').val(reasons);
																h += Math.floor(m / 60);
																m = m % 60;
																if (m > 0) {
																	p += m + "m";
																}
																if (h > 0) {
																	p += h + "h";
																}
																$('#admin-period').val(p);
															}
														</script>
													</td>
												</tr>
												<tr>
													<td></td>
													<td style="padding:0 0 5px 0;">
														<button  class="button" type="button" onclick="chatMute();">
															<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																<div class="c">Применить</div>
															</span>
														</button>
													</td>
												</tr>
											</table>

										</form>
									</div>

									<script type="text/javascript">
										function ShowAdmin(flag) {
											if (true==flag || !$("#pers-admin-block").is(":visible")){
												$("#pers-admin-block").show();
											} else {
												$("#pers-admin-block").hide();
											}
										}
									</script>
								</div>
							</div>
						</div>
					</xsl:if>

				</div>
			</div>
		</div>
    </xsl:template>

</xsl:stylesheet>
