<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

    $errors = array();
	$title = '';
	$description = '';
	$category = '';
	$audience = '';
	
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
		$description = $_POST['description'];
		$category = $_POST['category'];
		$audience = $_POST['audience'];

		

            if (empty($errors)) {
                $title = mysqli_real_escape_string($connection, $_POST['title']);
                $description = mysqli_real_escape_string($connection, $_POST['description']);
                $category = mysqli_real_escape_string($connection, $_POST['category']);
                $audience = mysqli_real_escape_string($connection, $_POST['audience']);


              $query = "INSERT INTO notice (title, description, category, audience) 
			   VALUES ('{$title}', '{$description}', '{$category}', '{$audience}')";
	
                $result = mysqli_query($connection, $query);
                if ($result) {
                    header('Location: notice.php');
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
	<title>Add New Notice</title>
	<link rel="stylesheet" href="../../css/uadd.css">
</head>
<body>
		<div class="top-bar">
      <div class="container">
        <p>
          <span>&#128205;</span> No 506/7 Elvitigala Mawatha, Colombo 05, Sri
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
		<h1>Add New Notice<span> <a href="notice.php">< Back to User List</a></span></h1>

		<?php 

			if (!empty($errors)) {
				display_errors($errors);
			}

		 ?>

		<form action="addNotice.php" method="post" class="userform">
			
			<p>
				<label for="">Notice Title </label>
				<input type="text" name="title" <?php echo 'value="' . $title . '"'; ?>>
			</p>

			<p>
				<label for="">Notice Description</label>
				<input type="text" name="description" <?php echo 'value="' . $description . '"'; ?>>
			</p>

			<p>
				<label for="">Notice Category </label>
				<input type="text" name="category" <?php echo 'value="' . $category . '"'; ?>>
			</p>

			
			<p>
				<label for="">Target Audience</label>
				<input type="text" name="audience" <?php echo 'value="' . $audience . '"'; ?>>
			</p>

			

			<p>
				<label for="">&nbsp;</label>
				<button type="submit" name="submit">Save</button>
			</p>

		</form>

		
		
	</main>
</body>
</html>