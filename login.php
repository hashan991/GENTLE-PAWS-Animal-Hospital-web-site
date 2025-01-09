<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 

	// check for form submission
	if (isset($_POST['submit'])) {

		$errors = array();

		// check if the username and password has been entered
		if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1 ) {
			$errors[] = 'Username is Missing / Invalid';
		}

		if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1 ) {
			$errors[] = 'Password is Missing / Invalid';
		}

		// check if there are any errors in the form
		if (empty($errors)) {
			// save username and password into variables
			$email 		= mysqli_real_escape_string($connection, $_POST['email']);
			$password 	= mysqli_real_escape_string($connection, $_POST['password']);
			$hashed_password = sha1($password);

			// prepare database query
			$query = "SELECT * FROM user 
						WHERE email = '{$email}' 
						AND password = '{$hashed_password}' 
						LIMIT 1";

			$result_set = mysqli_query($connection, $query);

			verify_query($result_set);
				// query succesfful

				if (mysqli_num_rows($result_set) == 1) {
					// valid user found
					$user = mysqli_fetch_assoc($result_set);
					$_SESSION['user_id'] = $user['id'];
					$_SESSION['first_name'] = $user['first_name'];

					// updating last login
				$query = "UPDATE user SET last_login = NOW() ";
				$query .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";

				$result_set = mysqli_query($connection, $query);

				verify_query($result_set); 



					// redirect to users.php
					header('Location: home.php');
				} else {
					// user name and password invalid
					$errors[] = 'Invalid Username / Password';
				}
			
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Log In - User Management System</title>
	<link rel="stylesheet" href="css/style1.css">
</head>

<body>
	<div class="login-container">
<div class="login-container">
    <!-- Left Section -->
    <div class="login-left">
			
      		<h2>Welcome Back</h2>
      		<p>Thank you for getting back, please login to your account by filling these forms:</p>
		<form action="login.php" method="post">
			
		
		
				

				<?php 
					  if (isset($errors) && !empty($errors)) {
						echo '<p class="error">Invalid Username / Password</p>';
					}
				                         ?>

				<?php
					if (isset($_GET['logout'])){
						echo '<p class = "info"> you have successfully logged out from the system</p>';
					}
				?>

				 <div class="input-group">
					<label for="email">Email Address</label>
					<input type="email" id="email" name="email" placeholder="coolname@name.com" required>
                </div>
                <div class="input-group">
						<label for="password">Password</label>
						<input type="password" id="password" name="password" placeholder="************" required>
                 </div>
				 <div class="buttons">
          			<button type="submit" name ="submit" class="btn login-btn">Login</button>
         			 <button type="button" class="btn signup-btn">Sign Up</button>
      			  </div>

			

		</form>		
	</div>
	<div class="login-right">
      <div class="overlay">
        <h1>THE <span>GENTLE PAWS</span></h1>
        <p> Animal Hospitals</p>
      </div>
    </div>
</div> <!-- .login -->
</body>
</html>
<?php mysqli_close($connection); ?>