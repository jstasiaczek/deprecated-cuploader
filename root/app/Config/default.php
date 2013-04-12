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

return Array(
	// orginal size upload dir and url 
	'image_upload_dir' => '',
	'image_upload_url' => '',
	// thumbnail dir
	'thumb_dir' => '',
	'thumb_url' => '',
	'show_breadcrumb' => false,
	'target' => 'Ciap_Target',
	'show_tree' => true,
	'show_dirs_in_filelist' => false,
	// allowed image mimetypes
	'allowed_mime_types' => Array('image/jpeg', 'image/pjpeg','image/png','image/gif', 'image/x-png'),
	// default view of directory grid/list
	'default_directory_view' => 'list',
	'skip_xhr_upload' => false,
	// registred types
	'types' => Array(
		'Type_Image'=> Array(),
	),
	// browser always create 
	'thumb_create' => Array(),
	'register_scripts' => Array(
		'link' => Array(
			'cuploader' => Array('href'=>'public/css/uploader.css', 'rel' => 'stylesheet'),
			'cuploader-ie' => Array('href' => 'public/js/uploader-ie.css', 'type' => 'text/javascript', '_condition_comment' => 'IE'),
			'bootstrap' => Array('href'=>'public/css/bootstrap.min.css', 'rel' => 'stylesheet'),
		),
		'script' => Array(
			'jquery' => Array('src' => 'public/js/jquery.js', 'type' => 'text/javascript'),
			'cuploader' => Array('src' => 'public/js/uploader.js', 'type' => 'text/javascript'),
			'bootstrap' => Array('src' => 'public/js/bootstrap.min.js', 'type' => 'text/javascript'),
		),
	)
);
?>
