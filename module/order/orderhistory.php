<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>

<?php 
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_list = '';
$current_user_id = mysqli_real_escape_string($connection, $_SESSION['user_id']);

// Admin sees all orders (assuming user_id 13 is Admin)
if ($current_user_id == 13) {
    $query = "SELECT o.*, p.image AS product_image, p.name AS product_name 
              FROM orders o 
              JOIN product p ON o.product_id = p.p_id 
              ORDER BY o.order_date DESC";
} else {
    // Regular users see only their orders
    $query = "SELECT o.*, p.image AS product_image, p.name AS product_name 
              FROM orders o 
              JOIN product p ON o.product_id = p.p_id 
              WHERE o.user_id = {$current_user_id} 
              ORDER BY o.order_date DESC";
}

$orders = mysqli_query($connection, $query);
verify_query($orders);

while ($order = mysqli_fetch_assoc($orders)) {
    $product_image_path = "../../uploads/" . $order['product_image'];

    $user_list .= "<tr>";
    $user_list .= "<td>{$order['order_id']}</td>";
    $user_list .= "<td><img src='{$product_image_path}' width='80' height='80' alt='Product Image'></td>";  // Display Product Image
    $user_list .= "<td>{$order['product_name']}</td>";  // Display Product Name
    $user_list .= "<td>{$order['quantity']}</td>";
    $user_list .= "<td>Rs. {$order['total_price']}</td>";
    $user_list .= "<td>{$order['status']}</td>";
    $user_list .= "<td>{$order['order_date']}</td>";
    $user_list .= "<td>{$order['customer_name']}</td>";
    $user_list .= "<td>{$order['address']}</td>";
    $user_list .= "<td>{$order['payment_method']}</td>";

    // Allow Edit/Delete for Admin only
    if ($_SESSION['user_id'] == '13') {
        $user_list .= "<td><a href=\"editorder.php?order_id={$order['order_id']}\">Edit</a></td>";
        $user_list .= "<td><a href=\"deleteorder.php?order_id={$order['order_id']}\" 
                            onclick=\"return confirm('Are you sure you want to delete this order?');\">Delete</a></td>";
    }

    $user_list .= "</tr>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
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
                <li><a href="../product/product.php">PRODUCTS</a></li>
                <li><a href="../notice/notice.php">NOTICE</a></li>
            </ul>
        </nav>
        <div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?> | <a href="../../logout.php">Log Out</a></div>
    </div>
</header>

<main>
    <h1>Order History <span><a href="../product/product.php">Products</a> | <a href="book.php">Refresh</a></span></h1>

    <table class="masterlist">
        <tr>
            <th>Order ID</th>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Order Date</th>
            <th>Customer Name</th>
            <th>Address</th>
            <th>Payment Method</th>
            <?php if ($_SESSION['user_id'] == '13'): ?>
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
