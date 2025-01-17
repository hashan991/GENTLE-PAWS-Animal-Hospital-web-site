<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Get order details
$order_id = isset($_GET['order_id']) ? mysqli_real_escape_string($connection, $_GET['order_id']) : '';
$total_price = isset($_GET['total_price']) ? mysqli_real_escape_string($connection, $_GET['total_price']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = mysqli_real_escape_string($connection, $_POST['order_id']);
    $payment_method = mysqli_real_escape_string($connection, $_POST['payment_method']);
    $payment_details = mysqli_real_escape_string($connection, $_POST['payment_details']);

    // Allowed payment methods
    $allowed_methods = ['Pending', 'Bank Transfer', 'Credit Card', 'Cash on Delivery'];

    // Validate payment method
    if (!in_array($payment_method, $allowed_methods)) {
        echo "<h2>Invalid Payment Method!</h2>";
        exit;
    }

    // Determine the status
    //$status = ($payment_method === 'Cash on Delivery') ? 'Pending' : 'Paid';

    // Update the order with payment method and status
    $update_order = "UPDATE orders 
                     SET payment_method = '$payment_method', 
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
    <script>
        // Show/Hide payment details based on payment method
        function togglePaymentDetails() {
            const paymentMethod = document.getElementById("payment_method").value;
            const paymentDetails = document.getElementById("payment_details");

            if (paymentMethod === "Credit Card" || paymentMethod === "Bank Transfer") {
                paymentDetails.required = true;
                paymentDetails.placeholder = "Enter your payment details (e.g., card number, bank info)";
                paymentDetails.disabled = false;
            } else {
                paymentDetails.required = false;
                paymentDetails.placeholder = "No details required for Cash on Delivery";
                paymentDetails.disabled = true;
                paymentDetails.value = "";  // Clear the field if disabled
            }
        }

        window.onload = function() {
            togglePaymentDetails();  // Initialize on page load
        };
    </script>
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
                <li><a href="../product/product.php">PRODUCTS</a></li>
                <li><a href="../../logout.php">LOG OUT</a></li>
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
            <label for="payment_method">Select Payment Method:</label>
            <select name="payment_method" id="payment_method" onchange="togglePaymentDetails()" required>
                <option value="Credit Card">Credit Card</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Cash on Delivery">Cash on Delivery</option>
            </select>
        </p>

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
