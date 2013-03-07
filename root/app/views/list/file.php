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
?>
<tr class="image-element <?php if(isset($this->class)) echo $this->class; ?>">
	<td class="thumb">
		<a href="#" onclick="uploader.getOptions('<?php echo $this->element['req'] ?>');return false;">
			<img src="<?php echo Ciap_Image::extendImageName($this->element['thumb'], 25) ?>" />
		</a>
	</td>
	<td class="name"><a href="#" onclick="uploader.getOptions('<?php echo $this->element['req'] ?>', this);return false;"><?php echo $this->element['name'] ?></a></td>
	<td class="number"><?php echo $this->element['sizes'][0] ?> <strong>x</strong> <?php echo $this->element['sizes'][1] ?> px</td>
	<td class="number"><?php echo $this->element['size'] ?></td>
</tr>