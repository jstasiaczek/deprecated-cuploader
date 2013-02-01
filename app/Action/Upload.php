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
class Action_Upload extends Action_Base{
	public function __construct() {
		parent::__construct();
		if(!Config_Secure::can_upload())
			Ciap::redirect (Ciap_Url::create('index')->buildUrl());
	}
	public function get($maches)
	{
		if(isset($_GET['action']) && $_GET['action'] == 'add_field' && isset($_GET['iter']))
		{
			return Ciap::render('upload_oneField', Array('field_postfix' => '_'.$_GET['iter']));
		}
		return Ciap::render('upload_many', Array('current_dir' => $_GET['path']));
	}
	
	public function post($maches)
	{
		$add_path = '';
		$return_to = '';
		$errors = Array();
		$warnings = Array();
		$success = Array();
		if(isset($_GET['back']))
		{
			$return_to = $_GET['back'];
			$add_path = str_replace(Ciap_Reg::get('separator'), '/', $_GET['back']);
		}
		
		$path_small = $this->config['thumb_dir'].'/'.$add_path;
		$path_big = $this->config['image_upload_dir'].'/'.$add_path;
		
		if(!is_dir($path_small))
			mkdir ($path_small, 0777, true);

		if(!empty($_FILES))
		{
			list($warnings, $errors, $success) = $this->handleUploads($path_big, $path_small, $warnings, $errors, $success);
		}
		
		if(empty($errors) && empty($warnings))
			Ciap::redirect(Ciap_Url::create('index', Array('path' => $return_to))->buildUrl());
		else
		{
			$_GET['path'] = $return_to;
			Ciap_Reg::set('message_from_upload', Array('errors' => $this->preprateArrayForJson($errors), 'warnings' => $this->preprateArrayForJson($warnings)));
			return Ciap::forward('Index');
		}
	}
	
	protected function handleUploads($path_big, $path_small, $warnings, $errors, $success)
	{
		foreach($_FILES as $file)
		{
			if($file['type'] == '' && $file['error'] == 0)
			{
				$file['type'] = Ciap_Image::getContentType($file['tmp_name']);
			}
			$file['name'] = Ciap_Tools::safeFileName($file['name']);
			if($file['error'] == 0 && in_array($file['type'], $this->config['allowed_mime_types']))
			{
				$new_name = $this->getCorrectName($path_big.'/', $file['name']);
				if($new_name != $file['name'])
				{
					$warnings[$file['name']] = Ciap_Lang::t('file_exists_warning').$new_name;
				}
				$file['name'] = $new_name;
				// mandatory thumbs
				Ciap_Image::convertFileAndSave($file['tmp_name'], $path_small.'/'.$file['name'], Ciap_Image_Convert_ResizeAndCutToBox::init(), Array('edge' => 75));
				Ciap_Image::convertFileAndSave($file['tmp_name'], $path_small.'/'.Ciap_Image::extendImageName($file['name'], '25'), Ciap_Image_Convert_ResizeAndCutToBox::init(), Array('edge' => 25));

				move_uploaded_file($file['tmp_name'], $path_big.'/'.$file['name']);
				$success[$file['name']] = Ciap_Tools::fixImagePath($path_big.'/'.$file['name']);
			}
			else
			{
				if(PhpUploadErrors::isError($file['error']))
					$errors[$file['name']] = PhpUploadErrors::getMessage($file['error']);
				elseif(PhpUploadErrors::UPLOAD_ERR_NO_FILE != $file['error'] && !in_array($file['type'], $this->config['allowed_mime_types']))
					$errors[$file['name']] = Ciap_Lang::t('error_type');
			}
		}
		return Array($warnings, $errors, $success);
	}
	
	protected function getCorrectName($path, $filename)
	{
		$i = 0;
		$base = $filename;
		while(file_exists($path.'/'.$filename))
		{
			$i++;
			$filename = Ciap_Image::extendImageName($base, '-'.$i);
		}
		return $filename;
	}
	
	
	protected function preprateArrayForJson(array $data)
	{
		$new_arr = Array();
		foreach($data as $name=>$message)
		{
			$new_arr[] = Array(
				'file' => $name,
				'message' => $message,
			);
		}
		return $new_arr;
	}
}
?>