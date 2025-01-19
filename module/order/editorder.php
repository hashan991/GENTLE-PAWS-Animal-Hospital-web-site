<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>

<?php 
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$errors = array();
$order_id = '';
$quantity = '';
$product_price = '';
$total_price = '';
$status = '';
$customer_name = '';
$address = '';
$payment_method = '';

// Fetch order details
if (isset($_GET['order_id'])) {
    $order_id = mysqli_real_escape_string($connection, $_GET['order_id']);
    $query = "SELECT * FROM orders WHERE order_id = {$order_id} LIMIT 1";
    $result_set = mysqli_query($connection, $query);

    if ($result_set && mysqli_num_rows($result_set) == 1) {
        $result = mysqli_fetch_assoc($result_set);
        $quantity = $result['quantity'];
        $product_price = $result['product_price']; 
        $total_price = $result['total_price'];
        $status = $result['status'];
        $customer_name = $result['customer_name'];
        $address = $result['address'];
        $payment_method = $result['payment_method'];
    } else {
        header('Location: orderhistory.php?err=order_not_found');
        exit;
    }
}

// Updating the order
if (isset($_POST['submit'])) {
    $order_id = mysqli_real_escape_string($connection, $_POST['order_id']);
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $product_price = mysqli_real_escape_string($connection, $_POST['product_price']);
    $total_price = mysqli_real_escape_string($connection, $_POST['total_price']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);
    $customer_name = mysqli_real_escape_string($connection, $_POST['customer_name']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $payment_method = mysqli_real_escape_string($connection, $_POST['payment_method']);

    
        // Validate input   
$total_price = (float)$product_price * (int)$quantity;


    // Check for errors
    if (empty($errors)) {
        $query = "UPDATE orders SET 
                    quantity = '{$quantity}', 
                    total_price = '{$total_price}', 
                      order_date = NOW(),  -- Automatically updates to current date
                    status = '{$status}', 
                    customer_name = '{$customer_name}', 
                    address = '{$address}',
                    payment_method = '{$payment_method}'
                  WHERE order_id = '{$order_id}' LIMIT 1";

        $result = mysqli_query($connection, $query);

        if ($result) {
            // Redirect to payment page with order ID and total price
            header("Location: payment_success.php?order_id={$order_id}&total_price={$total_price}");
            exit;
        } else {
            $errors[] = 'Failed to update the order. Error: ' . mysqli_error($connection);
        }
    }
}
?>















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Notice</title>
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
<?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 13): ?>
    <li><a href="../users/users.php">USERS</a></li>
<?php endif; ?>
                <li><a href="../bookNow/book.php">BOOK NOW</a></li>
                <li><a href="../product/product.php">PRODUCTS</a></li>
                <li><a href="../notice/notice.php">NOTICE</a></li>
                </ul>
            </nav>
            <div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?> | <a href="../../logout.php">Log Out</a></div>
        </div>
    </header>

    <main>
        <h1>Edit Order <span><a href="orderhistory.php" class="action-btn" >←  Order List</a></span></h1>

        <?php 
            if (!empty($errors)) {
                display_errors($errors);
            }
        ?>

        <form action="editorder.php" method="post" class="userform">
            <!-- Hidden Field for Notice ID -->
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">

            <p>
                <label for="quantity">Quantity</label>
                <input type="text" name="quantity" value="<?php echo $quantity; ?>" required>
            </p>

               <p>
                <label for="product_price">product price</label>
                <input type="text" name="product_price" value="<?php echo $product_price; ?>" required>
            </p>

            
            <p>
                <label for="total_price">total price</label>
                <input type="text" name="total_price" value="<?php echo $total_price; ?>" required>
            </p>

           <p>
    <label for="status">Status</label>
    <select name="status" required>
        <option value="Pending" <?php if ($status == 'Pending') echo 'selected'; ?>>Pending</option>
        <option value="Processing" <?php if ($status == 'Processing') echo 'selected'; ?>>Processing</option>
        <option value="Delivered" <?php if ($status == 'Delivered') echo 'selected'; ?>>Delivered</option>
    </select>
</p>


            <p>
                <label for="customer_name">Customer Name:</label>
                <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" required>
            </p>

             <p>
                <label for="address">Address</label>
                <input type="text" name="address" value="<?php echo $address; ?>" required>
            </p>

            <p>
                <label for="payment_method">Select Payment Method:</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="Credit Card" <?php if ($payment_method == 'Credit Card') echo 'selected'; ?>>Credit Card</option>
                    <option value="Bank Transfer" <?php if ($payment_method == 'Bank Transfer') echo 'selected'; ?>>Bank Transfer</option>
                    <option value="Cash on Delivery" <?php if ($payment_method == 'Cash on Delivery') echo 'selected'; ?>>Cash on Delivery</option>
                </select>
            </p>




            <p>
                <button type="submit" name="submit">Save Changes</button>
                
            </p>
            
        </form>
    </main>

</body>
</html>
