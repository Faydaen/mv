<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>
	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear"><h2>Ваш оборотень</h2></div>
				<div id="content" class="police">

					<div class="police-werewolf-view">
						<h3 class="curves clear">
							<i class="npc-werewolf" title="Оборотень"></i>Оборотень в погонах [<xsl:value-of select="werewolf/level" />]
						</h3>
						<table align="center" style="width:447px;">
							<tr>
								<td colspan="3">
									<div class="description">
										<div class="block-rounded">
											<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
											<b>Оборотень вырвался на свободу!</b> Теперь вы можете приступать к нападениям.
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td></td>
								<td class="police-werewolf-lifes">
									<div class="padding" align="center">
										<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
										<div class="life">
											Жизни: <span rel="hp"><xsl:value-of select="werewolf/maxhp" />/<xsl:value-of select="werewolf/maxhp" /></span>
											<div class="bar"><div><div class="percent" style="width:100%;"></div></div></div>
										</div>
									</div>
								</td>
								<td></td>
							</tr>
							<tr>
								<td align="right" style="width:50%">
									<div class="block-rounded" style="background-color:#f7b142; width:150px; height:194px;">
										<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
										<ul class="stats">
											<li class="stat odd" rel="health">
												<div class="label"><b>Здоровье</b><span class="num"><xsl:value-of select="werewolf/health" /></span></div>
												<div class="bar"><div><div class="percent" style="width:{werewolf/healthprocent}%;"></div></div></div>
											</li>
											<li class="stat" rel="strength">
												<div class="label"><b>Сила</b><span class="num"><xsl:value-of select="werewolf/strength" /></span></div>
												<div class="bar"><div><div class="percent" style="width:{werewolf/strengthprocent}%;"></div></div></div>
											</li>
											<li class="stat odd" rel="dexterity">
												<div class="label"><b>Ловкость</b><span class="num"><xsl:value-of select="werewolf/dexterity" /></span></div>
												<div class="bar"><div><div class="percent" style="width:{werewolf/dexterityprocent}%;"></div></div></div>
											</li>
											<li class="stat" rel="resistance">
												<div class="label"><b>Выносливость</b><span class="num"><xsl:value-of select="werewolf/resistance" /></span></div>
												<div class="bar"><div><div class="percent" style="width:{werewolf/resistanceprocent}%;"></div></div></div>
											</li>
											<li class="stat odd" rel="intuition">
												<div class="label"><b>Хитрость</b><span class="num"><xsl:value-of select="werewolf/intuition" /></span></div>
												<div class="bar"><div><div class="percent" style="width:{werewolf/intuitionprocent}%;"></div></div></div>
											</li>
											<li class="stat" rel="attention">
												<div class="label"><b>Внимательность</b><span class="num"><xsl:value-of select="werewolf/attention" /></span></div>
												<div class="bar"><div><div class="percent" style="width:{werewolf/attentionprocent}%;"></div></div></div>
											</li>
											<li class="stat odd" rel="charism">
												<div class="label"><b>Харизма</b><span class="num"><xsl:value-of select="werewolf/charism" /></span></div>
												<div class="bar"><div><div class="percent" style="width:{werewolf/charismprocent}%;"></div></div></div>
											</li>
										</ul>
									</div>
								</td>
								<td style="width:141px; padding:0 3px;">
									<div class="avatar-back-6" id="avatar-back">
										<img style="background: url(/@/images/pers/npc2.png);" src="/@/images/pers/npc2_eyes.gif" />
										<div class="slot-pet"><img src="/@/images/obj/pet3.png" /></div>
										<span class="time" timer="{werewolf/timer}"><xsl:value-of select="werewolf/timer2" /></span>
									</div>

								</td>
								<td align="left" style="width:50%">
									<div class="block-rounded" style="background-color:#f7b142; width:150px; height:194px;">
										<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
										<ul class="stats">
											<li class="stat odd" rel="ratingaccur">
												<div class="label"><b>Рейтинг точности</b><span class="num"><xsl:value-of select="werewolf/ratingaccur" /></span></div>
												<div class="bar"><div><div class="percent" style="width:{werewolf/ratingaccurprocent}%;"></div></div></div>
											</li>
											<li class="stat" rel="ratingdamage">
												<div class="label"><b>Рейтинг урона</b><span class="num"><xsl:value-of select="werewolf/ratingdamage" /></span></div>
												<div class="bar"><div><div class="percent" style="width:{werewolf/ratingdamageprocent}%;"></div></div></div>
											</li>
											<li class="stat odd" rel="ratingcrit">
												<div class="label"><b>Рейтинг крит. ударов</b><span class="num"><xsl:value-of select="werewolf/ratingcrit" /></span></div>
												<div class="bar"><div><div class="percent" style="width:{werewolf/ratingcritprocent}%;"></div></div></div>
											</li>
											<li class="stat" rel="ratingdodge">
												<div class="label"><b>Рейтинг уворота</b><span class="num"><xsl:value-of select="werewolf/ratingdodge" /></span></div>
												<div class="bar"><div><div class="percent" style="width:{werewolf/ratingdodgeprocent}%;"></div></div></div>
											</li>
											<li class="stat odd" rel="ratingresist">
												<div class="label"><b>Рейтинг защиты</b><span class="num"><xsl:value-of select="werewolf/ratingresist" /></span></div>
												<div class="bar"><div><div class="percent" style="width:{werewolf/ratingresistprocent}%;"></div></div></div>
											</li>
											<li class="stat" rel="ratinganticrit">
												<div class="label"><b>Рейтинг защиты<br />от крит. ударов</b><span class="num"><xsl:value-of select="werewolf/ratinganticrit" /></span></div>
												<div class="bar"><div><div class="percent" style="width:{werewolf/ratinganticritprocent}%;"></div></div></div>
											</li>
										</ul>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<p class="borderdata">
										Сила оборотня:
										<xsl:choose>
											<xsl:when test="stars = 0">
												<span class="icon icon-star-empty"></span>
												<span class="icon icon-star-empty"></span>
												<span class="icon icon-star-empty"></span>
												<span class="icon icon-star-empty"></span>
												<span class="icon icon-star-empty"></span>
											</xsl:when>
											<xsl:when test="stars = 1">
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-empty"></span>
												<span class="icon icon-star-empty"></span>
												<span class="icon icon-star-empty"></span>
												<span class="icon icon-star-empty"></span>
											</xsl:when>
											<xsl:when test="stars = 2">
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-empty"></span>
												<span class="icon icon-star-empty"></span>
												<span class="icon icon-star-empty"></span>
											</xsl:when>
											<xsl:when test="stars = 3">
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-empty"></span>
												<span class="icon icon-star-empty"></span>
											</xsl:when>
											<xsl:when test="stars = 4">
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-empty"></span>
											</xsl:when>
											<xsl:when test="stars = 5">
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-filled"></span>
												<span class="icon icon-star-filled"></span>
											</xsl:when>
										</xsl:choose>
									</p>
								</td>
							</tr>
						</table>

						<div id="loading-stats" style="display:none"></div>

						<div align="center">
							<div style="width:472px;">

								<button class="button" onclick="document.location.href='/alley/';">
									<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										<div class="c"><div style="width:114px; height:26px;">Вперед,<br />в закоулки!</div></div>
									</span>
								</button>

								<button style="margin:0 5px;" class="button" id="policeWerewolfRegenerationButton" type="button" onclick="policeWerewolfRegeneration();">
									<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										<div class="c"><div style="width:154px; height:26px;">Подобрать нового<br />оборотня&#160;[<xsl:value-of select="werewolf/level" />]&#160;<!--xsl:if test="werewolf/regeneration > 0">(<xsl:value-of select="werewolf/regeneration" />)</xsl:if--> - <span class="med"><xsl:value-of select="costs/werewolf_regeneration" /><i></i></span></div></div>
									</span>
								</button>

								<button class="button" type="button" onclick="policeWerewolfExtension('/police/werewolf/');">
									<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										<div class="c"><div style="width:134px; height:26px;">Продлить оборотня<br />на час - <span class="med"><xsl:value-of select="costs/werewolf_extension" /><i></i></span></div></div>
									</span>
								</button>

								<div class="hint">
									Вы можете подобрать себе нового оборотня, если этот недостаточно хорош для вас. 
									С&#160;каждым новым подбором шанс найти более сильного оборотня увеличивается, но&#160;остается и&#160;вероятность наткнуться на&#160;более слабого.
								</div>
								<p align="center" style="padding-bottom:1px;"><span class="dashedlink" onclick="$('#police-werewolf-view-leave').toggle('fast');">Хочу отпустить оборотня</span></p>
								<div id="police-werewolf-view-leave" align="center" style="display:none;">
									<p>Вы действительно хотите отпустить <b><i class="npc-werewolf" title="Оборотень"></i>оборотня [<xsl:value-of select="werewolf/level" />]</b> раньше времени?</p>
									<button class="button" type="button" onclick="policeWerewolfCancel();">
										<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Да, отпускаю оборотня</div>
										</span>
									</button>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</xsl:template>
</xsl:stylesheet>
