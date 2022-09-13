<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Нефтепровод
                </h2></div>
                <div id="content" class="pipeline">
					<xsl:choose>
						<xsl:when test="lowlevel = 1">
							<xsl:attribute name="class">pipeline pipeline-unavilable</xsl:attribute>
						</xsl:when>
						<xsl:when test="/data/ventel = 17">
							<xsl:attribute name="class">pipeline pipeline-finished</xsl:attribute>
						</xsl:when>
						<xsl:otherwise>
							<xsl:attribute name="class">pipeline</xsl:attribute>
						</xsl:otherwise>
					</xsl:choose>
					
                    <div class="welcome">
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="text">
								<xsl:choose>
									<xsl:when test="lowlevel = 1">
										<b>Вы еще не готовы сражаться за трубы и вентили.</b><br />
										Приходите, когда достигните 10 уровня.
									</xsl:when>
									<xsl:otherwise>
										Где-то в области добывают нефть, которая по трубам течёт в столицу. Течёт-течёт, но не дотекает.
										А все потому что у каждого вентиля кормится свой взяточник. <b>Собери всю свою богатырскую силу и отбей присосавшихся дармоедов.</b>
									</xsl:otherwise>
								</xsl:choose>
                                
                            </div>
                        </div>
                    </div>
                    <div class="pipeline-scroll-place">
                        <div id="pipeline-scroll" class="pipeline-scroll">
                            <div class="pipes"><div></div></div>

                            <xsl:if test="lowlevel = 0">
								 <xsl:for-each select="counter/element">
	                                 <xsl:choose>
	                                     <xsl:when test="position() &lt; number(/data/ventel)">
	                                         <i class="icon-ok-tick pulp{position()}"></i>
	                                     </xsl:when>
	                                     <xsl:when test="position() = /data/ventel">
	                                        <div class="enemy-place pulp{position()}">
	                                            <div class="enemy">
	                                                <img class="avatar" id="ventel-avatar" src="/@/images/pers/man109_thumb.png" />
	                                                <div class="timeleft" timer="{/data/timeleft2}"><xsl:value-of select="/data/timeleft" /></div>
	                                                <div class="action">
	                                                    <xsl:call-template name="attack-buttons">
	                                                        <xsl:with-param name="honey" select="/data/nowprice" />
	                                                    </xsl:call-template>
	                                                </div>
	                                                <span class="tail"></span>
	                                            </div>
	                                        </div>
	                                     </xsl:when>
	                                     <xsl:otherwise>
	                                         <i class="icon-locked pulp{position()}"></i>
	                                     </xsl:otherwise>
	                                 </xsl:choose>
	                             </xsl:for-each>

	                            <div class="enemy-place pulp16">
	                                <div class="enemy">
	                                    <img class="avatar" src="/@/images/pers/man110_thumb.png">
                                            <xsl:if test="/data/ventel = 16"><xsl:attribute name="id">ventel-avatar</xsl:attribute></xsl:if>
                                        </img>
	                                    <xsl:if test="/data/ventel = 16">
	                                        <div class="timeleft" timer="{/data/timeleft2}"><xsl:value-of select="/data/timeleft" /></div>
	                                    </xsl:if>
	                                    <div class="action">
	                                        <xsl:if test="/data/ventel = 16">
	                                            <xsl:call-template name="attack-buttons">
	                                                <xsl:with-param name="honey" select="/data/nowprice" />
	                                            </xsl:call-template>
	                                        </xsl:if>
	                                    </div>
	                                    <div style="margin:0 0 3px 0;"><b>Миша Двапроцента</b></div>
                                        <small>Всего 2% и элемент коллекции - ваш!</small>
	                                    <span class="tail"></span>
	                                </div>
	                            </div>
								<i class="icon-locked pulp16"></i>
							</xsl:if>

                        </div>
                        <i class="arrow-left-circle" id="pipeline-arrow-left"></i>
                        <i class="arrow-right-circle" id="pipeline-arrow-right"></i>
                        <xsl:if test="/data/ventel &lt; 17">
                            <div class="timeleft" tooltip="1" title="Успеть до получночи||Присосавшихся взяточников нужно успеть поймать до полуночи! Ведь на их место придут другие." timer="{timer2}"><xsl:value-of select="timer" /></div>
                        </xsl:if>
						
						<xsl:if test="/data/ventel = 17">
							<div class="overtip" style="top:50%; left:50%; margin:-60px 0 0 -150px; display:block;">
								<div class="object">
									<h2>Миссия выполнена</h2>
									<div class="data">
										<i class="icon-ok-tick"></i>
										<b><span style="color:green; font-size:16px;">Браво!</span><br />
										Сегодня ты избавил трубы от утечек.</b>
										Страна гордится тобой. 
										Однако завтра новый тяжелый день.
										<i class="thumb">
											<img src="/@/images/pers/man114_thumb.png" />
										</i>
									</div>
								</div>
							</div>
						</xsl:if>
						
				        <div class="overtip" style="top:150px; left:300px; DISPLAY:NONE;" id="ventel-overtip">
				            <div class="object">
				                <h2>Вентиль [<xsl:value-of select="ventel" />]</h2>
				                <div class="data">
				                    <xsl:choose>
                                        <xsl:when test="/data/ventel = 16">
                                            На нефтевышке сидит <b>Миша Двапроцента</b> и никого к трубе не подпускает.
                                        </xsl:when>
                                        <xsl:otherwise>
                                            К трубе присосался <b>Взяточник [<xsl:value-of select="npclevel" />]</b>.
                                            Попробуйте отбить вентиль из его мохнатых лап.
                                        </xsl:otherwise>
                                    </xsl:choose>
				                    <div class="objects-data">
				                        <h4>Награда за победу:</h4>
                                        <xsl:if test="neft > 0">
											<span class="neft"><xsl:value-of select="neft" /><i></i></span>
										</xsl:if>
										<xsl:if test="ore > 0">
                                            <span class="ruda"><xsl:value-of select="ore" /><i></i></span>
										</xsl:if>
										<xsl:if test="money > 0">
                                            <span class="tugriki"><xsl:value-of select="money" /><i></i></span>
										</xsl:if>
                                        <xsl:if test="/data/ventel = 16">
                                            <br />элемент нефте-коллекции
                                        </xsl:if>
				                        <!--div class="objects">
				                            <span class="object-thumb">
				                                <div class="padding">
				                                    <img src="/@/images/obj/drugs1.png" />
				                                    <div class="count">x2</div>
				                                </div>
				                            </span>
				                            <span class="object-thumb">
				                                <div class="padding">
				                                    <img src="/@/images/obj/axe.png" />
				                                    <div class="count">x2</div>
				                                </div>
				                            </span>
				                        </div-->
				                    </div>
				                    <i class="thumb">
                                        <xsl:choose>
                                            <xsl:when test="/data/ventel = 16"><img src="/@/images/pers/man110_thumb.png" /></xsl:when>
                                            <xsl:otherwise><img src="/@/images/pers/man109_thumb.png" /></xsl:otherwise>
                                        </xsl:choose>
				                    </i>
				                </div>
				            </div>
				        </div>

						
                    </div>
                    <script type="text/javascript">
                        neftPrepare();
						area = "neft";
                    </script>
				
                </div>
            </div>
        </div>

    </xsl:template>

    <xsl:template name="attack-buttons">
        <xsl:param name="honey" />
        <xsl:if test="/data/timeleft2 > 0">
            <button class="button attack-now" type="button" onclick="neftAttack(true)" id="neft-attack-now">
                <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                    <div class="c">Атаковать<br />сразу - <span class="med"><xsl:value-of select="$honey" /><i></i></span></div>
                </span>
            </button>
        </xsl:if>
        <button class="button" type="button" onclick="neftAttack(false)">
            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                <div class="c">Атаковать</div>
            </span>
        </button>
    </xsl:template>

</xsl:stylesheet>