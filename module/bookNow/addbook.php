<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}


    $errors = array();
	$name = '';
	$number = '';
	$service = '';
	$type = '';
	$date = '';
	$time = '';

    if (isset($_POST['submit'])) {

		$name = $_POST['name'];
		$number = $_POST['number'];
		$service = $_POST['service'];
		$type = $_POST['type'];
		$date = $_POST['date'];
		$time = $_POST['time'];
		$user_id = $_SESSION['user_id'];  // Get logged-in user ID

		// checking required fields		
		
		// checking if email address already exists


		

		

		if (empty($errors)) {
			// no errors found... adding new record
			$name = mysqli_real_escape_string($connection, $_POST['name']);
			$number = mysqli_real_escape_string($connection, $_POST['number']);
			$service = mysqli_real_escape_string($connection, $_POST['service']);
			$type = mysqli_real_escape_string($connection, $_POST['type']);
			$date = mysqli_real_escape_string($connection, $_POST['date']);
			$time = mysqli_real_escape_string($connection, $_POST['time']);

			  $query = "INSERT INTO booking (name, number, service, type, date, time, user_id) 
                  VALUES ('{$name}', '{$number}', '{$service}', '{$type}', '{$date}', '{$time}', '{$user_id}')";
			$result = mysqli_query($connection, $query);
			if ($result) {
				header('Location: book.php');
			} else {
				echo 'Database query failed.';
			}

		}
	}




?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add New User</title>
	<link rel="stylesheet" href="../../css/uadd.css">
</head>
<body>
		<div class="top-bar">
      <div class="container">
        <p>
          <span>&#128205;</span> No 506 Elvitigala Mawatha, Colombo 05, Sri
          Lanka
        </p>
        <p><span>&#128222;</span> +94 11 230 3554</p>
        <p><span>&#128231;</span> petsvcare@gmail.com</p>
        <p><span>&#128337;</span> 08:30 AM - 10:00 PM</p>
      </div>
    </div>
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
		       		<div class = "loggedin"> welcome <?php echo $_SESSION['first_name'];?> <a href = "../../logout.php">Log Out</a></div>

      </div>

        
    </header>

	<main>
		<h1>Add New User<span> <a href="book.php">< Back to User List</a></span></h1>

		<?php 

			if (!empty($errors)) {
				display_errors($errors);
			}

		 ?>

		<form action="addbook.php" method="post" class="userform">
			
			<p>
				<label for="">full Name:</label>
				<input type="text" name="name" <?php echo 'value="' . $name . '"'; ?>>
			</p>

			<p>
				<label for="">contact number</label>
				<input type="text" name="number" <?php echo 'value="' . $number . '"'; ?>>
			</p>

			<p>
				<label for="">Type of Service </label>
				<input type="text" name="service" <?php echo 'value="' . $service . '"'; ?>>
			</p>

			
			<p>
				<label for="">pet type</label>
				<input type="text" name="type" <?php echo 'value="' . $type . '"'; ?>>
			</p>

			
			<p>
				<label for="">Date</label>
				<input type="text" name="date" <?php echo 'value="' . $date . '"'; ?>>
			</p>

			
			<p>
				<label for="">Time</label>
				<input type="text" name="time" <?php echo 'value="' . $time . '"'; ?>>
			</p>

			<p>
				<label for="">&nbsp;</label>
				<button type="submit" name="submit">Save</button>
			</p>

		</form>

		
		
	</main>
</body>
</html>