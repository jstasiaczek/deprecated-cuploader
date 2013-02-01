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

require_once 'app/Ciap.php';

// init some important directory paths
Ciap::init(
		Array(
			'base_app_dir' => dirname(__FILE__).'/app/',
			'view_directory' => dirname(__FILE__).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR,
			'lang_directory' => dirname(__FILE__).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR,
			'entry_file_name' => basename(__FILE__),
));

// include required files
Ciap::importClasses(Array(
	'Ciap_Reg', 
	'Config',
	'Config_Secure_Base',
	'Config_Secure',
	'Ciap_Interface_AutoloadInit',
	'Ciap_View',
	'Ciap_Lang',
	'Ciap_Tools',
	'Ciap_Image',
	'Ciap_Url',
	'PhpUploadErrors',
	'Action_Base',
	'Action_Createthumb',
	'Action_Index',
	'Action_Folder',
	'Action_Options',
	'Action_Upload',
	'Action_UploadXHR',
	'Action_About',
));



Ciap_Image::preloadAllClasses();
$config_class = Config::getInstance('main.php');

// seciurity options
Config_Secure::init();


Ciap_Reg::set('config', Config_Secure::modify_settings($config_class));
Ciap_Reg::set('separator', '|');

if(!Config_Secure::can_access())
	die('You don\'t have permissions to access this plugin. ');


Ciap::stick(
		Array(
		'/[a-zA-Z0-9=\?&\.\+\-|_]*' => 'Action_Index',
		'/index' => 'Action_Index',
		'/about/[a-zA-Z0-9=\?&\.\+\-|_]*' => 'Action_About',
		'/index/[a-zA-Z0-9=\?&\.\+\-|_]*' => 'Action_Index',
		'/createthumb/[a-zA-Z0-9=\?&\.\+\-|_]*' => 'Action_Createthumb',
		'/upload/[a-zA-Z0-9=\?&\.\+\-|_]*' => 'Action_Upload',
		'/uploadXHR/[a-zA-Z0-9=\?&\.\+\-|_]*' => 'Action_UploadXHR',
		'/options[/]?[a-zA-Z0-9=\?&\.\+\-|_]*' => 'Action_Options',
		'/folder_actions/[a-zA-Z0-9=\?&\.\+\-|_]*' => 'Action_Folder',
		)
);



?>
