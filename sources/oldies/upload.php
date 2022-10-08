<?php
	require_once 'security.php';
	require_once '../config/database.php';


	// Fetch the image array sent by preupload.php  
	  
	$photos_uploaded = $_FILES['photo_filename'];  
	  
	// Fetch the image caption array  
	  
	$photo_captions = $_POST['photo_captions'];


	$photo_types = array(    
	  'image/pjpeg' => 'jpg',
	  'image/jpeg' => 'jpg',
	  'image/gif' => 'gif',
	  'image/bmp' => 'bmp',
	  'image/x-png' => 'png'
	);

	while($counter <= count($photos_uploaded))
	{   
		if($photos_uploaded['size'][$counter] > 0)
  		{
			if(!array_key_exists($photos_uploaded['type'][$counter], $photo_types))
			{
				$result_final .= 'File ' . ($counter + 1) . ' is not a photo<br />';
			}
			else
			{
				// Great the file is an image, we will add this file
			}
		}
	}


?>