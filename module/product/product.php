<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	$user_list = '';
	

	$query = "SELECT * FROM product ORDER BY p_id DESC";
	
	$users = mysqli_query($connection, $query);

	verify_query($users);

	while ($user = mysqli_fetch_assoc($users)) {

        $imagePath = "../../uploads/" . $user['image'];

		$user_list .= "<tr>";
		$user_list .= "<td><img src='{$imagePath}' width='100' height='100'></td>";
		$user_list .= "<td>{$user['name']}</td>";
		$user_list .= "<td>{$user['price']}</td>";
        $user_list .= "<td>{$user['stock']}</td>";
		$user_list .= "<td>{$user['description']}</td>";
		$user_list .= "<td><a href=\"editproduct.php?user_id={$user['p_id']}\">Edit</a></td>";
		$user_list .= "<td><a href=\"deleteproduct.php?user_id={$user['p_id']}\" 
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
            <li><a href="../users/users.php">USERS</a></li>
            <li><a href="../bookNow/book.php">BOOK NOW</a></li>
            <li><a href="../product/product.php">PRODUCT</a></li>
            <li><a href=../notice/notice.php>NOTICE</a></li>
          </ul>
        </nav>
		       		<div class = "loggedin"> welcome <?php echo $_SESSION['first_name'];?> <a href = "../../logout.php">Log Out</a></div>

      </div>

        
    </header>

    <main>

        <h1> USERS <span> <a href = "addproduct.php"> + add new </a> | <a href="product.php">Refresh</a></span></h1>

       

        <table class="masterlist">
            <tr>
                 <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Description</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>


            <?php echo $user_list; ?>

        </table>    

            

    </main>    


</body>
</html>
<?php mysqli_close($connection); ?>