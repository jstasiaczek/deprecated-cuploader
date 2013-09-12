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

// init some important directory paths
Ciap::init(
		Array(
			'base_app_dir' => ROOT_DIR.'/app/',
			'view_directory' => ROOT_DIR.'/app/views/',
			'lang_directory' => ROOT_DIR.'/app/lang/',
			'entry_file_name' => ROOT_FILE,
));

// include required files
Ciap::importClasses(Array(
	'Ciap_Reg', 
	'Config',
	'Config_Secure_Base',
	'Config_Secure',
	'Ciap_Interface_AutoloadInit',
	'Ciap_Script',
	'Ciap_View',
	'Ciap_Lang',
	'Ciap_Tools',
	'Ciap_Image',
	'Ciap_Url',
	'Ciap_Target',
	'Target_Tinymce',
	'Target_Tinymce4',
	'Target_Ckeditor',
	'Target_Popup',
	'Ciap_Type',
	'Ciap_Type_Manager',
	'Type_Image',
	'Type_Pdf',
	'Type_Text',
	'Type_Html',
	'Ciap_Target_Autoloader', // this class should be loaded after all targets
	'PhpUploadErrors',
	'Action_Base',
	'Action_Createthumb',
	'Action_Index',
	'Action_Folder',
	'Action_Options',
	'Action_Upload',
	'Action_UploadXHR',
	'Action_About',
	'Version',
));



Ciap_Image::preloadAllClasses();
$config_class = Config::getInstance('main.php');

// seciurity options
Config_Secure::init();


Ciap_Reg::set('config', Config_Secure::modify_settings($config_class));
Ciap_Reg::set('separator', '|');

if(!Config_Secure::can_access())
	die('You don\'t have permissions to access this plugin. ');


Ciap::registerRoutes(
		Array(
		'/[a-zA-Z0-9=\?&\.\+\-|_]*' => 'Action_Index',
		'/index/[a-zA-Z0-9=\?&\.\+\-|_]*' => 'Action_Index',
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
