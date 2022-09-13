<?php
abstract class PageTemplate
{	
	protected $cache;
	
	public function __construct(Cache $cache)
	{
		$this->cache = $cache;
	}
	
	abstract public function create();
	
	protected function compress(& $html)
	{
		preg_match_all("!(<(?:code|pre|script|textarea).*>[^<]+</(?:code|pre|script|textarea)>)!is", $html, $pre);
		//$html = preg_replace("!<(?:code|pre|textarea).*>[^<]+</(?:code|pre|textarea)>!is", "#pre#", $html);
		//$html = preg_replace("#<!–[^\[].+–>#s", "", $html);
		//$html = preg_replace("/[\r\n\t]+/", " ", $html);
		//$html = preg_replace("/>[\s]+</", "><", $html);
		//$html = preg_replace("/[\s\t]+/s", " ", $html);
		if (!empty($pre[0]))
		{
			foreach ($pre[0] as $tag)
			{
				$html = preg_replace("!#pre#!", $tag, $html, 1);
			}
		}
	}
}
?>