<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html" />

	<xsl:include href="common/playerlink.xsl" />
	<xsl:include href="common/paginator.xsl" />

	<xsl:template name="photo-top">
		<div class="photo-highlights">
			<div class="block-rounded">
				<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
				<div class="text">
					<h3><span class="dashedlink" onclick="$('#photo-highlights-hint').toggle('fast');">Попади в Десяточку</span></h3>
					<p id="photo-highlights-hint" class="hint" style="display:none;">
						Чтобы попасть в Десяточку — зайдите на страницу фотографии и нажмите кнопку &#0171;В десяточку&#0187; над фотографией.<br />
						Цена — <span class="med">1<i></i></span>.
						Каждая новая фотография вытесняет последнюю фотографию из Десяточки.
					</p>
					<xsl:for-each select="top/element">
						<a href="/photos/{player_id}/#{id}"><img class="thumb" src="{thumb_src}" /></a>
					</xsl:for-each>
				</div>
			</div>
		</div>
	</xsl:template>
	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear"><h2>Фотки</h2></div>
				<div class="photos" id="content">

					<table class="buttons">
						<tr>
							<td>
								<div class="button button-current">
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

					<!--<div class="photo-page">-->
					<xsl:choose>
						<xsl:when test="mode = 'index'">
							<!--
								<h3 class="curves clear"><a href="/photos/topphotos/">Топ-фоток</a></h3>
								<ul class="photos-preview-list clear">
									<xsl:for-each select="topphotos/element">
										<li>
											<a href="/photos/{player_id}/{id}/"><img class="thumb" src="{thumb_src}" /></a><br />
											<xsl:call-template name="playerlink"><xsl:with-param name="href" select="'photos'" /><xsl:with-param name="player" select="current()" /></xsl:call-template>
										</li>
									</xsl:for-each>
								</ul>

								<h3 class="curves clear"><a href="/photos/toppeople/">Топ-людей</a></h3>
								<ul class="photos-preview-list clear">
									<xsl:for-each select="toppeople/element">
										<li>
											<a href="/photos/{player_id}/{id}/"><img class="thumb" src="{thumb_src}" /></a><br />
											<xsl:call-template name="playerlink"><xsl:with-param name="href" select="'photos'" /><xsl:with-param name="player" select="current()" /></xsl:call-template>
										</li>
									</xsl:for-each>
								</ul>
								<h3 class="curves clear"><a href="/photos/newphotos/">Новые фотки</a><xsl:if test="todaynew > 0"><span title="Новых фотографий за сутки"> +<xsl:value-of select="todaynew" /></span></xsl:if></h3>
								<ul class="photos-preview-list clear">
									<xsl:for-each select="newphotos/element">
										<li>
											<a href="/photos/{player_id}/{id}/"><img class="thumb" src="{thumb_src}" /></a><br />
											<xsl:call-template name="playerlink"><xsl:with-param name="href" select="'photos'" /><xsl:with-param name="player" select="current()" /></xsl:call-template>
										</li>
									</xsl:for-each>
								</ul>
								-->

							<xsl:call-template name="photo-top" />
							<div class="photo-page-top">
								<h3 class="curves clear">
									<table>
										<tr>
											<td style="width:33%"></td>
											<td style="width:34%"><a href="/photos/topphotos/">Топ-фоток</a><i class="question-icon" tooltip="1" title="Топ-фоток||В топ попадают фотографии с наибольшим рейтингом имеющие не менее 5 голосов"></i></td>
											<td style="width:33%;">
												<div class="selector">
													<span rel="all" class="dashedlink filter_topphotos current">Все</span> &#160;
													<span rel="female" class="dashedlink filter_topphotos">Женские</span> &#160;
													<span rel="male" class="dashedlink filter_topphotos">Мужские</span>
												</div>
											</td>
										</tr>
									</table>
								</h3>
								<ul class="photos-preview-list clear" id="photostop-all">
									<xsl:for-each select="topphotos/element">
										<li style="width: 130px;">
											<a href="/photos/{player_id}/#{id}"><img class="thumb" src="{thumb_src}" /></a><br />
											<xsl:call-template name="playerlink"><xsl:with-param name="href" select="'photos'" /><xsl:with-param name="player" select="current()" /></xsl:call-template>
										</li>
									</xsl:for-each>
								</ul>
								<ul class="photos-preview-list clear" id="photostop-male" style="display: none;">
									<xsl:for-each select="topphotos_male/element">
										<li style="width:130px;">
											<a href="/photos/{player_id}/#{id}"><img class="thumb" src="{thumb_src}" /></a><br />
											<xsl:call-template name="playerlink"><xsl:with-param name="href" select="'photos'" /><xsl:with-param name="player" select="current()" /></xsl:call-template>
										</li>
									</xsl:for-each>
								</ul>
								<ul class="photos-preview-list clear" id="photostop-female" style="display: none;">
									<xsl:for-each select="topphotos_female/element">
										<li style="width:130px;">
											<a href="/photos/{player_id}/#{id}"><img class="thumb" src="{thumb_src}" /></a><br />
											<xsl:call-template name="playerlink"><xsl:with-param name="href" select="'photos'" /><xsl:with-param name="player" select="current()" /></xsl:call-template>
										</li>
									</xsl:for-each>
								</ul>
								<h3 class="curves clear">
									<table>
										<tr>
											<td style="width:33%"></td>
											<td style="width:34%"><a href="/photos/toppeople/">Топ-людей</a><i class="question-icon" tooltip="1" title="Топ-людей||В топ попадают люди с наибольшей суммой всех голосов"></i></td>
											<td style="width:33%;">
												<div class="selector">
													<span rel="all" class="dashedlink filter_toppeople current">Все</span> &#160;
													<span rel="female" class="dashedlink filter_toppeople">Женские</span> &#160;
													<span rel="male" class="dashedlink filter_toppeople">Мужские</span>
												</div>
											</td>
										</tr>
									</table>
								</h3>
								<ul class="photos-preview-list clear" id="peopletop-all">
									<xsl:for-each select="toppeople/element">
										<li style="width:130px;">
											<a href="/photos/{player_id}/#{id}"><img class="thumb" src="{thumb_src}" /></a><br />
											<xsl:call-template name="playerlink"><xsl:with-param name="href" select="'photos'" /><xsl:with-param name="player" select="current()" /></xsl:call-template>
										</li>
									</xsl:for-each>
								</ul>
								<ul class="photos-preview-list clear" id="peopletop-male" style="display: none;">
									<xsl:for-each select="toppeople_male/element">
										<li style="width:130px;">
											<a href="/photos/{player_id}/#{id}"><img class="thumb" src="{thumb_src}" /></a><br />
											<xsl:call-template name="playerlink"><xsl:with-param name="href" select="'photos'" /><xsl:with-param name="player" select="current()" /></xsl:call-template>
										</li>
									</xsl:for-each>
								</ul>
								<ul class="photos-preview-list clear" id="peopletop-female" style="display: none;">
									<xsl:for-each select="toppeople_female/element">
										<li style="width:130px;">
											<a href="/photos/{player_id}/#{id}"><img class="thumb" src="{thumb_src}" /></a><br />
											<xsl:call-template name="playerlink"><xsl:with-param name="href" select="'photos'" /><xsl:with-param name="player" select="current()" /></xsl:call-template>
										</li>
									</xsl:for-each>
								</ul>
							</div>
							<div class="photo-page">
								<h3 class="curves clear">
									<a href="/photos/newphotos/">Новые фотки</a><xsl:if test="todaynew > 0"><span title="Новых фотографий за сутки" class="number"> +<xsl:value-of select="todaynew" /></span></xsl:if>
								</h3>
								<ul class="photos-preview-list clear">
									<xsl:for-each select="newphotos/element">
										<li style="width:109px">
											<a href="/photos/{player_id}/#{id}"><img class="thumb" src="{thumb_src}" /></a><br />
											<xsl:call-template name="playerlink"><xsl:with-param name="href" select="'photos'" /><xsl:with-param name="player" select="current()" /></xsl:call-template>
										</li>
									</xsl:for-each>
								</ul>
							</div>

						</xsl:when>
						<xsl:when test="mode = 'player'">
							<xsl:call-template name="photo-top" />
							<script>
								var photos = eval('<xsl:value-of select="photos_json"  />');
								var photoCurrent = <xsl:value-of select="current_photo" />;
								<![CDATA[
								$(document).ready(function(){
									if (!isNaN(document.location.hash.replace('#', '')) && photoGetNumberById(document.location.hash.replace('#', '')) !== false) {
										photoCurrent = photoGetNumberById(document.location.hash.replace('#', ''));
									} else {
										photoCurrent = 0;
									}
									photoShow(photoCurrent);
								});
								]]>
							</script>
							<div class="photo-page">
								<h3 class="curves clear" rel="playerlink">
									<xsl:call-template name="playerlink">
										<xsl:with-param name="array" select="0" />
										<xsl:with-param name="player" select="photo/player" />
									</xsl:call-template>
								</h3>

								<xsl:if test="count(photo) > 0 and count(photos/element) > 0">
									<div class="block-rounded">
										<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
										<div class="photo-rating">
											<div class="photo-vote">
												<a class="previous" href="#" onclick="photoShow('prev');return false;">Назад</a>
												<a class="next" href="#" onclick="photoShow('next');return false;">Далее</a>
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
											</div>
											<table>
												<tr>
													<td class="photo-highlights-button" style="width:30%;">
														<xsl:if test="player/allow_actions = 'true'">
															<form method="post">
																<xsl:choose>
																	<xsl:when test="DEV_SERVER = 1"><xsl:attribute name="action">/photos/</xsl:attribute></xsl:when>
																	<xsl:otherwise><xsl:attribute name="action">http://img.moswar.ru/photos/</xsl:attribute></xsl:otherwise>
																</xsl:choose>
																<input type="hidden" name="action" value="top" /><input type="hidden" id="ten-id" name="id" value="{photo/id}" /><button class="button" type="submit">
																	<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
																		<div class="c">В десяточку — <span class="med">1<i style="margin-right:0;"></i></span></div>
																	</span>
															</button></form>
														</xsl:if>
													</td>
													<td style="width:40%; text-align:center;">
														<div class="photo-rating-numbers">
															Рейтинг: <span id="imgRating"><xsl:value-of select="photo/rating" /></span> &#160;&#160;
															Голосов: <span id="imgVotes"><xsl:value-of select="photo/amount" /></span>
														</div>
													</td>
													<td style="width:30%;"></td>
												</tr>
											</table>
										</div>
									</div>
								</xsl:if>

								<div class="bigphoto">
									<p align="center" id="photoInContest" style="display:none;">Эта фотография участвует в <a href="/photos/contest/{photo/for_contest}/">конкурсе</a>.</p>
									<xsl:choose>
										<xsl:when test="photo/player = 0">
											<p class="error">По заданным критериям не найдены фотографии.</p>
										</xsl:when>
										<xsl:when test="count(photo/id) = 0 and photo/player/id = player/id">
											<p class="error">У вас еще нет фотографий, но вы можете закачать их.<br />За каждый голос вашей фотографии вы будете получать монеты.</p>
										</xsl:when>
										<xsl:when test="count(photo/id) = 0">
											<p class="error">У этого игрока нет фотографий.</p>
										</xsl:when>
										<xsl:otherwise>
											<b id="photoInProfile" style="display: none;">Эта фотография отображается в профиле.</b>
											<p id="newPhoto" style="display: none;"><b>Эта фотография еще не проверена модератором.</b></p>
											<p id="photoCanceled" style="display: none;"><b>Модератор отклонил эту фотографию.</b></p>
											
											<img id="img" rel="{photo/id}" src="{photo/src}" />
											<xsl:if test="photo/player/id = player/id or player/access/photos = 1">
												<div class="actions">
													<xsl:if test="player/access/photos = 1">
														<select id="photoAction" style="font-size: 8pt;">
															<option value="---">---</option>
															<option value="accept">Разрешить</option>
															<optgroup label="Запретить">
																<option value="cancel">Разрешены только настоящие фотографии</option>
																<option value="cancel">Чужая фотография</option>
																<option value="cancel">Фотография нарушает правила</option>
																<option value="cancel">Дубликат</option>
																<option value="cancel">Слишком темная</option>
																<option value="cancel">Ребенок без родителей</option>
																<option value="cancel">Плохое качество</option>
																<option value="cancel">Слишком много эффектов фотошопа</option>
																<option value="cancel">Cлишком вульгарно</option>
																<option value="cancel">Фотография перевернута</option>
																<option value="cancel">Другое</option>
															</optgroup>
														</select>
														<div class="button">
															<a class="f" onclick="photoAction($('#img').attr('rel'));">
																<i class="rl"></i>
																<i class="bl"></i>
																<i class="brc"></i>
																<div class="c">OK</div>
															</a>
														</div>
													</xsl:if>
													<xsl:if test="photo/player/id = player/id">
														<span class="dashedlink" onclick="photoSetInProfile($('#img').attr('rel'));">Разместить в профиле</span>&#160;
														<span class="dashedlink delete" onclick="photoDelete($('#img').attr('rel'));">Удалить фотку</span>
													</xsl:if>
												</div>
											</xsl:if>
										</xsl:otherwise>
									</xsl:choose>
								</div>

								<div class="thumbs" id="pers-photos-thumbs">
									<nobr>
										<xsl:for-each select="photos/element">
											<a href="#{id}" onclick="photoShow({position()-1});return false;">
												<xsl:if test="id = /data/photo/id">
													<xsl:attribute name="class">current</xsl:attribute>
												</xsl:if>
												<img src="{thumb_src}" />
											</a>
										</xsl:for-each>
									</nobr>
								</div>
								<script type="text/javascript">
									$("#pers-photos-thumbs a.current img")[0].scrollIntoView();
								</script>
								<div class="buttons">
									<div class="button" style="width: 32%">
										<a class="f" href="#" onclick="alleyAttack({photo/player/id});return false;">
											<i class="rl"></i>
											<i class="bl"></i>
											<i class="brc"></i>
											<div class="c">Атаковать</div>
										</a>
									</div>
									<div class="button" style="width: 32%">
										<a class="f" href="/phone/message/send/{photo/player/id}/">
											<i class="rl"></i>
											<i class="bl"></i>
											<i class="brc"></i>
											<div class="c">Написать сообщение</div>
										</a>
									</div>
									<div class="button" style="width: 32%">
										<a class="f" href="/shop/section/gifts/present/{photo/player/id}/{photo/player/nickname}/">
											<i class="rl"></i>
											<i class="bl"></i>
											<i class="brc"></i>
											<div class="c">Подарить подарок</div>
										</a>
									</div>
								</div>

								<xsl:if test="show_player_info = 1"><br/>
									<div class="pers-text">
										<div class="block-rounded clear">
											<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
											<xsl:if test="photo/player/custom_avatar != ''">
												<img class="avatar">
													<xsl:attribute name="src">/@images/<xsl:value-of select="photo/player/custom_avatar" /></xsl:attribute>
												</img>
											</xsl:if>
											<xsl:if test="photo/player2/name != ''">
												<b>Имя: </b> <xsl:value-of select="photo/player2/name" /><br />
											</xsl:if>
											<xsl:if test="photo/player/sex != ''">
												<b>Пол: </b> <xsl:choose>
													<xsl:when test="photo/player/sex = 'male'">Мужской</xsl:when>
													<xsl:when test="photo/player/sex = 'female'">Женский</xsl:when>
												</xsl:choose><br />
											</xsl:if>
											<xsl:if test="photo/player2/age != 0 and photo/player2/age &lt; 100">
												<b>Возраст: </b> <xsl:value-of select="photo/player2/age" /><br />
											</xsl:if>
											<xsl:if test="photo/player2/country != ''">
												<b>Страна: </b> <xsl:value-of select="photo/player2/country" /><br />
											</xsl:if>
											<xsl:if test="photo/player2/city != ''">
												<b>Город: </b> <xsl:value-of select="photo/player2/city" /><br />
											</xsl:if>
											<xsl:if test="photo/player2/metro != ''">
												<b>Метро: </b> <xsl:value-of select="photo/player2/metro" /><br />
											</xsl:if>
											<xsl:if test="photo/player2/business != ''">
												<b>Род занятий: </b> <xsl:value-of select="photo/player2/business" /><br />
											</xsl:if>
											<xsl:if test="photo/player2/interests != '' and count(photo/player2/interests/element) > 0">
												<b>Увлечения и хобби: </b>
												<xsl:for-each select="photo/player2/interests/element">
													<xsl:value-of select="name" />
													<xsl:if test="position() != last()">, </xsl:if>
												</xsl:for-each>
												<br />
											</xsl:if>
											<xsl:if test="photo/player2/vkontakte != '' or photo/player2/facebook != '' or photo/player2/twitter != '' or photo/player2/livejournal != '' or photo/player2/mailru != '' or photo/player2/odnoklassniki != '' or photo/player2/liveinternet != ''">
												<b>Я в соц. сетях: </b>
												<xsl:if test="photo/player2/vkontakte != ''"><a href="http://{photo/player2/vkontakte}" target="_blank"><i class="icon vkontakte-icon"></i></a></xsl:if>
												<xsl:if test="photo/player2/facebook != ''"><a href="http://{photo/player2/facebook}" target="_blank"><i class="icon facebook-icon"></i></a></xsl:if>
												<xsl:if test="photo/player2/twitter != ''"><a href="http://{photo/player2/twitter}" target="_blank"><i class="icon twitter-icon"></i></a></xsl:if>
												<xsl:if test="photo/player2/livejournal != ''"><a href="http://{photo/player2/livejournal}" target="_blank"><i class="icon livejournal-icon"></i></a></xsl:if>
												<xsl:if test="photo/player2/mailru != ''"><a href="http://{photo/player2/mailru}" target="_blank"><i class="icon moimir-icon"></i></a></xsl:if>
												<xsl:if test="photo/player2/odnoklassniki != ''"><a href="http://{photo/player2/odnoklassniki}" target="_blank"><i class="icon odnoklassniki-icon"></i></a></xsl:if>
												<xsl:if test="photo/player2/liveinternet != ''"><a href="http://{photo/player2/liveinternet}" target="_blank"><i class="icon liveinternet-icon"></i></a></xsl:if>
												<br />
											</xsl:if>
											<xsl:if test="photo/player2/about != ''">
												<xsl:value-of select="photo/player2/about" disable-output-escaping="yes" />
											</xsl:if>
										</div>
									</div>
								</xsl:if>
								<xsl:if test="count(photo/id) > 0">
									<div class="link">
										Ссылка на эту страницу: <input type="text" onclick="this.select()" value="http://moswar.ru/photos/{photo/player/id}/#{photo/id}" id="linkToThisPage" />
									</div>
								</xsl:if>
							</div>
						</xsl:when>
						<xsl:when test="mode = 'moderate'">
							<div class="photo-page">
								<h3 class="curves clear">Фото</h3>
								<ul class="photos-moderate-list clear">
									<xsl:for-each select="photos/element">
										<li id="photo{id}">
											<a href="/photos/{player_id}/#{id}"><img class="thumb" src="{src}" /></a><br />
											<xsl:call-template name="playerlink"><xsl:with-param name="href" select="'photos'" /><xsl:with-param name="player" select="current()" /></xsl:call-template><br />
											<xsl:if test="for_contest > 0"><p align="center">Эта фотография участвует в <a href="/photos/contest/{for_contest}/">конкурсе</a>.</p></xsl:if>
											<form id="url_form" method="post" action="http://www.tineye.com/search" target="_blank" style="float:left; margin-right:20px;">
                                                <input id="url_box" name="url" type="hidden" value="{src}" />
                                                <input id="url_submit" name="search_button" value="tineye.com" type="submit" />
                                            </form>
                                            <select id="photo-select-{id}" style="font-size: 8pt; width:230px;">
												<option value="---">---</option>
												<option value="accept">Разрешить</option>
												<optgroup label="Запретить">
													<option>Разрешены только настоящие фотографии</option>
													<option>Чужая фотография</option>
													<option>Фотография нарушает правила</option>
													<option>Дубликат</option>
													<option>Слишком темная</option>
													<option>Ребенок без родителей</option>
													<option>Плохое качество</option>
													<option>Слишком много эффектов фотошопа</option>
													<option>Cлишком вульгарно</option>
													<option>Фотография перевернута</option>
													<option>Другое</option>
												</optgroup>
											</select>
											<button onclick="photoModerate({id}, $('#photo-select-{id}').val());">OK</button>
										</li>
									</xsl:for-each>
								</ul>

								<xsl:call-template name="paginator">
									<xsl:with-param name="pages" select="pages2" />
									<xsl:with-param name="page" select="page" />
									<xsl:with-param name="link" select="'/photos/moderate/page/'" />
								</xsl:call-template>
								<xsl:if test="count(photos/element) = 0">
									<p align="center"><i>По заданным критериям фотографии не найдены.</i></p>
								</xsl:if>
							</div>
						</xsl:when>
						<xsl:otherwise>
							<xsl:call-template name="photo-top" />
							<div class="photo-page">
								<h3 class="curves clear">Фото</h3>
								<ul class="photos-preview-list clear">
									<xsl:for-each select="photos/element">
										<li>
											<a href="/photos/{player_id}/#{id}"><img class="thumb" src="{thumb_src}" /></a><br />
											<xsl:call-template name="playerlink"><xsl:with-param name="href" select="'photos'" /><xsl:with-param name="player" select="current()" /></xsl:call-template>
										</li>
									</xsl:for-each>
								</ul>

								<xsl:call-template name="paginator">
									<xsl:with-param name="pages" select="pages2" />
									<xsl:with-param name="page" select="page" />
									<xsl:with-param name="link" select="'/photos/page/'" />
								</xsl:call-template>
								<xsl:if test="count(photos/element) = 0">
									<p align="center"><i>По заданным критериям фотографии не найдены.</i></p>
								</xsl:if>
							</div>
						</xsl:otherwise>
					</xsl:choose>
					<!--</div>-->

					<div class="listing">
						<!--
						<div class="block-bordered">
							<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
							<div class="center clear">

								<ul class="list-users sorting-links">
									<li><a href="/photos/topphotos/">Топ фоток</a></li>
									<li><a href="/photos/toppeople/">Топ людей</a></li>
									<li><a href="/photos/newphotos/">Новые фотки</a><xsl:if test="todaynew > 0"><span title="Новых фотографий за сутки"> +<xsl:value-of select="todaynew" /></span></xsl:if></li>
									<li><a href="/photos/popular/">Популярные фотки</a></li>
								</ul>
								<h3>Люди</h3>
								<ul class="list-users">
									<xsl:for-each select="players/element">
										<li>
											<i class="{status}"></i>
											<xsl:call-template name="playerlink">
												<xsl:with-param name="href" select="'photos'" />
												<xsl:with-param name="player" select="current()" />
											</xsl:call-template>
										</li>
									</xsl:for-each>
								</ul>

								<xsl:call-template name="paginator">
									<xsl:with-param name="pages" select="pages" />
									<xsl:with-param name="page" select="page" />
									<xsl:with-param name="link" select="'/photos/page/'" />
									<xsl:with-param name="arrow_text" select="0" />
								</xsl:call-template>

								<h3>Поиск</h3>
								<form action="/photos/" method="post">
									<input type="hidden" name="action" value="search" />
									<table class="forms">
										<tr>
											<td class="label">Имя</td>
											<td class="input">
												<input class="name" name="nickname" type="text" value="{filter/name}" />
											</td>
										</tr>
										<tr>
											<td class="label">Пол</td>
											<td class="input">
												<select name="sex">
													<option value="">любой</option>
													<option value="male">
														<xsl:if test="filter/sex = 'male'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														муж.
													</option>
													<option value="female">
														<xsl:if test="filter/sex = 'female'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														жен.
													</option>
												</select>
											</td>
										</tr>
										<tr>
											<td class="label">Клан</td>
											<td class="input">
											-->
												<!--<select class="clan" name="clan">
																<option value="">любой</option>
																<xsl:for-each select="clans/element">
																	<option value="{id}">
																		<xsl:if test="/data/filter/clan = id"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
																		<xsl:value-of select="name" />
																	</option>
																</xsl:for-each>
															</select>-->
									<!--
												<input type="text" name="clan" class="clan" value="{/data/filter/clan}" />
											</td>
										</tr>
										<tr>
											<td class="label">Сорт.</td>
											<td class="input">
												<select name="sort">
													<option value="date">
														<xsl:if test="filter/sort = 'date'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														по дате
													</option>
													<option value="abc">
														<xsl:if test="filter/sort = 'abc'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														по алфавиту
													</option>
													<option value="rating">
														<xsl:if test="filter/sort = 'rating'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														по рейтингу
													</option>
													<option value="popular">
														<xsl:if test="filter/sort = 'popular'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														по популярности
													</option>
												</select>
											</td>
										</tr>
										<xsl:if test="player/access/photos">
											<tr>
												<td class="label">Статус</td>
												<td class="input">
													<select name="status">
														<option value="accepted">
															<xsl:if test="filter/status = 'accepted'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															проверенные
														</option>
														<option value="new">
															<xsl:if test="filter/status = 'new'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															новые
														</option>
														<option value="canceled">
															<xsl:if test="filter/status = 'canceled'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
															отклоненные
														</option>
													</select>
												</td>
											</tr>
										</xsl:if>
										<tr>
											<td class="label"></td>
											<td class="input">
												<button class="button" type="submit">
													<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div class="c">Искать</div>
													</span>
												</button>
											</td>
										</tr>
									</table>
								</form>

							</div>
							<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
						</div>
						-->
						<div class="block-bordered">
							<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
							<div class="center clear">

								<h3>Поиск</h3>
								<form action="/photos/" method="post">
									<input type="hidden" name="action" value="search" />
									<table class="forms">
										<tr>
											<td class="label">Имя</td>
											<td class="input">
												<input name="name" value="{filter/name}" class="name" type="text" style="width:130px" />
											</td>
										</tr>
										<tr>
											<td class="label">Клан</td>
											<td class="input">
												<input name="clan" class="name" value="{filter/clan}" type="text" style="width:130px" />
											</td>
										</tr>
										<tr>
											<td class="label">Сторона</td>
											<td class="input">
												<select name="fraction">
													<option>любая</option>
													<option value="resident">
														<xsl:if test="filter/fraction = 'resident'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														коренные
													</option>
													<option value="arrived">
														<xsl:if test="filter/fraction = 'arrived'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														понаехавшие
													</option>
												</select>
											</td>
										</tr>
										<tr>
											<td class="label">Уровень</td>
											<td class="input">
												<select name="level">
													<option>любой</option>
													<option value="11"><xsl:if test="filter/level = '11'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>11</option>
													<option value="10"><xsl:if test="filter/level = '10'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>10</option>
													<option value="9"><xsl:if test="filter/level = '9'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>9</option>
													<option value="8"><xsl:if test="filter/level = '8'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>8</option>
													<option value="7"><xsl:if test="filter/level = '7'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>7</option>
													<option value="6"><xsl:if test="filter/level = '6'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>6</option>
													<option value="5"><xsl:if test="filter/level = '5'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>5</option>
													<option value="4"><xsl:if test="filter/level = '4'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>4</option>
													<option value="3"><xsl:if test="filter/level = '3'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>3</option>
													<option value="2"><xsl:if test="filter/level = '2'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>2</option>
													<option value="1"><xsl:if test="filter/level = '1'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>1</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<hr />
											</td>
										</tr>
										<tr>
											<td class="label">Страна</td>
											<td class="input">
												<select name="country" onchange="loadPhotosSearchCities(this.value);" style="width:130px">
													<xsl:value-of select="countries" disable-output-escaping="yes" />
												</select>
											</td>
										</tr>
										<tr>
											<td class="label">Город</td>
											<td class="input">
												<select name="city" onchange="loadPhotosSearchMetros(this.value);" style="width:130px" id="city-select">
													<xsl:value-of select="cities" disable-output-escaping="yes" />
												</select>
											</td>
										</tr>
										<tr>
											<td class="label">Метро</td>
											<td class="input">
												<select name="metro" style="width:130px" id="metro-select">
													<xsl:value-of select="metros" disable-output-escaping="yes" />
												</select>
											</td>
										</tr>
										<tr>
											<td class="label">Пол</td>
											<td class="input">
												<select name="sex" onchange="loadPhotosSearchFamilies(this.value);" style="width:130px">
													<option value="">любой</option>
													<option value="male">
														<xsl:if test="filter/sex = 'male'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														муж.
													</option>
													<option value="female">
														<xsl:if test="filter/sex = 'female'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														жен.
													</option>
												</select>
											</td>
										</tr>
										<tr>
											<td class="label"><nobr>Сем. пол.</nobr></td>
											<td class="input">
												<select name="family" style="width:130px" id="family-select">
													<xsl:value-of select="families" disable-output-escaping="yes" />
												</select>
											</td>
										</tr>
										<tr>
											<td class="label"><nobr>Возраст</nobr></td>
											<td class="input">
												от <input name="age_from" value="{filter/age_from}" type="text" style="width: 43px;" />
												до <input name="age_to" value="{filter/age_to}" type="text" style="width: 43px;" />
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<hr />
											</td>
										</tr>
										<tr>
											<td class="label">Сорт.</td>
											<td class="input">
												<select name="sort">
													<option value="date">
														<xsl:if test="filter/sort = 'date'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														по дате
													</option>
													<option value="abc">
														<xsl:if test="filter/sort = 'abc'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														по алфавиту
													</option>
													<option value="rating">
														<xsl:if test="filter/sort = 'rating'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														по рейтингу
													</option>
													<option value="popular">
														<xsl:if test="filter/sort = 'popular'"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
														по популярности
													</option>
												</select>
											</td>
										</tr>

										<tr>
											<td class="label"></td>
											<td class="input">
												<button class="button" type="submit">
													<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div class="c">Искать</div>
													</span>
												</button>
											</td>
										</tr>
									</table>
								</form>
							</div>
							<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
						</div>
						<xsl:if test="player/access/photos = 1 and mode != 'moderate'">
						<center><a href="/photos/moderate/">Модерация фотографий</a></center>
						</xsl:if>
					</div>

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
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'upload' and $result/params/successes = 0"><p class="error" align="center">К сожалению, при закачке Ваших фотографий произошла ужасная ошибка, и они потерялись. Попробуйте еще раз, пожалуйста. <xsl:if test="$result/params/smallsize > 0"><b><xsl:value-of select="$result/params/smallsize" /></b>&#0160;<xsl:value-of select="$result/params/words/smallsize" /> слишком маленького размера.</xsl:if></p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'photos' and $result/action = 'upload' and $result/params/successes > 0"><p class="success" align="center">Вы молодец, что закачали фотографии. Они появятся после проверки модератором. <xsl:if test="$result/params/successes &lt; $result/params/total">Вы закачали <b><xsl:value-of select="$result/params/successes" /></b>&#0160;<xsl:value-of select="$result/params/words/successes" /> из <xsl:value-of select="$result/params/total" />. <xsl:if test="$result/params/smallsize > 0"><b><xsl:value-of select="$result/params/smallsize" /></b>&#0160;<xsl:value-of select="$result/params/words/smallsize" /> слишком маленького размера.</xsl:if></xsl:if></p></xsl:when>
			<xsl:otherwise><xsl:value-of select="$result" /></xsl:otherwise>
		</xsl:choose>

	</xsl:template>

</xsl:stylesheet>
