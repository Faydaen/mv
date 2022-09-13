<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Шаг 2 / Покупка мёда через RBK Money</h2>
				</div>
				<div id="content" class="stash">

					<div style="float: right; width: 140px; text-align: center;">
						<img src="/@/images/pers/man101.png" align="right" />
					</div>

					<form id="pay" name="pay" method="POST" action="https://rbkmoney.ru/acceptpurchase.aspx" accept-charset="windows-1251" style="margin-right:150px">
                        <input type="hidden" name="eshopId" value="{rbk_shop_id}" />
                        <input type="hidden" name="orderId" value="{payment_number}" />
                        <input type="hidden" name="recipientAmount" value="{payment_amount}" />
                        <input type="hidden" name="recipientCurrency" value="RUR" />
                        <input type="hidden" name="serviceName" value="Пополнение счета {player/nickname} ({player/id}) на {payment_amount} - #{payment_number}" />

                        <input type="hidden" name="userField_1" value="{userField_1}" />
                        <input type='hidden' name='userField_2' value='{player/id}' />
                        <input type='hidden' name='userField_3' value='{payment_number}' />

						<table class="forms">
							<tr>
								<td class="label">Добыть</td>
								<td class="input">
									<span class="med"><xsl:value-of select="honey2buy" /><i></i></span> за  <xsl:value-of select="payment_amount" /> руб.
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
								<td class="label"></td>
								<td class="input">
									<button  class="button" type="submit">
										<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Добыть мёд</div>
										</span>
									</button>
									<p>После нажатия на «Добыть мёд» вы перейдете на страницу оплаты RBK Money.</p>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
    </xsl:template>

</xsl:stylesheet>
