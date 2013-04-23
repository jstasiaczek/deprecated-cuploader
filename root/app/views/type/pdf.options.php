
<div class="well well-small form-inline" id="additionalOptions">
	<label class="span2" style="margin-left: 5px;" for="file-input-text"><?php echo Ciap_Lang::t('link_text') ?>: </label>
	<input id="file-input-text" type="text" value="<?php echo $this->fileName; ?>"/>
	<div style="clear: both;"></div>
	<label class="span2" style="margin-left: 5px;" for="file-input-title"><?php echo Ciap_Lang::t('title_text') ?>: </label>
	<input id="file-input-title" type="text" value="<?php echo $this->fileName; ?>"/>
	<div style="clear: both;"></div>
	<label class="span2" style="margin-left: 5px;" for="file-input-window"><?php echo Ciap_Lang::t('in_new_window') ?>: </label>
	<input id="file-input-window" type="checkbox" value="1"/>
	<input id="file-input-url" type="hidden" value="<?php echo $this->fileUrl; ?>"/>
	<hr style="clear: both; margin: 5px 0" />
	<div style="text-align: right;">
		<button type="button" onclick="targetObj.insert(typeFile.getHtml());" class="btn btn-success"><?php echo Ciap_Lang::t('insert') ?></button>
	</div>
</div>