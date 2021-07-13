<?php 
//leave this file if not logged in 
if( ! $logged_in_user ){
	//leave this file (comment-form.php)
	echo 'Please log in to comment.';
	return;
} ?>
<section class="comment-form" id="respond">
	<h2>Leave a comment</h2>

	<?php display_feedback( $feedback, $feedback_class, $errors ); ?>

	<form action="single.php?post_id=<?php echo $post_id; ?>#respond" method="post">
		<textarea name="body"></textarea>
		<input type="hidden" name="did_comment" value="1">
		<input type="submit" value="Comment">
	</form>
</section>