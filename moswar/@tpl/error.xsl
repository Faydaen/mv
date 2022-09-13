<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <xsl:choose>
            <xsl:when test="error = 1">

            </xsl:when>
            <xsl:when test="error = 500">
                <div style="width: 400px; margin:170px 0 100px 0;">
					<div class="block-bordered">
						<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
						<div class="center clear" style="text-align:left; padding:30px;">
							<h1 align="center">EPIC FAIL</h1>
			                <p>На сервере произошла страшная неизвестная ошибка.</p>
                            <p style="text-align:center;"><a href="/">Что это было?!</a></p>
						</div>
						<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
					</div>
				</div>
            </xsl:when>
            <xsl:when test="error = 502">
				<div style="width: 400px; margin:170px 0 100px 0;">
					<div class="block-bordered">
						<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
						<div class="center clear" style="text-align:left; padding:30px;">
							<h1 align="center">А-а-а-а-а-а!!! Все&#0160;сломалось!</h1>
			                <p>Оказавшись в пустом помещении, вы решили оглядеться по сторонам, как вдруг услышали голоса за стенкой:</p>
			                <p>— Ах вы негодяи! Опять все сломали!</p>
			                <p>— Зачем ругайся насяльника! Мы харасо работать, мы игра писать, мы сервера настраивать.</p>
                            <p style="text-align:center;"><a href="/">Улизнуть, пока не заметили</a></p>
						</div>
						<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
					</div>
				</div>
            </xsl:when>
        </xsl:choose>
    </xsl:template>

</xsl:stylesheet>