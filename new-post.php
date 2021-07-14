<?php 
require('config.php'); 
require_once('includes/functions.php');

//doctype and visible header
require('includes/header.php');

//shut down this page if not logged in
if( ! $logged_in_user ){
	exit('You must be logged in to see this page');
}

require( 'includes/new-post-parse.php' );
?>
<main class="content">
	<h2>New Post</h2>

	<?php display_feedback( $feedback, $feedback_class, $errors ); ?>
	
	<form action="new-post.php" method="post" enctype="multipart/form-data">
		<label>Image File (jpg, gif or png allowed)</label>
		<input type="file" name="uploadedfile" accept=".jpg, .gif, .png">

		<input type="submit" value="Next: Add Details &rarr;">
		<input type="hidden" name="did_upload" value="1">
	</form>

</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>