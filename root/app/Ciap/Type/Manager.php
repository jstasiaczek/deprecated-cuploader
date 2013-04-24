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
class Ciap_Type_Manager {
	protected static $instance = null;
	
	/**
	 * Return instance of type managers
	 * @param string $class
	 * @return Ciap_Type_Manager
	 */
	public static function getInstance($class = __CLASS__)
	{
		if(self::$instance != null)
			return self::$instance;
		self::$instance = new $class;
		return self::$instance;
	}
	
	/**
	 * 
	 * @param string $path
	 * @return Ciap_Type
	 */
	public function getTypeByFilename($path)
	{
		$pos = strrpos($path, '/');
		$dirPath = substr($path, 0, $pos+1);
		$fileName = substr($path, $pos+1);
		$cachedPath = $dirPath.'___cache/'.$fileName;
		if(file_exists($cachedPath))
			$mimeType = file_get_contents ($cachedPath);
		else
		{
			$mimeType = Ciap_Image::getContentType($path);
			@mkdir(Ciap_Tools::fixImagePath($dirPath.'/___cache/'), 0777, true);
			file_put_contents($cachedPath, $mimeType);
		}
		return $this->getTypeByMimetype($mimeType);
	}
	
	/**
	 * 
	 * @param string $mimeType
	 * @return Ciap_Type
	 */
	public function getTypeByMimetype($mimeType)
	{
		return Ciap_Type::getInstanceByMimeType($mimeType);
	}
}

?>
