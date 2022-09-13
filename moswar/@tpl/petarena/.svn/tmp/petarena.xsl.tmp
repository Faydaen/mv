<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>
	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Дрессировка питомцев</h2>
				</div>
				<div id="content" class="petarena">

					<div class="petarena-training">

						<div class="welcome">
							<div class="block-rounded">
								<i class="tlc"></i>
								<i class="trc"></i>
								<i class="blc"></i>
								<i class="brc"></i>
								<div class="text">Человек питомцу друг — это знают все вокруг! <span style="color:#e8a291; font-size:90%">&#169; Ваня Павлов</span>
								</div>
							</div>
						</div>


						<table class="inventary">
							<tr>
								<td class="dopings-cell" style="width:50%; padding-right:8px;">

									<div class="block-bordered">
										<ins class="t l"><ins></ins></ins>
										<ins class="t r"><ins></ins></ins>
										<div class="center clear">
											<h3>Дрессировка</h3>
											<div class="petarena-training-description">
												<p>Дрессировка питомца позволит сделать его незаменимым помощником в боях с врагом.</p>
												<p>Вы можете завести не более одного питомца каждого вида.</p>
												<p>В случае, если ваш питомец потеряет все жизни в бою — он впадет в кому. В таком случае он <b>потеряет 5% характеристик, но навыки дрессировки не потеряются</b>. Выходить из комы он будет 4 дня, если не применить реанимацию. Поэтому лучше следить за здоровьем любимца.</p>
											</div>

										</div>
										<ins class="b l"><ins></ins></ins>
										<ins class="b r"><ins></ins></ins>
									</div>

								</td>
								<td class="equipment-cell" rowspan="2" style="width:46%; padding:0 2px">
									<div style="width:312px;">
										<dl id="equipment-accordion" class="vtabs">
											<dt class="selected active">
												<div><div>Питомцы</div></div>
											</dt>
											<dd>
												<div class="object-thumbs">
													<xsl:choose>
														<xsl:when test="count(pets/element) > 0">
															<xsl:for-each select="pets/element">
																<div class="object-thumb">
																	<div class="padding">
																		<img src="/@/images/obj/{image}" />
																		<div class="action" onclick="document.location.href='/petarena/train/{id}/';"><span>обучить</span></div>
																	</div>
																</div>
															</xsl:for-each>
															
														</xsl:when>
														<xsl:otherwise>
															<p>У вас пока нет ни одного питомца, но вы можете купить его в <a href="/shop/section/zoo/">Торговом центре</a>.</p>
														</xsl:otherwise>
													</xsl:choose>
												
												</div>
												<div class="hint">
													<input type="checkbox" id="showpetinprofile" onchange="petarenaShowPetInProfile($('#showpetinprofile'));">
														<xsl:if test="showpetinprofile = 1">
															<xsl:attribute name="checked">checked</xsl:attribute>
														</xsl:if>
													</input>
													<label for="showpetinprofile">Я хочу, чтобы моего активного питомца видели остальные игроки</label>
												</div>
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