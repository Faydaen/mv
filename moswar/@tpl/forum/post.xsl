<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/paginator.xsl" />
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
					<h1><xsl:value-of select="topic/name" disable-output-escaping="yes" /></h1>

					<xsl:if test="count(result) > 0">
						<div class="report">
							<xsl:call-template name="error">
								<xsl:with-param name="result" select="result" />
							</xsl:call-template>
						</div>
					</xsl:if>

						<xsl:if test="player/access/forum_move_topic = 1">
							<input type="hidden" name="action" value="move topic" />
							<select name="forum" id="forumId">
								<xsl:for-each select="forums/element">
									<option value="{id}">
										<xsl:if test="id = /data/forum/id"><xsl:attribute name="selected">selected</xsl:attribute></xsl:if>
										<xsl:value-of select="name" />
									</option>
								</xsl:for-each>
							</select>&#0160;
							<button title="Перенести тему" class="button" type="button" onclick="forumMoveTopic({topic/id}, $('#forumId').val());">
								<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
									<div class="c">Перенести</div>
								</span>
							</button>&#0160;
						</xsl:if>
						<xsl:if test="player/access/forum_hide_topic = 1 or player/access/forum_delete_topic = 1 or topic/moderatable = 1">
							<button title="Удалить тему" class="button" type="button" onclick="forumDeleteTopic({topic/id}, {forum/id});">
								<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
									<div class="c">Удалить тему</div>
								</span>
							</button>&#0160;
						</xsl:if>
						<xsl:if test="player/access/forum_openclose_topic = 1 or topic/moderatable = 1">
							<xsl:choose>
								<xsl:when test="/data/topic/closed = 0">
									<button title="Закрыть обсуждение" class="button" type="button" onclick="forumCloseTopic({topic/id});">
										<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Закрыть</div>
										</span>
									</button>&#0160;
								</xsl:when>
								<xsl:otherwise>
									<button title="Открыть обсуждение" class="button" type="button" onclick="forumOpenTopic({topic/id});">
										<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Открыть</div>
										</span>
									</button>&#0160;
								</xsl:otherwise>
							</xsl:choose>
						</xsl:if>

					<xsl:if test="action = 'delete'">
						<div class="report">
							<xsl:choose>
								<xsl:when test="result = 1">
									<div class="success">Сообщение успешно удалено.</div>
								</xsl:when>
								<xsl:otherwise>
									<div class="error">Произошла ошибка при удалении сообщения.</div>
								</xsl:otherwise>
							</xsl:choose>
						</div>
					</xsl:if>

					<!--<xsl:if test="topic/question != ''">
						<xsl:choose>
							<xsl:when test="action = 'vote' and result = 1">
								<p class="report"><span class="success">Ваш голос засчитан.</span></p>
							</xsl:when>
						</xsl:choose>
						<div class="vote">
							Вопрос: <b><xsl:value-of select="topic/question" /></b><br />
							<xsl:choose>
								<xsl:when test="vote/voted = 0">
									<form action="/forum/topic/{topic/id}/" method="post">
										Голосовать:<br />
										<table border="1" cellpadding="1" cellspacing="1" width="200">
											<input type="hidden" name="action" value="vote" />
											<xsl:for-each select="vote/options/element">
												<tr>
													<td width="50"><input type="radio" name="option" value="{id}" id="option{topic/id}" /></td>
													<td width="150"><label for="option{topic/id}"><xsl:value-of select="option" /></label></td>
												</tr>
											</xsl:for-each>
											<tr>
												<td colspan="2" align="center"><input type="submit" name="submit" value="Голосовать" /></td>
											</tr>
										</table>
									</form>
								</xsl:when>
								<xsl:otherwise>
									Результаты:<br />
									<table border="0" cellpadding="1" cellspacing="1">
										<xsl:for-each select="vote/results/element">
											<tr>
												<td><xsl:value-of select="option" /></td>
												<td><xsl:value-of select="amount" /> (<xsl:value-of select="procent" />%)</td>
											</tr>
										</xsl:for-each>
									</table>
								</xsl:otherwise>
							</xsl:choose>
						</div>
					</xsl:if>-->

					<ul class="posts">
						<xsl:for-each select="post/element">
							<xsl:call-template name="post-item">
								<xsl:with-param name="post" select="current()" />
							</xsl:call-template>
						</xsl:for-each>
					</ul>

					<xsl:call-template name="paginator">
						<xsl:with-param name="pages" select="pages" />
						<xsl:with-param name="page" select="page" />
						<xsl:with-param name="link" select="concat('/forum/topic/', topic/id, '/')" />
					</xsl:call-template>

					<xsl:choose>
						<xsl:when test="player/id = 0 or count(player/id) = 0">
							<div class="report"><p class="error">Для создания новых тем необходимо <a href="/">авторизироваться</a>.</p></div>
						</xsl:when>
						<xsl:when test="topic/closed = 1">
							<div class="report"><p class="error">Обсуждение закрыто.</p></div>
						</xsl:when>
					</xsl:choose>

					<xsl:choose>
						<xsl:when test="player/mute_forum > servertime">
							<p class="error" align="center">Вы наказаны и не можете общаться на форуме до <b><xsl:value-of select="php:function('date', 'd.m.Y H:i:s', string(player/mute_forum))" /></b>.</p>
						</xsl:when>
						<xsl:when test="player/level &lt; minlevel">
							<p class="error" align="center">Оставлять комментарии можно только со <xsl:value-of select="minlevel" />-го уровня.</p>
						</xsl:when>
						<xsl:when test="player/id > 0 and (topic/closed = 0 or (topic/closed = 1 and player/accesslevel = 100))">
							<div class="block-bordered">
								<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
								<div class="center clear">
									<form action="/forum/" method="post" onsubmit="$('#buttonSubmit').addClass('disabled');return true;">
										<input type="hidden" name="topic" value="{topic/id}"/>
										<input type="hidden" name="action" value="new post"/>
										<h3>Ваше сообщение:</h3>
										<xsl:choose>
											<xsl:when test="text-error = 1">
												<p class="error">Текст не введен.</p>
											</xsl:when>
										</xsl:choose>
										<table class="forms">
											<tr>
												<td class="label">Текст:</td>
												<td class="input"><textarea name="text" id="posttext"></textarea></td>
											</tr>
											<tr>
												<td class="label"><div onclick="$('#smiles').toggle(); $('#smiles-hint').toggle();"><span class="dashedlink">Смайлы</span></div></td>
												<td>
												<div id="smiles-hint">скрыты от эпилептиков</div>
												<div id="smiles" rel="posttext" style="display: none;">
													<xsl:for-each select="smiles/element">
														<img src="/@/images/smile/{current()}.gif" alt="{current()}" />
													</xsl:for-each>
												</div></td>
											</tr>
											<tr>
												<td class="label"></td>
												<td class="input">
													<button id="buttonSubmit" class="button" type="submit">
														<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
															<div class="c">Написать</div>
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

	<xsl:template name="post-item">
		<xsl:param name="post" />
		<li id="post-{$post/id}-li">
            <xsl:choose>
                <xsl:when test="$post/deleted = 1"><xsl:attribute name="class">li deleted</xsl:attribute></xsl:when>
                <xsl:otherwise><xsl:attribute name="class">li</xsl:attribute></xsl:otherwise>
            </xsl:choose>
			<table class="forms">
				<tr>
					<td class="label">
						<a name="p{$post/id}" />
						<img src="{$post/player/thumb}" class="avatar">
						<xsl:choose>
							<xsl:when test="count($post/player/forum_avatar) > 0 and (/data/player/forum_show_useravatars = 1)">
								<xsl:attribute name="src">/@images/<xsl:value-of select="$post/player/forum_avatar" /></xsl:attribute>
							</xsl:when>
							<xsl:otherwise>
								<xsl:attribute name="src">/@/images/pers/<xsl:value-of select="php:function('str_replace', '.png', '_thumb.png', string($post/player/avatar))" /></xsl:attribute>
							</xsl:otherwise>
						</xsl:choose>
						</img>
					</td>
					<td>
						<div class="clear" style="margin-bottom:5px;">
							<div class="author" style="float:left;">
								<nobr><xsl:call-template name="playerlink">
									<xsl:with-param name="player" select="$post/player" />
								</xsl:call-template>:</nobr>
							</div>
							<div class="date">
								<nobr>
									<a href="/forum/topic/{topic}/{/data/page}/#p{id}">#<xsl:value-of select="id" /></a>&#160;&#8729;&#160;
									<span><xsl:value-of select="$post/dt" /></span>
									<xsl:if test="$post/deleted = 0">&#160;&#8729;&#160;<span class="dashedlink" onclick="forumQuote($(this).parents('li:first'));">Цитата</span></xsl:if>
									<xsl:if test="/data/player/access/forum_hide_post = 1 or /data/player/access/forum_delete_post = 1 or /data/topic/moderatable = 1">
										<xsl:choose>
											<xsl:when test="/data/topic/startpost = $post/id">
											</xsl:when>
											<xsl:otherwise>
												<xsl:if test="$post/deleted = 0">&#160;&#8729;&#160;<span id="post-{$post/id}-dellink" class="dashedlink" style="color:red; border-color:red;" onclick="forumDeletePost({$post/id}, {$post/topic});">Удалить</span></xsl:if>
											</xsl:otherwise>
										</xsl:choose>
										<!--
										<button title="Прикрепить важную тему" class="button" type="button" onclick="forumPinTopic({$post/topic}, {/data/forum/id});">
											<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
											<div class="c">Прикрепить</div>
											</span>
										</button>&#0160;
										-->
									</xsl:if>
								</nobr>
							</div>
						</div>
						<span>
							<xsl:choose>
								<xsl:when test="count($post/player/accesslevel) > 0 and $post/player/accesslevel = 100"><xsl:attribute name="class">admin</xsl:attribute></xsl:when>
                                <xsl:when test="count($post/player/clan) > 0 and $post/player/clan/id = 14"><xsl:attribute name="class">moderator</xsl:attribute></xsl:when>
								<xsl:otherwise><xsl:attribute name="class">text</xsl:attribute></xsl:otherwise>
							</xsl:choose>
							<xsl:value-of select="$post/text" disable-output-escaping="yes" />
						</span>
                        <xsl:if test="$post/deleted = 1">
                            <div class="deletedby">
                            Удалено модератором <nobr><xsl:call-template name="playerlink">
									<xsl:with-param name="player" select="$post/deletedbydata" />
								</xsl:call-template></nobr>&#160;<xsl:value-of select="$post/deleteddt" />
                            </div>
                        </xsl:if>
					</td>
				</tr>
			</table>
		</li>
	</xsl:template>

</xsl:stylesheet>