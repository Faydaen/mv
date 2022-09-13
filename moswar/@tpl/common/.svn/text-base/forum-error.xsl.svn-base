<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template name="error">
		<xsl:param name="error" />
		<xsl:param name="type" />
		<xsl:param name="params" />
		<xsl:param name="action" />
		<xsl:param name="result" />

        <xsl:choose>
            <!-- errors -->
			<xsl:when test="$result/result = 0 and $result/type = 'forum' and $result/error = 'forum is closed'"><p class="error" align="center">Этот форум закрыт и здесь нельзя создавать темы.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'forum' and $result/error = 'topic is closed'"><p class="error" align="center">Эта тема закрыта и здесь нельзя писать комментарии.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'forum' and $result/error = 'you have not access'"><p class="error" align="center">У вас нет доступа к данной функции.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'forum' and $result/error = 'topic not found'"><p class="error" align="center">Тема не найдена.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'forum' and $result/error = 'forum not found'"><p class="error" align="center">Форум не найден.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'forum' and $result/error = 'bad text'"><p class="error" align="center">Слишком короткий текст.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'forum' and $result/action = 'new topic' and $result/error = 'bad name'"><p class="error" align="center">Слишком короткое название темы.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'forum' and $result/action = 'search' and $result/error = 'bad text'"><p class="error" align="center">Слишком короткий запрос для поиска.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'forum' and $result/action = 'search' and $result/error = 'posts not found'"><p class="error" align="center">Ничего не найдено.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'forum' and $result/action = 'search' and $result/error = 'need auth'"><p class="error" align="center">Для поиска по форуму необходимо авторизироваться.</p></xsl:when>
			<!-- successes -->
			<xsl:when test="$result/result = 1 and $result/type = 'forum' and $result/action = 'close topic'"><p class="success" align="center">Обсуждение закрыто.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'forum' and $result/action = 'open topic'"><p class="success" align="center">Обсуждение открыто.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'forum' and $result/action = 'open forum'"><p class="success" align="center">Форум открыт.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'forum' and $result/action = 'close forum'"><p class="success" align="center">Форум закрыт.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'forum' and $result/action = 'delete topic'"><p class="success" align="center">Обсуждение удалено.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'forum' and $result/action = 'delete post'"><p class="success" align="center">Комментарий удален.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'forum' and $result/action = 'new post'"><p class="success" align="center">Комментарий успешно добавлен.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'forum' and $result/action = 'new topic'"><p class="success" align="center">Тема успешно создана.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'forum' and $result/action = 'move topic'"><p class="success" align="center">Тема успешно перемещена.</p></xsl:when>
        </xsl:choose>

    </xsl:template>

</xsl:stylesheet>
