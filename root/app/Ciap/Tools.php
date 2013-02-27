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
class Ciap_Tools{
	
	/**
	 * Return safe for filesystem file name
	 * @param string $string
	 * @param bool $force_lowercase
	 * @param bool $anal
	 * @param bool $omit_extension
	 * @return string
	 */
	public static function safeFileName($string, $force_lowercase = true, $anal = true, $omit_extension = false)
	{
		$orginal_name = $string;
		$extension = '';
		if(strrpos($string, '.') !== false)
		{
			$string = substr($orginal_name, 0, strrpos($orginal_name, '.'));
			$extension = substr($orginal_name, strrpos($orginal_name, '.'));
		}
		$strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                   "â€”", "â€“", ",", "<", ".", ">", "/", "?");
		$clean = trim(str_replace($strip, "", strip_tags($string)));
		$clean = preg_replace('/\s+/', "-", $clean);
		$clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
		$ret = ($force_lowercase) ?
			(function_exists('mb_strtolower')) ?
				mb_strtolower($clean, 'UTF-8') :
				strtolower($clean) :
			$clean;
		if($omit_extension)
			return $ret;
		else
			return $ret.$extension;
	}
	
	/**
	 * return formated size of give file
	 * @param string $a_bytes
	 * @return string
	 */
	static public function formatSize($a_bytes) 
	{
		$a_bytes = filesize($a_bytes);
		if ($a_bytes < 1024) {
			return $a_bytes . ' B';
		} elseif ($a_bytes < 1048576) {
			return round($a_bytes / 1024, 2) . ' KB';
		} elseif ($a_bytes < 1073741824) {
			return round($a_bytes / 1048576, 2) . ' MB';
		} elseif ($a_bytes < 1099511627776) {
			return round($a_bytes / 1073741824, 2) . ' GB';
		} elseif ($a_bytes < 1125899906842624) {
			return round($a_bytes / 1099511627776, 2) . ' TB';
		}
	}
	
	public static function fixImagePath($path)
	{
		$path = str_replace('///', '/', $path);
		$path = str_replace('//', '/', $path);
		return $path;
	}
	
	/**
	 * Return width and height of image
	 * @param string $path
	 * @param bool $plain
	 * @return string
	 */
	public static function getImageWithHeightAttributes($path, $plain = false)
	{
		if(!file_exists($path))
		{
			if($plain)
				return '';
			return "''";
		}
		$ret = getimagesize($path);
		if($plain)
			return $ret[0].",".$ret[1];
		return "'".$ret[0]."','".$ret[1]."'";
	}
	
	public static function getDirTree()
	{
		$dir = Config::getInstance()->image_upload_dir;
		$data = scandir($dir);
		return self::getDirTreeInternal($dir, $data);
	}
	
	protected static function getDirTreeInternal($base_dir, $data, $current_dir = '')
	{
		$tree = Array();
		foreach($data as $dir)
		{
			if(in_array($dir, Array('.', '..')))
				continue;
			if(!is_dir($base_dir.'/'.$dir))
				continue;
			$tree[] = Array(
				'name' => $dir,
				'path' => $base_dir.'/'.$dir,
				'code' => $current_dir.Ciap_Reg::get('separator').$dir,
				'url' => Ciap_Url::create('index', Array('path' => $current_dir.Ciap_Reg::get('separator').$dir))->buildUrl(),
				'childs' => self::getDirTreeInternal($base_dir.'/'.$dir, scandir($base_dir.'/'.$dir),$current_dir.Ciap_Reg::get('separator').$dir),
			);
		}
		return $tree;
	}
	
	/**
	 * Scan dir
	 * @param string $path
	 * @param array $allowed_types
	 * @param array $include_folders
	 * @return array
	 */
	public static function scanDir($path, $allowed_types = Array(), $include_folders = true)
	{
		if(!is_dir($path))
			return Array();
		$data = scandir(self::fixImagePath($path));
		$new_data = Array();
		$new_data_dir = Array();
		foreach($data as $file)
		{
			if(in_array($file, Array('.','..')))
				continue;
			if(is_dir($path.DIRECTORY_SEPARATOR.$file))
			{
				if(!$include_folders)
					continue;
				if($file[0] == '.')
					continue;
				$new_data_dir[] = Array(
					'name' => $file,
					'path' => $path.DIRECTORY_SEPARATOR.$file,
					'type' => 'dir'
				);
				continue;
			}
			
			$file_type = Ciap_Image::getContentType($path.DIRECTORY_SEPARATOR.$file);
			
			if(empty($allowed_types) || !in_array($file_type, $allowed_types))
				continue;
			
			$new_data[] = Array(
				'name' => $file,
				'path' => $path.DIRECTORY_SEPARATOR.$file,
				'type' => 'file'
			);
			
		}
		return array_merge($new_data_dir,$new_data);
	}
	
	/**
	 * Short too long filenames.
	 * @param string $string
	 * @param int $lenght
	 * @param string $postfix
	 * @param string $encoding
	 * @return string
	 */
	public static function shortString($string, $lenght = 10, $postfix = '...', $encoding = 'UTF-8')
	{
		$len = mb_strlen($string, $encoding);
		if($len <= $lenght)
			return $string;
		
		$string = mb_substr($string, 0, $lenght, $encoding);
		
		return $string.$postfix;
	}
	
	public static function createDirLink($current_dir, $next_dir)
	{
		if(empty($current_dir) || $current_dir == '/')
			return $next_dir;
		return $current_dir.Ciap_Reg::get('separator').$next_dir;
	}
}

?>
