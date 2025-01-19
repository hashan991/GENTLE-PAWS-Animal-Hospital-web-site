<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}


$payment_methode = '';

// Get order details
$order_id = isset($_GET['order_id']) ? mysqli_real_escape_string($connection, $_GET['order_id']) : '';
$total_price = isset($_GET['total_price']) ? mysqli_real_escape_string($connection, $_GET['total_price']) : '';

 $order_id = mysqli_real_escape_string($connection, $_GET['order_id']);
    $query = "SELECT * FROM orders WHERE order_id = {$order_id} LIMIT 1";
    $result_set = mysqli_query($connection, $query);

 if ($result_set && mysqli_num_rows($result_set) == 1) {
        $result = mysqli_fetch_assoc($result_set);
        $payment_method = $result['payment_method'];
    } else {
        header('Location: orderhistory.php?err=order_not_found');
        exit;
    }




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = mysqli_real_escape_string($connection, $_POST['order_id']);
    $payment_details = mysqli_real_escape_string($connection, $_POST['payment_details']);

    // Allowed payment methods
    $allowed_methods = ['Pending', 'Bank Transfer', 'Credit Card', 'Cash on Delivery'];

   

    // Determine the status
    //$status = ($payment_method === 'Cash on Delivery') ? 'Pending' : 'Paid';

    // Update the order with payment method and status
    $update_order = "UPDATE orders 
                     SET
                         payment_details = '$payment_details'
                    
                         
                     WHERE order_id = '$order_id'";

    $result = mysqli_query($connection, $update_order);

    if ($result) {
        header("Location: payment_success.php?order_id=$order_id");
        exit;
    } else {
        echo "<h2>Payment Failed!</h2>";
        echo "<p>Error: " . mysqli_error($connection) . "</p>";
        echo "<a href='../../product/product.php'>Back to Products</a>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Page</title>
    <link rel="stylesheet" href="../../css/uadd.css">
   
</head>
<body>

<div class="top-bar">
    <div class="container">
        <p><span>&#128205;</span> No 506/7 Elvitigala Mawatha, Colombo 05, Sri Lanka</p>
        <p><span>&#128222;</span> +94 11 230 3554</p>
        <p><span>&#128231;</span> petsvcare@gmail.com</p>
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
    </div>
</header>

<main>
    <h1>Payment for Order #<?php echo htmlspecialchars($order_id); ?></h1>

    <p>Total Amount to Pay: <strong>Rs. <?php echo htmlspecialchars($total_price); ?></strong></p>

    <form action="" method="post" class="userform">
        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
        <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($total_price); ?>">

      


        <p>
            <label for="payment_details">Payment Details:</label>
            <textarea name="payment_details" id="payment_details" rows="4" placeholder="Enter your payment details"></textarea>
        </p>

        <p>
            <button type="submit">Complete Payment</button>
        </p>
    </form>
</main>

</body>
</html>
