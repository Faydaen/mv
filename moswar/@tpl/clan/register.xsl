<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/clan-error.xsl" />

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
                <div class="heading clear"><h2>
                    <span class="clan"></span>
                </h2></div>
                <div id="content" class="clan">

                    <div class="welcome">
                        <i class="emblem">
                            <a href="/rating/clans/"><img style="margin:8px 0 2px 0" src="/@/images/ico/star.png" /><br />Рейтинг кланов</a>
                        </i>
                        <div class="block-rounded">
                            <i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
                            <div class="text">
                                <p>Ты — одиночка. Никто за тебя не отомстит, никто тебе не поможет.<br />Найди себе семью или построй свой синдикат.</p>
                                <div style="text-align:center;">
                                    <div class="button">
                                        <a class="f" href="/clan/list/new/"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                            <div class="c">Список новых кланов</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <xsl:if test="count(result) > 0">
                        <xsl:call-template name="error">
                            <xsl:with-param name="result" select="result" />
                        </xsl:call-template>
                    </xsl:if>

                    <div class="block-bordered" id="clan-create-form">
                        <ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
                        <div class="center clear">
                            <form class="clan-registration" method="post" id="registerForm" name="registerForm" enctype="multipart/form-data">
								<xsl:choose>
									<xsl:when test="DEV_SERVER = 1"><xsl:attribute name="action">/clan/register/</xsl:attribute></xsl:when>
									<xsl:otherwise><xsl:attribute name="action">http://img.moswar.ru/clan/register/</xsl:attribute></xsl:otherwise>
								</xsl:choose>
                            <h3>Заявка на регистрацию клана</h3>
                            <xsl:choose>
                                <xsl:when test="message = 'no_money'">
                                    <p class="error">У вас не хватает денег для создания клана.</p>
                                </xsl:when>
                            </xsl:choose>
                            <table class="forms">
								<tr>
									<td class="label"></td>
                                    <td class="input">
										<input type="checkbox" id="clan-register-checkbox" style="width: auto;" /><label for="clan-register-checkbox">Я хочу зарегистрировать клан и ознакомлен с <a href="/licence/clan_rules/">правилами</a></label>
									</td>
								</tr>
                                <tr>
                                    <td class="label">Придумайте название:</td>
                                    <td class="input"><input class="name" type="text" name="name" />
                                    <xsl:choose>
                                        <xsl:when test="name-error = 'bad_length'">
                                            <p class="error">Название должно быть от 5 до 25 символов.</p>
                                        </xsl:when>
										<xsl:when test="name-error = 'bad_name'">
                                            <p class="error">Название должно состоять из букв только одного алфавита - или русского, или английского.</p>
                                        </xsl:when>
										<xsl:when test="name-error = 'name_exists'">
                                            <p class="error">Клан с таким названием уже существует. Придумайте другое название.</p>
                                        </xsl:when>
                                    </xsl:choose>
                                    <div class="hint">Может состоять из латинских и русских букв, цифр, пробела или дефиса.</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Значок клана (28x16px, формат PNG):</td>
                                    <td class="input"><input type="file" name="ico" /></td>
                                </tr>
                                <tr>
                                    <td class="label">Герб клана (99x99px, формат PNG):</td>
                                    <td class="input"><input type="file" name="logo" /></td>
                                </tr>
                                <!--
                                <tr>
                                    <td class="label"></td>
                                    <td class="input">
                                        <div class="hint">Если вы не можете сделать значки в формате PNG нужного размера,
                                        то просто после регистрации клана пришлите картинки или ссылки на них на e-mail: support@moswar.ru,
                                        указав название Вашего клана.</div>
                                    </td>
                                </tr>
                                -->
                                <tr>
                                    <td class="label">Сайт:</td>
                                    <td class="input"><input class="name" type="text" name="site" />
                                        <div class="hint">Если есть</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Девиз:</td>
                                    <td class="input"><input class="name" type="text" name="slogan" style="width: 100%;" />
                                        <div class="hint">Не длиннее 80 символов</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Описание клана:</td>
                                    <td class="input"><textarea name="info"></textarea></td>
                                </tr>
                                <tr>
                                    <td class="label"></td>
                                    <td class="input">
                                        <div class="hint"><b>Внимание!</b> Клан будет иметь сторону, как у основателя: <i class="{player/fraction}"></i><b><xsl:value-of select="layer/fractionTitle" /></b></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label"></td>
                                    <td class="input">
                                        <button class="button" onclick="$('#registerForm').trigger('submit');">
                                            <span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
                                                <xsl:choose>
                                                    <xsl:when test="clan_regcert = 1">
                                                        <div class="c">Подать заявку (используя сертификат «Мой Клан»)</div>
                                                    </xsl:when>
                                                    <xsl:otherwise>
                                                        <div class="c">Подать заявку — <span class="tugriki">5000<i></i></span> + (<span class="ruda">200<i></i></span> или <span class="med">200<i></i></span>)</div>
                                                    </xsl:otherwise>
                                                </xsl:choose>
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            </form>
							<script type="text/javascript">
								$("#clan-register-checkbox").bind("click", function(){
									if (this.checked){
										$("form.clan-registration input[type!='checkbox']").attr("disabled",false);
										$("form.clan-registration textarea").attr("disabled",false);
										$("form.clan-registration button").attr("disabled",false);
										$("form.clan-registration button").removeClass("disabled");
									} else {
										$("form.clan-registration input[type!='checkbox']").attr("disabled",true);
										$("form.clan-registration textarea").attr("disabled",true);
										$("form.clan-registration button").attr("disabled",true);
										$("form.clan-registration button").addClass("disabled");
									}
								});
								$("form.clan-registration input[type!='checkbox']").attr("disabled",true);
								$("form.clan-registration textarea").attr("disabled",true);
								$("form.clan-registration button").attr("disabled",true);
								$("form.clan-registration button").addClass("disabled");
							</script>
                        </div>
                        <ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
                    </div>

                </div>
            </div>
        </div>
	</xsl:template>

</xsl:stylesheet>
