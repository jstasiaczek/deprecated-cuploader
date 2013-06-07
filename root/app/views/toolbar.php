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
<ul class="nav nav-tabs" id="filelist-toolbar">
	<li><a href="#" title="<?php echo Ciap_Lang::t('edit_current_dir'); ?>" onclick="uploader.getFolderActions('<?php echo $this->current_dir; ?>');return false;"><span class="icon-folder-open"></span><i class="icon-wrench"></i></a></li>
	<?php if(Config_Secure::can_delete_file()): ?>
		<li><a href="#" onclick="uploader.toggleSelectMode(this);return false;"><span class="icon-check"></span> <?php echo Ciap_Lang::t('select_files') ?></a></li>
		<li id="deleteManyButton" style="display: none;"><a href="#" onclick="uploader.deleteManyImages('<?php echo $this->current_dir; ?>', '<?php echo Ciap_Lang::t('remove_many_message')?>');return false;"><span class="icon-trash"></span> <?php echo Ciap_Lang::t('remove_files') ?></a></li>
	<?php endif; ?>
</ul>
