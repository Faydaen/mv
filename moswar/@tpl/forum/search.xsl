<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/playerlink.xsl" />
    <xsl:include href="common/forum-error.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Форум</h2>
				</div>
				<div id="content" class="forum">
					<div class="path">
						<a href="/forum/">Форум</a>&#160;&#8594;&#160;Результаты поиска&#160;&#8595;
					</div>
					<h1>Результаты поиска</h1>

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

					<xsl:if test="count(result) > 0">
						<div class="report">
							<xsl:call-template name="error">
								<xsl:with-param name="result" select="result" />
							</xsl:call-template>
						</div>
					</xsl:if>

					<ul class="posts">
						<xsl:for-each select="posts/element">
							<xsl:call-template name="post-item">
								<xsl:with-param name="post" select="current()" />
							</xsl:call-template>
						</xsl:for-each>
					</ul>

				</div>
			</div>
		</div>
    </xsl:template>

	<xsl:template name="post-item">
		<xsl:param name="post" />
		<li class="li">
			<table class="forms">
				<tr>
					<td class="label">
						<a name="p{$post/id}" />
						<xsl:if test="$post/player/thumb != ''">
							<img src="/@/images/pers/{$post/player/thumb}" class="avatar" />
							<br />
						</xsl:if>
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
									<a href="/forum/post/{$post/id}/">#<xsl:value-of select="id" /></a>&#160;&#8729;&#160;
									<span><xsl:value-of select="$post/dt" /></span>&#160;&#8729;&#160;
									<a href="/forum/topic/{$post/topic/id}/" style="white-space:normal;"><xsl:value-of select="$post/topic/name" disable-output-escaping="yes" /></a>
								</nobr>
							</div>
						</div>
						<span>
							<xsl:choose>
								<xsl:when test="count($post/player/accesslevel) > 0 and $post/player/accesslevel >= 50"><xsl:attribute name="class">admin</xsl:attribute></xsl:when>
								<xsl:otherwise><xsl:attribute name="class">text</xsl:attribute></xsl:otherwise>
							</xsl:choose>
							<xsl:value-of select="$post/text" disable-output-escaping="yes" />
						</span>
					</td>
				</tr>
			</table>
		</li>
	</xsl:template>
</xsl:stylesheet>