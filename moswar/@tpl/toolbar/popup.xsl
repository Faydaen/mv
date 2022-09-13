<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN" indent="yes" />
	<xsl:include href="common/playerlink.xsl" />
	<xsl:template match="/data">
		<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Понаехали</title>
				<link rel="icon" href="http://www.moswar.ru/favicon.ico" type="image/x-icon" />
				<link rel="shortcut icon" href="http://www.moswar.ru/favicon.ico" type="image/x-icon" />
				<link rel="stylesheet" type="text/css" href="http://www.moswar.ru/@/css/style.css" />
				<script type="text/javascript" src="http://www.moswar.ru/@/js/script.js"></script>
				<style>
.toolbar-window { background:#fff9ee; overflow:hidden; }
.toolbar-window-padding { background:#fff4de; padding:15px 15px 15px 25px; width:358px; height:218px; border:1px solid #8d887f; }
.toolbar-window .personal#personal { font-size:12px; position:relative; left:-10px; width:auto; height:auto; //height:64px; min-height:64px; color:#945903; padding:10px 10px 10px 90px; background:#fcd05c; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px; float:left; }
.toolbar-window .personal .user { white-space:nowrap; }
.toolbar-window .personal .phone { margin:2px 0; }
.toolbar-window .personal .phone .icon { margin-left:0; }
.toolbar-window .personal .tugriki i { margin-left:0; position:relative; left:-1px; }
.toolbar-window .personal .avatar { position:absolute; left:4px; top:3px; background:url(/@/images/decor/personal.png) 0 -520px; width:64px; height:64px; padding:7px 7px 6px 6px; }
.toolbar-window .personal .avatar img { background:#fcde91; }
.toolbar-window .busy { font-weight:bold; margin:15px 0; }
.toolbar-window .busy .timeleft { padding:1px 3px; margin:0 5px; font-weight:normal; font-size:11px; color:#945903; background:#fae3b4;  -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px; }
.toolbar-window .busy .cancel { font-weight:normal; font-size:11px; }
.toolbar-window .play { margin:18px 0; text-align:center; }
.toolbar-window .links a,
.toolbar-window .links a:link,
.toolbar-window .links a:visited { color:#1e75d8; font-weight:bold; }
.toolbar-window .links a.new { color:red; }
.toolbar-window .links a.stash { color:#dd6d00; }
				</style>
			</head>
			<body class="toolbar-window">
				<div class="toolbar-window-padding">

					<table>
						<tr>
							<td width="50%">
								<div class="personal" id="personal">
						Привет,
									<br />
									<xsl:call-template name="playerlink">
										<xsl:with-param name="player" select="current()" />
									</xsl:call-template>
									<div class="phone phone-attention">
										<i class="icon"></i>
										<a href="/phone/" target="_blank">Телефон</a>
										<xsl:if test="newmes > 0 or newlogs > 0 or newduellogs > 0">
											&#0160;(<xsl:if test="newmes > 0"><a href="/phone/messages/" title="Новые сообщения" target="_blank"><xsl:value-of select="newmes" /></a></xsl:if>
											<xsl:if test="newlogs > 0"><xsl:if test="newmes > 0">&#0160;</xsl:if><a href="/phone/logs/" title="Новые логи"><xsl:value-of select="newlogs" /></a></xsl:if>
											<xsl:if test="newduellogs > 0"><xsl:if test="newmes > 0 or newlogs > 0">&#0160;</xsl:if><a href="/phone/duels/" title="Новые дуэли"><xsl:value-of select="newduellogs" /></a>
											</xsl:if>)
										</xsl:if>
									</div>
									<div>
										<span class="tugriki">
											<i></i><xsl:value-of select="money" />
										</span>
									</div>
									<i class="avatar">
										<xsl:choose>
											<xsl:when test="avatar != ''">
												<img src="http://img.moswar.ru{avatar}" />
												<br />
											</xsl:when>
											<xsl:otherwise>
												<img src="http://www.moswar.ru/@/images/pers/general_thumb.png" />
												<br />
											</xsl:otherwise>
										</xsl:choose>
									</i>
								</div>
							</td>
							<td align="center" style="vertical-align:middle;">
								<a href="http://www.moswar.ru/" target="_blank">
									<img src="http://img.moswar.ru/@/images/logo-tiny.png" style="margin:0;" />
								</a>
							</td>
						</tr>
					</table>
					
					<xsl:if test="busy_title != ''">
						<div class="busy">
				Занятость:
							<xsl:value-of select="busy_title" />
							<span class="timeleft" timer="{busy_timer}"><xsl:value-of select="busy_timer2" /></span>
							<a href="http://www.moswar.ru/{busy_location}/" class="cancel" target="_blank">Улизнуть</a>
						</div>
					</xsl:if>
					<div class="play">
						<div class="button">
							<a href="http://www.moswar.ru/" class="f">
								<i class="rl"></i>
								<i class="bl"></i>
								<i class="brc"></i>
								<div class="c">Войти в игру</div>
							</a>
						</div>
					</div>
					<table class="links">
						<tr>
							<td>
								<a href="http://www.moswar.ru/player/" target="_blank" >Персонаж</a>
							</td>
							<td>
								<a href="http://www.moswar.ru/alley/" target="_blank" >Закоулки</a>
							</td>
							<td>
								<a href="http://www.moswar.ru/stash/" class="stash" target="_blank">Заначка</a>
							</td>
							<td>
								<a href="http://www.moswar.ru/news/" class="new" target="_blank">Новости</a>
							</td>
							<td>
								<a href="http://forum.theabyss.ru/?act=external&amp;project=moswar&amp;session={session}" target="_blank" >Форум</a>
							</td>
						</tr>
					</table>
				</div>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>