<?php
/*Copyright (C) 2013 Jarosław Stasiaczek
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

/**
 * Script class store all css and js files and render it in template
 */
class Ciap_Script implements Ciap_Interface_AutoloadInit{
	protected static $instance = null;
	protected $script = Array();
	protected $link = Array();
	
	/**
	 * 
	 * @param string $class
	 * @return Ciap_Script
	 */
	public static function getInstance($class = __CLASS__)
	{
		if(!empty(self::$instance))
			return self::$instance;
		self::$instance = new $class();
		return self::$instance;
	}

	public static function moduleInit() { 
		$config = Config::getInstance('main.php');
		$me = self::getInstance();
		$scripts = $config->register_scripts;
		$me->registerArray($scripts);
	}
	
	public function registerArray(array $scripts)
	{
		if(isset($scripts['link']))
			foreach($scripts['link'] as $name=>$data)
				$this->setArray ('link',$name, $data);
		if(isset($scripts['script']))
			foreach($scripts['script'] as $name=>$data)
				$this->setArray ('script',$name, $data);
	}
	
	public function registerScript($name, $src, $type='text/javascript',array $attributes = Array())
	{
		$params = array_merge($attributes, Array('src' => $src, 'type' => $type));
		$this->setArray('script', $name, $params);
	}
	
	public function registerLink($name, $href, $rel ='stylesheet', array $attributes = Array())
	{
		$params = array_merge($attributes, Array('href' => $href, 'rel' => $rel));
		$this->setArray('link', $name, $params);
	}
	
	protected function setArray($array_name, $key, array $data = Array())
	{
		$this->{$array_name}[$key] = $data;
	}
	
	
	public function renderHeader()
	{
		$html = '';
		$html .= $this->renderArray($this->link, '<link', '/>');
		$html .= $this->renderArray($this->script, '<script', '></script>');
		return $html;
	}
	
	protected function renderArray(array $array, $tagBegin, $tagEnd)
	{
		$html = '';
		foreach($array as $key=>$data)
		{
			$condition = isset($data['_condition_comment'])? $data['_condition_comment']: false;
			if($condition)
			{
				unset($data['_condition_comment']);
				$html .= '<!--[if '.$condition.']>'."\n";
			}
			if(isset($data['href']))
				$data['href'] = Ciap::$baseUrlNoFile.$data['href'];
			if(isset($data['src']))
				$data['src'] = Ciap::$baseUrlNoFile.$data['src'];
			$html .= $tagBegin.''.$this->renderAttributes($data).' '.$tagEnd."\n";
			if($condition)
				$html .= "<![endif]--> \n";
		}
		return $html;
	}
	
	protected function renderAttributes(array $attributes)
	{
		$attr = '';
		foreach($attributes as $key=>$value)
		{
			$attr .= ' '.$key.'="'.$value.'"';
		}
		return $attr;
	}
}

?>
