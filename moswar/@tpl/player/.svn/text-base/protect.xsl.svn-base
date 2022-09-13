<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>
	<xsl:include href="common/playerlink.xsl" />
	<xsl:template match="/data">
		<script type="text/javascript" src="/@/js/register.js"></script>
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear"><h2>Сохранить персонажа</h2></div>
				<div id="content" class="registration">
					<div style="padding: 10px 25px;" class="block-rounded clear">
						<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
						<form id="form-protect" method="post" action="/">
							<input type="hidden" name="action" value="protect" />
							<input type="hidden" name="paytype" value="{paytype}" />

							<!-- При переходе из заначки  -->
							<xsl:if test="pay='true'">
								<div class="regitration-save">
									<div class="block-rounded">
										Перед добычей <span class="med"><i></i>мёда</span> вам обязательно надо <b>придумать пароль своему персонажу</b>. Иначе, его муогут украсть.
									</div>
								</div>
							</xsl:if>
							
							<h3><xsl:call-template name="playerlink"><xsl:with-param name="player" select="player" /><xsl:with-param name="link" select="'0'" /></xsl:call-template></h3>
							<table class="layout avatar-change">
								<tr>
									<td class="label">Укажите e-mail</td>
									<td class="input"><input id="email" value="{email}" type="text" name="email" maxlength="32" /></td>

									<td id="email-error"><span class="error"><xsl:value-of select="email-error" /></span></td>
								</tr>
								<tr>
									<td class="label">Впишите пароль</td>
									<td class="input"><input type="password" id="password" name="password" maxlength="16" /></td>
									<td id="password-error"><span class="error"><xsl:value-of select="password-error" /></span></td>
								</tr>
								<tr>
									<td class="label">Повторите пароль</td>
									<td class="input"><input type="password" id="retypepassword" maxlength="16" /></td>
									<td id="retypepassword-error"><span class="error"></span></td>
								</tr>
								<tr>
									<td colspan="3" class="submit">
										<p><input type="checkbox" id="registration-agreement-checkbox" />
												<label for="registration-agreement-checkbox">
												Я согласен с
												<a href="/licence/" target="_blank">пользовательским соглашением</a>,
												<a href="/licence/game_rules/" target="_blank">правилами игры</a>,<br /><a href="/licence/rules/" target="_blank">правилами общения</a>,
												<a href="/licence/dogovor-oferta/" target="_blank">договором-офертой</a>.
										</label></p>
										<div id="registration-agreement-error" class="error" style="display: none;">Необходимо Ваше согласие с правилами.<br /><br /></div>
										<button type="submit" class="button">
											<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Готово</div>
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