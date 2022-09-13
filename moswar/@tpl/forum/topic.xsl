<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl" version="1.0">
    <xsl:output method="html"/>

	<xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/paginator.xsl" />
    <xsl:include href="common/topic-item.xsl" />
    <xsl:include href="common/forum-error.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Форум</h2>
				</div>
				<div id="content" class="forum">
					<div class="path">
						<a href="/forum/">Форум</a>&#160;&#8594;&#160;<a href="/forum/{forum/id}"><xsl:value-of select="forum/name"/></a>&#160;&#8595;
					</div>
					<h1><xsl:value-of select="forum/name"/></h1>

					<xsl:if test="player/access/forum_openclose_forum = 1">
						<xsl:choose>
							<xsl:when test="forum/closed = 0">
								<button title="Закрыть форум" class="button" type="button" onclick="forumCloseForum({forum/id});">
									<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										<div class="c">Закрыть</div>
									</span>
								</button>
							</xsl:when>
							<xsl:otherwise>
								<button title="Открыть форум" class="button" type="button" onclick="forumOpenForum({forum/id});">
									<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										<div class="c">Открыть</div>
									</span>
								</button>
							</xsl:otherwise>
						</xsl:choose>
					</xsl:if>

					<xsl:if test="count(result) > 0">
						<xsl:call-template name="error">
							<xsl:with-param name="result" select="result" />
						</xsl:call-template>
					</xsl:if>

					<xsl:if test="action = 'delete'">
						<div class="report">
							<xsl:choose>
								<xsl:when test="result = 1">
									<div class="success">Тема успешно удалена.</div>
								</xsl:when>
								<xsl:otherwise>
									<div class="error">Произошла ошибка при удалении темы.</div>
								</xsl:otherwise>
							</xsl:choose>
						</div>
					</xsl:if>
					
					<xsl:choose>
						<xsl:when test="count(topic/element) > 0">
							<ul class="topics">
							<table class="topic-line">
								<tr>
									<th class="read">&#160;</th>
									<th class="name">Тема</th>
									<th class="author">Автор</th>
									<th class="replies">Ответов</th>
									<th class="last">Последнее сообщение</th>
								</tr>
								<xsl:for-each select="topic/element">
									<xsl:call-template name="topic-item" />
								</xsl:for-each>
								</table>
							</ul>
						</xsl:when>
						<xsl:otherwise>
							<center><i>Нет тем.</i></center>
						</xsl:otherwise>
					</xsl:choose>

					<xsl:call-template name="paginator">
						<xsl:with-param name="pages" select="pages" />
						<xsl:with-param name="page" select="page" />
						<xsl:with-param name="link" select="concat('/forum/', forum/id, '/')" />
					</xsl:call-template>

					<br />

					<xsl:choose>
						<xsl:when test="player/id = 0 or count(player/id) = 0">
							<div class="report"><p class="error">Бу! Для создания новых тем необходимо <a href="/">авторизироваться</a>.</p></div>
						</xsl:when>
						<xsl:when test="forum/closed = 1">
							<div class="report"><p class="error">Форум закрыт, вах.</p></div>
						</xsl:when>
					</xsl:choose>

					<xsl:choose>
						<xsl:when test="player/mute_forum > servertime">
							<p class="error" align="center">Вы наказаны и не можете общаться на форуме до <b><xsl:value-of select="php:function('date', 'd.m.Y H:i:s', string(player/mute_forum))" /></b>.</p>
						</xsl:when>
						<xsl:when test="player/level &lt; minlevel">
							<p class="error" align="center">Создавать обсуждения можно только со <xsl:value-of select="minlevel" />-го уровня.</p>
						</xsl:when>
						<xsl:when test="player/id > 0 and (forum/closed = 0 or (forum/closed = 1 and player/accesslevel = 100))">
						<div class="block-bordered">
							<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
							<div class="center clear">
								<form action="/forum/" method="post" onsubmit="$('#buttonSubmit').addClass('disabled');return true;">
								<input type="hidden" name="action" value="new topic"/>
								<input type="hidden" name="forum" value="{forum/id}"/>
								<h3>Новое обсуждение:</h3>
								<xsl:choose>
									<xsl:when test="text-error = 1">
										<p class="error">Текст не введен.</p>
									</xsl:when>
									<xsl:when test="name-error = 1">
										<p class="error">Заголовок не введен.</p>
									</xsl:when>
								</xsl:choose>
								<table class="forms">
									<tr>
										<td class="label">Заголовок: *</td>
										<td class="input"><input type="text" name="name"/></td>
									</tr>
									<!--
									<tr>
										<td class="label">Вопрос:</td>
										<td class="input"><input type="text" name="question" /></td>
									</tr>
									<tr>
										<td class="label">Варианты: <a href="javascript:forumAddVoteOption();return false;">добавить</a>&#0160;<a href="javascript:forumRemoveVoteOption();return false;">удалить</a></td>
										<td class="input"><p><input type="text" name="option[]" /></p>
										<p><input type="text" name="option[]" /></p></td>
									</tr>
									-->
									<tr>
										<td class="label">Текст: *</td>
										<td class="input"><textarea name="text" id="posttext"></textarea></td>
									</tr>
									<tr>
										<td class="label"><div onclick="$('#smiles').toggle();">Смайлы</div></td>
										<td>
										<div id="smiles" rel="posttext" style="display: none;">
											<xsl:for-each select="smiles/element">
												<img src="/@/images/smile/{current()}.gif" alt="{current()}" />
											</xsl:for-each>
										</div></td>
									</tr>
									<tr>
										<td class="label"></td>
										<td class="input">
											<button class="button" type="submit" id="buttonSubmit">
												<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
													<div class="c">Отправить</div>
												</span>
											</button>
										</td>
									</tr>
								</table>
							</form>
							</div>
							<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
						</div>
						</xsl:when>
					</xsl:choose>

				</div>
			</div>
		</div>
    </xsl:template>
</xsl:stylesheet>
