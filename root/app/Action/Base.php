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
class Action_Base{
	protected $allowed_view_types = Array('list', 'grid');
	/**
	 * Configuration array
	 * @var array 
	 */
	protected $config = Array();
	
	public function __construct() {
		$this->config = Ciap_Reg::get('config', Array());
		
		// set language
		if(isset($_REQUEST['lang']))
		{
			Ciap_Lang::setLang($_REQUEST['lang']);
			Ciap_Url::setLang($_REQUEST['lang']);
		}
		else
		{
			Ciap_Lang::setLang('en');
			Ciap_Url::setLang('en');
		}
		// set view type
		if(isset($_REQUEST['type']))
		{
			Ciap_Reg::set('type', $_REQUEST['type']);
			Ciap_Url::setType($_REQUEST['type']);
		}
		else
		{
			Ciap_Reg::set('type', $this->config['default_directory_view']);
			Ciap_Url::setType($this->config['default_directory_view']);
		}
	}
	
	/**
	 * Return correct view type basing on current params
	 * @return string
	 */
	public function getViewType()
	{
		$type = Ciap_Reg::get('type', $this->config['default_directory_view']);
		if(!in_array($type, $this->allowed_view_types))
			$type = $this->config['default_directory_view'];
		return 'view_'.$type;
	}
	
	/**
	 * Adds data required for displaying list of images
	 * @param array $dir
	 * @param string $add_path
	 * @return array
	 */
	protected function addThumbPath($dir, $add_path)
	{
		foreach($dir as $key=>$file)
		{
			$path_small = $this->config['thumb_url'].'/'.$add_path;
			$path_full = $this->config['image_upload_dir'].'/'.$add_path;
			if($file['type'] == 'file')
			{
				$dir[$key]['thumb'] = Ciap_Tools::fixImagePath($path_small.'/'.$file['name']);
				$dir[$key]['req'] = $add_path.'/'.$file['name'];
				$dir[$key]['sizes'] = getimagesize($path_full.'/'.$file['name']);
				$dir[$key]['size'] = Ciap_Tools::formatSize($path_full.'/'.$file['name']);
			}
		}
		return $dir;
	}
	
	public function post($request)
	{
	}
	
	public function get($request)
	{
	}
}
?>