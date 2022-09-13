<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>

    <!--xsl:template match="shop-item">
		<xsl:call-template name="shop-item" />
	</xsl:template-->

    <xsl:template name="shop-item">
		<li class="object" rel="{id}">
			<h2>
				<xsl:value-of select="name" /><xsl:if test="mf > 0"> [<xsl:value-of select="mf" />]</xsl:if>
			</h2>
			<div class="data">
				<div class="text">
					<xsl:if test="info != ''">
						<h4>Описание</h4>
						<xsl:value-of select="info" disable-output-escaping="yes" />
					</xsl:if>
				</div>
				<div class="characteristics">
					<h4 style="display:inline;">Воздействия</h4>
					<xsl:call-template name="item-params"><xsl:with-param name="item" select="current()" /></xsl:call-template>
					<xsl:if test="type = 'home_safe'"><br /></xsl:if>

					<xsl:if test="level != '' and level > 0">
						<h4>Требования</h4>
						Уровень: 
						<xsl:value-of select="level" />
						<br />
					</xsl:if>
					<xsl:if test="shopdt2 != ''">
						<h4>В продаже до</h4>
						<xsl:value-of select="shopdt2" />
						<br />
					</xsl:if>

				</div>
				<i class="thumb">
					<img src="/@/images/obj/{image}" alt="{image_title}" title="{image_title}" />
                    <xsl:if test="stackable = 1">
                        <div class="count">#<xsl:value-of select="durability" /></div>
                    </xsl:if>
                    <xsl:if test="mf > 0">
                        <div class="mf">М-<xsl:value-of select="mf" /></div>
                    </xsl:if>
				</i>
				<div class="actions">
                    <xsl:if test="(((sex = /data/mysex or sex='') and buyable = 1 and (/data/playerlevel>=level or (/data/playerlevel+1>=level and forgrowth = 1))) or /data/player/accesslevel = 100) and (/data/shop = 'berezka' or /data/section != 'mine')">
						<xsl:if test="forgrowth = 1"><span class="error" style="float: left;">Этот предмет можно будет надеть только на <xsl:value-of select="level" /> уровне</span></xsl:if>
						<xsl:if test="stackable = 1">
							<span class="count">Кол-во: <input type="text" name="amount" size="1" value="1" /></span>
						</xsl:if>

						<xsl:if test="(shop = 'berezka' and (money > 0 or ore > 0 or oil > 0 or warzub > 0 or wargoldenzub > 0 or huntbadge > 0 or huntmobile > 0 or stars > 0 or petriks > 0)) or shop = 'shop'">
						
							<div class="button">
								<xsl:element name="span">
									<xsl:attribute name="class">f</xsl:attribute>
									<xsl:choose>
										<xsl:when test="code = 'axe1'">
											<xsl:attribute name="onclick">document.location.href='/shop/special/axe1/';</xsl:attribute>
										</xsl:when>
										<xsl:when test="stackable = 1">
											<xsl:attribute name="onclick">shopBuyItem('<xsl:value-of select="/data/key" />', <xsl:value-of select="id" />, '<xsl:value-of select="/data/return_url" />', $(this).parents('div.actions:first').find('input[name=amount]').val());</xsl:attribute>
										</xsl:when>
										<xsl:when test="type = 'gift' or type = 'gift2' or type = 'ring'">
											<!--xsl:attribute name="onclick">input("Введите имя игрока:", "<xsl:value-of select="/data/playername" />", "/shop/section/<xsl:value-of select="/data/section" />/buy/<xsl:value-of select="id" />/", "player");</xsl:attribute-->
											<xsl:attribute name="onclick">showPresentForm('<xsl:value-of select="/data/key" />', <xsl:value-of select="id" />,'<xsl:value-of select="name" />');</xsl:attribute>
										</xsl:when>
										<xsl:otherwise>
											<xsl:attribute name="onclick">shopBuyItem('<xsl:value-of select="/data/key" />', <xsl:value-of select="id" />, '<xsl:value-of select="/data/return_url" />');</xsl:attribute>
										</xsl:otherwise>
									</xsl:choose>
									<i class="rl"></i>
									<i class="bl"></i>
									<i class="brc"></i>
									<xsl:choose>
										<xsl:when test="code = 'axe1'">
											<div class="c">Получить</div>
										</xsl:when>
										<xsl:when test="shop = 'berezka'">
												<div class="c">Купить за
													<xsl:call-template name="showprice">
														<xsl:with-param name="nohoney" select="1" />
														<xsl:with-param name="money" select="money" />
														<xsl:with-param name="ore" select="ore" />
														<xsl:with-param name="oil" select="oil" />
														<xsl:with-param name="war_zub" select="warzub" />
														<xsl:with-param name="war_goldenzub" select="wargoldenzub" />
														<xsl:with-param name="huntclub_badge" select="huntbadge" />
														<xsl:with-param name="huntclub_mobile" select="huntmobile" />
														<xsl:with-param name="fight_star" select="stars" />
														<xsl:with-param name="petriks" select="petriks" />
													</xsl:call-template>
												</div>
										</xsl:when>
										<xsl:otherwise>
	<!--xsl:if test="/data/allowbuy = 1"-->
											<div class="c">Купить за
												<xsl:call-template name="showprice">
													<xsl:with-param name="money" select="money" />
													<xsl:with-param name="ore" select="ore" />
													<xsl:with-param name="oil" select="oil" />
													<xsl:with-param name="honey" select="honey" />
													<xsl:with-param name="war_zub" select="warzub" />
													<xsl:with-param name="war_goldenzub" select="wargoldenzub" />
													<xsl:with-param name="huntclub_badge" select="huntbadge" />
													<xsl:with-param name="huntclub_mobile" select="huntmobile" />
													<xsl:with-param name="fight_star" select="stars" />
													<xsl:with-param name="petriks" select="petriks" />
												</xsl:call-template>
											</div>
	<!--/xsl:if-->
										</xsl:otherwise>
									</xsl:choose>
								</xsl:element>
							</div>
						</xsl:if>
						<xsl:if test="shop = 'berezka' and honey > 0">
							<div class="button">
								<xsl:element name="a">
									<xsl:attribute name="class">f</xsl:attribute>
									<xsl:attribute name="onclick">shopBuyItem('<xsl:value-of select="/data/key" />', <xsl:value-of select="id" />, '<xsl:value-of select="/data/return_url" />', $(this).parents('div.actions:first').find('input[name=amount]').val(), 'honey');</xsl:attribute>
									<i class="rl"></i>
									<i class="bl"></i>
									<i class="brc"></i>
									<div class="c">Купить за
										<xsl:call-template name="showprice">
											<xsl:with-param name="honey" select="honey" />
										</xsl:call-template>
									</div>
								</xsl:element>
							</div>
						</xsl:if>
                    </xsl:if>
					<!--xsl:if test="auction_ore > 0 or auction_money > 0 or auction_honey > 0">
						<div class="button">
							<span class="f">
								<i class="rl"></i>
								<i class="bl"></i>
								<i class="brc"></i>
								<div class="c">Поторговаться
									<xsl:if test="auction_money > 0">
										<span class="tugriki">
											<xsl:value-of select="auction_money" />
											<i></i>
										</span>
									</xsl:if>
									<xsl:if test="auction_ore > 0">
										<span class="ruda">
											<xsl:value-of select="auction_ore" />
											<i></i>
										</span>
									</xsl:if>
									<xsl:if test="auction_honey > 0">
										<span class="med">
											<xsl:value-of select="auction_honey" />
											<i></i>
										</span>
									</xsl:if>
								</div>
							</span>
						</div>
					</xsl:if-->
					<xsl:if test="/data/section = 'mine' and (sell/ore > 0 or sell/money > 0 or sell/honey > 0)">
						<div class="button">
							<span class="f" onclick="if(!confirm('Вы уверены, что хотите продать предмет?'))return false;shopSellItem('{id}', '/shop/section/{/data/section}/');">
								<i class="rl"></i>
								<i class="bl"></i>
								<i class="brc"></i>
								<div class="c">Продать за
									<xsl:call-template name="showprice">
										<xsl:with-param name="money" select="sell/money" />
										<xsl:with-param name="ore" select="sell/ore" />
										<xsl:with-param name="oil" select="sell/oil" />
										<xsl:with-param name="honey" select="sell/honey" />
                                        <xsl:with-param name="nohoney" select="1" />
									</xsl:call-template>
								</div>
							</span>
						</div>
					</xsl:if>
				</div>
			</div>
		</li>
	</xsl:template>
</xsl:stylesheet>
