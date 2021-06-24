<aside class="sidebar">
	
	<?php 
	//get the 5 most recently joined users
	$result = $DB->prepare('SELECT username, profile_pic
							FROM users
							ORDER BY join_date DESC
							LIMIT 5');
	//run it
	$result->execute();
	//check it
	if( $result->rowCount() >= 1 ){
	?>
	<section class="users">
		<h2>Newest Users</h2>

		<ul>
			<?php 
			//loop it
			while( $row = $result->fetch() ){ ?>
			<li class="user"><img src="<?php echo $row['profile_pic']; ?>" 
				alt="<?php echo $row['username']; ?>" width="50" height="50"></li>
			<?php } //end while ?>
		</ul>
	</section>
	<?php } //end if users found ?>

	<?php 
	//get up to 20 categories in a random order 
	$result = $DB->prepare('SELECT COUNT(*) AS total, categories.name
							FROM posts, categories
							WHERE posts.category_id = categories.category_id 
							GROUP BY posts.category_id
							ORDER BY RAND()
							LIMIT 20');
	//run it
	$result->execute();
	//check it
	if( $result->rowCount() >= 1 ){
	?>
	<section class="categories">
		<h2>Categories</h2>

		<ul>
			<?php //loop it 
			while( $row = $result->fetch() ){ ?>
			
			<li><?php echo $row['name']; ?> (<?php echo $row['total']; ?>)</li>

			<?php } ?>
		</ul>
	</section>
	<?php } //end if categories found ?>

	<?php //get up to 20 tags in a random order ?>
	<section class="tags">
		<h2>Tags</h2>

		<ul>
			<li>NAME</li>
		</ul>
	</section>
	<?php //end tags ?>

	<?php //show the 5 most recent comments with their author and the post they are about
	$query = 	'SELECT users.username, comments.body, posts.title
				FROM users, comments, posts
				WHERE users.user_id = comments.user_id
				AND comments.post_id = posts.post_id
				ORDER BY comments.date DESC
				LIMIT 5'; 
	$result = $DB->prepare($query);
	//run it
	$result->execute();
	//check it
	if( $result->rowCount() >= 1 ){
	?>
	<section class="recent-comments">
		<h2>Recent Comments</h2>

		<ul>
			<?php 
			//loop it
			while( $row = $result->fetch() ){ ?>
			<li>
				<?php echo $row['username']; ?>
				said: <b>"<?php echo $row['body']; ?>"</b> 
				on <?php echo $row['title']; ?></li>
			<?php } //end while ?>
		</ul>
	</section>
	<?php } //end if recent comments ?>
</aside>