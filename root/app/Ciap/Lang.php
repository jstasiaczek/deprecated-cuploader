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
class Ciap_Lang{
		protected static $langs = Array();
		protected static $current_lang = 'en';
		
		public static function setLang($lang)
		{
			self::$current_lang = $lang;
			self::loadTranslation($lang);
		}
		
		public static function getLang()
		{
			return self::$current_lang;
		}
		
		public static function loadTranslation($lang, $force = false)
		{
			$path = Ciap::configGet('lang_directory');
			if(isset(self::$langs[$lang]) && !$force)
					return ;
			if(!file_exists($path.$lang.'.php'))
				$lang = 'en';
			$array = include($path.$lang.'.php');
			if(is_array($array))
				self::$langs[$lang] = $array;
			else
				throw new Exception('Can\'t load language '.$lang.' file should return array ');
		}
		
		public static function t($key)
		{
			self::loadTranslation(self::$current_lang);
			if(isset(self::$langs[self::$current_lang][$key]))
				return self::$langs[self::$current_lang][$key];
			else
				return $key;
			
		}
		
		
	}

?>
