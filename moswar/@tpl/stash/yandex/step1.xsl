<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Шаг 1 / Покупка мёда за Яндекс.Деньги</h2>
				</div>
				<div id="content" class="stash">
					<xsl:if test="protect_gameleads = 'true'">
						<img src="http://pix.gameleads.ru/{protect_order}/q1/{protect_md5}" />
					</xsl:if>

					<div style="float: right; width: 140px; text-align: center;">
						<img src="/@/images/pers/man101.png" align="right" />
					</div>

					<form method="POST" action="/stash/yandex/step2/" style="margin-right:150px">
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
									<img src="/@/images/stash/yandexdengi.png"  vspace="5" hspace="5" />
									<br clear="all" />
										<p>Яндекс.Деньги – удобная и безопасная система онлайн-платежей для жителей России и СНГ.</p> 
										<p>Яндекс.Деньгами можно оплачивать множество товаров и услуг через интернет – мгновенно и без комиссии. Чтобы открыть счет в системе, нужен только логин на Яндексе. А чтобы начать совершать платежи, пополните счет наличными деньгами.</p> <p>В странах СНГ это можно сделать через системы денежных переводов CONTACT и Anelik.</p>
                                </td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
    </xsl:template>

</xsl:stylesheet>
