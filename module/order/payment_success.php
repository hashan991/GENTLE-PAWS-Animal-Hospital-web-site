<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Get order_id from URL
if (isset($_GET['order_id'])) {
    $order_id = mysqli_real_escape_string($connection, $_GET['order_id']);

    // Fetch order details
    $query = "SELECT * FROM orders WHERE order_id = {$order_id} LIMIT 1";
    $result_set = mysqli_query($connection, $query);

    if ($result_set && mysqli_num_rows($result_set) == 1) {
        $order = mysqli_fetch_assoc($result_set);
    } else {
        echo "<h2>Order Not Found!</h2>";
        echo "<a href='../product/product.php'>Continue Shopping</a>";
        exit;
    }
} else {
    echo "<h2>Invalid Order ID!</h2>";
    echo "<a href='../product/product.php'>Continue Shopping</a>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="../../css/uadd.css">
</head>
<body>

<h1>Payment Successful!</h1>
<p>Your order has been successfully placed and paid.</p>

<!-- Displaying Order Details -->
<h2>Order Details</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Order ID</th>
        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
    </tr>
    <tr>
        <th>Quantity</th>
        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
    </tr>
    <tr>
        <th>Product Price</th>
        <td>Rs. <?php echo number_format($order['product_price'], 2); ?></td>
    </tr>
    <tr>
        <th>Total Price</th>
        <td>Rs. <?php echo number_format($order['total_price'], 2); ?></td>
    </tr>
    <tr>
        <th>Status</th>
        <td><?php echo htmlspecialchars($order['status']); ?></td>
    </tr>
    <tr>
        <th>Order Date</th>
        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
    </tr>
    <tr>
        <th>Customer Name</th>
        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
    </tr>
    <tr>
        <th>Address</th>
        <td><?php echo htmlspecialchars($order['address']); ?></td>
    </tr>
    <tr>
        <th>Payment Method</th>
        <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
    </tr>
</table>

<!-- Link to continue shopping -->
<p><a href="../product/product.php">Continue Shopping</a></p>

</body>
</html>
