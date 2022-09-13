<?php
class PageXHTML extends PageTemplate 
{
	private $parts;
	private $hashes;
	private $hash;
	private $template;
	public $player;
	
	public function __construct(Cache $cache, & $hash = null)
	{
		parent::__construct($cache);
		
		$this->parts = array();
		$this->hash = & $hash;
	}
	
	public function __call($name, $arguments)
	{
		if ($name == "addPart")
		{
			$argumentsSize = sizeof($arguments);
			switch ($argumentsSize)
			{
				case 2 :
					return $this->_addXHTMLPart($arguments[0], $arguments[1]);
					break;
				case 3 :
					return $this->_addXSLPart($arguments[0], $arguments[1], $arguments[2]);
					break; 
			}
		}		
	}
	
	private function _addXHTMLPart($name, $template)
	{
		$hash = null;
		$this->parts[$name] = new PageXHTML($this->cache, $hash);
		$this->parts[$name]->setTemplate($template);
		//$this->hashes[$name] = & $hash;
		
		//$this->hash = md5(implode("", $this->hashes));
		
		return $this->parts[$name];
	}

	private function _addXSLPart($name, $styleheet, & $data)
	{
		//$xslHash = json_encode($data);
		//$xslHash = md5($styleheet . $xslHash);
		//_debug($name . " " . $styleheet . " " . $xslHash);
		//$this->hashes[$name] = $xslHash;
		//$this->hash = md5(implode("", $this->hashes));
		//if (!$this->parts[$name] = $this->cache->get($xslHash)) {
			$this->parts[$name] = new PageXSL($this->cache);
			$this->parts[$name]->setStylesheet($styleheet);
			//$this->parts[$name]->setHash($xslHash);
			$dom = $this->_createXML($data);
			if (is_a($dom, "DOMDocument"))
			{
				$this->parts[$name]->setData($dom);
			}
			$this->parts[$name] = $this->parts[$name]->create();
			//$this->cache->set($xslHash, $this->parts[$name]);
		//} else {
			//print $styleheet . " from cache";
		//}
		return $this->parts[$name];
	}

	private function _createXML(& $data)
	{
		$t1 = microtime(true);
/*		$document = new DOMDocument();

		$document->appendChild($root = $document->createElement("data"));
		$this->_addChilds($data, $root, $document);
		return $document;
*/
		if ((DEV_SERVER || true) && function_exists("oxml_encode")) {
			$xml = oxml_encode($data);
		} else {
			$xml = "";
			$stack = 1;
			$this->_addChilds1($data, $xml, $stack);
			$xml = "<?xml version=\"1.0\"?><data>" . $xml . "</data>";
		}
		$tmp = new DOMDocument();
		$res = $tmp->loadXML($xml);
		if (!$res) {
			Std::dump($xml);
		}
/*
		$xml = $tmp->saveXML();
		$rn=rand(0, 100000);
		$fp1 = fopen("/tmp/1/".$rn."a","w");
		fputs($fp1,$xml);
		fclose($fp1);
		$xml2 = $document->saveXML();
		$fp1 = fopen("/tmp/1/".$rn."b","w");
		fputs($fp1,$xml2);
		fclose($fp1);
*/
		$t2 = microtime(true);
		$t = $t2 - $t1;
		PageXSL::$time += $t;

		return $tmp;
	}


	/*
	private function _createXML(& $data) {
		$document = new DOMDocument();
		$xml = "";
		$this->_addChilds1(& $data, & $xml);
		$xml = "<?xml version=\"1.0\"?><data>" . $xml . "</data>";
		$document->loadXML($xml);
		return $document;
	}
*/
	private function _addChilds(& $data, & $parent, & $document)
	{
		$keys = array_keys($data);
		$sum = array_sum($keys);
		if (sizeof($data) == 1 && is_integer($keys[0])) $sum = 1;
		if (is_integer($sum) && $sum > 0)
		{
			//for ($i = 0, $length = sizeof($data); $i < $length; $i++) {
			foreach ($data as $key => $value)
			{
				if ($value instanceof Data) continue;
				$parent->appendChild($element = $document->createElement("element"));
				/*
				if (is_array($data[$i])) {
					$this->_addChilds($data[$i], $element, $document);
				} else {
					$element->appendChild($document->createTextNode($data[$i]));
				}
				*/
				if (is_array($data[$key]))
				{
					$this->_addChilds($data[$key], $element, $document);
				}
				else
				{
					$element->appendChild($document->createTextNode($data[$key]));
				}
			}
		}
		else
		{
			foreach ($data as $key => $value)
			{
				if ($value instanceof Data)
				{
					continue;
				}
				$parent->appendChild($attribute = $document->createElement($key));
				if (is_array($value))
				{
					$this->_addChilds($value, $attribute, $document);
				}
				else
				{
					$attribute->appendChild($document->createTextNode($value));
				}
			}
		}		
	}


	private function _addChilds1(& $data, & $parent, $stack)
	{
		if ($stack > 8)
		{
			return;
		}
		$keys = array_keys($data);
		$sum = array_sum($keys);
		if (sizeof($data) == 1 && is_integer($keys[0])) $sum = 1;
		if (is_integer($sum) && $sum > 0)
		{
			foreach ($data as $key => $value)
			{
				if ($value instanceof Data) continue;
				$parent .= "<element>";
				if (is_array($data[$key]))
				{
					$this->_addChilds1($data[$key], $parent, $stack + 1);
				}
				else
				{
					$parent .= str_replace("<", "&lt;", $data[$key] === false ? "0" : str_replace("&", "&amp;", $data[$key]));
                    //$parent .= '<![CDATA['.$data[$key].']]>';
				}
				$parent .= "</element>";
			}
		}
		else
		{
			foreach ($data as $key => $value)
			{
				if ($value === false) $value = "0";
				if ($value instanceof Data) 
				{
					continue;
				}
				$parent .= "<" . $key . ">";
				if (is_array($value))
				{
					$this->_addChilds1($value, $parent, $stack + 1);
				}
				else
				{
					$parent .= str_replace("<", "&lt;", $value === false ? "0" : str_replace("&", "&amp;", $value));
                    //$parent .= '<![CDATA['.$value.']]>';
				}
				$parent .= "</" . $key . ">";
			}
		}
	}


	public function addValue($name, $value)
	{
		$this->parts[$name] = $value;
		//$this->hashes[$name] = md5(serialize ($value));
		//$this->hash = md5(implode("", $this->hashes));
		return true;
	}

	public function create()
	{
		//$this->hash = md5(implode("", $this->hashes));
		//if (!$content = $this->cache->get($this->hash))
		//{
			//if (!$content = $this->cache->get($this->template))
			//{
				$content = file_get_contents($this->template);
				//$this->cache->set($this->template, $content);
			//}
			foreach ($this->parts as $partName => $partObject)
			{
				if (is_a($partObject, "PageTemplate"))
				{
					$partContent = $partObject->create();
				}
				else
				{
					$partContent = $partObject;
				}
				$content = str_replace("<%" . $partName . "%>",	$partContent, $content);
				unset($partContent);
			}
			if (is_a($this->player, 'playerObject')) {
				if ($this->player->sex == 'female') {
					$content = preg_replace("/{%sex:([^\|]*)\|([^\%]*)%}/im", "\\2", $content);
				} else {
					$content = preg_replace("/{%sex:([^\|]*)\|([^\%]*)%}/im", "\\1", $content);
				}
				if ($this->player->fraction == 'arrived') {
					$content = preg_replace("/{%fraction:([^\|]*)\|([^\%]*)%}/im", "\\1", $content);
				} else {
					$content = preg_replace("/{%sex:([^\|]*)\|([^\%]*)%}/im", "\\2", $content);
				}
				$content = str_replace(array('{%player:nickname%}', '{%player:level%}', '{%player:money%}', '{%player:ore%}', '{%player:honey%}', '{%player:id%}'), array($this->player->nickname, $this->player->level, $this->player->money, $this->player->ore, $this->player->honey, $this->player->id), $content);
			}
			$content = preg_replace("/<%([^%])*%>/", "", $content);
			//$this->compress($content);
			//$this->cache->set($this->hash, $content);
		//}
		return $content;
	}
	
	public function setTemplate($template)
	{
        global $data;
		$this->template = '@tpl/'. ($data['vk'] ? 'vk/' : '') . $template;
		//$this->hashes["__template"] = md5($template);
		//$this->hash = md5(implode("", $this->hashes));
	}
}
?>
