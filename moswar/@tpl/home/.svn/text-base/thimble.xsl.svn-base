<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>Сундучки</h2></div>
                <div id="content" class="thimble thimble-chest clear">

                    <div class="welcome">
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <img class="avatar-back-5" src="/@/images/pers/man105.png" />
                            <div class="say">
                                — Выбирай поскорей,<br />
								Не задерживай добрых<br />
								И мудрых людей! 
                            </div>
                        </div>
                    </div>

					<xsl:if test="finished = 1">
						<xsl:choose>
							<xsl:when test="result = 0">
								<div align="center" class="report"><p>Вы выбрали <b><xsl:value-of select="item/name" /></b>, но этот элемент уже был у вас.</p></div>
							</xsl:when>
							<xsl:when test="result = 1">
								<div align="center" class="report"><p class="success">Браво! Вы выбрали новый элемент коллекции - <b><xsl:value-of select="item/name" /></b>.</p></div>
							</xsl:when>
						</xsl:choose>
					</xsl:if>

                    <div class="thimble-choose">
                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">

								<div style="padding:5px;">
									<p style="text-align:left;">
										В трех сундучках спрятаны три элемента коллекции и как минимум одного из них не хватает в Вашей коллекции.
										Выберите один из сундучков.
									</p>
								</div>

								<div align="center">

									<p class="thimbles" id="thimble-chest-thimbles">
										<xsl:for-each select="naperstkidata/d/element">
											<xsl:choose>
												<xsl:when test="current() = '0' and /data/finished = 1">
													<i id="thimble{position() - 1}" class="icon thimble-closed-active">
														<xsl:choose>
															<xsl:when test="position() = 1">
																<img src="/@/images/obj/collections/{/data/items/element[1]/image}.png" style="display:none;" />
															</xsl:when>
															<xsl:when test="position() = 2">
																<img src="/@/images/obj/collections/{/data/items/element[2]/image}.png" style="display:none;" />
															</xsl:when>
															<xsl:when test="position() = 3">
																<img src="/@/images/obj/collections/{/data/items/element[3]/image}.png" style="display:none;" />
															</xsl:when>
														</xsl:choose>
													</i>
												</xsl:when>
												<xsl:when test="current() = '0'">
													<i id="thimble{position() - 1}" class="icon thimble-closed-active" onclick="homeThimbleGuess({/data/collection/id}, {position() - 1});"></i>
												</xsl:when>
												<xsl:when test="current() = '1'"><i id="thimble{position() - 1}" class="icon thimble-closed"></i></xsl:when>
												<xsl:when test="current() = '2'">
													<i class="icon thimble-item thimble-item-selected"><img src="/@/images/obj/collections/{/data/item/image}.png" /></i>
													<!-- <i id="thimble{position() - 1}" class="icon thimble-guessed"></i> -->
												</xsl:when>
												<xsl:when test="current() = '3'">
													<i class="icon thimble-item thimble-item-selected"><img src="/@/images/obj/collections/{/data/item/image}.png" /></i>
													<!-- <i id="thimble{position() - 1}" class="icon thimble-empty"></i> -->
												</xsl:when>
											</xsl:choose>
										</xsl:for-each>
									</p>
                                    <br />
									<xsl:if test="finished = 1 and full = 0">
										<script type="text/javascript">
											function ShowOtherChests(){
												$("#thimble-chest-thimbles img").show();
												$("#thimble-chest-thimbles i.icon").addClass("thimble-item");
												$("#thimble-chest-thimbles i.icon").removeClass("thimble-closed-active");
											}
										</script>
										<p><span class="dashedlink" onclick="ShowOtherChests()">Показать, что было в других сундучках</span></p>
									</xsl:if>
									
                                    <div class="hint">
                                        <p>
                                            <xsl:if test="finished = 1 and full = 0">
                                                <button class="button" onclick="document.location.href='/home/collection/{collection/id}/thimble/';">
                                                    <span class="f" ><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Попробовать еще раз — <span class="med"><xsl:value-of select="monya_cost" /><i></i></span></div>
                                                    </span>
                                                </button>
                                                &#0160;
                                            </xsl:if>
                                            <button class="button" onclick="document.location.href='/home/collection/{collection/id}/';">
                                                <span class="f" ><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                    <div class="c">Вернуться</div>
                                                </span>
                                            </button>
                                        </p>
                                    </div>

								</div>

                            </div>
							<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>