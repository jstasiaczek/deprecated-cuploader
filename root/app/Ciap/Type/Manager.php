<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Manager
 *
 * @author Administrator
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
			@mkdir($dirPath.'___cache/');
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
