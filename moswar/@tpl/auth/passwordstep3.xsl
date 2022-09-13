<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html"/>

	<xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Восстановление пароля &#8212; Шаг 3</h2>
				</div>
				<div id="content">
					<p>Пароль успешно восстановлен.</p>
					<p>Ваш новый пароль &#8212;
						<xsl:value-of select="pwd" />. Вы можете его изменить в <a href="/settings/">личном кабинете</a>.
					</p>
				</div>
			</div>
		</div>
	</xsl:template>

</xsl:stylesheet>