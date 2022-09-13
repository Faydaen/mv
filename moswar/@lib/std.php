<?php
/**
 * Стандартные функции
 *
 */
class Std {
	public static $dumpN = 0;

	public static function formatRussianNumeral($n, $form1, $form2, $form5)
	{
		$n = abs($n) % 100;
		$n1 = $n % 10;
		if ($n > 10 && $n < 20) return $form5;
		if ($n1 > 1 && $n1 < 5) return $form2;
		if ($n1 == 1) return $form1;
		return $form5;
	}

	public static function formatPeriod($time) {
		if ($time >= 60) {
			$minutes = floor($time / 60);
			if ($minutes >= 60) {
				$hours = floor($minutes / 60);
				if ($hours >= 24) {
					$days = floor($hours / 24);
					$hours = $hours % 24;
					$result = $days . " " . self::formatRussianNumeral($days, "день", "дня", "дней");
					if ($hours > 0) $result .= " " . $hours . " " . self::formatRussianNumeral($hours, "час", "часа", "часов");
					return $result;
				}
				$minutes = $minutes % 60;
				$result = $hours . " " . self::formatRussianNumeral($hours, "час", "часа", "часов");
				if ($minutes > 0) $result .= " " . $minutes . " " . self::formatRussianNumeral($minutes, "минуту", "минуты", "минут");
				return $result;
			} else {
				$result = $minutes . " " . self::formatRussianNumeral($minutes, "минуту", "минуты", "минут");
				$seconds = $time % 60;
				if ($seconds > 0) $result .= " " . $seconds . " " . self::formatRussianNumeral($seconds, "секунду", "секунды", "секунд");
				return $result;
			}
		} else {
			return $time . " " . self::formatRussianNumeral($time, "секунду", "секунды", "секунд");
		}
	}

	public static function formatPeriodShort($time) {
		if ($time >= 60) {
			$minutes = floor($time / 60);
			if ($minutes >= 60) {
				$hours = floor($minutes / 60);
				$minutes = $minutes % 60;
				$result = $hours . ":";
				if ($minutes > 0) {
					if ($minutes < 10) $minutes = "0" . $minutes;
					$result .= $minutes . ":";
				} else $result .= "00:";
				$seconds = $time % 60;
				if ($seconds > 0) {
					if ($seconds < 10) $seconds = "0" . $seconds;
					$result .= $seconds;
				} else $result.= "00";
				return $result;
			} else {
				if ($minutes < 10) $minutes = "0" . $minutes;
				$result = $minutes . ":";
				$seconds = $time % 60;
				if ($seconds < 10) $seconds = "0" . $seconds;
				if ($seconds > 0) $result .= $seconds;
				else $result .= "00";
				return $result;
			}
		} else {
			return "00:" . $time;
		}
	}

	public static function formatPeriodLog($time) {
		if ($time >= 60) {
			$minutes = floor($time / 60);
			if ($minutes >= 60) {
				$hours = floor($minutes / 60);
				$minutes = $minutes % 60;
				$result = $hours . "h";
				if ($minutes > 0) $result .= " " . $minutes . "m";
				return $result;
			} else {
				return $minutes . "m";
			}
		} else {
			return $time . "s";
		}
	}

    /**
     * Обработка строки для SQL запроса
     *
     * @param string $String
     * @return string
     */
    public static function cleanString($string)
    {
        return mysql_real_escape_string(trim($string));
    }

    /**
     * Загрузка HTML шаблона
     *
     * @param string $Template
     * @return string
     */
    public static function loadTemplate ($template)
    {
        return file_get_contents('@tpl/'.$template.'.html');
    }

    /**
     * Загрузка библиотеки
     *
     * @param string $Lib
     */
    public static function loadLib($lib)
    {
        if (!class_exists("Runtime") || (!in_array($lib, Runtime::$loadedLibs) && !class_exists($lib)))
        {
            include('@lib/'.strtolower($lib).'.php');
            Runtime::$loadedLibs[] = $lib;
        }
    }

    /**
     * Загрузка модуля с переводами текстов
     *
     */
    public static function loadLang()
    {
        global $configProject;

        if ($configProject['lang'] != '') {
            if (!class_exists('Runtime') || (!in_array('Lang', Runtime::$loadedLibs) && !class_exists('Lang')))
            {
                include('@mod/lang/'.$configProject['lang'] . '.php');
                Runtime::$loadedLibs[] = 'Lang';
            }
        }
    }

    /**
     * Загрузка класса метаобъекта
     *
     * @param string $metaObjectCode
     */
    public static function loadMetaObjectClass($metaObjectCode)
    {
        if (!in_array($metaObjectCode.'Object', Runtime::$loadedLibs) && file_exists('@obj/'.strtolower($metaObjectCode).'.base.php') && file_exists('@obj/'.strtolower($metaObjectCode).'.php'))
        {
            include('@obj/'.strtolower($metaObjectCode).'.base.php');
            include('@obj/'.strtolower($metaObjectCode).'.php');
            Runtime::$loadedLibs[] = $metaObjectCode.'Object';
        }
    }

    /**
     * Загрузка расширения для метаобъекта
     *
     * @param string $metaObjectCode
     * @return bool
     */
    public static function loadMetaObjectExtention($metaObjectCode)
    {
        if (in_array($metaObjectCode.'Extention', Runtime::$loadedLibs))
        {
            return true;
        }
        if (file_exists('@obj/'.strtolower($metaObjectCode).'.ext.php'))
        {
            include('@obj/'.strtolower($metaObjectCode).'.ext.php');
            Runtime::$loadedLibs[] = $metaObjectCode.'Extention';
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Загрузка модуля
     *
     * @param string $module
     */
    public static function loadModule($module)
    {
        if (!in_array($module.'Module', Runtime::$loadedLibs) && !class_exists($module))
        {
            include('@mod/'.strtolower($module).'.php');
            Runtime::$loadedLibs[] = $module.'Module';
        }
    }

    /**
     * Редирект
     *
     * @param string $Url
     * @param bool $stopExecution
     */
    public static function redirect($url, $stopExecution=true)
    {
		if (is_callable('Page::forceEndTransactions')) {
			Page::forceEndTransactions();
		}
		if (function_exists('writeTiming')) {
			writeTiming();
		}
        header('Location: '.$url);
        if ($stopExecution)
        {
            exit;
        }
    }

    /**
     * Перевод строки в транслит
     *
     * @param string $str
     * @param bool $uniqueName
     * @return string
     */
    public static function translit($str, $uniqueName=false)
    {
        //$str = str_replace(' ', '-', $str);
        $ru = array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я');
        $en = array('A','B','V','G','D','E','E','G','Z','I','J','K','L','M','N','O','P','R','S','T','U','F','H','C','CH','SH','SCH','','I','','E','U','YA','a','b','v','g','d','e','e','g','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','','y','','e','u','ya');
        $str = str_replace($ru, $en, $str);
        $str = preg_replace("/[^a-zA-Z0-9_\.-]/", '', $str);
        if ($uniqueName) {
            $str = mt_rand(100001, 999999).'__'.$str;
        }
        return $str;
    }

    /**
     * Определение IP адреса
     *
     * @return string
     */
    public static function getClientIP()
    {
        return $_SERVER['REMOTE_ADDR'];
        if (getenv("HTTP_CLIENT_IP"))
        {
            $ip = getenv("HTTP_CLIENT_IP");
        }
        elseif (getenv("HTTP_X_FORWARDED_FOR") && (!strstr(getenv("HTTP_X_FORWARDED_FOR"),"192.168.") && (!strstr(getenv("HTTP_X_FORWARDED_FOR"),"255.255.255."))))
        {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        }
        elseif (getenv("REMOTE_ADDR"))
        {
            $ip = getenv("REMOTE_ADDR");
        }
        else
        {
            $ip = "";
        }
        return $ip;
    }

    /**
     * Генерация HTML на основе шаблона и данных
     *
     * @param string $Template
     * @param array $Data
     * @return string
     */
    public static function renderTemplate($template, $data)
    {
        if (is_array($data))
        {
            foreach ($data as $field=>$value)
            {
                $template = str_replace('<%'.$field.'%>', $value, $template);
            }
        }
        return $template;
    }

    /**
     * Генерация списка страниц
     *
     * @param int $Total - всего элементов
     * @param int $OnPage - элементов на странице
     * @param int $CurPage - номер текущей старницы, начиная с 1
     * @param string $Href - ссылка, к которой будет приписано "<номер-страницы>/"
     * @param bool $ShowIfOnePage - показывать ссылки если всего одна страница
     * @param int $Show - кол-во ссылок справа/слева от текущей
     * @return string
     */
    public static function renderNavigation($total, $onPage, $curPage, $href, $showIfOnePage=true, $show=2)
    {
        $prev_templ = self::loadTemplate('nav/prev');
        $prev_dis_templ = self::loadTemplate('nav/prev_disabled');
        $pagenumlink_template = self::loadTemplate('nav/pagenumberlink');
        $current_template = self::loadTemplate('nav/current');
        $next_templ = self::loadTemplate('nav/next');
        $next_dis_templ = self::loadTemplate('nav/next_disabled');
        $sep_templ = self::loadTemplate('nav/separator');
        $nav_templ = self::loadTemplate('nav/nav');
        //
        $pages = ($total - ($total % $onPage)) / $onPage;
        if($Total > ($pages * $onPage))
        {
            $pages++;
        }
        if (($pages > 1) || ($showIfOnePage))
        {
            $pageNums = array();
            for ($i =- $show; $i <= $show; $i++)
            {
                $link = '';
                if ($i == 0)
                {
                    $pageNums[] = str_replace(array('<%page_no%>', '<%href%>'), array($curPage, $href.$curPage.'/'), $current_template);
                }
                else
                {
                    $n = $curPage + $i;
                    if (($n > 0) && ((($n * $onPage) == $total) || ((($n - 1) * $onPage) < $total)))
                    {
                        $pageNums[] = str_replace(array('<%page_no%>', '<%href%>'), array($n, $href.$n.'/'), $pagenumlink_template);
                    }
                }
            }
            // 1 ... 5 6 7
            if ($curPage - $show > 1)
            {
                $link = str_replace(array('<%page_no%>', '<%href%>'), array(1, $href.'1/'), $pagenumlink_template);
                if ($curPage - $show > 2)
                {
                    $link .= $sep_templ.' &hellip; ';
                }
                array_unshift($pageNums, $link);
            }
            // 1 2 3 ... 7
            if ($pages - $curPage > $show)
            {
                $link = '';
                if ($pages - $curPage > $show + 1)
                {
                    $link = ' &hellip; '.$sep_templ;
                }
                $link .= str_replace(array('<%page_no%>', '<%href%>'), array($pages, $href.$pages.'/'), $pagenumlink_template);
                array_push($pageNums, $link);
            }
            // первая, назад, вперед, последняя
            $prev = str_replace('<%href%>', $href.($curPage - 1), ($curPage > 1 ? $prev_templ : $prev_dis_templ));
            $next = str_replace('<%href%>', $href.($curPage + 1), ($curPage < $Pages ? $next_templ : $next_dis_templ));
            return std::renderTemplate($nav_templ, array(
                'prev'=>$prev,
                'next'=>$next,
                'sep'=>$sep_templ,
                'pages'=>implode($sep_templ, $pageNums),
            ));
        }
        else
        {
            return '';
        }
    }

    /**
     * Проверка прав доступа
     *
     * @param int $metaObjectId
     * @param int $objectId
     * @param int $rights
     * @param int $userId
     * @return bool
     */
    public static function checkUserRightsOnObject($metaObjectId, $objectId, $rights, $userId=0)
    {
        $sql = SqlDataSource::getInstance();
        if (!is_numeric($metaObjectId))
        {
            $metaObjectId = $sql->getValue("SELECT id FROM metaobject WHERE code='$metaObjectId'");
        }
        return $sql->getValue("SELECT checkUserRightsOnObject($metaObjectId, $objectId, ".Runtime::$gid.", $rights");
    }

    /**
     * Проверка загруженного файла на безопасность
     *
     * @param array $file - $_FILES[*]
     * @param string $type - {image, file}
     * @return bool
     */
    public static function testUploadedFile($file, $type)
    {
        switch ($type)
        {
            case 'image':
                $ext = explode('.', $file['name']);
                $ext = strtolower($ext[count($ext)-1]);
                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'png')
                {
                    switch ($ext)
                    {
                        case 'jpg': case 'jpeg': $func = 'imagecreatefromjpeg'; break;
                        case 'gif': $func = 'imagecreatefromgif'; break;
                        case 'png': $func = 'imagecreatefrompng'; break;
                    }
                    $img = $func($file['tmp_name']);
                    if (!$img)
                    {
                        return false;
                    }
                    else
                    {
                        imagedestroy($img);
                        return true;
                    }
                }
                else
                {
                    return false;
                }
                break;
            case 'file':
                $ext = explode('.', $file['name']);
                $ext = strtolower($ext[count($ext)-1]);
                $scriptExt = array('php','php3','php4','php5','phtml','pl','cs','vb','aspx');
                return (in_array($ext, $scriptExt)) ? false : true;
                break;
        }
    }

	/**
	 * Отправка письма с вложениями
	 *
	 * @param string $from от кого
	 * @param string $to кому

	 * @param string $subject тема
	 * @param string $text собственно текст (html)
	 * @param string $cc копия
	 * @return unknown
	 */
	public static function sendMultipartMail($from, $to, $subject, $text, $cc = null) {
		$subject = "=?utf-8?B?".base64_encode($subject)."?=";
		$domain = 'http://www.moswar.ru';
		$headers ="From: $from\n";
		//$headers.="To: $to\n";
		if (!is_null($cc)) {
			$headers.="Cc: $cc\n";
		}
		//$headers.="Subject: $subject\n";
		$headers.="Date: ".date("r")."\n";

		$headers.="Return-Path: $from\n";
		$headers.="X-Mailer: zm php script\n";
		$headers.="MIME-Version: 1.0\n";
		
		$baseboundary="------------".strtoupper(md5(uniqid(rand(), true)));
		$newboundary="------------".strtoupper(md5(uniqid(rand(), true)));

		//$headers .= "Content-Type: multipart/mixed;\nboundary=\"$baseboundary\"\n";
		//$headers.="This is a multi-part message in MIME format.\n";

		$headers.="Content-Type: multipart/mixed;\n";
		$headers.="  boundary=\"$baseboundary\"\n";
		
		$message.="--$baseboundary\n";
		$message.="Content-Type: multipart/related;\n";
		$message.="  boundary=\"$newboundary\"\n\n\n";
		$message.="--$newboundary\n";
		$message.="Content-Type: text/html; charset=utf-8\n";

		$message.="Content-Transfer-Encoding: 7bit\n\n";
		$message.=($text)."\n\n";
		preg_match_all('/img(.+?)src="([^"]+)"/i',$text,$m);

		if (isset($m[2])) {
			$img_f=$m[2];
			if (is_array($img_f)) {
				foreach ($img_f as $k => $v) {
					$img_f[$k]=str_ireplace($domain.'/','',$v);
				}
			}
		}
		$attachment_files=$img_f;
		$names = array();
		$log = '';
		if (is_array($attachment_files)) {
			foreach($attachment_files as $filename)  {
				if (isset($names[$filename])) {
					continue;
				}
				$log .= 'filename: ' . $filename . PHP_EOL;
				$log .= 'filesize: ' . filesize($filename) . PHP_EOL;
				$names[$filename] = 1;
				//$file_content = file_get_contents($filename,true);
				$fp = fopen($filename,"rb");
				$file_content = fread($fp, filesize($filename));
				fclose($fp);
				$log .= 'length: ' . strlen($file_content) . PHP_EOL;
				$mime_type='image/png';
				if(function_exists("mime_content_type"))  {
					$mime_type=mime_content_type($filename);
				}
				else {
					switch (file_ext($filename)) {
						case 'jpg': $mime_type='image/jpeg';break;
						case 'gif': $mime_type='image/gif';break;
						case 'png': $mime_type='image/png';break;
						default:;
					}
				}

				$message=str_replace($domain.'/'.$filename,'cid:'.basename($filename),$message);
				$filename=basename($filename);
				$message.="--$newboundary\n";
				$message.="Content-Type: $mime_type;\n";
				$message.=" name=\"$filename\"\n";
				$message.="Content-Transfer-Encoding: base64\n";
				$message.="Content-ID: <$filename>\n";
				$message.="Content-Disposition: inline;\n";
				$message.=" filename=\"$filename\"\n\n";
				$message.=chunk_split(base64_encode($file_content));
				//fclose($file_content);
			}
		}
		$message.="--$newboundary--\n\n";

		/*$message="--$baseboundary\n";
		$message.="Content-Type: text/plain; charset=utf-8\n";
		$message.="Content-Transfer-Encoding: 7bit\n\n";
		$text_plain=str_replace('<p>',"\n",$text);
		$text_plain=str_replace('<b>',"",$text_plain);
		$text_plain=str_replace('</b>',"",$text_plain);
		$text_plain=str_replace('<br>',"\n",$text_plain);
		$text_plain= preg_replace('/<a(\s+)href="([^"]+)"([^>]+)>([^<]+)/i',"\$4\n\$2",$text_plain);
		$message.=strip_tags($text_plain);
		$message.="\n\nIts simple text. Switch to HTML view!\n\n";*/

		$message.="--$baseboundary--\n";

		return mail($to, $subject, $message , $headers);
	}

    /**
     * Отправить e-mail
     *
     * @param strign $email
     * @param string $subject
     * @param string $body
     * @param string $from
     * @param string $replyTo
     */
    public static function sendMail($email, $subject, $body, $from, $replyTo='', $fixUtf8=false)
    {
        $replyTo = $replyTo == "" ? $from : $replyTo;
		$subject = "=?".$GLOBALS['config']['headerCharset']."?B?".base64_encode(iconv("UTF-8", $GLOBALS['config']['headerCharset'], $subject))."?=";
		$header = "From: "."=?".$GLOBALS['config']['headerCharset']."?B?".base64_encode(iconv("UTF-8", $GLOBALS['config']['headerCharset'], $from))."?="." <".$from.">\r\n".($replyTo==''?'':"Reply-To: ".$replyTo."\r\n")."Return-Path: " . $from . "\r\nContent-Type: text/html; charset=\"UTF-8\"\r\n";
		return @mail($email, $subject, $body, $header);
    }

    /**
     * Упаковка массива в JSON
     *
     * @param array $array
     * @return string
     */
    public static function arrayToJson($array)
    {
        $items = array();
        foreach ($array as $key => $value) {
            $item = is_numeric($key) ? '' : '"'.$key.'":';
            $item .= is_array($value) ? self::arrayToJSON($value) : '"'.$value.'"';
            $items[] = $item;
        }
        return is_numeric($key) ? '['.implode(',', $items).']' : '{'.implode(',', $items).'}';
    }

    /**
     * Упаковка массива в XML
     *
     * @param array $array
     * @param bool $isRoot
     * @return string
     */
    public static function arrayToXml($array, $isRoot = true, $rootTagName = 'contentico')
    {
        $xml = $isRoot ? '<?xml version="1.0" encoding="utf-8"?><' . $rootTagName . '>' : '';
        foreach ($array as $key => $value) {
            $key = is_numeric($key) ? 'element' : $key;
            $xml .= '<'.$key.'>'.(is_array($value) ? self::arrayToXml($value, false) : str_replace(array('<','>'), array('&lt;','&gt;'), $value)).'</'.$key.'>';
        }
        $xml .= $isRoot ? '</' . $rootTagName . '>' : '';
        return $xml;
    }
    
    /**
     * Поиск свободного имени для файла
     *
     * @param string $path
     * @param string $filesPath
     * @return string
     */
    public function getNextFreeFileName($path)
    {
        $i = 1;
        while (file_exists($path)) {
            $path = explode('.', $path);
            if ($i == 1) {
                $path[count($path)-2] .= '['.$i.']';
            } else {
                $path[count($path)-2] = str_replace('['.($i-1).']', '['.$i.']', $path[count($path)-2]);
            }
            $path = implode('.', $path);
            $i++;
        }
        return $path;
    }

    public static function dump($data, $cleanFile = false, $file = 'dump.txt')
    {
        $f = $cleanFile ? fopen($file, "w+") : fopen($file, "a+");
        if (is_array($data)) {
            $data = json_encode($data);
        }
        fputs($f, PHP_EOL . date('Y-m-d H:i:s', time()) . "\t" . Runtime::$uid . "\t" . Std::$dumpN . "\t" . $data);
        fclose($f);
		Std::$dumpN ++;
    }

	// 0 - desc - от большего к меньшему
	// 1 - asc - от меньшего к большему
	/*
    public static function sortRecordSetByField(&$recordSet, $field, $sortOrder = 1) {
        $setForSorting = array();
        for ($i = 0, $len = sizeof($recordSet); $i < $len; $i++) {
            $setForSorting["$i"] = is_numeric($recordSet[$i][$field]) ? (int)$recordSet[$i][$field] : $recordSet[$i][$field];
        }
        if ($sortOrder == 1) {
            asort($setForSorting);
        } else {
            arsort($setForSorting);
        }
        $recordSet2 = $recordSet;
        $recordSet = array();
        foreach ($setForSorting as $i => $fieldValue) {
            $recordSet[] = $recordSet2[$i];
        }
    }
*/

	// 0 - desc - от большего к меньшему
	// 1 - asc - от меньшего к большему
	public static function sortRecordSetByField(&$recordSet, $field, $sortOrder = 1) {
		if ($sortOrder != 1) $sortOrder = -1;
		usort($recordSet, function($a, $b)use(&$field, &$sortOrder) {
			if ($a[$field] == $b[$field]) return 0;
			return ($a[$field] < $b[$field]) ? $sortOrder * -1 : $sortOrder;
		});
    }
}

function callPhpFunction($args) {
	var_dump($args);
	if (!is_array($args) || count($args) == 0) {
		return false;
	}
	$funcName = $args[0];
	if (count($args) == 1) {
		return call_user_func($funcName);
	}
	unset($args[0]);
	return call_user_func_array($funcName, $args);
}
?>