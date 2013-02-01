<!DOCTYPE html>
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
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Add image</title>
    </head>
    <body>
		<?php if(isset($this->message) && $this->message == true): ?>
		<div style="background-color: #ccff33; border: #00cc00 1px solid; padding: 5px;">
			Dodano
		</div>
		<?php endif; ?>
		
		<?php if(isset($this->message) && $this->message == false): ?>
		<div style="background-color: #ff9999; border: #ff0033 1px solid; padding: 5px;">
			Błąd
		</div>
		<?php endif; ?>
		<form method="POST" enctype="multipart/form-data" action="<?php echo Ciap::$baseUrl.'/upload?lang='.Ciap_Lang::getLang().'&back='.$this->current_dir?>">
			Plik<br />
			<input type="file" name="image" /><br />
			Opis<br />
			<input type="text" name="name" /><br /><br />
			<input type="submit" value="Dodaj" /><br />
		</form>
		<?php
		// put your code here
		?>
    </body>
</html>
