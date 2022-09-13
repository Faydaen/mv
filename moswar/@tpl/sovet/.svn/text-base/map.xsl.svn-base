<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="sovet/enemyname.xsl" />
    <xsl:include href="sovet/menu1.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Карта города
                </h2></div>
                <div id="content" class="council">

                    <xsl:call-template name="menu1">
                        <xsl:with-param name="page" select="'map'" />
                        <xsl:with-param name="council" select="council" />
                    </xsl:call-template>

                    <div align="center" class="council-citymap">
						<div class="council-citymap-place">
					
							<div class="description1">
								Контроль над территориями — вот, что важнее славы и денег.
								Пора согнать взяточников, рейдеров и жадных риэлторов, оккупировавших  столицу.
							</div>
							<div class="description2">
								Не забывайте <a href="/alley/#patrol">патрулировать свои территории</a>.
							</div>
	                        <map name="citymap-coordinates">
	                            <xsl:for-each select="counter/element">
	                                <area tooltip="1" href="#" onmouseover="citymapMouseover({current()})" onmouseout="citymapMouseout({current()})" shape="polygon">
	                                    <xsl:attribute name="title">
	                                        <xsl:value-of select="/data/metro/element[number(current())]/name" />||<xsl:value-of select="/data/metro/element[number(current())]/info" />|||Принадлежит: <xsl:call-template name="enemy-name">
	                                            <xsl:with-param name="enemy" select="/data/metro/element[number(current())]/fraction" /><xsl:with-param name="form" select="3" /></xsl:call-template>|
	                                        <xsl:if test="/data/day &lt; 6 or /data/hour &lt; 1">
	                                            <xsl:if test="/data/astation = current()">Атакован: Понаехавшие|</xsl:if>
	                                            <xsl:if test="/data/rstation = current()">Атакован: Коренные|</xsl:if>
	                                        </xsl:if>
	                                        <xsl:if test="/data/metro/element[number(current())]/bonus != ''">
												Бонусы (в патруле): <xsl:value-of select="/data/metro/element[number(current())]/bonus" />|
											</xsl:if>
	                                    </xsl:attribute>
	                                    <xsl:attribute name="coords">
	                                        <xsl:call-template name="coords"><xsl:with-param name="coord" select="current()" /></xsl:call-template>
	                                    </xsl:attribute>
	                                </area>
	                            </xsl:for-each>
	                        </map>

	                        <div class="icon" id="citymap">
	                            <img border="0" style="position:absolute; z-index:11; left:0; top:0;" src="/@/images/loc/citymap/citymap.png" width="530" height="480" usemap="#citymap-coordinates" />
	                            <xsl:for-each select="counter/element">
	                                <div id="citymap-land-{current()}">
	                                    <xsl:attribute name="class">
	                                        <xsl:choose>
	                                            <xsl:when test="/data/astation = current() and (/data/day &lt; 6 or /data/hour &lt; 1)">arrived-color-attacked</xsl:when>
	                                            <xsl:when test="/data/rstation = current() and (/data/day &lt; 6 or /data/hour &lt; 1)">resident-color-attacked</xsl:when>
	                                            <xsl:otherwise><xsl:value-of select="/data/metro/element[number(current())]/fraction" />-color</xsl:otherwise>
	                                        </xsl:choose>
	                                    </xsl:attribute>
	                                </div>
	                            </xsl:for-each>
	                        </div>
						
						</div>
						
						<div class="block-rounded council-differentiation">
							<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
							<table class="avatars">
								<tr>
									<xsl:for-each select="stations/stats/element">
                                        <td class="{fraction}-cell">
                                            <i class="icon">
                                                <img class="avatar">
                                                    <xsl:attribute name="src">/@/images/pers/<xsl:call-template name="enemy-name">
                                                            <xsl:with-param name="enemy" select="fraction" />
                                                            <xsl:with-param name="form" select="4" />
                                                        </xsl:call-template>_thumb.png</xsl:attribute>
                                                </img>
                                                <span class="num"><xsl:value-of select="amount" /></span>
                                            </i>
                                            <h3><xsl:call-template name="enemy-name">
                                                    <xsl:with-param name="enemy" select="fraction" />
                                                    <xsl:with-param name="form" select="3" />
                                                </xsl:call-template></h3>
                                        </td>
                                    </xsl:for-each>
								</tr>
							</table>
						</div>

                        <xsl:if test="day = 2">
                            <a name="stationschoose"></a>
                            <div class="block-bordered block-bordered-attention">
                                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                                <div class="center clear">
                                    <div style="float:left; width:47%; text-align:left;">
                                        <h3 style="color:red;">Сегодня выбор района</h3>
                                        <form class="council-stationchoose" method="post" action="/sovet/vote-station/">
                                            <input type="hidden" name="player" value="{player/id}" />
                                            <p>Сегодня вторник, и вам предстоит проголосовать, какой район следует атаковать.</p>

                                            <xsl:choose>
												<xsl:when test="areavote = 0">
													<p class="holders">Голосовать за район можно раз в час. В следующий раз вы сможете проголосовать в <xsl:value-of select="areavote_willbe_at" /></p>
												</xsl:when>
                                                <xsl:when test="player/level > 1">
                                                    <table class="forms">
                                                        <tr>
                                                            <td class="label">Район</td>
                                                            <td class="input">
                                                                <select name="station">
                                                                    <option>-выберите район-</option>
                                                                    <xsl:for-each select="stations/votes/element">
                                                                        <option value="{id}"><xsl:value-of select="name" /></option>
                                                                    </xsl:for-each>
                                                                </select>
                                                                <div class="hint">Смотрите карту города</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">Ратный взнос</td>
                                                            <td class="input">
                                                                <span class="tugriki"><input type="text" name="money" size="6" maxlength="9" /><i></i></span>
                                                                <div class="hint">минимум 100 монет (50% от собранных монет пойдет в казну Совета)</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label"></td>
                                                            <td class="input">
                                                                <button class="button" type="submit">
                                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                        <div class="c">
                                                                            Голосовать
                                                                        </div>
                                                                    </span>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    <p class="holders">Участвовать в голосовании можно со 2-го уровня</p>
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </form>
                                    </div>
                                    <div style="float:right; width:49%; text-align:left;">
                                        <h3>Лидирующие районы</h3>
                                        <div class="council-stationchoose">

                                            <table class="list">
                                                <tr>
                                                    <th class="num">№</th>
                                                    <th>Район</th>
                                                    <th class="value">Взносы</th>
                                                </tr>
                                                <xsl:choose>
                                                    <xsl:when test="count(stations/leaders/element) > 0">
                                                        <xsl:for-each select="stations/leaders/element">
                                                            <tr>
                                                                <td class="num"><xsl:value-of select="position()" /></td>
                                                                <td class="name"><xsl:value-of select="name" /></td>
                                                                <td class="value"><xsl:value-of select="format-number(votes, '###,###,###')" /></td>
                                                            </tr>
                                                        </xsl:for-each>
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        <tr>
                                                            <td colspan="3" style="text-align:center;">Пока предложений нет.</td>
                                                        </tr>
                                                    </xsl:otherwise>
                                                </xsl:choose>

                                            </table>

                                            <p class="borderdata">
                                                Всего взносов: <span class="tugriki"><xsl:value-of select="format-number(stations/total, '###,###,###')" /><i></i></span>
                                            </p>

                                            <p class="hint">Сторонники нуждаются в твоем взносе! Собрав достаточно средств, совет может
                                            активировать различные бонусы для всей Вашей стороны. Это усиление поможет Вам победить.</p>
                                        </div>
                                    </div>
                                </div>
                                <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                            </div>
                        </xsl:if>

                    </div>

                </div>
            </div>

        </div>
    </xsl:template>

    <xsl:template name="coords">
        <xsl:param name="coord" />

        <xsl:choose>
            <xsl:when test="$coord = 1">216, 242, 208, 220, 223, 187, 259, 176, 277, 183, 289, 204, 303, 215, 290, 225, 278, 259, 266, 252, 243, 259, 233, 243</xsl:when>
            <xsl:when test="$coord = 2">248, 177, 223, 187, 209, 217, 218, 243, 202, 243, 190, 232, 188, 208, 175, 199, 155, 199, 151, 170, 164, 140, 193, 117, 217, 115, 233, 120, 246, 100, 280, 90, 284, 102, 262, 116, 245, 145, 242, 161</xsl:when>
            <xsl:when test="$coord = 3">273, 180, 249, 178, 242, 155, 246, 141, 261, 115, 281, 106, 315, 129, 327, 127, 339, 119, 349, 121, 343, 142, 363, 180, 374, 180, 386, 194, 360, 202, 345, 219, 304, 218, 293, 208</xsl:when>
            <xsl:when test="$coord = 4">388, 284, 346, 322, 277, 264, 278, 251, 292, 221, 305, 215, 346, 217, 361, 200, 386, 193, 394, 213, 407, 229, 394, 254</xsl:when>
            <xsl:when test="$coord = 5">225, 364, 204, 361, 186, 349, 184, 335, 179, 328, 189, 309, 207, 299, 224, 305, 237, 293, 238, 265, 257, 254, 272, 255, 346, 321, 336, 342, 291, 370, 246, 378</xsl:when>
            <xsl:when test="$coord = 6">156, 281, 140, 266, 142, 216, 158, 199, 179, 200, 190, 211, 190, 233, 203, 241, 225, 241, 238, 254, 237, 294, 226, 303, 209, 298, 190, 307, 180, 329, 168, 327, 158, 306</xsl:when>
            <xsl:when test="$coord = 7">167, 88, 148, 61, 156, 50, 197, 45, 224, 29, 236, 29, 247, 41, 246, 53, 267, 68, 285, 74, 290, 84, 283, 93, 247, 100, 236, 119, 218, 116, 212, 100, 185, 84</xsl:when>
            <xsl:when test="$coord = 8">360, 106, 360, 119, 352, 128, 342, 119, 331, 127, 316, 129, 284, 108, 283, 94, 289, 81, 286, 75, 266, 68, 247, 54, 247, 40, 236, 28, 241, 24, 263, 20, 301, 32, 325, 39, 362, 65, 377, 88</xsl:when>
            <xsl:when test="$coord = 9">436, 190, 417, 192, 386, 188, 375, 180, 362, 179, 342, 142, 360, 116, 361, 103, 377, 87, 385, 99, 406, 111, 440, 155, 457, 189</xsl:when>
            <xsl:when test="$coord = 10">442, 313, 429, 290, 410, 278, 391, 278, 394, 255, 407, 229, 386, 193, 389, 188, 423, 190, 457, 188, 479, 219, 478, 283, 457, 320</xsl:when>
            <xsl:when test="$coord = 11">361, 400, 335, 365, 347, 326, 391, 277, 411, 278, 430, 290, 445, 315, 458, 323, 422, 369, 382, 419</xsl:when>
            <xsl:when test="$coord = 12">222, 436, 233, 434, 228, 421, 245, 408, 244, 398, 235, 390, 241, 374, 289, 373, 335, 342, 337, 366, 369, 427, 320, 447, 281, 448, 253, 457, 221, 450</xsl:when>
            <xsl:when test="$coord = 13">115, 363, 122, 351, 160, 346, 170, 327, 181, 328, 190, 352, 208, 363, 227, 363, 243, 373, 236, 389, 244, 398, 244, 409, 230, 420, 234, 433, 225, 434, 211, 445, 152, 429, 108, 383, 94, 356, 107, 352</xsl:when>
            <xsl:when test="$coord = 14">94, 261, 111, 249, 122, 250, 136, 242, 144, 271, 157, 281, 159, 309, 170, 327, 160, 346, 122, 351, 116, 362, 106, 353, 91, 356, 78, 329, 71, 323, 58, 259, 72, 250</xsl:when>
            <xsl:when test="$coord = 15">104, 162, 123, 151, 151, 172, 158, 202, 144, 217, 138, 244, 122, 250, 112, 250, 95, 260, 73, 250, 59, 247, 55, 210, 63, 172, 78, 141, 90, 140</xsl:when>
            <xsl:when test="$coord = 16">85, 135, 65, 108, 63, 88, 82, 77, 108, 91, 150, 62, 167, 86, 187, 84, 213, 99, 221, 115, 196, 117, 165, 141, 153, 173, 126, 149, 103, 163</xsl:when>
        </xsl:choose>
    </xsl:template>

</xsl:stylesheet>