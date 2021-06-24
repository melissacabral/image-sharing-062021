<?php 
//Convert datetime into nice looking date
function nice_date( $timestamp ){
	$date = new DateTime( $timestamp );
	echo $date->format( 'l, F jS, Y' );
}


//no close php