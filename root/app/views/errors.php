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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="<?php echo Ciap::$baseUrlNoFile; ?>css/uploader_main.css" />
		<script type="text/javascript" src="<?php echo Ciap::$baseUrlNoFile; ?>/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo Ciap::$baseUrlNoFile; ?>/js/uploader.js"></script>
        <title></title>
    </head>
    <body>
		<div class="padding_5 borderb">
			<a  href="<?php echo Ciap_Url::create('index', Array('path' => $this->current_dir)); ?>" ><?php echo Ciap_Lang::t('back'); ?></a>
		</div>
		<?php foreach($this->errors as $file => $message) { ?>
		<div class="padding_5 borderb">	
			<b><?php echo $file ?></b> <br/> 
			<span style="color: red; font-weight: bold;"><?php echo $message ?></span>
		</div>	
		<?php } ?>
		<?php foreach($this->warnings as $file => $message) { ?>
		<div class="padding_5 borderb">	
			<b><?php echo $file ?></b> <br/> 
			<span style="color: orange; font-weight: bold;"><?php echo $message ?></span>
		</div>	
		<?php } ?>
		<?php ?>
		<div class="padding_5">
			<a  href="<?php echo Ciap_Url::create('index', Array('path' => $this->current_dir)); ?>" ><?php echo Ciap_Lang::t('back'); ?></a>
		</div>
    </body>
</html>
