<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/clanlink.xsl" />
    <xsl:include href="common/paginator.xsl" />
    <xsl:include href="common/clan-error.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    Амбарная книга
                </h2></div>
                <div id="content" class="clan">

                    <div class="block-bordered">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <h3></h3>
                            <div class="clan-store-logs phone">
                                <!--p>К сожалению или счастью, сторож склада страдает бессонницей, и записывает всех, кто приходит на склад и отоваривается.</p-->
                                <table class="messages-list">
                                    <xsl:choose>
                                        <xsl:when test="count(log/element) > 0">
                                            <xsl:for-each select="log/element">
                                                <tr>
                                                    <td class="date">
                                                        <xsl:value-of select="dt" />
                                                    </td>
                                                    <td class="text">
                                                        <xsl:if test="count(params/p) > 0">
                                                        <xsl:call-template name="playerlink">
                                                            <xsl:with-param name="player" select="params/p" />
                                                        </xsl:call-template> &#0160; </xsl:if><xsl:choose>
															<xsl:when test="action = 'chgr'">изменяет&#0160;<xsl:choose>
																	<xsl:when test="params/n=1 and params/i=1 and params/l=1">название клана, клановые иконку и логотип</xsl:when>
																	<xsl:when test="params/n=1 and params/i=1">название клана и клановую иконку</xsl:when>
																	<xsl:when test="params/n=1 and params/l=1">название клана и клановый логотип</xsl:when>
																	<xsl:when test="params/i=1 and params/l=1">клановые иконку и логотип</xsl:when>
																	<xsl:when test="params/n=1">название клана</xsl:when>
																	<xsl:when test="params/i=1">клановую иконку</xsl:when>
																	<xsl:when test="params/l=1">клановый логотип</xsl:when>
																</xsl:choose>&#0160;за <span class="tugriki"><xsl:value-of select="params/m" /><i></i></span><span class="med"><xsl:value-of select="params/h" /><i></i></span>.</xsl:when>
                                                            <xsl:when test="action = 'take'">берет со склада <b><xsl:value-of select="params/i" /></b>.</xsl:when>
                                                            <xsl:when test="action = 'put'">возвращает на склад <b><xsl:value-of select="params/i" /></b>.</xsl:when>
                                                            <xsl:when test="action = 'upgr'">покупает улучшение <b><xsl:value-of select="params/i/n" /></b> за <xsl:if test="params/i/m > 0"><span class="tugriki"><xsl:value-of select="params/i/m" /><i></i></span></xsl:if> <xsl:if test="params/i/o > 0"><span class="ruda"><xsl:value-of select="params/i/o" /><i></i></span></xsl:if> <xsl:if test="params/i/h > 0"><span class="med"><xsl:value-of select="params/i/h" /><i></i></span></xsl:if>.</xsl:when>
                                                            <xsl:when test="action = 'buy'">покупает <b><xsl:value-of select="params/i/n" /></b><xsl:if test="params/i/a > 1"> (<xsl:value-of select="params/i/a" /> шт.)</xsl:if> за <xsl:if test="params/i/m > 0"><span class="tugriki"><xsl:value-of select="params/i/m" /><i></i></span></xsl:if> <xsl:if test="params/i/o > 0"><span class="ruda"><xsl:value-of select="params/i/o" /><i></i></span></xsl:if> <xsl:if test="params/i/h > 0"><span class="med"><xsl:value-of select="params/i/h" /><i></i></span></xsl:if>.</xsl:when>
                                                            <xsl:when test="action = 'dpst'">вносит в казну клана <xsl:if test="params/m > 0"><span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span></xsl:if> <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="format-number(params/o, '###,###')" /><i></i></span></xsl:if> <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="format-number(params/h, '###,###')" /><i></i></span></xsl:if>.</xsl:when>
                                                            <xsl:when test="action = 'offc'">расширяет штаб клана за <xsl:if test="params/m > 0"><span class="tugriki"><xsl:value-of select="params/m" /><i></i></span></xsl:if> <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if> <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>. Теперь мест в клане: <b><xsl:value-of select="params/mp" /></b>.</xsl:when>

                                                            <xsl:when test="action = 'leav'">покидает клан.</xsl:when>
                                                            <xsl:when test="action = 'japl'">подает заявку на вступление в наш клан.</xsl:when>
                                                            <xsl:when test="action = 'japc'">отзывает заявку на вступление в наш клан.</xsl:when>
                                                            <xsl:when test="action = 'jrfs'">отказывает игроку <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/p2" /></xsl:call-template> во вступлении в клан.</xsl:when>
                                                            <xsl:when test="action = 'jacp'">принимает игрока <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/p2" /></xsl:call-template> в клан.</xsl:when>
                                                            <xsl:when test="action = 'jdrp'">выгоняет игрока <xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/p2" /></xsl:call-template> из клана.</xsl:when>

															<xsl:when test="action = 'rest'">берет отпуск для клана на неделю.<xsl:if test="count(params/l)">&#0160;Уровень клана падает до <xsl:value-of select="params/l" />.</xsl:if></xsl:when>

                                                            <xsl:when test="action = 'bst'">придает всем кланерам заряд бодрости на <xsl:value-of select="params/h" /> ч.
                                                                стоимостью <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span>:<br />
                                                                <xsl:for-each select="params/b/element">
                                                                    <xsl:choose>
                                                                        <xsl:when test="c = 'ra'">Рейтинг точности</xsl:when>
                                                                        <xsl:when test="c = 'rdm'">Рейтинг урона</xsl:when>
                                                                        <xsl:when test="c = 'rc'">Рейтинг критических ударов</xsl:when>
                                                                        <xsl:when test="c = 'rd'">Рейтинг уворота</xsl:when>
                                                                        <xsl:when test="c = 'rr'">Рейтинг защиты</xsl:when>
                                                                        <xsl:when test="c = 'rac'">Рейтинг защиты от крит. ударов</xsl:when>
                                                                    </xsl:choose>: +<xsl:value-of select="v" />
                                                                    <xsl:if test="position() != last()"><br /></xsl:if>
                                                                </xsl:for-each>
                                                            </xsl:when>

                                                            <xsl:when test="action = 'tmsr'">
                                                                проводит кадровые перестановки в клане:
                                                                <xsl:if test="count(params/r/fr0) != 0"><br /><xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/r/fr0" /></xsl:call-template> снимается с должности <b>Глава клана</b></xsl:if>
                                                                <xsl:if test="count(params/r/fr1) != 0"><br /><xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/r/fr1" /></xsl:call-template> назначается на должность <b>Глава клана</b></xsl:if>
                                                                <xsl:if test="count(params/r/ad0) != 0"><br /><xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/r/ad0" /></xsl:call-template> снимается с должности <b>Заместитель главы клана</b></xsl:if>
                                                                <xsl:if test="count(params/r/ad1) != 0"><br /><xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/r/ad1" /></xsl:call-template> назначается на должность <b>Заместитель главы клана</b></xsl:if>
                                                                <xsl:if test="count(params/r/dp0) != 0"><br /><xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/r/dp0" /></xsl:call-template> снимается с должности <b>Дипломат</b></xsl:if>
                                                                <xsl:if test="count(params/r/dp1) != 0"><br /><xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/r/dp1" /></xsl:call-template> назначается на должность <b>Дипломат</b></xsl:if>
                                                                <xsl:if test="count(params/r/mn0) != 0"><br /><xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/r/mn0" /></xsl:call-template> снимается с должности <b>Казначей</b></xsl:if>
                                                                <xsl:if test="count(params/r/mn1) != 0"><br /><xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/r/mn1" /></xsl:call-template> назначается на должность <b>Казначей</b></xsl:if>
                                                                <xsl:if test="count(params/r/fm0) != 0"><br /><xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/r/fm0" /></xsl:call-template> снимается с должности <b>Модератор</b></xsl:if>
                                                                <xsl:if test="count(params/r/fm1) != 0"><br /><xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/r/fm1" /></xsl:call-template> назначается на должность <b>Модератор</b></xsl:if>
                                                                <xsl:if test="count(params/r/pp0) != 0"><br /><xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/r/pp0" /></xsl:call-template> снимается с должности <b>Кадровик</b></xsl:if>
                                                                <xsl:if test="count(params/r/pp1) != 0"><br /><xsl:call-template name="playerlink"><xsl:with-param name="player" select="params/r/pp1" /></xsl:call-template> назначается на должность <b>Кадровик</b></xsl:if>
                                                                <br />Всего на кадровые перестановки потрачено: <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###,###')" /><i></i></span>.
                                                            </xsl:when>
                                                            <xsl:when test="action = 'tmct'">
                                                                отказывается от должности <b><xsl:choose>
                                                                    <xsl:when test="params/r = 'adviser'">Заместитель главы клана</xsl:when>
                                                                    <xsl:when test="params/r = 'money'">Казначей</xsl:when>
                                                                    <xsl:when test="params/r = 'diplomat'">Дипломат</xsl:when>
                                                                    <xsl:when test="params/r = 'people'">Кадровик</xsl:when>
                                                                    <xsl:when test="params/r = 'forum'">Модератор</xsl:when>
                                                                </xsl:choose></b>, потратив на это <span class="tugriki"><xsl:value-of select="format-number(params/m, '###,###')" /><i></i></span> из казны клана.
                                                            </xsl:when>

                                                            <xsl:when test="action = 'duc'">разрывает союз с кланом <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template>.</xsl:when>
                                                            <xsl:when test="action = 'duc2'">от лица клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> разрывает союз с нашим кланом.</xsl:when>
                                                            <xsl:when test="action = 'dua'">принимает предложение клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> заключить союз, потратив на это <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if> <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.</xsl:when>
                                                            <xsl:when test="action = 'dua2'">от лица клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> принимает предложение нашего клана заключить союз.</xsl:when>
                                                            <xsl:when test="action = 'dud'">отвергает предложение клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> заключить союз.</xsl:when>
                                                            <xsl:when test="action = 'dud2'">от лица клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> отвергает предложение нашего клана заключить союз.</xsl:when>
                                                            <xsl:when test="action = 'dup'">предлагает клану <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> заключить союз, потратив на это <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if> <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.</xsl:when>
                                                            <xsl:when test="action = 'dup2'">от лица клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> предлагает нашему клану заключить союз.</xsl:when>
                                                            <xsl:when test="action = 'dupc'">отзывает предложение клану <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> заключить союз.</xsl:when>
                                                            <xsl:when test="action = 'dupc2'">от лица клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> отзывает предложение нашему клану заключить союз.</xsl:when>

                                                            <xsl:when test="action = 'wa'">объявляет войну клану <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template>, потратив на это <xsl:if test="params/m > 0"><span class="tugriki"><xsl:value-of select="params/m" /><i></i></span></xsl:if> <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if> <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.<br />В случае победы наш клан получит <xsl:if test="params/m2 > 0"><span class="tugriki"><xsl:value-of select="params/m2" /><i></i></span></xsl:if> <xsl:if test="params/o2 > 0"><span class="ruda"><xsl:value-of select="params/o2" /><i></i></span></xsl:if> <xsl:if test="params/h2 > 0"><span class="med"><xsl:value-of select="params/h2" /><i></i></span></xsl:if>.<br />В случае поражения наш клан потеряет <xsl:if test="params/m3 > 0"><span class="tugriki"><xsl:value-of select="params/m3" /><i></i></span></xsl:if> <xsl:if test="params/o3 > 0"><span class="ruda"><xsl:value-of select="params/o3" /><i></i></span></xsl:if> <xsl:if test="params/h3 > 0"><span class="med"><xsl:value-of select="params/h3" /><i></i></span></xsl:if>.</xsl:when>
                                                            <xsl:when test="action = 'wa2'">от лица клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> объявляет войну нашему клану.<br />В случае поражения наш клан потеряет <xsl:if test="params/m > 0"><span class="tugriki"><xsl:value-of select="params/m" /><i></i></span></xsl:if> <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if> <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.<br />В случае победы наш клан получит <xsl:if test="params/m2 > 0"><span class="tugriki"><xsl:value-of select="params/m2" /><i></i></span></xsl:if> <xsl:if test="params/o2 > 0"><span class="ruda"><xsl:value-of select="params/o2" /><i></i></span></xsl:if> <xsl:if test="params/h2 > 0"><span class="med"><xsl:value-of select="params/h2" /><i></i></span></xsl:if>.</xsl:when>
                                                            <xsl:when test="action = 'waa'">вступает в войну против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> на стороне союзного клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c2" /></xsl:call-template>.</xsl:when>
                                                            <xsl:when test="action = 'waa2'">от лица клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> вступает в войну против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c2" /></xsl:call-template> на стороне нашего клана.</xsl:when>
                                                            <xsl:when test="action = 'wapa'">от лица нашего клана вступает в войну против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> на стороне клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c2" /></xsl:call-template>.</xsl:when>
                                                            <xsl:when test="action = 'wapa2'">от лица клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> вступает в войну против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c2" /></xsl:call-template> на стороне нашего клана.</xsl:when>
                                                            <xsl:when test="action = 'wapa3'">от лица клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> вступает в войну против нашего клана на стороне клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c2" /></xsl:call-template>.</xsl:when>
                                                            <xsl:when test="action = 'wapd'">отказывается вступить в войну против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> на стороне клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c2" /></xsl:call-template>.</xsl:when>
                                                            <xsl:when test="action = 'wapd2'">от лица клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> отказывается вступить в войну против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c2" /></xsl:call-template> на стороне нашего клана.</xsl:when>
                                                            <xsl:when test="action = 'ww'">приводит свой клан к победе в войне против клана <nobr><xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template></nobr>, обогатив при этом казну своего клана на <xsl:if test="params/m > 0"><span class="tugriki"><xsl:value-of select="params/m" /><i></i></span></xsl:if> <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if> <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.</xsl:when>
                                                            <xsl:when test="action = 'ww2'">Война против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> выиграна.</xsl:when>
                                                            <xsl:when test="action = 'wf'">Война против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> проиграна. Казна лишилась <xsl:if test="params/m > 0"><span class="tugriki"><xsl:value-of select="params/m" /><i></i></span></xsl:if> <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if> <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.<xsl:if test="params/dstr != ''"><br />Во время грабежей и мародерства в нашем клановом штабе было уничтожено улучшение <b><xsl:value-of select="params/dstr" /></b>.</xsl:if></xsl:when>
                                                            <xsl:when test="action = 'wf2'">Война против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> проиграна.</xsl:when>
                                                            <xsl:when test="action = 'wea'">Война против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> завершается вничью. Потеряно <xsl:if test="params/m > 0"><span class="tugriki"><xsl:value-of select="params/m" /><i></i></span></xsl:if> <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if> <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.</xsl:when>
                                                            <xsl:when test="action = 'wed'">Война против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> завершается вничью. Получено <xsl:if test="params/m > 0"><span class="tugriki"><xsl:value-of select="params/m" /><i></i></span></xsl:if> <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if> <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.</xsl:when>
                                                            <xsl:when test="action = 'we2'">Война против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> завершается вничью.</xsl:when>
                                                            <xsl:when test="action = 'ws1'">Война против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> переходит в <a href="/faq/war/#step1">первую фазу</a>.</xsl:when>
                                                            <xsl:when test="action = 'ws2'">Война против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> переходит во <a href="/faq/war/#step2">вторую фазу</a>.</xsl:when>
                                                            <xsl:when test="action = 'wsr'"> капитулирует в войне против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template>.</xsl:when>
                                                            <xsl:when test="action = 'dstr'">Во время грабежей вражеского штаба вы уничтожили улучшение <b><xsl:value-of select="params/dstr" /></b>, за что получили <xsl:if test="params/m > 0"><span class="tugriki"><xsl:value-of select="params/m" /><i></i></span></xsl:if> <xsl:if test="params/o > 0"><span class="ruda"><xsl:value-of select="params/o" /><i></i></span></xsl:if> <xsl:if test="params/h > 0"><span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:if>.</xsl:when>
                                                            <xsl:when test="action = 'wx'">от лица клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c" /></xsl:call-template> выходит из войны клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c1" /></xsl:call-template> против клана <xsl:call-template name="clanlink"><xsl:with-param name="clan" select="params/c2" /></xsl:call-template>.</xsl:when>
															<xsl:when test="action = 'dcrs3w'">Молодежь постепенно забывает о былых заслугах Вашего клана. Очередной приступ амнезии затер в их памяти некоторые важные моменты.</xsl:when>
															<xsl:when test="action = 'hire_detective'">нанял детектива за <span class="med"><xsl:value-of select="params/h" /><i></i></span></xsl:when>
                                                        </xsl:choose>
														<xsl:if test="count(params/pts) and params/pts != 0">
															Ваш клан
															<xsl:choose>
																<xsl:when test="params/pts &lt; 0">теряет <xsl:value-of select="params/pts * -1" /></xsl:when>
																<xsl:when test="params/pts > 0">получает <xsl:value-of select="params/pts" /></xsl:when>
															</xsl:choose>&#0160;<xsl:value-of select="params/pts_word" />.
														</xsl:if>
                                                    </td>
                                                    <td class="actions">
                                                        <xsl:call-template name="warstatsbutton"><xsl:with-param name="diplomacy" select="params/d" /></xsl:call-template>
                                                    </td>
                                                </tr>
                                            </xsl:for-each>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <p>На складе тихо и спокойно. И коробки на полках покрыты толстым слоем пыли.</p>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </table>

                                <xsl:call-template name="paginator">
                                    <xsl:with-param name="pages" select="pages" />
                                    <xsl:with-param name="page" select="page" />
                                    <xsl:with-param name="link" select="'/clan/profile/logs/'" />
                                </xsl:call-template>
                            </div>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                </div>
            </div>
        </div>
	</xsl:template>

    <xsl:template name="warstatsbutton">
        <xsl:param name="diplomacy" />
        <xsl:if test="$diplomacy > 0">
            <span class="button">
                <a class="f" href="/clan/warstats/{$diplomacy}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                    <div class="c">Статистика</div>
                </a>
            </span>
        </xsl:if>
    </xsl:template>

</xsl:stylesheet>
