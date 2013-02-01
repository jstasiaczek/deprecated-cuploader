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
class Ciap_Image_Convert_Gd_AddBackgroundAndCenter extends Ciap_Image_Driver_Convert_Abstarct{
	
	public function __construct(\Ciap_Image_Resource $resource, array $options = array()) {
		parent::__construct($resource, $options);
	}
	
	public function transform() {
		
		$params = $this->options;
		
		if(!isset($params['width']) || !isset($params['height']) || $params['width'] < 1 || $params['height'] < 1 )
			throw new Ciap_Image_Exception('Incorrect height or width gived');
		
		$old_image= $this->resource->raw;
		
		$height = (int)$params['height'];
		$width = (int)$params['width'];
		
		$thumb = ImageCreateTrueColor($height, $width);
		
		$color = ImageColorAllocate( $thumb, 255, 255, 255);
		if(isset($params['color']) && is_array($params['color']) && count($params['color']) == 3)
			$color = ImageColorAllocate( $thumb, $params['color'][0], $params['color'][1], $params['color'][2]);
		
		imagefill ($thumb, 0, 0, $color);
		$old_x = imagesx($old_image);
		$old_y = imagesy($old_image);
		
		if($old_y > $height || $old_x > $width)
			throw new Ciap_Image_Exception("Size of image is bigger that given dimensions");
		
		$thumb_x = (int)ceil(($width - $old_x) / 2);
		$thumb_y = (int)ceil(($height - $old_y) /2);

		imagecopyresized($thumb, $old_image, $thumb_x, $thumb_y, 0, 0, $old_x, $old_y, $old_x, $old_y);
		$this->resource->raw = $thumb;
		return $this->resource;
	}
}

?>
