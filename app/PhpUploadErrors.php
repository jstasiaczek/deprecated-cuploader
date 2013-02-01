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
class PhpUploadErrors{
	const UPLOAD_ERR_OK = 0;
	const UPLOAD_ERR_INI_SIZE = 1;
	const UPLOAD_ERR_FORM_SIZE = 2;
	const UPLOAD_ERR_PARTIAL = 3;
	const UPLOAD_ERR_NO_FILE = 4;
	const UPLOAD_ERR_NO_TMP_DIR = 6;
	const UPLOAD_ERR_CANT_WRITE = 7;
	const UPLOAD_ERR_EXTENSION = 8;
	
	protected static $errors = Array();
	protected static $all = Array();
	
	protected static function _init()
	{
		if(!empty(self::$errors))
				return;
		
		self::$errors = Array(self::UPLOAD_ERR_CANT_WRITE, self::UPLOAD_ERR_EXTENSION, self::UPLOAD_ERR_FORM_SIZE, self::UPLOAD_ERR_INI_SIZE,
			self::UPLOAD_ERR_NO_TMP_DIR, self::UPLOAD_ERR_PARTIAL);
		
		self::$all = Array(self::UPLOAD_ERR_NO_FILE, self::UPLOAD_ERR_OK, self::UPLOAD_ERR_CANT_WRITE, self::UPLOAD_ERR_EXTENSION, self::UPLOAD_ERR_FORM_SIZE, self::UPLOAD_ERR_INI_SIZE,
			self::UPLOAD_ERR_NO_TMP_DIR, self::UPLOAD_ERR_PARTIAL);
	}
	
	public static function getAll()
	{
		self::_init();
		return self::$all;
	}
	
	public static function getErrors()
	{
		self::_init();
		return self::$errors;
	}
	
	public static function isError( $id)
	{
		self::_init();
		$id = (int)$id;
		if(in_array($id, self::$errors))
			return true;
		return false;
	}
	
	public static function getMessage($id)
	{
		self::_init();
		if(in_array($id, Array(self::UPLOAD_ERR_CANT_WRITE, self::UPLOAD_ERR_EXTENSION, self::UPLOAD_ERR_NO_TMP_DIR, self::UPLOAD_ERR_PARTIAL)))
			return Ciap_Lang::t('error_system');
		if(in_array($id, Array(self::UPLOAD_ERR_FORM_SIZE, self::UPLOAD_ERR_INI_SIZE)))
			return Ciap_Lang::t('error_size');
		return Ciap_Lang::t('error_ok');
	}
}

?>
