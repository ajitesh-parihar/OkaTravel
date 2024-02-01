<?php
session_start();

$serverName = "127.0.0.1";
$username = "OkaTravel";
$password = "123123";
$database = "OkaTravel";

$conn = mysqli_connect($serverName, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = ($_POST["fname"]);
    $lname = ($_POST["lname"]);
    $email = ($_POST["email"]);
    $password = ($_POST["psw"]);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users (Email, Password, f_name, l_name) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ssss", $email, $hashed_password, $fname, $lname);
    $result = mysqli_stmt_execute($stmt);

    if ($result === false) {
        die("Error: " . mysqli_error($conn));
    } else {
        header("Location: signIn.html");
        exit();
    }
}

mysqli_close($conn);
?>
