<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
	<div id="personal">
	    <a href="/player/" class="name">
			<xsl:choose>
				<xsl:when test="avatar != ''">
					<img src="http://img.moswar.ru{avatar}" class="avatar" /><br />
				</xsl:when>
				<xsl:otherwise>
					<img src="/@/images/pers/general_thumb.png" class="avatar" /><br />
				</xsl:otherwise>
			</xsl:choose>
			<xsl:choose>
				<xsl:when test="nickname != ''">
					<b><xsl:value-of select="nickname" /> [<xsl:value-of select="level" />]</b>
				</xsl:when>
				<xsl:otherwise>
					<b>Это вы [1]</b>
				</xsl:otherwise>
			</xsl:choose>
	    </a>
	    <div class="life">
		Жизни: 
		<span id="currenthp"><xsl:value-of select="hp" /></span>/<span id="maxhp"><xsl:value-of select="maxhp" /></span>
		<div class="bar">
			<div class="percent" style="width: {procenthp}%;" id="playerHpBar"></div>
		</div>
	    </div>
	    <div class="wanted" title="Когда розыск положительный, вы можете попасть за решетку">
		Розыск: 
		<i class="start">-5</i>
		<i class="end">+5</i>
		<div class="bar">
		    <div class="percent" style="width:{procentsuspicion}%;"></div>
			<!--xsl:element name="div">
				<xsl:attribute name="class">percent</xsl:attribute>
				<xsl:attribute name="style">width: <xsl:value-of select="procentsuspicion" />%;</xsl:attribute>
			</xsl:element-->
		</div>
	    </div>

	    <ul class="wallet">
			<xsl:if test="level >= 10">
				<xsl:attribute name="class">wallet wallet-4</xsl:attribute>
			</xsl:if>
			<li class="tugriki-block" title="Монет: {money}">
				<b class="tugriki"></b><br />
			    <span rel="money"><xsl:value-of select="format-number(money, '###,###,###')" /></span>
			</li><![CDATA[]]><li class="ruda-block" title="Руды: {ore}">
				<b class="ruda"></b><br />
			    <span rel="ore"><xsl:value-of select="format-number(ore, '###,###')" /></span>
			</li><![CDATA[]]><xsl:if test="level >= 10"><li class="neft-block" title="Нефти: {oil}">
				<b class="neft"></b><br />
			    <span rel="oil"><xsl:value-of select="format-number(oil, '###,###')" /></span>
			</li><![CDATA[]]></xsl:if><li class="med-block" title="Меда: {honey}">
				<b class="med"></b><br />
			    <a href="/stash/"><span rel="honey"><xsl:value-of select="format-number(honey, '###,###')" /></span></a>
			</li>
	    </ul>
		<div>
			<xsl:attribute name="class">
				phone 
				<xsl:if test="newmes > 0 or newlogs > 0 or newduellogs > 0">phone-attention</xsl:if>
			</xsl:attribute>
		    <i class="icon"></i>
		    <a href="/phone/">Телефон</a>
			<xsl:if test="newmes > 0 or newlogs > 0 or newduellogs > 0">
				&#0160;(<xsl:if test="newmes > 0"><a href="/phone/messages/" title="Новые сообщения"><xsl:value-of select="newmes" /></a></xsl:if>
					<xsl:if test="newlogs > 0"><xsl:if test="newmes > 0">&#0160;</xsl:if><a href="/phone/logs/" title="Новые логи"><xsl:value-of select="newlogs" /></a></xsl:if>
					<xsl:if test="newduellogs > 0"><xsl:if test="newmes > 0 or newlogs > 0">&#0160;</xsl:if><a href="/phone/duels/" title="Новые дуэли"><xsl:value-of select="newduellogs" /></a></xsl:if>)
			</xsl:if>
		</div>
	</div>
	
	<!--<div style="color:#bd5d00" class="side-invite">
	    Фото-конкурс «<a style="color:#bd5d00" href="http://forum.theabyss.ru/index.php?showtopic=304446" target="_blank">Среда обитания настоящего мосваровца</a>»
	</div>-->
	

	<div class="side-invite">
		Отправь другу ссылку на игру и получи <a href="/stash/">бонусы</a><br />
		<input onclick="this.select()" type="text" value="http://moswar.ru/register/{id}/" />
	</div>

	<xsl:choose>
		<xsl:when test="kubovich = 1">
            <a href="/casino/kubovich/">
				<div class="side-fractionwar" style="color:#89deff; background:url(/@/images/link/kubovich.jpg) #2a66a1 no-repeat;">
					Приз в студию!
				</div>
			</a>
        </xsl:when>
        <xsl:when test="taxiblock = 1">
            <a href="/arbat/" style="text-decoration:none;">
                <div class="side-fractionwar" style="color:#fff; background:url(/@/images/link/taxi.jpg) #434994 no-repeat;">
                    За сотку поедем?
                </div>
            </a>
        </xsl:when>
		<xsl:when test="sovetdaynum = 1">
            <a href="/sovet/" style="text-decoration:none;">
                <div class="side-fractionwar" style="color:#fff; background:url(/@/images/loc/fractionwar-candidate.jpg) #434994 no-repeat;">
                    Голосуй за своего кандидата!
                </div>
            </a>
        </xsl:when>
        <xsl:when test="sovetdaynum = 2">
            <a href="/sovet/map/#stationschoose" style="text-decoration:none;">
                <div class="side-fractionwar" style="color:#fff; background:url(/@/images/loc/fractionwar-station.jpg) #637c9e no-repeat;">
                    Какой район атаковать?
                </div>
            </a>
        </xsl:when>
        <xsl:when test="sovetdaynum = 4">
            <a href="/alley/" style="text-decoration:none;">
                <div class="side-fractionwar" style="color:#fff; background:url(/@/images/loc/fractionwar-duel.jpg) #ae805e no-repeat;">
                    Дуэли с врагом!
                </div>
            </a>
        </xsl:when>
        <xsl:when test="sovetdaynum = 5">
            <a href="/alley/" style="text-decoration:none;">
                <div class="side-fractionwar" style="color:#fff; background:url(/@/images/loc/fractionwar-groupfight.jpg) #ce7352 no-repeat;">
                    Стенка-на-стенку с&#160;врагом!
                </div>
            </a>
        </xsl:when>
        <xsl:when test="sovetdaywin = 1">
            <a href="/sovet/warstats/" style="text-decoration:none;">
                <div class="side-fractionwar" style="color:#fff; background:url(/@/images/loc/fractionwar-win.jpg) #13962a no-repeat;">
                    Ваша победа!
                </div>
            </a>
        </xsl:when>
        <xsl:when test="sovetdayfail = 1">
            <a href="/sovet/warstats/" style="text-decoration:none;">
                <div class="side-fractionwar" style="color:#fff; background:url(/@/images/loc/fractionwar-fail.jpg) #c8a5e5 no-repeat;">
                    Увы, битва <nobr>проиграна :-(</nobr>
                </div>
            </a>
        </xsl:when>
    </xsl:choose>


	<!--
	<div class="side-invite" style="margin: -14px 0 10px 0; text-align: center;">
		<a href="http://www.moswar.ru/temp/runet/" target="_blank"><img title="За Мосвар голосуймана" src="/@/images/s/premiaruneta.gif" /></a>
	</div>
	-->
    </xsl:template>
</xsl:stylesheet>
