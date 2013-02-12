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

/**
 * Configuration class
 * @property string $image_upload_dir
 * @property string $image_upload_url
 * @property string $thumb_dir
 * @property string $thumb_url
 * @property bool $show_breadcrumb
 * @property bool $show_tree
 * @property bool $show_dirs_in_filelist
 * @property array $allowed_mime_types
 * @property string $default_directory_view
 * @property bool $skip_xhr_upload
 * @property array $thumb_create
 */
class Config implements ArrayAccess{
	private $data = Array();
	private static $instance = null;
	
	protected function __construct($config_file_name = null) {
		$dir = dirname(__FILE__).'/Config/';
		$this->data = include $dir."default.php";
		if(!empty($config_file_name) && file_exists($dir.$config_file_name))
		{
			$user_data = include $dir.'main.php';
			$this->data = array_merge($this->data, $user_data);
		}
	}
	
	/**
	 * Return instance of config class
	 * @param string $class
	 * @return Config
	 */
	public static function getInstance($config_file_name = null,$class = __CLASS__)
	{
		if(!empty(self::$instance))
			return self::$instance;
		self::$instance = new $class($config_file_name);
		return self::$instance;
	}
	
	
	public function offsetExists($offset) {
		return isset($this->data[$offset]);
	}

	public function offsetGet($offset) {
		return $this->data[$offset];
	}

	public function offsetSet($offset, $value) {
		$this->data[$offset] = $value;
	}

	public function offsetUnset($offset) {
		unset($this->data[$offset]);
	}
	
	public function __get($name) {
		if($this->offsetExists($name))
			return $this->offsetGet ($name);
		return null;
	}
	
	public function __set($name, $value) {
		$this->offsetSet($name, $value);
	}
}

?>
