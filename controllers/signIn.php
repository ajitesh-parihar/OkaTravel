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
    $email = ($_POST["email"]);
    $password = ($_POST["psw"]);

    $query = "SELECT email, password, f_name, l_name FROM Users WHERE email = '$email'"; 

    $result = $conn->query($query); 

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['loggedin'] = true;
            $_SESSION['f_name'] = $row['f_name'];
            $_SESSION['l_name'] = $row['l_name'];

            header("Location: /views/Homepage.html");
            exit();
        } else {
            echo "Incorrect password."; 
        }
    } else { 
        echo "The email does not exist in the database."; 
    } 
}

$conn->close(); 
?>

