<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Шаг 1 / Покупка мёда через RBK Money</h2>
				</div>
				<div id="content" class="stash">
					<xsl:if test="protect_gameleads = 'true'">
						<img src="http://pix.gameleads.ru/{protect_order}/q1/{protect_md5}" />
					</xsl:if>

					<div style="float: right; width: 140px; text-align: center;">
						<img src="/@/images/pers/man101.png" align="right" />
					</div>

					<form method="POST" action="/stash/rbk/step2/" style="margin-right:150px">
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
									<img src="/@/images/stash/rbkmoney.png"  vspace="5" hspace="5" />
									<br clear="all" />
									<p>RBkMoney — это универсальный, удобный и безопасный платежный инструмент, объединяющий все возможные способы онлайн-расчетов.</p>
                                </td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
    </xsl:template>

</xsl:stylesheet>
