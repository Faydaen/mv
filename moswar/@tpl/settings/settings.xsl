<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl" version="1.0">
	<xsl:output method="html"/>
	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Настройки</h2>
				</div>
				<div id="content" class="settings">
					
					<xsl:if test="error">
						<div class="report">
							<div class="red">
								<xsl:value-of select="error" />
							</div>
						</div>
					</xsl:if>
					<xsl:if test="report">
						<div class="report">
							<div class="green">
								<xsl:value-of select="report" />
							</div>
						</div>
					</xsl:if>

					<div class="block-bordered">
						<ins class="t l">
							<ins/></ins>
						<ins class="t r">
							<ins/></ins>
						<div class="center clear">
							<h3>Анкета персонажа</h3>

							<form method="post" action="/settings/about/" >
								<table class="forms">
									<tr>
										<td class="label">Девиз:</td>
										<td class="input"><input type="text" name="slogan" maxlength="80" value="{player2/slogan}" style="width:85%;" /></td>
									</tr>
                                </table>
                                <h3>
                                    <span class="dashedlink" onclick="socialProfileFormInit();$('#social-profile').toggle();">Социальный профиль</span>
								</h3>
								<table class="forms" id="social-profile" style="display:none;">
									<tr>
										<td class="label">Имя:</td>
										<td class="input"><input type="text" name="name" maxlength="30" value="{player2/name}" style="width:50%;" /></td>
									</tr>
									<tr>
										<td class="label">Дата рождения:</td>
										<td class="input">
											<select name="day">
												<option value="day"> - день - </option>
												<xsl:value-of select="days" disable-output-escaping="yes" />
											</select> — <select name="month">
												<option value="month"> - месяц - </option>
												<xsl:value-of select="months" disable-output-escaping="yes" />
											</select> — <select name="year">
												<option value="year"> - год - </option>
												<xsl:value-of select="years" disable-output-escaping="yes" />
											</select>
										</td>
									</tr>
									<tr>
										<td class="label">О себе:</td>
										<td class="input"><textarea name="about" rows="5" style="width:85%;"><xsl:value-of select="player2/about" /></textarea></td>
									</tr>
									<tr>
										<td class="label">Страна:</td>
										<td class="input">
											<select name="country" onchange="socialProfileLoadCities();" id="country-select">
												<option value=""> - выберите - </option>
												<xsl:value-of select="countries" disable-output-escaping="yes" />
											</select>
										</td>
									</tr>
									<tr id="city-tr">
										<td class="label">Город:</td>
										<td class="input">
											<select name="city" onchange="socialProfileLoadMetros();" id="city-select">
												<option value=""> - выберите - </option>
												<xsl:value-of select="cities" disable-output-escaping="yes" />
											</select>
										</td>
									</tr>
									<tr id="metro-tr">
										<td class="label">Метро/район:</td>
										<td class="input">
											<select name="metro" id="metro-select">
												<option value=""> - выберите - </option>
												<xsl:value-of select="metros" disable-output-escaping="yes" />
											</select>
										</td>
									</tr>
									<tr>
										<td class="label">Увлечения и хобби:</td>
										<td class="input">
											<xsl:for-each select="interests/element">
												<input type="checkbox" name="interest_{id}" id="interest_{id}" value="1">
													<xsl:if test="checked = 1"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if>
												</input>
												<label for="interest_{id}"><xsl:value-of select="name" /></label>
												<xsl:if test="position() != last()"><br /></xsl:if>
											</xsl:for-each>
										</td>
									</tr>
									<tr>
										<td class="label">Семейное положение:</td>
										<td class="input">
											<select name="family">
												<option value=""> - выберите - </option>
												<xsl:choose>
													<xsl:when test="player/sex = 'male'">
														<option value="single">
															<xsl:if test="player2/family = 'single'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															Холост</option>
														<option value="friend">
															<xsl:if test="player2/family = 'friend'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															Есть девушка</option>
														<option value="engaged">
															<xsl:if test="player2/family = 'engaged'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															Помолвлен</option>
														<option value="married">
															<xsl:if test="player2/family = 'married'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															Женат</option>
														<option value="mixed">
															<xsl:if test="player2/family = 'mixed'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															Сам не пойму</option>
														<option value="search">
															<xsl:if test="player2/family = 'search'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															В активном поиске</option>
													</xsl:when>
													<xsl:otherwise>
														<option value="single">
															<xsl:if test="player2/family = 'single'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															Сама по себе</option>
														<option value="friend">
															<xsl:if test="player2/family = 'friend'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															Есть парень</option>
														<option value="engaged">
															<xsl:if test="player2/family = 'engaged'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															Помолвлена</option>
														<option value="married">
															<xsl:if test="player2/family = 'married'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															Замужем</option>
														<option value="mixed">
															<xsl:if test="player2/family = 'mixed'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															Эх, сама не пойму</option>
														<option value="search">
															<xsl:if test="player2/family = 'search'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															В активном поиске</option>
													</xsl:otherwise>
												</xsl:choose>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label">Деятельность:</td>
										<td class="input"><input type="text" style="width:85%;" name="business" maxlength="250" value="{player2/business}" /></td>
									</tr>
                                    <tr>
										<td class="label" colspan="2" style="text-align:left;">Профили в социальных сетях</td>
									</tr>
                                    <tr>
										<td class="label">VKontakte.ru:</td>
										<td class="input">http://<input type="text" style="width:85%;" name="vkontakte" maxlength="250" value="{player2/vkontakte}" /></td>
									</tr>
                                    <tr>
										<td class="label">FaceBook.com:</td>
										<td class="input">http://<input type="text" style="width:85%;" name="facebook" maxlength="250" value="{player2/facebook}" /></td>
									</tr>
                                    <tr>
										<td class="label">Twitter.com:</td>
										<td class="input">http://<input type="text" style="width:85%;" name="twitter" maxlength="250" value="{player2/twitter}" /></td>
									</tr>
                                    <tr>
										<td class="label">LiveJournal.com:</td>
										<td class="input">http://<input type="text" style="width:85%;" name="livejournal" maxlength="250" value="{player2/livejournal}" /></td>
									</tr>
                                    <tr>
										<td class="label">Мой мир (my.mail.ru):</td>
										<td class="input">http://<input type="text" style="width:85%;" name="mailru" maxlength="250" value="{player2/mailru}" /></td>
									</tr>
                                    <tr>
										<td class="label">Odnoklassniki.ru:</td>
										<td class="input">http://<input type="text" style="width:85%;" name="odnoklassniki" maxlength="250" value="{player2/odnoklassniki}" /></td>
									</tr>
                                    <tr>
										<td class="label">LiveInternet.ru:</td>
										<td class="input">http://<input type="text" style="width:85%;" name="liveinternet" maxlength="250" value="{player2/liveinternet}" /></td>
									</tr>
								</table>
                                
                                <table class="forms">
									<tr>
										<td class="label"></td>
										<td class="input">
											<button class="button" type="submit">
												<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">Сохранить</div>
												</span>
											</button>
										</td>
									</tr>
								</table>
							</form>
						</div>
						<ins class="b l"><ins/></ins><ins class="b r"><ins/></ins>
					</div>

                    <div class="block-bordered">
						<ins class="t l"><ins/></ins><ins class="t r"><ins/></ins>
						<div class="center clear">
                            <a name="privacy"></a>
							<h3>Настройки приватности</h3>

							<form method="post" action="/settings/privacy/" id="">
								<table class="forms">
									<tr>
										<td class="label"></td>
										<td class="input">
                                            <input type="checkbox" name="denyblackgifts" id="denyblackgifts">
                                                <xsl:if test="player2/denyblackgifts = 1">
                                                    <xsl:attribute name="checked">checked</xsl:attribute>
                                                </xsl:if>
                                            </input>
                                            <label for="denyblackgifts">Не принимать подарки от игроков, внесенных в черный список</label>
                                        </td>
									</tr>
                                    <tr>
										<td class="label"></td>
										<td class="input">
                                            <input type="checkbox" name="approvegifts" id="approvegifts">
                                                <xsl:if test="player2/approvegifts = 1">
                                                    <xsl:attribute name="checked">checked</xsl:attribute>
                                                </xsl:if>
                                            </input>
                                            <label for="approvegifts">Спрашивать перед тем, как принимать подарки (от всех игроков)</label>
                                        </td>
									</tr>
									<tr>
										<td class="label"></td>
										<td class="input">
											<button class="button" type="submit">
												<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">Сохранить</div>
												</span>
									</button>
										</td>
									</tr>
								</table>
							</form>
						</div>
						<ins class="b l"><ins/></ins><ins class="b r"><ins/></ins>
					</div>

					<div class="block-bordered">
						<ins class="t l"><ins/></ins><ins class="t r"><ins/></ins>
						<div class="center clear">
							<h3>Настройки аккаунта</h3>

							<xsl:choose>
								<xsl:when test="player/password != 'd41d8cd98f00b204e9800998ecf8427e'">
									<form method="post" action="/settings/account/" id="">
										<table class="forms">
											<tr>
												<td class="label">E-mail:</td>
												<td class="input"><xsl:value-of select="player/email" /></td>
											</tr>
											<tr>
												<td class="label">Старый пароль:</td>
												<td class="input"><input type="password" id="old_password" name="old_password"/></td>
											</tr>
											<tr>
												<td class="label">Новый пароль:</td>
												<td class="input"><input type="password" id="new_password" name="new_password"/></td>
											</tr>
											<tr>
												<td class="label">Подтвердить пароль:</td>
												<td class="input"><input type="password" id="retype_password" name="retype_password"/></td>
											</tr>
											<tr>
												<td class="label"></td>
												<td class="input">
													<button class="button" type="submit">
														<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">Сохранить</div>
														</span>
											</button>
												</td>
											</tr>
										</table>								
									</form>
								</xsl:when>
								<xsl:otherwise>
									<p align="center"><b>Защитите своего персонажа.</b> Если вы не хотите, чтобы посторонние люди играли вашим персонажем или украли его, <a href="/protect/">придумайте пароль своему персонажу</a>.</p>
								</xsl:otherwise>
							</xsl:choose>
						</div>
						<ins class="b l"><ins/></ins><ins class="b r"><ins/></ins>
					</div>

					<div class="block-bordered">
						<ins class="t l"><ins/></ins><ins class="t r"><ins/></ins>
						<div class="center clear">
                            <div style="padding:5px;">
                                <h3>Форум</h3>

								<p><b>Внимание!</b> Менять аватар можно не чаще, чем раз в 4 часа!</p>

                                <form method="post" action="http://img.moswar.ru/settings/forum/" enctype="multipart/form-data" id="">
									<xsl:choose>
										<xsl:when test="DEV_SERVER = 1"><xsl:attribute name="action">/settings/forum/</xsl:attribute></xsl:when>
										<xsl:otherwise><xsl:attribute name="action">http://img.moswar.ru/settings/forum/</xsl:attribute></xsl:otherwise>
									</xsl:choose>
                                    <input type="hidden" name="MAX_FILE_SIZE" value="102400" />
                                    <table class="forms">
                                        <tr>
                                            <td class="label">Аватар:</td>
                                            <td class="input">
                                                <xsl:choose>
                                                    <xsl:when test="player/forum_avatar = 0"><img><xsl:attribute name="src">/@/images/pers/<xsl:value-of select="php:function('str_replace', '.png', '_thumb.png', string(player/avatar))" /></xsl:attribute></img></xsl:when>
                                                    <xsl:otherwise>
                                                        <img src="/@images/{player/forum_avatar_src}" />
                                                        <xsl:if test="player/forum_avatar_checked = 0"><br /><b>не проверен</b></xsl:if>
                                                    </xsl:otherwise>
                                                </xsl:choose>
                                                </td>
                                        </tr>
                                        <xsl:if test="player/forum_avatar > 0">
                                            <tr>
                                                <td class="label">Удалить аватар:</td>
                                                <td class="input"><input type="checkbox" name="forum_avatar_delete" /></td>
                                            </tr>
                                        </xsl:if>
                                        <tr>
                                            <td class="label">Установить аватар:</td>
                                            <td class="input"><input type="file" name="forum_avatar" /><br /><small>(не более 100 кб, картинка должна быть квадратной, форматы: gif, jpg, png)</small></td>
                                        </tr>
                                        <tr>
                                            <td class="label"></td>
                                            <td class="input"><input type="checkbox" id="forum_show_useravatars" name="forum_show_useravatars"><xsl:if test="player/forum_show_useravatars = 1"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if></input> <label for="forum_show_useravatars">Показывать на форуме пользовательские аватары</label></td>
                                        </tr>
                                        <tr>
                                            <td class="label"></td>
                                            <td class="input">
                                                <button class="button" type="submit">
                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Сохранить</div>
                                                    </span>
                                        </button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                                <p>Если у вас возникли вопросы по аватаркам, прочитайте <a href="/faq/avatar/">короткое описание</a> по их использованию.</p>
                            </div>
						</div>
						<ins class="b l"><ins/></ins><ins class="b r"><ins/></ins>
					</div>
					
					<div class="block-bordered">
						<ins class="t l"><ins/></ins><ins class="t r"><ins/></ins>
						<div class="center clear">
                            <a name="creogen"></a>
							<h3>Заморозить персонажа</h3>
							<div style="padding:5px;">
                                <p>Новая областная криогенная лаборатория позволяет заморозить вашего персонажа. После этого никто на вас не сможет напасть,
                                а ваш персонаж перестанет участвовать в жизни клана и города.</p>
                                <p>Заморозиться можно, если у вас нет никаких таймеров (не работаете в Шаурбургерсе, не находитесь в тюрьме и не патрулируете город).
                                А также если ваш клан не находится в состоянии 1-го этапа войны.
                                Минимальный срок заморозки – 48 часов, максимальный – 30 дней. <!--Замораживаться можно не чаще раза в 7 дней.--></p>
                                <p>Внимание! Во время отпуска сейфы, жвачки и другие временные принадлежности продолжают работать.</p>
                                <p><b>Разморозка</b> персонажа происходит автоматически при входе в аккаунт. Но помните, что вы не сможете войти в аккаунт ранее, чем через
                                48 часов после заморозки. Также персонаж автоматически размораживается через 30 дней после заморозки.</p>

                                <xsl:choose>
                                    <xsl:when test="war_step1 = 1">
                                        <p class="holders">Вы не можете заморозиться во время 1-го этапа войны.</p>
                                    </xsl:when>
                                    <xsl:when test="player/level &lt; 4">
                                        <p class="holders">Заморозка персонажа доступна с 4-го уровня.</p>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <form method="post" action="/settings/creogen/">
                                            <input type="hidden" name="player" value="{player/id}" />
                                            <p align="center">
                                                <button class="button" onclick="$(this).hide();$('#real-creogen-button').show();return false;">
                                                    <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                        <div class="c">Заморозиться — <span class="tugriki">1000<i></i></span></div>
                                                    </span>
                                                </button>
                                                <div class="holders" id="real-creogen-button" style="display:none;">
                                                    <p>Пароль от персонажа: <input type="password" name="password" value="" /></p>
                                                    <button class="button" type="submit">
                                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Заморозиться — <span class="tugriki">1000<i></i></span></div>
                                                        </span>
                                                    </button>
                                                </div>
                                            </p>
                                        </form>
                                    </xsl:otherwise>
                                </xsl:choose>
							</div>
						</div>
						<ins class="b l"><ins/></ins><ins class="b r"><ins/></ins>
					</div>

                    <xsl:if test="player/level > 3">
                        <div class="block-bordered">
                            <ins class="t l"><ins/></ins><ins class="t r"><ins/></ins>
                            <div class="center clear">
                                <h3>Заблокировать персонажа</h3>
                                <div style="padding:5px;">
                                    <p>Надоела грязь большого города? Нервы не выдерживают ежедневных стрессов? Ну что ж, надеемся,
                                    что размеренная жизнь в глубинке пойдет вам на пользу.</p>

                                    <xsl:choose>
                                        <xsl:when test="war_step1 = 1">
                                            <p class="holders">Вы не можете заблокироваться во время 1-го этапа войны.</p>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <form method="post" action="/settings/block/">
                                                <input type="hidden" name="player" value="{player/id}" />
                                                <p align="center">
                                                    <button class="button" onclick="$(this).hide();$('#real-block-button').show();return false;">
                                                        <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                            <div class="c">Заблокироваться — <strong>бесплатно!</strong></div>
                                                        </span>
                                                    </button>
                                                    <div class="holders" id="real-block-button" style="display:none;">
                                                        <p>Пароль от персонажа: <input type="password" name="password" value="" /></p>
                                                        <button class="button" type="submit">
                                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                                <div class="c">Заблокироваться</div>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </p>
                                            </form>
                                        </xsl:otherwise>
                                    </xsl:choose>

                                    <p>После блокировки персонажа, вы больше не сможете играть им. Если вы все таки передумаете, то всего за 50 мёда сможете вновь вернутся в игру.</p>
                                </div>
                            </div>
                            <ins class="b l"><ins/></ins><ins class="b r"><ins/></ins>
                        </div>
                    </xsl:if>

				</div>
			</div>
		</div>
	</xsl:template>

</xsl:stylesheet>
