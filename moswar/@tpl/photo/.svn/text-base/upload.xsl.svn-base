<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" />

    <xsl:include href="common/playerlink.xsl" />

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
										<div class="button button-current">
											<a class="f" href="http://img.moswar.ru/photos/upload/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
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

					<table>
						<tr>
							<td style="width:50%; padding:0 5px 0 0;">
								<div class="block-bordered">
									<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
									<div class="center clear">
										<h3>Закачать фотографии</h3>
										<form class="photos-upload" enctype="multipart/form-data" method="post">
											<xsl:choose>
												<xsl:when test="DEV_SERVER = 1"><xsl:attribute name="action">/photos/</xsl:attribute></xsl:when>
												<xsl:otherwise><xsl:attribute name="action">http://img.moswar.ru/photos/</xsl:attribute></xsl:otherwise>
											</xsl:choose>
											<xsl:choose>
												<xsl:when test="count(slots/element) != 0">
													<p>Вы можете закачать не более <xsl:value-of select="total - uploaded" /> фотографий.<br />
													Размер фотографии не более 3 Mb</p>
													<p><input type="checkbox" id="photos-upload-checkbox" /> <label for="photos-upload-checkbox">Я хочу закачать фотки себя<br />и ознакомлен с <a href="/licence/photo_rules/">правилами</a></label></p>
													<input type="hidden" name="action" value="upload" />
													<xsl:for-each select="slots/element">
														<input type="file" name="photo{position()}" disabled="true" /><br />
													</xsl:for-each>
													<button class="button disabled" type="submit"><span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">Готово</div></span></button>
												</xsl:when>
												<xsl:otherwise>
													<p><strong>У вас больше нет доступных мест для загрузки фотографий, но вы можете их докупить.</strong></p>
												</xsl:otherwise>
											</xsl:choose>
											<p style="margin:5px 0 0 0"><b>Вы можете заработать</b>, поскольку за каждый голос вашей фотографии вы будете получать монеты или руду.</p>
										</form>
										<script type="text/javascript">
											$("#photos-upload-checkbox").bind("click", function(){
												if(this.checked){
													$("form.photos-upload input[type=file]").attr("disabled",false);
													$("form.photos-upload button").attr("disabled",false);
													$("form.photos-upload button").removeClass("disabled");
												} else {
													$("form.photos-upload input[type=file]").attr("disabled",true);
													$("form.photos-upload button").attr("disabled",true);
													$("form.photos-upload button").addClass("disabled");
												}
											})
										</script>
									</div>
									<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
								</div>
							</td>
							<td style="width:50%; padding:0 0 0 5px;">
								<div class="block-bordered">
									<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
									<div class="center clear">
										<h3>Рамки для фотографий</h3>
										<form class="photos-upload-enlarge" action="/photos/" method="post">
											<input type="hidden" name="action" value="buy_frame" />
											<p>Изначально альбом вмещает всего <xsl:value-of select="max_free_slots" /> фотографий, но вы можете его расширить, докупив дополнительные рамки для фотографий.<br />Закачивайте только свои фотки.</p>
											<xsl:if test="player/level &lt; 3"><p class="hint">На 3-ем уровне вы получите еще 10 дополнительных мест для ваших фотографий.</p></xsl:if>
											<p class="total">Текущая вместимость: <xsl:value-of select="uploaded" />/<xsl:value-of select="total" /></p>
											<button class="button" type="submit">
												<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i><div class="c">
													Расширить на одну фотку - <span class="med">2<i></i></span>
												</div></span>
											</button>
										</form>
									</div>
									<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
								</div>
							</td>
						</tr>
					</table>

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
			<xsl:when test="$result/result = 0 and $result/type = 'photos' and $result/error = 'photo not found'"><p class="error" align="center">Фотография не найдена.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/error = 'no money'"><p class="error" align="center">У вас не хватает денег.</p></xsl:when>
			<!-- successes -->
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'buy frame'"><p class="success" align="center">Вы купили рамку и теперь у Вас появилось место для двух дополнительных фотографий.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'accept'"><p class="success" align="center">Фотография разрешена.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'cancel'"><p class="success" align="center">Фотография отклонена.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'delete'"><p class="success" align="center">Фотография удалена.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'set in profile'"><p class="success" align="center">Фотография размещена в профиле.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'upload'"><p class="success" align="center">Вы молодец, что закачали фотографии. Они появятся после проверки модератором.</p></xsl:when>
			<xsl:otherwise><xsl:value-of select="$result" /></xsl:otherwise>
        </xsl:choose>

    </xsl:template>

</xsl:stylesheet>
