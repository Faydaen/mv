<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>
	<xsl:include href="common/playerlink.xsl" />
	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div align="center" class="column-right-bottombg">
				<div class="heading clear"><h2>Войти по имени</h2></div>
				<div class="registration" id="content">
					<div class="block-rounded clear" style="padding: 10px 25px;">
						<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
						<form method="post" action="/">
							<input type="hidden" value="login" name="action" />
							<table class="layout avatar-change">
								<tr>
									<td class="label">Укажите имя персонажа</td>
									<td class="input"><input type="text" maxlength="32" name="email" id="email" value="{email}" /></td>
									<td id="email-error"><span class="error"><xsl:value-of select="email-error" disable-output-escaping="yes" /></span></td>
								</tr>
								<tr>
									<td class="submit" colspan="3">
										<button class="button" type="submit">
											<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Войти</div>
											</span>
										</button>
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</xsl:template>
</xsl:stylesheet>