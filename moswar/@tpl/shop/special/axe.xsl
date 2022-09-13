<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/data">
        <div class="column-right-topbg">
            <div class="column-right-bottombg" align="center">
				<div class="heading clear"><h2>
					Аромат
				</h2></div>
				<div id="content" class="special">
				
					<div class="special-axe">
						<div class="welcome">
							<div class="block-rounded">
								<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
								<div class="text">
									Бренд Axe и игра «Мосвар» проводит совместную акцию!<br />
									Приобрети в любом магазине дезодорант <b>Axe Shift или любой другой продукт Axe Effect</b> и&#160;получи в подарок дезодорант Axe с уникальным эффектом в игре.
									<h4>Памятка для участника:</h4>
									<ol>
										<li>Купить любой продукт AXE.</li>
										<!--li>Зайти на эту страницу, ввести тип продукта и его штрих-код.</li-->
                                        <li>Зайти на эту страницу и ввести штрих-код продукта.</li>
										<li>Получить бесплатный баллончик в игре.</li>
									</ol>
                                    <xsl:choose>
                                        <xsl:when test="success = 1">
                                            <img src="http://axeeffect.ru/gamecounters/moswar_success" style="width:0px; height:0px;" />
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <img src="http://axeeffect.ru/gamecounters/moswar_promo" style="width:0px; height:0px;" />
                                        </xsl:otherwise>
                                    </xsl:choose>
								</div>
							</div>
						</div>
						<div class="block-bordered">
							<ins class="t l"><ins></ins></ins><ins class="t r"><ins></ins></ins>
							<div class="center clear">
								<h3>Простое действие</h3>
								<form class="special-axe-form" action="/shop/special/axe1/activate/" method="post">
									<input type="hidden" name="product" value='1' />
									<table class="forms">
										<!--
										<tr>
											<td class="label">
												Выберите продукт
											</td>
											<td class="input">
												<select style="min-width:200px" name="product">												
													<option value="Дезодорант аэрозоль AXE Африка 150мл">Дезодорант аэрозоль AXE Африка 150мл</option>
													<option value="Дезодорант аэрозоль AXE Буст 150мл">Дезодорант аэрозоль AXE Буст 150мл</option>
													<option value="Дезодорант аэрозоль AXE Вайс 150мл">Дезодорант аэрозоль AXE Вайс 150мл</option>
													<option value="Дезодорант аэрозоль AXE Вайс 90мл">Дезодорант аэрозоль AXE Вайс 90мл</option>
													<option value="Дезодорант аэрозоль AXE Дарк Темптейшн 150мл">Дезодорант аэрозоль AXE Дарк Темптейшн 150мл</option>
													<option value="Дезодорант аэрозоль AXE Дарк темптейшн 90мл">Дезодорант аэрозоль AXE Дарк темптейшн 90мл</option>
													<option value="Дезодорант аэрозоль AXE Джет 150мл">Дезодорант аэрозоль AXE Джет 150мл</option>
													<option value="Дезодорант аэрозоль AXE Инстинкт 150мл">Дезодорант аэрозоль AXE Инстинкт 150мл</option>
													<option value="Дезодорант аэрозоль AXE Инстинкт 90мл">Дезодорант аэрозоль AXE Инстинкт 90мл</option>
													<option value="Дезодорант аэрозоль AXE Клик 150мл">Дезодорант аэрозоль AXE Клик 150мл</option>
													<option value="Дезодорант аэрозоль AXE Клик 90мл">Дезодорант аэрозоль AXE Клик 90мл</option>
													<option value="Дезодорант аэрозоль AXE Перезагрузка 150мл">Дезодорант аэрозоль AXE Перезагрузка 150мл</option>
													<option value="Дезодорант аэрозоль AXE Пульс 150мл">Дезодорант аэрозоль AXE Пульс 150мл</option>
													<option value="Дезодорант аэрозоль AXE Пульс 90мл">Дезодорант аэрозоль AXE Пульс 90мл</option>
													<option value="Дезодорант аэрозоль AXE Райз-ап 150мл">Дезодорант аэрозоль AXE Райз-ап 150мл</option>
													<option value="Дезодорант аэрозоль AXE Тач 150мл">Дезодорант аэрозоль AXE Тач 150мл</option>
													<option value="Дезодорант аэрозоль AXE Тач 90мл">Дезодорант аэрозоль AXE Тач 90мл</option>
													<option value="Дезодорант аэрозоль AXE Феникс 150мл">Дезодорант аэрозоль AXE Феникс 150мл</option>
													<option value="Дезодорант аэрозоль AXE Хот Фивер 150мл">Дезодорант аэрозоль AXE Хот Фивер 150мл</option>
													<option value="Дезодорант аэрозоль AXE Шифт 150мл" selected="selected">Дезодорант аэрозоль AXE Шифт 150мл</option>
													<option value="Дезодорант аэрозоль AXE Шифт 90мл">Дезодорант аэрозоль AXE Шифт 90мл</option>
													<option value="Дезодорант аэрозоль AXE Шок 150мл">Дезодорант аэрозоль AXE Шок 150мл</option>
												</select>
											</td>
										</tr>
										-->
										<tr>
											<td class="label">
												Введите штрих-код
											</td>
											<td class="input">
												<input type="text" name="code" size="7" maxlength="13" style="width:200px" />
												<div class="hint">
													<b>Внимание!</b> Один код можно ввести всего один раз. Также баллончик можно получить не чаще одного раза в месяц, если вы приобретаете разные продукты Axe Effect.
												</div>
											</td>
										</tr>
										<tr>
											<td class="label">
											</td>
											<td class="input">
												<button class="button" type="submit">
													<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
														<div class="c">
															Получить
														</div>
													</span>
												</button>
											</td>
										</tr>
									</table>
								</form>
							</div>
							<ins class="b l"><ins></ins></ins><ins class="b r"><ins></ins></ins>
						</div>
						<div class="special-axe-link">
							<div class="block-rounded">
								<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
								<div class="text">
									<a href="http://axeeffect.ru/" target="_blank">Подробнее о всех ароматах Axe Effect</a>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
		
		<xsl:choose>
			<xsl:when test="step = 2">
				<div class="alert">
					<div class="padding">
						<h2>Все правильно сделал</h2>
						<div class="data">
							<p><img src="/@/images/obj/axe.png" align="left" />Отлично, ты выполнил все условия задания. В награду ты получаешь <b>дезодорант Axe Shift</b>, который выделит тебя из толпы.</p>
							<div class="actions">
								<button class="button">
									<span class="f"><i class="rl"></i><i class="bl"></i><i class="brc"></i>
										<div class="c">Ok</div>
									</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</xsl:when>
		</xsl:choose>
    </xsl:template>

</xsl:stylesheet>