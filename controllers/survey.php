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

if (!isset($_SESSION['email'])) {
    die("User not logged in");
}

$user = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $trip_length = intval($_POST["trip_length"]);
    $budget = floatval($_POST["budget"]);
    $accommodation_type = mysqli_real_escape_string($conn, $_POST["accommodation_type"]);
    $activities = mysqli_real_escape_string($conn, $_POST["activities"]);
    $weather_preference = mysqli_real_escape_string($conn, $_POST["weather_preference"]);

    $sql = "INSERT INTO UserAnswers (user, trip_length, budget, accommodation_type, activities, weather_preference)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "sidssss", $user, $trip_length, $budget, $accommodation_type, $activities, $weather_preference);
    $result = mysqli_stmt_execute($stmt);

    if ($result === false) {
        die("Error: " . mysqli_error($conn));
    } else {
        header("Location: recommendations.php");
        exit();
    }
}

mysqli_close($conn);
