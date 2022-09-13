<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Шаг 1 / Покупка мёда через Мобильный платеж</h2>
				</div>
				<div id="content" class="stash">
					<xsl:if test="protect_gameleads = 'true'">
						<img src="http://pix.gameleads.ru/{protect_order}/q1/{protect_md5}" />
					</xsl:if>

					<div style="float: right; width: 140px; text-align: center;">
						<img src="/@/images/pers/man101.png" align="right" />
					</div>

					<form method="POST" action="/stash/mobile/step2/" style="margin-right:150px">
						<table class="forms">
							<tr>
								<td class="label">Мёда:</td>
								<td class="input">
									<select name="amount" id="sum" onchange="checkSum();">
										<option value="-">--- выберите сумму ---</option>
										<xsl:for-each select="rates/element">
                                            <xsl:if test="rub &lt; 3001">
                                                <option value="{rub}"><xsl:value-of select="label" /></option>
                                            </xsl:if>
										</xsl:for-each>
									</select>
									<div class="hint" id="mts-warning" style="display: none; color: #ff0000;"><b>Внимание!</b> Минимальная сумма для абонентов МТС — 300 рублей.</div>
								</td>
							</tr>

							<tr>
								<td class="label">Ваш номер телефона:</td>
								<td class="input">
									<span style="font-weight:bold; font-size:110%">8</span>
									<input style="margin:0 5px" type="text" onkeyup="checkFocus(this)" id="phone" maxlength="3" size="4" value="" name="phone1" />
									<input type="text" id="phone2" maxlength="7" size="8" value="" name="phone2" />
									<div class="hint">Только цифры. Например: <span style="color:#a7a899;">8</span> 987 6543210</div>
								</td>
							</tr>
							<tr>
								<td class="label"></td>
								<td class="input">
									<button  class="button" type="submit">
										<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Добыть мёд</div>
										</span>
									</button>
								</td>
							</tr>
							<tr>
								<td class="label"></td>
								<td class="input">
                                    <p>Мобильный платёж – это самый удобный способ оплаты с помощью вашего мобильного телефона,
                                    переводы в котором происходят мгновенно.</p>
                                    <p style="color:#e30000"><b>Мобильный платёж доступен только для абонентов МТС, Мегафон, Билайн и только при оформлении
                                    номера на физическое лицо.</b></p>
                                    <p>Мёд зачисляется сразу после отправки подтверждения на полученное вами СМС от оператора.</p>
                                </td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<script>
				<![CDATA[
				function checkFocus(obj){
					var value= $(obj).val();

					value = value.replace(/[^0-9]/, '');
					$(obj).val(value);

					if ($(obj).attr('id')=='phone'){
						if (value.length==3){
							$('#phone2').focus();
						}
					}else{
						if (value.length==0){
							$('#phone').focus();
						}
					}
				}

				function checkSum() {
					if ($('#sum').val() < 300) {
						$('#mts-warning').show();
					} else {
						$('#mts-warning').hide();
					}
				}
				]]>
			</script>
		</div>

    </xsl:template>

</xsl:stylesheet>