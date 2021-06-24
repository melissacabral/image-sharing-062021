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
	$result = $DB->prepare('SELECT name
							FROM categories
							ORDER BY RAND()');
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
			
			<li><?php echo $row['name']; ?></li>

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
</aside>