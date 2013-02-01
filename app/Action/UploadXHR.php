<?php
class Action_UploadXHR extends Action_Upload{
	public function get($maches)
	{
	}
	
	public function post($maches)
	{
		$add_path = '';
		$return_to = '';
		$errors = Array();
		$warnings = Array();
		$success = Array();
		if(isset($_GET['back']))
		{
			$return_to = $_GET['back'];
			$add_path = str_replace(Ciap_Reg::get('separator'), '/', $_GET['back']);
		}
		
		$path_small = $this->config['thumb_dir'].'/'.$add_path;
		$path_big = $this->config['image_upload_dir'].'/'.$add_path;
		
		if(!is_dir($path_small))
			mkdir ($path_small, 0777, true);

		if(!empty($_FILES))
		{
			list($warnings, $errors, $success) = $this->handleUploads($path_big, $path_small, $warnings, $errors, $success);
		}
		else {
			$errors[Ciap_Lang::t('empty')] = Ciap_Lang::t('error_unknown');
		}
		
		$display_type = Ciap_Reg::get('type', $this->config['default_directory_view']);
		
		$html = Array();
		foreach($success as $file => $file_path)
		{
			$row_data = Array(
				'name' => $file,
				'path' => $file_path,
				'type' => 'file'
			);
			$element = $this->addThumbPath(Array($row_data), $add_path);
			 $html[] = Ciap::render($display_type.'/file', Array('element'=>$element[0], 'class' => 'success'));
			 
		}
		return json_encode(Array('errors' => $this->preprateArrayForJson($errors), 'warnings' => $this->preprateArrayForJson($warnings), 'html' => $html));
	}
}

?>