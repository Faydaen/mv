<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <script type="text/javascript" src="/@/js/chat.js"></script>
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear">
                    <h2>Модерирование чата</h2>
                </div>

				<div id="content" class="chat">
					<script>
						var can_mute = true;
					</script>

						<div class="block-rounded" style="background:#ffccc2; position: relative; z-index: 2; margin-top:10px;">
							<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
							<div class="center clear pers-admin">
								<div id="pers-admin-block">
									<div style="width:100%; float:left;">
										<input type="hidden" id="mute-chat-player" value="{target/id}" />
										<table>
											<tr>
												<td style="padding: 10px 10px 0 10px;">
													Игрок: <strong><xsl:value-of select="target/nickname" /></strong>
												</td>
											</tr>
											<tr>
												<td style="padding: 10px 10px 0 10px;">
													<select name="action" id="mute-chat-action">
														<option value="">- Выберите действие-</option>
														<xsl:if test="access-isolate = 1">
															<option value="isolate">+ Изолировать в чате</option>
															<option value="unisolate">- Изолировать в чате</option>
														</xsl:if>
														<xsl:if test="access-mute = 1">
															<option value="mute">+ Молчанка в чате</option>
															<option value="unmute">- Молчанка в чате</option>
														</xsl:if>
													</select>
												</td>
											</tr>
											<tr>
												<td style="padding: 10px 10px 0 10px;">
													Причина: <input type="text" id="mute-chat-reasons" size="20" />&#0160;&#0160;&#0160;&#0160;
													Время: <input type="text" id="mute-chat-time" size="10" />
												</td>
											</tr>
											<tr>
												<td style="padding: 10px 10px 0 10px;">
													<select id="reasons" multiple="multiple" size="6" onchange="reasonChecker();" style="width: 100%;">
														<option value="3600" reason="Ненормативная лексика">Ненормативная лексика - 1h</option>
														<option value="3600" reason="Завуалированный мат">Завуалированный мат - 1h</option>
														<option value="1800" reason="Создание конфликтных ситуаций, провокация">Создание конфликтных ситуаций, провокация - 30m</option>
														<option value="1800" reason="Флуд">Флуд - 30m</option>
														<option value="1800" reason="Обсуждение наказаний и действий модератора">Обсуждение наказаний и действий модератора - 30m</option>
														<option value="900" reason="Капс">Капс - 15m</option>
														<option value="86400" reason="Распространение вредоносных ссылок">Распространение вредоносных ссылок - 24h</option>
														<option value="86400" reason="Разжигание межнациональной розни">Разжигание межнациональной розни - 24h</option>
														<option value="21600" reason="Обсуждение тем сексуального характера">Обсуждение тем сексуального характера - 6h</option>
														<option value="259200" reason="Угроза расправой в реальной жизни">Угроза расправой в реальной жизни - 72h</option>
														<option value="10800" reason="Оскорбление игроков">Оскорбление игроков - 3h</option>
														<option value="3600" reason="Бурное обсуждение политики">Бурное обсуждение политики - 1h</option>
													</select>
													<script>
														function reasonChecker() {
															var reasons = "";
															var time = 0;
															$("#reasons option:selected").each(function(i) {
																if (reasons.length > 0) {
																	reasons += ", ";
																}
																reasons += $(this).attr("reason");
																time += parseInt($(this).val());
															});
															$("#mute-chat-reasons").val(reasons);
															$("#mute-chat-time").val(getTextTime(time));
														}

														function getTime(txt) {
															var time = 0;
															var matches = txt.match(/\d+h/g);
															if (matches) time += parseInt(matches[0].replace("h", "")) * 3600;

															var matches = txt.match(/\d+m/g);
															if (matches) time += parseInt(matches[0].replace("m", "")) * 60;

															var matches = txt.match(/\d+s/g);
															if (matches) time += parseInt(matches[0].replace("s", ""));
															return time;
														}

														function getTextTime(time) {
															var txt = "";
															var hours = Math.floor(time / 3600);
															time = time % 3600;
															var minutes = Math.floor(time / 60);
															time = time % 60;
															var seconds = time;
															if (hours) txt += hours + "h";
															if (minutes) {
																if (txt.length) txt += " ";
																txt += minutes + "m";
															}
															if (seconds) {
																if (txt.length) txt += " ";
																txt += seconds + "s";
															}
															return txt;
														}
													</script>
												</td>
											</tr>
											<tr>
												<td style="padding: 10px 10px 10px 10px;">
													<button  class="button" type="button" onclick="top.frames['chat-frame-' + getCookie('chatLayout')].Chat.moderate($('#mute-chat-action').val(), $('#mute-chat-player').val(), getTime($('#mute-chat-time').val()), $('#mute-chat-reasons').val());">
														<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">Применить</div>
														</span>
													</button>
												</td>
											</tr>
										</table>
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

				</div>
			</div>
		</div>
    </xsl:template>

</xsl:stylesheet>