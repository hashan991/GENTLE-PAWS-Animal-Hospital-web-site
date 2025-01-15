<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>

<?php 
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
    }




    $user_list = '';
    $current_user_id = $_SESSION['user_id'];  // Get logged-in user's ID




     if ($current_user_id == 13) {
        // Admin sees all bookings
        $query = "SELECT * FROM booking ORDER BY date, time";
    } else {
        // Other users see only their own bookings
        $query = "SELECT * FROM booking WHERE user_id = {$current_user_id} ORDER BY date, time";
    }



    
    $users = mysqli_query($connection, $query);
    verify_query($users);



    while ($user = mysqli_fetch_assoc($users)) {
        $user_list .= "<tr>";
        $user_list .= "<td>{$user['name']}</td>";
        $user_list .= "<td>{$user['number']}</td>";
        $user_list .= "<td>{$user['service']}</td>";
        $user_list .= "<td>{$user['type']}</td>";
        $user_list .= "<td>{$user['date']}</td>";
        $user_list .= "<td>{$user['time']}</td>";

        // Show Edit and Delete buttons only to the user who made the booking
        $user_list .= "<td><a href=\"editbook.php?notice_id={$user['b_id']}\">Edit</a></td>";
        $user_list .= "<td><a href=\"deletebook.php?user_id={$user['b_id']}\" 
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

        <h1> USERS <span> <a href = "addbook.php"> + add new </a> | <a href="book.php">Refresh</a></span></h1>

       

        <table class="masterlist">
            <tr>
                <th>full Name:</th>
                <th>contact number</th>
                <th>Type of Service</th>
                <th>pet type</th>
                <th>Date</th>
                <th>Time</th>
                <th>edit</th>
                <th>delete</th>
            </tr>


            <?php echo $user_list; ?>

        </table>    

            

    </main>    


</body>
</html>
<?php mysqli_close($connection); ?>