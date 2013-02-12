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
class Ciap_Reg extends ArrayObject
	{
		public function __construct($array = array(), $flags = parent::ARRAY_AS_PROPS)
		{
			parent::__construct($array, $flags);
		}

		private static $_registry = null;

		/**
		 * Return instance of Helper_Registry class
		 * @return Helper_Registry
		 */
		public static function getInstance()
		{
			if (self::$_registry === null) {
				self::$_registry = new Ciap_Reg();
			}

			return self::$_registry;
		}

		/**
		 * Method return value of given index, if not exist return given $delault( null )
		 * @param string $index
		 * @param mixed $default
		 * @return mixed
		 */
		public static function get($index, $default = null)
		{
			$instance = self::getInstance();

			if (!$instance->offsetExists($index)) {
				return $default;
			}

			return $instance->offsetGet($index);
		}

		/**
		 * Method set $value for given $index
		 * @param string $index
		 * @param mixed $value
		 */
		public static function set($index, $value)
		{
			$instance = self::getInstance();
			$instance->offsetSet($index, $value);
		}

		/**
		 * Method check if $index is regiested
		 * @param string $index
		 * @return boolean
		 */
		public static function isRegistered($index)
		{
			if (self::$_registry === null) {
				return false;
			}
			return self::$_registry->offsetExists($index);
		}

		public function offsetExists($index)
		{
			return array_key_exists($index, $this);
		}
	}
?>