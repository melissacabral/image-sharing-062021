<?php 
require('config.php'); 
require_once('includes/functions.php');

//doctype and visible header
require('includes/header.php');
?>
<main class="content">
	<?php 
	//write it
	//get the most recent 10 published posts
	$result = $DB->prepare('SELECT posts.*, users.username, users.profile_pic, categories.* 
							FROM posts, users, categories
							WHERE posts.is_published = 1
							AND posts.user_id = users.user_id 
							AND posts.category_id = categories.category_id
							ORDER BY posts.date DESC
							LIMIT 10');
	//run it
	$result->execute();

	//check it - did we find at least one row?
	if( $result->rowCount() >= 1 ){
		//loop it
		while( $row = $result->fetch() ){
	?>
	
	<div class="post">
		<img src="<?php echo $row['image']; ?>">

		<span class="author">
			<img src="<?php echo $row['profile_pic']; ?>" width="50" height="50">
			<?php echo $row['username']; ?>
		</span>

		<h2><?php echo $row['title']; ?></h2>
		<p><?php echo $row['body']; ?></p>

		<span class="category"><?php echo $row['name']; ?></span>
		<span class="date"><?php  nice_date($row['date']); ?></span>
		<span class="comment-count"><?php count_comments( $row['post_id'] ); ?></span>
	</div>

	<?php 
		} //end while
	}else{
		//query found no posts
		echo '<h2>Sorry, no posts found.</h2>';
	} 
	?>


</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>