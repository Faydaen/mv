<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
	<!-- lightbox -->
    <link rel="stylesheet" type="text/css" media="screen" href="/@/jquery.lightbox/css/jquery.lightbox.packed.css" />
    <script type="text/javascript" src="/@/jquery.lightbox/js/jquery.color.min.js"></script>
    <script type="text/javascript" src="/@/jquery.lightbox/js/jquery.lightbox.min.js"></script>
    <script type="text/javascript"><![CDATA[
		$(function(){
			$.Lightbox.construct({
				text: {
					close: "Закрыть",
					image: "Картинка",
					of: "из",
					help: {
						close: "Закрыть"
					}
				}
			});
		});]]>
	</script>
    <!-- /lightbox -->
		<div class="column-right-topbg">
						<div class="column-right-bottombg" align="center">
							<div class="heading clear"><h2>
								Коллекция
							</h2></div>
							<div id="content" class="home">
								<div class="collection">

									<h3 class="curves"><xsl:value-of select="collection/name" /></h3>

									<table class="inventary">
										<tr>
											<td style="width:50%; padding-right:8px;">

												<div class="block-bordered">
													<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
													<div class="center clear">
														<h3>Описание</h3>
														<div class="home-collection-description">
															<p>
																<img src="/@/images/obj/collections/{collection/image}" align="left"  style="margin-bottom:5px;" />
																<xsl:value-of select="collection/info" disable-output-escaping="yes" />
															</p>
														</div>
														<xsl:if test="collection/done > 0">
															
															<h3>Собрано</h3>
															<div class="home-collection-gathered">
																<p class="hint">
																	<img align="left" src="/@/images/obj/collections/{collection/image_reward}" style="margin-bottom:5px;" />
																	<b class="success">Поздравляем, вы собрали коллекцию и получили приз.</b><br clear="all"/><br />
																	<xsl:if test="collection/done &lt; collection/repeats">Теперь, если соберете коллекцию еще раз, вы сможете улучшить характеристики приза.</xsl:if>
																</p>
																<p class="borderdata">
																	Собрано:
																	<xsl:for-each select="collection/stars/element">
																		<xsl:choose>
																			<xsl:when test="position() &lt;= /data/collection/done">
																				<span class="icon icon-star-filled"></span>
																			</xsl:when>
																			<xsl:otherwise>
																				<span class="icon icon-star-empty"></span>
																			</xsl:otherwise>
																		</xsl:choose>
																	</xsl:for-each>
																</p>
															</div>
														</xsl:if>
													</div>
													<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
												</div>

												<xsl:if test="collection/done &lt; collection/repeats">
													<div class="block-bordered">
														<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
														<div class="center clear">
															<h3>Коллекционер Дедушка Йоши</h3>
															<div class="home-collection-description">
																<p>
																	<img src="/@/images/pers/man105_thumb.png" align="left" style="margin-bottom:8px;" />
																	Дедушка Йоши начинал с коллекционирования наручных часов и люто ненавидел переходы на летнее и зимнее время. 
																	К своему 120-летнему юбилею он собрал все коллекции в мире и теперь готов помогать начинающим коллекционерам.
																</p>
																<xsl:choose>
																	<xsl:when test="monya = 1">	
																		<p>
																			Он узнал, что вы заинтересовались этой коллекцией и решил вам помочь. 
																			У него есть недостающие элементы коллекции, но просто так он их вам не отдаст. Он готов сыграть с Вами в «Три Сундучка».
																			Угадаете — получите недостающий элемент, нет — получите старый. Дерзайте!
																			<div align="center"><button class="button" onclick="document.location.href='/home/collection/{collection/id}/thimble/';">
																				<span class="f" ><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																					<div class="c">Играть — <span class="med"><xsl:value-of select="monya_cost" /><i></i></span></div>
																				</span>
																			</button>
																			<p class="hint" style="margin:5px 0 0 0">Чем нужнее вам элемент коллекции, тем дороже сыграть с&#160;Дедушкой Йоши.</p>
																			</div>
																		</p>
																	</xsl:when>
																	<xsl:otherwise>
																		<p>Как только вы соберете половину коллекции, он <b>поможет вам собрать остальное</b>.</p>
																	</xsl:otherwise>
																</xsl:choose>
															</div>
														</div>
														<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
													</div>
												</xsl:if>


											</td>
											<td rowspan="2" style="width:46%; padding:0 2px">
												<div style="width:312px;">
												<dl class="vtabs">
													<dt class="selected active"><div><div>Элементы коллекции<xsl:if test="collection/done &lt; collection/repeats">&#160;(<xsl:value-of select="now" /> из <xsl:value-of select="needed" />)</xsl:if></div></div></dt>
													<dd>
														<div class="object-thumbs">
															<xsl:choose>
																<xsl:when test="collection/done = collection/repeats">
																	<xsl:for-each select="items/element">
																		<div class="object-thumb">
																			<div class="padding">
																				<img src="/@/images/obj/collections/{image}.png" alt="{name}" title="{name}" />
																				<xsl:if test="amount > 1">
																					<div class="count">&#0215;<xsl:value-of select="amount" /></div>
																				</xsl:if>
																				<xsl:if test="/data/collection/show_button = 1"><div class="action"><a href="/home/collection/image/{id}/" rel="lightbox-1" title="{name}"><span>смотреть</span></a></div></xsl:if>
																			</div>
																		</div>
																	</xsl:for-each>
																	<!--<xsl:if test="count(items/element) = 0">-->
																		<div class="empty">Вы полностью собрали коллекцию. Вы молодец!</div>
																	<!--</xsl:if>-->
																</xsl:when>
																<xsl:otherwise>
																	<xsl:for-each select="items/element">
																		<div class="object-thumb">
																			<div class="padding">
																				<xsl:choose>
																					<xsl:when test="amount > 0">
																						<xsl:choose>
																							<xsl:when test="/data/collection/show_button = 1">
																								<a href="/@/images/obj/collections/{image}-picture.jpg" rel="lightbox-1" title="{name}"><img src="/@/images/obj/collections/{image}.png" alt="{name}" title="{name}" /></a>
																								<div class="action"><a href="/@/images/obj/collections/{image}-picture.jpg" rel="lightbox-1" title="{name}"><span>смотреть</span></a></div>
																							</xsl:when>
																							<xsl:otherwise>
																								<img src="/@/images/obj/collections/{image}.png" alt="{name}" title="{name}" />
																							</xsl:otherwise>
																						</xsl:choose>
																						<xsl:if test="amount > 1">
																							<div class="count">&#0215;<xsl:value-of select="amount" /></div>
																						</xsl:if>
																					</xsl:when>
																					<xsl:otherwise>
																						<img src="/@/images/ico/slot-hidden.png" />
																						<xsl:if test="/data/collection/show_button = 1">
																							<div class="action action-disabled"><span>смотреть</span></div>
																						</xsl:if>
																					</xsl:otherwise>
																				</xsl:choose>
																			</div>
																		</div>
																	</xsl:for-each>
																	<xsl:for-each select="items2/element">
																		<div class="object-thumb">
																			<div class="padding">
																				<img src="/@/images/obj/{image}" alt="{name}" title="{name}" />
																				<xsl:if test="amount > 1">
																					<div class="count">&#0215;<xsl:value-of select="amount" /></div>
																				</xsl:if>
																				<!-- <div class="action"><a href="/home/collection/image/{id}/" title="{name}"><span>смотреть</span></a></div> -->
																			</div>
																		</div>
																	</xsl:for-each>
																	<xsl:if test="count(items/element) = 0 and count(items2/element) = 0">
																		<div class="empty">К сожалению, вы только начали собирать коллекцию и еще не успели найти хотя бы один экспонат.</div>
																	</xsl:if>
																</xsl:otherwise>
															</xsl:choose>
														</div>
														<xsl:if test="collection/done &lt; collection/repeats">
															<div class="hint">
																<button class="button" onclick="document.location.href='/home/collection/{collection/id}/make/';">
																	<span class="f" ><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																		<div class="c">Собрать коллекцию</div>
																	</span>
																</button>
															</div>
														</xsl:if>
													</dd>
												</dl>
												</div>
											</td>
										</tr>
									</table>

								</div>
							</div>
						</div>
					</div>
    </xsl:template>
</xsl:stylesheet>