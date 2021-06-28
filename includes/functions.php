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
function display_feedback( $message, $class = 'error', $bullets = array() ){
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

//no close php