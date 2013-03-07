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
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php echo Ciap_Script::getInstance()->renderHeader(); ?>
        <title>CUploader<?php echo $this->titlePath ?></title>
		<script type="text/javascript">
			urls.createThumb = '<?php echo Ciap_Url::create('createthumb')->buildUrl();?>';
			urls.uploadManyDialog = '<?php echo Ciap_Url::create('upload')->buildUrl(); ?>';
			urls.uploadFileXHR = '<?php echo Ciap_Url::create('uploadXHR')->buildUrl(); ?>';
			urls.moreFiles = '<?php echo Ciap_Url::create('upload', Array('action'=>'add_field'))->buildUrl(); ?>';
			urls.getOptions = '<?php echo Ciap_Url::create('options')->buildUrl(); ?>';
			urls.getFolderActions = '<?php echo Ciap_Url::create('folder_actions')->buildUrl(); ?>';
			urls.getAbout = '<?php echo Ciap_Url::create('about')->buildUrl(); ?>';
			urls.currentLocation = '<?php echo Ciap_Url::create('index', Array('path'=>$this->current_dir)) ?>';
			var uploader = new CUploader();
			uploader.urls = urls;
			uploader.viewMode = '<?php echo $this->view_type; ?>';
			var targetObj = new CTarget();
			targetObj.params = $.parseJSON('<?php echo Ciap_Target::getInstance()->getJsParams(); ?>');
			targetObj.setCurrentDirectory('<?php echo $this->current_dir ?>');
		</script>
    </head>
    <body>
		<div id="overlay" class="overlay" style="display:none;"></div>
		<div id="options" class="modal hide fade ciap-modal"></div>
		<div id="errors" class="modal hide fade ciap-modal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3><?php echo Ciap_Lang::t('upload_info'); ?><h3>
			</div>
			<div class="modal-body">
			</div>
		</div>
		<div id="wait" class="modal hide fade ciap-modal">
			<div class="modal-body">
				<?php echo Ciap_Lang::t('uploading'); ?> <span>100%</span>...
				<div class="progress progress-striped active">
					<div class="bar" style="width: 60%;"></div>
				</div>
			</div>
		</div>
		<div id="about" class="modal hide fade ciap-modal"></div>
		<div id="folder_actions" class="modal hide fade ciap-modal"></div>
		<div id="upload_many_dlg" class="modal hide fade ciap-modal"></div>
		<?php echo Ciap::render('navbar', Array('current_dir' => $this->current_dir, 'view_type' => $this->view_type)); ?>
		<div class='container' style="margin-top: 60px;">
		<div style="clear: both;"></div>
		<?php if(Config::getInstance()->show_breadcrumb): ?>
		<ul class="breadcrumb">
			<?php echo $this->navi; ?>
		</ul>
		<?php endif; ?>
		<div style="clear: both;"></div>
		<?php if(Config::getInstance()->show_tree && $this->showTree): ?>
		<div style="float: left; width: 18%; margin-right: 1%; padding: 2px;" class="well well-small">
			<?php echo $this->tree; ?>
		</div>
		<div style="float: left; width: 80%;">
			<?php echo Ciap_View::getHtml('toolbar', Array('current_dir' => $this->current_dir)); ?>
		<?php endif; ?>
			<?php echo Ciap::render($this->view_type, Array('dir' => $this->dir, 'current_dir' => $this->current_dir)); ?>
		<?php if(Config::getInstance()->show_tree && $this->showTree): ?>
		</div>
		<?php endif; ?>
		</div>
		<?php	$errors = $this->getValue('errors', false); 
				if($errors):?>
		<script type="text/javascript">
			uploader.showErrors($.parseJSON('<?php echo json_encode($errors['errors']) ?>'),$.parseJSON('<?php echo json_encode($errors['warnings']) ?>'));
		</script>
		<?php	endif; ?>
    </body>
</html>
