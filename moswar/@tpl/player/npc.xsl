<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/npclink.xsl" />
    <xsl:include href="common/stats.xsl" />
    <xsl:include href="common/item.xsl" />

	<xsl:template name="player" match="/data">
		<h3 class="curves clear"><xsl:call-template name="npclink"><xsl:with-param name="player" select="player" /></xsl:call-template></h3>

        <xsl:if test="count(result) > 0">
		    <xsl:call-template name="error">
				<xsl:with-param name="result" select="result" />
			</xsl:call-template>
		</xsl:if>

        <table class="layout">
            <tr>
                <td class="stats-cell">
                    <dl id="stats-accordion" class="vtabs">
                        <dt class="selected active"><div><div>Характеристики</div></div></dt>
                        <dd>
                            <xsl:call-template name="stats">
                                <xsl:with-param name="player" select="player" />
                            </xsl:call-template>
                            <xsl:if test="profile = 'my'">
                                <center style="padding-top: 5px;"><div class="button" onclick="document.location.href='/trainer/';"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Потренироваться</div></span></div></center>
                            </xsl:if>
                        </dd>
                    </dl>
                </td>
                <td class="slots-cell" align="center">
                    <ul class="slots">
                        <xsl:if test="player/accesslevel = -1">
                            <div class="blocked"></div>
                        </xsl:if>
                        <xsl:if test="player/accesslevel = -2">
                            <div class="frozen"></div>
                        </xsl:if>
                        <li class="slot1">
                            <xsl:call-template name="item">
                                <xsl:with-param name="item" select="/data/equipped/hat" />
                            </xsl:call-template>
                        </li>
                        <li class="slot2">
                            <xsl:call-template name="item">
                                <xsl:with-param name="item" select="/data/equipped/talisman" />
                            </xsl:call-template>
                        </li>
                        <li class="slot3">
                            <xsl:call-template name="item">
                                <xsl:with-param name="item" select="/data/equipped/cloth" />
                            </xsl:call-template>
                        </li>
                        <li class="slot4">
                            <xsl:call-template name="item">
                                <xsl:with-param name="item" select="/data/equipped/weapon" />
                            </xsl:call-template>
                        </li>
                        <li class="slot5">
                            <xsl:call-template name="item">
                                <xsl:with-param name="item" select="/data/equipped/accessory1" />
                            </xsl:call-template>
                        </li>
                        <li class="slot6">
                            <xsl:call-template name="item">
                                <xsl:with-param name="item" select="/data/equipped/tech" />
                            </xsl:call-template>
                        </li>
                        <li class="slot7">
                            <xsl:call-template name="item">
                                <xsl:with-param name="item" select="/data/equipped/shoe" />
                            </xsl:call-template>
                        </li>
                        <li class="slot8">
                            <xsl:call-template name="item">
                                <xsl:with-param name="item" select="/data/equipped/pouch" />
                            </xsl:call-template>
                        </li>
                        <li class="slot9">
                            <xsl:call-template name="item">
                                <xsl:with-param name="item" select="/data/equipped/jewellery" />
                            </xsl:call-template>
                        </li>
                        <li class="slot10">
                            <xsl:call-template name="item">
                                <xsl:with-param name="item" select="/data/equipped/cologne" />
                            </xsl:call-template>
                        </li>
                        <li class="avatar {player/bg}">
                            <xsl:if test="player/dopings != ''">
                                <i class="icon affects-icon" tooltip="1" title="Допинги||{player/dopings}"></i>
                            </xsl:if>
                            <div class="">
                                <xsl:element name="img">
                                    <xsl:attribute name="style">background: transparent url(/@/images/pers/<xsl:value-of select="player/av" />) repeat scroll 0% 0%; height: 200px; width: 140px;</xsl:attribute>
                                    <xsl:choose>
                                        <xsl:when test="player/status = 'offline'">
                                            <xsl:attribute name="src">/@/images/pers/<xsl:value-of select="player/avatar_without_ext" />_eyes_closed.gif</xsl:attribute>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:attribute name="src">/@/images/pers/<xsl:value-of select="player/avatar_without_ext" />_eyes.gif</xsl:attribute>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </xsl:element>
                            </div>
                        </li>
                    </ul>
                </td>
                <td class="say-cell">
                    <dl id="statistics-accordion" class="vtabs">
                        <dt class="selected active"><div><div>Статистика</div></div></dt>
                        <dd>
                            <div class="pers-statistics">
                                <div class="bars">
                                    <div align="center">
                                        <div class="life" title="Драться можно только при не менее 25% жизней">
                                            Жизни: <xsl:value-of select="player/hp" />/<xsl:value-of select="player/maxhp" />
                                            <div class="bar" align="center"><div><div class="percent" style="width:{player/procenthp}%;"></div></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </dd>
                    </dl>
                </td>
            </tr>
        </table>

        <xsl:if test="player/slogan != ''">
            <div class="pers-slogan">
                <div class="block-bordered">
                    <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                    <div class="center clear">
                        <label><span>девиз</span></label>
                        <h3><xsl:value-of select="player/slogan" disable-output-escaping="yes" /></h3>
                    </div>
                    <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                </div>
            </div>
        </xsl:if>

        <xsl:if test="player/about != '' or player/name != '' or player/site != '' or player/city != '' or player/hobby != '' or player/photo">
            <div class="pers-text">
                <div class="block-rounded clear">
                    <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
					<xsl:if test="player/photo">
						<div class="pers-photo-thumb">
							<a href="/photos/{player/id}/{player/photo/id}/"><img src="{player/photo/thumb_src}" /></a><br />
							<a href="/photos/{player/id}/">Фотки</a> (<xsl:value-of select="player/photo/amount" />)
						</div>
					</xsl:if>
                    <xsl:if test="player/name != ''">
                        <b>Имя: </b> <xsl:value-of select="player/name" /><br />
                    </xsl:if>
                    <xsl:if test="player/sex != ''">
                        <b>Пол: </b> <xsl:choose>
                            <xsl:when test="player/sex = 'male'">Мужской</xsl:when>
                            <xsl:when test="player/sex = 'female'">Женский</xsl:when>
                            </xsl:choose><br />
                    </xsl:if>
                    <xsl:if test="player/city != ''">
                        <b>Город: </b> <xsl:value-of select="player/city" /><br />
                    </xsl:if>
                    <xsl:if test="player/site != ''">
                        <b>Сайт: </b> <xsl:value-of select="player/site" /><br />
                    </xsl:if>
                    <xsl:if test="player/hobby != ''">
                        <b>Увлечения и хобби: </b> <xsl:value-of select="player/hobby" /><br />
                    </xsl:if>
                    <xsl:if test="player/about != ''">
                        <xsl:value-of select="player/about" disable-output-escaping="yes" />
                    </xsl:if>
                </div>
            </div>
        </xsl:if>
	</xsl:template>

    <xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">

				<div class="heading clear"><h2>
					<span class="pers"></span>
				</h2></div>
				<div id="content" class="pers enemy">
					<xsl:choose>
						<xsl:when test="result = 0 and block = 1">
							<xsl:call-template name="error">
								<xsl:with-param name="error" select="error" />
							</xsl:call-template>
						</xsl:when>
						<xsl:otherwise>
							<xsl:call-template name="player" />
						</xsl:otherwise>
					</xsl:choose>
				</div>
			</div>
		</div>
    </xsl:template>

</xsl:stylesheet>