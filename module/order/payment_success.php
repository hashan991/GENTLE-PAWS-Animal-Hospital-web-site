<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //$order_id = mysqli_real_escape_string($connection, $_POST['order_id']);

    // Update order status to 'Paid'
    //$update_order = "UPDATE orders SET status = 'Paid' WHERE order_id = {$order_id}";
    //mysqli_query($connection, $update_order);
//}
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

<a href="../product/product.php">Continue Shopping</a>

</body>
</html>
