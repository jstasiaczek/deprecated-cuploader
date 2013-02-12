<?php
/*Copyright (C) 2012 Jarosław Stasiaczek
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software 
 * and associated documentation files (the "Software"), to deal in the Software without restriction, 
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, 
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is 
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR 
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE 
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, 
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR 
 * OTHER DEALINGS IN THE SOFTWARE.
 */
class Ciap_Url implements Ciap_Interface_AutoloadInit{
	protected $baseUrl = null;
	protected $resource_name = null;
	protected $params = Array();
	
	protected function __construct($resource_name, array $params = Array()) {
		$this->resource_name = $resource_name;
		$this->params = $params;
		$this->baseUrl = Ciap::$baseUrl;
	}
	
	/**
	 * 
	 * @param string $key
	 * @param string $value
	 * @return \Ciap_Url
	 */
	public function setParam($key, $value)
	{
		$this->params[$key] = $value;
		return $this;
	}
	
	public function getParam($key, $default = null)
	{
		if(!isset($this->params[$key]))
			return $default;
		return $this->params[$key];
	}
	
	public function buildUrl()
	{
		$url = $this->baseUrl.'/';
		$url .= $this->resource_name.'/';
		if(!empty($this->params))
			$url .= $this->buildParams();
		return $url;
	}
	
	protected function buildParams()
	{
		$params = '?';
		$i = 0;
		foreach($this->params as $key=>$value)
		{
			$i++;
			$params .= $key.'='.$value;
			if(count($this->params) != $i)
				$params .= '&';
		}
		return $params;
	}
	
	public function __toString() {
		return $this->buildUrl();
	}
	
	
	/******************************************************STATIC PART******************************************************/
	
	protected static $type = null;
	protected static $lang = null;
	
	/**
	 * 
	 * @param string $base_path
	 * @param string $class
	 * @return Ciap_Url
	 */
	public static function create($resource_name, array $params = Array(), $class = __CLASS__)
	{
		if(!isset($params['lang']))
			$params['lang'] = self::$lang;
		if(!isset($params['type']))
			$params['type'] = self::$type;
		return new $class($resource_name, $params);
	}

	public static function moduleInit() {
	}
	
	public static function setType($type)
	{
		self::$type = $type;
	}
	public static function setLang($lang)
	{
		self::$lang = $lang;
	}
}

?>
