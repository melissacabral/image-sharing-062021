<?php 
require('config.php'); 
require_once(  'includes/functions.php' );
require( 'includes/header.php' );

//which profile are we showing?  profile.php?user_id=X
//if not set, show the logged in user
if( isset($_GET['user_id']) ){
	$user_id = filter_var( $_GET['user_id'], FILTER_SANITIZE_NUMBER_INT );
}else{
	$user_id = $logged_in_user['user_id'];
}

?>
<main class="content">
	<div class="grid">
		<?php //get this user and all their published posts (if they exist)
		$result = $DB->prepare('SELECT posts.*, users.username, users.bio, users.profile_pic
								FROM users
								LEFT JOIN posts
								ON ( posts.user_id = users.user_id AND posts.is_published = 1 )
								WHERE users.user_id = ?
								ORDER BY posts.date DESC
								LIMIT 21'); 
		$result->execute( array( $user_id ) );
		if( $result->rowCount() >= 1 ){
			while( $row = $result->fetch() ){
				
		?>
		<div class="important">
			<div class="author author-profile">
				<img src="<?php echo $row['profile_pic'] ?>" width="100" height="100"> 
				<h2><?php echo $row['username']; ?></h2>
				<p class="bio"><?php echo $row['bio']; ?></p>
			</div>

			<div class="follows grid">
				<div>999 posts</div>
				<div>9999 Followers</div>
				<div>9 following</div>
			
				
			</div>

		
		<!-- all the remaining posts should be little posts -->
		<div class="post little-post item">
			<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
				<img src="<?php image_url($row['image'], 'small') ?>">
			</a>
		</div>
	<?php 
				
			}//end while
		}//end if rows found ?>

	</div><!-- end .grid -->
</main>

<?php 
include( 'includes/sidebar.php'); 
include( 'includes/footer.php');
?>