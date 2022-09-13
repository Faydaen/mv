<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl" version="1.0">
	<xsl:variable name="general_included" select="1" />
    <xsl:output method="html"/>

	<xsl:template name="error">
		<xsl:param name="error" />
		<xsl:param name="type" />
		<xsl:param name="params" />
		<xsl:param name="action" />
		<xsl:param name="result" />
		<xsl:choose>
			<xsl:when test="$result/error = 'you are busy'"><p class="error" align="center">Вы сейчас заняты.</p></xsl:when>
			<xsl:when test="$type = 'macdonalds' and $action = 'work' and $error = 'player busy'"><p class="error" align="center">Вы сейчас заняты и не можете начать работу.</p></xsl:when>

			<xsl:when test="$error = 'low level'"><p class="error">Вы слишком молоды, подкачайтесь и приходите позже.</p></xsl:when>
			<xsl:when test="$error = 'no money'"><p class="error">Вы слишком бедны, <a href="/macdonalds/">заработайте денег</a> или <a href="/alley/">займитесь гоп-стопом</a>.</p></xsl:when>
			<xsl:when test="$error = 'item not found'"><p class="error">Вы хотели купить сами не знаете что, но телепаты в отпуске и не смогли вам помочь.</p></xsl:when>
			<xsl:when test="$error = 'item is uniq'"><p class="error">Вы не можете купить этот предмет, потому что он у вас есть.</p></xsl:when>
			<xsl:when test="$error = 'item is not buyable'"><p class="error">Это не купить в магазине.</p></xsl:when>
			<xsl:when test="$error = 'item is not sellable'"><p class="error">Такой хлам никому не нужен здесь.</p></xsl:when>
			<xsl:when test="$error = 'pet exists'"><p class="error">У вас уже есть питомец, а с двумя вы не управитесь, это точно!</p></xsl:when>
            <xsl:when test="$error = 'safe exists'"><p class="error">У вас уже есть сейф, законом запрещено второй иметь!</p></xsl:when>
            <xsl:when test="$error = 'sex error'"><p class="error">Трансвеститов не обслуживаем! Для них есть магазин за углом.</p></xsl:when>
			<xsl:when test="$error = 'player with such nickname is not exists'"><p class="error">Никто в округе не слышал об этом человеке. Возможно, его зовут не так.</p></xsl:when>
			<xsl:when test="$error = 'full inventory'"><p class="error">Ваш рюкзак уже набит подзавязку, больше вы унести не в состоянии.</p></xsl:when>
			<xsl:when test="$error = 'fight not found'"><p class="error" align="center">Никто не видел этого боя.</p></xsl:when>
			<xsl:when test="$error = 'player not found'"><p class="error" align="center">Никто не слышал о человеке с таким именем.</p></xsl:when>
			<xsl:when test="$error = 'cant dress item, slot is busy'"><p class="error" align="center">Вы не можете надеть эту вещь, потому что слот для нее уже занят.</p></xsl:when>
			<xsl:when test="$error = 'cant sell item, it dressed'"><p class="error" align="center">Вы не можете продать эту вещь, потому что она сейчас надета на вас.</p></xsl:when>
			<xsl:when test="$error = 'item is not undressable'"><p class="error" align="center">Эту вещь нельзя снять.</p></xsl:when>

			<xsl:when test="$result/result = 1 and $result/type = 'fight' and $result/action = 'join fight'"><p class="success" align="center">Ваша заявка на участие в бою принята.</p></xsl:when>

			<xsl:when test="$result/result = 0 and $result/error = 'no money'"><p class="error" align="center">У вас не хватает денег.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/error = 'low level'"><p class="error" align="center">У вас слишком низкий уровень.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/error = 'player with this nickname not found'"><p class="error" align="center">Игрок с таким именем не найден.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/error = 'you have not access'"><p class="error" align="center">У вас нет доступа к данной функции.</p></xsl:when>


			<!--
			<xsl:when test="$result = 0 and $type = 'clan' and $action = '' and $error = ''"><p class="error"></p></xsl:when>
			-->
			<!--xsl:otherwise><p class="error"><b>Случилось что-то неведомое:</b> <xsl:value-of select="$result" /></p></xsl:otherwise-->
		</xsl:choose>
	</xsl:template>

	<xsl:template name="questbutton">
		<xsl:param name="quest" />
		<xsl:if test="quest/button != ''">
			<form action="/quest/" method="post" style="text-align: center;">
				<input type="hidden" name="action" value="nextstep" />
				<button class="button" type="submit">
					<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
						<div class="c"><xsl:value-of select="$quest/button" /></div>
					</span>
				</button>
			</form>
		</xsl:if>
	</xsl:template>

</xsl:stylesheet>