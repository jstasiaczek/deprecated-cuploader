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

    /**
     * Ciap
     *
     * Provides an easy way to map URLs to classes. URLs can be literal
     * strings or regular expressions.
     *
     * When the URLs are processed:
     *      * delimiter (/) are automatically escaped: (\/)
     *      * The beginning and end are anchored (^ $)
     *      * An optional end slash is added (/?)
     *	    * The i option is added for case-insensitive searches
     *
     * Example:
     *
     * $urls = array(
     *     '/' => 'index',
     *     '/page/(\d+) => 'page'
     * );
     *
     * class page {
     *      function GET($matches) {
     *          echo "Your requested page " . $matches[1];
     *      }
     * }
     *
     * Ciap::stick($urls);
     *
     */
    class Ciap {
		
		/**
		 * Configuration array
		 * @var array 
		 */
		protected static $config = Array('view_directory' => '', 'entry_file_name' => false, 'lang_directory'=> '', 'base_app_dir' => '');
		
		public static $baseUrl = '';
		public static $baseUrlNoFile = '';
		private static $routes = Array();
		
		/**
		 * Initialize configuration array, in key is not set in configuration array, function throws exception.
		 * @param array $data
		 * @return array 
		 */
		public static function init(array $data = Array(), $in_script = false)
		{
			foreach($data as $key=>$value)
			{
				if(!isset(self::$config[$key]))
					throw new Exception ('No config key found!');
				self::$config[$key] = $value;
			}
			if($in_script)
				return;
			self::getBaseUrl();
			self::getBaseUrlNoFile();
		}
		
		/**
		 * Return path with DIRECTORY_SEPARATOR at end
		 * @param string $path
		 * @return string 
		 */
		public static function pathCorrect($path)
		{
			if($path[strlen($path)-1] == DIRECTORY_SEPARATOR)
				return $path;
			return $path.DIRECTORY_SEPARATOR;
		}
		
		/**
		 * Returns config value
		 * @param type $key
		 * @return mixed 
		 */
		public static function configGet($key)
		{
			if(!isset(self::$config[$key]))
				throw new Exception ('No config key found!');
			return self::$config[$key];
		}
		
		/**
		 * Set config value, if value is not set throws exception
		 * @param type $key
		 * @param type $value
		 */
		public static function configSet($key, $value)
		{
			if(!isset(self::$config[$key]))
				throw new Exception ('No config key found!');
			self::$config[$key] = $value;
			
		}
		
		public static function registerRoutes(array $routes)
		{
			foreach($routes as $route=>$action)
				self::registerRoute($route, $action);
		}
		
		public static function registerRoute($route, $action_class)
		{
			self::$routes[$route] = $action_class;
		}

        /**
         * stick
         *
         * the main static function of the ciap class.
         * @throws  Exception               Thrown if corresponding class is not found
         * @throws  Exception               Thrown if no match is found
         * @throws  BadMethodCallException  Thrown if a corresponding GET,POST is not found
         *
         */
        static function run () {
			$urls = self::$routes;
            $method = strtoupper($_SERVER['REQUEST_METHOD']);
			
			if(self::configGet('entry_file_name'))
			{
				$path = self::requestCutFile(self::configGet('entry_file_name'));
			}
			else
			{
				$path = $_SERVER['REQUEST_URI'];
			}
			
            $found = false;

            krsort($urls);

            foreach ($urls as $regex => $class) {
                $regex = str_replace('/', '\/', $regex);
                $regex = '^' . $regex . '\/?$';
                if (preg_match("/$regex/i", $path, $matches)) {
                    $found = true;
                    self::_internalCall($class, $method, $matches);
                    break;
                }
            }
            if (!$found) {
                throw new Exception("URL, $path, not found.");
            }
        }
		
		protected static function _internalCall($class, $method, $matches = Array(null))
		{
			if (class_exists($class)) {
				$obj = new $class;
				if (method_exists($obj, $method)) {
					$ret = call_user_func_array(Array($obj, strtolower($method)), $matches);
					if(!empty($ret))
					{
						echo $ret;
					}
				} else {
					throw new BadMethodCallException("Method, $method, not supported.");
				}
			} else {
				throw new Exception("Class, $class, not found.");
			}
		}
		
		public static function forward($action, $method = 'get')
		{
			$class = 'Action_'.$action;
			self::_internalCall($class, $method);
		}
		
		public static function getBaseUrlNoFile()
		{
			$path = $_SERVER['REQUEST_URI'];
			$file = self::$config['entry_file_name'];
			self::$baseUrlNoFile = substr($path, 0, strpos($path, $file));
			return self::$baseUrlNoFile;
		}
		public static function getBaseUrl()
		{
			$path = $_SERVER['REQUEST_URI'];
			$file = self::$config['entry_file_name'];
			self::$baseUrl = substr($path, 0, strpos($path, $file)).self::$config['entry_file_name'];
			return self::$baseUrl;
		}
		
		/**
		 * 
		 * @param string $file
		 * @return string 
		 */
		public static function requestCutFile($file)
		{
			$path = $_SERVER['REQUEST_URI'];
			if(strlen($path) == strpos($path, $file)+strlen($file))
					return '/';
			return substr($path, strpos($path, $file)+strlen($file));
		}
		
		/**
		 * Make a simple redirect, if we entered entry_file_name, add this 
		 * @param type $action 
		 */
		public static function redirect($action)
		{
			$action;
			header('Location:'.$action) ;
			exit();
		}
		
		/**
		 * Alias for Ciap_View::getHtml method. 
		 * Create new class populate it with data and render file
		 * @param type $name
		 * @param array $data
		 * @return type 
		 */
		public static function render($name, array $data = Array())
		{
			return Ciap_View::getHtml($name, $data);
		}
		
		public static function importClasses(array $classes = Array())
		{
			$dir = self::$config['base_app_dir'];
			foreach($classes as $class)
			{
				require_once $dir.self::convertClassToPath($class);
				$impl = class_implements($class);
				if(in_array('Ciap_Interface_AutoloadInit', $impl))
				{
					call_user_func(Array($class, 'moduleInit'));
				}
			}
		}
		
		public static function convertClassToPath($class_name)
		{
			return str_replace('_', "/", $class_name).'.php';
		}
    }
	
	
	

	
	
	
	
	

?>
