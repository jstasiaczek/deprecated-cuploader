<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Image
 *
 * @author jstasiac
 */
class Type_Image extends Ciap_Type implements Ciap_Interface_AutoloadInit{
	protected function __construct($class) {
		parent::__construct($class);
		$this->mimeTypes = Array('image/jpeg', 'image/pjpeg','image/png','image/gif', 'image/x-png');
	}
	
	public static function moduleInit() {
		Ciap_Script::getInstance()->registerScript('type.image', '/public/js/type/image.js');
	}
	
	public function afterUpload(array $fileArray, $destinationDir, $thumbnailDir) 
	{
		Ciap_Image::convertFileAndSave($fileArray['tmp_name'], $thumbnailDir.'/'.$fileArray['name'], 
																				Ciap_Image_Convert_ResizeAndCutToBox::init(), Array('edge' => 75));
		Ciap_Image::convertFileAndSave($fileArray['tmp_name'], $thumbnailDir.'/'.Ciap_Image::extendImageName($fileArray['name'], '25'), 
																				Ciap_Image_Convert_ResizeAndCutToBox::init(), Array('edge' => 25));
		$fileArray['type'] = get_class();
		return $fileArray;
	}
	
	public function prepareGridData($path, $fileName, $additionalPath) {
		$data = parent::prepareGridData($path, $fileName, $additionalPath);
		$data['thumb'] = Ciap_Tools::fixImagePath(Config::getInstance()->thumb_url.'/'.$additionalPath.'/'.$fileName);
		$data['name'] = $fileName;
		return $data;
	}
	
	public function prepareListData($path, $fileName, $additionalPath) {
		$data = parent::prepareListData($path, $fileName, $additionalPath);
		$sizes = getimagesize($path.'/'.$fileName);
		$data['thumb'] = Ciap_Tools::fixImagePath(Ciap_Image::extendImageName(Config::getInstance()->thumb_url.'/'.$additionalPath.'/'.$fileName, '25'));
		$data['informations'] = $sizes[0].'<strong>x</strong>'.$sizes[1].' px';
		$data['name'] = $fileName;
		return $data;
	}
	
	public function prepareOptionsDialogInfo($path, $fileName, $additionalPath) {
		$array = parent::prepareOptionsDialogInfo($path, $fileName, $additionalPath);
		$array = $this->prepareListData($path, $fileName, $additionalPath);
		$array['thumb'] = Ciap_Tools::fixImagePath(Config::getInstance()->thumb_url.'/'.$additionalPath.'/'.$fileName);
		return $array;
	}
	
	public function renderOptions($path, $fileName, $additionalPath) {
		$data = Array();
		$data['thumb_sizes'] = $this->config['thumb_create'];
		$data['thumb'] = Ciap_Tools::fixImagePath(Config::getInstance()->thumb_url.'/'.$additionalPath.'/'.$fileName);
		$sizes = getimagesize(Config::getInstance()->thumb_dir.'/'.$additionalPath.'/'.$fileName);
		$data['thumb_sizes_string'] = "'$sizes[0]', '$sizes[1]', 'width: $sizes[0]; height:$sizes[1]'";
		$sizes = getimagesize(Config::getInstance()->image_upload_dir.'/'.$additionalPath.'/'.$fileName);
		$data['original_sizes_string'] = "'$sizes[0]', '$sizes[1]', 'width: $sizes[0]; height:$sizes[1]'";
		$data['original'] = Config::getInstance()->image_upload_url.'/'.$additionalPath.'/'.$fileName;
		$data['fileName'] = $fileName;
		$data['relativePath'] = $additionalPath;
		return Ciap_View::getHtml('type/image.options', $data);
	}
	
	public function createAdditionalFile($path, $fileName, $additionalPath) {
		$thumb_id = (int)$_POST['thumb_id'];
		if(!isset($this->config['thumb_create'][$thumb_id]))
			return json_encode (Array('error' => 'This thumb do not exisits!', 'success' => false, 'attributes' => ''));
		
		// init some paths and urls
		$config = Config::getInstance();
		$thumbnailPath = Ciap_Tools::fixImagePath($config->thumb_dir.'/'.$additionalPath);
		$extendedFileName = Ciap_Image::extendImageName($fileName, '_'.$this->config['thumb_create'][$thumb_id]['output_file_name_postfix']);
		$thumbnailImagePath = Ciap_Tools::fixImagePath($thumbnailPath.'/'.$extendedFileName);
		$thumbnailImageUrl = Ciap_Tools::fixImagePath($config->thumb_url.$_POST['path_add'].$extendedFileName);
		
		
		// check if file exists
		if(file_exists($thumbnailImagePath))
			return json_encode (Array('good' => 'File already exsist!', 'success' => true, 'url' => Ciap_Tools::fixImagePath ($thumbnailImageUrl), 'attributes' => explode(',',Ciap_Tools::getImageWithHeightAttributes($thumbnailImagePath, true))));
		if(!file_exists($path))
			return json_encode (Array('error' => 'No file to convert!', 'success' => false, 'attributes' => ''));
		
		// create thumbnail dir
		if(!is_dir(dirname($thumbnailPath)))
			mkdir(dirname($thumbnailPath), 0777, true);
		
		// create thumbnail 
		try{
			$image = Ciap_Image::create($path);
			foreach($this->config['thumb_create'][$thumb_id]['chain'] as $part)
			{
				$image->convert($part['class'], $part['options']);
			}
			$image->save($thumbnailImagePath);
		}catch(Exception $e)
		{
			
		}
		return json_encode (Array('good' => 'Converted!', 'success' => true, 'url' => Ciap_Tools::fixImagePath ($thumbnailImageUrl), 'attributes' => explode(',',Ciap_Tools::getImageWithHeightAttributes($thumbnailImagePath, true))));
	}
	
	public function getFilesToDelete($path, $fileName, $additionalPath) {
		$config = Config::getInstance();
		$array = parent::getFilesToDelete($additionalPath, $fileName, $additionalPath);
		$array[] =$config['thumb_dir'].$additionalPath.$fileName;
		$array[] =$config['thumb_dir'].$additionalPath.  Ciap_Image::extendImageName($fileName, '25');

		if(is_array($this->config['thumb_create']))
		{
			foreach($this->config['thumb_create'] as $thumb)
			{
				$array[] =Ciap_Image::extendImageName($config['thumb_dir'].$additionalPath.$fileName, '_'.$thumb['output_file_name_postfix']);
			}
		}
		return $array;
	}
}

?>
