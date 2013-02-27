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
<div onclick="window.location.href='<?php echo Ciap_Url::create('index', Array('path' => Ciap_Tools::createDirLink($this->current_dir,$this->element['name']))) ?>';" class="square thumbnail span1_75" style="cursor: pointer ;background-repeat: no-repeat; background-position: center; background-image: url(<?php echo Ciap::$baseUrlNoFile; ?>img/folder_open.png);">
	<div style="width: 100%; height: 54px;">&nbsp;</div>
	<a  title="<?php echo $this->element['name'] ?>" href=""></a>
		<?php echo Ciap_Tools::shortString($this->element['name'], 6) ?>
</div>