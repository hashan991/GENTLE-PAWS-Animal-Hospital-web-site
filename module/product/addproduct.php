<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

$errors = array();
$name = '';
$price = '';
$stock = '';
$description = '';

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $price = mysqli_real_escape_string($connection, $_POST['price']);
    $stock = mysqli_real_escape_string($connection, $_POST['stock']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);

     // Image Upload
    $target_dir = "../../uploads/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        $errors[] = "File is not an image.";
    }

    // Allow only certain file types
    $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        $errors[] = "Only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // Upload image if no errors
    if (empty($errors) && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $query = "INSERT INTO product (name, price, stock, description, image)
                  VALUES ('{$name}', '{$price}', '{$stock}', '{$description}', '{$image_name}')";

        $result = mysqli_query($connection, $query);

        if ($result) {
            header('Location: product.php?product_added=true');
        } else {
            $errors[] = "Failed to add product.";
        }
    } else {
        $errors[] = "Failed to upload image.";
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Product</title>
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
    <h1>Add New Product <span><a href="product.php">← Back to Product List</a></span></h1>

    <?php if (!empty($errors)) display_errors($errors); ?>

    <form action="addproduct.php" method="post" enctype="multipart/form-data" class="userform">
        <p><label for="">Product Name:</label>
           <input type="text" name="name" value="<?php echo $name; ?>"></p>

        <p><label for="">Price:</label>
           <input type="text" name="price" value="<?php echo $price; ?>"></p>

        <p><label for="">Stock Quantity:</label>
           <input type="number" name="stock" value="<?php echo $stock; ?>"></p>

        <p><label for="">Description:</label>
           <textarea name="description"><?php echo $description; ?></textarea></p>

        <p><label for="">Product Image:</label>
           <input type="file" name="image"></p>

        <p><button type="submit" name="submit">Save Product</button></p>
    </form>
</main>

</body>
</html>