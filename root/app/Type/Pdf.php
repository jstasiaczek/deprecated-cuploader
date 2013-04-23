<?php

class Type_Pdf extends Ciap_Type implements Ciap_Interface_AutoloadInit{
	protected $icons = Array();
	protected function __construct($class) {
		parent::__construct($class);
		$this->mimeTypes = Array('application/pdf', 'application/x-pdf');
		$this->icons = Array(
				'25' => Ciap::$baseUrlNoFile.'public/img/pdf25.png',
				'48' => Ciap::$baseUrlNoFile.'public/img/pdf48.png'
		);
	}
	
	public static function moduleInit() {
		Ciap_Script::getInstance()->registerScript('type.file', '/public/js/type/file.js');
	}
	
	public function afterUpload(array $fileArray, $destinationDir, $thumbnailDir) {
		return $fileArray;
	}
	
	public function prepareGridData($path, $fileName, $additionalPath) {
		$array = parent::prepareGridData($path, $fileName, $additionalPath);
		$array['thumb'] = $this->icons['48'];
		$array['name'] = $fileName;
		return $array;
	}
	
	public function prepareListData($path, $fileName, $additionalPath) {
		$array = $this->prepareGridData($path, $fileName, $additionalPath);
		$array['thumb'] = $this->icons['25'];
		$array['informations'] = '&nbsp;';
		return $array;
	}
	
	public function prepareOptionsDialogInfo($path, $fileName, $additionalPath) {
		$data = $this->prepareListData($path, $fileName, $additionalPath);
		$data['thumb'] = $this->icons['48'];
		$data['informations'] = Ciap_Lang::t('size');
		return $data;
	}
	
	public function renderOptions($path, $fileName, $additionalPath) {
		$data = Array();
		$config = Config::getInstance();
		$data['fileName'] = $fileName;
		$data['fileUrl'] = Ciap_Tools::fixImagePath($config->image_upload_url.'/'.$additionalPath.'/'.$fileName);
		return Ciap_View::getHtml('type/pdf.options', $data);
	}
}

?>
