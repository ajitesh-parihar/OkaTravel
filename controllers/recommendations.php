<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: signIn.html");
    exit();
}

$serverName = "127.0.0.1";
$username = "OkaTravel";
$password = "123123";
$database = "OkaTravel";

$conn = mysqli_connect($serverName, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$userEmail = $_SESSION['email'];

$sqlUserPreferences = "SELECT * FROM UserAnswers WHERE user = '$userEmail'";
$resultUserPreferences = mysqli_query($conn, $sqlUserPreferences);

if (!$resultUserPreferences) {
    die("Error fetching user preferences: " . mysqli_error($conn));
}

$weights = [
    'trip_length' => 5,
    'budget' => 3,
    'accommodation_type' => 2,
    'activities' => 4,
    'weather_preference' => 3
];

$bestMatch = null;
$highestScore = -1;

while ($row = mysqli_fetch_assoc($resultUserPreferences)) {
    $userTripLength = $row['trip_length'];
    $userBudget = $row['budget'];
    $userAccommodationType = $row['accommodation_type'];
    $userActivities = $row['activities'];
    $userWeatherPreference = $row['weather_preference'];

    $sqlTrips = "SELECT * FROM Trips";
    $resultTrips = mysqli_query($conn, $sqlTrips);

    if (!$resultTrips) {
        die("Error fetching trip recommendations: " . mysqli_error($conn));
    }

    while ($trip = mysqli_fetch_assoc($resultTrips)) {
        $score = 0;

        $score += abs($trip['trip_length'] - $userTripLength) * $weights['trip_length'];
        $score += abs($trip['budget'] - $userBudget) * $weights['budget'];
        $score += ($trip['accommodation_type'] == $userAccommodationType) ? $weights['accommodation_type'] : 0;
        $score += similar_text($trip['activities'], $userActivities) * $weights['activities'];
        $score += ($trip['weather'] == $userWeatherPreference) ? $weights['weather'] : 0;

        if ($score > $highestScore) {
            $bestMatch = $trip;
            $highestScore = $score;
        }
    }
}

mysqli_close($conn);

if ($bestMatch) {
    echo "Here is the recommended trip:<br>";
    echo "Destination: " . $bestMatch['destination'] . "<br>";
    echo "Trip Length: " . $bestMatch['trip_length'] . " days<br>";
    echo "Budget: $" . $bestMatch['budget'] . "<br>";
    echo "Accommodation Type: " . $bestMatch['accommodation_type'] . "<br>";
    echo "Activities: " . $bestMatch['activities'] . "<br>";
    echo "Weather Preference: " . $bestMatch['weather'] . "<br>";
    echo "Picture URL: <img src='" . $bestMatch['picture_url'] . "'><br><br>";
} else {
    echo "Sorry, no matching trips found based on your preferences.";
}
