<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>

<?php 
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

$errors = [];

// Fetch existing product details
if (isset($_GET['product_id'])) {
    $product_id = mysqli_real_escape_string($connection, $_GET['product_id']);
    $query = "SELECT * FROM product WHERE p_id = {$product_id} LIMIT 1";
    $result_set = mysqli_query($connection, $query);

    verify_query($result_set);

    if (mysqli_num_rows($result_set) == 1) {
        $product = mysqli_fetch_assoc($result_set);
    } else {
        header('Location: product.php?err=product_not_found');
    }
}

// Handle form submission
if (isset($_POST['submit'])) {
    $product_id = $_POST['product_id'];
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $price = mysqli_real_escape_string($connection, $_POST['price']);
    $stock = mysqli_real_escape_string($connection, $_POST['stock']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $product_image = $product['image'];  // Keep the old image by default

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../../uploads/";
        $image_name = uniqid() . "_" . basename($_FILES['image']['name']);  // Unique filename
        $target_file = $target_dir . $image_name;

        // Validate file type
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];

        if (in_array($imageFileType, $allowed_types)) {
            // Move the uploaded file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $product_image = $image_name;  // Only save the filename
            } else {
                $errors[] = "Error uploading the image.";
            }
        } else {
            $errors[] = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    // Update product details
    if (empty($errors)) {
        $query = "UPDATE product SET 
                  name = '{$name}', 
                  price = '{$price}', 
                  stock = '{$stock}', 
                  description = '{$description}', 
                  image = '{$product_image}' 
                  WHERE p_id = {$product_id} LIMIT 1";

        $result = mysqli_query($connection, $query);

        if ($result) {
            header('Location: product.php?product_updated=true');
        } else {
            $errors[] = "Failed to update the product.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../../css/uadd.css">
</head>
<body>

<div class="top-bar">
    <div class="container">
        <p><span>&#128205;</span> No 506/7 Elvitigala Mawatha, Colombo 05, Sri Lanka</p>
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
                <li><a href="notice.php">NOTICE</a></li>
                <li><a href="#">FEEDBACK</a></li>
                <li><a href="../../logout.php">LOG OUT</a></li>
            </ul>
        </nav>
        <div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?> | <a href="../../logout.php">Log Out</a></div>
    </div>
</header>

<main>
    <h1>Edit Product <span><a href="product.php">← Back to Product List</a></span></h1>

    <?php if (!empty($errors)) display_errors($errors); ?>

    <form action="editproduct.php?product_id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data" class="userform">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

        <p>
            <label for="">Product Name:</label>
            <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
        </p>

        <p>
            <label for="">Price:</label>
            <input type="text" name="price" value="<?php echo $product['price']; ?>" required>
        </p>

        <p>
            <label for="">Stock:</label>
            <input type="text" name="stock" value="<?php echo $product['stock']; ?>" required>
        </p>

        <p>
            <label for="">Description:</label>
            <textarea name="description" required><?php echo $product['description']; ?></textarea>
        </p>

        <p>
            <label for="">Current Image:</label><br>
            <?php if (!empty($product['image'])): ?>
                <img src="../../uploads/<?php echo $product['image']; ?>" width="150px"><br>
            <?php else: ?>
                <span>No image uploaded.</span>
            <?php endif; ?>
        </p>

        <p>
            <label for="">Upload New Image:</label>
            <input type="file" name="image">
        </p>

        <p>
            <button type="submit" name="submit">Update Product</button>
        </p>
    </form>
</main>

</body>
</html>
