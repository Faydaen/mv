<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0"><!-- xmlns:php="http://php.net/xsl" -->
    <xsl:output method="html"/>

    <xsl:template name="item">
		<xsl:param name="item" />
		<xsl:param name="show_hidden" select="'0'" />
		<xsl:if test="count($item/name) > 0 or count($item/si) > 0">
			<xsl:element name="img">
				<xsl:choose>
					<xsl:when test="$item/image != ''">
						<xsl:attribute name="src">/@/images/obj/<xsl:value-of select="$item/image" /></xsl:attribute>
					</xsl:when>
					<xsl:otherwise>
						<xsl:attribute name="src">/@/images/ico/slot-hidden.png</xsl:attribute>
					</xsl:otherwise>
				</xsl:choose>
				<xsl:attribute name="tooltip">1</xsl:attribute>
				<xsl:attribute name="title">
					<xsl:choose>
						<xsl:when test="show_hidden = 1">Слот скрыт||Несмотря на то, что вы читаете десятки модных журналов, вы не в состоянии определить, что надето на человеке. Либо это ваше плохое зрение, либо удачная маскировка.|Все выяснится только в бою.</xsl:when>
						<xsl:otherwise>
                            <xsl:value-of select="$item/name" /><xsl:if test="$item/anonymous = 0"> от <xsl:value-of select="$item/player_from" /></xsl:if><xsl:if test="$item/mf > 0"> [<xsl:value-of select="$item/mf" />]</xsl:if>
                            <xsl:choose><xsl:when test="($item/private = 0 or $item/player = /data/self/id) and $item/comment != ''">||<xsl:value-of select="comment" /></xsl:when><xsl:otherwise><xsl:if test="$item/info != ''">||<xsl:value-of select="$item/info" /></xsl:if></xsl:otherwise></xsl:choose>
                            ||<xsl:call-template name="item-params"><xsl:with-param name="item" select="$item" /><xsl:with-param name="separator" select="'|'" /></xsl:call-template>
						</xsl:otherwise>
					</xsl:choose>
				</xsl:attribute>
			</xsl:element>
            <xsl:if test="$item/mf > 0">
                <div class="mf">М-<xsl:value-of select="$item/mf" /></div>
            </xsl:if>
		</xsl:if>
	</xsl:template>

    <xsl:template name="item-params">
        <xsl:param name="item" />
        <xsl:param name="separator"><br /></xsl:param>

        <xsl:choose>
            <xsl:when test="$item/type = 'pet'">
                    <xsl:if test="$item/special1 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/special1name" />: <xsl:value-of select="$item/special1before" /><xsl:value-of select="$item/special1" /><xsl:value-of select="$item/special1after" /></xsl:if>
                <xsl:if test="$item/sp1 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/sp1n" />: <xsl:value-of select="$item/sp1b" /><xsl:value-of select="$item/sp1" /><xsl:value-of select="$item/sp1a" /></xsl:if>

                <xsl:if test="$item/wins > 0"><xsl:copy-of select="$separator" />Победы: <xsl:value-of select="$item/wins" /></xsl:if>
                <xsl:if test="$item/procent != 0"><xsl:copy-of select="$separator" />Развитие: <xsl:value-of select="$item/procent" />% от характеристик хозяина</xsl:if>
                <xsl:if test="$item/hp != 0"><xsl:copy-of select="$separator" />Жизни: <xsl:value-of select="$item/hp" />/<xsl:value-of select="$item/maxhp" /></xsl:if>
                    <xsl:if test="$item/health != 0"><xsl:copy-of select="$separator" />Здоровье: <xsl:value-of select="$item/health" /></xsl:if>
                <xsl:if test="$item/h != 0"><xsl:copy-of select="$separator" />Здоровье: <xsl:value-of select="$item/h" /></xsl:if>
                    <xsl:if test="$item/strength != 0"><xsl:copy-of select="$separator" />Сила: <xsl:value-of select="$item/strength" /></xsl:if>
                <xsl:if test="$item/s != 0"><xsl:copy-of select="$separator" />Сила: <xsl:value-of select="$item/s" /></xsl:if>
                    <xsl:if test="$item/dexterity != 0"><xsl:copy-of select="$separator" />Ловкость: <xsl:value-of select="$item/dexterity" /></xsl:if>
                <xsl:if test="$item/d != 0"><xsl:copy-of select="$separator" />Ловкость: <xsl:value-of select="$item/d" /></xsl:if>
                    <xsl:if test="$item/intuition != 0"><xsl:copy-of select="$separator" />Хитрость: <xsl:value-of select="$item/intuition" /></xsl:if>
                <xsl:if test="$item/i != 0"><xsl:copy-of select="$separator" />Хитрость: <xsl:value-of select="$item/i" /></xsl:if>
                    <xsl:if test="$item/attention != 0"><xsl:copy-of select="$separator" />Внимательность: <xsl:value-of select="$item/attention" /></xsl:if>
                <xsl:if test="$item/a != 0"><xsl:copy-of select="$separator" />Внимательность: <xsl:value-of select="$item/a" /></xsl:if>
                    <xsl:if test="$item/resistance != 0"><xsl:copy-of select="$separator" />Выносливость: <xsl:value-of select="$item/resistance" /></xsl:if>
                <xsl:if test="$item/r != 0"><xsl:copy-of select="$separator" />Выносливость: <xsl:value-of select="$item/r" /></xsl:if>
                    <xsl:if test="$item/charism != 0"><xsl:copy-of select="$separator" />Харизма: <xsl:value-of select="$item/charism" /></xsl:if>
                <xsl:if test="$item/c != 0"><xsl:copy-of select="$separator" />Харизма: <xsl:value-of select="$item/c" /></xsl:if>
            </xsl:when>

            <xsl:otherwise>
                <xsl:if test="$item/usestate = 'fight'"><xsl:copy-of select="$separator" />Используется в бою</xsl:if>
                <xsl:if test="$item/type = 'pick' or $item/type = 'metro'"><xsl:copy-of select="$separator" />Использований: <xsl:if test="$item/durability != ''"><xsl:value-of select="$item/durability" />/</xsl:if><xsl:value-of select="$item/maxdurability" /></xsl:if>
                <!--xsl:if test="($item/type = 'drug' or $item/type = 'drug2') and $item/time != ''"><xsl:copy-of select="$separator" />Время действия: </xsl:if-->
                <xsl:if test="$item/hp != 0"><xsl:copy-of select="$separator" />Жизни: <xsl:if test="$item/hp > 0">+</xsl:if><xsl:choose><xsl:when test="$item/hp &lt;= 0.1 and $item/hp >= -0.1"><xsl:value-of select="$item/hp * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/hp" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/health != 0"><xsl:copy-of select="$separator" />Здоровье: <xsl:if test="$item/health > 0">+</xsl:if><xsl:choose><xsl:when test="$item/health &lt;= 0.1 and $item/health >= -0.1"><xsl:value-of select="$item/health * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/health" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/health2 != 0">&#0160;(до +<xsl:choose><xsl:when test="$item/health2 &lt;= 0.1 and $item/health2 >= -0.1"><xsl:value-of select="$item/health2 * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/health2" /></xsl:otherwise></xsl:choose>)</xsl:if>
                <xsl:if test="$item/h != 0"><xsl:copy-of select="$separator" />Здоровье: <xsl:if test="$item/h > 0">+</xsl:if><xsl:choose><xsl:when test="$item/h &lt;= 0.1 and $item/h >= -0.1"><xsl:value-of select="$item/h * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/h" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/strength != 0"><xsl:copy-of select="$separator" /><xsl:choose><xsl:when test="$item/type = 'drug2'">Рейтинг урона</xsl:when><xsl:otherwise>Сила</xsl:otherwise></xsl:choose>: <xsl:if test="$item/strength > 0">+</xsl:if><xsl:choose><xsl:when test="$item/strength &lt;= 0.1 and $item/strength >= -0.1"><xsl:value-of select="$item/strength * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/strength" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/strength2 != 0">&#0160;(до +<xsl:choose><xsl:when test="$item/strength2 &lt;= 0.1 and $item/strength2 >= -0.1"><xsl:value-of select="$item/strength2 * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/strength2" /></xsl:otherwise></xsl:choose>)</xsl:if>
                <xsl:if test="$item/s != 0"><xsl:copy-of select="$separator" /><xsl:choose><xsl:when test="$item/type = 'drug2'">Рейтинг урона</xsl:when><xsl:otherwise>Сила</xsl:otherwise></xsl:choose>: <xsl:if test="$item/s > 0">+</xsl:if><xsl:choose><xsl:when test="$item/s &lt;= 0.1 and $item/s >= -0.1"><xsl:value-of select="$item/s * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/s" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/dexterity != 0"><xsl:copy-of select="$separator" /><xsl:choose><xsl:when test="$item/type = 'drug2'">Рейтинг точности</xsl:when><xsl:otherwise>Ловкость</xsl:otherwise></xsl:choose>: <xsl:if test="$item/dexterity > 0">+</xsl:if><xsl:choose><xsl:when test="$item/dexterity &lt;= 0.1 and $item/dexterity >= -0.1"><xsl:value-of select="$item/dexterity * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/dexterity" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/dexterity2 != 0">&#0160;(до +<xsl:choose><xsl:when test="$item/dexterity2 &lt;= 0.1 and $item/dexterity2 >= -0.1"><xsl:value-of select="$item/dexterity2 * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/dexterity2" /></xsl:otherwise></xsl:choose>)</xsl:if>
                <xsl:if test="$item/d != 0"><xsl:copy-of select="$separator" /><xsl:choose><xsl:when test="$item/type = 'drug2'">Рейтинг точности</xsl:when><xsl:otherwise>Ловкость</xsl:otherwise></xsl:choose>: <xsl:if test="$item/d > 0">+</xsl:if><xsl:choose><xsl:when test="$item/d &lt;= 0.1 and $item/d >= -0.1"><xsl:value-of select="$item/d * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/d" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/intuition != 0"><xsl:copy-of select="$separator" /><xsl:choose><xsl:when test="$item/type = 'drug2'">Рейтинг критических ударов</xsl:when><xsl:otherwise>Хитрость</xsl:otherwise></xsl:choose>: <xsl:if test="$item/intuition > 0">+</xsl:if><xsl:choose><xsl:when test="$item/intuition &lt;= 0.1 and $item/intuition >= -0.1"><xsl:value-of select="$item/intuition * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/intuition" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/intuition2 != 0">&#0160;(до +<xsl:choose><xsl:when test="$item/intuition2 &lt;= 0.1 and $item/intuition2 >= -0.1"><xsl:value-of select="$item/intuition2 * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/intuition2" /></xsl:otherwise></xsl:choose>)</xsl:if>
                <xsl:if test="$item/i != 0"><xsl:copy-of select="$separator" /><xsl:choose><xsl:when test="$item/type = 'drug2'">Рейтинг критических ударов</xsl:when><xsl:otherwise>Хитрость</xsl:otherwise></xsl:choose>: <xsl:if test="$item/i > 0">+</xsl:if><xsl:choose><xsl:when test="$item/i &lt;= 0.1 and $item/i >= -0.1"><xsl:value-of select="$item/i * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/i" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/attention != 0"><xsl:copy-of select="$separator" /><xsl:choose><xsl:when test="$item/type = 'drug2'">Рейтинг уворота</xsl:when><xsl:otherwise>Внимательность</xsl:otherwise></xsl:choose>: <xsl:if test="$item/attention > 0">+</xsl:if><xsl:choose><xsl:when test="$item/attention &lt;= 0.1 and $item/attention >= -0.1"><xsl:value-of select="$item/attention * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/attention" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/attention2 != 0">&#0160;(до +<xsl:choose><xsl:when test="$item/attention2 &lt;= 0.1 and $item/attention2 >= -0.1"><xsl:value-of select="$item/attention2 * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/attention2" /></xsl:otherwise></xsl:choose>)</xsl:if>
                <xsl:if test="$item/a != 0"><xsl:copy-of select="$separator" /><xsl:choose><xsl:when test="$item/type = 'drug2'">Рейтинг уворота</xsl:when><xsl:otherwise>Внимательность</xsl:otherwise></xsl:choose>: <xsl:if test="$item/a > 0">+</xsl:if><xsl:choose><xsl:when test="$item/a &lt;= 0.1 and $item/a >= -0.1"><xsl:value-of select="$item/a * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/a" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/resistance != 0"><xsl:copy-of select="$separator" /><xsl:choose><xsl:when test="$item/type = 'drug2'">Рейтинг стойкости</xsl:when><xsl:otherwise>Выносливость</xsl:otherwise></xsl:choose>: <xsl:if test="$item/resistance > 0">+</xsl:if><xsl:choose><xsl:when test="$item/resistance &lt;= 0.1 and $item/resistance >= -0.1"><xsl:value-of select="$item/resistance * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/resistance" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/resistance2 != 0">&#0160;(до +<xsl:choose><xsl:when test="$item/resistance2 &lt;= 0.1 and $item/resistance2 >= -0.1"><xsl:value-of select="$item/resistance2 * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/resistance2" /></xsl:otherwise></xsl:choose>)</xsl:if>
                <xsl:if test="$item/r != 0"><xsl:copy-of select="$separator" /><xsl:choose><xsl:when test="$item/type = 'drug2'">Рейтинг защиты</xsl:when><xsl:otherwise>Выносливость</xsl:otherwise></xsl:choose>: <xsl:if test="$item/r > 0">+</xsl:if><xsl:choose><xsl:when test="$item/r &lt;= 0.1 and $item/r >= -0.1"><xsl:value-of select="$item/r * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/r" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/charism != 0"><xsl:copy-of select="$separator" /><xsl:choose><xsl:when test="$item/type = 'drug2'">Рейтинг защиты от критических ударов</xsl:when><xsl:otherwise>Харизма</xsl:otherwise></xsl:choose>: <xsl:if test="$item/charism > 0">+</xsl:if><xsl:choose><xsl:when test="$item/charism &lt;= 0.1 and $item/charism >= -1"><xsl:value-of select="$item/charism * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/charism" /></xsl:otherwise></xsl:choose></xsl:if>
                    <xsl:if test="$item/charism2 != 0">&#0160;(до +<xsl:choose><xsl:when test="$item/charism2 &lt;= 0.1 and $item/charism2 >= -0.1"><xsl:value-of select="$item/charism2 * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/charism2" /></xsl:otherwise></xsl:choose>)</xsl:if>
                <xsl:if test="$item/c != 0"><xsl:copy-of select="$separator" /><xsl:choose><xsl:when test="$item/type = 'drug2'">Рейтинг защиты от критических ударов</xsl:when><xsl:otherwise>Харизма</xsl:otherwise></xsl:choose>: <xsl:if test="$item/c > 0">+</xsl:if><xsl:choose><xsl:when test="$item/c &lt;= 0.1 and $item/c >= -1"><xsl:value-of select="$item/c * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/c" /></xsl:otherwise></xsl:choose></xsl:if>

                <xsl:if test="$item/type = 'home_defence'"><xsl:copy-of select="$separator" />Защита дома: <xsl:if test="$item/itemlevel > 0">+</xsl:if><xsl:choose><xsl:when test="$item/itemlevel &lt;= 0.1 and $item/itemlevel >= -0.1"><xsl:value-of select="$item/itemlevel * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/itemlevel" /></xsl:otherwise></xsl:choose></xsl:if>
                <xsl:if test="$item/type = 'home_comfort'"><xsl:copy-of select="$separator" />Комфорт дома: <xsl:if test="$item/itemlevel > 0">+</xsl:if><xsl:choose><xsl:when test="$item/itemlevel &lt;= 0.1 and $item/itemlevel >= -0.1"><xsl:value-of select="$item/itemlevel * 1000" />%</xsl:when><xsl:otherwise><xsl:value-of select="$item/itemlevel" /></xsl:otherwise></xsl:choose></xsl:if>

                    <xsl:if test="$item/special1 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/special1name" />: <xsl:value-of select="$item/special1before" /><xsl:value-of select="$item/special1" /><xsl:value-of select="$item/special1after" /></xsl:if>
                <xsl:if test="$item/sp1 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/sp1n" />: <xsl:value-of select="$item/sp1b" /><xsl:value-of select="$item/sp1" /><xsl:value-of select="$item/sp1a" /></xsl:if>
                    <xsl:if test="$item/special2 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/special2name" />: <xsl:value-of select="$item/special2before" /><xsl:value-of select="$item/special2" /><xsl:value-of select="$item/special2after" /></xsl:if>
                <xsl:if test="$item/sp2 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/sp2n" />: <xsl:value-of select="$item/sp2b" /><xsl:value-of select="$item/sp2" /><xsl:value-of select="$item/sp2a" /></xsl:if>
                    <xsl:if test="$item/special3 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/special3name" />: <xsl:value-of select="$item/special3before" /><xsl:value-of select="$item/special3" /><xsl:value-of select="$item/special3after" /></xsl:if>
                <xsl:if test="$item/sp3 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/sp3n" />: <xsl:value-of select="$item/sp3b" /><xsl:value-of select="$item/sp3" /><xsl:value-of select="$item/sp3a" /></xsl:if>
                    <xsl:if test="$item/special4 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/special4name" />: <xsl:value-of select="$item/special4before" /><xsl:value-of select="$item/special4" /><xsl:value-of select="$item/special4after" /></xsl:if>
                <xsl:if test="$item/sp4 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/sp4n" />: <xsl:value-of select="$item/sp4b" /><xsl:value-of select="$item/sp4" /><xsl:value-of select="$item/sp4a" /></xsl:if>
                    <xsl:if test="$item/special5 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/special5name" />: <xsl:value-of select="$item/special5before" /><xsl:value-of select="$item/special5" /><xsl:value-of select="$item/special5after" /></xsl:if>
                <xsl:if test="$item/sp5 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/sp5n" />: <xsl:value-of select="$item/sp5b" /><xsl:value-of select="$item/sp5" /><xsl:value-of select="$item/sp5a" /></xsl:if>
                    <xsl:if test="$item/special6 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/special6name" />: <xsl:value-of select="$item/special6before" /><xsl:value-of select="$item/special6" /><xsl:value-of select="$item/special6after" /></xsl:if>
                <xsl:if test="$item/sp6 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/sp6n" />: <xsl:value-of select="$item/sp6b" /><xsl:value-of select="$item/sp6" /><xsl:value-of select="$item/sp6a" /></xsl:if>
                    <xsl:if test="$item/special7 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/special7name" />: <xsl:value-of select="$item/special7before" /><xsl:value-of select="$item/special7" /><xsl:value-of select="$item/special7after" /></xsl:if>
                <xsl:if test="$item/sp7 != ''"><xsl:copy-of select="$separator" /><xsl:value-of select="$item/sp7n" />: <xsl:value-of select="$item/sp7b" /><xsl:value-of select="$item/sp7" /><xsl:value-of select="$item/sp7a" /></xsl:if>

                <xsl:if test="$item/time != '' and $item/subtype != 'award'"><xsl:copy-of select="$separator" />Время действия: <xsl:value-of select="$item/time" /></xsl:if>

                <xsl:if test="$item/ratingdamage != 0"><xsl:copy-of select="$separator" />Рейтинг урона: +<xsl:value-of select="$item/ratingdamage" /></xsl:if>
                    <xsl:if test="$item/rdm != 0"><xsl:copy-of select="$separator" />Рейтинг урона: +<xsl:value-of select="$item/rdm" /></xsl:if>
                <xsl:if test="$item/ratingaccur != 0"><xsl:copy-of select="$separator" />Рейтинг точности: +<xsl:value-of select="$item/ratingaccur" /></xsl:if>
                    <xsl:if test="$item/ra != 0"><xsl:copy-of select="$separator" />Рейтинг точности: +<xsl:value-of select="$item/ra" /></xsl:if>
                <xsl:if test="$item/ratingcrit != 0"><xsl:copy-of select="$separator" />Рейтинг критических ударов: +<xsl:value-of select="$item/ratingcrit" /></xsl:if>
                    <xsl:if test="$item/rc != 0"><xsl:copy-of select="$separator" />Рейтинг критических ударов: +<xsl:value-of select="$item/rc" /></xsl:if>
                <xsl:if test="$item/ratingdodge != 0"><xsl:copy-of select="$separator" />Рейтинг уворота: +<xsl:value-of select="$item/ratingdodge" /></xsl:if>
                    <xsl:if test="$item/rd != 0"><xsl:copy-of select="$separator" />Рейтинг уворота: +<xsl:value-of select="$item/rd" /></xsl:if>
                <xsl:if test="$item/ratingresist != 0"><xsl:copy-of select="$separator" />Рейтинг защиты: +<xsl:value-of select="$item/ratingresist" /></xsl:if>
                    <xsl:if test="$item/rr != 0"><xsl:copy-of select="$separator" />Рейтинг защиты: +<xsl:value-of select="$item/rr" /></xsl:if>
                <xsl:if test="$item/ratinganticrit != 0"><xsl:copy-of select="$separator" />Рейтинг защиты от критических ударов: +<xsl:value-of select="$item/ratinganticrit" /></xsl:if>
                    <xsl:if test="$item/rac != 0"><xsl:copy-of select="$separator" />Рейтинг защиты от критических ударов: +<xsl:value-of select="$item/rac" /></xsl:if>
                <xsl:if test="$item/ratingrandom != 0"><xsl:copy-of select="$separator" />Случайный рейтинг: +<xsl:value-of select="$item/ratingrandom" /></xsl:if>

                <xsl:if test="$item/code = 'ctf_flag'"><xsl:copy-of select="$separator" />Отнят у: <xsl:value-of select="$item/player_from" /></xsl:if>
                <xsl:if test="$item/code = 'clan_founder_crown'"><xsl:copy-of select="$separator" />Клан основан: <xsl:value-of select="giftdate" /> в <xsl:value-of select="gifttime" /></xsl:if>

                <xsl:if test="$item/subtype = 'gift' and $item/giftdate != ''"><xsl:copy-of select="$separator" />Подарен: <xsl:value-of select="$item/giftdate" />&#0160;<xsl:value-of select="$item/gifttime" /></xsl:if>
                <xsl:if test="$item/endtime != ''"><xsl:copy-of select="$separator" />Годен до: <xsl:value-of select="$item/enddate" />&#160;<xsl:value-of select="$item/endtime" /></xsl:if>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

</xsl:stylesheet>
