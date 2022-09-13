<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
            <div class="heading clear">
                <h2>Чат</h2>
            </div>
            <div id="content" class="agreement">
                <div class="welcome">
                <div class="block-rounded">
                    <i class="tlc"></i>
                    <i class="trc"></i>
                    <i class="blc"></i>
                    <i class="brc"></i>
                    <div class="text">

						<p>Хочешь общаться? Докажи, что ты человек — введи текст с картинки.</p>
						<p>Внимание! Эта проверка осуществляется только один раз за игру с целью комфортной игры для всех игроков.</p>

						<xsl:choose>
							<xsl:when test="error = 'bad captcha'">
								<p class="error" align="center">Вы неправильно ввели код.</p>
							</xsl:when>
						</xsl:choose>
						<br />
						<img src="/captcha/{random}/" />
						<form action="/chat/captcha/" method="post">
							<input type="hidden" name="action" value="captcha" />
							<input type="text" name="code" size="6" /><br />
							<button class="button" type="submit">
								<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
									<div class="c">Проверить</div>
								</span>
							</button>
						</form>

                    </div>
                </div>
                </div>

            </div>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>