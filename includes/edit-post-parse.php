<?php
//parse the form if it was submitted
if( isset( $_POST['did_edit'] ) ){
	//sanitize everything
	$title 		= filter_var( $_POST['title'], FILTER_SANITIZE_STRING );
	$body 		= filter_var( $_POST['body'], FILTER_SANITIZE_STRING );
	$category_id = filter_var( $_POST['category_id'], FILTER_SANITIZE_NUMBER_INT );
	//sanitize boolean checkboxes
	if( $_POST['allow_comments'] != 1 ){
		$allow_comments = 0;
	}else{
		$allow_comments = 1;
	}

	if( $_POST['is_published'] != 1 ){
		$is_published = 0;
	}else{
		$is_published = 1;
	}
	//validate
	$valid = true;
		//blank or too long (50 chars+) title
	if( $title == '' OR strlen( $title ) > 50 ){
		$valid = false;
		$errors[] = 'Please give your post a title up to 50 characters long.';
	}	
		//body longer than 500 chars
	if( strlen($body) > 500 ){
		$valid = false;
		$errors[] = 'The body of your post must be shorter than 500 characters.';
	}	
		//category id is not positive, nonzero int
	if( $category_id < 1 ){
		$valid = false;
		$errors[] = 'Please choose a category for your post';
	}
	
	//if valid, update this post in the DB and show feedback
	if( $valid ){
		$result = $DB->prepare('UPDATE posts
								SET 
								title = :title,
								body = :body,
								category_id = :category_id,
								allow_comments = :allow_comments,
								is_published = :is_published
								WHERE post_id = :post_id
								AND user_id = :user_id
								LIMIT 1');
		$data = array(
			'title' 			=> $title,
			'body' 				=> $body,
			'category_id' 		=> $category_id,
			'allow_comments'	=> $allow_comments,
			'is_published'		=> $is_published,
			'post_id'			=> $post_id,
			'user_id'			=> $logged_in_user['user_id'],
		);
		$result->execute($data);

		debug_statement($result);

		if( $result->rowCount() >= 1 ){
			//success
			$feedback = 'Successfully saved your changes.';
			$feedback_class = 'success';
		}else{
			//error
			$feedback = 'No changes were made';
			$feedback_class = 'info';
		}
	}else{
		$feedback = 'Please fix the following errors:';
		$feedback_class = 'error';
	}
}//end form parser


//Pre-fill this form and do a security check to make sure I'm logged in as the author
$result = $DB->prepare('SELECT * FROM posts
						WHERE post_id = ?
						AND user_id = ?
						LIMIT 1');
$data = array( $post_id, $logged_in_user['user_id'] );
$result->execute($data);
//if one row is found, create variables to use in the form below. if not lock the page down
if( $result->rowCount() >= 1 ){
	$row = $result->fetch();
	//create $title, $body, etc
	extract($row);
}else{
	exit('Invalid post');
}