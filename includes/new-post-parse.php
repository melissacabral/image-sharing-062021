<?php 
//if the user submitted the form
if( $_POST['did_upload'] ){
	//upload configuration 
	//this directory must exist and be writable
	$target_directory = 'uploads/';

	$sizes = array(
		'small' 	=> 150,
		'medium'	=> 300,
		'large'		=> 600,
	);

	//grab the image that they uploaded
	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];

	//validate
	$valid = true;

	//get the dimensions of the image
	list( $width, $height ) = getimagesize( $uploadedfile );

	//does the image contain pixels?
	if( $width == 0 OR $height == 0 ){
		//NOT AN IMAGE
		$valid = false;
		$errors['size'] = 'Your image does not meet the minimum size requirements.';
	}

	//if valid, process and resize the image
	if($valid){

		//get the filetype
		$filetype = $_FILES['uploadedfile']['type'];

		switch( $filetype ){
			case 'image/jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
				$src = imagecreatefromjpeg( $uploadedfile );
			break;

			case 'image/gif':
				$src = imagecreatefromgif( $uploadedfile );
			break;

			case 'image/png':
				//todo: increase resources on the server
				$src = imagecreatefrompng( $uploadedfile );
			break;
		}

		//unique string for the final file name
		$unique_name = sha1( microtime() );

		//do the resizing
		foreach( $sizes AS $size_name => $pixels ){
			//square crop calculations -  landscape or portrait
			if( $width > $height ){
				//landscape
				$offset_x = ( $width - $height ) / 2 ;
				$offset_y = 0;
				$crop_size = $height;
			}else{
				//portrait or square
				$offset_x = 0;
				$offset_y = ( $height - $width ) / 2;
				$crop_size = $width;
			}
			//create a new blank canvas of the desired size
			$tmp_canvas = imagecreatetruecolor( $pixels, $pixels );

			//scale down and align the original onto the tmp canvas
			//dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
			imagecopyresampled( $tmp_canvas, $src, 0, 0, $offset_x, $offset_y, $pixels, $pixels, $crop_size, $crop_size );

			//save it into the correct directory
			//something like 	uploads/fdkuhfdghjkfdg_small.jpg
			$filepath = $target_directory . $unique_name . '_' . $size_name . '.jpg';

			$did_save = imagejpeg( $tmp_canvas, $filepath, 70 );

		}//end foreach size

		//clean up old resources
		imagedestroy($src);
		imagedestroy($tmp_canvas);


		//Add post to Database
		if( $did_save ){
			$result = $DB->prepare( 'INSERT INTO posts
			(title, image, user_id, date, category_id, body, allow_comments, is_published )
			VALUES
			("", :image, :user_id, now(), 0, "", 0, 0 )' );

			$data = array(
				'image' => $unique_name,
				'user_id' => $logged_in_user['user_id'],
			);

			$result->execute( $data );

			if( $result->rowCount() >= 1 ){
				//file and DB successful
				$feedback = 'Success! Your post has been saved as a draft';
				$feedback_class = 'success';
			}else{
				//database error
				$feedback = 'Sorry, the post could not be saved';
				$feedback_class = 'error';
			}
		}else{
			$feedback = 'Sorry,the file could not be saved';
			$feedback_class = 'error';
		}

	}//end if valid
	else{
		$feedback = 'There was a problem uploading your image, fix the following:';
	}

}//end upload parser