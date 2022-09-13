<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

	<xsl:include href="common/price.xsl" />
    <xsl:include href="shop/item.xsl" />
    <xsl:include href="common/item.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
	            <div class="heading clear">
	                <h2>
						Берёзка
	                </h2>
	            </div>
				<div id="content" class="shop berezka">
				
					<div class="welcome">
						<div class="block-rounded">
							<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
							<div class="text">
								Бартер — это хорошо.<br />В нашем царском магазине &#0171;Берёзка&#0187; Вы найдете товары, которые можно поменять<br />
								на <b><i class="tooth-golden"></i><i class="tooth-white"></i>зубы</b>, 
								<span class="star"><i></i>звездочки</span>, 
								<span class="badge"><i></i>жетоны</span>,
								<span class="mobila"><i></i>мобилы</span>,
								<span class="neft"><i></i>нефть</span>
								или <span class="med"><i></i>мёд</span>.
								<div class="borderdata">
									У вас в наличии:&#160;
									<span class="tooth-golden"><xsl:value-of select="format-number(number(war_goldenzub), '###,###,###')" /><i></i></span> &#160;
									<span class="tooth-white"><xsl:value-of select="format-number(war_zub, '###,###,###')" /><i></i></span> &#160;
									<span class="star"><xsl:value-of select="format-number(fight_star, '###,###,###')" /><i></i></span> &#160;
									<span class="badge"><xsl:value-of select="format-number(huntclub_badge, '###,###,###')" /><i></i></span> &#160;
									<span class="mobila"><xsl:value-of select="format-number(huntclub_mobile, '###,###,###')" /><i></i></span> &#160;
									<span class="neft"><xsl:value-of select="format-number(player/oil, '###,###,###')" /><i></i></span> &#160;
									<span class="med"><xsl:value-of select="format-number(player/honey, '###,###,###')" /><i></i></span>
								</div>
							</div>
						</div>

					</div>

					<xsl:if test="count(result/type) > 0 and count(result/action) > 0 and count(result/result) > 0">
						<xsl:call-template name="error">
							<xsl:with-param name="result" select="result" />
						</xsl:call-template>
					</xsl:if>

					<ul class="objects">
						<xsl:for-each select="items/element">
							<xsl:call-template name="shop-item" />
						</xsl:for-each>
					</ul>
	            </div>
            </div>
        </div>
    </xsl:template>

	<xsl:template name="error">
		<xsl:param name="error" />
		<xsl:param name="type" />
		<xsl:param name="params" />
		<xsl:param name="action" />
		<xsl:param name="result" />

        <xsl:choose>
            <!-- errors -->
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'sell' and $result/error = 'item is dressed'"><p class="error" align="center">Эта вещь сейчас на вас, необходимо сначала ее снять.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'sell' and $result/error = 'item is not sellable'"><p class="error" align="center">Магазин не выкупает такой хлам.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'sell' and $result/error = 'item not found'"><p class="error" align="center">У вас нет этой вещи.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'item not found'"><p class="error" align="center">Магазин не продает такие вещи.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'item is not buyable'"><p class="error" align="center">Еще чего захотел! Товар - дефицит, только для своих.</p></xsl:when>
            <xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'no money'"><p class="error" align="center">У вас не хватает денег. Не смешите людей, идите работайте.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'low level'"><p class="error" align="center">У вас низкий уровень для покупки этой вещи.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'full inventory'"><p class="error" align="center">У вас полно вещей, вы не унесете еще одну.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'pet exists'"><p class="error" align="center">У вас уже есть один такой питомец, вы не можете завести второго.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'pet full'"><p class="error" align="center">Вы не можете иметь больше трех питомцев.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'no free slots for home'"><p class="error" align="center">Ваша квартира уже забита всяким хламом под завязку, еще одна вещь не поместится.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'you have not home'"><p class="error" align="center">У вас еще нет квартиры.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'you already have this uniq item'"><p class="error" align="center">Такую вещь можно иметь только одну.</p></xsl:when>
            <xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'not_clan_founder'"><p class="error" align="center">Только глава клана может затовариваться в этом отделе.</p></xsl:when>
			<!-- successes -->
			<xsl:when test="$result/result = 1 and $result/type = 'shop' and $result/action = 'sell'"><p class="success" align="center">Вы избавились от хлама и прихватили немного деньжат за него.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'shop' and $result/action = 'buy'"><p class="success" align="center">Вы были так довольны покупкой, что чуть не оставили ее в магазине.</p></xsl:when>
        </xsl:choose>

    </xsl:template>

</xsl:stylesheet>