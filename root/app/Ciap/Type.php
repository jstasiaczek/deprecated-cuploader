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
abstract class Ciap_Type {
	protected static $instance = Array();
	protected $mimeTypes = Array();
	protected $config = Array();
	protected $class = null;
	/**
	 * 
	 * @param string $class
	 * @return Ciap_Type
	 */
	public static function getInstance($class = __CLASS__)
	{
		if(isset(self::$instance[$class]))
			return self::$instance[$class];
		self::$instance[$class] = new $class($class);
		return self::$instance[$class];
	}
	
	protected function __construct($class) {
		$this->class = $class;
		$this->config = Config::getInstance()->types[$class];
	}
	
	/**
	 * Trying to find suitable Ciap_Type class for given mime-type
	 * @param string $mimeType
	 * @param string $class
	 * @return Ciap_Type|null
	 */
	public static function getInstanceByMimeType($mimeType, $class = __CLASS__)
	{
		$types = array_keys(Config::getInstance()->types);
		foreach($types as $type)
		{
			$instance = self::getInstance($type);
			if($instance->isAllowedMimeType($mimeType))
				return $instance;
		}
		return null;
	}
	
	
	/**
	 * Return array of allowed mimetypes
	 * @return array
	 */
	public function getAllowedMimeTypes()
	{
		return $this->mimeTypes;
	}
	
	/**
	 * Check if mime type is allowed for this handler
	 * @param string $mimeType
	 * @return bool
	 */
	public function isAllowedMimeType($mimeType)
	{
		return in_array($mimeType, $this->getAllowedMimeTypes());
	}
	
	/**
	 * Execute actions after file upload
	 * @param array $fileArray
	 * @param string $destinationDir
	 * @param string $thumbnailDir
	 */
	abstract public function afterUpload(array $fileArray, $destinationDir, $thumbnailDir);
	
	/**
	 * Prepare data array informations part of options dialog
	 * @param string $path
	 * @param string $fileName
	 * @param string $additionalPath
	 * @return array
	 */
	public function prepareOptionsDialogInfo($path, $fileName, $additionalPath){
		return Array();
	}
	
	/**
	 * Renders and return options html part.
	 * @param string $path
	 * @param string $fileName
	 * @param string $additionalPath
	 */
	public function renderOptions($path, $fileName, $additionalPath){}
	
	public function insert($path, $fileName, $additionalPath){}
	/**
	 * This action is executed by ajax call and is used to create additional files before insert
	 * @param string $path
	 * @param string $filename
	 * @param string $additionalPath
	 * @return string encoded json object
	 */
	public function createAdditionalFile($path, $filename, $additionalPath){}
	/**
	 * Return array of files that should be deleted
	 * @param string $path
	 * @param string $fileName
	 * @param string $additionalPath
	 * @return array list of files to delete
	 */
	public function getFilesToDelete($path, $fileName, $additionalPath){
		return Array();
	}
	/**
	 * Prepare data for list view 
	 * @param string $path
	 * @param string $fileName
	 * @param string $additionalPath
	 * @return array
	 */
	public function prepareListData($path, $fileName, $additionalPath){
		return Array(
			'size' => Ciap_Tools::formatSize($path.'/'.$fileName),
			'req' => $additionalPath.'/'.$fileName,
		);
	}
	/**
	 * Preprare data for grid view
	 * @param string $path
	 * @param string $fileName
	 * @param string $additionalPath
	 * @return array
	 */
	public function prepareGridData($path, $fileName, $additionalPath){
		return Array(
			'size' => Ciap_Tools::formatSize($path.'/'.$fileName),
			'req' => $additionalPath.'/'.$fileName,
		);
	}
	
}

?>
