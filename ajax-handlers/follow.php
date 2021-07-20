<?php 
//get all dependencies
require('../config.php');
require_once( '../includes/functions.php' );

//simulate slow response
sleep(1);

//get all the data
$from_user = filter_var($_REQUEST['fromUserId'], FILTER_SANITIZE_NUMBER_INT);
$to_user = filter_var($_REQUEST['toUserId'], FILTER_SANITIZE_NUMBER_INT);

//check to see if this relationship already exists
$result = $DB->prepare("SELECT * FROM follows
                        WHERE from_user_id = :from_user 
                        AND to_user_id = :to_user
                        LIMIT 1");
$result->execute( array(
                    'from_user' => $from_user,
                    'to_user' => $to_user,
                ) );
if($result->rowCount() >= 1){
    //remove the relationship
    $query = "DELETE FROM follows
            WHERE from_user_id = :from_user 
            AND to_user_id = :to_user
            LIMIT 1";
}else{
    //add the relationship
    $query = "INSERT INTO follows
            (from_user_id, to_user_id)
            VALUES 
            (:from_user, :to_user)";
}

//run the resulting query
$result = $DB->prepare($query);
$result->execute( array(
                    'from_user' => $from_user,
                    'to_user' => $to_user,
                ) );
//update the interface
if( $result->rowCount() >= 1 ){
    follows_interface( $to_user, $from_user );
}else{
    //TODO: remove this after testing
    echo 'failed';
}