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
							<form class="navbar-search pull-left"method="POST" enctype="multipart/form-data" action="<?php echo Ciap::$baseUrl.'/upload/?lang='.Ciap_Lang::getLang().'&back='.$this->current_dir?>&type=<?php echo Ciap_Reg::get('type'); ?>">
								<div class="input-append">
									<span style="display: none;">
										<input type="file" name="file" id="single-upload-file" onchange="fakeInput.renderPath($(this), $('#fakeUploadInput'));"/>
									</span>
									<input class="span2 uneditable-input" id="fakeUploadInput" disabled='disabled' id="appendedInputButton" type="text">
									<button class="btn" onclick="$('#single-upload-file').focus().trigger('click');" type="button"><span class="icon-hdd"></span></button>
									<button id="normal-upload-button" class="btn" type="submit"><span class="icon-upload"></span></button>
									<button id="xhr-upload-button" class="btn" type="button" onclick="uploadFileXHR('&back=<?php echo $this->current_dir ?>')" style="display: none;"><span class="icon-upload"></span></button>
									<a href="#" onclick="upload_many_dialog('<?php echo $this->current_dir ?>'); return false;" class="btn">...</a>
									<script type="text/javascript">
										var fakeInput = new CFakeFileInput();
										initCorrectUploader(<?php $settings = Ciap_Reg::get('config'); if($settings['skip_xhr_upload']) echo 'true'; else echo 'false'; ?>);
									</script>
								</div>
							</form>