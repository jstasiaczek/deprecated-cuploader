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
class Action_Options extends Action_Base{
	public function post($maches)
	{
		$file = '';
		$path = '/';
		if(isset($_POST['file']))
			$file = $_POST['file'];
		if(isset($_POST['path']))
			$path = $_POST['path'];
		if(isset($_POST['action']) && $_POST['action'] == 'delete' && Config_Secure::can_delete_file())
		{
			$this->deleteFile();
		}
		
		$thumb_size = ($this->config['thumb_create'])? $this->config['thumb_create'] : Array();
		
		return Ciap::render('options', Array( 
							'orginal' => Ciap_Tools::fixImagePath($this->config['image_upload_url'].$path.$file), 
							'orginal_dir' => $this->config['image_upload_dir'].$path.$file, 
							'thumb' => Ciap_Tools::fixImagePath($this->config['thumb_url'].'/'.$path.$file), 
							'thumb_dir' => $this->config['thumb_dir'].'/'.$path.$file, 
							'thumb_path' => Ciap_Tools::fixImagePath($this->config['thumb_url'].$path.'/'),
							'image_size' => getimagesize($this->config['image_upload_dir'].$path.$file),
							'file_size' => Ciap_Tools::formatSize($this->config['image_upload_dir'].$path.$file),
							'filename' => $file, 
							'path'=> $path,
							'back'=> str_replace('/', Ciap_Reg::get('separator'), $path),
							'thumb_sizes' => $thumb_size,
							));
	}
	
	protected function deleteFile()
	{
		$path = '/'.$_POST['back'];
		$file = $_POST['file'];
		
		$this->deleteSingleFile($this->config['image_upload_dir'].$path.$file);
		$this->deleteSingleFile($this->config['thumb_dir'].$path.$file);
		$this->deleteSingleFile($this->config['thumb_dir'].$path.  Ciap_Image::extendImageName($file, '25'));
		
		if(is_array($this->config['thumb_create']))
		{
			foreach($this->config['thumb_create'] as $thumb)
			{
				$this->deleteSingleFile(  Ciap_Image::extendImageName($this->config['thumb_dir'].$path.$file, '_'.$thumb['output_file_name_postfix']));
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