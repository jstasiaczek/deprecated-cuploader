<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Image
 *
 * @author jstasiac
 */
class Type_Image extends Ciap_Type{
	protected function __construct($class) {
		parent::__construct($class);
		$this->mimeTypes = Array('image/jpeg', 'image/pjpeg','image/png','image/gif', 'image/x-png');
	}
}

?>
