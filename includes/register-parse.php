<?php 
//pre-define vars
$policy = null;

//if the form was submitted
if( isset($_POST['did_register']) ){
	//sanitize all fields
	$username 	= filter_var( $_POST['username'],	FILTER_SANITIZE_STRING );
	$email 		= filter_var( $_POST['email'],		FILTER_SANITIZE_EMAIL );
	$password 	= filter_var( $_POST['password'], 	FILTER_SANITIZE_STRING );
	//sanitize a checkbox boolean (html checkboxes do not set data if not checked)
	if( isset($_POST['policy']) ){
		$policy = 1;
	}else{
		$policy = 0;
	}

	//validate everything
	$valid = true;

	//bad length username
	if( strlen($username) < $username_min OR strlen($username) > $username_max ){
		$valid = false;
		$errors['username'] = "Username must be between $username_min and $username_max characters long";
	}else{
		//check if username already taken
		$result = $DB->prepare('SELECT username 
								FROM users
								WHERE username = ?
								LIMIT 1');
		$result->execute( array( $username ) );
		//check if one row found - if so, this username is taken!
		if( $result->rowCount() >= 1 ){
			$valid = false;
			$errors['username'] = 'Sorry, that username is already in use. Try another.';
		}
	}//end username checks

	//email bad format or blank
	if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		$valid = false;
		$errors['email'] = 'Invalid email address';
	}else{
		//check if email is already registered in DB
		$result = $DB->prepare('SELECT email 
								FROM users
								WHERE email = ?
								LIMIT 1');
		$result->execute( array( $email ) );
		//if one row found, this email is taken!
		if( $result->rowCount() >= 1 ){
			$valid = false;
			$errors['email'] = 'That email is already registered. Try logging in.';
		}
	}//end email checks

	//password too short
	if( strlen($password) < $password_min ){
		$valid = false;
		$errors['password'] = "Create a strong password that is at least $password_min characters long";
	}

	//policy not checked
	if( ! $policy ){
		$valid = false;
		$errors['policy'] = 'You must agree to our policies before registering';
	}

	//if valid, add new user to DB
	if( $valid ){
		$result = $DB->prepare('INSERT INTO users
						(username, password, email, is_admin, join_date, profile_pic)
						VALUES
						( :username, :pass, :email, 0, now(), "images/default.png" )');
		
		//make a salted, hashed version of the password 
		//(make sure your DB can hold up to 255 chars in the password field)
		$hashed_pass = password_hash( $password, PASSWORD_DEFAULT );
		
		$data = array(
			'username' 	=> $username,
			'pass' 		=> $hashed_pass,
			'email'		=> $email
		);
		$result->execute($data);
		//check if it worked
		if( $result->rowCount() >= 1 ){
			//success
			$feedback = 'Welcome! You can now log in';
			$feedback_class = 'success';
		}else{
			//error
			$feedback = 'Sorry, there was a problem making your account. Try again later.';
			$feedback_class = 'error';
		}
	}else{
		$feedback = 'Fix the following errors:';
		$feedback_class = 'error';
	}
	
}//end form parser