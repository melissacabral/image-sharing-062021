<?php 
//if the user is trying to logout 
//URL will be login.php?action=logout
if( isset( $_GET['action'] ) AND $_GET['action'] == 'logout' ){
	//remove the access token from the database
	
	//unset the cookies (make them null and expired)
	setcookie( 'access_token', '', time() - 9999);
	setcookie( 'user_id', '', time() - 9999);
	
	//destroy the session
	//https://www.php.net/manual/en/function.session-destroy.php
	$_SESSION = array();

	// If it's desired to kill the session, also delete the session cookie.
	// Note: This will destroy the session, and not just the session data!
	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000,
	        $params["path"], $params["domain"],
	        $params["secure"], $params["httponly"]
	    );
	}

	// Finally, destroy the session.
	session_destroy();
	
} //end logout logic