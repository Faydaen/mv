<?php
/**
 * Типограф
 *
 */
class Typograf
{
	private $text; // Текст для типографирования
	private $tmode; // Режим типографа

	public $br = false; // Растановка переносов строк,  ztrue или false
	public $p = false; // Растановка абзацов,  true или false

	public $quot11 = '&laquo;'; // Откр. кавычка первого уровня
	public $quot12 = '&raquo;'; // Закр. кавычка первого уровня
	public $quot21 = '&bdquo;'; // Откр. кавычка второго уровня
	public $quot22 = '&ldquo;'; // Закр. кавычка второго уровня

	public $tire = '&mdash;'; // Тире
	public $tireinterval = '&mdash;'; // Тире в интервалах

	public $space = '&nbsp;'; // Неразрывный пробел
	public $hellip = '&hellip;';
	public $number = '№'; // Знак №

	public $sect = '&sect;'; // Знак параграфа
	public $sup2 = '&sup2;'; // Степень квадрата
	public $sup3 = '&sup3;'; // Степень куба
	public $deg = '&deg;'; // Знак градуса

	public $Prime = '&Prime;'; // Знак дюйма
	public $euro = '&euro;'; // Знак евро
	public $times = '&times;'; // Знак умножения
	public $plusmn = '&plusmn;'; // Плюс-минус
	public $cent = '&cent;'; // Знак цента
	public $pound = '&pound;'; // Знак фунта

	public $darr = '&darr;'; // Стрелка вниз
	public $uarr = '&uarr;'; // Стрелка вверх
	public $larr = '&larr;'; // Стрелка влево
	public $rarr = '&rarr;'; // Стрелка вправо
	public $crarr = '&crarr;'; //

	public $spaceAfterShortWord = true; // Пробел после коротких слов,  true или false
	public $lengthShortWord = 2; // Длина короткого слова
	public $spaceBeforeTire = true; // Пробел перед тире,  true или false
	public $delTab = false;	// Удаление табов, если установлено false, табы заменяются на пробелы,  true или false
	public $replaceTab = true; // Замена табов на пробелы,  true или false
	public $spaceBeforeLastWord = true; // Пробел перед последним словом,  true или false
	public $lengthLastWord = 3; // Длина последнего слова
	public $spaceAfterNum = true; // Пробел после №,  true или false

	public $spaceBeforeParticles = true; // Пробел перед частицами - ли, же, бы.  true или false
	public $delRepeatSpace = true; // Удалять повторы пробелов,  true или false
	public $delSpaceBeforePunctuation = true; // Удалять пробел перед знаками препинания,  true или false
	public $delSpaceBeforeProcent = true; // Удалять пробел перед знаком процента,  true или false
	public $trim = true; // Удаление пробелов в начале и конце текста,  true или false

	public $doReplaceBefore = true; // Делать замену перед типографированием. true или false
	public $doReplaceAfter = true; // Делать замену после типографирования. true или false

	public $findUrls = false; // Искать URL и заменять http://example.com на  <a href="http://example.com">http://example.com</a>,  true или false

	private $_isHTMLCode; // Это HTML-код

	function __construct()
	{

	}

	private function replaceBefore()
	{
		$before = array('(r)', '(c)', '(tm)', '+/-');
		$after = array('®', '©', '™', '±');
		$this->text = str_ireplace($before, $after, $this->text);
	}

	private function replaceAfter()
	{
		// Замена +- около чисел
		$this->text = preg_replace('/(?<=^| |\>|&nbsp;|&#160;)\+-(?=\d)/', $this->plusmn, $this->text);

		// Замена 3 точек на троеточие
		$this->text = preg_replace('/(^|[^.])\.{3}([^.]|$)/', '$1'.$this->hellip.'$2', $this->text);

		// Градусы Цельсия
		$this->text = preg_replace('/(\d+)( |\&\#160;|\&nbsp;)?(C|F)([\W \.,:\!\?"\]\)]|$)/', '$1'.$this->space.$this->deg.'$3$4', $this->text);

		// XXXX г.
		$this->text = preg_replace('/(^|\D)(\d{4})г( |\.|$)/', '$1$2'.$this->space.'г$3', $this->text);

		$m = '(км|м|дм|см|мм)';
		// Кв. км м дм см мм
		$this->text = preg_replace('/(^|\D)(\d+)( |\&\#160;|\&nbsp;)?'.$m.'2(\D|$)/', '$1$2'.$this->space.'$4'.$this->sup2.'$5', $this->text);

		// Куб. км м дм см мм
		$this->text = preg_replace('/(^|\D)(\d+)( |\&\#160;|\&nbsp;)?'.$m.'3(\D|$)/', '$1$2'.$this->space.'$4'.$this->sup3.'$5', $this->text);

		// ГРАД(n)
		$this->text = preg_replace('/ГРАД\(([\d\.,]+?)\)/', '$1'.$this->deg, $this->text);

		// ДЮЙМ(n)
		$this->text = preg_replace('/ДЮЙМ\(([\d\.,]+?)\)/', '$1'.$this->Prime, $this->text);

		// Замена икса в числах на знак умножения
		$this->text = preg_replace('/(?<=\d) ?x ?(?=\d)/', $this->times, $this->text);

		// Знак евро
		$this->text = str_replace('ЕВРО()', $this->euro, $this->text);

		// Знак фунта
		$this->text = str_replace('ФУНТ()', $this->pound, $this->text);

		// Знак цента
		$this->text = str_replace('ЦЕНТ()', $this->cent, $this->text);

		// Стрелка вверх
		$this->text = str_replace('СТРВ()', $this->uarr, $this->text);

		// Стрелка вниз
		$this->text = str_replace('СТРН()', $this->darr, $this->text);

		// Стрелка влево
		$this->text = str_replace('СТРЛ()', $this->larr, $this->text);

		// Стрелка вправо
		$this->text = str_replace('СТРП()', $this->rarr, $this->text);

		// Стрелка ввод
		$this->text = str_replace('ВВОД()', $this->crarr, $this->text);
	}

	private function quotes()
	{
		$quotes = array('&quot;', '&laquo;', '&raquo;', '«', '»', '&#171;', '&#187;', '&#147;', '&#132;', '&#8222;', '&#8220;');
		$this->text = str_replace($quotes, '"', $this->text);

		$this->text = preg_replace('/([^=]|\A)""(\.{2,4}[а-яА-Я\w\-]+|[а-яА-Я\w\-]+)/', '$1<typo:quot1>"$2', $this->text);
		$this->text = preg_replace('/([^=]|\A)"(\.{2,4}[а-яА-Я\w\-]+|[а-яА-Я\w\-]+)/', '$1<typo:quot1>$2', $this->text);

		$this->text = preg_replace('/([а-яА-Я\w\.\-]+)""([\n\.\?\!, \)][^>]{0,1})/', '$1"</typo:quot1>$2', $this->text);
		$this->text = preg_replace('/([а-яА-Я\w\.\-]+)"([\n\.\?\!, \)][^>]{0,1})/', '$1</typo:quot1>$2', $this->text);

		$this->text = preg_replace('/(<\/typo:quot1>[\.\?\!]{1,3})"([\n\.\?\!, \)][^>]{0,1})/', '$1</typo:quot1>$2', $this->text);
		$this->text = preg_replace('/(<typo:quot1>[а-яА-Я\w\.\- \n]*?)<typo:quot1>(.+?)<\/typo:quot1>/', '$1<typo:quot2>$2</typo:quot2>', $this->text);
		$this->text = preg_replace('/(<\/typo:quot2>.+?)<typo:quot1>(.+?)<\/typo:quot1>/', '$1<typo:quot2>$2</typo:quot2>', $this->text);
		$this->text = preg_replace('/(<typo:quot2>.+?<\/typo:quot2>)\.(.+?<typo:quot1>)/', '$1<\/typo:quot1>.$2', $this->text);
		$this->text = preg_replace('/(<typo:quot2>.+?<\/typo:quot2>)\.(?!<\/typo:quot1>)/', '$1</typo:quot1>.$2$3$4', $this->text);
		$this->text = preg_replace('/""/', '</typo:quot2></typo:quot1>', $this->text);
		$this->text = preg_replace('/(?<=<typo:quot2>)(.+?)<typo:quot1>(.+?)(?!<\/typo:quot2>)/', '$1<typo:quot2>$2', $this->text);
		$this->text = preg_replace('/"/', '</typo:quot1>', $this->text);

		$this->text = preg_replace('/(<[^>]+)<\/typo:quot\d>/', '$1"', $this->text);
		$this->text = preg_replace('/(<[^>]+)<\/typo:quot\d>/', '$1"', $this->text);
		$this->text = preg_replace('/(<[^>]+)<\/typo:quot\d>/', '$1"', $this->text);
		$this->text = preg_replace('/(<[^>]+)<\/typo:quot\d>/', '$1"', $this->text);
		$this->text = preg_replace('/(<[^>]+)<\/typo:quot\d>/', '$1"', $this->text);
		$this->text = preg_replace('/(<[^>]+)<\/typo:quot\d>/', '$1"', $this->text);

		$this->text = str_replace('<typo:quot1>', $this->quot11, $this->text);
		$this->text = str_replace('</typo:quot1>', $this->quot12, $this->text);
		$this->text = str_replace('<typo:quot2>', $this->quot21, $this->text);
		$this->text = str_replace('</typo:quot2>', $this->quot22, $this->text);
	}

	private function dashes()
	{
		$tires = array('&mdash;', '&ndash;', '&#8211;', '&#8212;');
		$this->text = str_replace($tires, '—', $this->text);

		$pre = '(январь|февраль|март|апрель|июнь|июль|август|сентябрь|октябрь|ноябрь|декабрь)';
		$this->text = preg_replace('/'.$pre.' ?(-|—) ?'.$pre.'/i', '$1—$3', $this->text);

		$pre = '(понедельник|вторник|среда|четверг|пятница|суббота|воскресенье)';
		$this->text = preg_replace('/'.$pre.' ?(-|—) ?'.$pre.'/i', '$1—$3', $this->text);

		$this->text = preg_replace('/(^|\n|>) ?(-|—) /', '$1— ', $this->text);

		$this->text = preg_replace('/(^|[^\d\-])(\d{1,4}) ?(—|-) ?(\d{1,4})([^\d\-\=]|$)/', '$1$2'.$this->tireinterval.'$4$5', $this->text);

		$this->text = preg_replace('/ -(?= )/', $this->space.$this->tire, $this->text);
		$this->text = preg_replace('/(?<=&nbsp;|&#160;)-(?= )/', $this->tire, $this->text);

		$this->text = preg_replace('/ —(?= )/', $this->space.$this->tire, $this->text);
		$this->text = preg_replace('/(?<=&nbsp;|&#160;)—(?= )/', $this->tire, $this->text);
	}

	private function pbr()
	{
		$n = strpos($this->text, "\n");

		if ($this->_isHTMLCode)
		{
		    return;
		}

		if ($n !== false)
		{
			if ($this->br)
			{
				if (!$this->p)
				{
				    $this->text = str_replace("\n", "<br />\n", $this->text);
				}
				else
				{
					$this->text = preg_replace('/^([^\n].*?)(?=\n\n)/s', '<p>$1</p>', $this->text);
					$this->text = preg_replace('/(?<=\n\n)([^\n\<].*?)(?=\n\n)/s', '<p>$1</p>', $this->text);
					$this->text = preg_replace('/(?<=\n\n)([^\n\<].*?)$/s', '<p>$1</p>', $this->text);

					$this->text = preg_replace('/([^\n])\n([^\n])/', "$1<br />\n$2", $this->text);
				}
			}
			else
			{
				if ($this->p)
				{
					$this->text = preg_replace('/^([^\n].*?)(?=\n\n)/s', '<p>$1</p>', $this->text);
					$this->text = preg_replace('/(?<=\n\n)([^\n].*?)(?=\n\n)/s', '<p>$1</p>', $this->text);
					$this->text = preg_replace('/(?<=\n\n)([^\n].*?)$/s', '<p>$1</p>', $this->text);
				}
			}
		}
		else
		{
			if ($this->p)
			{
			    $this->text = '<p>'.$this->text.'</p>';
			}
		}
	}

	private function delpbr()
	{
		$tags = array('<br />', '<p>', '</p>');
		$this->text = str_replace($tags, '', $this->text);
	}

	private function spaces()
	{
		$this->text = str_replace("\r", '', $this->text);

		if ($this->delTab)
		{
		    $this->text=str_replace("\t", '', $this->text);
		}
		elseif ($this->replaceTab)
		{
		    $this->text=str_replace("\t", ' ', $this->text);
		}

		if ($this->trim)
		{
			$this->text=trim($this->text);
		}

		$this->text = str_replace('&nbsp;', ' ', $this->text);
		$this->text = str_replace('&#160;', ' ', $this->text);

		if ($this->delRepeatSpace)
		{
			$this->text = preg_replace('/ {2,}/', ' ', $this->text);
			$this->text = preg_replace("/\n {1,}/m", "\n", $this->text);
			$this->text = preg_replace("/\n{3,}/m", "\n\n", $this->text);
		}

		if ($this->delSpaceBeforePunctuation)
		{
			$before = array('!', ';', ',', '?', '.', ')',);
			$after = array();
			foreach ($before as $i)
			{
			    $after[]='/ \\'.$i.'/';
			}
			$this->text = preg_replace($after, $before, $this->text);
			$this->text = preg_replace('/\( /', '(', $this->text);
		}

		if ($this->spaceBeforeParticles)
		{
			$this->text = preg_replace('/ (ли|ль|же|ж|бы|б)(?![а-яА-Я])/', $this->space.'$1', $this->text);
		}

		if ($this->spaceAfterShortWord and $this->lengthShortWord>0)
		{
			$this->text = preg_replace('/( [а-яА-Я\w]{1,'.$this->lengthShortWord.'}) /', '$1'.$this->space, $this->text);
		}

		if ($this->spaceBeforeLastWord and $this->lengthLastWord>0)
		{
			$this->text = preg_replace('/ ([а-яА-Я\w]{1,'.$this->lengthLastWord.'})(?=\.|\?|:|\!|,)/', $this->space.'$1', $this->text);
		}

		if ($this->spaceAfterNum)
		{
			$this->text = preg_replace('/(№|&#8470;)(?=\d)/', $this->number.$this->space, $this->text);
			$this->text = preg_replace('/(§|&#167;|&sect;)(?=\d)/', $this->sect.$this->space, $this->text);
		}

		if ($this->delSpaceBeforeProcent)
		{
			$this->text = preg_replace('/( |&nbsp;|&#160;)%/', '%', $this->text);
		}

		return;
	}

	public function execute($text, $coding='utf-8')
	{
		if (empty($text))
		{
            return '';
		}

		$this->text = $text;

		if ($coding != 'windows-1251')
		{
		    $this->text = iconv($coding, 'windows-1251', $this->text);
		}

		preg_match_all('/<script([^\>]*)>(.*?)<\/script>/smi', $text, $scripts, PREG_SET_ORDER);
		for ($i = 0; $i < sizeof($scripts); $i++)
		{
		    $this->text = str_replace($scripts[$i][0], '__typograph__script__'.$i.'__', $this->text);
		}
		preg_match_all('/<style([^\>]*)>(.*?)<\/style>/smi', $text, $styles, PREG_SET_ORDER);
		for ($i = 0; $i < sizeof($styles); $i++)
		{
		    $this->text = str_replace($styles[$i][0], '__typograph__style__'.$i.'__', $this->text);
		}

		$this->setTMode();

		$b = strpos($this->text, '<');
		$e = strpos($this->text, '>');

		if ($b !== false and $e !== false)
		{
		    $this->_isHTMLCode = true;
		}
		else
		{
		    $this->_isHTMLCode = false;
		}

		if ($this->doReplaceBefore)
		{
		    $this->replaceBefore();
		}

		$this->spaces();
		$this->quotes();
		$this->dashes();

		if ($this->findUrls)
		{
		    $this->setUrls();
		}

		$this->pbr();

		$this->replaceWindowsCodes();

		if ($this->doReplaceAfter)
		{
		    $this->replaceAfter();
		}

		for ($i = 0; $i < sizeof($scripts); $i++)
		{
		    $this->text = str_replace('__typograph__script__'.$i.'__', $scripts[$i][0], $this->text);
		}
		for ($i = 0; $i < sizeof($styles); $i++)
		{
		    $this->text = str_replace('__typograph__style__'.$i.'__', $styles[$i][0], $this->text);
		}

		if ($coding != 'windows-1251')
		{
		    $this->text = iconv('windows-1251', $coding, $this->text);
		}

		return $this->text;
	}

	private function replaceWindowsCodes()
	{
		$before = array('§', '©',  '®', '™',  '°', '«', '·', '»', '…', '‘', '’', '“', '”', '¤', '¦', '„', '•', '–', '±', '—', '№', '‰',	'€', '¶', '¬');
	    $after = array('&#167;', '&#169;', '&#174;', '&#8482;', '&#176;', '&#171;', '&#183;',
				'&#187;', '&#133;', '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#164;', '&#166;',
				'&#8222;', '&#8226;', '&#8211;', $this->plusmn, $this->tire, $this->number, '&#8240;',
				'&#8364;', '&#182;', '&#172;');
		$this->text = str_replace($before, $after, $this->text);
	}

	private function setUrls()
	{
		if ($this->_isHTMLCode)
		{
		    return;
		}
		$prefix = '(http|https|ftp|telnet|news|gopher|file|wais)://';
		$pureUrl = '([[:alnum:]/\n+-=%&:_.~?]+[#[:alnum:]+]*)';
		$this->text = eregi_replace($prefix.$pureUrl, '<a href="\\1://\\2">\\1://\\2</a>', $this->text);
	}

}

class Typograph
{
	private static $typograph = null;

	public static function process($text)
	{
		if (self::$typograph === null)
		{
			self::$typograph = new Typograf();
			self::$typograph->p = true;
			self::$typograph->br = true;
			//self::$typograph->findUrls=true;
			// тут параметры
		}
		return self::$typograph->execute($text);
	}
}

?>