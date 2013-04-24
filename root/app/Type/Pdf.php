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
	
	protected function getRenderOptions($path, $fileName, $additionalPath)
	{
		
		$data = Array();
		$config = Config::getInstance();
		$data['fileName'] = $fileName;
		$data['fileUrl'] = Ciap_Tools::fixImagePath($config->image_upload_url.'/'.$additionalPath.'/'.$fileName);
		return $data;
	}
	
	public function renderOptions($path, $fileName, $additionalPath) {
		$data = $this->getRenderOptions($path, $fileName, $additionalPath);
		return Ciap_View::getHtml('type/pdf.options', $data);
	}
}

?>
