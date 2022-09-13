<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/item.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
        <div class="column-right-bottombg" align="center">
            <div class="heading clear"><h2>
                <span class="factory"></span>
            </h2></div>
            <div id="content" class="factory">
			
				<div class="factory-mf">

	                <div class="welcome">
	                    <div class="block-rounded">
	                        <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
	                        <div class="text">
                                <xsl:choose>
                                    <xsl:when test="player/level > 5 or player/factory = 1">
										Добро пожаловать в мастерскую. Здесь рождаются самые лучшие вещи и самые искусные инженеры.
                                    </xsl:when>
                                    <xsl:otherwise>
                                        Цех модификаций строго охраняется, и доступ возможен только по пропускам.
                                    </xsl:otherwise>
                                </xsl:choose>
	                        </div>
	                    </div>
						<div class="goback">
						    <span class="arrow">&#9668;</span>
							<a href="/factory/">Выйти из цеха</a>
						</div>
	                </div>
					
					<xsl:if test="player/level > 5 or player/factory = 1">
		                <table class="inventary">
		                    <tr>
		                        <td class="dopings-cell" style="width:50%; padding-right:8px;">

		                            <div class="block-bordered">
		                                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
		                                <div class="center clear">
		                                    <h3>Цех модификаций</h3>
		                                    <div class="factory-mf-about">
		                                        <p>
		                                            Идея этого устройства пришла в седую голову профессора Клянера, когда на нее упал банан. С помощью адронного аппарата Т-800 можно менять кварковую структуру тканей и материалов. Это позволяет улучшать характеристики одежды, предметов и оружия.
		                                            <span class="dashedlink" onclick="$('#factory-nanoptric-description').toggle();">Подробнее</span>
		                                        </p>
		                                        <p id="factory-nanoptric-description" style="display:none;">
		                                            После улучшения предмета, он получит увеличение базового параметра.
		                                            Каждый предмет можно улучшить <b>до 20 раз</b>, поэтому не удивляйтесь, если вы увидите хайлевела в новичковой одежде.
		                                        </p>
		                                    </div>
		                                    <h3>Мастерство не пропьешь</h3>
		                                    <div class="factory-mf-skill">
		                                        <p>Чем чаще вы модифицируете предметы, тем выше растет мастерство.</p>
		                                        <table class="process">
		                                            <tr>
		                                                <td class="label">Навык мф.:</td>
		                                                <td class="progress">
		                                                    <div class="exp">
		                                                        <div class="bar"><div><div class="percent" style="width:{prof/percent}%;"></div></div></div>
		                                                    </div>
		                                                </td>
		                                                <td class="value">
		                                                    <xsl:value-of select="prof/value" />/<xsl:value-of select="prof/nextlevel" />
		                                                </td>
		                                            </tr>
		                                        </table>
		                                        <p style="text-align:center;"><b style="color:#003399;">Звание: <xsl:value-of select="prof/name" /></b></p>
		                                        <p>Вместе с ростом звания увеличиваются шансы на получения улучшенной модификации. В начале карьеры шансы минимальны.</p>

		                                    </div>
		                                </div>
		                                <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
		                            </div>

		                        </td>
		                        <td class="equipment-cell" rowspan="2" style="width:46%; padding:0 2px">
		                            <div style="width:312px;">
			                            <dl id="equipment-accordion" class="vtabs">
			                                <dt class="selected active"><div><div>Инвентарь</div></div></dt>
			                                <dd>
			                                    <div class="object-thumbs">
			                                        <xsl:choose>
			                                            <xsl:when test="count(inventory/element) > 0">
			                                                <xsl:for-each select="inventory/element">
			                                                    <xsl:choose>
			                                                        <xsl:when test="code != ''">
			                                                            <div class="object-thumb">
																			<div class="padding">
				                                                                <!--xsl:element name="img">
				                                                                    <xsl:attribute name="tooltip">1</xsl:attribute>
				                                                                    <xsl:attribute name="src">/@/images/obj/<xsl:value-of select="image" /></xsl:attribute>
				                                                                    <xsl:attribute name="title"><xsl:value-of select="name" />||<xsl:value-of select="info" />|||</xsl:attribute>
				                                                                </xsl:element-->
                                                                                <xsl:call-template name="item">
                                                                                    <xsl:with-param name="item" select="current()" />
                                                                                </xsl:call-template>
				                                                                <!--img src="/@/images/obj/{image}" title="{name}||{info}|||" tooltip="1" /-->
				                                                                <xsl:if test="stackable = 1">
				                                                                    <div class="count">#<xsl:value-of select="durability" /></div>
				                                                                </xsl:if>
                                                                                <xsl:if test="mf > 0">
                                                                                    <div class="mf">М-<xsl:value-of select="mf" /></div>
                                                                                </xsl:if>
				                                                                <div class="action" onclick="document.location.href = '/factory/mf-item/{id}/';"><span>мф-ать</span></div>
																			</div>
			                                                            </div>
			                                                        </xsl:when>
			                                                        <xsl:otherwise>
			                                                            <img src="/@/images/ico/gift.png" />
			                                                        </xsl:otherwise>
			                                                    </xsl:choose>
			                                                </xsl:for-each>
			                                            </xsl:when>
			                                            <xsl:otherwise>

			                                            </xsl:otherwise>
			                                        </xsl:choose>
			                                    </div>
												<div class="hint">
													Модифицировать можно только вещи 5-го и более высокого уровня,
													находящиеся в Вашем инвентаре (не&#160;надетые на&#160;персонажа).
												</div>
			                                </dd>
			                            </dl>
			                        </div>
			                    </td>
			                </tr>
		                </table>
					</xsl:if>
	            </div>
			</div>
        </div>
        </div>
    </xsl:template>

</xsl:stylesheet>