<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" />

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/paginator.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear"><h2>Фотки</h2></div>

					<div class="photos" id="content">

						<table class="buttons">
							<tr>
								<td>
									<div class="button">
										<a class="f" href="/photos/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Обзор</div>
										</a>
									</div>
								</td>
								<td>
									<xsl:choose>
										<xsl:when test="count(player/id) = 0">
											<div class="button disabled">
												<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">Оценить фотки</div>
												</span>
											</div>
										</xsl:when>
										<xsl:otherwise>
											<div class="button button-current">
												<a class="f" href="/photos/rate/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">Оценить фотки</div>
												</a>
											</div>
										</xsl:otherwise>
									</xsl:choose>
								</td>
								<td>
									<div class="button">
										<a class="f" href="/photos/contest/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Конкурсы</div>
										</a>
									</div>
								</td>
								<td>
									<xsl:choose>
										<xsl:when test="count(player/id) = 0">
											<div class="button disabled">
												<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">Мои фотки</div>
												</span>
											</div>
										</xsl:when>
										<xsl:otherwise>
											<div class="button">
												<a class="f" href="/photos/{player/id}/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">Мои фотки</div>
												</a>
											</div>
										</xsl:otherwise>
									</xsl:choose>
								</td>
								<td>
									<xsl:choose>
										<xsl:when test="count(player/id) = 0">
											<div class="button disabled">
												<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">Закачать</div>
												</span>
											</div>
										</xsl:when>
										<xsl:otherwise>
											<div class="button">
												<a class="f" href="/photos/upload/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">Закачать</div>
												</a>
											</div>
										</xsl:otherwise>
									</xsl:choose>
								</td>
							</tr>
						</table>

						<xsl:if test="count(result) > 0">
							<xsl:call-template name="error">
								<xsl:with-param name="result" select="result" />
							</xsl:call-template>
						</xsl:if>

								<div class="photo-page" style="width:100%; float:none;">
									<h3 class="curves clear">
										<xsl:call-template name="playerlink">
											<xsl:with-param name="array" select="0" />
											<xsl:with-param name="player" select="photo/player" />
										</xsl:call-template>
									</h3>

									<xsl:if test="count(photo) > 0">
										<div class="block-rounded">
											<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
											<div class="photo-rating">
												<div class="photo-vote">
													<a class="previous" href="/photos/rate/prev/">Назад</a>
													<a class="next" href="/photos/rate/next/">Далее</a>
													<label>Оцените <span class="dashedlink" onclick="$('#photo-vote-hint').toggle();">платно</span>:</label>&#0160;
													<a class="icon photo-vote-button" onclick="photoRate({photo/id}, 1, 'line');" href="#">1</a>&#0160;
													<a class="icon photo-vote-button" onclick="photoRate({photo/id}, 2, 'line');" href="#">2</a>&#0160;
													<a class="icon photo-vote-button" onclick="photoRate({photo/id}, 3, 'line');" href="#">3</a>&#0160;
													<a class="icon photo-vote-button" onclick="photoRate({photo/id}, 4, 'line');" href="#">4</a>&#0160;
													<a class="icon photo-vote-button" onclick="photoRate({photo/id}, 5, 'line');" href="#">5</a>&#0160;
													<a class="icon photo-vote-button-big" onclick="photoRate({photo/id}, 10, 'line');" href="#">10-<span class="med">1<i></i></span></a>
													<div id="photo-vote-hint" style="display:none;">
														Стоимость оценки до 5 баллов: <span class="tugriki">50<i></i></span>. Награда автору: <span class="tugriki">25<i></i></span><br />
														Стоимость оценки в 10 баллов: <span class="med">1<i></i></span>. Награда автору: <span class="ruda">1<i></i></span>
													</div>
												</div>
												<table>
													<tr>
														<td class="photo-highlights-button" style="width:30%;">
														</td>
														<td style="width:40%; text-align:center;">
															<div class="photo-rating-numbers">
																Рейтинг: <xsl:value-of select="photo/rating" /> &#160;&#160;
																Голосов: <xsl:value-of select="photo/amount" />
															</div>
														</td>
														<td style="width:30%;"></td>
													</tr>
												</table>
											</div>
										</div>
									</xsl:if>

									<div class="bigphoto">
										<xsl:choose>
											<xsl:when test="count(photo/player) = 0">
												<p class="error">Сегодня вы оценили все фотографии. Вы - молодец!</p>
											</xsl:when>
											<xsl:otherwise>
												<img src="{photo/src}" />
											</xsl:otherwise>
										</xsl:choose>
									</div>

										<xsl:if test="show_player_info = 1 and (photo/player/about/about != '' or photo/player/about/name != '' or photo/player/about/site != '' or photo/player/about/city != '' or photo/player/about/hobby != '')">
											<div class="block-rounded">
												<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
												<xsl:if test="photo/player/about/name != ''">
													<b>Имя: </b> <xsl:value-of select="photo/player/about/name" /><br />
												</xsl:if>
												<xsl:if test="photo/player/sex != ''">
													<b>Пол: </b> <xsl:choose>
														<xsl:when test="photo/player/sex = 'male'">Мужской</xsl:when>
														<xsl:when test="photo/player/sex = 'female'">Женский</xsl:when>
														</xsl:choose><br />
												</xsl:if>
												<xsl:if test="photo/player/about/city != ''">
													<b>Город: </b> <xsl:value-of select="photo/player/about/city" /><br />
												</xsl:if>
												<xsl:if test="photo/player/site != ''">
													<b>Сайт: </b> <xsl:value-of select="photo/player/about/site" /><br />
												</xsl:if>
												<xsl:if test="photo/player/about/hobby != ''">
													<b>Увлечения и хобби: </b> <xsl:value-of select="photo/player/about/hobby" /><br />
												</xsl:if>
												<xsl:if test="photo/player/about/about != ''">
													<xsl:value-of select="photo/player/about/about" disable-output-escaping="yes" />
												</xsl:if>
											</div>
										</xsl:if>
										<xsl:if test="count(photo/id) > 0">
											<div class="link">
												Ссылка на фотографию: <input type="text" onclick="this.select()" value="http://moswar.ru/photos/{photo/player/id}/{photo/id}/" />
											</div>
										</xsl:if>
									</div>



										<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
									</div>
								</div>

								<br clear="all" />
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
			<xsl:when test="$result/result = 0 and $result/type = 'photos' and $result/error = 'low level'"><p class="error" align="center">Голосовать можно только со 2-го уровня.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'photos' and $result/error = 'no money'"><p class="error" align="center">У Вас не хватает денег, чтобы поставить выбранную оценку.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'photos' and $result/error = 'you have no access'"><p class="error" align="center">Чтобы проголосовать, необходимо <a href="/">авторизироваться</a> или <a href="/">зарегистрироваться</a>.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'photos' and $result/error = 'photo not found'"><p class="error" align="center">Фотография не найдена.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'photos' and $result/action = 'rate' and $result/error = 'already rated today'"><p class="error" align="center">Вы уже голосовали за эту фотографию сегодня.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'photos' and $result/action = 'rate' and $result/error = 'photo is not accepted'"><p class="error" align="center">Нельзя голосовать за непроверенные фотографии.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'photos' and $result/action = 'rate' and $result/error = 'you cannot rate yourself'"><p class="error" align="center">Нельзя оценивать свои собственные фотографии.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'photos' and $result/action = 'rate' and $result/error = 'photo is not available for voting'"><p class="error" align="center">Фотография недоступна для голосования.</p></xsl:when>
			<!-- successes -->
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'rate'"><p class="success" align="center">Ваш голос зачтен.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'accept'"><p class="success" align="center">Фотография разрешена.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'cancel'"><p class="success" align="center">Фотография отклонена.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'delete'"><p class="success" align="center">Фотография удалена.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'set in profile'"><p class="success" align="center">Фотография размещена в профиле.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'upload'"><p class="success" align="center">Вы молодец, что закачали фотографии. Они появятся после проверки модератором.</p></xsl:when>
			<xsl:otherwise><xsl:value-of select="$result" /></xsl:otherwise>
        </xsl:choose>

    </xsl:template>

</xsl:stylesheet>
