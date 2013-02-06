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
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h5 style="margin: 0px;"><?php echo Ciap_Lang::t('edit_current_dir'); ?></h5>
</div>
<div class="modal-body" style="text-align: center;">
<?php if(!$this->getValue('can_do_something')): ?>
<div class="option_option">
	<strong><?php echo Ciap_Lang::t('cant_perform_any_forlder_action') ?></strong>
</div>
<?php endif; ?>
<?php if($this->can['create_new'] && Config_Secure::can_create_dir()): ?>

	<h5><?php echo Ciap_Lang::t('dir_add'); ?></h5>
	<form class="form-inline" action="<?php echo Ciap_Url::create('folder_actions') ?>" method="POST" style="text-align: center;">
		<input type="hidden" value="add" name="action" />
		<input type="hidden" value="<?php echo $this->back ?>" name="back" />
		<input type="hidden" value="<?php echo $this->current_dir ?>" name="path" />
		<input type="text"  name="new" id="new_folder" value="" />&nbsp;<input class="btn" type="submit" onclick="return uploader.validateFolderName('new_folder');" value="<?php echo Ciap_Lang::t('save'); ?>" />
	</form>
	<div style="clear: both;">&nbsp;</div>
<?php endif; ?>
<?php if($this->can['edit'] && Config_Secure::can_rename_dir()): ?>
	<h5><?php echo Ciap_Lang::t('dir_edit'); ?></h5>
	<form class="form-inline" action="<?php echo Ciap_Url::create('folder_actions') ?>" method="POST" style="text-align: center;">
		<input type="hidden" value="rename" name="action" />
		<input type="hidden" value="<?php echo $this->back ?>" name="back" />
		<input type="hidden" value="<?php echo $this->current_dir ?>" name="path" />
		<input type="hidden" value="<?php echo $this->dir ?>" name="current" />
		<input type="text" name='new' id="folder_rename" value="<?php echo $this->dir; ?>" />&nbsp;<input class="btn" type="submit" onclick="return uploader.validateFolderName('folder_rename');" value="<?php echo Ciap_Lang::t('save'); ?>" />
		<p class="text-warning"><?php echo Ciap_Lang::t('rename_dir_warning'); ?></p>
	</form>
	<div style="clear: both;">&nbsp;</div>

<?php endif; ?>
<?php if($this->can['delete'] && Config_Secure::can_delete_dir()): ?>

	<form class="form-inline" action="<?php echo Ciap_Url::create('folder_actions') ?>" method="POST" style="text-align: center;">
		<input type="hidden" value="delete" name="action" />
		<input type="hidden" value="<?php echo $this->back ?>" name="back" />
		<input type="hidden" value="<?php echo $this->current_dir ?>" name="path" />
		<input class="btn btn-danger" type="submit" value="<?php echo Ciap_Lang::t('dir_delete'); ?>" />
	</form>
	<div style="clear: both;">&nbsp;</div>

<?php endif; ?>
</div>