<?php 
require('config.php'); 
require_once('includes/functions.php');

//what did they search for?
$phrase = filter_var( $_GET['phrase'], FILTER_SANITIZE_STRING ); 

//configuration: how many posts per page?
$per_page = 4;

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

		//how many pages will we need to hold all the posts? ceil() always rounds up
		$max_pages = ceil( $total / $per_page );

		//what page are we on? url will be like search.php?phrase=bla&page=3
		$current_page = filter_var( $_GET['page'], FILTER_SANITIZE_NUMBER_INT );
		
		//validate current page (if invalid, send them to page 1)
		if( $current_page < 1 OR $current_page > $max_pages ){
			$current_page = 1;
		}

		//create the offset for the LIMIT
		$offset = ( $current_page - 1 ) * $per_page ;

		//write the query again, but with the LIMIT in place
		$result = $DB->prepare('SELECT post_id, title, image, date
								FROM posts
								WHERE is_published = 1	
								AND ( title LIKE :phrase 
								OR body LIKE :phrase ) 
								LIMIT :offset, :per_page');
		//must bind_param because LIMIT needs strict INT data
		$wildcard_phrase = "%$phrase%";
		$result->bindParam( 'phrase', $wildcard_phrase, PDO::PARAM_STR );
		$result->bindParam( 'offset', $offset, 		PDO::PARAM_INT );
		$result->bindParam( 'per_page', $per_page, 	PDO::PARAM_INT );

		$result->execute();
	?>
	<section class="title">
		<h2>Search Results for "<?php echo $phrase; ?>"</h2>
		<h3><?php echo $total; ?> posts found. 
			Showing page <?php echo $current_page; ?> of <?php echo $max_pages; ?></h3>
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


	<section class="pagination">
		<?php 
		$next = $current_page + 1;
		$prev = $current_page - 1;

		if( $current_page != 1 ){ ?>
		
		<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $prev; ?>" class="button button-outline">
			Previous Page
		</a>
		<?php 
		}  //end if not on first page

		if( $current_page != $max_pages ){
		?>
		<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $next; ?>" class="button button-outline">
			Next Page
		</a>
		<?php } //end if not on last page ?>
	</section>
	<?php } //end if total ?>


	<?php 
	}else{
		echo 'Invalid Search';
	} 
	?>
</main>

<?php include('includes/sidebar.php'); ?>
<?php include('includes/footer.php'); ?>