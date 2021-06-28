<?php 
//pre-define all variables to prevent notices
$feedback = null;
$feedback_class = '';
$errors = array();

//if the form was submitted
if( isset( $_POST['did_comment'] ) ){
	//sanitize everything
	$body = filter_var( $_POST['body'], FILTER_SANITIZE_STRING );
	//TODO: make this work with the logged in user
	$user_id = 1;

	//validate
	$valid = true;

	//body is blank
	if( '' == $body ){
		$valid = false;
		$errors['body'] = 'Comment can\'t be blank';
	}
	
	//if valid, add the comment to the DB
	if( $valid ){
		$result = $DB->prepare('INSERT INTO comments
								( user_id, body, date, post_id, is_approved )
								VALUES 
								( :user_id, :body, now(), :post_id, 1 )');
		$data = array(
					'user_id' 	=> $user_id,
					'body'		=> $body,
					'post_id'	=> $post_id
					);

		$result->execute( $data );

		//check to see if one row was added
		if( $result->rowCount() >= 1 ){
			//success!
			$feedback = 'Thank you for your comment';
			$feedback_class = 'success';
		}else{
			//error
			$feedback = 'Your comment could not be saved.';
			$feedback_class = 'error';
		}
	}else{
		//invalid submission
		$feedback = 'Invalid Comment.';
		$feedback_class = 'error';
	}
	//show user feedback
	
}//end if did_comment

//no close php