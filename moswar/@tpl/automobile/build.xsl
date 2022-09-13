<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>
    <xsl:include href="common/price.xsl" />

	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear"><h2>Автозавод</h2></div>
				<div id="content" class="auto">
					<div class="building-upgrade">
						<h3 class="curves">
							<div class="goback">
								<span class="arrow">◄</span><a href="/automobile/">К цехам</a>
							</div>
							<xsl:value-of select="factory/name" /> [<xsl:value-of select="factory/level" />]
						</h3>
						<div class="block-rounded">
							<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
							<div class="text clear">
								<p>
									<img align="left" src="{factory/image}-{factory/view_level}.png" style="margin: 0;" /><xsl:value-of select="factory/description" />
									С улучшением цеха вам будут доступны новые автомобили и прибамбасы.
									<span class="dashedlink" onclick="$('#building-upgrade-description').toggle();">Показать</span>
								</p>
								<p id="building-upgrade-description" style="display:none;">
									<xsl:for-each select="improvements/element">
										<img src="{image}" tooltip="1" title="{name}||{description}||Требования: {../../factory/name} [{factory_level}]|">
											<xsl:if test="disabled = 1">
												<xsl:attribute name="class">disabled</xsl:attribute>
											</xsl:if>
										</img>
									</xsl:for-each>
								</p>
								<xsl:if test="maxlevel = 1">
									<p class="green"><b>У вас самый крутой цех. Лучше и не придумаешь.</b></p>
								</xsl:if>
								<xsl:if test="cooldown/end != 0">
									<p class="green">Идёт строительство: <b><xsl:value-of select="cooldown/progress" /></b>.</p>
									<p>
									Насладиться <a href="/automobile/">видом строительства</a>.
									</p>
								</xsl:if>
							<xsl:if test="maxlevel = 0 and cooldown/end = 0">
									<p>Чтобы построить
									<b><xsl:value-of select="factory/name" /> [<xsl:value-of select="factory/level + 1" />]</b> вам требуется собрать необходимые материалы и инструменты.
									</p>

									<h3>У вас в наличии:</h3>
									<div class="parts-list">
										<xsl:for-each select="parts/element">
											<span class="part-item">
											
											
												<div><img src="{image}" /></div>
												<div class="num"><span><xsl:value-of select="count_have" /> из <xsl:value-of select="count_need" /></span></div>
												<xsl:if test="count_have &lt; count_need">
												
													<div onclick="document.location.href='/alley/';" class="button"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Добыть в закоулках</div></span></div>
													<div>
													или
													</div>
													<div>
														<form action="/automobile/buypart/{code}/" method="post">
															<button class="button" type="submit" onclick="$(this).parents('div.alert:first').hide();">
																<span class="f">
																	<i class="rl"></i><i class="bl"></i><i class="brc"></i>
																	<div class="c">Купить 1 шт. - <span class="med"><xsl:value-of select="honey" /><i></i></span></div>
																</span>
															</button>
														</form>
													</div>
												</xsl:if>
											</span>
										</xsl:for-each>
									</div>
								</xsl:if>
							</div>

							<xsl:if test="maxlevel = 0 and cooldown/end = 0">
								<div class="actions">
									<xsl:if test="honey/count != 0">
										<form action="/automobile/buyparts/{factory/id}/" method="post" style="display: inline;">
											<button class="button" type="submit">
												<span class="f">
													<i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">Докупить (<xsl:value-of select="honey/count" /> шт.) и построить -
													<xsl:call-template name="showprice">
														 <xsl:with-param name="money" select="cost/money" />
														 <xsl:with-param name="ore" select="cost/ore" />
														 <xsl:with-param name="oil" select="cost/oil" />
														 <xsl:with-param name="honey" select="honey/value" />
														 <xsl:with-param name="nohoney" select="0" />
													</xsl:call-template>
													</div>
												</span>
											</button>
										</form>
										&#0160;
									</xsl:if>
									<form action="/automobile/upgradefactory/{factory/id}/" method="post" style="display: inline;">
										<button class="button" type="submit">
											<xsl:choose>
												<xsl:when test="honey/count != 0"><xsl:attribute name="class">button disabled</xsl:attribute><xsl:attribute name="onclick">return false;</xsl:attribute></xsl:when>
												<xsl:otherwise><xsl:attribute name="class">button</xsl:attribute></xsl:otherwise>
											</xsl:choose>
											<span class="f">
												<i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Строить -
												<xsl:call-template name="showprice">
													 <xsl:with-param name="money" select="cost/money" />
													 <xsl:with-param name="ore" select="cost/ore" />
													 <xsl:with-param name="oil" select="cost/oil" />
													 <xsl:with-param name="nohoney" select="1" />
												</xsl:call-template>
												</div>
											</span>
										</button>
									</form>
								</div>
							</xsl:if>
						</div>
					</div>
				</div>
			</div>
		</div>
	</xsl:template>

</xsl:stylesheet>
