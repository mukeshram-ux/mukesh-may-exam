
<?php
$host = "mysqlcnt";
$username = "root";
$password = "pwd@12345"; // your MySQL password
$database = "users";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
     
    

        

    
