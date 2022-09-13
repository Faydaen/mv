<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/data">
		<div class="column-right-topbg">
			<div class="column-right-bottombg" align="center">
				<div class="heading clear">
					<h2>Покупка мёда через систему 2pay.ru</h2>
				</div>
				<div id="content" class="stash">
					<xsl:if test="protect_gameleads = 'true'">
						<img src="http://pix.gameleads.ru/{protect_order}/q1/{protect_md5}" />
					</xsl:if>

					<div style="float: right; width: 140px; text-align: center;">
						<img src="/@/images/pers/man101.png" align="right" />
					</div>
					
					<div  style="margin-right:150px">

                        <p>Через систему оплаты 2pay.ru вы можете оплатить мёд:</p>

                        <p>
						<img width="22" src="https://2pay.ru/img/payment/view/terminal_ico.png" align="absmiddle"/>&#160;
						<a target="_blank"><xsl:attribute name="href">https://2pay.ru/oplata/number.html?id=2314&amp;v1=<xsl:value-of select="player/id" />&amp;v2=&amp;v3=&amp;page=3021&amp;country=0</xsl:attribute>Автоматически в терминалах</a>
						</p>

                        <p>
						<img width="22" src="https://2pay.ru/img/payment/view/yamoney_ico.png" align="absmiddle"/>&#160;
						<a target="_blank"><xsl:attribute name="href">https://2pay.ru/oplata/yandex/?id=2314&amp;v1=<xsl:value-of select="player/id" />&amp;v2=&amp;v3=&amp;page=3021&amp;country=0</xsl:attribute>Яndex-деньгами</a>
						</p>

                        <p>
						<img width="22" src="https://2pay.ru/img/payment/view/card_ico.png" align="absmiddle"/>&#160;
						<a target="_blank"><xsl:attribute name="href">https://2pay.ru/oplata/liqpay/?id=2314&amp;v1=<xsl:value-of select="player/id" />&amp;v2=&amp;v3=&amp;page=3021&amp;country=0</xsl:attribute>Кредитной картой</a>
						</p>

                        <p>
						<img width="22" src="https://2pay.ru/img/payment/view/paypal_ico.png" align="absmiddle"/>&#160;
						<a target="_blank"><xsl:attribute name="href">https://2pay.ru/oplata/paypal/?id=2314&amp;v1=<xsl:value-of select="player/id" />&amp;v2=&amp;v3=&amp;page=3021&amp;country=0</xsl:attribute>PayPal</a>
                        </p>

                        <p>
                        <a target="_blank"><xsl:attribute name="href">https://2pay.ru/oplata/?id=2314&amp;v1=<xsl:value-of select="player/id" />&amp;v2=&amp;v3=&amp;page=3021&amp;country=0</xsl:attribute>Или же одним из множества других способов</a>
                        </p>

                        <p>Курс: 3 рубля = <span class="med">1<i></i></span></p>
                        <p><b>Бонус: +20%</b></p>
					</div>
				</div>
			</div>
		</div>
    </xsl:template>

</xsl:stylesheet>