<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>

	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Восстановление пароля &#8212; Шаг 1</h2>
				</div>
				<div id="content">
					<form id="form-remind" action="/auth/remind/" method="post">
						<xsl:if test="error">
							<div class="report">
								<div class="red">
									<xsl:value-of select="error" />
								</div>
							</div>
						</xsl:if>
						
						<table class="forms">
							<tr>
								<td></td>
								<td class="input">Введите e-mail, указанный при регистрации. Через несколько минут вам придет письмо с дальнейшими инструкциями.</td>
							</tr>
							<tr>
								<td class="label">E-mail:</td>
								<td class="input">
									<input class="wide" type="text" name="email" />
								</td>
							</tr>
							<tr>
								<td></td>
								<td class="input">
									<button class="button" type="submit">
										<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Далее</div>
										</span>
									</button>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</xsl:template>

</xsl:stylesheet>