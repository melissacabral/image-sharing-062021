<?php 
require('config.php'); 
require_once('includes/functions.php');

//which post are we editing? 
//URL looks like edit-post.php?post_id=X
$post_id = filter_var( $_GET['post_id'], FILTER_SANITIZE_NUMBER_INT );

//doctype and visible header
require('includes/header.php');

//shut down this page if not logged in
if( ! $logged_in_user ){
	exit('You must be logged in to see this page');
}
require( 'includes/edit-post-parse.php' );
?>
<main class="content">
	<h2>Edit Post</h2>

	<?php display_feedback( $feedback, $feedback_class, $errors ); ?>

	<img src="<?php image_url($image, 'medium'); ?>">

	<form method="post" action="edit-post.php?post_id=<?php echo $post_id; ?>">
		<label>Title:</label>
		<input type="text" name="title" value="<?php echo $title; ?>">

		<label>Body:</label>
		<textarea name="body"><?php echo $body; ?></textarea>

		<label>Category:</label>
		<select name="category_id">
			<option>Choose a category</option>
			<?php //get all the categories 
			$result = $DB->prepare('SELECT * FROM categories'); 
			$result->execute();

			if( $result->rowCount() >= 1 ){
				while( $row = $result->fetch() ){
			?>
			<option value="<?php echo $row['category_id']; ?>" 
				<?php selected( $category_id, $row['category_id'] ) ?>>
				<?php echo $row['name']; ?>
			</option>
			<?php 
				}
			} //end if categories found ?>

		</select>

		<label>
			<input type="checkbox" name="allow_comments" value="1" 
				<?php checked(1, $allow_comments); ?>>
			Allow comments on this post
		</label>

		<label>
			<input type="checkbox" name="is_published" value="1" 
				<?php checked(1, $is_published); ?>>
			Make this post public
		</label>

		<input type="submit" value="Save Post">
		<input type="hidden" name="did_edit" value="1">
	</form>

</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>