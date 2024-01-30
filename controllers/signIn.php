<?php
$serverName = "localhost";
$username = "DylHuit";
$password = "Dylan123";
$database = "okatravel";

// Establishes the connection
$conn = mysqli_connect($serverName, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get user input
    $email = ($_POST["email"]);
    $password = ($_POST["psw"]);

    // Prepare the query 
    $query = "SELECT email, password FROM users WHERE email = '$email'"; 
 
    // Execute the query 
    $result = $conn->query($query); 

    // Check if the email exists in the database 
    if ($result->num_rows > 0) { 
        echo "The email exists in the database."; 
    } else { 
        echo "The email does not exist in the database."; 
    } 
}
 
    // Close the connection 
    $conn->close(); 

?> 