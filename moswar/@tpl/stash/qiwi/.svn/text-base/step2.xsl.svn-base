<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Шаг 2 / Покупка мёда через терминалы QIWI</h2>
				</div>
				<div id="content" class="stash">
					
					<div style="float: right; width: 140px; text-align: center;">
						<img src="/@/images/pers/man101.png" align="right" />
					</div>
					
					<form id="pay" name="pay" method="POST" action="" style="margin-right:150px">
                        <table class="forms">
							<tr>
								<td class="label">Добыть</td>
								<td class="input">
									<span class="med"><xsl:value-of select="amount" /><i></i></span> за <xsl:value-of select="payment_amount" /> руб.
								</td>
							</tr>
							
							<tr>
								<td class="label">Имя персонажа</td>
								<td class="input">
									<xsl:value-of select="player/nickname" />
								</td>
							</tr>
							
							<tr>
								<td class="label">Идентификатор персонажа</td>
								<td class="input">
									<xsl:value-of select="player/id" />
								</td>
							</tr>
							
							<tr>
								<td class="label">Номер телефона</td>
								<td class="input">
									8&#0160;<xsl:value-of select="phone1" />&#0160;<xsl:value-of select="phone2" />
								</td>
							</tr>

                            <tr>
								<td class="label"></td>
								<td class="input">
									<p class="holders">Теперь Вам необходимо оплатить выставленный Вам счет через терминал QIWI.</p>
								</td>
							</tr>
							
							<!--tr>
								<td class="label"></td>
								<td class="input">
									<button  class="button" type="submit">
										<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Добыть мёд</div>
										</span>
									</button>
									<p>После нажатия на «Добыть мёд» счет будет оформлен и можно перейти ко 2-ому шагу инструкции.</p>
								</td>
							</tr-->

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
		</div>
    </xsl:template>

</xsl:stylesheet>