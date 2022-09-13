<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Шаг 2 / Покупка мёда через <xsl:choose><xsl:when test="yandex=1">Яндекс.Деньги</xsl:when><xsl:otherwise>ДеньгиОнлайн</xsl:otherwise></xsl:choose></h2>
				</div>
				<div id="content" class="stash">

					<div style="float: right; width: 140px; text-align: center;">
						<img src="/@/images/pers/man101.png" align="right" />
					</div>

					<form id="pay" name="pay" method="POST" action="http://www.onlinedengi.ru/wmpaycheck.php" accept-charset="windows-1251" style="margin-right:150px">
                        <input type="hidden" name="project" value="{onlinedengi_shop_id}" />
                        <input type="hidden" name="source" value="{onlinedengi_source_id}" />
                        <input type="hidden" name="nickname" value="{player/id}" />
                        <input type="hidden" name="amount" value="{payment_amount}" />
                        <xsl:if test="yandex = 1">
                            <input type="hidden" name="paymode" value="yandex" />
                        </xsl:if>
						<table class="forms">
							<tr>
								<td class="label">Добыть</td>
								<td class="input">
									<span class="med"><xsl:value-of select="amount" /><i></i></span> за  <xsl:value-of select="payment_amount" /> руб.
								</td>
							</tr>
                            <xsl:if test="yandex != 1">
                                <tr>
                                    <td class="label">Способ платежа</td>
                                    <td class="input">
                                        <select name='paymode' class='field select_paymode' id='paymode'>
                                            <option value='bank_card'>Банковские карты</option>
                                            <option value='mk'>Личный кабинет QIWI</option>
                                            <!--
                                            <option value='12'>Карты ДеньгиOnline</option>
                                            <option value='paypal'>PayPal</option>
                                            -->
                                            <option value='moneymail'>MoneyMail</option>
                                            <option value='webcreds'>WebCreds</option>
                                        </select>
                                    </td>
                                </tr>
							</xsl:if>
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
								<td class="label"></td>
								<td class="input">
									<button  class="button" type="submit">
										<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Добыть мёд</div>
										</span>
									</button>
									
									<p>Выберите один из представленных способов зачисления:</p>
									<p>
										<b>Банковские карты</b> — оплата с помощью дебетных карт типа Visa или Mastercard. Максимальный платеж для данного типа платежа не должен превышать 6000 рублей.<br/>
										<b>MoneyMail</b> — если вы знакомы с данной системой и имеете интернет-кошелек данного типа, вы можете совершить платеж через нее.<br/>
										<b>WebCreds</b> — если вы знакомы с данной системой и имеете интернет-кошелек данного типа, вы можете совершить платеж через нее.<br/>
									</p>
									
									<p>После нажатия на «Добыть мёд» вы перейдете на страницу оплаты ДеньгиОнлайн.</p>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
    </xsl:template>

</xsl:stylesheet>
