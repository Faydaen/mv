<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
	<div class="column-right-topbg">
	    <div class="column-right-bottombg" align="center">
		<div class="heading clear">
		    <h2>
			<span class="nightclub"></span>
		    </h2>
		</div>
		<div id="content" class="nightclub">
			
		    <div class="welcome">
			<div class="block-rounded">
			    <i class="tlc"></i>
			    <i class="trc"></i>
			    <i class="blc"></i>
			    <i class="brc"></i>
			    <div class="text clear">
					<div style="float:left; width:49%"><b>— Тебе сюда нельзя!<br />Клуб закрыт!</b></div>
					<div style="float:right; width:49%; text-align:left; position:relative;">
						<div style="padding-right:130px;">
							<xsl:choose>
								<xsl:when test="player/level &lt; 2">
									<img src="/@/images/pers/man113.png" style="position:absolute; right:-10px; top:-130px;" />
								</xsl:when>
								<xsl:otherwise>
									<a href="/nightclub/photo/"><img src="/@/images/pers/man113.png" style="position:absolute; right:-10px; top:-130px;" /></a>
								</xsl:otherwise>
							</xsl:choose>
							У входа в клуб стоит Лёлик
							и&#160;щелкает всех позирующих
							<xsl:choose>
								<xsl:when test="player/level &lt; 2">
									<div class="hint">Сфоткаться можно будет <nobr>со 2-го уровня</nobr></div>
								</xsl:when>
								<xsl:otherwise>
									<div style="margin:10px 0 0 0;">
										<div class="button">
											<a class="f" href="/nightclub/photo/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Сфоткаться</div>
											</a>
										</div>
									</div>
								</xsl:otherwise>
							</xsl:choose>
							
						</div>
					</div>
			    </div>
			</div>
		    </div>
			

		</div>
	    </div>
	</div>
    </xsl:template>

</xsl:stylesheet>
