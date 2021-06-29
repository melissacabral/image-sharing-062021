<?php 
//Convert datetime into nice looking date
function nice_date( $timestamp ){
	$date = new DateTime( $timestamp );
	echo $date->format( 'l, F jS, Y' );
}

//count the number of approved comments on any post
function count_comments( $id ){
	global $DB;
	//count all the comments on THAT post  ? is a variable placeholder in PDO prepare()
	$result = $DB->prepare('SELECT COUNT(*) AS total
		FROM comments
		WHERE post_id = ?
		AND is_approved = 1');
	//run it (pass array of data to the query)
	$result->execute( array( $id ) );
	//check it
	if( $result->rowCount() >= 1  ){
		//loop it
		while( $row = $result->fetch() ){
			echo $row['total'];
		}
	} //end if
} //end count_comments


//Form Feedback Display
//Handle success/error messages
function display_feedback( &$message, &$class = 'error', &$bullets = array() ){
	if( isset( $message ) ){ ?>
		<div class="feedback <?php echo $class; ?>">
			<h2><?php echo $message; ?></h2>

			<?php if( ! empty( $bullets ) ){ ?>
				<ul>
					<?php foreach( $bullets AS $bullet ){
						echo "<li>$bullet</li>";
					} ?>
				</ul>
			<?php } //end if not empty  ?>

		</div>
	<?php } //end if isset
} //end function


//test if something exists before you show it (clears notices on variables)
function echo_if_exists( &$something ){
	if( isset($something) ){
		echo $something;
	}
}


/**
 * check to see if the viewer is logged in
 * @return array|bool false if not logged in, array of all user data if they are logged in
 */

function check_login(){
    global $DB;
    //if the cookie is valid, turn it into session data
    if(isset($_COOKIE['access_token']) AND isset($_COOKIE['user_id'])){
        $_SESSION['access_token'] = $_COOKIE['access_token'];
        $_SESSION['user_id'] = $_COOKIE['user_id'];
    }

   //if the session is valid, check their credentials
   if( isset($_SESSION['access_token']) AND isset($_SESSION['user_id']) ){
        //check to see if these keys match the DB     

       $data = array(
       	'id' => $_SESSION['user_id'],
       	'access_token' =>$_SESSION['access_token'],
       );

        $result = $DB->prepare(
        	"SELECT * FROM users
                WHERE user_id = :id
                AND access_token = :access_token
                LIMIT 1");
        $result->execute( $data );
       
        if($result){
            //success! return all the info about the logged in user
            return $result->fetch();
        }else{
            return false;
        }
    }else{
        //not logged in
        return false;
    }
}

//checkbox helper
function checked( $val1, $val2 ){
	if( $val1 == $val2 ){
		echo 'checked';
	}
}


//no close php