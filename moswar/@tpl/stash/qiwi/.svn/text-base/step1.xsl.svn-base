<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Шаг 1 / Покупка мёда через терминалы QIWI</h2>
				</div>
				<div id="content" class="stash">
					<xsl:if test="protect_gameleads = 'true'">
						<img src="http://pix.gameleads.ru/{protect_order}/q1/{protect_md5}" />
					</xsl:if>
					
					<div style="float: right; width: 140px; text-align: center;">
						<img src="/@/images/pers/man101.png" align="right" />
					</div>
					
					<form method="POST" action="/stash/qiwi/step2/" style="margin-right:150px">
						<table class="forms">
							<tr>
								<td class="label">Мёда:</td>
								<td class="input">									
									<select name="amount">
										<xsl:for-each select="rates/element">
											<option value="{rub}"><xsl:value-of select="label" /></option>
										</xsl:for-each>
									</select>
								</td>
							</tr>

							<tr>
								<td class="label">Ваш номер телефона:</td>
								<td class="input">									
									<span style="font-size: 20px;">8</span>
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
								<td class="label" align="center"> <img src="/@/images/stash/qiwi.png"  vspace="5" hspace="5" /></td>
								<td class="input">
									<p>
										Оплата через терминалы происходит в несколько шагов:
                                        <ol>
                                            <li>Вы указываете свой номер телефона и сумму счета. Нажимете Добыть мёд.</li>
                                            <li>Вы идёте к терминалу и выбираете там пункт «<b>Личный кабинет</b>» (вторая кнопка). Указываете номер
                                            телефона, введенный в это поле. </li>
											<li>Если вы никогда раньше, не пользовались QIWI, то вам придёт смс с вашим PIN-кодом(4 цифры), которые надо будет ввести в терминал. Если вы когда-то давно пользовались, и не помните PIN, то его можно легко поменять, следуя инструкции на терминале.</li>
											<li>Затем выбираете «<b>Счета к оплате</b>». На этой странице вы
                                            увидите свой счет.</li>
                                            <li>Внесите наличные деньги. В случае если у вас осталась сдача, вы можете перевести ее на свой телефон.</li>
                                        </ol>
									</p>
									
                                </td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<script>
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
			</script>
		</div>
		
    </xsl:template>

</xsl:stylesheet> 