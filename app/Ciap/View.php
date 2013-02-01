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
class Ciap_View
	{
		
		/**
		 * Create new class populate it with data and render file
		 * @param string $name
		 * @param array $data
		 * @return string 
		 */
		public static function getHtml($name, array $data = Array())
		{
			$view = new Ciap_View;
			if(!empty($data))
			{
				foreach($data as $key=>$value)
					$view->$key = $value;
			}
			return $view->render($name);
		}
		
		/**
		 * Check if key exsists and return it or default value
		 * @param string $key
		 * @param mixed $default
		 * @return mixed
		 */
		public function getValue($key, $default = null)
		{
			if(!isset($this->$key))
				return $default;
			return $this->$key;
		}
		
		/**
		 * Render file and return html
		 * @param string $name
		 * @return string 
		 */
		public function render($name)
		{
			$html = '';
			ob_start();
			include (Ciap::pathCorrect(Ciap::configGet('view_directory')).$name.'.php');
			$html = ob_get_contents();
			ob_end_clean();
			unset($view);
			return $html;
		}
	}

?>
