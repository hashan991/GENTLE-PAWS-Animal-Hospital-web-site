<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>

<?php 
// Checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

$errors = array();
$notice_id = '';
$title = '';
$description = '';
$category = '';
$audience = '';

// Fetching the notice details
if (isset($_GET['notice_id'])) {
    $notice_id = mysqli_real_escape_string($connection, $_GET['notice_id']);
    $query = "SELECT * FROM notice WHERE n_id = {$notice_id} LIMIT 1";

    $result_set = mysqli_query($connection, $query);

    if ($result_set && mysqli_num_rows($result_set) == 1) {
        $result = mysqli_fetch_assoc($result_set);
        $title = $result['title'];
        $description = $result['description'];
        $category = $result['category'];
        $audience = $result['audience'];
    } else {
        header('Location: notice.php?err=notice_not_found');
    }
}

// Updating the notice
if (isset($_POST['submit'])) {
    $notice_id = $_POST['notice_id'];
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $category = mysqli_real_escape_string($connection, $_POST['category']);
    $audience = mysqli_real_escape_string($connection, $_POST['audience']);

    // Check for errors
    if (empty($errors)) {
        $query = "UPDATE notice SET 
                    title = '{$title}', 
                    description = '{$description}', 
                    category = '{$category}', 
                    audience = '{$audience}' 
                  WHERE n_id = {$notice_id} LIMIT 1";

        $result = mysqli_query($connection, $query);

        if ($result) {
            header('Location: notice.php?notice_modified=true');
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
<?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 13): ?>
    <li><a href="../users/users.php">USERS</a></li>
<?php endif; ?>
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
        <h1>Edit Notice <span><a href="notice.php"class="action-btn">← Back to Notice List</a></span></h1>

        <?php 
            if (!empty($errors)) {
                display_errors($errors);
            }
        ?>

        <form action="editNotice.php" method="post" class="userform">
            <!-- Hidden Field for Notice ID -->
            <input type="hidden" name="notice_id" value="<?php echo $notice_id; ?>">

            <p>
                <label for="title">Notice Title:</label>
                <input type="text" name="title" value="<?php echo $title; ?>" required>
            </p>

            <p>
                <label for="description">Notice Description:</label>
                <input type="text" name="description" value="<?php echo $description; ?>" required>
            </p>

            <p>
                <label for="category">Notice Category:</label>
                <input type="text" name="category" value="<?php echo $category; ?>" required>
            </p>

            <p>
                <label for="audience">Target Audience:</label>
                <input type="text" name="audience" value="<?php echo $audience; ?>" required>
            </p>

            <p>
                <button type="submit" name="submit">Save Changes</button>
            </p>
        </form>
    </main>

</body>
</html>
