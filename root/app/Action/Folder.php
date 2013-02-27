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
class Action_Folder extends Action_Base{
	public function post($maches)
	{
		if(isset($_POST['action']))
			return $this->doAction();
		$can_do = Array(
			'create_new' => true,
			'edit' => false,
			'delete' => false,
		);
		$path = '';
		if(isset($_POST['path']))
			$path = $_POST['path'];
		
		if(Action_Index::isPathSafe($path))
		{
			$can_do = $this->getCanDo($path, $can_do);
		}
		$arr = $this->clearEmpty(explode(Ciap_Reg::get('separator'), $path));
		$dir = '';
		$back = '';
		if(!empty($arr))
		{
			$dir = $arr[count($arr)-1];
			$back = $arr;
			unset($back[count($back)-1]);
			$back = implode(Ciap_Reg::get('separator'), $back);
		}
		$can_do_something = false;
		foreach($can_do as $can)
		{
			$can_do_something = $can? true : $can_do_something;
		}
		return Ciap::render('folder_actions', Array('can' => $can_do, 'can_do_something' => $can_do_something, 'dir' => $dir, 'current_dir' => $path, 'back' => $back));
	}
	
	protected function doAction()
	{
		if($_POST['action'] == 'delete' && isset($_POST['path']) && isset($_POST['back']) && Config_Secure::can_delete_dir())
		{
			$path = implode('/', $this->clearEmpty(explode(Ciap_Reg::get('separator'), $_POST['path'])));
			@rmdir($this->config['image_upload_dir'].'/'.$path);
			@rmdir($this->config['thumb_dir'].'/'.$path);
			Ciap::redirect(Ciap_Url::create('index', Array('path' => $_POST['back']))->buildUrl());
		}
		if($_POST['action'] == 'rename' && isset($_POST['back']) && isset($_POST['current']) && isset($_POST['new']) && Config_Secure::can_rename_dir())
		{
			$path = implode('/', $this->clearEmpty(explode(Ciap_Reg::get('separator'), $_POST['back'])));
			rename($this->config['image_upload_dir'].'/'.$path.'/'.$_POST['current'], $this->config['image_upload_dir'].'/'.$path.'/'.$_POST['new']);
			rename($this->config['thumb_dir'].'/'.$path.'/'.$_POST['current'], $this->config['thumb_dir'].'/'.$path.'/'.$_POST['new']);
			Ciap::redirect(Ciap_Url::create('index', Array('path' => $_POST['back'].Ciap_Reg::get('separator').$_POST['new']))->buildUrl());
		}
		
		
		if($_POST['action'] == 'add' && isset($_POST['path']) && isset($_POST['new']) && Config_Secure::can_create_dir())
		{
			$path = implode('/', $this->clearEmpty(explode(Ciap_Reg::get('separator'), $_POST['path'])));
			$path .= '/'.$_POST['new'];
			@mkdir($this->config['image_upload_dir'].'/'.$path);
			@mkdir($this->config['thumb_dir'].'/'.$path);
			Ciap::redirect(Ciap_Url::create('index', Array('path' => str_replace('/', Ciap_Reg::get('separator'), $path)))->buildUrl());
		}
		
		Ciap::redirect(Ciap_Url::create('index')->buildUrl());
	}
	
	protected function getCanDo($path, $can_do)
	{
		// if it is main dir we can only create new dir
		if($path == '' || $path == Ciap_Reg::get('separator'))
		{
			return Array(
				'create_new' => Config_Secure::can_create_dir(),
				'edit' => false,
				'delete' => false,
			);
		}
		$path_arr = $this->clearEmpty(explode(Ciap_Reg::get('separator'), $path));
		$ret = Array(
			'create_new' => Config_Secure::can_create_dir(),
			'edit' => false,
			'delete' => false,
		);
		if(empty($path_arr))
		{
			return $ret;
		}
		$ret['edit'] = Config_Secure::can_rename_dir();
		// if we have some file in dir we can't remove dir or rename
		$files = @scandir($this->config['image_upload_dir'].'/'.implode('/',$path_arr));
		if(count($files) > 2)
		{
			return $ret;
		}
		$ret['delete'] = Config_Secure::can_delete_dir();
		return $ret;
	}
	
	protected function clearEmpty($array)
	{
		foreach($array as $key=>$val)
		{
			if($val == '' || empty($val))
				unset($array[$key]);
		}
		// array merge to clear array ids
		return array_merge($array, Array());
	}
}
?>