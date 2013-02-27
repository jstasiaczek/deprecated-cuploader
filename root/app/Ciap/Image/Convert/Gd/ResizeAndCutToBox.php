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
class Ciap_Image_Convert_Gd_ResizeAndCutToBox extends Ciap_Image_Driver_Convert_Abstarct{
	
	public function __construct(\Ciap_Image_Resource $resource, array $options = array()) {
		parent::__construct($resource, $options);
	}
	
	public function transform() {
		$res = $this->resource->raw;
		$width = imagesx($res);
		$height = imagesy($res);
		$to_height = $this->options['edge'];
		if(empty($to_height) || $to_height <= 0)
			throw new Ciap_Image_Exception("Edge not given!");
		// we start from 74 but we will add 1 in loop 
		$to = $to_height-1;
		do{
			$to +=1;
			$ratio = $to / $height;
			$new_width = $width * $ratio;
		// we must have width bigger or equals 75
		}while($new_width < $to_height);

		// an empty image
		$new_image = imagecreatetruecolor($new_width, $to);

		// resize image
		imagecopyresampled($new_image, $res, 0, 0, 0, 0, (int)$new_width, (int)$to, (int)$width, (int)$height);
		$src_x = $src_y =0;
		// if width or height is bigger that 75 we will get center part of image 
		if($new_width > $to_height)
		{
			$src_x = ceil(($new_width - $to_height)/2);
		}
		if($to > $to_height)
			$src_y = ceil(($to - $to_height)/2);

		// another empty image
		$new_image2 = imagecreatetruecolor($to_height, $to_height);

		// cut resized image to 75x75 size
		imagecopy($new_image2, $new_image, 0, 0, (int)$src_x, (int)$src_y, $to_height, $to_height);
		
		$this->resource->raw = $new_image2;
		return $this->resource;
	}
}

?>
