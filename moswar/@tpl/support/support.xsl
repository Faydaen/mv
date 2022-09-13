<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
	<div class="column-right-topbg">
	    <div class="column-right-bottombg" align="center">
		<div class="heading clear">
		    <h2>
			<span style="background: url() !important;">Техническая поддержка</span>
		    </h2>
		</div>
		<div id="content">
			<div class="block-rounded" style="padding:10px 25px;">
			    <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
				
				<!--
                <h2>Старый суппорт</h2>
				-->
				
				<!--
				<h3>Отправить сообщение</h3>
				<br />
				
				
                <xsl:choose>
                    <xsl:when test="string-length(/data/message)=0">
                        <form action="/support/send-message/" method="post" onsubmit="return checkForm();">
                            <table class="forms">
								<tr>
                                    <td class="label"></td>
                                    <td class="input">
										<input type="checkbox" id="support-checkbox-faq" onclick="CheckSupportForm();" />
										<label for="support-checkbox-faq">Я прочитал(а) <a href="/faq/">FAQ</a>, но не нашел ответа</label><br />
										<input type="checkbox" id="support-checkbox-forum" onclick="CheckSupportForm();" />
										<label for="support-checkbox-forum">Я поискал(а) <a href="http://forum.theabyss.ru/index.php?showforum=499" target="_blank">на Форуме</a>, но не нашел ответа</label>
                                    </td>
                                </tr>
								
                                <tr>
                                    <td class="label" id="support-select-label" style="display:none;">Тема:</td>
                                    <td class="input" id="support-select" 		style="display:none;">
                                        <select name="type" onchange="CheckSupportFormSelectedType()" id="problemType">
                                            <option value="0">Не выбрано</option>
											<option value="Ошибки, пожелания, улучшения">Ошибки, пожелания, улучшения</option>
                                            <option value="Начисление мёда">Начисление мёда, трата мёда, услуги за мёд</option>
                                            <option value="Начисление монет, руды, опыта">Начисление монет, руды, опыта</option>
                                            <option value="Жалобы на игроков">Жалобы на игроков</option>
                                            <option value="Другое">Другое</option>
                                        </select>
                                    </td>
                                </tr>

								<tr>
                                    <td class="label" id="support-problem2-textarea-label" style="display:none;">Способ оплаты:</td>
                                    <td class="input" id="support-problem2-textarea-input" style="display:none;">
                                        <select name="paymenttype" onchange="CheckSupportFormSelectedTypeProblem2()" id="problem2Select">
                                            <option value="">Не выбрано</option>
											<option value="sms">SMS</option>
                                            <option value="other">Любой другой способ оплаты кроме SMS</option>
                                        </select>
                                    </td>
                                </tr>
								
								<tr>
                                    <td class="label" id="support-problem2-sms-textarea-label" style="display:none;">Номер телефона:</td>
                                    <td class="input" id="support-problem2-sms-textarea-input" style="display:none;">
                                        <input type="text" style="width:200px;" name="phone"></input>
                                    </td>
                                </tr>
								
								<tr>
                                    <td class="label" id="support-problem2-sms2-textarea-label" style="display:none;">Указанный номер отправки и текст сообщения:</td>
                                    <td class="input" id="support-problem2-sms2-textarea-input" style="display:none;">
                                        <input style="width:100%;" name="smsdata"></input>
                                    </td>
                                </tr>
								
								<tr>
                                    <td class="label" id="support-problem2-nosms-textarea-label" style="display:none;">Все реквизиты платежа:</td>
                                    <td class="input" id="support-problem2-nosms-textarea-input" style="display:none;">
                                        <textarea style="width:100%; height:6em;" name="paymentdata"></textarea>
										<p>Если есть чек, то все данные с чека. Если транзакция, то ее номер и.т.п. Также всегда надо указывать время.</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label" id="support-textarea-label" style="display:none;">Суть проблемы:</td>
                                    <td class="input" id="support-textarea-input" style="display:none;">
                                        <textarea style="width:100%; height:6em;" name="name"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"></td>
                                    <td class="input" id="support-button" style="display:none;">
                                        <button type="submit" class="button" ><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Отправить</div></span></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"></td>
                                    <td class="input" id="support-mail" style="display:none;">
                                        <br />
                                        <p><b>Техническая поддержка</b></p>
                                        <p>
                                            E-mail: <a href="mailto:support@moswar.ru">support@moswar.ru</a>
                                            — для игровых вопросов.
                                        </p>
                                        <p>
                                            E-mail: <a href="mailto:support@ddestiny.ru">support@ddestiny.ru</a>
                                            — для вопросов по покупке и трате мёда.
                                        </p>
                                        <p>
                                            Обращаем ваше внимание, что при отправке сообщения надо максимально описать свою проблему.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </form>
						<script type="text/javascript">
							<![CDATA[
							function CheckSupportForm() {
								var faq = $("#support-checkbox-faq")[0];
								var forum = $("#support-checkbox-forum")[0];
								if(faq.checked && forum.checked) {
									$("#support-textarea-label").show();
									$("#support-textarea-input").show();
									$("#support-select").show();
									$("#support-select-label").show();
									$("#support-button").show();
                                    $("#support-mail").show();
								} else {
									$("#support-textarea-label").hide();
									$("#support-textarea-input").hide();
									$("#support-select").hide();
									$("#support-select-label").hide();
									$("#support-button").hide();
                                    $("#support-mail").hide();
								}
							}
							
							
							function CheckSupportFormSelectedType() {
								if ($("#problemType")[0].selectedIndex == 2 ) { // показать мёд
									$("#support-problem2-textarea-label").show();
									$("#support-problem2-textarea-input").show();
								} else {
									$("#support-problem2-textarea-label").hide();
									$("#support-problem2-textarea-input").hide();
								}
								$("#support-problem2-nosms-textarea-label").hide();
								$("#support-problem2-nosms-textarea-input").hide();
							}
							
							
							function CheckSupportFormSelectedTypeProblem2() {
								if ($("#problem2Select")[0].selectedIndex == 1 ) { // показать СМС
									$("#support-problem2-sms-textarea-label").show();
									$("#support-problem2-sms-textarea-input").show();
									$("#support-problem2-sms2-textarea-label").show();
									$("#support-problem2-sms2-textarea-input").show();
								} else {
									$("#support-problem2-sms-textarea-label").hide();
									$("#support-problem2-sms-textarea-input").hide();
									$("#support-problem2-sms2-textarea-label").hide();
									$("#support-problem2-sms2-textarea-input").hide();
								}
								
								if ($("#problem2Select")[0].selectedIndex == 2 ) { // показать Не СМС
									$("#support-problem2-nosms-textarea-label").show();
									$("#support-problem2-nosms-textarea-input").show();
								} else {
									$("#support-problem2-nosms-textarea-label").hide();
									$("#support-problem2-nosms-textarea-input").hide();
								}
							
							}

							function checkForm() {
								$('.error').remove();
								if ($('#support-select option:selected').val() == 0) {
									$('#support-select').append('<span class="error"><br />Выберите тему.</span>');
								}
								if ($('#support-select option:selected').val() == 'Начисление мёда') {
									if ($('#support-problem2-textarea-input option:selected').val() == '') {
										$('#support-problem2-textarea-input').append('<span class="error"><br />Выберите тип оплаты.</span>');
									} else if ($('#support-problem2-textarea-input option:selected').val() == 'sms') {
										if ($('#support-problem2-sms-textarea-input input').val().length < 10) {
											$('#support-problem2-sms-textarea-input').append('<span class="error"><br />Укажите номер телефона.</span>');
										}
										if ($('#support-problem2-sms2-textarea-input input').val().length < 5) {
											$('#support-problem2-sms2-textarea-input').append('<span class="error"><br />Укажите короткий номер и текст.</span>');
										}
									}
								}
								if ($('#support-textarea-input textarea').val().length < 10) {
									$('#support-textarea-input').append('<span class="error"><br />Укажите суть проблемы.</span>');
								}
								if ($('.error').length > 0) {
									return false;
								} else {
									return true;
								}
							}
							
							CheckSupportForm();
							]]>
						</script>
                    </xsl:when>
                    <xsl:otherwise>
                        <p><xsl:value-of select="/data/message" disable-output-escaping="yes" /></p>
                    </xsl:otherwise>
                </xsl:choose>
				
				-->
				
				<!--
				<hr />
				<h2>Новый суппорт</h2>
				-->
				
				<xsl:choose>
					<xsl:when test="player/password = 'd41d8cd98f00b204e9800998ecf8427e'">
						Техническая поддержа осуществляется только для защищенных пользователей. <a href="/protect/">Защитите своего  персонажа</a>.
					</xsl:when>
					<xsl:otherwise>
				<iframe border="0" frameborder="0" width="100%" height="500px" src="http://support.moswar.ru/public?Action=AgentTicketOpen&amp;ProjectID=9&amp;SessionID={session}"></iframe>
					</xsl:otherwise>
				</xsl:choose>
			</div>
		</div>
		</div>
	</div>
    </xsl:template>
</xsl:stylesheet>