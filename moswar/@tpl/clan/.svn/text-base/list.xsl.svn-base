<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
	
    <xsl:include href="common/clanlink.xsl" />

    <xsl:template match="/data">
					<div class="column-right-topbg">
						<div class="column-right-bottombg" align="center">
							<div class="heading clear"><h2>Кланы</h2></div>
							<div id="content" class="clan">
								<div class="clan-list">
									<form class="clan-search" method="post" action="/clan/search/" name="listForm" id="listForm">
										<div class="block-bordered">
											<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
											<div class="center clear">
												<h3>Поиск кланов</h3>
												<table class="forms">
													<tr>

														<td class="label">Название</td>
														<td class="input"><input class="name" type="text" name="name" /></td>
													</tr>
													<tr>
														<td class="label">Сторона</td>
														<td class="input">
															<select name="fraction">
																<option value="any">Любая</option>
																<option value="resident">Коренные</option>
																<option value="arrived">Понаехавшие</option>
															</select>
														</td>
													</tr>
													<tr>
														<td class="label"></td>
														<td class="input">
															<button class="button" onclick="$('#listForm').trigger('submit');">
																<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																	<div class="c">Найти</div>
																</span>
															</button>
														</td>
													</tr>
												</table>

											</div>
											<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
										</div>
									</form>

									<div class="block-rounded">
										<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
										<xsl:choose>
											<xsl:when test="count(clans/element) > 0">
												<h3>Кланы (<xsl:value-of select="count(clans/element)" />)</h3>
												<table class="list-clans">
													<xsl:for-each select="clans/element">
														<tr>
														<td><xsl:value-of select="position()" /></td>
														<td>
															<xsl:call-template name="clanlink">
																<xsl:with-param name="clan" select="current()" />
															</xsl:call-template>
														</td>
														<td>
															<xsl:value-of select="slogan" />
														</td>
													</tr>
													</xsl:for-each>
												</table>
											</xsl:when>
											<xsl:otherwise>
												<p>Нет кланов.</p>
											</xsl:otherwise>
										</xsl:choose>

									</div>
								</div>
							</div>
						</div>
					</div>
    </xsl:template>
</xsl:stylesheet>
