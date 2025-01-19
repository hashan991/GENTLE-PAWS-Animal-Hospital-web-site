<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$product = null;
$product_id = '';
$errors = [];

// Fetch product details if product_id is passed
if (isset($_GET['product_id'])) {
    $product_id = mysqli_real_escape_string($connection, $_GET['product_id']);

    $product_query = "SELECT * FROM product WHERE p_id = {$product_id}";
    
    $product_result = mysqli_query($connection, $product_query);
    $product = mysqli_fetch_assoc($product_result);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = mysqli_real_escape_string($connection, $_POST['product_id']);
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $customer_name = mysqli_real_escape_string($connection, $_POST['customer_name']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $payment_method = mysqli_real_escape_string($connection, $_POST['payment_method']);
    $user_id = $_SESSION['user_id'];

    // Fetch product details again for price calculation
    $product_query = "SELECT * FROM product WHERE p_id = {$product_id}";
    $product_result = mysqli_query($connection, $product_query);
    $product = mysqli_fetch_assoc($product_result);

    if ($product && $product['stock'] >= $quantity) {
        $product_price = $product['price'];
        $total_price = $product_price * $quantity;

        // Insert order with status 'Pending'
        $order_query = "INSERT INTO orders (user_id, product_id, quantity, product_price, total_price, status, customer_name, address , payment_method) 
                        VALUES ('$user_id', '$product_id', '$quantity', '$product_price', '$total_price', 'Pending', '$customer_name', '$address' , '$payment_method')";
        $order_result = mysqli_query($connection, $order_query);

        if ($order_result) {
            $order_id = mysqli_insert_id($connection); // Get the last inserted order ID

            // Decrease product stock
            $update_stock = "UPDATE product SET stock = stock - $quantity WHERE p_id = {$product_id}";
            mysqli_query($connection, $update_stock);

            // Redirect to payment page with order ID and total price
            // Redirect based on payment method
          if ($payment_method === 'Cash on Delivery' || $payment_method === 'Bank Transfer') {
                // Redirect to payment_success.php for Cash on Delivery or Bank Transfer
             header("Location: payment_success.php?order_id={$order_id}");
                exit();
            } else {
                // Redirect to payment.php for Credit Card
                header("Location: payment.php?order_id={$order_id}&total_price={$total_price}");
                exit();
            }

        } else {
            echo "<h2>Order Failed!</h2>";
            echo "<p>There was a problem placing your order. Please try again.</p>";
            echo "<a href='../../product/product.php'>Back to Products</a>";
        }
    } else {
        echo "<h2>Order Failed!</h2>";
        echo "<p>Sorry, the product is out of stock or the quantity is invalid.</p>";
        echo "<a href='../../product/product.php'>Back to Products</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Your Order</title>
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
                <li><a href="../product/product.php">PRODUCTS</a></li>
                <li><a href="../../logout.php">LOG OUT</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <h1>Place Your Order</h1>

    <?php if ($product): ?>
        <div style="display: flex; align-items: center;">
            <img src="../../uploads/<?php echo $product['image']; ?>" width="150" height="150" alt="Product Image">
            <div style="margin-left: 20px;">
                <h2><?php echo $product['name']; ?></h2>
                <p>Price: Rs. <?php echo $product['price']; ?></p>
                <p>Available Stock: <?php echo $product['stock']; ?></p>
            </div>
        </div>

        <form action="order_now.php" method="post" class="userform">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

            <p>
                <label for="customer_name">Your Name:</label>
                <input type="text" name="customer_name" required>
            </p>

            <p>
                <label for="address">Delivery Address:</label>
                <textarea name="address" rows="3" required></textarea>
            </p>

            <p>
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" min="1" max="<?php echo $product['stock']; ?>" required>
            </p>

            <p>
                <label for="payment_method">Select Payment Method:</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Cash on Delivery">Cash on Delivery</option>
                </select>
            </p>
            <p>
                <button type="submit">Place Order</button>
            </p>
        </form>
    <?php else: ?>
        <h2>Product not found!</h2>
        <a href="../../product/product.php">Back to Products</a>
    <?php endif; ?>
</main>

</body>
</html>
