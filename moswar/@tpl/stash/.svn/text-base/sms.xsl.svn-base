<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Оплата по SMS</h2>
				</div>
				<div id="content" class="stash">
					<xsl:if test="protect_gameleads = 'true'">
						<img src="http://pix.gameleads.ru/{protect_order}/q1/{protect_md5}" />
					</xsl:if>
					
					<div style="float: right; width: 140px; text-align: center;">
						<img src="/@/images/pers/man101.png" align="right" />
					</div>
					
					<div id="operator" style="margin:10px 0;">
					<p><b>Внимание!</b> С одного номера можно отправлять СМС не более, чем на 20 долларов, за 12 часов.</p>
					Выберите своего оператора сотовой связи:<br />
					<select name="operator" id="operatorId" onchange="showTarifs();" style="margin:5px 0;">
						<option value="-1">- выберите оператора -</option>
						<xsl:for-each select="operators/element">
							<option value="{id}"><xsl:value-of select="name" /></option>
						</xsl:for-each>
					</select>
					</div>
					<div id="priceblock" style="display: none; margin:10px 0;">
						Выберите подходящую стоимость сообщения:<br />
						<select name="price" id="price" onchange="showResults();" style="margin:5px 0;">
							<option value="-1">- выберите стоимость -</option>
						</select>
					</div>
					<div id="resultblock" style="display: none; margin:10px 0;">
						<div class="block-rounded" style="margin-right:150px">
							<i class="tlc"></i><i class="trc"></i><i class="blc"></i><i class="brc"></i>
							Стоимость отправки сообщения: <b><span id="cost"></span></b>.<br />
							Вы получите: <span class="med">0<i></i></span> <span id="bonus">+ БОНУС <span class="tugriki">0<i></i></span></span><br/>
							Вы должны отправить сообщение с текстом <nobr><span style="color: red; font-size: 14pt;">kanwar<span style="color: green; font-size: 8pt;">&lt;пробел&gt;</span><xsl:value-of select="player/id" /></span></nobr> на номер <span id="number" style="color: blue; font-size: 14pt;"></span>.<br />
							После этого вам будет начислен вкусный медок и немного мелочевки.

							<p style="color: red; font-size: 13pt;"><b>ВНИМАНИЕ!</b> В тексте сообщения между словом kanwar и вашим ID нужно ставить один пробел - <nobr>"kanwar <xsl:value-of select="player/id" />"</nobr> (без кавычек).</p>
						</div>
					</div>
					<script>
						var tarifs = <xsl:value-of select="tarifs" />;
					<![CDATA[
						function showTarifs() {
							var id = $('#operatorId').val();
							$('#resultblock').hide();
							if (id == -1) {
								$('#priceblock').hide();
								return;
							}
							$('#price').val('-1');
							$('#priceblock').show();
							$('#price').html('<option value="-1">- выберите стоимость -</option>');
							for (i in tarifs[id]) {
								$('#price').append('<option value=' + i + '>' + tarifs[id][i]['price'] + ' руб - ' + tarifs[id][i]['honey'] + ' меда + ' + tarifs[id][i]['money'] + ' монеток</option>');
							}
						}
						function showResults() {
							var id = $('#operatorId').val();
							var number = $('#price').val();
							if (id == -1 || number == -1) {
								$('#resultblock').hide();
								return;
							}
							$('#resultblock').show();
							$('#resultblock #cost').html(tarifs[id][number]['cost']);
							$('#resultblock span.med').html(tarifs[id][number]['honey'] + '<i />');
							$('#resultblock #number').html(tarifs[id][number]['number']);
							$('#resultblock #bonus').hide();
							if (tarifs[id][number]['money'] > 0) {
								$('#resultblock #bonus .tugriki').html(tarifs[id][number]['money'] + '<i />');
								$('#resultblock #bonus').show();
							}
						}
					]]></script>
				</div>
			</div>
		</div>
    </xsl:template>

</xsl:stylesheet>
