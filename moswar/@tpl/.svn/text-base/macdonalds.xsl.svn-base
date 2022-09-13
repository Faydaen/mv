<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
<div class="column-right-topbg">
						<div class="column-right-bottombg" align="center">
							<div class="heading clear"><h2>
								<span class="macdonalds"></span>
							</h2></div>
							<div id="content" class="macdonalds">


								<div class="welcome">
								</div>


								<table>
									<tr>
										<td style="width:50%; padding:0 5px 0 0;">
											<div class="block-bordered">
												<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
												<div class="center clear">
													<h3>Работа</h3>


													<form class="macdonalds-work" id="workForm" action="/macdonalds/work/" method="post">
													<input type="hidden" name="action" value="work" />
													<p>Вы можете работать <xsl:value-of select="currentskill/tip" />.<br />Ваша зарплата — <span class="tugriki"><xsl:value-of select="currentskill/salary" /><i></i> в час</span></p>
														<div class="time">
															<select name="time">
																<option value="1">1 час</option>
																<option value="2">2 часа</option>
																<option value="3">3 часа</option>
																<option value="4">4 часа</option>
																<option value="5">5 часов</option>
																<option value="6">6 часов</option>
																<option value="7">7 часов</option>
																<option value="8">8 часов</option>
															</select>
															<span class="button" onclick="$('#workForm').trigger('submit');">
																<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																	<div class="c">Работать</div>
																</span>
															</span>
														</div>
														<p><xsl:choose>
															<xsl:when test="nextskill/level > player/level">
																На <xsl:value-of select="nextskill/level" /> уровне вы сможете работать <xsl:value-of select="nextskill/tip" /> с&#160;минимальной зарплатой <span class="tugriki"><xsl:value-of select="nextskill/salary" /><i></i> в час</span>.
															</xsl:when>
															<xsl:otherwise>
																Вы можете работать <xsl:value-of select="nextskill/tip" /> с&#160;минимальной зарплатой <span class="tugriki"><xsl:value-of select="nextskill/salary" /><i></i> в час</span>.
															</xsl:otherwise>
														</xsl:choose></p>
													</form>
												</div>
												<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
											</div>
										</td>
										<td style="width:50%; padding:0 0 0 5px;">
											<div class="block-bordered">
												<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>

												<div class="center clear">
													<h3>Куры и тренинги</h3>
													<xsl:choose>
														<xsl:when test="nextskill/salary!=''">
															<form class="macdonalds-training" id="trainForm" action="/macdonalds/train/" method="post">
																<p>Обучение позволит повысить вашу эффективность и увеличить минимальную зарплату.
																После прохождения тренингов вы сможете получать зарлату — <span class="tugriki"><xsl:value-of select="nextskill/salary" /><i></i> в час</span></p>
																<div class="button" onclick="$('#trainForm').trigger ('submit');">
																	<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																		<div class="c">Пройти тренинги - <xsl:if test="nextskill/cost_money>0"><span class="tugriki"><xsl:value-of select="nextskill/cost_money" /><i></i></span></xsl:if><xsl:if test="nextskill/cost_ore>0"><span class="ruda"><xsl:value-of select="nextskill/cost_ore" /><i></i></span> или <span class="med"><xsl:value-of select="nextskill/cost_ore" /><i></i></span></xsl:if></div>
																	</span>
																</div>
															</form>
														</xsl:when>
														<xsl:otherwise>
															<form class="macdonalds-training">
																<p>Вы уже достигли совершенства.</p>
															</form>
														</xsl:otherwise>
													</xsl:choose>
												</div>
												<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>

											</div>

										</td>
									</tr>
								</table>

							</div>
						</div>
					</div>
	</xsl:template>
</xsl:stylesheet>
