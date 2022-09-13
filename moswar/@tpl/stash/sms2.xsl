<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
	
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Оплата по SMS</h2>
				</div>
				<div id="content" class="stash clear">
					<xsl:if test="protect_gameleads = 'true'">
						<img src="http://pix.gameleads.ru/{protect_order}/q1/{protect_md5}" />
					</xsl:if>
				
					<img src="/@/images/pers/man101.png" align="right" style="margin-top:-30px; //margin-top:0;" />
			        <p><b>Для получения награды путем оплаты через СМС, вы должны отправить одну или несколько СМС на желаемую сумму.</b></p>
			        <br />
			        <select style='width:300px; font-size:160%;' onchange='showHideCountry()' id ='countryList'>
			            <option value = '3'>Азербайджан</option>
			            <option value = '2'>Армения</option>
			            <option value = '4'>Израиль</option>
			            <option value = '5'>Латвия</option>
			            <option value = '6'>Литва</option>
			            <option value = '1' selected="selected">Россия</option>
			            <option value = '8'>Украина</option>
			            <option value = '7'>Эстония</option>
				    <option value = '9'>Казахстан</option>
			        </select>
			        <br /><br />

			        <div rel="country" id='country_1'>
						
			           <p class="borderdata" style="margin-right:150px">Если Вы абонент МТС, Билайн или Мегафон, есть более выгодный<br/> 
					   <a href="/stash/mobile/">способ покупки мёда <b>с бонусом +40%</b></a>.
					   </p>

						<p>Данный способ работает только, если вы явяетесь клиентом одного из следующих операторов: 
						Мегафон, МТС*, Билайн, Теле-2, Мотив, «Екатеринбург — 2000»" (Мотив), «Контент Урал»(«Уралсвязьинформ»),
						«Новгородские телекомуникации» (Индиго), «Астрахань GSM», ОАО "РеКом", "НТК", СМАРТС.</p>
						
			            <p style="font-size:140%">Текст сообщения: «<b style='color:red'><xsl:value-of select="sms" /></b>» (без кавычек, с пробелом в середине)</p>
						<table class="datatable"  style="width:70%;">
							<tr>
								<th width="33%">Номер</th>
								<th width="34%">Стоимость</th>
								<th width="33%">Получите мёда</th>
							</tr>
							<tr><td><b>7099</b></td><td>0,99 у.е.<span class='nobold'>(+ НДС)</span></td><td><span class="med">7<i></i></span></td></tr>
							<tr><td><b>7250</b></td><td>2,50 у.е.<span class='nobold'>(+ НДС)</span></td><td><span class="med">18<i></i></span></td></tr>
							<tr><td><b>2332</b></td><td>5,00 у.е.<span class='nobold'>(+ НДС)</span></td><td><span class="med">36<i></i></span></td></tr>
						</table>

						<small><em>* Для абонентов МТС: стоимость доступа к услугам контент-провайдера устанавливается Вашим оператором.
						Подробную информацию можно узнать: в разделе «Услуги по коротким номерам» на сайте <a href="http://www.mts.ru">www.mts.ru</a>
						или обратившись в контактный центр по телефону 8-800-333-08-90 (0890 для абонентов МТС).</em></small>
			        </div>

			        <div rel="country" id='country_8' style="display:none;">
			            <p style="font-size:140%">Текст сообщения: «<b style='color:red'><xsl:value-of select="sms" /></b>» (без кавычек, с пробелом в середине)</p>
						<p>Оператор UMC Украина временно не работает.</p>
						<table class="datatable"  style="width:70%;">
							<tr>
								<th width="33%">Номер</th>
								<th width="34%">Стоимость</th>
								<th width="33%">Получите мёда</th>
							</tr>
							<tr><td><b>7099</b></td><td>6 UAH <span class='nobold'>(+ НДС)</span></td><td><span class="med">7<i></i></span></td></tr>
							<tr><td><b>7250</b></td><td>12 UAH <span class='nobold'>(+ НДС)</span></td><td><span class="med">14<i></i></span></td></tr>
							<tr><td><b>5373</b></td><td>25 UAH <span class='nobold'>(+ НДС)</span></td><td><span class="med">30<i></i></span></td></tr>
						</table>
			        </div>

			        <div rel="country" id='country_2' style="display:none;">
			            <p style="font-size:140%">Текст сообщения: «<b style='color:red'>PM<xsl:value-of select="sms" /></b>» (без кавычек, с пробелом в середине)</p>
			            <table class="datatable"  style="width:70%;">
							<tr>
								<th width="33%">Номер</th>
								<th width="34%">Стоимость</th>
								<th width="33%">Получите мёда</th>
							</tr>
			                <tr><td><b>3001</b></td><td>360 AMD</td><td><span class="med">7<i></i></span></td></tr>
			                <tr><td><b>3002</b></td><td>1000 AMD</td><td><span class="med">18<i></i></span></td></tr>
			                <tr><td><b>3005</b></td><td>1700 AMD</td><td><span class="med">30<i></i></span></td></tr>
			            </table>
			        </div>

			        <div rel="country" id='country_3' style="display:none;">
			            <p><span style="font-size:140%">Номер: <b style='color:red'>8777</b></span> <br />Текст сообщения можно узнать из таблицы ниже. Текст - без кавычек, с пробелом в середине</p>
			            <table class="datatable"  style="width:70%;">
							<tr>
								<th width="33%">Текст сообщения</th>
								<th width="34%">Стоимость</th>
								<th width="33%">Получите мёда</th>
							</tr>
			                <tr><td><b>1<xsl:value-of select="sms" /></b></td><td>1,06 AZN</td><td><span class="med">7<i></i></span></td></tr>
			                <tr><td><b>3<xsl:value-of select="sms" /></b></td><td>2,95 AZN</td><td><span class="med">18<i></i></span></td></tr>
			                <tr><td><b>5<xsl:value-of select="sms" /></b></td><td>4,83 AZN</td><td><span class="med">36<i></i></span></td></tr>
			            </table>
			        </div>

			        <div rel="country" id='country_4' style="display:none;">
			            <p><span style="font-size:140%">Номер: <b style='color:red'>4070</b></span> <br />Текст сообщения можно узнать из таблицы ниже. Текст - без кавычек, с пробелом в середине</p>
			            <table class="datatable"  style="width:70%;">
							<tr>
								<th width="33%">Текст сообщения</th>
								<th width="34%">Стоимость</th>
								<th width="33%">Получите мёда</th>
							</tr>
			                <tr><td><b>PMD1<xsl:value-of select="sms" /></b></td><td>5 ISL</td><td><span class="med">7<i></i></span></td></tr>
			                <tr><td><b>PMD3<xsl:value-of select="sms" /></b></td><td>15 ISL</td><td><span class="med">18<i></i></span></td></tr>
			                <tr><td><b>PMD5<xsl:value-of select="sms" /></b></td><td>20 ISL</td><td><span class="med">30<i></i></span></td></tr>
			            </table>
			        </div>

			        <div rel="country" id='country_5' style="display:none;">
			            <p><span style="font-size:140%">Номер: <b style='color:red'>1897</b></span> <br />Текст сообщения можно узнать из таблицы ниже. Текст - без кавычек, с пробелом в середине</p>
			            <table class="datatable"  style="width:70%;">
							<tr>
								<th width="33%">Текст сообщения</th>
								<th width="34%">Стоимость</th>
								<th width="33%">Получите мёда</th>
							</tr>
			                <tr><td><b>1PM<xsl:value-of select="sms" /></b></td><td>0,77 LVL</td><td><span class="med">7<i></i></span></td></tr>
			                <tr><td><b>3PM<xsl:value-of select="sms" /></b></td><td>1,55 LVL</td><td><span class="med">18<i></i></span></td></tr>
			                <tr><td><b>5PM<xsl:value-of select="sms" /></b></td><td>2,58 LVL</td><td><span class="med">30<i></i></span></td></tr>
			            </table>
			        </div>

			        <div rel="country" id='country_6' style="display:none;">
			            <p><span style="font-size:140%">Номер: <b style='color:red'>1337</b></span> <br />Текст сообщения можно узнать из таблицы ниже. Текст - без кавычек, с пробелом в середине</p>
			            <table class="datatable"  style="width:70%;">
							<tr>
								<th width="33%">Текст сообщения</th>
								<th width="34%">Стоимость</th>
								<th width="33%">Получите мёда</th>
							</tr>
			                <tr><td><b>1PM<xsl:value-of select="sms" /></b></td><td>3,03 LTL</td><td><span class="med">7<i></i></span> </td></tr>
			                <tr><td><b>3PM<xsl:value-of select="sms" /></b></td><td>7,07 LTL</td><td><span class="med">18<i></i></span></td></tr>
			                <tr><td><b>5PM<xsl:value-of select="sms" /></b></td><td>10,01 LTL</td><td><span class="med">30<i></i></span></td></tr>
			            </table>
			        </div>

			        <div rel="country" id='country_7' style="display:none;">
			            <p style="font-size:140%">Текст сообщения: «<b style='color:red'>PMD<xsl:value-of select="sms" /></b>» (без кавычек, с пробелом в середине)</p>
			            <table class="datatable"  style="width:70%;">
							<tr>
								<th width="33%">Номер</th>
								<th width="34%">Стоимость</th>
								<th width="33%">Получите мёда</th>
							</tr>
			                <tr><td><b>15330</b></td><td>17 EEK</td><td><span class="med">7<i></i></span> </td></tr>
			                <tr><td><b>13015</b></td><td>35 EEK</td><td><span class="med">18<i></i></span></td></tr>
			            </table>
			        </div>


				<div rel="country" id='country_9' style="display:none;">
                                    <p style="font-size:140%">Текст сообщения: «<b style='color:red'>a<xsl:value-of select="sms" /></b>» (без кавычек, с пробелом в середине)</p>
                                    <table class="datatable"  style="width:70%;">
                                                        <tr>
                                                                <th width="33%">Номер</th>
                                                                <th width="34%">Стоимость</th>
                                                                <th width="33%">Получите мёда</th>
                                                        </tr>
                                        <tr><td><b>3110</b></td><td>600 KZT</td><td><span class="med">28<i></i></span> </td></tr>
                                        <tr><td><b>4545</b></td><td>230 KZT</td><td><span class="med">10<i></i></span></td></tr>
                                    </table>
                                </div>


			        <p>Не посылайте сообщения сразу на все номера. Выберите те которые вам нужны чтобы набрать нужную сумму. Так же советуем дождаться ответа на сообщение чтобы узнать сколько вы уже потратили сегодня.</p>

			        <p><b>Примечание:</b> В случае неверного запроса на оплату, платеж  до нас не дойдет, а вы не получите вашу награду в качестве компенсации.</p>
			        <p style='color:#ff0000'><b>Внимание:</b> во избежание проблем с оплатой, настоятельно не рекомендуем осуществлять платежи более чем с 3-х телефонных номеров!</p>
			        
			        <div style="float:left; width:45%;">
						<p>В целях избежания мошенничества, введено ограничение на отсылку сообщений с одного номера в час.
						Сумму которую вы можете оплатить зависит от истории платежей данным способом с вашего телефонного номера. 
						Все мошенники и задействованные в обмане персонажи будут забанены навсегда, с изьятием имущества.</p>
					</div>
			        
			        <div style="float:right; width:50%;">
						<table class="datatable">
				            <tr class="text_main_4">
				                <th width="50%" align="center">Общая сумма за всё время (у.е.)</th>
				                <th width="50%" align="center">Макс в час (у.е.) </th>
				            </tr>
				            <tr><td align="center">&lt;50</td><td align="center">10</td></tr>
				            <tr><td align="center">&lt;50...150</td><td align="center">20</td></tr>
				            <tr><td align="center">&lt;150...300</td><td align="center">30</td></tr>
				            <tr><td align="center">&lt;300...500</td><td align="center">40</td></tr>
				            <tr><td align="center">&gt;500</td><td align="center">50</td></tr>
				        </table>
			        </div>
					
					<script type="text/javascript">
						function showHideCountry(){
							$("div[rel=country]").hide();
							var country_index = $("#countryList").val();
							$("#country_"+country_index).show();
						}
					</script>
		
				</div>
			</div>
		</div>

    </xsl:template>
</xsl:stylesheet>
