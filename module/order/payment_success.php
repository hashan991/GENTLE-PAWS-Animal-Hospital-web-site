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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="../../css/pay.css">
   
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

    <div class="summary-container">
        <h1>Payment Successful!</h1>
        <p>Your order has been placed successfully.</p>

        <div class="summary-details">
            <p>Order ID: <span><?php echo htmlspecialchars($order['order_id']); ?></span></p>
            <p>Quantity: <span><?php echo htmlspecialchars($order['quantity']); ?></span></p>
            <p>Product Price: <span>Rs. <?php echo number_format($order['product_price'], 2); ?></span></p>
            <p>Delivery: <span>Rs. 0.00</span></p>
            <p>Tax: <span>Rs. 0.00</span></p>
            <p>Status: <span><?php echo htmlspecialchars($order['status']); ?></span></p>
            <p>Payment Method: <span><?php echo htmlspecialchars($order['payment_method']); ?></span></p>
            <p class="summary-total">TOTAL: Rs. <?php echo number_format($order['total_price'], 2); ?></p>
        </div>

        <a href="../product/product.php" class="continue-link">Continue Shopping</a>
    </div>
</body>
</html>
