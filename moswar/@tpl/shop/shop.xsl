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
						<span class="shop"></span>
					</h2>
				</div>
				<div id="content" class="shop">

					<div class="welcome"></div>

					<table class="buttons">
						<tr>
							<xsl:for-each select="sections/element">
								<xsl:if test="position() &lt;= 6">
									<td>
										<xsl:if test="title != 'spacer'">
											<xsl:element name="div">
												<xsl:attribute name="class">
													button
												</xsl:attribute>
												<xsl:if test="name = /data/section">
													<xsl:attribute name="class">
														button button-current
													</xsl:attribute>
												</xsl:if>
												<a class="f" href="/shop/section/{name}/">
													<i class="rl"></i>
													<i class="bl"></i>
													<i class="brc"></i>
													<div class="c"><xsl:value-of select="title" /></div>
												</a>
											</xsl:element>
										</xsl:if>
									</td>
								</xsl:if>
							</xsl:for-each>
						</tr>
						<tr>
							<xsl:for-each select="sections/element">
								<xsl:if test="position() &gt; 6 and position() &lt;= 12">
									<td>
										<xsl:if test="title != 'spacer'">
											<xsl:element name="div">
												<xsl:attribute name="class">
													button
												</xsl:attribute>
												<xsl:if test="name = /data/section">
													<xsl:attribute name="class">
														button button-current
													</xsl:attribute>
												</xsl:if>
												<a class="f" href="/shop/section/{name}/">
													<i class="rl"></i>
													<i class="bl"></i>
													<i class="brc"></i>
													<div class="c">
														<!-- подсветить раздел Мои вещи -->
														<xsl:if test="name = 'mine'">
															<xsl:attribute name="style">color:blue;</xsl:attribute>
														</xsl:if>													
														<xsl:value-of select="title" />
													</div>
												</a>
											</xsl:element>
										</xsl:if>
									</td>
								</xsl:if>
							</xsl:for-each>
						</tr>
						<tr>
							<xsl:for-each select="sections/element">
								<xsl:if test="position() &gt; 12">
									<td>
										<xsl:if test="title != 'spacer'">
											<xsl:element name="div">
												<xsl:attribute name="class">
													button
												</xsl:attribute>
												<xsl:if test="name = /data/section">
													<xsl:attribute name="class">
														button button-current
													</xsl:attribute>
												</xsl:if>
												<a class="f" href="/shop/section/{name}/">
													<i class="rl"></i>
													<i class="bl"></i>
													<i class="brc"></i>
													<div class="c"><xsl:value-of select="title" /></div>
												</a>
											</xsl:element>
										</xsl:if>
									</td>
								</xsl:if>
							</xsl:for-each>
						</tr>
					</table>
					<!--<div class="report">
						<xsl:choose>
							<xsl:when test="result = 0">
								<xsl:call-template name="error">
									<xsl:with-param name="error" select="error" />
								</xsl:call-template>
							</xsl:when>
							<xsl:when test="result = 1 and action = 'buy'">
								<p class="success">Вы были так довольны покупкой, что чуть не оставили ее в магазине.</p>
							</xsl:when>
							<xsl:when test="result = 1 and action = 'sell'">
								<p class="success">Вы избавились от хлама и прихватили немного деньжат за него.</p>
							</xsl:when>
						</xsl:choose>
						<xsl:if test="result/result = 0">
							<xsl:call-template name="error">
								<xsl:with-param name="error" select="result/error" />
							</xsl:call-template>
						</xsl:if>
					</div>-->

					<xsl:if test="count(result/type) > 0 and count(result/action) > 0 and count(result/result) > 0">
						<xsl:call-template name="error">
							<xsl:with-param name="result" select="result" />
						</xsl:call-template>
					</xsl:if>
					
					<xsl:choose>
						<xsl:when test="count(items/element) > 0">
							<xsl:if test="section = 'clan'">
                                <p><b>Внимание!</b> Вещи в этом разделе покупаются только главой клана, его замом или казначеем за деньги в клановой казне. После покупки вещи попадают в клановый штаб.</p>
                            </xsl:if>
                            <ul class="objects">								
								<xsl:choose>
									<xsl:when test="count(items2/element) != 0">
										<xsl:for-each select="items/element">
											<xsl:call-template name="shop-item" />
										</xsl:for-each>
										<li class="object shop-items-toggle">
											<h2><span class="dashedlink" onclick="$('.shop-items-other').slideToggle();">Показать малышовые предметы</span></h2>
										</li>
										<div class="shop-items-other">
											<xsl:for-each select="items2/element">
												<xsl:call-template name="shop-item" />
											</xsl:for-each>
										</div>
									</xsl:when>
									<xsl:otherwise>
										<xsl:for-each select="items/element">
											<xsl:call-template name="shop-item" />
										</xsl:for-each>
									</xsl:otherwise>
								</xsl:choose>
							</ul>
						</xsl:when>
						<xsl:when test="section = 'mine'">
							<div class="block-rounded">
								<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
								<div class="closed">
									<h3>Закрыто</h3>
									<center>У вас нет вещей, которые можно было бы продать.</center>
								</div>
							</div>
						</xsl:when>
						<xsl:otherwise>
							<div class="block-rounded">
								<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
								<div class="closed">
									<h3>Закрыто</h3>
									<center>В отделе учет. Приходите позже.</center>
								</div>
							</div>
						</xsl:otherwise>
					</xsl:choose>
				</div>
			</div>
		</div>

        <div class="alert" id="present-panel">
            <div class="padding">
                <h2>Подарить подарок</h2>
                <div class="data">
                    <form class="gift-form" method="post" action="/shop/" id="present-form">
						<input type="hidden" name="action" value="buy" />
						<input type="hidden" name="return_url" value="/shop/section/gifts/" />
						<input type="hidden" name="item" id="itemid" value="0" />
                        <input type="hidden" name="playerid" id="present-form-playerid" value="{/data/present/playerid}" />
						<input type="hidden" name="key" id="present_form_buy_key" value="" />
						<div class="report"><div class="error"></div></div>
                        <table class="forms">
                            <tr>
                                <td class="label">Подарок:</td>
                                <td class="input" id="present-form-present"></td>
                            </tr>
                            <tr>
                                <td class="label">Кому:</td>
                                <td class="input">
                                    <xsl:choose>
                                        <xsl:when test="/data/present/playerid != ''">
                                            <b><xsl:value-of select="/data/present/playername" /></b> (<a href="/shop/section/gifts/">другому</a>)
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <input type="checkbox" name="me" id="to-me">
												<xsl:attribute name="onclick">
												<![CDATA[  if(this.checked) { $('#present-form-player').hide(); } else { $('#present-form-player').show(); }  ]]>
												</xsl:attribute>
											</input>
											<label for="to-me">Себе любимому</label><br />
                                            <input type="player" id="present-form-player" name="player" class="name" />
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Текст:</td>
                                <td class="input">
                                    <xsl:choose>
                                        <xsl:when test="player/level > 2">
                                            <textarea name="comment" id="present-form-comment"></textarea>
                                            <div class="hint">Не более 200 символов</div>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <em>Вы сможете писать к подаркам собственные комментарии, когда достигните 3-го уровня.</em>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </td>
                            </tr>
							<tr>
								<td class="label"><input type="checkbox" id="present-form-private" name="private" /></td>
								<td class="input"><label for="present-form-private">Текст виден только получателю</label></td>
							</tr>
							<tr>
								<td class="label"><input type="checkbox" id="present-form-anonimous" name="anonimous" /></td>
								<td class="input"><label for="present-form-anonimous">Отправить анонимно. (Подарки с минусами остаются видимыми получателю)</label></td>
							</tr>
                            <tr>
                                <td class="label"></td>
                                <td class="input">
                                    <button class="button" type="button" onclick="sendForm('present-form', 'checkPresentForm', 'hidePresentForm', '');return false;">
                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                            <div class="c">Подарить</div>
                                        </span>
                                    </button>&#160;
                                    <button class="button" type="buttom" onclick="$('#present-panel').hide();return false;">
                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                            <div class="c">Отмена</div>
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
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
            <xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'no money'"><p class="error" align="center">У вас не хватает денег. Не смешите людей, идите работайте. <a href="/stash/">Получить монеты</a></p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'low level'"><p class="error" align="center">У вас низкий уровень для покупки этой вещи.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'shop' and $result/action = 'buy' and $result/error = 'full inventory'"><p class="error" align="center">У вас полно вещей, вы не унесете еще одну. Купите сумку для увеличения рюкзака, сумка может быть куплена даже при переполненном инвентаре.</p></xsl:when>
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
