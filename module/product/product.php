<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>

<?php 
// Checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

$user_list = '';

// Query to fetch product data
$query = "SELECT * FROM product ORDER BY p_id DESC";
$products = mysqli_query($connection, $query);
verify_query($products);

while ($product = mysqli_fetch_assoc($products)) {
    $imagePath = "../../uploads/" . $product['image'];

    $user_list .= "<tr>";
    $user_list .= "<td><img src='{$imagePath}' width='100' height='100' alt='Product Image'></td>";
    $user_list .= "<td>{$product['name']}</td>";
    $user_list .= "<td>{$product['price']}</td>";
    $user_list .= "<td>{$product['stock']}</td>";
    $user_list .= "<td>{$product['description']}</td>";

    // "Buy Now" button redirects to order_now.php with the product ID
    $user_list .= "<td>
                    <form action='../order/order_now.php' method='get'>
                        <input type='hidden' name='product_id' value='{$product['p_id']}'>
                        <button type='submit'>Buy Now</button>
                    </form>
                  </td>";

    // Show Edit/Delete options only for Admin (user_id = 13)
    if ($_SESSION['user_id'] == 13) {
        $user_list .= "<td><a href=\"editproduct.php?product_id={$product['p_id']}\">Edit</a></td>";
        $user_list .= "<td><a href=\"deleteproduct.php?user_id={$product['p_id']}\" 
                        onclick=\"return confirm('Are you sure you want to delete this product?');\">Delete</a></td>";
    }

    $user_list .= "</tr>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="../../css/utable.css">
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
                <li><a href="../users/users.php">USERS</a></li>
                <li><a href="../bookNow/book.php">BOOK NOW</a></li>
                <li><a href="../product/product.php">PRODUCT</a></li>
                <li><a href="../notice/notice.php">NOTICE</a></li>
            </ul>
        </nav>
        <div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?> | <a href="../../logout.php">Log Out</a></div>
    </div>
</header>

<main>
    <h1>PRODUCT LIST 
        <span>
            <?php if ($_SESSION['user_id'] == 13): ?>
                <a href="addproduct.php" class="action-btn">+ Add New</a>
            <?php endif; ?>
             <a href="../order/orderhistory.php" class="action-btn">MY orders</a>
            <a href="product.php" class="action-btn">Refresh</a>
        </span>
    </h1>

    <table class="masterlist">
        <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Description</th>
            <th>Buy Now</th>
            <?php if ($_SESSION['user_id'] == 13): ?>
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
