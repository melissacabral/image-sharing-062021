<?php
//parse the form if the logged in
if( isset($_POST['did_login']) ){
	//sanitize all fields
	$input_username = filter_var( $_POST['username'], FILTER_SANITIZE_STRING );
	$input_password = filter_var( $_POST['password'], FILTER_SANITIZE_STRING );

	//validate
	$valid = true;
	//username wrong length
	if( strlen($input_username) < $username_min OR strlen($input_username) > $username_max ){
		$valid = false;
		$errors[] = 'Wrong length username';
	}
	//password wrong length
	if( strlen( $input_password ) < $password_min ){
		$valid = false;
		$errors[] = 'password too short';
	}
	
	//if valid, 
	if($valid){
		//look up the username in the DB
		$result = $DB->prepare('SELECT user_id, password
										FROM users
										WHERE username = ?
										LIMIT 1');
		$result->execute( array( $input_username ) );
		//if username found, verify the password against the hash
		if( $result->rowCount() >= 1 ){
			//verify password
			$row = $result->fetch();
			//if password is verified, store a hardened cookie and session
			if( password_verify( $input_password, $row['password'] ) ){
				//success - generate a random token
				$access_token = bin2hex(random_bytes( 30 ));
				//store it in the db
				$result = $DB->prepare( 'UPDATE users
										SET access_token = :token
										WHERE user_id = :id 
										LIMIT 1' );
				$result->execute( array(
					'token' => $access_token,
					'id'	=> $row['user_id'],
				) );
				//save it as a cookie and session
				setcookie( 'access_token', $access_token, time() + 60 * 60 * 24 * 7 );
				$_SESSION['access_token'] = $access_token;

				setcookie( 'user_id', $row['user_id'], time() + 60 * 60 * 24 * 7 );
				$_SESSION['user_id'] = $row['user_id'];

				$feedback = 'Success. You are now logged in';
				$feedback_class = 'success';

			}else{
				//error, bad password
				$feedback = 'Incorrect Password';
				$feedback_class = 'error';
			}
		}else{
			//bad username
			$feedback = 'Incorrect username';
			$feedback_class = 'error';
		}
		
	}else{
		$feedback = 'Incorrect Username/Password Combo';
		$feedback_class = 'error';
	}	
}