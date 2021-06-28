<?php 
require('config.php'); 
require_once('includes/functions.php');

//what did they search for?
$phrase = filter_var( $_GET['phrase'], FILTER_SANITIZE_STRING ); 

//doctype and visible header
require('includes/header.php');
?>
<main class="content">
	<?php 
	//validate - make sure phrase isn't blank
	if( $phrase != '' ){
		//get all the published posts that match the phrase (title or body)
		$result = $DB->prepare('SELECT post_id, title, image, date
								FROM posts
								WHERE is_published = 1	
								AND ( title LIKE :phrase 
								OR body LIKE :phrase )  ');
		//run it (% means wildcard unknown characters around the phrase)
		$result->execute( array( 'phrase' => "%$phrase%" ) );

		//how many rows were found?
		$total = $result->rowCount();
	?>
	<section class="title">
		<h2>Search Results for "<?php echo $phrase; ?>"</h2>
		<h3><?php echo $total; ?> posts found. Showing page PAGE of MAXPAGES</h3>
	</section>

	<?php if( $total >= 1 ){ ?>
	<section class="grid">
		
		<?php while( $row = $result->fetch() ){ ?>
		<div class="item">
			<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
				<img src="<?php echo $row['image']; ?>" width="200" height="200">

				<h3><?php echo $row['title']; ?></h3>
				<span class="date"><?php nice_date( $row['date'] ); ?></span>
			</a>
		</div> <!-- end .item -->
		<?php } //end while ?>

	</section> <!-- end .grid -->
	<?php } //end if total ?>


	<?php 
	}else{
		echo 'Invalid Search';
	} 
	?>
</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>