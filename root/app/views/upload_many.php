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
	<h5 style="margin: 0px;"><?php echo Ciap_Lang::t('upload_many'); ?></h5>
</div>
<div class="modal-body">
	<form id="upload_many_form" method="POST" enctype="multipart/form-data" action="<?php echo Ciap_Url::create('upload', Array('back' => $this->current_dir)); ?>">
		<script type="text/javascript">
			var fakeInput_multi = new CFakeFileInput();
		</script>
		<?php for ($i =0; $i < 3; $i++): ?>
			<?php echo Ciap::render('upload_oneField', Array('field_postfix' => '_'.$i)) ?>
		<?php endfor; ?>
		<script type="text/javascript">
			window['current_upload_many_iter'] = <?php echo $i; ?>;
		</script>
		<div class='form-inline span3' style="margin-bottom: 10px;">
			<button class="btn" onclick="uploader.moreFiles('<?php echo $this->current_dir ?>', this)" type="button"><span class="icon-plus"></span></button>
			<button class="btn" onclick="uploader.uploadManyFiles(); return false;" type="button"><span class="icon-upload"></span></button>
		</div>
	</form>
</div>
