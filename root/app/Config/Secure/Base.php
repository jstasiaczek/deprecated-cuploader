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


/*
 *  ======================= DO NOT MODIFY THIS CLASS ======================
 */
class Config_Secure_Base {
	/**
	 * Some initial settings...
	 */
	public static function init()
	{
		
	}
	
	/**
	 * User can access whole plugin?
	 * @return boolean 
	 */
	public static function can_access()
	{
		
		return true;
	}
	
	/**
	 * Can user upload files?
	 * @return boolean 
	 */
	public static function can_upload()
	{
		return true;
	}
	
	/**
	 * Can user delete file?
	 * @return boolean
	 */
	public static function can_delete_file()
	{
		return true;
	}
	
	/**
	 * Can user delete file?
	 * @return boolean 
	 */
	public static function can_delete_dir()
	{
		return true;
	}
	
	/**
	 * Can user create dir?
	 * @return boolean 
	 */
	public static function can_create_dir()
	{
		return true;
	}
	
	/**
	 * Can user rename dir?
	 * @return boolean 
	 */
	public static function can_rename_dir()
	{
		return true;
	}
	
	/**
	 * Allow you to modify and personalize configuration for user.
	 * @param Config $settings
	 * @return mixed
	 */
	public static function modify_settings(Config $settings)
	{
		return $settings;
	}
}

?>
