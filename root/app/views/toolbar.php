<ul class="nav nav-tabs" id="filelist-toolbar">
	<li><a href="#" title="<?php echo Ciap_Lang::t('edit_current_dir'); ?>" onclick="uploader.getFolderActions('<?php echo $this->current_dir; ?>');return false;"><span class="icon-folder-open"></span><i class="icon-wrench"></i></a></li>
	<li><a href="#" onclick="uploader.toggleSelectMode(this);return false;"><span class="icon-check"></span> <?php echo Ciap_Lang::t('select_files') ?></a></li>
	<li id="deleteManyButton" style="display: none;"><a href="#" onclick="uploader.deleteManyImages('<?php echo $this->current_dir; ?>', '<?php echo Ciap_Lang::t('remove_many_message')?>');return false;"><span class="icon-trash"></span> <?php echo Ciap_Lang::t('remove_files') ?></a></li>
</ul>
