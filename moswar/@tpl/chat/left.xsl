<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>
	<xsl:template match="/data">
		<html><head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Понаехали</title>
				<link rel="icon" href="/favicon.ico" type="image/x-icon" />
				<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
				<link rel="stylesheet" type="text/css" href="/@/css/style.css" />
				<script type="text/javascript" src="/@/js/script.js"></script>
				<base target="game-frame" />
			</head>

			<body onresize="chatLeftResize();">

				<script>
					$(document).ready(function(){
						chatLeftResize();
						var flashvars = {};
						var params = {};
						params.allowscriptaccess = "always";
						var attributes = {};
						attributes.type = "application/x-shockwave-flash";
						attributes.id = "chatswf";
						attributes.name = "chat";
						swfobject.embedSWF("/@/swf/Chat.swf", "chatSwf", "1", "1", "9.0.0", "expressInstall.swf", flashvars, params, attributes);

					});
					function q(){
						Chat.actionMessage();
						return false;
					}
				</script>
				<div id="chatSwf"></div>
				<div class="chat chat-left" id="chat-left">
					<div class="chat-cover">
						<div id="chat-headline" class="chat-headline">
							<div class="chat-size-controls">
								<i class="icon chat-size-controls-left" title="Уменьшить ширину чата" onclick="chatWidthChange('left');"></i>
								<i class="icon chat-size-controls-right" title="Увеличить ширину чата" onclick="chatWidthChange('right');"></i>
								<i class="icon reload-icon" title="Обновить чат" onclick="self.location.reload(true)"></i>
								<i class="icon chat-size-controls-bottomside" title="Чат снизу" onclick="chatFramesLayout('bottom');"></i>
								<i class="icon chat-size-controls-close" title="Закрыть чат" onclick="chatClose()"></i>
							</div>
							<i class="icon chat-headline-icon">Чат</i>
							<b class="title"><span id="chat-room-name"></span> (<span id="chat-room-people-number">0</span>)</b>
							<span class="links">
								<a href="/chat/rooms/">Сменить комнату</a> &#160;
								<a href="/licence/rules/">Правила чата</a>
							</span>
						</div>

						<table class="chat-layout">
							<tr>
								<td class="chat-layout-right">
									<div class="chat-users" id="users">
										<ul id="users-list" class="list-users">

										</ul>
									</div>
								</td>
							</tr>
							<tr>
								<td class="chat-layout-left">
									<div class="chat-messages" id="messages">

									</div>
								</td>
							</tr>
						</table>

						<div id="chat-footerline" class="chat-footerline clear">
							<div id="input">
								<form action="" method="post" onsubmit="return q();">
									<table>
										<tr>
											<td class="text-cell">
												<input id="text" name="text" value="" size="60" maxlength="256" type="text" />
											</td>
										</tr>
										<tr>
											<td class="submit-cell">

												<button class="button" type="submit">
													<span class="f">
														<i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div class="c">Сказать</div>
													</span>
												</button>

												<div class="smiles-place">
													<i class="icon chat-smiles-icon" title="Вставить смайлик" onclick="$('#overtip-smiles').toggle();"></i>
													<div class="overtip" id="overtip-smiles" style="display: none;">
														<div class="help">
															<h2>Смайлики ;-)</h2>
															<div class="data">
																<div id="smiles" rel="text" alt="1">
																	<xsl:for-each select="smiles/element">
																		<img src="/@/images/smile/{current()}.gif" alt="{current()}" />
																	</xsl:for-each>
																</div>
																<div class="actions">
																	<div class="button" onclick="$('#overtip-smiles').hide();">
																		<span class="f">
																			<i class="rl"></i><i class="bl"></i><i class="brc"></i>
																			<div class="c">Отмена</div>
																		</span>
																	</div>
																</div>
																<i class="tail-bottom"></i>
															</div>
														</div>
													</div>
												</div>
												<i class="chat-clear-icon" title="Очистить чат" onclick="Chat.clear();"></i>
											</td>
										</tr>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
					chatLeftResize();
					});
				</script>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>