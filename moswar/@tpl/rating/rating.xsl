<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

	<xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/clanlink.xsl" />
    <xsl:include href="common/paginator.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Рейтинг
                </h2></div>
                    <div id="content" class="rating">
                        <table class="buttons">
							<tr>
								<xsl:for-each select="modes/element">
									<xsl:if test="position() &lt;= 4">
										<td>
											<xsl:element name="div">
												<xsl:choose>
													<xsl:when test="name = /data/mode">
														<xsl:attribute name="class">button button-current</xsl:attribute>
													</xsl:when>
													<xsl:otherwise>
														<xsl:attribute name="class">button</xsl:attribute>
													</xsl:otherwise>
												</xsl:choose>
												<a class="f" href="/rating/{name}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c"><xsl:value-of select="title" /></div>
												</a>
											</xsl:element>
										</td>
									</xsl:if>
								</xsl:for-each>
							</tr>
							<tr>
								<xsl:for-each select="modes/element">
									<xsl:if test="position() > 4">
										<td>
											<xsl:if test="name = 'fractions'">
												<xsl:attribute name="colspan">2</xsl:attribute>
											</xsl:if>
											<xsl:element name="div">
												<xsl:choose>
													<xsl:when test="name = /data/mode">
														<xsl:attribute name="class">button button-current</xsl:attribute>
													</xsl:when>
													<xsl:otherwise>
														<xsl:attribute name="class">button</xsl:attribute>
													</xsl:otherwise>
												</xsl:choose>
												<a class="f" href="/rating/{name}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c"><xsl:value-of select="title" /></div>
												</a>
											</xsl:element>
										</td>
									</xsl:if>
								</xsl:for-each>
							</tr>
							<xsl:if test="0">
							<!--<tr>
								<xsl:for-each select="modes/element">
									<xsl:if test="position() &gt; 4">
										<td>
											<xsl:if test="name = 'fractions'">
												<xsl:attribute name="colspan">2</xsl:attribute>
											</xsl:if>
											<xsl:element name="div">
												<xsl:choose>
													<xsl:when test="name = /data/mode">
														<xsl:attribute name="class">button button-current</xsl:attribute>
													</xsl:when>
													<xsl:otherwise>
														<xsl:attribute name="class">button</xsl:attribute>
													</xsl:otherwise>
												</xsl:choose>
												<a class="f" href="/rating/{name}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c"><xsl:value-of select="title" /></div>
												</a>
											</xsl:element>
										</td>
									</xsl:if>
								</xsl:for-each>
							</tr>-->
							</xsl:if>
						</table>

                    <xsl:choose>
                        <xsl:when test="mode = 'fraction'">
                            <xsl:call-template name="rating-fraction" />
                        </xsl:when>
                        <xsl:when test="mode = 'clans'">
                            <xsl:call-template name="rating-clan" />
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:call-template name="rating-player" />
                        </xsl:otherwise>
                    </xsl:choose>

                </div>
            </div>
        </div>
    </xsl:template>

	<xsl:template name="rating-player">
        <form class="search" action="/rating/{mode}/" method="post">
            <div class="block-bordered">
                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                <div class="center clear">
                    <b>Поиск</b>:
                    <input class="name" type="text" name="nickname" />
                    <button class="button" type="submit">
                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                            <div class="c">Найти</div>
                        </span>
                    </button>
                </div>
                <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
            </div>
        </form>

        <div class="block-rounded">
            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
            <h3><xsl:value-of select="window-name" /></h3>
			<div class="rating-filter">
                <select id="fraction" name="fraction">
                    <option value="">Обе стороны</option>
                    <option value="resident/"><xsl:if test="fraction = 'resident'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>Коренные</option>
                    <option value="arrived/"><xsl:if test="fraction = 'arrived'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>Понаехавшие</option>
                </select>&#160;
				<xsl:if test="mode != 'referers'">
					<select id="period" name="period">
						<option value="all/"><xsl:if test="period = 'all'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>Все время</option>
						<option value="day/"><xsl:if test="period = 'day'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>Сегодня</option>
						<option value="week/"><xsl:if test="period = 'week'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>Текущая неделя</option>
						<option value="month/"><xsl:if test="period = 'month'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>Текущий месяц</option>
						<xsl:if test="mode = 'moneygrabbed'">
							<option value="event/"><xsl:if test="period = 'event'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>Конкурс</option>
						</xsl:if>
					</select>&#160;
				</xsl:if>
				<select id="level" name="level">
                    <option value="">Все уровни</option>
                    <option value="level/1/"><xsl:if test="level = 1"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>1</option>
                    <option value="level/2/"><xsl:if test="level = 2"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>2</option>
                    <option value="level/3/"><xsl:if test="level = 3"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>3</option>
                    <option value="level/4/"><xsl:if test="level = 4"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>4</option>
                    <option value="level/5/"><xsl:if test="level = 5"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>5</option>
                    <option value="level/6/"><xsl:if test="level = 6"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>6</option>
                    <option value="level/7/"><xsl:if test="level = 7"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>7</option>
                    <option value="level/8/"><xsl:if test="level = 8"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>8</option>
                    <option value="level/9/"><xsl:if test="level = 9"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>9</option>
                    <option value="level/10/"><xsl:if test="level = 10"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>10</option>
                    <option value="level/11/"><xsl:if test="level = 11"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>11</option>
                    <option value="level/12/"><xsl:if test="level = 12"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>12</option>
                    <option value="level/13/"><xsl:if test="level = 13"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>13</option>
                    <option value="level/14/"><xsl:if test="level = 14"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>14</option>
                    <option value="level/15/"><xsl:if test="level = 15"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>15</option>
                    <option value="level/16/"><xsl:if test="level = 16"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>16</option>
                    <option value="level/17/"><xsl:if test="level = 17"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>17</option>
                </select>&#160;
				<button class="button" type="button" onclick="document.location.href='/rating/{mode}/' + $('#fraction').val() + $('#period').val() + $('#level').val();">
					<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
						<div class="c">Фильтр</div>
					</span>
				</button>
			</div>

            <table class="list">
                <tr>
                    <th>№</th>
                    <th>Имя</th>
                    <th>Девиз</th>
                    <th class="value">
                        <xsl:choose>
                            <xsl:when test="mode = 'moneygrabbed'">Награблено</xsl:when>
                            <xsl:when test="mode = 'moneylost'">Потеряно</xsl:when>
                            <xsl:when test="mode = 'wins'">Побед</xsl:when>
                            <xsl:when test="mode = 'referers'">Учеников</xsl:when>
							<xsl:when test="mode = 'huntkills'">Убийства</xsl:when>
							<xsl:when test="mode = 'huntaward'">Награда</xsl:when>
                        </xsl:choose>
                    </th>
                    <th>&#0160;</th>
                </tr>
                <xsl:for-each select="players/element">
                    <xsl:element name="tr">
						<xsl:choose>
							<xsl:when test="id = /data/player/id">
								<xsl:attribute name="class">my</xsl:attribute>
							</xsl:when>
							<xsl:when test="position &lt;= 3">
								<xsl:attribute name="class">special</xsl:attribute>
							</xsl:when>
						</xsl:choose>
						<xsl:choose>
							<xsl:when test="skip = 1">
								<td colspan="4" class="skip">...</td>
							</xsl:when>
							<xsl:otherwise>
								<td class="num"><xsl:value-of select="position" />.</td>
								<td>
									<xsl:call-template name="playerlink">
										<xsl:with-param name="player" select="current()" />
									</xsl:call-template>
								</td>
								<td>
									<xsl:value-of select="slogan" />
								</td>
								<td class="value">
									<b><xsl:value-of select="format-number(value, '###,###,###,###')" /></b>
								</td>
								<td>
									<xsl:if test="id != /data/player/id">
										<div class="button">
											<a class="f" href="#" onclick="alleyAttack({player});return false;"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
												<div class="c">Напасть</div>
											</a>
										</div>
									</xsl:if>
								</td>
							</xsl:otherwise>
						</xsl:choose>
                    </xsl:element>
                </xsl:for-each>
            </table>
        </div>
        <xsl:call-template name="paginator">
            <xsl:with-param name="pages" select="pages" />
            <xsl:with-param name="page" select="page" />
            <xsl:with-param name="link" select="url" />
        </xsl:call-template>
	</xsl:template>

	<xsl:template name="rating-fraction">
        <div class="block-rounded">
            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
            <h3><xsl:value-of select="window-name" /></h3>
            <table class="list">
                <tr>
                    <th style="text-align:right; width:40%;"><b><i title="Коренной" class="resident"></i>Коренные</b></th>
                    <th style="text-align:center; width:20%;"></th>
                    <th style="text-align:left; width:40%;"><b><i title="Понаехавший" class="arrived"></i>Понаехавшие</b></th>
                </tr>
                <tr>
                    <td align="right"><b><xsl:value-of select="format-number(fractions/resident/members, '###,###,###')" /></b></td>
                    <td align="center">Сторонников</td>
                    <td align="left"><b><xsl:value-of select="format-number(fractions/arrived/members, '###,###,###')" /></b></td>
                </tr>
                <tr>
                    <td align="right"><b><xsl:value-of select="format-number(fractions/resident/wins, '###,###,###,###')" /></b></td>
                    <td align="center">Побед в дуэлях</td>
                    <td align="left"><b><xsl:value-of select="format-number(fractions/arrived/wins, '###,###,###,###')" /></b></td>
                </tr>
                <tr>
                    <td align="right"><b><xsl:value-of select="format-number(fractions/resident/levelfights, '###,###,###')" /></b></td>
                    <td align="center">Побед в боях за руду</td>
                    <td align="left"><b><xsl:value-of select="format-number(fractions/arrived/levelfights, '###,###,###')" /></b></td>
                </tr>
                <tr>
                    <td align="right"><span class="tugriki"><xsl:value-of select="format-number(fractions/resident/moneygrabbed, '###,###,###,###')" /><i></i></span></td>
                    <td align="center">Награблено</td>
                    <td align="left"><span class="tugriki"><xsl:value-of select="format-number(fractions/arrived/moneygrabbed, '###,###,###,###')" /><i></i></span></td>
                </tr>
                <tr>
                    <td align="right">
                        <xsl:choose>
                            <xsl:when test="fraction = 'resident'">
                                <b><xsl:value-of select="fractions/resident/flagtime" /></b>
                            </xsl:when>
                            <xsl:otherwise>
                                <xsl:value-of select="fractions/resident/flagtime" />
                            </xsl:otherwise>
                        </xsl:choose>
                    </td>
                    <td align="center">Флаг</td>
                    <td align="left">
                        <xsl:choose>
                            <xsl:when test="fraction = 'arrived'">
                                <b><xsl:value-of select="fractions/arrived/flagtime" /></b>
                            </xsl:when>
                            <xsl:otherwise>
                                <xsl:value-of select="fractions/arrived/flagtime" />
                            </xsl:otherwise>
                        </xsl:choose>
                    </td>
                </tr>
            </table>
        </div>
	</xsl:template>

	<xsl:template name="rating-clan">
		<form class="search" action="/rating/clans/" method="post">
            <div class="block-bordered">
                <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                <div class="center clear">
                    <b>Поиск</b>:
                    <input class="name" type="text" name="name" />
                    <button class="button" type="submit">
                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                            <div class="c">Найти</div>
                        </span>
                    </button>
                </div>
                <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
            </div>
        </form>

        <div class="block-rounded">
            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
            <h3><xsl:value-of select="window-name" />&#0160;
                <select name="fraction" id="fraction" onchange="document.location.href='/rating/clans/' + $('#fraction').val() + '/';">
                    <option value="">Обе стороны</option>
                    <option value="resident">Коренные</option>
                    <option value="arrived">Понаехавшие</option>
                </select>
            </h3>
            <xsl:choose>
                <xsl:when test="count(clans/element) > 0">
                    <table class="list">
                        <tr>
                            <th>№</th>
                            <th width="33%">Имя</th>
                            <th>Девиз</th>
                            <th>Рейтинг</th>
                        </tr>
                        <xsl:for-each select="clans/element">
                            <xsl:element name="tr">
                                <xsl:if test="position &lt;= 3">
                                    <xsl:attribute name="class">special</xsl:attribute>
                                </xsl:if>
                                <td class="num"><xsl:value-of select="position" />.</td>
                                <td>
                                    <xsl:call-template name="clanlink">
                                        <xsl:with-param name="clan" select="current()" />
                                    </xsl:call-template>
                                </td>
                                <td>
                                    <xsl:value-of select="slogan" />
                                </td>
                                <td style="text-align:right;">
									<xsl:value-of select="format-number(exp, '###,###,###,###')" />
                                </td>
                            </xsl:element>
                        </xsl:for-each>
                    </table>
                </xsl:when>
                <xsl:otherwise>
                    <center><i>Cтолица ночью спит спокойно, про ОПГ ничего не слышно, но это временно...</i></center>
                </xsl:otherwise>
            </xsl:choose>
        </div>

        <xsl:call-template name="paginator">
            <xsl:with-param name="pages" select="pages" />
            <xsl:with-param name="page" select="page" />
            <xsl:with-param name="link" select="concat('/rating/', mode, '/', fraction, '/')" />
        </xsl:call-template>
	</xsl:template>
</xsl:stylesheet>
