<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>
<?php 
	// Checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	$errors = array();
	$user_id = '';
	$first_name = '';
	$last_name = '';
	$email = '';

	if (isset($_GET['user_id'])) {
		// Getting the user information
		$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
		$query = "SELECT * FROM user WHERE id = {$user_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set && mysqli_num_rows($result_set) == 1) {
			$result = mysqli_fetch_assoc($result_set);
			$first_name = $result['first_name'];
			$last_name = $result['last_name'];
			$email = $result['email'];
		} else {
			header('Location: users.php?err=user_not_found');	
		}
	}

	if (isset($_POST['submit'])) {
		$user_id = $_POST['user_id'];
		$password = $_POST['password'];

		// Required field validation
		$req_fields = array('user_id', 'password');
		$errors = array_merge($errors, check_req_fields($req_fields));

		if (empty($errors)) {
			$password = mysqli_real_escape_string($connection, $_POST['password']);
			$hashed_password = sha1($password);

			$query = "UPDATE user SET password = '{$hashed_password}' WHERE id = {$user_id} LIMIT 1";

			if (mysqli_query($connection, $query)) {
				header('Location: users.php?user_modified=true');
			} else {
				$errors[] = 'Failed to update the password.';
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Change Password</title>
	<link rel="stylesheet" href="../../css/uchangepassword.css">
</head>
<body>

<!-- Top Bar -->
<div class="top-bar">
  <div class="container">
    <p><span>&#128205;</span> No 506/7 Elvitigala Mawatha, Colombo 05, Sri Lanka</p>
    <p><span>&#128222;</span> +94 11 230 3554</p>
    <p><span>&#128231;</span> petsvcare@gmail.com</p>
    <p><span>&#128337;</span> 08:30 AM - 10:00 PM</p>
  </div>
</div>

<!-- Navigation Header -->
<header class="main-header">
  <div class="container">
    <nav class="main-nav">
      <ul>
        <li><a href="../../home.php">HOME</a></li>
        <li><a href="users.php">USERS</a></li>
        <li><a href="#">BOOK NOW</a></li>
        <li><a href="#">PRODUCT</a></li>
        <li><a href="#">NOTICE</a></li>
        <li><a href="#">FEEDBACK</a></li>
        <li><a href="../../logout.php">LOG OUT</a></li>
      </ul>
    </nav>
    <div class="loggedin">Welcome, <?php echo $_SESSION['first_name']; ?> | <a href="../../logout.php">Logout</a></div>
  </div>
</header>

<main>
  <div class="form-container">
    <h1>🔒 Change Password</h1>
    <a href="users.php" class="back-link">← Back to User List</a>

    <?php if (!empty($errors)) { display_errors($errors); } ?>

    <form action="change-password.php" method="post" class="password-form">
      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

      <div class="form-group">
        <label>First Name:</label>
        <input type="text" value="<?php echo $first_name; ?>" disabled>
      </div>

      <div class="form-group">
        <label>Last Name:</label>
        <input type="text" value="<?php echo $last_name; ?>" disabled>
      </div>

      <div class="form-group">
        <label>Email Address:</label>
        <input type="email" value="<?php echo $email; ?>" disabled>
      </div>

      <div class="form-group">
        <label>New Password:</label>
        <input type="password" name="password" id="password" required placeholder="Enter New Password">
      </div>

      <div class="form-group checkbox">
        <input type="checkbox" id="showPassword">
        <label for="showPassword">Show Password</label>
      </div>

      <button type="submit" name="submit" class="btn">Update Password</button>
    </form>
  </div>
</main>

<script>
  // Show/Hide Password Script
  document.getElementById('showPassword').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
  });
</script>

</body>
</html>
