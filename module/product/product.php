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

// Ensure there are products in the database
if (mysqli_num_rows($products) == 0) {
    $products = null; // No products available
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="../../css/uptable.css">
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
<?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 13): ?>
    <li><a href="../users/users.php">USERS</a></li>
<?php endif; ?>
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
                <a href="addproduct.php" class="action-btn">+ Add Product</a>
            <?php endif; ?>
             <a href="../order/orderhistory.php" class="action-btn">MY orders</a>
        </span>
    </h1>

    <div class="product-grid">
        <?php while ($product = mysqli_fetch_assoc($products)): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="../../uploads/<?php echo $product['image']; ?>" alt="Product Image">
                </div>
                <div class="product-info">
                    <h2><?php echo $product['name']; ?></h2>
                    <p class="product-price">Rs. <?php echo $product['price']; ?></p>
                    <p class="product-stock">Stock: <?php echo $product['stock']; ?></p>
                    <p class="product-description"><?php echo $product['description']; ?></p>
                </div>
                <div class="product-actions">
                    <form action="../order/order_now.php" method="get">
                        <input type="hidden" name="product_id" value="<?php echo $product['p_id']; ?>">
                        <button type="submit" class="btn buy-btn">Buy Now</button>
                    </form>
                    <?php if ($_SESSION['user_id'] == 13): ?>
                        <a href="editproduct.php?product_id=<?php echo $product['p_id']; ?>" class="btn edit-btn">Edit</a>
                        <a href="deleteproduct.php?user_id=<?php echo $product['p_id']; ?>" 
                           class="btn delete-btn"
                           onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

</body>
</html>

<?php mysqli_close($connection); ?>
