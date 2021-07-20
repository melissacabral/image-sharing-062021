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

//checkbox helper. use to make a checkbox "sticky"
function checked( $val1, $val2 ){
	if( $val1 == $val2 ){
		echo 'checked';
	}
}
//select dropdown helper
function selected( $val1, $val2 ){
	if( $val1 == $val2 ){
		echo 'selected';
	}
}


/**
 * displays sql query information including the computed parameters.
 * Silent unless DEBUG MODE is set to 1 in config.php
 * @param [type] $[name] [<description>]
 */

function debug_statement($sth){
    if( DEBUG_MODE ){
        echo '<pre>';
    
        $info =  debug_backtrace();
        echo '<b>Debugger ran from ' . $info[0]['file'] . ' on line ' . $info[0]['line'] . '</b><br><br>';

        $sth->debugDumpParams();
        echo '</pre>';
    }
}

/*
Turn any image hash into a working url
*/
function image_url( $unique, $size = 'large' ){
	echo 'uploads/' . $unique . '_' . $size . '.jpg';
}


//Count how many followers any user has
function count_followers( $user_id ){
	global $DB;
	$result = $DB->prepare('SELECT COUNT(*) AS total 
							FROM follows
							WHERE to_user_id = ?');
	$result->execute( array( $user_id ) );
	$row = $result->fetch();
	//ternary operator example
	echo $row['total'] == 1 ? '1 Follower' : $row['total'] . ' Followers' ;
}

//Count how many users a user is following
function count_following( $user_id ){
	global $DB;
	$result = $DB->prepare('SELECT COUNT(*) AS total 
							FROM follows
							WHERE from_user_id = ?');
	$result->execute( array( $user_id ) );
	$row = $result->fetch();
	//ternary operator example
	echo $row['total'] == 1 ? '1 Following' : $row['total'] . ' Following' ;
}

/**
 * Display all info about a user's from_users
 * @param  int $user_id the profile we're viewing
 * @return mixed HTML
 */
function follows_interface( $to_user, $from_user ){
    global $DB;
    //if viewer is logged in
    if($from_user){
        //are they already following this account?
        $result = $DB->prepare("SELECT * FROM follows 
                                WHERE to_user_id = ?
                                AND from_user_id = ?
                                LIMIT 1");
        $result->execute(array( $to_user, $from_user ));
        if($result->rowCount() >= 1){
            //the viewer follows them
            $class = 'button-outline';
            $label = 'Unfollow';
        }else{
            //the viewer doesn't follow them yet
            $class = 'button';
            $label = 'Follow';
        }
    }
   
    ?>
    <div class="item"><?php count_followers( $to_user ); ?></div>
    <div class="item"><?php count_following( $to_user ); ?></div>
    <?php if( $from_user AND $to_user != $from_user ){ ?>
    <div class="item">
        <button class="follow-button <?php echo $class; ?>" data-to="<?php echo $to_user; ?>">
            <?php echo $label; ?>
        </button>
    </div>
    <?php } 
}


//no close php