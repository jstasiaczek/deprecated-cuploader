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
class Action_Options extends Action_Base{
	public function post($maches)
	{
		$fileName = '';
		$additionalPath = '/';
		if(isset($_POST['file']))
			$fileName = $_POST['file'];
		if(isset($_POST['path']))
			$additionalPath = $_POST['path'];
		if(isset($_POST['action']) && $_POST['action'] == 'delete' && Config_Secure::can_delete_file())
		{
			$this->deleteFile();
		}
		$normalImagePath = $this->config['image_upload_dir'].$additionalPath.$fileName;
		$data = Ciap_Type_Manager::getInstance()->getTypeByFilename($normalImagePath)
								->prepareOptionsDialogInfo($this->config['image_upload_dir'].$additionalPath, $fileName, $additionalPath);
				
		return Ciap::render('options', Array(
							'filename' => $fileName, 
							'path'=> $additionalPath,
							'normalPath' => $this->config['image_upload_dir'].$additionalPath,
							'data'=> $data,
							));
	}
	
	protected function deleteFile()
	{
		$additionalPath = '/'.$_POST['back'];
		if(is_array($_POST['file']))
			$files = $_POST['file'];
		else
			$files = Array($_POST['file']);
		
		foreach($files as $fileName)
		{
			$normalFilePath = $this->config['image_upload_dir'].$additionalPath.$fileName;
			$metaCachedFile = $this->config['image_upload_dir'].$additionalPath.'/___cache/'.$fileName;
			$typeHandler = Ciap_Type_Manager::getInstance()->getTypeByFilename($normalFilePath);
			$filesToDelete = array_merge(Array($normalFilePath, $metaCachedFile), 
											$typeHandler->getFilesToDelete($normalFilePath, $fileName, $additionalPath));
			foreach($filesToDelete as $fileToDelete)
			{
				$this->deleteSingleFile($fileToDelete);
			}
		}
		Ciap::redirect(Ciap_Url::create('index', Array('path' => str_replace('/', Ciap_Reg::get('separator'), $_POST['back'])))->buildUrl());
	}
	
	protected function deleteSingleFile($path)
	{
		if(file_exists($path))
			unlink($path);
	}
}

?>