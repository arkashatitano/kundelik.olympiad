<?php 
if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["image"]["name"];
        $filetype = $_FILES["image"]["type"];
        $filesize = $_FILES["image"]["size"];
    
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
		$file = uniqid().'_'.time().'.'.$ext;
        if(in_array($filetype, $allowed)){
            move_uploaded_file($_FILES["image"]["tmp_name"], "custom/wysiwyg/upload/" . $file);
			$res = [
				'url' => '/uploads/wysiwyg//' . $file
				];
                
            
        } else{
            $res = [
				'url' => '/custom/wysiwyg/upload/' . $file
				];
        }
}
		echo json_encode($res);