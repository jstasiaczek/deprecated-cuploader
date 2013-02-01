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

<div class='form-inline span3' style="margin-bottom: 10px;">
<span style="display: none;">
	<input type="file" name="file<?php echo $this->field_postfix; ?>" id="fakeUploadInput_orgInput<?php echo $this->field_postfix; ?>" onchange="fakeInput_multi.renderPath($(this), $('#fakeUploadInput<?php echo $this->field_postfix; ?>'));"/>
</span>
<input class="span2 uneditable-input" id="fakeUploadInput<?php echo $this->field_postfix; ?>" disabled='disabled' type="text">
<button class="btn" onclick="$('#fakeUploadInput_orgInput<?php echo $this->field_postfix; ?>').focus().trigger('click');" type="button"><span class="icon-hdd"></span></button>
</div>
