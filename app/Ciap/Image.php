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
class Ciap_Image {
	public static $defaultDriver = 'Ciap_Image_Driver_Gd';
	/**
	 *
	 * @var Ciap_Image_Driver 
	 */
	protected $driver = null;
	/**
	 *
	 * @var Ciap_Image_Resource 
	 */
	protected $resource = null;



	protected function __construct($image_name, $driver) {
		$this->driver = new $driver;
		$mime_type = self::getContentType($image_name);
		$this->resource = $this->getImageRes($image_name, $mime_type);
	}
	
	/**
	 * 
	 * @param string $file
	 * @param string $type
	 * @return Ciap_Image_Resource
	 */
	protected function getImageRes($file, $type)
	{
		return $this->driver->load($file, $type);
	}	
	
	/**
	 * Save converted file
	 * @param string $name
	 * @param string $extend_name
	 * @return boolean
	 */
	public function save($name, $extend_name = false)
	{
		if($extend_name)
		{
			$name = self::extendImageName($this->resource->path, $name);
		}
		
		return $this->driver->save($this->resource, $name);
	}
	
	/**
	 * Convert image
	 * @param type $class_name
	 * @param array $options
	 * @return Ciap_Image
	 * @throws Ciap_Image_Exception
	 */
	public function convert($class_name,array $options = Array())
	{
		$converter = $class_name::getConverter($this->driver, $this->resource, $options);
		if(!($converter instanceof Ciap_Image_Driver_Convert))
		{
			throw new Ciap_Image_Exception('Convert must implements Ciap_Image_Driver_Convert interface');
		}
		$this->resource = $converter->transform();
		unset($converter);
		return $this;
	}
	
	/**
	 * Return file name
	 * @return string
	 */
	public function getImageName() {
		return $this->resource->filename;
	}

	/**
	 * Return path of image
	 * @return string
	 */
	public function getImagePath() {
		return $this->resource->path;
	}

	/**
	 * Return mime type of image
	 * @return string
	 */
	public function getMimeType() {
		return $this->resource->mime_type;
	}

	/**
	 * Return resource of image
	 * @return Ciap_Image_Resource
	 */
	public function getResource() {
		return $this->resource;
	}
	
	
	//=================================== STATIC PART ============================
	
	/**
	 * Return mime type of file
	 * @param string $image_path
	 * @return string
	 */
	public static function getContentType($image_path)
	{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime_type = finfo_file($finfo, $image_path);
		finfo_close($finfo);
		return $mime_type;
	}
	
	/**
	 * Add text just before file extension.
	 * @param string $full_path
	 * @param string $extender
	 * @return string
	 */
	public static function extendImageName($full_path, $extender)
	{
		$pos =strrpos($full_path, '.');
		if($pos !== false)
		{
			$ext = substr($full_path, $pos);
			$begin = substr($full_path, 0, $pos);
			return $begin.$extender.$ext;
		}
		else
		{
			return $full_path.$extender;
		}
	}
	
	/**
	 * Create instance of Ciap_Image
	 * @param string $path
	 * @param string $driver
	 * @param string $class
	 * @return Ciap_Image
	 */
	public static function create($path, $driver = null, $class = __CLASS__)
	{
		if(empty($driver))
		{
			$driver = self::$defaultDriver;
		}
		return new $class($path, $driver);
	}
	
	/**
	 * Convert file and save it.
	 * @param string $input_file
	 * @param string $output_file
	 * @param string $convert_class
	 * @param array $options
	 * @return boolean
	 */
	public static function convertFileAndSave($input_file, $output_file, $convert_class, array $options = Array())
	{
		self::create($input_file)->convert($convert_class, $options)->save($output_file);
		return true;
	}
	
	/**
	 * Load all classes needed to run library
	 * @param string $dir
	 */
	public static function preloadAllClasses($dir = null)
	{
		if(empty($dir))
		{
			$dir = dirname(__FILE__).'/Image/';
		}
		require_once $dir.'/Exception.php';
		require_once $dir.'/Resource.php';
		require_once $dir.'/Driver.php';
		require_once $dir.'/Convert.php';
		require_once $dir.'/Convert/Abstract.php';
		self::includeRecurse($dir.'/Driver/');
		self::includeRecurse($dir.'/Convert/');
	}
	
	private static function includeRecurse($dir)
	{
		$dir_content = scandir($dir, 1);
		foreach($dir_content as $file)
		{
			if(in_array($file, Array('.', '..')))
				continue;
			if(!is_file($dir.$file))
			{
				self::includeRecurse($dir.$file.'/');
				continue;
			}
			require_once $dir.$file;
		}
	}
	
}

?>
