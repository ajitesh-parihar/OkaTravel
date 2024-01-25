<?php
$serverName = "localhost";
$connectionOptions = array(
    "Database" => "okatravel",
    "Uid" => "DylHuit",
    "PWD" => "Dylan123"
);

// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
phpinfo();

// Check connection
if (!$conn) {
    die("Connection failed: " . sqlsrv_errors());
}

// Function to safely handle user input
function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get user input
    $email = sanitize_input($_POST["email"]);
    $password = sanitize_input($_POST["psw"]);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the database
    $sql = "INSERT INTO Users (Email, Password) VALUES (?, ?)";
    $params = array($email, $hashed_password);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        // Redirect to a confirmation page after successful registration
        header("Location: confirmation.php");
        exit();
    }
}

sqlsrv_close($conn);
