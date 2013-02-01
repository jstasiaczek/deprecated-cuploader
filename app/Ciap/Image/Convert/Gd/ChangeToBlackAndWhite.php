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
class Ciap_Image_Convert_Gd_ChangeToBlackAndWhite extends Ciap_Image_Driver_Convert_Abstarct{
	
	public function __construct(\Ciap_Image_Resource $resource, array $options = array()) {
		parent::__construct($resource, $options);
	}
	
	public function transform() {
		$old_image = $this->resource->raw;
		$old_x = imagesx($old_image);
		$old_y = imagesy($old_image);
		$graysc = ImageCreate($old_x, $old_y);
		for ($c = 0; $c < 256; $c++) {
			ImageColorAllocate($graysc, $c,$c,$c);
		}
		
		imagecopymerge($graysc, $old_image, 0, 0, 0, 0, $old_x, $old_y, 100);
		
		$this->resource->raw = $graysc;
		return $this->resource;
	}
}

?>
