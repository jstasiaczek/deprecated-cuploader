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


class Action_Createthumb extends Action_Base{
	public function __construct() {
		parent::__construct();
		if(!Config_Secure::can_upload())
			Ciap::redirect (Ciap_Url::create('index')->buildUrl());
	}
	public function get($maches)
	{
	}
	
	public function post($maches)
	{
		if(!isset($_POST['imageName']) || !isset($_POST['path_add']))
			return json_encode (Array('error' => 'Data incomplete!', 'success' => false, 'attributes' => ''));
		$fileName = $_POST['imageName'];
		$additionalPath = $_POST['path_add'];
		$normalImagePath = Ciap_Tools::fixImagePath(Config::getInstance()->image_upload_dir.'/'.$additionalPath.'/'.$fileName);
		$typeHandler = Ciap_Type_Manager::getInstance()->getTypeByFilename($normalImagePath);
		if(empty($typeHandler))
			return json_encode (Array('error' => 'Incorrect type!', 'success' => false, 'attributes' => ''));
		return $typeHandler->createAdditionalFile($normalImagePath, $fileName, $additionalPath);
	}
}

?>