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
class Ciap_Cookie {
	protected static $instance = null;
	protected $cookie_name = null;
	protected $data = Array();
	/**
	 * Return instance of Ciap_Cookie
	 * @param type $class
	 * @return Ciap_Cookie
	 */
	public static function getInstance($class = __CLASS__)
	{
		if(!empty(self::$instance))
			return self::$instance;
		self::$instance = new $class;
		return self::$instance;
	}
	
	function __construct() {
		if(isset($_SERVER['HTTP_USER_AGENT']))
		{
			$this->cookie_name = 'cuploader';
		}
		else
		{
			$this->cookie_name = 'cuploader';
		}
		$this->readData();
	}
	
	/**
	 * Check if key exists
	 * @param string $key
	 * @return boolean
	 */
	public function is($key)
	{
		return isset($this->data[$key]);
	}
	
	/**
	 * Return key value
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		if($this->is($key))
			return $this->data[$key];
		else
			return $default;
		
	}
	
	/**
	 * Set key value, return false if saving failed returns false
	 * @param string $key
	 * @param mixed $value
	 * @return boolean
	 */
	public function set($key, $value)
	{
		$this->data[$key] = $value;
		return $this->storeData();
	}
	
	/**
	 * return array of all keys
	 * @return array
	 */
	public function getArray()
	{
		return $this->data;
	}
	
	protected function storeData()
	{
		$serialized = serialize($this->data);
		return setcookie($this->cookie_name, $serialized);
	}
	
	protected function readData()
	{
		if(isset($_COOKIE[$this->cookie_name]) && !empty($_COOKIE[$this->cookie_name]))
		{
			try 
			{
				$serialized = $_COOKIE[$this->cookie_name];
				$this->data = unserialize($serialized);
				if($this->data == false)
					$this->data = Array();
			} 
			catch (Exception $exc) 
			{}
		}
	}

}

?>