<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl" version="1.0">
    <xsl:output method="html"/>

	<xsl:include href="common/price.xsl" />

    <xsl:template match="/data">
	<div class="column-right-topbg">
	    <div class="column-right-bottombg" align="center">
		<div class="heading clear">
		    <h2>
			<span class="police"></span>
		    </h2>
		</div>
		<div id="content" class="police">

		    <div class="welcome">
				<div class="block-rounded">
					<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
					<div class="text">
						<xsl:choose>
							<xsl:when test="player/state = 'police' and player/timer > unixtime">
								— В нашем городе не принято баклашить. Потусуй-ка в аквариуме.<br /><br />
								<b>Вас задержали за драки и отпустят через:
									<xsl:element name="span">
										<xsl:attribute name="class">timer</xsl:attribute>
										<xsl:attribute name="timer"><xsl:value-of select="player/timer - unixtime" /></xsl:attribute>
									</xsl:element>
								</b>
							</xsl:when>
						    <xsl:otherwise>
								Милиция следит за беспорядками в городе и укрощает пыл самых ретивых буянов.
							</xsl:otherwise>
						</xsl:choose>
					</div>
				</div>
		    </div>

			<xsl:call-template name="error">
				<xsl:with-param name="result" select="result" />
			</xsl:call-template>
            
			<script src="/@/js/index.js"></script>
		    <table>
                <tr>
                    <td style="width:50%; padding:0 5px 0 0;">
                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>Сменить имя</h3>
                                <form class="police-rename" action="/police/passport/" method="post">
                                    <input type="hidden" name="action" value="change_nickname" />
                                    <p>Иногда вам кажется, что вы носите не свое имя. Так почему бы его не поменять?</p>

                                    <table class="forms">
                                        <tr>
                                            <td class="label"><nobr>Новое имя</nobr></td>
                                            <td class="input"><input type="text" maxlength="20" name="nickname" /></td>
                                        </tr>
                                    </table>
                                    <p>Не пытайтесь скрыться от преследователей с помощью смены имени. Вас смогут вычислить по рейтингам, девизу, подаркам и т. д.</p>

									<div align="center">
                                        <button class="button" type="submit">
                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                <div class="c">
													<xsl:choose>
														<xsl:when test="cert_changenickname = 1">
															Сменить имя бесплатно сертификатом
														</xsl:when>
														<xsl:otherwise>
															Сменить имя - <span class="med">100<i></i></span>
														</xsl:otherwise>
													</xsl:choose>
												</div>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </td>
                    <td style="width:50%; padding:0 0 0 5px;">
                        <div class="block-bordered">
                            <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                            <div class="center clear">
                                <h3>Сменить прописку и аватар</h3>

                                <form class="police-rename" action="/police/passport/" method="post" onsubmit="return checkConfirm();">
                                    <input type="hidden" name="action" value="change_avatar" />
                                    <input type="hidden" name="avatar" value="{player/avatar}" />
                                    <input type="hidden" name="background" value="{player/background}" />
                                <table class="layout avatar-change forms">
                                    <tr>
                                        <td class="label">Выберите сторону</td>
                                        <td class="input" colspan="2" style="text-align:left; font-weight:bold;">
                                            <input onclick="updatePrice();changeSide();" type="radio" name="side" id="registration-side-resident" value="resident" style="vertical-align:bottom;"><xsl:if test="(player/clan > 0 and player/fraction = 'arrived') or sovet = 1"><xsl:attribute name="disabled" value="disabled" /></xsl:if><xsl:if test="player/fraction = 'resident'"><xsl:attribute name="checked" value="checked" /></xsl:if></input><label for="registration-side-resident"><i class="resident"></i>Коренной столичник</label><br />
                                            <input onclick="updatePrice();changeSide();" type="radio" name="side" id="registration-side-arrived" value="arrived" style="vertical-align:bottom;"><xsl:if test="(player/clan > 0 and player/fraction = 'resident') or sovet = 1"><xsl:attribute name="disabled" value="disabled" /></xsl:if><xsl:if test="player/fraction = 'arrived'"><xsl:attribute name="checked" value="checked" /></xsl:if></input><label for="registration-side-arrived"><i class="arrived"></i>Понаехавший захватчик</label>
                                            <xsl:if test="player/clan > 0 and player/fraction = 'resident'">
                                                <div class="hint">Вы не можете поменять прописку пока находитесь в клане Коренных.</div>
                                            </xsl:if>
                                            <xsl:if test="player/clan > 0 and player/fraction = 'arrived'">
                                                <div class="hint">Вы не можете поменять прописку пока находитесь в клане Понаехавших.</div>
                                            </xsl:if>
                                            <xsl:if test="sovet = 1">
                                                <div class="hint">Вы не можете поменять прописку пока являетесь членом Совета.</div>
                                            </xsl:if>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><div id="pers-arrow-1"></div></td>
                                        <td rowspan="2" class="pers">
                                            <div id="avatar-back" class="{player/background}"><img src="/@/images/pers/{php:function('str_replace', '.png', '', string(player/avatar))}_eyes.gif" style="background:url(/@/images/pers/{player/avatar})" /></div>
                                        </td>
                                        <td><div id="pers-arrow-2"></div></td>
                                    </tr>
                                    <tr>
                                        <td><div id="pers-arrow-3"></div></td>
                                        <td><div id="pers-arrow-4"></div></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="gender"><div id="avatar-gender">Пол: <xsl:choose><xsl:when test="player/sex='male'">мужской</xsl:when><xsl:otherwise>женский</xsl:otherwise></xsl:choose></div></td>
                                    </tr>
                                </table>

                                <script type="text/javascript">
                                    var avatarImages_current = <xsl:value-of select="avatar" />;
                                    var avatarBackgrounds_current = <xsl:value-of select="background" />;
                                    function updatePrice() {
                                        if ($('input[name=side]:checked').val() == '<xsl:value-of select="player/fraction" />') {
                                            $('#price').html('100<i></i>');
                                        } else {
                                            $('#price').html('200<i></i>');
                                        }
                                    }
                                    function checkConfirm() {
                                        if ($('input[name=side]:checked').val() != '<xsl:value-of select="player/fraction" />') {
                                            return confirm('Вы уверены, что хотите перейти на другую сторону?');
                                        }
                                        return true;
                                    }
                                </script>

                                    <div align="center">
                                        <button class="button" type="submit">
                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                <div class="c">Сменить аватар/пол - <span class="med" id="price">100<i></i></span></div>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                        </div>
                    </td>
                </tr>
            </table>

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
			<xsl:when test="$result/result = 0 and $result/error = 'no money'"><p class="error" align="center">У вас не хватает денег.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'police passport' and $result/action = 'change avatar' and $result/error = 'same avatar and background'"><p class="error" align="center">Вы выбрали тот же самый аватар.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'police passport' and $result/action = 'change nickname' and $result/error = 'nickname exists'"><p class="error" align="center">Так зовут другого игрока, Вы не может взять себе такое же имя.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'police passport' and $result/action = 'change nickname' and $result/error = 'bad nickname'"><p class="error" align="center">Вы не можете выбрать себе такое имя.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'police passport' and $result/action = 'change nickname' and $result/error = 'same nickname'"><p class="error" align="center">Сейчас вас зовут так же.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'police passport' and $result/action = 'change avatar' and $result/error = 'you are in sovet'"><p class="error" align="center">Вы не можете сменить фракцию, пока находитесь в совете.</p></xsl:when>
			<!-- successes -->
			<xsl:when test="$result/result = 1 and $result/type = 'police passport' and $result/action = 'change avatar'"><p class="success" align="center">Ваш аватар успешно изменен.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'police passport' and $result/action = 'change nickname'"><p class="success" align="center">Ваше имя успешно изменено.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'police passport' and $result/action = 'change fraction'"><p class="success" align="center">Вы изменили свою прописку.</p></xsl:when>
			<xsl:otherwise><xsl:value-of select="result" /></xsl:otherwise>
        </xsl:choose>

    </xsl:template>

</xsl:stylesheet>