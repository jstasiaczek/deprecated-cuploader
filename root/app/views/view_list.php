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
<table border="0" class="filelist table table-bordered table-hover">
	<thead>
		<tr>
			<th style="width: 30px;"><?php echo Ciap_Lang::t('thumb_small'); ?></th>
			<th><?php echo Ciap_Lang::t('name'); ?></th>
			<th style="width: 150px;"><?php echo Ciap_Lang::t('info'); ?></th>
			<th style="width: 80px;"><?php echo Ciap_Lang::t('size'); ?></th>
		</tr>
	</thead>
	<tbody id="items-list" class="">
		<?php foreach($this->dir as $element): ?>
			<?php if($element['type'] == 'dir' && $element['name'] != '___cache'): ?>
				<?php echo Ciap::render('list/dir', Array('element'=>$element, 'current_dir'=>$this->current_dir)) ?>
			<?php endif;?>
			<?php if($element['type'] == 'file'): ?>
				<?php echo Ciap::render('list/file', Array('element'=>$element)) ?>
			<?php endif;?>
		<?php endforeach; ?>
	</tbody>
</table>
