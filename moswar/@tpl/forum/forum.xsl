<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/topic-item.xsl" />
    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/forum-error.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Форум</h2>
				</div>
				<div id="content" class="forum">
					<xsl:if test="count(result) > 0">
						<xsl:call-template name="error">
							<xsl:with-param name="result" select="result" />
						</xsl:call-template>
					</xsl:if>
					
					<form class="search" action="/forum/" method="post" align="center">
						<div class="block-bordered">
							<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
							<div class="center clear">
								<input type="hidden" name="action" value="search" />
								<b>Поиск по форуму:</b>&#160;
								<input type="text" name="text" value="{searchtext}" style="width: 200px;" />&#160;
								<button title="Искать" class="button" type="submit">
									<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										<div class="c">Искать</div>
									</span>
								</button>
							</div>
							<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
						</div>
					</form>					
					
					<xsl:choose>
						<xsl:when test="count(forum/element) > 0">
							<ul class="forums">
								<xsl:for-each select="forum/element">
									<xsl:call-template name="forum-item" />
								</xsl:for-each>
							</ul>
						</xsl:when>
						<xsl:otherwise>
							<p align="center"><i>Нет форумов.</i></p>
						</xsl:otherwise>
					</xsl:choose>
				</div>
			</div>
		</div>
    </xsl:template>
	
	<xsl:template name="forum-item">
		<li class="li">
			<h2><a href="/forum/{id}/"><xsl:value-of select="name" /></a><div class="hint"><xsl:value-of select="desc" /></div></h2>
			<div class="data">
				<xsl:choose>
					<xsl:when test="count(topic/element) > 0">
						<table class="topic-line">
							<tr>
								<th class="read">&#0160;</th>
								<th class="name">Тема</th>
								<th class="author">Автор</th>
								<th class="replies">Ответов</th>
								<th class="last">Последнее сообщение</th>
							</tr>
							<xsl:for-each select="topic/element">
								<xsl:call-template name="topic-item" />
							</xsl:for-each>
						</table>
						<center><a href="/forum/{id}/">Все обсуждения</a></center>
					</xsl:when>
					<xsl:otherwise>
						<p align="center"><br /><i>Нет ни одного топика в этом форуме. Вы можете <a href="/forum/{id}/">создать</a> первый.</i></p>
					</xsl:otherwise>
				</xsl:choose>
			</div>
		</li>
	</xsl:template>

</xsl:stylesheet>
