<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	$user_list = '';
	$search = '';

	// getting the list of users
	if ( isset($_GET['search']) ) {
		$search = mysqli_real_escape_string($connection, $_GET['search']);
		$query = "SELECT * FROM user WHERE (first_name LIKE '%{$search}%' OR last_name LIKE '%{$search}%' OR email LIKE '%{$search}%') AND is_deleted=0 ORDER BY first_name";					
	} else {
		$query = "SELECT * FROM user WHERE is_deleted=0 ORDER BY first_name";
	}
	
	$users = mysqli_query($connection, $query);

	verify_query($users);

	while ($user = mysqli_fetch_assoc($users)) {
		$user_list .= "<tr>";
		$user_list .= "<td>{$user['first_name']}</td>";
		$user_list .= "<td>{$user['last_name']}</td>";
		$user_list .= "<td>{$user['last_login']}</td>";
		$user_list .= "<td><a href=\"modify-user.php?user_id={$user['id']}\">Edit</a></td>";
		$user_list .= "<td><a href=\"delete-user.php?user_id={$user['id']}\" 
						onclick=\"return confirm('Are you sure?');\">Delete</a></td>";
		$user_list .= "</tr>";
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>users</title>
    
	 <link rel="stylesheet" href="../../css/utable.css">
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

        <h1> USERS <span> <a href = "add-user.php"> + add new </a> | <a href="users.php">Refresh</a></span></h1>

        <div class="search">
			<form action="users.php" method="get">
				<p>
					<input type="text" name="search" id="" placeholder="Type First Name, Last Name or Email Address and Press Enter" value="<?php echo $search; ?>" required autofocus>
				</p>
			</form>
		</div>

        <table class="masterlist">
            <tr>
                <th>First Name</th>
                <th>last Name</th>
                <th>last login</th>
                <th>edit</th>
                <th>delete</th>
            </tr>


            <?php echo $user_list; ?>

        </table>    

            

    </main>    


</body>
</html>
<?php mysqli_close($connection); ?>