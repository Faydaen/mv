<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
		<div class="column-right-topbg">
						<div class="column-right-bottombg" align="center">
							<div class="heading clear"><h2>
								Фото от Лёлика
							</h2></div>
							<div id="content" class="nightclub">

								<div class="nightclub-photo">

									<img src="/@/images/pers/man113.png" align="right" style="position:relative; z-index:1;" />

									<div class="clear description">
										
										<div class="nightclub-photo-view">
											<img id="avatar-back" class="{player/background}" src="/@/images/pers/{player/avatar}" />
											<xsl:if test="isset_photo = 'true'"><div class="hint">Отличная фотка!<br />Осталось дней: <xsl:value-of select="days_left" /></div></xsl:if>
										</div>
										
										<div class="text">
											<div class="block-rounded">
												<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
												Лёлик &#8212; модный клубный фотограф. Его снимки постоянно попадают
												на&#160;обложки глянцевых журналов, и&#160;он может сделать знаменитым любого столичника.
												Он&#160;талантлив, но&#160;очень вспыльчив. Часто любит спорить с&#160;другими фотографами,
												а&#160;когда заканчиваются аргументы, начинает мериться объективами.
											</div>
											<p><b>Выберите фон и&#160;он будет 14&#160;дней<br />
											красоваться на&#160;вашем аватаре.</b></p>

											<form action="/nightclub/setphoto/" method="post">
												<input type="hidden" name="action" value="setphoto" />
												<input id="avatar-back-id" type="hidden" name="backid" value="{substring-after(/data/player/background, 'avatar-back-')}" />
												<xsl:choose>
													<xsl:when test="count(items/camera/id) = 1">
														<img src="/@/images/obj/photocamera.png" align="left" /><span class="hint">Вы можете подарить Лёлику его желанную камеру, и он сфоткает вас бесплатно на любой фон.</span><br clear="all" />
														<button class="button" type="submit">
															<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																<div class="c">Сфоткаться</div>
															</span>
														</button>
													</xsl:when>
													<xsl:otherwise>
															<button class="button" type="submit">
																<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div class="c">Запечатлить образ (14 дней) - <span id="avatar-back-cost"><span class="ruda">5<i></i></span></span></div>
													</span>
												</button>
													</xsl:otherwise>
												</xsl:choose>
											</form>
										</div>
									</div>

									<div class="back-choose clear">
										<div class="back-choose-block clear">
											<ul>
												<xsl:for-each select="backgrounds/element">
													<li>
														<xsl:if test="/data/player/background = concat('avatar-back-', bgid)">
															<xsl:attribute name="class">current</xsl:attribute>
														</xsl:if>
														<xsl:if test="locked = 1">
															<xsl:choose>
																<xsl:when test="/data/player/background = concat('avatar-back-', bgid)"><xsl:attribute name="class">locked current</xsl:attribute></xsl:when>
																<xsl:otherwise><xsl:attribute name="class">locked</xsl:attribute></xsl:otherwise>
															</xsl:choose>
															<i class="icon-locked">
																<xsl:if test="locked = 1">
																	<xsl:attribute name="tooltip">1</xsl:attribute>
																	<xsl:attribute name="title">Этот фон недоступен||Чтобы воспользоваться этим фоном, вам необходимо:|<xsl:value-of select="conditions" /></xsl:attribute>
																</xsl:if>
															</i>
														</xsl:if>
														<img src="/@/images/pers/back/{thumb}-thumb.jpg" rel="avatar-back-{bgid}">
															<xsl:if test="locked = 1">
																<xsl:attribute name="tooltip">1</xsl:attribute>
																<xsl:attribute name="title">Этот фон недоступен||Чтобы воспользоваться этим фоном, вам необходимо:|<xsl:value-of select="conditions" /></xsl:attribute>
															</xsl:if>
														</img>
														<div class="cost"><b>
															<xsl:if test="money > 0 or bgid &lt;= 6">
																<span class="tugriki"><xsl:value-of select="money" /><i></i></span>
															</xsl:if>
															<xsl:if test="ore > 0">
																<span class="ruda"><xsl:value-of select="ore" /><i></i></span>
															</xsl:if>
															<xsl:if test="honey > 0">
																<span class="med"><xsl:value-of select="honey" /><i></i></span>
															</xsl:if>
														</b></div>
													</li>
												</xsl:for-each>
											</ul>
										</div>
										<i class="arrow-left" id="avatar-back-choose-arrow-left"></i>
										<i class="arrow-right" id="avatar-back-choose-arrow-right"></i>
									</div>
									<input type="hidden" id="regions-choose-id" name="region" />
									<script type="text/javascript">
										$(document).ready(function() {
											var visibleBacks = 5;
											var curBack = $("div.back-choose-block ul li").index( $("div.back-choose-block ul li.current")[0] ) || 0;
											var startBack = curBack;
											if ( startBack &lt; visibleBacks ) {
												startBack = 0;
											} else if ( $("div.back-choose-block ul li").length - startBack &lt; visibleBacks) {
												startBack = $("div.back-choose-block ul li").length - visibleBacks;
											}
											
											$("#regions-choose-id").val(curBack);
											$("div.back-choose-block").jCarouselLite({
												btnNext: "#avatar-back-choose-arrow-right",
												btnPrev: "#avatar-back-choose-arrow-left",
												visible: visibleBacks,
												circular: false,
												start: startBack
											})
											if(curBack == 0) {
												/* use only if circular:false */
												$("#avatar-back-choose-arrow-left").addClass("disabled");
											}
											$("div.back-choose-block ul li").bind("click", function(){
												if( $(this).hasClass("current") || $(this).hasClass("locked") ) {
													return false;
												} else {
													$("div.back-choose-block ul li").removeClass("current");
													$(this).addClass("current");
													$("#avatar-back")[0].className = $(this).find("img").attr("rel");
													$("#avatar-back-cost").html( $(this).find("div.cost b").html() );
													$("#avatar-back-id").val( $(this).find("img").attr("rel").replace(/\D*/i,"")); /* оставить только цифру из класса */
												}
											});
											$("#avatar-back-cost").html( $("div.back-choose-block ul li.current").find("div.cost b").html() );
										});


									</script>

								</div>

							</div>
						</div>
					</div>

    </xsl:template>
</xsl:stylesheet>
