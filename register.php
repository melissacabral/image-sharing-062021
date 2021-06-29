<?php 
require('config.php'); 
require_once('includes/functions.php');

//parse the form
require('includes/register-parse.php');

//doctype and visible header
require('includes/header-no-nav.php');
?>
<main class="container important-form">
	<h1>Create an Account</h1>

	<?php display_feedback( $feedback, $feedback_class, $errors ); ?>

	<form method="post" action="register.php">
		<label>Username:</label>
		<input type="text" name="username" value="<?php echo_if_exists($username); ?>">

		<label>Email Address:</label>
		<input type="email" name="email" value="<?php echo_if_exists($email); ?>">

		<label>Password:</label>
		<input type="password" name="password" value="<?php echo_if_exists($password); ?>">

		<label>
			<input type="checkbox" name="policy" value="1" <?php checked( $policy, 1 ); ?>>
			I agree to the <a href="#" target="_blank">terms of use and privacy policy</a>
		</label>

		<input type="submit" value="Sign Up">
		<input type="hidden" name="did_register" value="1">
	</form>
</main>

<?php include('includes/footer.php'); ?>