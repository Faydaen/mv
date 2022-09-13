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
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'apply' and $result/error = 'different fractions'"><p class="error" align="center">Вы не можете вступить в клан противоборствующей фракции.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'apply' and $result/error = 'low level'"><p class="error" align="center">Ваш уровень слишком мал для клана.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'apply' and $result/error = 'no money'"><p class="error" align="center">Для подачи заявки необходимо оплатить налог, на который у вас нет денег.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'apply' and $result/error = 'you are already in clan'"><p class="error" align="center">Вы не можете подавать заявку на вступление, пока находитесь в другом клане.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'cancel_apply' and $result/error = 'you have not made an apply'"><p class="error" align="center">Вы не подавали заявку на вступление.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/error = 'you are not in clan'"><p class="error" align="center">Вы не состоите в клане.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'refuse' and $result/error = 'you are not founder of this clan'"><p class="error" align="center">Вы не являетесь главой клана.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'refuse' and $result/error = 'this player is not recruit of this clan'"><p class="error" align="center">Этот игрок не подавал заявку на вступление в клан.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'accept' and $result/error = 'you are not founder of this clan'"><p class="error" align="center">Вы не являетесь главой клана.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'accept' and $result/error = 'this player is not recruit of this clan'"><p class="error" align="center">Этот игрок не подавал заявку на вступление в клан.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'accept' and $result/error = 'clan is full'"><p class="error" align="center">Сейчас в клане нет места.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'drop' and $result/error = 'you are not founder of this clan'"><p class="error" align="center">Вы не являетесь главой клана.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'drop' and $result/error = 'this player is not member of this clan'"><p class="error" align="center">Этот игрок не является членом клана.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'dissolve' and $result/error = 'you are not founder of this clan'"><p class="error" align="center">Вы не являетесь главой клана.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'change_info' and $result/error = 'you are not founder of this clan'"><p class="error" align="center">Вы не являетесь главой клана.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'register' and $result/error = 'no ico or logo'"><p class="error" align="center">Нет иконки или логотипа.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'deposit' and $result/error = 'bad numbers'"><p class="error" align="center">Неверная сумма денег для вложения.</p></xsl:when>
            <xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'set_clan_title'"><p class="error" align="center">Что-то пошло не так. Должность не изменена.</p></xsl:when>
			<xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'expand_office'"><p class="error" align="center">У вас в казне недостаточно денег. А строить нахаляву никто не будет.</p></xsl:when>
            <xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'propose_union'"><p class="error" align="center">У вас в казне недостаточно денег. Врятли потенциальные союзники захотят иметь с вами дело.</p></xsl:when>
            <xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'attack'"><p class="error" align="center">У вас в казне недостаточно денег. Не смешите своих врагов!</p></xsl:when>
            <xsl:when test="$result/result = 0 and $result/type = 'clan' and $result/action = 'union_accept' and $result/error = 'no money'"><p class="error" align="center">У вас в казне недостаточно денег. Не позорьтесь перед своими союзниками.</p></xsl:when>
            <!-- successes -->
			<xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'apply'"><p class="success" align="center">Заявка на вступление в клан принята.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'cancel_apply'"><p class="success" align="center">Заявка на вступление в клан отменена.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'refuse'"><p class="success" align="center">Игроку отказано в заявке на вступление в клан.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'drop'"><p class="success" align="center">Игрок исключен из клана.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'accept'"><p class="success" align="center">Игрок принят в клан.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'dissolve'"><p class="success" align="center">Клан распущен.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'leave'"><p class="success" align="center">Вы покинули клан.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'change_info'"><p class="success" align="center">Клановая информация изменена.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'clan_message'"><p class="success" align="center">Сообщение кланерам разослано.</p></xsl:when>
			<xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'deposit'"><p class="success" align="center">Вы сделали вклад в казну клана.</p></xsl:when>
            <xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'set_clan_title'"><p class="success" align="center">Должность изменена.</p></xsl:when>
            <xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'expand_office'"><p class="success" align="center">Проворные гастарбайтеры в считанные минуты приделали к вашему штабу еще одну комнату.</p></xsl:when>
            <xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'propose_union'"><p class="success" align="center">Предложение заключить союз отправлено голубиной почтой главе клана. Ждите ответных писем.</p></xsl:when>
            <xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'cancel_propose_union'"><p class="success" align="center">Нажав кнопку на пульте дистанционного управления вы ликвидировали свое предложение заключить союз.</p></xsl:when>
            <xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'attack'"><p class="success" align="center">Война, война никогда не меняется...</p></xsl:when>
            <xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'union_accept'"><p class="success" align="center">Союз заключен. Самое время на кого-нибудь вместе напасть!</p></xsl:when>
            <xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'union_decline'"><p class="success" align="center">Предложение заключить союза отклонено. Нечего иметь дело с этими слабоками!</p></xsl:when>
            <xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'union_cancel'"><p class="success" align="center">Союз разорван. Теперь каждый сам по себе.</p></xsl:when>
            <xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'war_accept'"><p class="success" align="center">Вы вышли на тропу войны. Теперь назад дороги нет.</p></xsl:when>
            <xsl:when test="$result/result = 1 and $result/type = 'clan' and $result/action = 'war_decline'"><p class="success" align="center">Вы отказались от войны. Тогда просто запасайтесь попкорном и выбирайте место с лучшим обзором.</p></xsl:when>
        </xsl:choose>
    </xsl:template>

</xsl:stylesheet>
