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
class Action_Index extends Action_Base{
	public function get($request)
	{
		$path = $this->config['image_upload_dir'];
		$back_link = false;
		$current_dir = '';
		$add_path = '';
		$titlePath = '';
		if(isset($_GET['path']) && $this->isSafePath($_GET['path']))
		{
			$add_path = $_GET['path'];
			$current_dir = $add_path;
			$add_path = str_replace(Ciap_Reg::get('separator'), '/', $add_path);
			$path = $this->config['image_upload_dir'].'/'.$add_path;
			if(strlen($add_path) > 0)
			{
				$titlePath .= ' - ';
				$titlePath .= ($add_path[0] == '/')? $add_path: '/'.$add_path;
			}
			$back_link = $this->getBackLink($add_path);
		}
		$types = $this->config['allowed_mime_types'];
		$dir = Ciap_Tools::scanDir($path, $types, Config::getInstance()->show_dirs_in_filelist);
		$dir = $this->addThumbPath($dir, $add_path);

		$errors = false;
		if(Ciap_Reg::isRegistered('message_from_upload'))
		{
			$errors = Ciap_Reg::get('message_from_upload');
		}
		
		list($tree, $showTree) = (Config::getInstance()->show_tree)? $this->getTree($current_dir): Array('','');
		return Ciap::render('index', Array(
			'dir'=> $dir, 
			'back_link'=>$back_link, 
			'current_dir'=>$current_dir, 
			'navi' => (Config::getInstance()->show_breadcrumb)? $this->createNavi($current_dir) : '',
			'view_type' => $this->getViewType(),
			'errors' => $errors,
			'tree' => $tree,
			'showTree' => $showTree,
			'titlePath' => $titlePath,
				));
	}
	
	protected function getTree($current_dir)
	{
		$current_dir = $this->preparePath($current_dir);
		$tree = '<ul class="nav nav-list">';
		$treeArray = Ciap_Tools::getDirTree();
		if($current_dir == '' || $current_dir == '|')
			$tree .= '<li class="active">';
		else
			$tree .= '<li>';
		$tree .= "<a href='".Ciap_Url::create('index')."'>";
		$tree .= '&nbsp;<span class="icon-home"></span>';
		$tree .= Ciap_Lang::t('home')."</a>";
		$tree .= '</li><li class="divider"></li>';
		$tree .= $this->renderTree($treeArray, $current_dir).'</ul>';
		return Array($tree, empty($treeArray)? false: true);
	}
	
	protected function preparePath($path)
	{
		$path = trim($path);
		if($path == '')
			return '';
		$new_path = Array();
		$arr = explode(Ciap_Reg::get('separator'), $path);
		foreach($arr as $part)
		{
			$part = trim($part);
			if($part == '')
				continue;
			$new_path[] = $part;
		}
		$path = implode(Ciap_Reg::get('separator'), $new_path);
		if($path != '')
			$path = Ciap_Reg::get('separator').$path;
		return $path;
	}
	
	protected function renderTree($tree, $current_dir = '')
	{
		$html = '';
		foreach($tree as $entry)
		{
			$active = '';
			if($entry['code'] == $current_dir)
				$active = 'class="active"';
			$html .= '<li '.$active.'>';
			$html .= '<a href="'.$entry['url'].'">';
			$html .= '&nbsp;<span class="';
			$html .= (!empty($entry['childs']))? 'icon-folder-open' : 'icon-folder-close';
			$html .= '"></span>';
			$html .= $entry['name'];
			$html .= '</a></li>';
			if(!empty($entry['childs']))
			{
				$html .= '<li><ul class="nav nav-list">';
				$html .= $this->renderTree($entry['childs'], $current_dir);
				$html .= '</ul></li>';
			}
		}
		return $html;
	}
	
	public function createNavi($current_dir)
	{
		$array = explode(Ciap_Reg::get('separator'), $current_dir);
		$divder = empty($current_dir)? '' : '<span class="divider">/</span>';
		$html = '<li><a href="'.Ciap_Url::create('index', Array('path' => '')).'"><span class="icon-home"></span>'.Ciap_Lang::t('home').'</a>'.$divder.'</li>';
		if($current_dir == '')
			return $html;
		$link = '';
		$i = 0;
		$count = count($array);
		foreach($array as $dir)
		{
			$i++;
			if($dir == '')
				continue;
			$link .= $dir;
			$divder = ($i == $count)? '' : '<span class="divider">/</span>';
			if($i != $count)
				$html .='<li><a href="'.Ciap_Url::create('index', Array('path' => $link)).'">'.$dir.'</a>'.$divder.'</li>';
			else
				$html .='<li class="active">'.$dir.'</li>';
			$link .= Ciap_Reg::get('separator');
		}
		
		return $html;
			
	}
	
	protected function getBackLink($add_path)
	{
		$path = explode('/', $add_path);
		if(count($path) == 1 && $path[0] == '')
		{
			return false;
		}
		elseif(count($path) == 1 && $path[0] != '')
		{
			return '';
		}
		else
		{
			unset($path[count($path)-1]);
			return implode(Ciap_Reg::get('separator'), $path);
		}
	}
	
	protected function isSafePath($path)
	{
		return self::isPathSafe($path);
	}
	
	public static function isPathSafe($path)
	{
		return preg_match('/^[|a-zA-Z0-9_]*$/i', $path);
	}
	
	public function post($request)
	{
		
	}
	
}
?>