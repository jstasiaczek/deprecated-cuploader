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
class Ciap_Image_Driver_Gd extends Ciap_Image_Driver{
	public function getDriverDir() {
		return 'Gd';
	}

	public function load($path, $mimetype) {
		$raw = null;
		if(in_array($mimetype, Array('image/jpeg', 'image/pjpeg')))
			$raw = imagecreatefromjpeg($path);

		if(in_array($mimetype, Array('image/png', 'image/x-png')))
			$raw = imagecreatefrompng($path);

		if(in_array($mimetype, Array('image/gif')))
			$raw = imagecreatefromgif($path);

		if(empty($raw))
			throw new Ciap_Image_Exception("File is not in supported format, accept only jpeg, png and gif!");
		
		$image_name = basename($path);
		$image_path = dirname($path);
		
		return new Ciap_Image_Resource($raw, $mimetype, $path, $image_path, $image_name);
	}

	public function save(Ciap_Image_Resource $resource, $name) {
		$type = $resource->mime_type;
		$image = $resource->raw;
		$return = null;
		if(in_array($type, Array('image/jpeg', 'image/pjpeg')))
			$return = imagejpeg ($image, $name, 100);
		elseif(in_array($type, Array('image/png')))
			$return = imagepng ($image, $name, 9);
		elseif(in_array($type, Array('image/gif')))
			$return = imagegif ($image, $name);
		return $return;
	}
}

?>
