	

<ul class="nav nav-tabs nav-stacked">
	<li>
		<a href="#" onclick="targetObj.insert(typeImage.getHtml('<?php echo $this->thumb ?>', <?php echo $this->thumb_sizes_string; ?>));return false;"><?php echo Ciap_Lang::t('insert_this'); ?></a>
	</li>
	<li>
		<a href="#" onclick="targetObj.insert(typeImage.getHtml('<?php echo $this->original ?>', <?php echo $this->original_sizes_string; ?>));return false;"><?php echo Ciap_Lang::t('insert_oryginal'); ?></a>
	</li>
<?php
if (!empty($this->thumb_sizes))
	foreach ($this->thumb_sizes as $thumb_id => $thumb):
		?>
		<li>
			<a href="#" onclick="typeImage.createThumb('<?php echo $this->relativePath ?>', <?php echo $thumb_id ?>, '<?php echo $this->fileName ?>');return false;">
			<?php echo $thumb['name'][Ciap_Lang::getLang()]; ?>
			</a>
		</li>
<?php endforeach; ?>
</ul>
<hr style="margin: 5px 0;" />
<a href='#' onclick="$('#additionalOptions').toggle();"><?php echo Ciap_Lang::t('additional_options') ?></a>
<div class="well well-small form-inline" id="additionalOptions" style="display: none;">
	<label class="span2" style="margin-left: 5px;" for="image-input-alt"><?php echo Ciap_Lang::t('alternative_text') ?>: </label>
	<input id="image-input-alt" type="text"/>
	<div style="clear: both;"></div>
	<label class="span2" style="margin-left: 5px;" for="image-input-title"><?php echo Ciap_Lang::t('title_text') ?>: </label>
	<input id="image-input-title" type="text"/>
</div>