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


// no limit for time execution
set_time_limit(0);
require_once '../app/Ciap.php';

// init some important directory paths
Ciap::init(
		Array(
			'base_app_dir' => dirname(dirname(__FILE__)).'/app/',
			'view_directory' => dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR,
			'lang_directory' => dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR,
			'entry_file_name' => basename(__FILE__),
), true);

// include required files
Ciap::importClasses(Array(
	'Ciap_Reg', 
	'Config_Secure',
	'Ciap_View',
	'Ciap_Cookie',
	'Ciap_Lang',
	'Ciap_Tools',
	'Ciap_Image',
	'PhpUploadErrors',
	'Action_Base',
	'Action_Index',
	'Action_Folder',
	'Action_Options',
	'Action_Upload',
));

Ciap_Image::preloadAllClasses();

Ciap_Reg::set('config', include ('../app/Config/main.php'));

$config = Ciap_Reg::get('config');
$upload_dir = $config['image_upload_dir'];
$thumbs_dir = $config['thumb_dir'];

$smallonly = false;
if((isset($argv[1]) && $argv[1] == 'smallonly') || (isset($_GET['ac']) && $_GET['ac'] == 'smallonly'))
	$smallonly = true;
	
function createThumbs($path, $thumb_path, $smallonly = false)
{
	$files = Ciap_Tools::scanDir($path);
	foreach($files as $row)
	{
		if($row['type'] == 'file')
		{
			if(!is_dir($thumb_path))
				mkdir($thumb_path, 0777, true);
			echo 'Processing file '.$row['name'].'...<br />'."\n";
			Ciap_Image::convertFileAndSave($path.$row['name'], $thumb_path.$row['name'], Ciap_Image_Convert_ResizeAndCutToBox::init(), Array('edge' => 75));
			Ciap_Image::convertFileAndSave($path.$row['name'], $thumb_path.Ciap_Image::extendImageName($row['name'], 25), Ciap_Image_Convert_ResizeAndCutToBox::init(), Array('edge' => 25));
			if($smallonly)
			{
				continue;
			}
			createConfigThumbs($path, $thumb_path, $row['name']);
		}
		else
		{
			createThumbs($path.$row['name'].'/', $thumb_path.$row['name'].'/', $smallonly);
		}
	}
}

function createConfigThumbs($path, $thumb_path, $name)
	{
		global $config;
		$array = $config['thumb_create'];
		foreach($array as $thumb)
		{
			try
			{
				$image = Ciap_Image::create($path.$name);
				foreach($thumb['chain'] as $part)
				{
					$image->convert($part['class'], $part['options']);
				}
				$image->save(Ciap_Image::extendImageName($thumb_path.$name, '_'.$thumb['output_file_name_postfix']));
			}
			catch(Exception $e)
			{
				
			}
		}
	}

createThumbs($upload_dir, $thumbs_dir, $smallonly);
?>
