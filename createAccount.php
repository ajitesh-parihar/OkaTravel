<?php
$serverName = "127.0.0.1";
$username = "OkaTravel";
$password = "123123";
$database = "OkaTravel";

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

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the database
    $sql = "INSERT INTO Users (Email, Password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "ss", $email, $hashed_password);
    $result = mysqli_stmt_execute($stmt);

    if ($result === false) {
        die("Error: " . mysqli_error($conn));
    } else {
        // Redirect to a confirmation page after successful registration
        header("Location: homepage.php");
        exit();
    }
}

mysqli_close($conn);