<?php 
//get up to 20 approved comments on THIS post, oldest first
// ($post_id is defined in single) 
$result = $DB->prepare('SELECT users.profile_pic, users.username, comments.body, 
								comments.date
						FROM comments, users
						WHERE comments.user_id = users.user_id
						AND comments.is_approved = 1
						AND comments.post_id = ?
						ORDER BY comments.date ASC
						LIMIT 20');
$result->execute( array( $post_id ) );
if( $result->rowCount() >= 1 ){
?>
<section class="comments">
	<h2>Comments</h2>

	<?php while( $row = $result->fetch() ){ ?>
	<div class="one-comment">
		<div class="user">
			<img src="<?php echo $row['profile_pic']; ?>" width="50" height="50">
			<?php echo $row['username']; ?>
		</div>

		<p><?php echo $row['body']; ?></p>

		<span class="date"><?php nice_date( $row['date'] ); ?></span>
	</div>
	<?php } //end while ?>
</section>
<?php } //end if comments found ?>