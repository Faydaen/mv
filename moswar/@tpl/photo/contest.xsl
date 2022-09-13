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
											<div class="button">
												<a class="f" href="/photos/rate/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">Оценить фотки</div>
												</a>
											</div>
										</xsl:otherwise>
									</xsl:choose>
								</td>
								<td>
									<div class="button button-current">
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

		<xsl:choose>
			<xsl:when test="count(contests/element) > 0">
				<div class="photo-page">
					<xsl:if test="count(contest) > 0">
						<xsl:attribute name="style">width:100%;</xsl:attribute>
						<div class="block-rounded">
							<xsl:if test="count(photo) > 0">
								<xsl:attribute name="style">background:#ffd86e;</xsl:attribute>
							</xsl:if>
							<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
							<xsl:choose>
								<xsl:when test="count(photo) > 0">
									<h3><a href="../"><xsl:value-of select="contest/name" disable-output-escaping="yes" /></a> - <span class="dashedlink" onclick="$('#photo-contest-description').toggle();">Описание</span></h3>
								</xsl:when>
								<xsl:otherwise>
									<h3><xsl:value-of select="contest/name" disable-output-escaping="yes" /></h3>
								</xsl:otherwise>
							</xsl:choose>
							<div class="photo-contest-description" id="photo-contest-description">
								<xsl:if test="count(photo) > 0">
									<xsl:attribute name="style">display:none;</xsl:attribute>
								</xsl:if>
								<div class="hint date" align="center">
									Время проведения: <xsl:value-of select="contest/dt_started" /> — <xsl:value-of select="contest/dt_finished" />
								</div>
								<div class="text clear">
									<xsl:value-of select="contest/info" disable-output-escaping="yes" />
								</div>
								<div align="center">
									<div class="status">
										<xsl:choose>
											<xsl:when test="contest/status = 'new'">
												Конкурс еще не начался.
											</xsl:when>
											<xsl:when test="contest/status = 'resulting'">
												Конкурс уже завершился, но победитель еще не определен, идет подсчет голосов.
											</xsl:when>
											<xsl:when test="contest/status = 'finished'">
												<span class="red">Конкурс уже завершен.</span>
											</xsl:when>
											<xsl:when test="count(player/id) = 0">
												Для участия в конкурсе необходимо <a href="/">авторизироваться</a>.
											</xsl:when>
											<xsl:when test="uploaded_photo_id = 0">
												<div class="button" onclick="$('#photo-contest-description-upload').toggle('fast')">
													<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div class="c">Принять участие</div>
													</span>
												</div>
												<form id="photo-contest-description-upload" method="post" enctype="multipart/form-data" style="display:none;">
													<xsl:choose>
														<xsl:when test="DEV_SERVER = 1"><xsl:attribute name="action">/photos/</xsl:attribute></xsl:when>
														<xsl:otherwise><xsl:attribute name="action">http://img.moswar.ru/photos/</xsl:attribute></xsl:otherwise>
													</xsl:choose>
													<input type="hidden" name="action" value="upload" />
													<input type="hidden" name="contest" value="{contest/id}" />
													<table class="forms">
														<tr>
															<td class="label" style="width:40%; vertical-align:middle; font-size:100%">Укажите&#160;фотку:</td>
															<td class="input" style="width:20%">
																
																<input type="file" name="photo" />
															</td>
															<td style="width:40%"></td>
														</tr>
													</table>
													<p class="hint">Каждый участник может отправить на конкурс только одну фотографию.</p>
													<button class="button" type="submit">
														<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">Закачать</div>
														</span>
													</button>
												</form>
											</xsl:when>
											<xsl:when test="uploaded_photo_status != 'accepted'">
												Вы уже отправили <a href="/photos/contest/{contest/id}/{uploaded_photo_id}/">свою фотографию</a> на этот конкурс.<br />После прохождения модерации за нее смогут проголосовать игроки.
											</xsl:when>
											<xsl:otherwise>
												<span class="green">Вы уже отправили <a href="/photos/contest/{contest/id}/{uploaded_photo_id}/">свою фотографию</a> на этот конкурс.</span>
											</xsl:otherwise>
										</xsl:choose>
									</div>
								</div>
							</div>
						</div>

						<xsl:if test="count(photo) > 0">
							
							<div class="block-rounded" style="display: none;">
								<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
								<div class="photo-rating">
									<div class="photo-vote">
										<a class="previous" href="#" onclick="photoShow('prev');return false;">Назад</a>
										<a class="next" href="#" onclick="photoShow('next');return false;">Далее</a>
										&#0160;
										<xsl:choose>
											<xsl:when test="contest/status = 'started' and count(photo) > 0">
												<label>Оцените <span class="dashedlink" onclick="$('#photo-vote-hint').toggle();">платно</span>:</label>&#0160;
												<a class="icon photo-vote-button" onclick="photoRate($('#img').attr('rel'), 1);" href="#">1</a>&#0160;
												<a class="icon photo-vote-button" onclick="photoRate($('#img').attr('rel'), 2);" href="#">2</a>&#0160;
												<a class="icon photo-vote-button" onclick="photoRate($('#img').attr('rel'), 3);" href="#">3</a>&#0160;
												<a class="icon photo-vote-button" onclick="photoRate($('#img').attr('rel'), 4);" href="#">4</a>&#0160;
												<a class="icon photo-vote-button" onclick="photoRate($('#img').attr('rel'), 5);" href="#">5</a>&#0160;
												<a class="icon photo-vote-button-big" onclick="photoRate($('#img').attr('rel'), 10);" href="#">10-<span class="med">1<i></i></span></a>
												<div id="photo-vote-hint" style="display:none;">
													Стоимость оценки до 5 баллов: <span class="tugriki">50<i></i></span>. Награда автору: <span class="tugriki">25<i></i></span><br />
													Стоимость оценки в 10 баллов: <span class="med">1<i></i></span>. Награда автору: <span class="ruda">1<i></i></span>
												</div>
											</xsl:when>
											<xsl:when test="contest/status = 'new' or contest/status = 'accepting'">
												<label>Голосование еще не началось.</label>
											</xsl:when>
											<xsl:when test="contest/status = 'resulting'">
												<label>Конкурс завершен, идет подведение итогов.</label>
											</xsl:when>
											<xsl:when test="contest/status = 'finished'">
												<label>Конкурс завершен.</label>
											</xsl:when>
										</xsl:choose>
										<xsl:if test="contest/status != 'new' and contest/status != 'accepting'">
											<div class="photo-rating-numbers">
												Рейтинг: <span id="imgRating"><xsl:value-of select="photo/rating" /></span> &#160;&#160;
												Голосов: <span id="imgVotes"><xsl:value-of select="photo/amount" /></span>
											</div>
										</xsl:if>
									</div>
								</div>
							</div>
							
							<h3 class="curves clear" rel="playerlink">
								<xsl:call-template name="playerlink">
									<xsl:with-param name="array" select="0" />
									<xsl:with-param name="player" select="photo/player" />
								</xsl:call-template>
							</h3>

							<div class="bigphoto">
								<img src="{photo/src}" id="img" rel="{photo/id}" />
								<xsl:if test="photo/player = player/id">
									<div class="actions">
										<span class="dashedlink delete" onclick="photoDelete({photo/id});">Удалить фотку</span>
									</div>
								</xsl:if>
							</div>

							<div class="link">
								Ссылка на эту страницу: <input type="text" onclick="this.select()" value="http://moswar.ru/photos/contest/{contest/id}/#{photo/id}/" id="linkToThisPage" />
							</div>
						</xsl:if>
						
						<xsl:if test="count(photos/element) > 0">
							<script>
								var photos = eval('(<xsl:value-of select="photos_json"  />)');
								var photoCurrent = <xsl:value-of select="current_photo" />;
								<![CDATA[
								$(document).ready(function(){
									if (!isNaN(document.location.hash.replace('#', '')) && photoGetNumberById(document.location.hash.replace('#', '')) !== false) {
										photoCurrent = photoGetNumberById(document.location.hash.replace('#', ''));
									} else {
										photoCurrent = 0;
									}
									photoShow(photoCurrent);
									$('div.photo-vote').parents('div.block-rounded:first').show();
								});
								]]>
							</script>
							<h3 class="curves clear">
								Конкурсные фотографии
							</h3>
							<div class="contest-photos-thumbs" id="pers-photos-thumbs">
								<xsl:for-each select="photos/element">
									<span class="thumb">
										<a href="#{id}" onclick="photoShow({position()-1});return false;">
											<xsl:if test="id = /data/photo/id">
												<xsl:attribute name="class">current</xsl:attribute>
											</xsl:if>
											<img src="{thumb_src}" />
										</a>
									</span>
								</xsl:for-each>
							</div>
						</xsl:if>
						<xsl:if test="count(photos/element) = 0">
							<p align="center">Пока в конкурсе не участвует ни одна фотография. Вы можете быть первым!</p>
						</xsl:if>
					</xsl:if>
				<!--
				<xsl:if test="count(contest) = 0">
					<p align="center"><i>Выберите интересующий вас конкурс слева.</i></p>
				</xsl:if>
				-->
				</div>
				
				<xsl:if test="count(contest) = 0">
				<div class="listing" style="width:100%">
					<xsl:for-each select="contests/element">
					<div class="block-bordered">
						<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
						<div class="center clear">
							<h3><a href="/photos/contest/{id}/"><xsl:value-of select="name" /></a></h3>
							<div class="photo-contest-preview">
								<div class="hint date" align="center">
									Время проведения: <xsl:value-of select="dt_started" /> — <xsl:value-of select="dt_finished" />
								</div>
								<div class="text">
									<xsl:value-of select="info" disable-output-escaping="yes" />
								</div>
								<div class="more"><a href="/photos/contest/{id}/">Смотреть &#8594;</a></div>
							</div>
						</div>
						<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
					</div>
					</xsl:for-each>
				</div>
				</xsl:if>
				
				
			</xsl:when>
			<xsl:otherwise>
				<p align="center"><i>Пока нет никаких конкурсов.</i></p>
			</xsl:otherwise>
		</xsl:choose>
								
 								<br clear="all" />
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
			<xsl:when test="$result/result = 0 and $result/type = 'photos' and $result/error = 'low level'"><p class="error" align="center">Голосовать можно только со 2-го уровня.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'photos' and $result/error = 'no money'"><p class="error" align="center">У вас не хватает денег, чтобы поставить выбранную оценку.</p></xsl:when>
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
