<?php session_start(); ?>
<?php require_once('../../inc/connection.php'); ?>
<?php require_once('../../inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}




	if (isset($_GET['order_id'])) {
		// getting the user information
		$user_id = mysqli_real_escape_string($connection, $_GET['order_id']);
		
        // DELETE query to remove the notice
        $query = "DELETE FROM orders WHERE order_id = {$user_id} LIMIT 1";
            

            $result = mysqli_query($connection,$query);

            if ($result){
                //user deleted
                header ('Location: orderhistory.php?msg=user_deleted');
            }else{
                header('Location: orderhistory.php?err=delete_failed');
            }
        
	} else {
        header('Loaction: notice.php');
    }

?>