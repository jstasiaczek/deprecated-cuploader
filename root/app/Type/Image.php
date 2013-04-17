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
}

?>
