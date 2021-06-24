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


//no close php