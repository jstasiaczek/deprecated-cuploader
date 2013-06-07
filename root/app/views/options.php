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
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h5 style="margin: 0px;"><?php echo $this->filename; ?></h5>
</div>
<div class="modal-body" style="height: 300px;">
	<div class="row">
		<div class="span1_75n well well-small" style="height: 250px;">
			<img src="<?php echo $this->data['thumb']; ?>" />
			<hr />
			<?php echo $this->data['informations'] ?><br />
			<?php echo $this->data['size'] ?><br />
			<?php if(Config_Secure::can_delete_file()): ?>
			<hr />
			<button type="button" onclick="return uploader.deleteImage('<?php echo Ciap_Lang::t('confirm_delete'); ?>');" class="btn btn-danger btn-mini"><?php echo Ciap_Lang::t('delete') ?></button>
			<?php endif; ?>
		</div>
		<div class="span410px" style="height: 270px; overflow-y: auto;">
			<?php if(Ciap_Target::getInstance()->canInsertImages()): ?>
			<?php echo Ciap_Type_Manager::getInstance()->getTypeByFilename($this->normalPath.'/'.$this->filename)->renderOptions($this->normalPath, $this->filename, $this->path); ?>
			<?php else: ?>
			<strong><?php echo Ciap_Lang::t('can_no_insert_images'); ?></strong>
			<?php endif; ?>
		<form id="delete_form" action="<?php echo Ciap_Url::create('options') ?>" method="POST">
			<input type="hidden" name="back" value="<?php echo $this->path ?>" />
			<input type="hidden" name="file" value="<?php echo $this->filename ?>" />
			<input type="hidden" name="action" value="delete" />
		</form>
		</div>
	</div>
</div>
