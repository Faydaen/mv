<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear">
                    <h2>Комнаты чата</h2>
                </div>

				<div id="content" class="chat">
					<xsl:if test="error">
						<p align="center" class="error"><xsl:value-of select="error" /></p>
					</xsl:if>
					<ul class="chat-rooms-list clear">
					</ul>
					<script>
						<![CDATA[
						var frame = top.frames["chat-frame-" + getCookie("chatLayout")];
						if (frame && frame.Chat) frame.Chat.getRooms();
						]]>
					</script>
				</div>
			</div>
		</div>
    </xsl:template>

</xsl:stylesheet>