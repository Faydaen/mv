<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Шаг 1 / Покупка мёда за WebMoney</h2>
				</div>
				<div id="content" class="stash">
					<xsl:if test="protect_gameleads = 'true'">
						<img src="http://pix.gameleads.ru/{protect_order}/q1/{protect_md5}" />
					</xsl:if>
					
					<div style="float: right; width: 140px; text-align: center;">
						<img src="/@/images/pers/man101.png" align="right" />
					</div>
					
					<form method="POST" action="/stash/webmoney/step2/" style="margin-right:150px">
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
									<img src="/@/images/stash/webmoney.png"  vspace="5" hspace="5" />
									<br clear="all" />
                                    <p>WebMoney это быстрый способ платежей, переводы в котором происходят мгновенно. Так же возможно зачисление с WM карт.</p>
                                    <p>Оплатить можно как с R, так и с Z кошелька. Конвертация происходит автоматически в процессе оплаты.</p>
                                    <p>Данная услуга не облагается НДС.</p>                               <!--p><b>Внимание!</b> Если у Вас не получается выполнить платеж в автоматическом режиме, вы можете сделать перевод
                                    на кошелек <b>R239734663335</b> вручную, указав в комментарии ваш ID или логин. После перевода желательно отправить
                                    на e-mail <a href="mailto:support@moswar.ru">support@moswar.ru</a> сообщение.</p-->
                                </td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
    </xsl:template>

</xsl:stylesheet>     
