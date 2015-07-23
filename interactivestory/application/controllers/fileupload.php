<?php
class Fileupload extends CI_Controller {

	public function upload_file() {
		
		$path = $_POST['path'];
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
	
		if (is_uploaded_file($_FILES['file']['tmp_name'])) {
			
			echo "File ". $_FILES['file']['name'] ." uploaded successfully.\n";
			move_uploaded_file ($_FILES['file'] ['tmp_name'], $path.$_FILES['file'] ['name']);
			
		}  else  { 
			
			echo "Possible file upload attack: "; 
			echo "filename '". $_FILES['file']['tmp_name'] . "'.";
			print_r($_FILES); }
	}
}
?>