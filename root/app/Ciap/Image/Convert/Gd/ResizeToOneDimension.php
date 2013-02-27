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
class Ciap_Image_Convert_Gd_ResizeToOneDimension  extends Ciap_Image_Driver_Convert_Abstarct{
	
	public function transform() {
		$res = $this->resource->raw;
		
		$params = $this->options;
		
		$width = null;
		if(isset($params['width']) && $params['width'] > 1)
			$width = $params['width'];
		
		$height = null;
		if(isset($params['height']) && $params['height'] > 1)
			$height = $params['height'];
		
		if((empty($height) && empty($width)) || ($height > 1 && $width > 1))
			throw new Ciap_Image_Exception('Please give only height OR width!');
		if((!empty($height) && !empty($width)) || (empty($height) && empty($width)))
			throw new Exception('Please set $height OR $width. ');

		$org_width = imagesx($res);
		$org_height = imagesy($res);

		if (!empty($height)) {
			$ratio = $height / $org_height;
			$width = $org_width * $ratio;
		} else {
			$ratio = $width / $org_width;
			$height = $org_height * $ratio;
		}
		$new_image = imagecreatetruecolor($width, $height);

		// resize image
		imagecopyresampled($new_image, $res, 0, 0, 0, 0, (int)$width, (int)$height, (int)$org_width, (int)$org_height);
		$this->resource->raw = $new_image;
		return $this->resource;
	}
}

?>
