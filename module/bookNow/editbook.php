<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>

<?php 
// Checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

    $errors = array();
	$name = '';
	$number = '';
	$service = '';
	$type = '';
	$date = '';
	$time = '';

    if (isset($_GET['notice_id'])) {
    $notice_id = mysqli_real_escape_string($connection, $_GET['notice_id']);
    $query = "SELECT * FROM booking WHERE b_id = {$notice_id} LIMIT 1";

    $result_set = mysqli_query($connection, $query);

    if ($result_set && mysqli_num_rows($result_set) == 1) {
        $result = mysqli_fetch_assoc($result_set);
        $name = $result['name'];
        $number = $result['number'];
        $service = $result['service'];
        $type = $result['type'];
        $date = $result['date'];
        $time = $result['time'];
    } else {
        header('Location: book.php?err=notice_not_found');
    }
}

// Updating the notice
if (isset($_POST['submit'])) {
    $notice_id = $_POST['notice_id'];
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $number = mysqli_real_escape_string($connection, $_POST['number']);
    $service = mysqli_real_escape_string($connection, $_POST['service']);
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    $date = mysqli_real_escape_string($connection, $_POST['date']);
    $time = mysqli_real_escape_string($connection, $_POST['time']);

    // Check for errors
    if (empty($errors)) {
        $query = "UPDATE booking SET 
                    name = '{$name}', 
                    number = '{$number}', 
                    service = '{$service}', 
                    type = '{$type}' ,
                    date = '{$date}' ,
                    time = '{$time}' 
                  WHERE b_id = {$notice_id} LIMIT 1";

        $result = mysqli_query($connection, $query);

        if ($result) {
            header('Location: book.php?notice_modified=true');
        } else {
            $errors[] = 'Failed to modify the notice.';
        }
    }
}

?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit booking</title>
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
                    <li><a href="../product/product.php">PRODUCT</a></li>
                    <li><a href="../notice/notice.php">NOTICE</a></li>
                </ul>
            </nav>
            <div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?> | <a href="../../logout.php">Log Out</a></div>
        </div>
    </header>

    <main>
        <h1>Edit booking <span><a href="book.php"   class="action-btn"  >← bookig List</a></span></h1>

        <?php 
            if (!empty($errors)) {
                display_errors($errors);
            }
        ?>

        <form action="editbook.php" method="post" class="userform">
           
            <input type="hidden" name="notice_id" value="<?php echo $notice_id; ?>">


           <p>
				<label for="">full Name:</label>
				<input type="text" name="name" <?php echo 'value="' . $name . '"'; ?>>
			</p>

			<p>
				<label for="">contact number</label>
				<input type="text" name="number" <?php echo 'value="' . $number . '"'; ?>>
			</p>

			<p>
				<label for="">Type of Service </label>
				<input type="text" name="service" <?php echo 'value="' . $service . '"'; ?>>
			</p>

			
			<p>
				<label for="">pet type</label>
				<input type="text" name="type" <?php echo 'value="' . $type . '"'; ?>>
			</p>

			
			<p>
				<label for="">Date</label>
				<input type="text" name="date" <?php echo 'value="' . $date . '"'; ?>>
			</p>

			
			<p>
				<label for="">Time</label>
				<input type="text" name="time" <?php echo 'value="' . $time . '"'; ?>>
			</p>

			


            <p>
                <button type="submit" name="submit">Save Changes</button>
            </p>
        </form>
    </main>

</body>
</html>
