<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>

<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

    $user_list = '';
	

  
    // Default query to fetch all notices
    $query = "SELECT * FROM notice ORDER BY title";


    $users = mysqli_query($connection, $query);
	verify_query($users);

    while ($user = mysqli_fetch_assoc($users)) {
    $user_list .= "<tr>";
    $user_list .= "<td>{$user['title']}</td>";
    $user_list .= "<td>{$user['description']}</td>";
    $user_list .= "<td>{$user['category']}</td>";
    $user_list .= "<td>{$user['audience']}</td>";

    // Show Edit and Delete buttons only for admin (user_id = 13)
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == '13') {
        $user_list .= "<td><a href=\"editNotice.php?notice_id={$user['n_id']}\">Edit</a></td>";
        $user_list .= "<td><a href=\"deleteNotice.php?user_id={$user['n_id']}\" 
                        onclick=\"return confirm('Are you sure?');\">Delete</a></td>";
    }

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
<?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 13): ?>
    <li><a href="../users/users.php">USERS</a></li>
<?php endif; ?>
                    <li><a href="../bookNow/book.php">BOOK NOW</a></li>
                    <li><a href="../product/product.php">PRODUCT</a></li>
                    <li><a href="../notice/notice.php">NOTICE</a></li>
          </ul>
        </nav>
		       		<div class = "loggedin"> welcome <?php echo $_SESSION['first_name'];?> <a href = "../../logout.php">Log Out</a></div>

      </div>

        
    </header>

    <main>

        <h1> Notices <span> 
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 13): ?>
         <a href="addNotice.php" class="action-btn" >+ Add New</a> 
         <?php endif; ?>
        </span></h1>

        

        <table class="masterlist">
           <tr>
    <th>Notice Title</th>
    <th>Notice Description</th>
    <th>Notice Category</th>
    <th>Target Audience</th>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == '13'): ?>
        <th>Edit</th>
        <th>Delete</th>
    <?php endif; ?>
</tr>


            <?php echo $user_list; ?>

        </table>    

            

    </main>    


</body>
</html>
<?php mysqli_close($connection); ?>