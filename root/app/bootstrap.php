<?php
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
	'Target_Popup',
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
