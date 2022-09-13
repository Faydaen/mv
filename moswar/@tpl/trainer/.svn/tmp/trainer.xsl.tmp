<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
	<div class="column-right-topbg">
	    <div class="column-right-bottombg" align="center">
		<div class="heading clear">
		    <h2>
			<span class="trainer"></span>
		    </h2>
		</div>
		<div id="content" class="trainer">

			<div class="welcome">
				<div class="poster"><a href="http://www.fitty.ru" target="_blank"><img src="/@/images/loc/trainer-fitty.png" /></a></div>
				<div class="block-rounded">
					<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
					<div class="text">
						В здоровом теле — здоровый дух.
						С помощью тренажера вы можете улучшить свои характеристики и стать сильным, но неповоротливым качком, 
						ловким ниндзя или харизматичным бизнесменом.
					</div>
				</div>
			</div>
			
			<p class="report">
				<xsl:if test='success-stat!=""'>
					<b class="green">Характеристика «<xsl:value-of select="success-stat" />» успешно увеличена.</b><br />
				</xsl:if>
				<xsl:if test="error-stat!=''">
					<b class="red">На поднятие характеристики не хватает <span class="tugriki"><xsl:value-of select="error-stat" /><i></i></span>.</b><br />
				</xsl:if>
			</p>
			
			<table>
			<tr>
			<td style="width:50%; padding:0 5px 0 0;">

			<div class="block-rounded">
			    <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>

			    <ul class="stats">
					<li class="stat" rel="health">
					    <div class="label">
						<b>Здоровье</b>
						<span class="num">
						    <xsl:value-of select="player/health" />
						</span>
					    </div>

					    <div class="bar">
						<div>
						    <div class="percent" style="width:{player/procenthealth}%;"></div>
						</div>
					    </div>
					    <div class="text">
						<xsl:choose>
						    <xsl:when test='player/money >= player/healthcost'>
							<div class="button" rel="enabled">
							    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
								<div class="c">Повысить —
								    <span class="tugriki">
									<xsl:value-of select="format-number(player/healthcost, '###,###,###')" />
									<i></i>
								    </span>
								</div>
							    </span>
							</div>
						    </xsl:when>
						    <xsl:otherwise>
							<div class="button disabled">
							    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
									<div class="c">Не хватает
									    <span class="tugriki">
										<xsl:value-of select="format-number((player/healthcost - player/money), '###,###,###')" />
										<i></i>
									    </span>
									</div>
							    </span>
							</div>
						    </xsl:otherwise>
						</xsl:choose>
						Влияет на количество жизней
					    </div>
					</li>
					<li class="stat" rel="strength">
					    <div class="label">
						<b>Сила</b>
						<span class="num">
						    <xsl:value-of select="player/strength" />
						</span>
					    </div>
					    <div class="bar">
						<div>
						    <div class="percent" style="width:{player/procentstrength}%;"></div>
						</div>
					    </div>
					    <div class="text">
						<xsl:choose>
						    <xsl:when test='player/money >= player/strengthcost'>
							<div class="button" rel="enabled">
							    <span class="f">
								<i class="rl"></i>
								<i class="bl"></i>
								<i class="brc"></i>
								<div class="c">Повысить —
								    <span class="tugriki">
									<xsl:value-of select="format-number(player/strengthcost, '###,###,###')" />
									<i></i>
								    </span>
								</div>
							    </span>
							</div>
						    </xsl:when>
						    <xsl:otherwise>
							<div class="button disabled">
							    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
									<div class="c">Не хватает
									    <span class="tugriki">
										<xsl:value-of select="format-number((player/strengthcost - player/money), '###,###,###')" />
										<i></i>
									    </span>
									</div>
							    </span>
							</div>
						    </xsl:otherwise>
						</xsl:choose>
						Определяет наносимый противнику урон
					    </div>
					</li>
					<li class="stat" rel="dexterity">
					    <div class="label">
						<b>Ловкость</b>
						<span class="num">
						    <xsl:value-of select="player/dexterity" />
						</span>
					    </div>
					    <div class="bar">
						<div>
						    <div class="percent" style="width:{player/procentdexterity}%;"></div>
						</div>
					    </div>

					    <div class="text">
						<xsl:choose>
						    <xsl:when test='player/money >= player/dexteritycost'>
							<div class="button" rel="enabled">
							    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
								<div class="c">Повысить —
								    <span class="tugriki">
									<xsl:value-of select="format-number(player/dexteritycost, '###,###,###')" />
									<i></i>
								    </span>
								</div>
							    </span>
							</div>
						    </xsl:when>
						    <xsl:otherwise>
							<div class="button disabled">
							   <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
								<div class="c">Не хватает
								    <span class="tugriki">
									<xsl:value-of select="format-number((player/dexteritycost - player/money), '###,###,###')" />
									<i></i>
								    </span>
								</div>
							    </span>
							</div>
						    </xsl:otherwise>
						</xsl:choose>
						Влияет на вероятность нанести удар, а также не дает врагу сконцентрироваться и нанести критический удар.
					    </div>
					</li>
					<li class="stat" rel="resistance">
					    <div class="label">
						<b>Выносливость</b>
						<span class="num">
						    <xsl:value-of select="player/resistance" />
						</span>
					    </div>
					    <div class="bar">
						<div>
						    <div class="percent" style="width:{player/procentresistance}%;"></div>
						</div>
					    </div>
					    <div class="text">
						<xsl:choose>
						    <xsl:when test='player/money >= player/resistancecost'>
							<div class="button" rel="enabled">
							    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
								<div class="c">Повысить —
								    <span class="tugriki">
									<xsl:value-of select="format-number(player/resistancecost, '###,###,###')" />
									<i></i>
								    </span>
								</div>
							    </span>
							</div>
						    </xsl:when>
						    <xsl:otherwise>
							<div class="button disabled">
							    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
								<div class="c">Не хватает
								    <span class="tugriki">
									<xsl:value-of select="format-number((player/resistancecost - player/money), '###,###,###')" />
									<i></i>
								    </span>
								</div>
							    </span>
							</div>
						    </xsl:otherwise>
						</xsl:choose>
						Влияет на получаемый урон и количество жизней
					    </div>
					</li>
				</ul>
			</div>
			
			</td>
			<td style="width:50%; padding:0 0 0 5px;">
			
				<div class="block-rounded">
				    <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
					
					<ul class="stats">
					
					<li class="stat" rel="intuition">
					    <div class="label">
						<b>Хитрость</b>
						<span class="num">
						    <xsl:value-of select="player/intuition" />
						</span>
					    </div>
					    <div class="bar">
						<div>
						    <div class="percent" style="width:{player/procentintuition}%;"></div>
						</div>
					    </div>
					    <div class="text">
						<xsl:choose>
						    <xsl:when test='player/money >= player/intuitioncost'>
							<div class="button" rel="enabled">
							    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
								<div class="c">Повысить —
								    <span class="tugriki">
									<xsl:value-of select="format-number(player/intuitioncost, '###,###,###')" />
									<i></i>
								    </span>
								</div>
							    </span>
							</div>
						    </xsl:when>
						    <xsl:otherwise>
							<div class="button disabled">
							    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
								<div class="c">Не хватает
								    <span class="tugriki">
									<xsl:value-of select="format-number((player/intuitioncost - player/money), '###,###,###')" />
									<i></i>
								    </span>
								</div>
							    </span>
							</div>
						    </xsl:otherwise>
						</xsl:choose>
						Влияет на вероятность критического удара
					    </div>
					</li>
					<li class="stat" rel="attention">
					    <div class="label">
						<b>Внимательность</b>
						<span class="num">
						    <xsl:value-of select="player/attention" />
						</span>
					    </div>
					    <div class="bar">
						<div>
						    <div class="percent" style="width:{player/procentattention}%;"></div>
						</div>
					    </div>

					    <div class="text">
						<xsl:choose>
						    <xsl:when test='player/money >= player/attentioncost'>
							<div class="button" rel="enabled">
							    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
								<div class="c">Повысить —
								    <span class="tugriki">
									<xsl:value-of select="format-number(player/attentioncost, '###,###,###')" />
									<i></i>
								    </span>
								</div>
							    </span>
							</div>
						    </xsl:when>
						    <xsl:otherwise>
							<div class="button disabled">
							    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
								<div class="c">Не хватает
								    <span class="tugriki">
									<xsl:value-of select="format-number((player/attentioncost - player/money), '###,###,###')" />
									<i></i>
								    </span>
								</div>
							    </span>
							</div>
						    </xsl:otherwise>
						</xsl:choose>
						Позволяет чаще избегать ударов соперника
					    </div>

					</li>
					<li class="stat" rel="charism">
					    <div class="label">
						<b>Харизма</b>
						<span class="num">
						    <xsl:value-of select="player/charism" />
						</span>
					    </div>
					    <div class="bar">
						<div>
						    <div class="percent" style="width:{player/procentcharism}%;"></div>
						</div>
					    </div>
					    <div class="text">
						<xsl:choose>
						    <xsl:when test="player/money >= player/charismcost">
							<div class="button" rel="enabled">
							    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
								<div class="c">Повысить —
								    <span class="tugriki">
									<xsl:value-of select="format-number(player/charismcost, '###,###,###')" />
									<i></i>
								    </span>
								</div>
							    </span>
							</div>
						    </xsl:when>
						    <xsl:otherwise>
							<div class="button disabled">
							    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
								<div class="c">Не хватает
								    <span class="tugriki">
									<xsl:value-of select="format-number((player/charismcost - player/money), '###,###,###')" />
									<i></i>
								    </span>
								</div>
							    </span>
							</div>
						    </xsl:otherwise>
						</xsl:choose>
						Помогает выбивать больше денег из соперников, больше зарабатывать и находить приключения
					    </div>
					</li>
				    </ul>
					</div>

					<div class="block-bordered">
						<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
						<div class="center clear">
							<h3>Персональный тренер</h3>
							<div class="trainer-personal-enterance">
								<p>Хотите ускорить процесс своих тренировок? Воспользуйтесь услугами персонального тренера.</p>
								<img src="/@/images/ico/trainer-personal.png" style="position:absolute; bottom:0px; right:10px;" />
								<div class="button">
									<a class="f" href="/trainer/vip/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										<div class="c">Пройти в VIP-зал</div>
									</a>
								</div>
								<p class="hint">Доступно с 5-го уровня</p>
							</div>												
						</div>
						<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
					</div>

				</td>
				</tr>
				</table>
				
			    <script><![CDATA[
                        $('li.stat div.button[rel=enabled]').bind ('click', function(){document.location.href='/trainer/train/'+$(this).parents ('li:first').attr ('rel')+'/';});
                    ]]>
			    </script>
		    </div>
		</div>
	</div>
    </xsl:template>
</xsl:stylesheet>
