<?php 
require('config.php'); 
require_once('includes/functions.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>Image Sharing App</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css" integrity="sha512-xiunq9hpKsIcz42zt0o2vCo34xV0j6Ny8hgEylN3XBglZDtTZ2nwnqF/Z/TTCc18sGdvCjbFInNd++6q3J0N6g==" crossorigin="anonymous" />

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="site">
	<header class="header">
		<h1>Image Sharing App</h1>
	</header>
	<main class="content">
		<?php 
		//write it
		//get the most recent 10 published posts
		$result = $DB->prepare('SELECT image, title, body, date 
								FROM posts
								WHERE is_published = 1
								ORDER BY date DESC
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
			<h2><?php echo $row['title']; ?></h2>
			<p><?php echo $row['body']; ?></p>
			<span class="date"><?php  nice_date($row['date']); ?></span>
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
	
	<footer class="footer"></footer>
</div>
</body>
</html>