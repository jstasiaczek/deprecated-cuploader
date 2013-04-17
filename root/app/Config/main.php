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
	'image_upload_dir' => 'c:/wamp/www/_u/org/',
	'image_upload_url' => '/_u/org/',
	// thumbnail dir
	'thumb_dir' => 'c:/wamp/www/_u/thumbs/',
	'thumb_url' => '/_u/thumbs/',
	'types' => Array(
		'Type_Image' => Array(
			'thumb_create' => Array(
						// Convert configuration
						Array(
							// name displayed for user for each language
							'name' => Array(
								'en' => 'Insert thumbnail 500px',
								'pl' => 'Wstaw miniaturkę 500px'
							),
							// name added to orginal filename after _
							'output_file_name_postfix' => '500',
							// what should we do to get this thumbnail
							'chain' => Array(
								Array(
									// class name
									'class' => 'Ciap_Image_Convert_ResizeToOneDimension',
									// options
									'options' => Array('width' => 500),
								)
							)
						),
					),
		)
	),
	);

?>
