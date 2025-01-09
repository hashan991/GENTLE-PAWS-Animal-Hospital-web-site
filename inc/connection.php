<?php
     
     $dbhost = 'localhost';
     $dbuser = 'root';
     $dbpass = '';
     $dbname = 'userdb';


   $connection = mysqli_connect('localhost:3307','root','hasa11','userdb');


    if(mysqli_connect_errno()) {
        die('database connection failed'. mysqli_connect_error());
    }
    
    


?>