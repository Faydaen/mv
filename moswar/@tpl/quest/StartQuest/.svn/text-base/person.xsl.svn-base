<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>
	<xsl:include href="general.xsl" />
	<xsl:template match="/data">
		<script type="text/javascript" src="/@/js/register.js"></script>
		<div class="column-right-topbg">
			<div align="center" class="column-right-bottombg">
				<div class="heading clear"><h2>Ваш персонаж</h2></div>
				<div class="registration" id="content">
					<form id="form-person" method="post" action="/">
						<input type="hidden" name="action" value="person" />
						<input type="hidden" name="avatar" id="input-person-avatar" value="{avatar}" />
						<input type="hidden" name="background" id="input-person-background" value="{background}" />
						<div class="block-rounded">
							<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
							<div class="registration-top">
								Вот вы и в столице. Теперь подберите свой образ и выберите сторону
							</div>
							<div class="registration-middle clear">
								<div class="left">
									<p>
										<i title="Подобрать случайно" onclick="Register.randomize();" class="icon button-randomize"></i>
									</p>
									<p class="nickname">
										Придумайте себе имя:<br />
										<input type="text" style="margin-top: 5px; width: 200px; text-align: center; font-size: 120%;" name="name" id="person-name" value="{name}" maxlength="16" />
										<div id="login-error"><span class="error"><xsl:value-of select="login-error" /></span></div>
									</p>
								</div>

								<div class="right">
									<table class="layout avatar-change">
										<tr>
											<td><div id="pers-arrow-1"></div></td>
											<td class="pers" rowspan="2">
												<div id="avatar-back">
													<img id="person-avatar" style="" src="" />
													<img style="display: none;" src="/@/images/ico/thumb-arrived.png" id="avatar-back-thumb-arrived" />
													<img style="display: none;" src="/@/images/ico/thumb-resident.png" id="avatar-back-thumb-resident" />
													<div class="registration-side-choose">
														<input type="radio" name="side" id="registration-side-resident" value="resident" style="vertical-align: bottom;" onclick="Register.changeFraction(this.value);">
															<xsl:if test="side = 'arrived'">
																<xsl:attribute name="checked">resident</xsl:attribute>
															</xsl:if>
														</input>
														<label for="registration-side-resident"></label>
														<br />
														<input type="radio" name="side" id="registration-side-arrived" value="arrived" style="vertical-align: bottom;" onclick="Register.changeFraction(this.value);">
															<xsl:if test="side = 'arrived'">
																<xsl:attribute name="checked">checked</xsl:attribute>
															</xsl:if>
														</input>
														<label for="registration-side-arrived"></label>
													</div>
												</div>
											</td>
											<td><div id="pers-arrow-2"></div></td>
										</tr>
										<tr>
											<td><div id="pers-arrow-3"></div></td>
											<td><div id="pers-arrow-4"></div></td>
										</tr>
										<tr>
											<td></td>
											<td class="gender"><div style="color: #C8692A; font-size: 11px;" id="avatar-gender"></div></td>
										</tr>
									</table>
								</div>
							</div>
							<div class="registration-bottom">
								<button type="submit" class="button">
									<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										<div class="c">Далее</div>
									</span>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</xsl:template>
</xsl:stylesheet>
