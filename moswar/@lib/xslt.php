<?php
/* 
 * 
 */

class Xslt
{
    public $xslStyleSheet;
    public $xmlData;

    public function __construct()
    {

    }

    /**
     * Генерация HTML
     *
     * @return string
     */
    public function getHtml()
    {
        chdir('@tpl');

        $xmlDataObject = new DOMDocument();
        $xmlDataObject->loadXML($this->xmlData);

	$xslStyleSheetObject = new DOMDocument();
	$xslStyleSheetObject->loadXML($this->xslStyleSheet);
	$xsltProcessor = new XSLTProcessor();
	$xsltProcessor->importStyleSheet($xslStyleSheetObject);

        $html = $xsltProcessor->transformToXML($xmlDataObject);

        chdir('..');

		return $html;
    }

    /**
     * Загрузка XSL шаблона
     *
     * @param string $xslStyleSheetPath
     */
    public function setXslStyleSheet($xslStyleSheetPath)
    {
        //$html = array('&quot;','&nbsp;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&shy;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&sup1;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&hellip;','&mdash;','&bull;');
        //$xml = array('&#34;','&#160;','&#161;','&#162;','&#163;','&#164;','&#165;','&#166;','&#167;','&#168;','&#169;','&#170;','&#171;','&#172;','&#173;','&#174;','&#175;','&#176;','&#177;','&#178;','&#179;','&#180;','&#181;','&#182;','&#183;','&#184;','&#185;','&#186;','&#187;','&#188;','&#189;','&#190;','&#191;','&#192;','&#193;','&#194;','&#195;','&#196;','&#197;','&#198;','&#199;','&#200;','&#201;','&#202;','&#203;','&#204;','&#205;','&#206;','&#207;','&#208;','&#209;','&#210;','&#211;','&#212;','&#213;','&#214;','&#215;','&#216;','&#217;','&#218;','&#219;','&#220;','&#221;','&#222;','&#223;','&#224;','&#225;','&#226;','&#227;','&#228;','&#229;','&#230;','&#231;','&#232;','&#233;','&#234;','&#235;','&#236;','&#237;','&#238;','&#239;','&#240;','&#241;','&#242;','&#243;','&#244;','&#245;','&#246;','&#247;','&#248;','&#249;','&#250;','&#251;','&#252;','&#253;','&#254;','&#255;','&#8230;','&#8212;','&#8226;');
        $this->xslStyleSheet = file_get_contents('@tpl/' . $xslStyleSheetPath . '.xsl'); //str_ireplace($html, $xml, file_get_contents('@tpl/' . $xslStyleSheetPath . '.xsl'));
    }

    /**
     * Загрузка XML данных
     *
     * @param array $data
     */
    public function setXmlData($data)
    {
		$this->xmlData = oxml_encode($data);
    }

    /**
     * Генерация HTML из XSL-файла и массава данных
     *
     * @param string $xslStyleSheet
     * @param array $xmlData
     * @return string
     */
    public static function getHtml2($xslStyleSheet, $xmlData, $rootTagName = 'contentico')
    {
        $xslt = new Xslt();
        $xslt->setXslStyleSheet($xslStyleSheet);
        $xslt->setXmlData($xmlData, $rootTagName);
        return $xslt->getHtml();
    }
}
?>